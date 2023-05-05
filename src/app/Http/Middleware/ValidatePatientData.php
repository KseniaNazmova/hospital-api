<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\ErrorCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatePatientData
{
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all() ,[
            'firstName' => 'nullable|string|max:255|required_without_all:lastName,middleName',
            'lastName' => 'nullable|string|max:255|required_without_all:firstName,middleName',
            'middleName' => 'nullable|string|max:255|required_without_all:firstName,lastName',
            'snils' => 'required|string|max:255',
            'residence' => 'nullable|string|max:255',
            'birthDate' => 'nullable|date_format:' . DATE_ATOM,
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return $next($request);
    }
}
