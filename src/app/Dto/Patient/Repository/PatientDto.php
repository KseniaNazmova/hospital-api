<?php

namespace App\Dto\Patient\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Spatie\LaravelData\Data;

class PatientDto extends Data
{
    public function __construct(
        public UuidInterface $id,
        public string $snils,
        public DateTimeInterface $createdAt,
        public DateTimeInterface $updatedAt,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $middleName = null,
        public ?DateTimeInterface $birthDate = null,
        public ?string $residence = null,
    ) {
    }
}
