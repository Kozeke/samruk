$(document).ready(function() {
  $( "#datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    yearRange: "1960:",
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
  });

  $('#profile--photo').uploadifive({
    'auto' : true,
    'multi' : false,
    'removeCompleted' : true,
    'buttonText'	: 'Выберите фото',
    'height'	    : '100%',
    'width'			: '100%',
    'checkScript'	: '/admin/ajax/check',
    'uploadScript'	: '/admin/ajax/profile',
    'fileType'		: 'image/*',
    'formData'		: {
        '_token'	: $('meta[name="_token"]').attr('content'),
        'user_id'	: $("#user_edit").data('id')
     },
    'folder'		: '/uploads/tmps/',

    'onUploadComplete' : function( file, data ) {
        var $data = JSON.parse(data);
        if ($data.errors == false) {
          var d = new Date();
          $('#user-photo').attr('src', $data.file.image + '?d=' + d.getMilliseconds());
        } else {
          messageError($data.messages);
        }

    }
  });
});
