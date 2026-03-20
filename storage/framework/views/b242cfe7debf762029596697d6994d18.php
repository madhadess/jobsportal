<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-wrench"></i> <span class="title">Site Ayarları</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <li class="nav-item  "> <a href="<?php echo e(route('edit.site.setting')); ?>" class="nav-link "> <span class="title">Site Ayarlarını Yönet</span> </a> </li>


    </ul>
</li>


<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-wrench"></i> <span class="title">Statik İçerik Modülleri</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">

<?php 

$w_pages = App\Models\WidgetPages::where('status','Aktif')->get();

?>

<?php if(null!==($w_pages)): ?>


          <?php $__currentLoopData = $w_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w_p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="nav-item  "> <a href="<?php echo e(route('admin.widgets_data',$w_p->slug)); ?>" class="nav-link "> <span class="title"><?php echo e($w_p->title); ?></span> </a> </li>
          
        
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
  <?php endif; ?>

    </ul>
</li>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/site_setting.blade.php ENDPATH**/ ?>