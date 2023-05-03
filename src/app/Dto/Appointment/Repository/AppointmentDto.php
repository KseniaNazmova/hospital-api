<?php

namespace App\Dto\Appointment\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Spatie\LaravelData\Data;

class AppointmentDto extends Data
{
    public function __construct(
        public UuidInterface $id,
        public UuidInterface $doctorId,
        public UuidInterface $patientId,
        public DateTimeInterface $startAt,
        public DateTimeInterface $finishAt,
        public DateTimeInterface $createdAt,
        public DateTimeInterface $updatedAt,
    ) {
    }
}
