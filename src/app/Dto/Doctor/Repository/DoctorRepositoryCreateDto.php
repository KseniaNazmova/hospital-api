<?php

namespace App\Dto\Doctor\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class DoctorRepositoryCreateDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $phone,
        public DateTimeInterface $workdayStart,
        public DateTimeInterface $workdayEnd,
        public ?UuidInterface $id = null,
        public ?DateTimeInterface $birthDate = null,
        public ?string $middleName = null,
        public ?string $email = null,
    ) {
    }
}
