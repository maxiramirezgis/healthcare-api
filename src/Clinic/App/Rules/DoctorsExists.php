<?php

namespace Lightit\Clinic\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lightit\Doctor\Domain\Models\Doctor;

class DoctorsExists implements ValidationRule
{
    /**
     * @param array<int> $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existingCount = Doctor::query()->whereIn('id', $value)->count();

        if ($existingCount !== count($value)) {
            $fail('One or more doctor IDs do not exist.');
        }
    }
}
