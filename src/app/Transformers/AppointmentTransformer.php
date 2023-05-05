<?php

namespace App\Transformers;

use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;
use App\Entities\Appointment\Appointment;
use DateTime;
use Ramsey\Uuid\Uuid;

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

    public static function getAppointmentCreateRequestDtoFromArrayRequest(
        array $request
    ): AppointmentCreateRequestDto {
        return new AppointmentCreateRequestDto(
            Uuid::fromString($request['doctorId']),
            Uuid::fromString($request['patientId']),
            DateTime::createFromFormat(DATE_ATOM, $request['startAt']),
        );
    }
}
