<script src="<?php echo e(asset('admin_assets/global/plugins/tinymce/js/tinymce/jquery.tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin_assets/global/plugins/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>
<script>
tinymce.init({
    selector: '#page_content,#success_story',
    height: 250,
    forced_root_block: '',
    Language: '<?php echo e($lang); ?>',
    directionality: '<?php echo e($direction); ?>',
    entity_encoding : "raw",
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    relative_urls: true,
    images_upload_url: "<?php echo e(route('tinymce.image_upload')); ?>",
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', "<?php echo e(route('tinymce.image_upload')); ?>");
        xhr.onload = function () {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('image', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    },
    /*         
     
     */
});
</script>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/cms_form_tinyMCE.blade.php ENDPATH**/ ?>