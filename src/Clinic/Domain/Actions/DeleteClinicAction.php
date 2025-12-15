<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\Models\Clinic;
use Throwable;

class DeleteClinicAction
{
    /**
     * @throws Throwable
     */
    public function execute(Clinic $clinic): void
    {
        $clinic->deleteOrFail();
    }
}
