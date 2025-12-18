<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\Models\Doctor;
use Throwable;

class StoreDoctorAction
{
    /**
     * @throws Throwable
     */
    public function execute(string $doctorName): Doctor
    {
        $doctor = new Doctor();
        $doctor->name = $doctorName;

        $doctor->saveOrFail();

        return $doctor;
    }
}
