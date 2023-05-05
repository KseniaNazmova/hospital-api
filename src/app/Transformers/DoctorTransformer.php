<?php

namespace App\Transformers;

use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Doctor\Repository\DoctorRepositoryCreateDto;
use App\Entities\Doctor\Doctor;
use DateTime;
use Illuminate\Support\Arr;

class DoctorTransformer
{
    public static function dtoFromEntity(Doctor $entity): DoctorDto
    {
        return new DoctorDto(
            $entity->getId(),
            $entity->getFirstName(),
            $entity->getLastName(),
            $entity->getPhone(),
            $entity->getWorkdayStart(),
            $entity->getWorkdayEnd(),
            $entity->getBirthDate(),
            $entity->getMiddleName(),
            $entity->getEmail(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
        );
    }

    public static function getDoctorRepositoryCreateDtoFromArrayRequest(array $request): DoctorRepositoryCreateDto
    {
        return new DoctorRepositoryCreateDto(
            firstName: $request['firstName'],
            lastName: $request['lastName'],
            phone: $request['phone'],
            workdayStart: DateTime::createFromFormat("H:i", $request['workdayStart']),
            workdayEnd: DateTime::createFromFormat("H:i", $request['workdayEnd']),
            birthDate: !is_null(Arr::get($request, 'birthDate'))
                ? DateTime::createFromFormat(DATE_ATOM, $request['birthDate'])
                : null,
            middleName: Arr::get($request, 'middleName'),
            email: Arr::get($request, 'email'),
        );
    }
}
