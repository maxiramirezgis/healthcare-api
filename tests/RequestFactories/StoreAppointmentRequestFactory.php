<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Worksome\RequestFactories\RequestFactory;

class StoreAppointmentRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $clinic = ClinicFactory::new()->createOne();
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();

        $clinic->doctors()->attach($doctor);

        $startsAt = now()->addDays(1)->setTime(10, 0);
        $endsAt = $startsAt->copy()->addHour();

        return [
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'ends_at' => $endsAt->format('Y-m-d H:i:s'),
        ];
    }
}
