<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <!-- STATUS DROPDOWN -->
        <!-- END STATUS DROPDOWN -->

        <!-- BEGIN USER LOGIN DROPDOWN -->
        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
        <li class="dropdown dropdown-user"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                data-hover="dropdown" data-close-others="true"> <span class="username username-hide-on-mobile">
                    <?php echo e((null !== (Auth::user()) && isset(Auth::user()->name)) ? Auth::user()->name : ''); ?> </span> <i
                    class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li> <a href="<?php echo e(route('admin.home')); ?>"> <i class="icon-user"></i> Profilim </a> </li>
                <li class="divider"> </li>
                <li> <a href="<?php echo e(route('admin.logout')); ?>"> <i class="icon-key"></i> Çıkış Yap </a> </li>
            </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->
    </ul>
</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/top_menu.blade.php ENDPATH**/ ?>