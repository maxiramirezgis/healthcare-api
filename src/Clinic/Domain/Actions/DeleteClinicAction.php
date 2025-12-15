<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;

class DeleteClinicAction
{
    public function execute(Clinic $clinic): void
    {
        $clinic->delete();
    }
}
