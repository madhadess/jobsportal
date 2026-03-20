<div class="row">
   <div class="col-md-12">
      <div class="form-group">
         {!! Form::label('title', 'Widget Başlığı', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('title', null, array('class' => 'form-control', 'id' => 'title', 'placeholder' => 'Widget Başlığı')) !!}
      </div>
   </div>

</div>
<div class="row">
   <div class="col-md-12">
      <div class="form-group">
         {!! Form::label('widget_page_id', 'Widget Sayfası', ['class' => 'font-weight-bold']) !!}
         {!! Form::select('widget_page_id', ['' => 'Widget Sayfası Seç'] + $widget_pages, null, array('class' => 'form-control', 'id' => 'widget_page_id')) !!}
      </div>

   </div>
   <div class="col-md-12">
      <div class="form-group">
         @php
            $fields = array(
               0 => 'Hayır',
               1 => 'Evet',
            );
         @endphp
         {!! Form::label('is_description', 'Widget Açıklaması', ['class' => 'font-weight-bold']) !!}
         {!! Form::select('is_description', $fields, null, array('class' => 'form-control', 'id' => 'is_description')) !!}
      </div>

   </div>

</div>


<div class="row">
   <div class="col-md-12">
      <div class="form-group">
         {!! Form::label('is_extra_image_title_1', 'Widget Resim 1', ['class' => 'font-weight-bold']) !!}
         {!! Form::select('is_extra_image_title_1', $fields, null, array('class' => 'form-control', 'id' => 'is_extra_image_title_1')) !!}
      </div>

   </div>
   <div class="col-md-4 image_section">
      <div class="form-group">
         {!! Form::label('extra_image_title_1', 'Widget Resim 1 Başlığı', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_title_1', null, array('class' => 'form-control', 'id' => 'extra_image_title_1', 'placeholder' => 'Widget Resim 1 Başlığı')) !!}
      </div>
   </div>
   <div class="col-md-4 image_section">
      <div class="form-group">
         {!! Form::label('extra_image_1_height', 'Küçük Resim Yüksekliği', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_1_height', null, array('class' => 'form-control', 'id' => 'extra_image_1_height', 'placeholder' => 'Küçük Resim Yüksekliği')) !!}
      </div>
   </div>
   <div class="col-md-4 image_section">
      <div class="form-group">
         {!! Form::label('extra_image_1_width', 'Küçük Resim Genişliği', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_1_width', null, array('class' => 'form-control', 'id' => 'extra_image_1_width', 'placeholder' => 'Küçük Resim Genişliği')) !!}
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="form-group">
         {!! Form::label('is_extra_image_title_2', 'Widget Resim 2', ['class' => 'font-weight-bold']) !!}
         {!! Form::select('is_extra_image_title_2', $fields, null, array('class' => 'form-control', 'id' => 'is_extra_image_title_2')) !!}
      </div>

   </div>
   <div class="col-md-4 image_section_2">
      <div class="form-group">
         {!! Form::label('extra_image_title_2', 'Widget Resim 2 Başlığı', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_title_2', null, array('class' => 'form-control', 'id' => 'extra_image_title_2', 'placeholder' => 'Widget Resim 2 Başlığı')) !!}
      </div>
   </div>
   <div class="col-md-4 image_section_2">
      <div class="form-group">
         {!! Form::label('extra_image_2_height', 'Küçük Resim Yüksekliği', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_2_height', null, array('class' => 'form-control', 'id' => 'extra_image_2_height', 'placeholder' => 'Küçük Resim Yüksekliği')) !!}
      </div>
   </div>
   <div class="col-md-4 image_section_2">
      <div class="form-group">
         {!! Form::label('extra_image_2_width', 'Küçük Resim Genişliği', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_image_2_width', null, array('class' => 'form-control', 'id' => 'extra_image_2_width', 'placeholder' => 'Küçük Resim Genişliği')) !!}
      </div>
   </div>
</div>


<div class="row">
   <div class="col-md-12">
      <div class="form-group">
         @php
            $extra_fields = array(
               1 => 1,
               2 => 2,
               3 => 3,
               4 => 4,
               5 => 5,
               6 => 6,
               7 => 7,
            );
         @endphp
         {!! Form::label('extra_fields', 'Ekstra Alanlar', ['class' => 'font-weight-bold']) !!}
         {!! Form::select('extra_fields', ['' => 'Ekstra Alan Seç'] + $extra_fields, null, array('class' => 'form-control', 'id' => 'extra_fields')) !!}
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_1', 'Ekstra Alan Başlığı 1', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_1', null, array('class' => 'form-control', 'id' => 'extra_field_title_1', 'placeholder' => 'Ekstra Alan Başlığı 1')) !!}
      </div>
   </div>
   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_2', 'Ekstra Alan Başlığı 2', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_2', null, array('class' => 'form-control', 'id' => 'extra_field_title_2', 'placeholder' => 'Ekstra Alan Başlığı 2')) !!}
      </div>
   </div>

   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_3', 'Ekstra Alan Başlığı 3', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_3', null, array('class' => 'form-control', 'id' => 'extra_field_title_3', 'placeholder' => 'Ekstra Alan Başlığı 3')) !!}
      </div>
   </div>
   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_4', 'Ekstra Alan Başlığı 4', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_4', null, array('class' => 'form-control', 'id' => 'extra_field_title_4', 'placeholder' => 'Ekstra Alan Başlığı 4')) !!}
      </div>
   </div>

   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_5', 'Ekstra Alan Başlığı 5', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_5', null, array('class' => 'form-control', 'id' => 'extra_field_title_5', 'placeholder' => 'Ekstra Alan Başlığı 5')) !!}
      </div>
   </div>
   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_6', 'Ekstra Alan Başlığı 6', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_6', null, array('class' => 'form-control', 'id' => 'extra_field_title_6', 'placeholder' => 'Ekstra Alan Başlığı 6')) !!}
      </div>
   </div>

   <div class="col-md-12 extra_field_title" style="display: none;">
      <div class="form-group">
         {!! Form::label('extra_field_title_7', 'Ekstra Alan Başlığı 7', ['class' => 'font-weight-bold']) !!}
         {!! Form::text('extra_field_title_7', null, array('class' => 'form-control', 'id' => 'extra_field_title_7', 'placeholder' => 'Ekstra Alan Başlığı 7')) !!}
      </div>
   </div>






   @push('scripts')

      <script type="text/javascript">
         extrafields("{{old('extra_fields', data_get($widget ?? null, 'extra_fields', ''))}}");
         $('#extra_fields').on('change', function () {
            extrafields($(this).val());
         })
         function extrafields(val) {
            $('.extra_field_title').hide();
            for (var i = 1; i <= val; i++) {
               $('#extra_field_title_' + i).parent().parent().show();
            }
         }

         show_thumb("{{old('is_extra_image_title_1', data_get($widget ?? null, 'is_extra_image_title_1', ''))}}");
         $('#is_extra_image_title_1').on('change', function () {
            show_thumb($(this).val());
         })

         function show_thumb(val) {
            if (val == 1) {
               $('.image_section').show();
            } else {
               $('.image_section').hide();
            }
         }

         show_thumb_2("{{old('is_extra_image_title_2', data_get($widget ?? null, 'is_extra_image_title_2', ''))}}");
         $('#is_extra_image_title_2').on('change', function () {
            show_thumb_2($(this).val());
         })

         function show_thumb_2(val) {
            if (val == 1) {
               $('.image_section_2').show();
            } else {
               $('.image_section_2').hide();
            }
         }

         radio_buttons("{{old('radio_buttons', data_get($widget ?? null, 'radio_buttons', ''))}}");
         $('#radio_buttons').on('change', function () {
            radio_buttons($(this).val());
         })
         function radio_buttons(val) {
            $('.extra_button_title').hide();
            for (var i = 1; i <= val; i++) {
               $('#radio_button_title_' + i).parent().parent().show();
            }
         }


      </script>

   @endpush