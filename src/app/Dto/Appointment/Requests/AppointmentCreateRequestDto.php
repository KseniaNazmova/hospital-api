<?php

namespace App\Dto\Appointment\Requests;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class AppointmentCreateRequestDto
{
    public function __construct(
        public UuidInterface $doctorId,
        public UuidInterface $patientId,
        public DateTimeInterface $startAt,
    ) {
    }
}
