<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateAppointmentListRequest
{
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'doctorFullName' => 'nullable|string|max:767',
            'patientFullName' => 'nullable|string|max:767',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:start_date',
            'sortDirection' => 'nullable|in:asc,desc',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return $next($request);
    }
}
