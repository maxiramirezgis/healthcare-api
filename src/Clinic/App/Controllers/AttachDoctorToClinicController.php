<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\App\Requests\AttachDoctorRequest;
use Lightit\Clinic\Domain\Actions\AttachDoctorToClinicAction;
use Lightit\Clinic\Domain\Models\Clinic;
use Symfony\Component\HttpFoundation\Response;

#[Group('Clinics')]
final class AttachDoctorToClinicController
{
    public function __invoke(
        Clinic $clinic,
        AttachDoctorRequest $request,
        AttachDoctorToClinicAction $action,
    ): JsonResponse {
        $action->execute($clinic, $request->getDoctorId());

        return response()->json(
            ['message' => 'Doctor successfully attached to clinic'],
            Response::HTTP_CREATED
        );
    }
}
