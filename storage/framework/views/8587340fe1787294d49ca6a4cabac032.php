<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <h3>Language Seviyelerini Sıralamak İçin Sürükle ve Bırak</h3>
    <?php echo Form::select('lang', ['' => 'Language Seçin']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshLanguageLevelSortData();')); ?>

    <div id="languageLevelSortDataDiv"></div>
</div>
<?php $__env->startPush('scripts'); ?> 
<script>
    $(document).ready(function () {
        refreshLanguageLevelSortData();
    });
    function refreshLanguageLevelSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "<?php echo e(route('Language.level.sort.data')); ?>",
            data: {lang: Language},
            success: function (responseData) {
                $("#languageLevelSortDataDiv").html('');
                $("#languageLevelSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var languageLevelOrder = $(this).sortable('toArray').toString();
                        $.post("<?php echo e(route('Language.level.sort.update')); ?>", {languageLevelOrder: languageLevelOrder, _method: 'PUT', _token: '<?php echo e(csrf_token()); ?>'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
<?php $__env->stopPush(); ?>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/language_level/forms/sort.blade.php ENDPATH**/ ?>