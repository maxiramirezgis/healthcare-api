<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;

class GetClinicAction
{
    public function execute(Clinic $clinic): Clinic
    {
        return $clinic;
    }
}
