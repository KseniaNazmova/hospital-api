<?php

namespace App\Services\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Contracts\Repositories\PatientRepositoryContract;
use App\Contracts\Services\AppointmentServiceContract;
use App\Dto\Appointment\AppointmentListFilterDto;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;
use App\Dto\Appointment\Responses\AppointmentListResponseDto;
use App\Enums\AppointmentListSortByEnum;
use App\Enums\SortDirectionEnum;
use App\Exceptions\ApiException;
use App\Exceptions\ErrorCodes;
use Carbon\Carbon;

class AppointmentService implements AppointmentServiceContract
{
    public function __construct(
        private readonly AppointmentRepositoryContract $appointmentRepository,
        private readonly PatientRepositoryContract $patientRepository,
        private readonly DoctorRepositoryContract $doctorRepository,
    ) {
    }

    public function create(AppointmentCreateRequestDto $request): AppointmentDto
    {
        // дата окончания новой записи
        $finishAt = Carbon::parse($request->startAt)
            ->modify("+" . env("APPOINTMENT_LENGTH_SECONDS", 1800) . " seconds");

        // Получаем доктора
        $doctor = $this->doctorRepository->getById($request->doctorId);

        // Убедимся что пациент существует
        $this->patientRepository->getById($request->patientId);

        // убедимся что запись не выходит за рамки дня врача
        if ($request->startAt->format('H:i') < $doctor->workdayStart->format('H:i')) {
            throw new ApiException("Запись выходит за рамки дня работы врача", ErrorCodes::APPOINTMENT_NOT_AVAILABLE);
        }

        // убедимся что запись не выходит за рамки дня врача
        if ($finishAt->format('H:i') > $doctor->workdayEnd->format('H:i')) {
            throw new ApiException("Запись выходит за рамки дня работы врача", ErrorCodes::APPOINTMENT_NOT_AVAILABLE);
        }

        /*
         * Получим записи (дата начала у искомых это +/- 30 мин от даты начала новой записи)
         */
        $list = $this->appointmentRepository->list(
            doctorId: $request->doctorId,
            startFrom: Carbon::parse($request->startAt)
                ->modify("-" . env("APPOINTMENT_LENGTH_SECONDS", 1800) . " seconds"),
            startTo: $finishAt
        );

        foreach ($list as $appointmentDtoInList) {
            // Дата начала у искомых записей не между датами начала и окончаниями из запроса
            if ($appointmentDtoInList->startAt > $request->startAt && $appointmentDtoInList->startAt < $finishAt) {
                throw new ApiException(
                    "Запись пересекается с другими записями.",
                    ErrorCodes::APPOINTMENT_NOT_AVAILABLE
                );
            }

            // Дата окончания у искомых записей не между датами начала и окончаниями из запроса
            if ($appointmentDtoInList->finishAt > $request->startAt && $appointmentDtoInList->finishAt < $finishAt) {
                throw new ApiException(
                    "Запись пересекается с другими записями.",
                    ErrorCodes::APPOINTMENT_NOT_AVAILABLE

                );
            }
        }

        // Если пересечений нет, то создаем запись
        return $this->appointmentRepository->create(
            new AppointmentRepositoryCreateDto(
                doctorId: $request->doctorId,
                patientId: $request->patientId,
                startAt: $request->startAt,
                finishAt: $finishAt,
            )
        );
    }

    public function list(AppointmentListFilterDto $listRequestDto): AppointmentListResponseDto
    {
        $filterDto = $this->getFilterFromRequest($listRequestDto);

        $doctorId = !is_null($listRequestDto->doctorFullName) ?
            $this->doctorRepository->getByFullName($listRequestDto->doctorFullName)?->id
            : null;

        $patientId = !is_null($listRequestDto->patientFullName) ?
            $this->patientRepository->getByFullName($listRequestDto->patientFullName)?->id
            : null;

        $list = $this->appointmentRepository->list(
            $doctorId,
            $patientId,
            $filterDto->startDate,
            $filterDto->endDate,
            $filterDto->page,
            $filterDto->perPage,
            $filterDto->sortDirection,
        );

        return new AppointmentListResponseDto(
            $list,
            $filterDto,
        );
    }

    private function getFilterFromRequest(AppointmentListFilterDto $listRequestDto): AppointmentListFilterDto
    {
        $filterDto = AppointmentListFilterDto::from($listRequestDto);

        if (is_null($filterDto->sortDirection)) {
            $filterDto->sortDirection = SortDirectionEnum::DESC;
        }

        if (is_null($filterDto->page)) {
            $filterDto->page = 1;
        }

        if (is_null($filterDto->perPage)) {
            $filterDto->perPage = env("PER_PAGE_DEFAULT", 10);
        }

        return $filterDto;
    }
}
