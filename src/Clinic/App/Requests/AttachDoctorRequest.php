<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Lightit\Doctor\Domain\Models\Doctor;

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
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $ids = $this->array(self::DOCTOR_IDS);

            if (empty($ids)) {
                return;
            }

            $existingCount = Doctor::query()->whereIn('id', $ids)->count();

            if ($existingCount !== count($ids)) {
                $validator->errors()->add(
                    self::DOCTOR_IDS,
                    'One or more doctor IDs do not exist.'
                );
            }
        });
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
