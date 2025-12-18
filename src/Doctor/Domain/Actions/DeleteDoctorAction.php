<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\Models\Doctor;
use Throwable;

class DeleteDoctorAction
{
    /**
     * @throws Throwable
     */
    public function execute(Doctor $doctor): void
    {
        $doctor->deleteOrFail();
    }
}
