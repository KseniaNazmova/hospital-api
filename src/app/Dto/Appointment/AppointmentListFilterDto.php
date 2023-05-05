<?php

namespace App\Dto\Appointment;

use App\Enums\SortDirectionEnum;
use DateTimeInterface;
use Spatie\LaravelData\Data;

class AppointmentListFilterDto extends Data
{
    public function __construct(
        public ?string $doctorFullName = null,
        public ?string $patientFullName = null,
        public ?DateTimeInterface $startDate = null,
        public ?DateTimeInterface $endDate = null,
        public ?SortDirectionEnum $sortDirection = null,
        public ?int $page = null,
        public ?int $perPage = null,
    ) {
    }
}
