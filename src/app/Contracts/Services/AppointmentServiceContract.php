<?php

namespace App\Contracts\Services;

use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;

interface AppointmentServiceContract
{
    public function create(AppointmentCreateRequestDto $request): AppointmentDto;
}
