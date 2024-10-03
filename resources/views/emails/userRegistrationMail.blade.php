<x-mail::message>
    # Introduction

    Your one time password is {{ $data['otp'] }}. Do not share your OTP with others.


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
