<?php

namespace Database\Factories;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Dto\Patient\Repository\PatientDto;
use App\Dto\Patient\Repository\PatientRepositoryCreateDto;
use Faker\Factory;

class PatientFactory
{
    public static function create(): PatientDto
    {
        /** @var PatientRepositoryContract $repository */
        $repository = app(PatientRepositoryContract::class);

        return $repository->create(self::generatePatientRepositoryCreateDto());
    }

    public static function generatePatientRepositoryCreateDto(): PatientRepositoryCreateDto
    {
        $faker = Factory::create();

        return new PatientRepositoryCreateDto(
            $faker->numerify('###########'),
            null,
            $faker->firstName,
            $faker->lastName,
            $faker->firstNameMale,
            $faker->dateTimeBetween('-80 years', '-18 years'),
            $faker->address,
        );
    }
}
