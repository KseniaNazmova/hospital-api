<?php

namespace App\Dto\Appointment\Responses;

use App\Dto\Appointment\AppointmentListFilterDto;
use App\Dto\Appointment\Repository\AppointmentDto;
use JetBrains\PhpStorm\ArrayShape;

class AppointmentListResponseDto
{
    public function __construct(
        #[ArrayShape([AppointmentDto::class])]
        public array $list,
        public AppointmentListFilterDto $filterDto,
    ) {
    }
}
