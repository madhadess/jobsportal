@if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_users'))
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-user"></i>
            <span class="title">Kullanıcı Profilleri</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('list.users') }}" class="nav-link">
                    <i class="icon-user"></i>
                    <span class="title">Profilleri Listele</span>
                </a>
            </li>
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_users'))
                <li class="nav-item">
                    <a href="{{ route('create.user') }}" class="nav-link">
                        <i class="icon-user"></i>
                        <span class="title">Yeni Profil Ekle</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif