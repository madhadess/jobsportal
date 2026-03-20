@extends('admin.layouts.email_template')
@section('content')
    <table border="0" cellpadding="0" cellspacing="0" class="force-row"
        style="width: 100%;    border-bottom: solid 1px #ccc;">
        <tr>
            <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                         padding-top: 20px;">Hesap Doğrulama</div>
            </td>
        </tr>
        <tr>
            <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                    <tr>
                        <td class="row" valign="top"
                            style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                <tr>
                                    <td class="subtitle"
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: left;">
                                        <p>Merhaba,</p>
                                        <p>Hesabınızı doğrulamak için lütfen aşağıdaki bağlantıya tıklayın:</p>
                                        <p>
                                            <br>
                                            @php
                                                $isCompany = false;
                                                if(isset($userTable) && $userTable == 'companies') {
                                                    $isCompany = true;
                                                } elseif(isset($user) && $user instanceof \App\Company) {
                                                    $isCompany = true;
                                                } elseif(isset($company) && $company instanceof \App\Company) {
                                                    $isCompany = true;
                                                }
                                                
                                                $s_name = 'Sistem';
                                                if(isset($siteSetting) && isset($siteSetting->site_name)) {
                                                    $s_name = $siteSetting->site_name;
                                                } elseif(method_exists('\App\SiteSetting', 'first')) {
                                                    $s_set = \App\SiteSetting::first();
                                                    if($s_set) $s_name = $s_set->site_name;
                                                }

                                                // Fix for undefined token
                                                if(!isset($token)) {
                                                    if(isset($user) && !empty($user->verification_token)) {
                                                        $token = $user->verification_token;
                                                    } elseif(isset($company) && !empty($company->verification_token)) {
                                                        $token = $company->verification_token;
                                                    }
                                                }
                                                // Get Email
                                                $email = '';
                                                if(isset($user)) {
                                                    $email = $user->email;
                                                } elseif(isset($company)) {
                                                    $email = $company->email;
                                                }
                                            @endphp
                                            <a href="{{ url('email-verification/check/' . ($token ?? '') . '?email=' . urlencode($email) . ($isCompany ? '&userTable=companies' : '')) }}"
                                                style="color: #fff;text-decoration: none;background: #f25a55; padding: 7px 10px;text-align: center;display: inline-block;margin-top: 20px;">E-posta
                                                Adresini Doğrula</a>
                                            <br>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 30px;text-align: left;">
                                        <p
                                            style="margin-top:10px; font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #333;">
                                            Saygılarımızla, <br>
                                            {{ $s_name }} Ekibi
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection