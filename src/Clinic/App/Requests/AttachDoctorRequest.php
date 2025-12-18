<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Clinic\App\Rules\DoctorsExists;

class AttachDoctorRequest extends FormRequest
{
    public const string DOCTOR_IDS = 'doctor_ids';

    public function rules(): array
    {
        return [
            self::DOCTOR_IDS => [
                'required',
                'array',
                new DoctorsExists(),
            ],
            self::DOCTOR_IDS . '.*' => [
                'integer',
            ],
        ];
    }

    /**
     * @return array<int>
     */
    public function getDoctorIds(): array
    {
        /** @var array<int> */
        return $this->array(self::DOCTOR_IDS);
    }
}
