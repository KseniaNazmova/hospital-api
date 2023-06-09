<?php

namespace App\Dto\Appointment\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Spatie\LaravelData\Data;

class AppointmentRepositoryCreateDto extends Data
{
    public function __construct(
        public UuidInterface $doctorId,
        public UuidInterface $patientId,
        public DateTimeInterface $startAt,
        public DateTimeInterface $finishAt,
        public ?UuidInterface $id = null,
    ) {
    }
}
