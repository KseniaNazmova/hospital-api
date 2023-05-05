<?php

namespace tests\Unit\Repositories\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Contracts\Repositories\PatientRepositoryContract;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;
use App\Services\Appointment\AppointmentService;
use Carbon\Carbon;
use Database\Factories\AppointmentFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    private AppointmentRepositoryContract $appointmentRepository;
    private PatientRepositoryContract $patientRepository;
    private DoctorRepositoryContract $doctorRepository;
    private AppointmentService $appointmentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->appointmentRepository = Mockery::mock(AppointmentRepositoryContract::class);
        $this->patientRepository = Mockery::mock(PatientRepositoryContract::class);
        $this->doctorRepository = Mockery::mock(DoctorRepositoryContract::class);

        $this->appointmentService = new AppointmentService(
            $this->appointmentRepository,
            $this->patientRepository,
            $this->doctorRepository,
        );
    }

    public function testCreate()
    {
        $startAt = Carbon::now()->setHour(8)->setMinute(0)->setSecond(0);

        $request = new AppointmentCreateRequestDto(
            doctorId: Uuid::uuid4(),
            patientId: Uuid::uuid4(),
            startAt: $startAt,
        );

        // Устанавливаем время начала рабочего дня врача
        $doctor = DoctorFactory::generateDoctorDto();
        $doctor->id = $request->doctorId;
        $doctor->workdayStart = $startAt->copy()->subHour();
        $doctor->workdayEnd = $startAt->copy()->addHours(2);

        // Настройка возвращаемого списка записей без пересечений
        $this->appointmentRepository->shouldReceive('list')
            ->once()
            ->andReturn([
                new AppointmentDto(
                    Uuid::uuid4(),
                    $request->doctorId,
                    $request->patientId,
                    $startAt->copy()->subDay()->subHour(),
                    $startAt->copy()->subDay()->addHour(),
                    Carbon::now(),
                    Carbon::now(),
                )
            ]);

        // Настройка возвращения доктора репозиторием
        $this->doctorRepository->shouldReceive('getById')
            ->once()
            ->with($request->doctorId)
            ->andReturn($doctor);

        // Настройка возвращения пациента репозиторием
        $patient = PatientFactory::generatePatientDto();
        $patient->id = $request->patientId;

        $this->patientRepository->shouldReceive('getById')
            ->once()
            ->with($request->patientId)
            ->andReturn($patient);

        // Настройка создания записи
        $this->appointmentRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::type(AppointmentRepositoryCreateDto::class))
            ->andReturn(AppointmentFactory::generateAppointmentDto());

        // Вызов метода
        $result = $this->appointmentService->create($request);

        // Проверка, что результатом является объект AppointmentDto
        $this->assertInstanceOf(AppointmentDto::class, $result);
    }
}
