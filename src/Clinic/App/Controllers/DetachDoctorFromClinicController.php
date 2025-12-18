<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\Domain\Actions\DetachDoctorFromClinicAction;
use Lightit\Clinic\Domain\Models\Clinic;
use Lightit\Doctor\Domain\Models\Doctor;
use Symfony\Component\HttpFoundation\Response;

#[Group('Clinics')]
final class DetachDoctorFromClinicController
{
    public function __invoke(
        Clinic $clinic,
        Doctor $doctor,
        DetachDoctorFromClinicAction $action,
    ): JsonResponse {
        $action->execute($clinic, $doctor);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
