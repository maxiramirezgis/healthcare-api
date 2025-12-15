<?php

declare(strict_types=1);

namespace Lightit\Doctor\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Doctor\App\Resources\DoctorResource;
use Lightit\Doctor\Domain\Models\Doctor;

#[Group('Doctors')]
final class GetDoctorController
{
    public function __invoke(Doctor $doctor): JsonResponse
    {
        return DoctorResource::make($doctor)
            ->response();
    }
}
