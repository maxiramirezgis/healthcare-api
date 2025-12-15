<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDTO;
use Lightit\Doctor\Domain\Models\Doctor;

class UpdateDoctorAction
{
    public function execute(Doctor $doctor, DoctorDTO $dto): Doctor
    {
        $doctor->name = $dto->name;

        $doctor->save();

        return $doctor;
    }
}
