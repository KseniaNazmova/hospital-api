<?php

namespace App\Dto\Doctor\Repository;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Spatie\LaravelData\Data;

class DoctorDto extends Data
{
    public function __construct(
        public UuidInterface $id,
        public string $firstName,
        public string $lastName,
        public string $phone,
        public DateTimeInterface $workdayStart,
        public DateTimeInterface $workdayEnd,
        public ?DateTimeInterface $birthDate,
        public ?string $middleName,
        public ?string $email,
        public DateTimeInterface $createdAt,
        public DateTimeInterface $updatedAt,
    ) {
    }
}
