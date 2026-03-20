<?php
$lang = config('default_lang');
if (isset($cmsContent))
    $lang = $cmsContent->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<div class="form-body">	
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'lang'); ?>">
        <?php echo Form::label('lang', 'Language', ['class' => 'bold']); ?>                    
        <?php echo Form::select('lang', ['' => 'Select Language']+$languages, $lang, array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'setLang(this.value)')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'lang'); ?>                                       
    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'page_id'); ?>">
        <?php echo Form::label('page_id', 'CMS Page', ['class' => 'bold']); ?>                    
        <?php echo Form::select('page_id', ['' => 'Select page']+$cmsPages, null, array('class'=>'form-control', 'id'=>'page_id')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'page_id'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'page_title'); ?>">
        <?php echo Form::label('page_title', 'Page Title', ['class' => 'bold']); ?>                    
        <?php echo Form::text('page_title', null, array('class'=>'form-control', 'id'=>'page_title', 'placeholder'=>'Page Title', 'dir'=>$direction)); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'page_title'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'page_content'); ?>">
        <?php echo Form::label('page_content', 'Page Content', ['class' => 'bold']); ?>                    
        <?php echo Form::textarea('page_content', null, array('class'=>'form-control', 'id'=>'page_content', 'placeholder'=>'Page Content')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'page_content'); ?>                                       
    </div>
    <input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
</div>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    function setLang(lang) {
        window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
</script>
<?php echo $__env->make('admin.shared.cms_form_tinyMCE', array($lang, $direction), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/cms_content/forms/form.blade.php ENDPATH**/ ?>