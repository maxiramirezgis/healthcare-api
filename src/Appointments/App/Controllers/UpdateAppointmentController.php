<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpdateAppointmentAction;
use Lightit\Appointments\Domain\Models\Appointment;
use Throwable;

#[Group('Appointments')]
final class UpdateAppointmentController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Appointment $appointment,
        UpsertAppointmentRequest $request,
        UpdateAppointmentAction $action,
    ): JsonResponse {
        $appointment = $action->execute($appointment, $request->toDto());

        return AppointmentResource::make($appointment)
            ->response();
    }
}
