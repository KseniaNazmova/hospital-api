<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/patients/create', [PatientController::class, 'create'])->middleware('validatePatientData');
Route::post('/doctor/create', [\App\Http\Controllers\DoctorController::class, 'create'])->middleware('validateDoctorData');
Route::post('/appointment/create', [AppointmentController::class, 'create'])->middleware('validateAppointmentCreateRequest');
Route::post('/appointment/list', [AppointmentController::class, 'list'])->middleware('validateAppointmentListRequest');
