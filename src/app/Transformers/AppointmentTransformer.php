<?php

namespace App\Transformers;

use App\Dto\Appointment\AppointmentListFilterDto;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;
use App\Entities\Appointment\Appointment;
use App\Enums\AppointmentListSortByEnum;
use App\Enums\SortDirectionEnum;
use DateTime;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class AppointmentTransformer
{
    public static function dtoFromEntity(Appointment $entity): AppointmentDto
    {
        return new AppointmentDto(
            $entity->getId(),
            $entity->getDoctor()->getId(),
            $entity->getPatient()->getId(),
            $entity->getStartAt(),
            $entity->getFinishAt(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
        );
    }

    public static function getAppointmentCreateRequestDtoFromArrayRequest(
        array $request
    ): AppointmentCreateRequestDto {
        return new AppointmentCreateRequestDto(
            Uuid::fromString($request['doctorId']),
            Uuid::fromString($request['patientId']),
            DateTime::createFromFormat(DATE_ATOM, $request['startAt']),
        );
    }

    public static function getAppointmentListRequestDtoFromArrayRequest(array $requestData): AppointmentListFilterDto
    {
        return new AppointmentListFilterDto(
            doctorFullName: Arr::get($requestData, 'doctorFullName'),
            patientFullName: Arr::get($requestData, 'patientFullName'),
            startDate: isset($requestData['startDate'])
                ? new DateTime($requestData['startDate'])
                : null,
            endDate: isset($requestData['endDate'])
                ? new DateTime($requestData['endDate'])
                : null,
            sortDirection: isset($requestData['sortDirection'])
                ? SortDirectionEnum::from($requestData['sortDirection'])
                : null,
            page: $requestData['page'] ?? null,
            perPage: $requestData['perPage'] ?? null,
        );
    }
}
