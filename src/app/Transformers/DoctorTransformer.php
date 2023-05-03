<?php

namespace App\Transformers;

use App\Dto\Doctor\Repository\DoctorDto;
use App\Entities\Doctor\Doctor;

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

}
