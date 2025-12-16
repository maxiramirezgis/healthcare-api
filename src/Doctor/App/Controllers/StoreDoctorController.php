<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Doctor\App\Requests\UpsertDoctorRequest;
use Lightit\Doctor\App\Resources\DoctorResource;
use Lightit\Doctor\Domain\Actions\StoreDoctorAction;

#[Group('Doctors')]
final class StoreDoctorController
{
    public function __invoke(
        UpsertDoctorRequest $request,
        StoreDoctorAction $action,
    ): JsonResponse {
        $doctor = $action->execute($request->toDto());

        return DoctorResource::make($doctor)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
