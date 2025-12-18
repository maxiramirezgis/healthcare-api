<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctor\Domain\Models\Doctor;
use Throwable;

class StoreDoctorAction
{
    /**
     * @throws Throwable
     */
    public function execute(DoctorDto $dto): Doctor
    {
        $doctor = new Doctor();
        $doctor->name = $dto->name;

        $doctor->saveOrFail();

        return $doctor;
    }
}
