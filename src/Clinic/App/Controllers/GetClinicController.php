<?php

declare(strict_types=1);

namespace Lightit\Clinic\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinic\App\Resources\ClinicResource;
use Lightit\Clinic\Domain\Models\Clinic;

#[Group('Clinics')]
final class GetClinicController
{
    public function __invoke(Clinic $clinic): JsonResponse
    {
        $clinic->loadCount('doctors');

        return ClinicResource::make($clinic)
            ->response();
    }
}
