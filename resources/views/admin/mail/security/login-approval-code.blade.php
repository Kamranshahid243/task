@component('mail::message')
Hi,

We just sent you a new login approval code. Please use the following code while login to your account.

Login approval code: {{ $code }}

Please not that you can use this code only one time. Next time you will get a new code if the login approval code is enabled on your profile.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
