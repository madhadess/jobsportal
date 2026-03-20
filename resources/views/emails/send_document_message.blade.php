@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                 padding-top: 20px;">Sayın {{ isset($is_admin) && $is_admin ? ($full_name ?? 'Süper Yönetici') : 'Süper Yönetici' }},
                 
                 <?php if($company->is_active == 1 && $is_admin){ ?>
                 <p>Tebrikler! {{ $siteSetting->site_name }} üzerindeki hesabınız Süper Yöneticimiz tarafından onaylandı. Artık iş ilanları yayınlamaya ve potansiyel adaylarla bağlantı kurmaya hazırsınız.</p>
                 <?php  }elseif($is_admin  && $status !=1){ ?>
                 <p>{{ $siteSetting->site_name }} üzerinde iş ilanı yayınlamak istediğiniz için teşekkür ederiz. Maalesef, işletme durumunuzu doğrulamak için yeterli belge sağlanamadığından başvurunuz reddedildi.</p>
                 <?php }else{ ?>
                 <p>{{$is_admin?'İşveren olarak kayıt olmak için başvurunuzu gönderdiğiniz için teşekkür ederiz. Talebinizi ve ekli belgelerinizi aldık.':'Yeni bir şirket veya işveren {{ $siteSetting->site_name }} sitesine kayıt oldu. İş ilanları yayınlamaya başlayabilmeleri için onayınızı rica ederiz.'}} </p>
                 <?php } ?>   
            <h3>
                Şirket/İşveren Bilgileri:
            </h3> 
            <p><strong>Şirket Profil Linki: {{route('company.detail', $company->slug)}}</strong></p>
            
            <?php if($company->is_active == 1 && $is_admin ){ ?>
            
            <h3>
                Başlangıç:
                
            </h3>
            <ol>
                <li>{{ $siteSetting->site_name }} hesabınıza giriş yapın.</li>
                <li>İş İlanları bölümüne gidin.</li>
                <li>İş ilanınızı oluşturmak için "Yeni İş İlanı Ekle" butonuna tıklayın.</li>
            </ol>
            
            <p>Herhangi bir sorunuz varsa veya yardıma ihtiyacınız olursa, {{ $siteSetting->site_name }} profil linkinizle destek ekibimize ulaşabilirsiniz.<br>
İşe alım ihtiyaçlarınız için {{ $siteSetting->site_name }} sitesini tercih ettiğiniz için teşekkür ederiz!</p>

            <?php  }elseif($is_admin  && $status !=1){ ?>
            
            <h3>
                Sonraki Adımlar:
                
            </h3>
            <ol>
                <li>Belgelerinizi Gözden Geçirin: Lütfen şirketinizin meşruiyetini kanıtlayan açık ve geçerli belgeler sağladığınızdan emin olun.</li>
                <li>Başvurunuzu Yeniden Gönderin: Gerekli belgelere sahip olduğunuzda, {{ $siteSetting->site_name }} hesabınıza giriş yapın ve başvurunuzu yeniden gönderin.</li>
                <li>Hızlı İnceleme: Güncellenmiş başvurunuzu aldığımızda ekibimiz inceleme sürecini hızlandıracaktır.</li>
            </ol>
            
            <p>{{ $siteSetting->site_name }} İş İlanları'na olan bağlılığınız için teşekkür eder, yaşanan herhangi bir aksaklık için özür dileriz. Herhangi bir sorunuz varsa veya yardıma ihtiyacınız olursa, destek ekibimize ulaşmaktan çekinmeyin.</p>
            
            <?php }else{ ?>
            @if(!$is_admin)
           
            <p><strong>Yönetici paneli linki: {{route('public.company', ['id' => $company->id])}}</strong></p>
            <p>Lütfen {{ $siteSetting->site_name }} üzerindeki Süper Yönetici hesabınıza giriş yapın ve kayıt bilgilerini inceleyin. Her şey uygun görünüyorsa, iş ilanları yayınlamaya başlayabilmeleri için hesaplarını onaylayın.</p>
            @else
            <p>İnceleme ekibimiz şu anda başvurunuzu değerlendirmektedir. Lütfen doğrulama süreci için biraz zaman tanıyın. Hesabınız doğrulandığında bir bildirim e-postası alacaksınız.</p>
<p>Herhangi bir sorunuz varsa veya yardıma ihtiyacınız olursa, bizimle iletişime geçmekten çekinmeyin.</p>
            @endif
            
             <?php } ?>   
            
            
            <p style="margin-top:10px; font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #333;">                               
            Saygılarımızla, <br>
{{ $siteSetting->site_name }} Ekibi 
            </p>
           
                 
        </div>
                 
        </td>
    </tr>
</table>
@endsection


