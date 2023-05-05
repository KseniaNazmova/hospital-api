<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Transformers\DoctorTransformer;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class DoctorController extends BaseController
{
    use ValidatesRequests;

    public function __construct(
        private readonly DoctorRepositoryContract $doctorRepository,
    ) {
    }

    public function create(Request $request)
    {
        $requestData = $request->toArray();
        $createDto = DoctorTransformer::getDoctorRepositoryCreateDtoFromArrayRequest($requestData);

        $doctor = $this->doctorRepository->create($createDto);

        return response()->json([
            'status' => 'success',
            'message' => 'Doctor created successfully',
            'doctor' => $doctor,
        ], 200, ['Content-Type => application/json']);
    }
}
