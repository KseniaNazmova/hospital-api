<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateAppointmentCreateRequest
{
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'doctorId' => 'required|uuid',
            'patientId' => 'required|uuid',
            'startAt' => 'required|date_format:' . DATE_ATOM,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return $next($request);
    }
}
