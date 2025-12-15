<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Doctor\Domain\Actions\DeleteDoctorAction;
use Lightit\Doctor\Domain\Models\Doctor;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

#[Group('Doctors')]
final class DeleteDoctorController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Doctor $doctor, DeleteDoctorAction $deleteDoctorAction): JsonResponse
    {
        $deleteDoctorAction->execute($doctor);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
