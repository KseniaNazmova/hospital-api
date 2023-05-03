<?php

namespace App\Transformers;

use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Patient\Repository\PatientDto;
use App\Entities\Doctor\Doctor;
use App\Entities\Patient\Patient;

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
}
