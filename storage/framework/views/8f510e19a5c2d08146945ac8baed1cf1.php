
<?php $__env->startSection('content'); ?>
<!-- Header start -->
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Header end -->

<?php if(null!==($blog)): ?>


<div class="listpgWraper pt-5">
<section id="blog-content">
    <div class="container">
        <?php
        $cate_ids = explode(",", $blog->cate_id);
        $data = DB::table('blog_categories')->whereIn('id', $cate_ids)->get();
        $cate_array = array();
        foreach ($data as $cat) {
            $cate_array[] = "<a href='" . url('/blog/category/') . "/" . $cat->slug . "'>$cat->heading</a>";
        }
        ?>
        <!-- Blog start -->
        <div class="row">
       
            <div class="col-lg-9">
                <!-- Blog List start -->
                <div class="blogdetailwrap">
                  <h1><?php echo e($blog->heading); ?></h1>

                        <div class="postimg"><?php echo e($blog->printBlogImage()); ?></div>

                        <div class="post-header">
                            
                            <div class="postmeta">Category : <?php echo implode(', ',$cate_array); ?></div>
                        </div>
                        <p><?php echo $blog->content; ?></p>


                      
                </div>


            </div>
			
			 <div class="col-lg-3">
				 
				 <div class="blogsidebar"> 
          <!-- Search -->
          <div class="widget mb-5">
            <h5 class="widget-title">Search</h5>
            <div class="search">
              <form action="<?php echo e(route('blog-search')); ?>" method="GET">
                <input type="text" class="form-control" placeholder="Search" name="search">
                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>
          <!-- Categories -->
          <?php if(null!==($categories)): ?>
          <div class="widget">
            <h5 class="widget-title">Categories</h5>
            <ul class="categories">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><a href="<?php echo e(url('/blog/category/').'/'.$category->slug); ?>"><?php echo e($category->heading); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>
			</div>
			

        </div>
    </div>
</section>
</div>

<?php endif; ?>
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
.plus-minus-input {
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}

.plus-minus-input .input-group-field {
    text-align: center;
    margin-left: 0.5rem;
    margin-right: 0.5rem;
    padding: 0rem;
}

.plus-minus-input .input-group-field::-webkit-inner-spin-button,
.plus-minus-input .input-group-field ::-webkit-outer-spin-button {
    -webkit-appearance: none;
    appearance: none;
}

.plus-minus-input .input-group-button .circle {
    border-radius: 50%;
    padding: 0.25em 0.8em;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('includes.immediate_available_btn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/blog_detail.blade.php ENDPATH**/ ?>