<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDTO;
use Lightit\Doctor\Domain\Models\Doctor;

class StoreDoctorAction
{
    public function execute(DoctorDTO $dto): Doctor
    {
        $doctor = new Doctor();
        $doctor->name = $dto->name;

        $doctor->save();

        return $doctor;
    }
}
