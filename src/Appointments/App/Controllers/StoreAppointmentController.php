<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\StoreAppointmentAction;
use Lightit\Users\Domain\Models\User;
use Throwable;

#[Group('Appointments')]
final class StoreAppointmentController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        UpsertAppointmentRequest $request,
        StoreAppointmentAction $action,
        #[CurrentUser]
        User $user,
    ): JsonResponse {
        $appointment = $action->execute($request->toDto(), $user);

        return AppointmentResource::make($appointment)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
