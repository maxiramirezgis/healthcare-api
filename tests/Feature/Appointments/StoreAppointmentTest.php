<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Lightit\Appointments\App\Controllers\StoreAppointmentController;
use Lightit\Appointments\Domain\Models\Appointment;
use Tests\RequestFactories\StoreAppointmentRequestFactory;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

dataset('validation-rules', [
    'clinic_id is required' => ['clinic_id', ''],
    'clinic_id must be integer' => ['clinic_id', 'not-an-integer'],
    'clinic_id must exist' => ['clinic_id', 99999],

    'doctor_id is required' => ['doctor_id', ''],
    'doctor_id must be integer' => ['doctor_id', 'not-an-integer'],
    'doctor_id must exist' => ['doctor_id', 99999],

    'user_id is required' => ['user_id', ''],
    'user_id must be integer' => ['user_id', 'not-an-integer'],
    'user_id must exist' => ['user_id', 99999],

    'starts_at is required' => ['starts_at', ''],
    'starts_at must be valid date' => ['starts_at', 'not-a-date'],
    'starts_at must match format' => ['starts_at', '2025-12-25'],

    'ends_at is required' => ['ends_at', ''],
    'ends_at must be valid date' => ['ends_at', 'not-a-date'],
    'ends_at must match format' => ['ends_at', '2025-12-25'],
]);

describe('appointments', function (): void {
    /** @see StoreAppointmentController */
    it('can create an appointment successfully', function (): void {
        $user = UserFactory::new()->createOne();
        $data = StoreAppointmentRequestFactory::new()->create([
            'user_id' => $user->id,
        ]);

        actingAs($user);

        $response = postJson('/api/appointments', $data);

        $appointment = Appointment::query()
            ->where('clinic_id', $data['clinic_id'])
            ->where('doctor_id', $data['doctor_id'])
            ->where('user_id', $data['user_id'])
            ->firstOrFail();

        $response
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'id' => $appointment->id,
                    'clinic' => ['id' => $data['clinic_id']],
                    'doctor' => ['id' => $data['doctor_id']],
                    'user' => ['id' => $data['user_id']],
                ],
            ]);

        assertDatabaseHas('appointments', [
            'clinic_id' => $data['clinic_id'],
            'doctor_id' => $data['doctor_id'],
            'user_id' => $data['user_id'],
        ]);
    });

    it('requires authentication to create an appointment', function (): void {
        $data = StoreAppointmentRequestFactory::new()->create();

        postJson('/api/appointments', $data)->assertUnauthorized();
    });

    it('cannot create appointment when doctor does not work at clinic', function (): void {
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor = DoctorFactory::new()->createOne();

        $startsAt = now()->addDay()->setTime(10, 0);

        $data = [
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'ends_at' => $startsAt->copy()->addHour()->format('Y-m-d H:i:s'),
        ];

        actingAs($user);

        postJson('/api/appointments', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['doctor_id'], 'error.fields');
    });

    it('cannot create appointment when doctor has overlapping appointment', function (): void {
        $existingAppointment = AppointmentFactory::new()->createOne([
            'starts_at' => now()->addDay()->setTime(10, 0),
            'ends_at' => now()->addDay()->setTime(11, 0),
        ]);

        $existingAppointment->load(['clinic', 'doctor']);

        $user = UserFactory::new()->createOne();
        $existingAppointment->clinic->doctors()->attach($existingAppointment->doctor);

        $data = [
            'clinic_id' => $existingAppointment->clinic_id,
            'doctor_id' => $existingAppointment->doctor_id,
            'user_id' => $user->id,
            'starts_at' => $existingAppointment->starts_at->addMinutes(30)->format('Y-m-d H:i:s'),
            'ends_at' => $existingAppointment->ends_at->addMinutes(30)->format('Y-m-d H:i:s'),
        ];

        actingAs($user);

        postJson('/api/appointments', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['doctor_id'], 'error.fields');
    });

    it('cannot create appointment when user has overlapping appointment', function (): void {
        $user = UserFactory::new()->createOne();
        $existingAppointment = AppointmentFactory::new()->createOne([
            'user_id' => $user->id,
            'starts_at' => now()->addDay()->setTime(10, 0),
            'ends_at' => now()->addDay()->setTime(11, 0),
        ]);

        $clinic = ClinicFactory::new()->createOne();
        $doctor = DoctorFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $data = [
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'starts_at' => $existingAppointment->starts_at->addMinutes(30)->format('Y-m-d H:i:s'),
            'ends_at' => $existingAppointment->ends_at->addMinutes(30)->format('Y-m-d H:i:s'),
        ];

        actingAs($user);

        postJson('/api/appointments', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['user_id'], 'error.fields');
    });

    it('cannot create appointment in the past', function (): void {
        $user = UserFactory::new()->createOne();
        $data = StoreAppointmentRequestFactory::new()->create([
            'user_id' => $user->id,
            'starts_at' => now()->subHour()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addHour()->format('Y-m-d H:i:s'),
        ]);

        actingAs($user);

        postJson('/api/appointments', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['starts_at'], 'error.fields');
    });

    it('cannot create appointment where ends_at is before starts_at', function (): void {
        $user = UserFactory::new()->createOne();
        $startsAt = now()->addDay()->setTime(11, 0);

        $data = StoreAppointmentRequestFactory::new()->create([
            'user_id' => $user->id,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'ends_at' => $startsAt->subHour()->format('Y-m-d H:i:s'),
        ]);

        actingAs($user);

        postJson('/api/appointments', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['ends_at'], 'error.fields');
    });

    it('cannot create appointment with invalid data', function (string $field, mixed $value): void {
        $user = UserFactory::new()->createOne();
        $data = StoreAppointmentRequestFactory::new()->create(['user_id' => $user->id]);

        actingAs($user);

        postJson('/api/appointments', [...$data, $field => $value])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([$field], 'error.fields');
    })->with('validation-rules');
});
