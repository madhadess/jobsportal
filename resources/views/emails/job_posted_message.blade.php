@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                 padding-top: 20px;">Sayın Süper Yönetici,</div></td>
    </tr>
    <tr>
        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
         <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
            <tr>
               <td width="192" style="width: 192px;" valign="top">
                  <![endif]-->      
            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <tr>
                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tr>
                                <td class="subtitle" style="font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:400;color:#000;text-align:left;padding-top:20px">

                                <p>Bir işveren, {{ $siteSetting->site_name }} sitesinin "İş İlanları" bölümünde onay için bir iş ilanı gönderdi. Detaylar aşağıdadır:</p>

                                    <p>"{{ $name }}" isimli işveren/şirket "{{ $siteSetting->site_name }}" sitesinde yeni iş ilanı yayınladı</p>                  
                                    <p><strong>İş İlanı Linki:</strong> 
                                        <span style="color: #000;text-decoration: none;text-align: left;display: inline-block;"><a href="{{ $link_admin }}" style="color: #000;">{{ $link_admin }}</a></span>
                                        <br>
                                    </p>

                                    <p>Lütfen başvuruyu inceleyin ve gerekli işlemi yapın. Daha fazla bilgiye ihtiyacınız varsa, diğer yöneticilerle iletişime geçebilirsiniz.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 30px;text-align: left;">
                                <p style="margin-top:10px; font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #333;">                               
                                Saygılarımızla, <br>
{{ $siteSetting->site_name }} Ekibi 
</p>
                                </td>
                            </tr>
                        </table>
                        <br></td>
                </tr>
            </table>      
            <!--[if mso]>
               </td>
            </tr>
         </table>
         <![endif]--></td>
    </tr>
</table>
@endsection


