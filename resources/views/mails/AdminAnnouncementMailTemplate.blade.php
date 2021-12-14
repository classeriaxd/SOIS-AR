@component('mail::message')
{{-- Title --}}
# {{ 'SOIS-AR Announcement: ' . $title }}

{{-- Message --}}
Dear {{ $full_name }},

{{ $description }}

@component('mail::button', ['url' => route('welcome'), 'color' => 'green' ])
Visit and Login to SOIS-AR
@endcomponent

{{-- Salutations --}}
Sent by,<br>
{{ config('app.name') }} Team

{{-- Subcopy --}}
@component('mail::subcopy')
If you’re having trouble clicking the button, copy and paste the URL below into your web browser: {{ route('welcome') }}
@endcomponent

@endcomponent


