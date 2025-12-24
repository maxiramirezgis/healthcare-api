<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\AppointmentFactory;
use Lightit\Appointments\App\Controllers\GetAppointmentController;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

describe('appointments', function (): void {
    /** @see GetAppointmentController */
    it('retrieves an appointment and returns a successful response', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        $appointment->load(['user', 'clinic', 'doctor']);
        actingAs($appointment->user);

        getJson("api/appointments/$appointment->id")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $appointment->id,
                    'clinic' => [
                        'id' => $appointment->clinic->id,
                        'name' => $appointment->clinic->name,
                        'address' => $appointment->clinic->address,
                    ],
                    'doctor' => [
                        'id' => $appointment->doctor->id,
                        'name' => $appointment->doctor->name,
                    ],
                    'user' => [
                        'id' => $appointment->user->id,
                        'name' => $appointment->user->name,
                        'email_address' => $appointment->user->email,
                    ],
                    'starts_at' => $appointment->starts_at->toJSON(),
                    'ends_at' => $appointment->ends_at->toJSON(),
                ],
            ]);
    });

    it('returns a 404 response when appointment is not found', function (): void {
        $user = \Database\Factories\UserFactory::new()->createOne();
        actingAs($user);

        $nonExistentAppointmentId = 99999;

        getJson("api/appointments/{$nonExistentAppointmentId}")->assertNotFound();
    });
});
