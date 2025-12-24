<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\App\Notifications\AppointmentCreatedNotification;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;
use Throwable;

final readonly class StoreAppointmentAction
{
    /**
     * @throws Throwable
     */
    public function execute(
        AppointmentDto $dto,
        User $user,
    ): Appointment {
        $appointment = new Appointment();
        $appointment->clinic_id = $dto->clinicId;
        $appointment->doctor_id = $dto->doctorId;
        $appointment->user_id = $dto->userId;
        $appointment->starts_at = $dto->startsAt;
        $appointment->ends_at = $dto->endsAt;

        $appointment->saveOrFail();

        $appointment->load('clinic');
        $appointment->load('doctor');
        $appointment->load('user');

        $user->notify(new AppointmentCreatedNotification($appointment));

        return $appointment;
    }
}
