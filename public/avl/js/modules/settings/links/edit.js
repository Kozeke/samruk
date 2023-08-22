$(document).ready(function() {

  $( "#datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    yearRange: "2000:",
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
  });

  $("body").on('click', '.deletePhoto', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id'),
        model      = self.data('model');
        lang      = self.data('lang');
    $.ajax({
        url: '/admin/ajax/deletePhotoLinks/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), model: model, lang: lang},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          } else {
            $("#link_photo-"+lang).empty();
          }
        }
    });
  });

});


function uploadPhoto(lang, section_id, link_id) {
  $('#upload--photos--'+lang).uploadifive({
    'auto' : true,
    'removeCompleted' : true,
    'buttonText'	: 'Выберите Изображение',
    'height'	    : '100%',
    'width'			: '100%',
    'checkScript'	: '/admin/ajax/check',
    'uploadScript'	: '/admin/ajax/links_photo',
    'fileType'		: 'image/*',
    'formData'		: {
      '_token'      : $('meta[name="_token"]').attr('content'),
      'section_id'  : section_id,
      'link_id'	  : link_id,
      'link_lang'	  : lang
    },
    'folder'		: '/uploads/tmps/',

    'onUploadComplete' : function( file, data ) {
      var $data = JSON.parse(data);
      if ($data.success) {
        var html =
        '<div class="card">'+
          '<div class="card-header text-right">'+
            '<a href="#" class="deletePhoto" data-model="Links" data-id="' + $data.file.id + '" data-lang="' + $data.file.lang + '"><i class="fa fa-trash-o"></i></a>'+
          '</div>'+
          '<div class="card-body p-0">'+
            '<img src="/image/resize/350/350/' + $data.file.image + '" style="width:100%">'+
          '</div>'+
        '</div>';
        $("#link_photo-"+lang).empty();
        $('#link_photo-'+lang).prepend(html);
      }

      if ($data.errors) {
        messageError($data.errors);
      }
    }
  });
}
