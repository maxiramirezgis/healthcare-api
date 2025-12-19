<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\Models\Appointment;
use Throwable;

class DeleteAppointmentAction
{
    /**
     * @throws Throwable
     */
    public function execute(Appointment $appointment): void
    {
        $appointment->deleteOrFail();
    }
}
