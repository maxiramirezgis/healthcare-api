<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Clinic\Domain\DataTransferObjects\ClinicDto;

class UpsertClinicRequest extends FormRequest
{
    public const string NAME = 'name';

    public const string ADDRESS = 'address';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:255'],
            self::ADDRESS => ['required', 'string', 'max:255'],
        ];
    }

    public function toDto(): ClinicDto
    {
        return new ClinicDto(
            name: $this->string(self::NAME)->toString(),
            address: $this->string(self::ADDRESS)->toString(),
        );
    }
}
