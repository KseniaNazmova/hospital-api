<?php

namespace App\Contracts\Repositories;

use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use Ramsey\Uuid\UuidInterface;

interface AppointmentRepositoryContract
{
    public function getById(UuidInterface $id): AppointmentDto;

    public function create(AppointmentRepositoryCreateDto $createDto): AppointmentDto;
}
