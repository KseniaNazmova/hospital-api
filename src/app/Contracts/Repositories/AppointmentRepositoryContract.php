<?php

namespace App\Contracts\Repositories;

use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use App\Enums\SortDirectionEnum;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

interface AppointmentRepositoryContract
{
    public function getById(UuidInterface $id): AppointmentDto;

    public function create(AppointmentRepositoryCreateDto $createDto): AppointmentDto;

    /** @return AppointmentDto[] */
    public function list(
        ?UuidInterface $doctorId = null,
        ?UuidInterface $patientId = null,
        ?DateTimeInterface $startFrom = null,
        ?DateTimeInterface $startTo = null,
        ?int $page = null,
        ?int $perPage = null,
        ?SortDirectionEnum $sort = SortDirectionEnum::DESC,
    ): array;
}
