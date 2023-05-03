<?php

namespace App\Contracts\Repositories;

use App\Dto\Patient\Repository\PatientDto;
use App\Dto\Patient\Repository\PatientRepositoryCreateDto;
use Ramsey\Uuid\UuidInterface;

interface PatientRepositoryContract
{
    public function getById(UuidInterface $id): PatientDto;

    public function create(PatientRepositoryCreateDto $createDto): PatientDto;
}
