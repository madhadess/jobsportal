@component('mail::message')
Son bir adım!
@component('mail::button', ['url' => route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) ])
Hesabınızı doğrulamak için buraya tıklayın
@endcomponent
<p style="margin-top:10px; font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #333;">                               
Saygılarımızla, <br>
Saygılarımızla, <br>
{{ $siteSetting->site_name }} Ekibi 
</p>

@endcomponent


