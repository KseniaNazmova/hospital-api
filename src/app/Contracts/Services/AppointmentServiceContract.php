<?php

namespace App\Contracts\Services;

use App\Dto\Appointment\AppointmentListFilterDto;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Requests\AppointmentCreateRequestDto;
use App\Dto\Appointment\Responses\AppointmentListResponseDto;

interface AppointmentServiceContract
{
    public function create(AppointmentCreateRequestDto $request): AppointmentDto;

    public function list(AppointmentListFilterDto $listRequestDto): AppointmentListResponseDto;
}
