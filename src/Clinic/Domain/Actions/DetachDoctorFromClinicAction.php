<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;
use Lightit\Doctor\Domain\Models\Doctor;

class DetachDoctorFromClinicAction
{
    public function execute(Clinic $clinic, Doctor $doctor): void
    {
        $clinic->doctors()->detach($doctor->id);
    }
}
