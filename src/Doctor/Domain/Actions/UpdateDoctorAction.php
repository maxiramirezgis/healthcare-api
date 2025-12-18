<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\Models\Doctor;
use Throwable;

class UpdateDoctorAction
{
    /**
     * @throws Throwable
     */
    public function execute(Doctor $doctor, string $doctorName): Doctor
    {
        $doctor->name = $doctorName;

        $doctor->saveOrFail();

        return $doctor;
    }
}
