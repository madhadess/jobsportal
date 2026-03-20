@if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_companies') || APAuthHelp::hasPermission('view_orders'))
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-building"></i>
            <span class="title">Şirketler</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('list.companies') }}" class="nav-link">
                    <span class="title">Şirketleri Listele</span>
                </a>
            </li>
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_companies'))
                <li class="nav-item">
                    <a href="{{ route('create.company') }}" class="nav-link">
                        <span class="title">Yeni Şirket Ekle</span>
                    </a>
                </li>
            @endif
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_orders'))
                <li class="nav-item">
                    <a href="{{ route('list.payment.hostory') }}" class="nav-link">
                        <span class="title">Şirket Ödeme Geçmişi</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif