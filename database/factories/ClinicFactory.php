<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Clinic\Domain\Models\Clinic;
use Sentry\ClientInterface;

/**
 * @extends Factory<Clinic>
 */
class ClinicFactory extends Factory
{
    protected $model = Clinic::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
        ];
    }

}
