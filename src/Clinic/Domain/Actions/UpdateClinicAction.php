<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\DataTransferObjects\ClinicDto;
use Lightit\Clinic\Domain\Models\Clinic;

class UpdateClinicAction
{
    public function execute(Clinic $clinic, ClinicDto $dto): Clinic
    {
        $clinic->name = $dto->name;
        $clinic->address = $dto->address;

        $clinic->save();

        return $clinic;
    }
}
