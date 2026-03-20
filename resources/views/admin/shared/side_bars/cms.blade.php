<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-file-text-o"
            aria-hidden="true"></i> <span class="title">İçerik Yönetimi</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_pages'))
            <li class="nav-item  "> <a href="{{ route('list.cms') }}" class="nav-link "> <span class="title">Sayfaları
                        Listele</span> </a> </li>
        @endif
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_pages'))
            <li class="nav-item  "> <a href="{{ route('create.cms') }}" class="nav-link "> <span class="title">Yeni Sayfa
                        Ekle</span> </a> </li>
        @endif
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_pages'))
            <li class="nav-item  "> <a href="{{ route('list.cmsContent') }}" class="nav-link "> <span
                        class="title">Çevrilmiş Sayfalar</span> </a> </li>
        @endif
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_pages'))
            <li class="nav-item  "> <a href="{{ route('create.cmsContent') }}" class="nav-link "> <span class="title">Yeni
                        Çeviri Ekle</span> </a> </li>
        @endif
    </ul>
</li>