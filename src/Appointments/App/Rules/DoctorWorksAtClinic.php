<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class DoctorWorksAtClinic implements ValidationRule
{
    public function __construct(
        private readonly int $clinicId,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $doctorId = $value;

        $exists = DB::table('clinic_doctor')
            ->where('clinic_id', $this->clinicId)
            ->where('doctor_id', $doctorId)
            ->exists();

        if (! $exists) {
            $fail('The selected doctor does not work at the selected clinic.');
        }
    }
}
