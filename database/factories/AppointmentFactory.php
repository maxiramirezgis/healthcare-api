<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Appointments\Domain\Models\Appointment;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('now', '+1 month');
        $endsAt = fake()->dateTimeBetween($startsAt, $startsAt->format('Y-m-d H:i:s') . ' +2 hours');

        return [
            'clinic_id' => ClinicFactory::new(),
            'doctor_id' => DoctorFactory::new(),
            'user_id' => UserFactory::new(),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ];
    }
}
