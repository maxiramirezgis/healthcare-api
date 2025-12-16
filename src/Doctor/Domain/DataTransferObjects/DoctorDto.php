<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\DataTransferObjects;

final readonly class DoctorDto
{
    public function __construct(
        public string $name,
    ) {
    }
}
