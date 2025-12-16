<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\App\Requests\UpsertClinicRequest;
use Lightit\Clinic\App\Resources\ClinicResource;
use Lightit\Clinic\Domain\Actions\UpdateClinicAction;
use Lightit\Clinic\Domain\Models\Clinic;

#[Group('Clinics')]
final class UpdateClinicController
{
    public function __invoke(
        Clinic $clinic,
        UpsertClinicRequest $request,
        UpdateClinicAction $action,
    ): JsonResponse {
        $clinic = $action->execute($clinic, $request->toDto());

        return ClinicResource::make($clinic)
            ->response();
    }
}
