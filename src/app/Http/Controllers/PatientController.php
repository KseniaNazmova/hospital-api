<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Transformers\PatientTransformer;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PatientController extends BaseController
{
    use ValidatesRequests;

    public function __construct(
        private readonly PatientRepositoryContract $patientRepository,
    ) {
    }

    public function create(Request $request)
    {
        $requestData = $request->toArray();
        $createDto = PatientTransformer::getPatientRepositoryCreateDtoDtoFromArrayRequest($requestData);

        $patient = $this->patientRepository->create($createDto);

        return response()->json([
            'status' => 'success',
            'message' => 'Patient created successfully',
            'patient' => $patient,
        ], 200, ['Content-Type => application/json']);
    }
}
