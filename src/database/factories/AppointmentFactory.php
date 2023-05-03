<?php

namespace Database\Factories;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use DateInterval;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class AppointmentFactory
{
    public static function create(): AppointmentDto
    {
        /** @var AppointmentRepositoryContract $repository */
        $repository = app(AppointmentRepositoryContract::class);

        return $repository->create(self::generateAppointmentRepositoryCreateDto());
    }

    public static function generateAppointmentRepositoryCreateDto(): AppointmentRepositoryCreateDto
    {
        $faker = Factory::create();

        $startAt = $faker->dateTimeThisMonth;

        return new AppointmentRepositoryCreateDto(
            DoctorFactory::create()->id,
            PatientFactory::create()->id,
            $startAt,
            $startAt->add(new DateInterval('PT30M')),
            Uuid::uuid4(),
        );
    }
}
