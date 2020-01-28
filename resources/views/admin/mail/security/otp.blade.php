@component('mail::message')
Hi,

We just sent you a new OTP (One Time Password). Please use the following password while login to your account.

OTP (One Time Password): {{ $password }}

Please not that you can use this password only one time. Next time you will get a new password if the OPT (One Time Password) is enabled on your profile.

Thanks,<br>
{{ config('app.name') }}
@endcomponent