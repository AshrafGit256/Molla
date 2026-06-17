@component('mail::message')

Hi <b>{{ $user->name }}</b>,
@php
    $getSetting = App\Models\SystemSettingModel::getSingle();
    $websiteName = $getSetting->website_name ?? 'DukaGo';
@endphp
<p>You are most welcome thank you for choosing <strong>{{ $websiteName }}</strong> </p>

<p>Simply click the button below to verify your email address.</p>

<p>
@component('mail::button', ['url' => url('activate/'.base64_encode($user->id))])
Verify
@endcomponent
</p>

<p>This will verify your email address, and then you will officially be part of the <strong>{{ $websiteName }}</strong> online platform.</p>

Thanks,<br>
<strong>{{ $websiteName }}</strong>

@endcomponent
