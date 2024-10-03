<x-mail::message>
    # Confirmation Code
    <p>Do not share your OTP with anyone</p>
    <b>{{ $data['code'] }}</b>


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
