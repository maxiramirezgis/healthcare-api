<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertDoctorRequest extends FormRequest
{
    public const string NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:255'],
        ];
    }

    public function getDoctorName(): string
    {
        return $this->string(self::NAME)->toString();
    }
}
