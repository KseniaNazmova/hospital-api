<?php

namespace App\Exceptions;

class ErrorCodes
{
    public const DOCTOR_NOT_FOUND = -23;
    public const PATIENT_NOT_FOUND = -24;
    public const APPOINTMENT_NOT_FOUND = -25;
    public const AT_LEAST_ONE_OF_THE_NAME_FIELDS_MUST_BE_PRESENT = -26;
    public const APPOINTMENT_NOT_AVAILABLE = -27;
}
