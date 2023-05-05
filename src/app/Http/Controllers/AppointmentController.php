<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceContract;
use App\Transformers\AppointmentTransformer;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AppointmentController extends BaseController
{
    use ValidatesRequests;

    public function __construct(
        private readonly AppointmentServiceContract $appointmentService,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $requestData = $request->toArray();
        $createDto = AppointmentTransformer::getAppointmentCreateRequestDtoFromArrayRequest($requestData);

        $patient = $this->appointmentService->create($createDto);

        return response()->json([
            'status' => 'success',
            'message' => 'Appointment created successfully',
            'appointment' => $patient,
        ], 200, ['Content-Type => application/json']);
    }

    public function list(Request $request): JsonResponse
    {
        $requestData = $request->toArray();
        $listRequestDto = AppointmentTransformer::getAppointmentListRequestDtoFromArrayRequest($requestData);

        $result = $this->appointmentService->list($listRequestDto);

        return response()->json([
            'status' => 'success',
            'message' => 'Appointments Page #' . $result->filterDto->page,
            'appointments' => $result->list,
            'filter' => $result->filterDto,
        ], 200, ['Content-Type => application/json']);
    }
}
