<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\DeleteAppointmentRequest;
use Lightit\Appointments\Domain\Actions\DeleteAppointmentAction;
use Lightit\Appointments\Domain\Models\Appointment;
use Throwable;

#[Group('Appointments')]
final class DeleteAppointmentController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Appointment $appointment,
        DeleteAppointmentRequest $request,
        DeleteAppointmentAction $deleteAppointmentAction,
    ): JsonResponse {
        $deleteAppointmentAction->execute($appointment);

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
