<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\Domain\Actions\DeleteClinicAction;
use Lightit\Clinic\Domain\Models\Clinic;
use Throwable;

#[Group('Clinics')]
final class DeleteClinicController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Clinic $clinic, DeleteClinicAction $deleteClinicAction): JsonResponse
    {
        $deleteClinicAction->execute($clinic);

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
