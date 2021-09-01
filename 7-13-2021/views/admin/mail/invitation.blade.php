@component('mail::message')
{{ __('You have been invited to be an ADMINISTRATOR on the :appname platform!', ['appname' => env('APP_NAME')]) }}
{{--  If The user already exist?  --}}
{{ __('You may accept this invitation by clicking the button below:') }}
@component('mail::button', ['url' => $url])
    {{ __('Setup My Account ') }}
@endcomponent

{{--@if (!\App\Models\User::where('email', $invitation->email)->exists())
    {{ __('You may create an account by clicking the button below:') }}
    @component('mail::button', ['url' => route('register')])
        {{ __('Create Account') }}
    @endcomponent
@else
    {{ __('You may accept this invitation by clicking the button below:') }}
    @component('mail::button', ['url' => $url])
        {{ __('Accept Invitation') }}
    @endcomponent
@endif--}}
{{ __('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
