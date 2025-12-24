<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lightit\Appointments\Domain\Models\Appointment;

class DoctorHasNoOverlappingAppointments implements ValidationRule
{
    public function __construct(
        private readonly int $doctorId,
        private readonly string $startsAt,
        private readonly string $endsAt,
        private readonly Appointment|null $excludeAppointment,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->doctorId <= 0 || ! is_int($value)) {
            return;
        }

        if ($this->startsAt === '' || $this->startsAt === '0' || ($this->endsAt === '' || $this->endsAt === '0')) {
            return;
        }

        if (strtotime($this->startsAt) === false || strtotime($this->endsAt) === false) {
            return;
        }

        $query = Appointment::query()
            ->where('doctor_id', $this->doctorId)
            ->where('starts_at', '<', $this->endsAt)
            ->where('ends_at', '>', $this->startsAt);

        if ($this->excludeAppointment instanceof Appointment) {
            $query->whereNot('id', $this->excludeAppointment->id);
        }

        if ($query->exists()) {
            $fail('The doctor has an overlapping appointment.');
        }
    }
}
