@if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_admins') || APAuthHelp::hasPermission('manage_roles'))
    <li class="heading">
        <h3 class="uppercase">Yönetici Kullanıcılar</h3>
    </li>
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-user"></i>
            <span class="title">Yönetici Kullanıcılar</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_admins'))
                <li class="nav-item">
                    <a href="{{ route('list.admin.users') }}" class="nav-link">
                        <i class="icon-user"></i>
                        <span class="title">Tüm Yöneticileri Listele</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('create.admin.user') }}" class="nav-link">
                        <i class="icon-users"></i>
                        <span class="title">Yeni Yönetici Ekle</span>
                    </a>
                </li>
            @endif
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_roles'))
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <i class="icon-lock"></i>
                        <span class="title">Rolleri Yönet</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif