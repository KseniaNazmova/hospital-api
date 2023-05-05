<?php

namespace Database\Factories;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use DateInterval;
use DateTime;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class AppointmentFactory extends AbstractFactory
{
    public static function create(array $params = []): AppointmentDto
    {
        /** @var AppointmentRepositoryContract $repository */
        $repository = app(AppointmentRepositoryContract::class);

        return $repository->create(self::generateAppointmentRepositoryCreateDto($params));
    }

    public static function generateAppointmentDto(array $params = []): AppointmentDto
    {
        $faker = Factory::create();
        $startAt = $faker->dateTime;

        $fakedParams = [
            "id" => Uuid::uuid4(),
            "doctorId" => Uuid::uuid4(),
            "patientId" => Uuid::uuid4(),
            "startAt" => $startAt,
            "finishAt" => $startAt->modify("+" . env("APPOINTMENT_LENGTH_SECONDS", 1800) . " seconds"),
            "createdAt" => new DateTime(),
            "updatedAt" => new DateTime(),
        ];

        return AppointmentDto::from(
            self::enrichParams($fakedParams, $params)
        );
    }

    public static function generateAppointmentRepositoryCreateDto(array $params = []): AppointmentRepositoryCreateDto
    {
        $faker = Factory::create();

        $startAt = $faker->dateTimeThisMonth;

        $fakedParams = [
            "doctorId" => DoctorFactory::create()->id,
            "patientId" => PatientFactory::create()->id,
            "startAt" => $startAt,
            "finishAt" => $startAt->add(new DateInterval('PT30M')),
            "createdAt" => new DateTime(),
            "updatedAt" => new DateTime(),
        ];

        return AppointmentRepositoryCreateDto::from(
            self::enrichParams($fakedParams, $params)
        );
    }
}
