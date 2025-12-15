<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Doctor\Domain\DataTransferObjects\DoctorDTO;

class UpsertDoctorRequest extends FormRequest
{
    public const string NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:255'],
        ];
    }

    public function toDto(): DoctorDTO
    {
        return new DoctorDTO(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
