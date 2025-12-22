<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;

class DeleteAppointmentRequest extends FormRequest
{
    public function authorize(
        #[CurrentUser]
        User $user,
        #[RouteParameter('appointment')]
        Appointment $appointment,
    ): bool {
        return $appointment->user_id === $user->id;
    }
}
