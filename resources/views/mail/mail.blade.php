@component('mail::message')
# Appointment Confirmed

Hello {{ $name }},

Your appointment has been successfully scheduled!

@component('mail::panel')
**Appointment Details**

**Date:** {{ $appointment->starts_at->format('l, F j, Y') }}
**Time:** {{ $appointment->starts_at->format('g:i A') }} - {{ $appointment->ends_at->format('g:i A') }}
**Duration:** {{ $appointment->starts_at->diffInMinutes($appointment->ends_at) }} minutes

**Doctor:** Dr. {{ $appointment->doctor->name }}
**Clinic:** {{ $appointment->clinic->name }}
**Address:** {{ $appointment->clinic->address }}
@endcomponent

@component('mail::button', ['url' => config('app.url')])
View Appointment
@endcomponent

Please arrive 10 minutes before your scheduled time.

If you need to reschedule or cancel, please contact us as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
