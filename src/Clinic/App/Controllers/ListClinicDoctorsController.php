<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\Domain\Actions\ListClinicDoctorsAction;
use Lightit\Clinic\Domain\Models\Clinic;
use Lightit\Doctor\App\Resources\DoctorResource;

#[Group('Clinics')]
final class ListClinicDoctorsController
{
    public function __invoke(
        Clinic $clinic,
        ListClinicDoctorsAction $action,
    ): JsonResponse {
        $doctors = $action->execute($clinic);

        return DoctorResource::collection($doctors)
            ->response();
    }
}
