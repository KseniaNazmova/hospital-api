<?php

namespace App\Transformers;

use App\Dto\Appointment\Repository\AppointmentDto;
use App\Entities\Appointment\Appointment;

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
}
