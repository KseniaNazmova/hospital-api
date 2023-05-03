<?php

namespace App\Contracts\Repositories;

use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Doctor\Repository\DoctorRepositoryCreateDto;
use Ramsey\Uuid\UuidInterface;

interface DoctorRepositoryContract
{
    public function getById(UuidInterface $id): DoctorDto;

    public function create(DoctorRepositoryCreateDto $createDto): DoctorDto;
}


