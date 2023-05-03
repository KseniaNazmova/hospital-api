<?php

namespace Database\Factories;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Doctor\Repository\DoctorRepositoryCreateDto;
use Faker\Factory;

class DoctorFactory
{
    public static function create(): DoctorDto
    {
        /** @var DoctorRepositoryContract $repository */
        $repository = app(DoctorRepositoryContract::class);

        return $repository->create(self::generateDoctorRepositoryCreateDto());
    }

    public static function generateDoctorRepositoryCreateDto(): DoctorRepositoryCreateDto
    {
        $faker = Factory::create();

        $id = null;
        $firstName = $faker->firstName();
        $lastName = $faker->lastName();
        $phone = $faker->phoneNumber();
        $workdayStart = $faker->dateTime();
        $workdayEnd = $faker->dateTime();
        $birthDate = $faker->optional()->dateTime();
        $middleName = $faker->optional()->firstName();
        $email = $faker->optional()->email();

        return new DoctorRepositoryCreateDto(
            $firstName,
            $lastName,
            $phone,
            $workdayStart,
            $workdayEnd,
            $id,
            $birthDate,
            $middleName,
            $email
        );
    }
}
