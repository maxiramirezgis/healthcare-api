<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;

class UpsertAppointmentRequest extends FormRequest
{
    public const string CLINIC_ID = 'clinic_id';

    public const string DOCTOR_ID = 'doctor_id';

    public const string USER_ID = 'user_id';

    public const string STARTS_AT = 'starts_at';

    public const string ENDS_AT = 'ends_at';

    public function rules(): array
    {
        return [
            self::CLINIC_ID => ['required', 'integer', Rule::exists('clinics', 'id')],
            self::DOCTOR_ID => ['required', 'integer', Rule::exists('doctors', 'id')],
            self::USER_ID => ['required', 'integer', Rule::exists('users', 'id')],
            self::STARTS_AT => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            self::ENDS_AT => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:starts_at'],
        ];
    }

    public function toDto(): AppointmentDto
    {
        /** @var CarbonImmutable $startsAt */
        $startsAt = $this->date(self::STARTS_AT);

        /** @var CarbonImmutable $endsAt */
        $endsAt = $this->date(self::ENDS_AT);

        return new AppointmentDto(
            clinicId: $this->integer(self::CLINIC_ID),
            doctorId: $this->integer(self::DOCTOR_ID),
            userId: $this->integer(self::USER_ID),
            startsAt: $startsAt->toImmutable(),
            endsAt: $endsAt->toImmutable(),
        );
    }
}
