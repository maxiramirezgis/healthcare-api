<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\Domain\Actions\DeleteClinicAction;
use Lightit\Clinic\Domain\Models\Clinic;
use Symfony\Component\HttpFoundation\Response;

#[Group('Clinics')]
final class DeleteClinicController
{
    public function __invoke(Clinic $clinic, DeleteClinicAction $deleteClinicAction): JsonResponse
    {
        $deleteClinicAction->execute($clinic);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
