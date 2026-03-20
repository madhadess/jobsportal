@if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_jobs'))
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-briefcase"></i>
            <span class="title">İş İlanları</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('list.jobs') }}" class="nav-link">
                    <span class="title">İlanları Listele</span>
                </a>
            </li>
            @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_jobs'))
                <li class="nav-item">
                    <a href="{{ route('create.job') }}" class="nav-link">
                        <span class="title">Yeni İlan Ekle</span>
                    </a>
                </li>
            @endif
            @if(APAuthHelp::check(['SUPER_ADMIN']))
                <li class="nav-item">
                    <a href="{{ route('list.jobsB') }}" class="nav-link">
                        <span class="title">İlanları İçe Aktar</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif