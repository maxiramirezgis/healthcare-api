<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;

class AttachDoctorToClinicAction
{
    public function execute(Clinic $clinic, int $doctorId): void
    {
        $clinic->doctors()->syncWithoutDetaching([$doctorId]);
    }
}
