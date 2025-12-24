<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\AppointmentFactory;
use Lightit\Appointments\App\Controllers\DeleteAppointmentController;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('appointments', function (): void {
    /** @see DeleteAppointmentController */
    it('deletes an appointment and returns a successful response', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        $appointment->load('user');
        actingAs($appointment->user);

        $response = deleteJson("api/appointments/$appointment->id");
        $response->assertNoContent();

        assertSoftDeleted('appointments', ['id' => $appointment->id]);
    });

    it('returns a 404 response when appointment is not found', function (): void {
        $nonExistentAppointmentId = 99999;

        deleteJson("api/appointmetns/$nonExistentAppointmentId")->assertNotFound();
    });
});
