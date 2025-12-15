<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Doctor\App\Requests\UpsertDoctorRequest;
use Lightit\Doctor\App\Resources\DoctorResource;
use Lightit\Doctor\Domain\Actions\UpdateDoctorAction;
use Lightit\Doctor\Domain\Models\Doctor;

#[Group('Doctors')]
final class UpdateDoctorController
{
    public function __invoke(
        Doctor $doctor,
        UpsertDoctorRequest $request,
        UpdateDoctorAction $action,
    ): JsonResponse {
        $doctor = $action->execute($doctor, $request->toDto());

        return DoctorResource::make($doctor)
            ->response();
    }
}
