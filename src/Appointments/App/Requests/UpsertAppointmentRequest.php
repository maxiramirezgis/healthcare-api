<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\App\Rules\DoctorHasNoOverlappingAppointments;
use Lightit\Appointments\App\Rules\DoctorWorksAtClinic;
use Lightit\Appointments\App\Rules\UserHasNoOverlappingAppointments;
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
        $clinicId = $this->integer(self::CLINIC_ID);
        $doctorId = $this->integer(self::DOCTOR_ID);
        $userId = $this->integer(self::USER_ID);
        $startsAt = $this->string(self::STARTS_AT)->toString();
        $endsAt = $this->string(self::ENDS_AT)->toString();
        $appointmentId = $this->route('appointment');

        return [
            self::CLINIC_ID => ['required', 'integer', Rule::exists('clinics', 'id')],
            self::DOCTOR_ID => [
                'required',
                'integer',
                Rule::exists('doctors', 'id'),
                new DoctorWorksAtClinic($clinicId),
                new DoctorHasNoOverlappingAppointments(
                    $doctorId,
                    $startsAt,
                    $endsAt,
                    $appointmentId
                ),
            ],
            self::USER_ID => [
                'required',
                'integer',
                Rule::exists('users', 'id'),
                new UserHasNoOverlappingAppointments(
                    $userId,
                    $startsAt,
                    $endsAt,
                    $appointmentId
                ),
            ],
            self::STARTS_AT => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:now'],
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
