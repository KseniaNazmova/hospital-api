<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateDoctorData
{
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'workdayStart' => 'required|date_format:H:i',
            'workdayEnd' => 'required|date_format:H:i',
            'birthDate' => 'nullable|date_format:' . DATE_ATOM,
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return $next($request);
    }
}
