@component('mail::message')
# Hi {{ $data['name'] }}!

Your OTP to change password is {{ $data['otp'] }}

**Please do not share your OTP to anyone.**

@component('mail::button', ['url' => url('admin') ])
View Admin Panel
@endcomponent

@component('mail::regards-section')
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
