<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Lightit\Clinic\Domain\DataTransferObjects\ClinicDTO;
use Lightit\Clinic\Domain\Models\Clinic;

final readonly class StoreClinicAction
{
    public function execute(ClinicDTO $dto): Clinic
    {
        $clinic = new Clinic();
        $clinic->name = $dto->name;
        $clinic->address = $dto->address;

        $clinic->save();

        return $clinic;
    }
}
