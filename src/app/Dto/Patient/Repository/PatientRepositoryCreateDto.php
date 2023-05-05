<?php

namespace App\Dto\Patient\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Spatie\LaravelData\Data;

class PatientRepositoryCreateDto extends Data
{
    public function __construct(
        public string $snils,
        public ?UuidInterface $id = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $middleName = null,
        public ?DateTimeInterface $birthDate = null,
        public ?string $residence = null,
    ) {
    }
}
