<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachDoctorRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => [
                'required',
                'integer',
                Rule::exists('doctors', 'id'),
            ],
        ];
    }

    public function getDoctorId(): int
    {
        return $this->integer(self::DOCTOR_ID);
    }
}
