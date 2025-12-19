<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;
use Throwable;

final readonly class StoreAppointmentAction
{
    /**
     * @throws Throwable
     */
    public function execute(AppointmentDto $dto): Appointment
    {
        $appointment = new Appointment();
        $appointment->clinic_id = $dto->clinicId;
        $appointment->doctor_id = $dto->doctorId;
        $appointment->user_id = $dto->userId;
        $appointment->starts_at = $dto->startsAt;
        $appointment->ends_at = $dto->endsAt;

        $appointment->saveOrFail();

        return $appointment;
    }
}
