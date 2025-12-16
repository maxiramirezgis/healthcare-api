<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\DataTransferObjects;

final readonly class ClinicDto
{
    public function __construct(
        public string $name,
        public string $address,
    ) {
    }
}
