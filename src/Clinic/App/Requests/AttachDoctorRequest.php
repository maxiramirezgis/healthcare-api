<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachDoctorRequest extends FormRequest
{
    public const string DOCTOR_IDS = 'doctor_ids';

    public function rules(): array
    {
        return [
            self::DOCTOR_IDS => [
                'required',
                'array',
            ],
            self::DOCTOR_IDS . '.*' => [
                'integer',
                Rule::exists('doctors', 'id'),
            ],
        ];
    }

    /**
     * @return array<int>
     */
    public function getDoctorIds(): array
    {
        /** @var array<int> */
        return $this->input(self::DOCTOR_IDS);
    }
}
