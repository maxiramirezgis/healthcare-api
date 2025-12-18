<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctor\Domain\Models\Doctor;
use Throwable;

class UpdateDoctorAction
{
    /**
     * @throws Throwable
     */
    public function execute(Doctor $doctor, DoctorDto $dto): Doctor
    {
        $doctor->name = $dto->name;

        $doctor->saveOrFail();

        return $doctor;
    }
}
