<?php

namespace App\Http\Controllers;

use app\Contracts\Services\AppointmentServiceContract;
use App\Transformers\AppointmentTransformer;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AppointmentController extends BaseController
{
    use ValidatesRequests;

    public function __construct(
        private readonly AppointmentServiceContract $appointmentService,
    ) {
    }

    public function create(Request $request)
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
}
