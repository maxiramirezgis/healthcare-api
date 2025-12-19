<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lightit\Appointments\Domain\Models\Appointment;

class UserHasNoOverlappingAppointments implements ValidationRule
{
    public function __construct(
        private readonly int $userId,
        private readonly string $startsAt,
        private readonly string $endsAt,
        private readonly int|null $excludeAppointmentId = null,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Appointment::query()
            ->where('user_id', $this->userId)
            ->where('starts_at', '<', $this->endsAt)
            ->where('ends_at', '>', $this->startsAt);

        if ($this->excludeAppointmentId) {
            $query->where('id', '!=', $this->excludeAppointmentId);
        }

        if ($query->exists()) {
            $fail('The user has an overlapping appointment.');
        }
    }
}
