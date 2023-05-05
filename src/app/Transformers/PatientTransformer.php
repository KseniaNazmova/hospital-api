<?php

namespace App\Transformers;

use App\Dto\Patient\Repository\PatientDto;
use App\Dto\Patient\Repository\PatientRepositoryCreateDto;
use App\Entities\Patient\Patient;
use DateTime;
use Illuminate\Support\Arr;

class PatientTransformer
{
    public static function dtoFromEntity(Patient $entity): PatientDto
    {
        return new PatientDto(
            $entity->getId(),
            $entity->getSnils(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
            $entity->getFirstName(),
            $entity->getLastName(),
            $entity->getMiddleName(),
            $entity->getBirthDate(),
            $entity->getResidence(),
        );
    }

    public static function getPatientRepositoryCreateDtoFromArrayRequest(
        array $request
    ): PatientRepositoryCreateDto {
        return new PatientRepositoryCreateDto(
            Arr::get($request, 'snils'),
            null,
            Arr::get($request, 'firstName'),
            Arr::get($request, 'lastName'),
            Arr::get($request, 'middleName'),
            !is_null(Arr::get($request, 'birthDate'))
                ? DateTime::createFromFormat(DATE_ATOM, Arr::get($request, 'birthDate'))
                : null,
            Arr::get($request, 'residence'),
        );
    }
}
