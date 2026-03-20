<li class="nav-item "><a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-level-up"
            aria-hidden="true"></i> <span class="title">Blog Yönetimi</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_blog') || APAuthHelp::hasPermission('view_blog'))
            <li class="nav-item  "> <a href="{{ route('blog') }}" class="nav-link "> <span class="title">Blogları
                        Listele</span> </a> </li>
        @endif
        @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_blog'))
            <li class="nav-item  "> <a href="{{ route('add-new-blog') }}" class="nav-link "> <span class="title">Yeni Blog
                        Ekle</span> </a> </li>
            <li class="nav-item  "> <a href="{{ URL::asset('/admin/blog_category')}}" class="nav-link "> <span
                        class="title">Kategoriler</span> </a> </li>
        @endif
    </ul>
</li>