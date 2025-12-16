<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;

class AttachDoctorToClinicAction
{
    /**
     * @param array<int> $doctorIds
     */
    public function execute(Clinic $clinic, array $doctorIds): void
    {
        $clinic->doctors()->syncWithoutDetaching($doctorIds);
    }
}
