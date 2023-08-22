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

  $("#sortable").sortable({
      opacity: 0.6,
      handle: 'img',
      stop: function(event, ui) {
          var sort = $("#sortable").sortable("serialize");
          $.get('/admin/ajax/'+ $("#section_id").val() +'/media-sortable?' + sort, {
              _token:$('meta[name="_token"]').attr('content'),
              sort: sort,
              news_id: $("#news_id").val()
          }, function(data) {

          });
      }
  });

  $("#sortable-files").sortable({
    opacity: 0.6,
    stop: function(event, ui) {
      var sort = $("#sortable-files").sortable("serialize");
      $.get('/admin/ajax/'+ $("#section_id").val() +'/media-sortable?' + sort, {
          _token:$('meta[name="_token"]').attr('content'),
          sort: sort,
          type: 'file',
          news_id: $("#news_id").val()
      });
    }
  });


  $('#upload--photos').uploadifive({
      'auto'			: true,
      'removeCompleted' : true,
      'buttonText'	: 'Выберите Изображение',
      'height'	    : '100%',
      'width'			: '100%',
      'checkScript'	: '/admin/ajax/check',
      'uploadScript'	: '/admin/ajax/news-images',
      'fileType'		: 'image/*',
      'formData'		: {
          '_token'      : $('meta[name="_token"]').attr('content'),
          'section_id'  : $('#section_id').val(),
          'news_id'	  : $('#news_id').val()
       },
      'folder'		: '/uploads/tmps/',

      'onUploadComplete' : function( file, data ) {
          var $data = JSON.parse(data);
          if ($data.success) {
              var html =
              '<li id="mediaSortable_' + $data.file.id + '" class="col-md-2 float-left ui-sortable-handle">'+
                  '<div class="card">'+
                      '<div class="card-header">'+
                        '<div class="row">'+
                          '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-eye"></i></a> </div>'+
                          '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="toMainPhoto" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-circle-o"></i></a> </div>'+
                          '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMedia" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-trash-o"></i></a> </div>'+
                        '</div>'+
                      '</div>'+
                      '<div class="card-body p-0">'+
                        '<img src="/image/resize/260/230/' + $data.file.src + '">' +
                        '<div class="col-12">' +
                          '<div class="row bg-light p-2">';
                            $.each($data.file.langs, function($key, $value) {
                              html += '<div class="col-lg-4 col-md-4 col-sm-4 text-center">'+
                                        '<a href="#" class="change--switch" data-lang="'+ $value.key +'" data-id="'+ $data.file.id +'">'+
                                          '<i class="icon--language icon--language-'+ $value.key +'"></i>'+
                                        '</a>'+
                                      '</div>';
                            });
                          html += ''+
                          '</div>'+
                        '</div>'+
                      '</div>'+
                      '<div class="card-footer p-0 bg-white">'+
                            '<ul class="nav nav-tabs">';
                              $.each($data.file.langs, function($key, $value) {
                                  var active = ($value.key == 'ru') ? 'active show' : '';
                                  html += '<li class="nav-item p-0">'+
                                  '<a class="nav-link ' + active + '" href="#tab--title-item-' + $data.file.id + '-' + $value.key + '" data-toggle="tab" aria-expanded="false">'+
                                      $value.key +
                                  '</a></li>';
                              });
                            html +=
                            '</ul>'+
                            '<div class="tab-content">';
                                $.each($data.file.langs, function($key, $value) {
                                    var active = ($value.key == 'ru') ? 'active' : '';
                                    html += '<div class="p-0 tab-pane ' + active + '" id="tab--title-item-' + $data.file.id + '-' + $value.key + '">'+
                                              '<textarea class="form-control border-0 media--' + $data.file.id + '" data-lang="' + $value.key + '" placeholder="' + $value.key + '">'+ $value.key +'</textarea>'+
                                              '<button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="' + $data.file.id + '">Save</button>'+
                                            '</div>';
                                });
                            html += '</div>'+
                      '</div>'+
                  '</div>'+
              '</li>';
              $('#sortable').prepend(html);
          }

          if ($data.errors) {
              messageError($data.errors);
          }
      }
  });

  $("body").on('click', '.change--switch', function (e) {
      e.preventDefault();
      var self = $(this);
      var id = $(this).data('id');
      var lang = $(this).data('lang');
      $.ajax({
        url: '/admin/ajax/change-switch',
        type: 'POST',
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), id: id, lang: lang},
        success: function(data) {
          if (data.success) {
            var fa = self.find('.icon--language');
            if (fa.hasClass('disabled')) {
              fa.removeClass('disabled');
            } else {
              fa.addClass('disabled');
            }
          } else {
            alert(data.errors);
          }
        }
      });
  });

  // upload files
  $('#upload--files').uploadifive({
        'auto'			: true,
        'removeCompleted' : true,
        'buttonText'	: 'Выберите файл для загрузки',
        'height'	    : '100%',
        'width'			: '100%',
        'checkScript'	: '/admin/ajax/check',
        'uploadScript'	: '/admin/ajax/news-files',
        'folder'		: '/uploads/tmps/',
        'onUpload'     : function(filesToUpload) {
            $('#upload--files').data('uploadifive').settings.formData = {
                '_token'      : $('meta[name="_token"]').attr('content'),
                'section_id'  : $('#section_id').val(),
                'news_id'	  : $('#news_id').val(),
                'lang'        : $("#select--language-file").val()
            };
        },
        'onUploadComplete' : function( file, data ) {
            var $data = JSON.parse(data);
            if ($data.success) {
                var html =
                  '<li class="col-md-12 list-group-item files--item" id="mediaSortable_' + $data.file.id + '">'+
                    '<div class="img-thumbnail">'+
                      '<div class="input-group">'+
                        '<div class="input-group-prepend">'+
                          '<span class="input-group-text" style="cursor: move;"><img src="/avl/img/icons/flags/' + $data.file.lang + '--16.png" alt=""></a></span>'+
                          '<span class="input-group-text"><a href="#" class="good" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-eye"></i></a></span>'+
                          '<span class="input-group-text"><a href="/file/save/' + $data.file.id + '" target="_blank"><i class="fa fa-download"></i></a></span>'+
                          '<span class="input-group-text"><a href="#" class="deleteMedia" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-trash-o"></i></a></span>'+
                        '</div>'+
                        '<input type="text" id="title--' + $data.file.id + '" class="form-control" name="" value="' + $data.file['title_' + $data.file.lang] + '">'+
                        '<div class="input-group-append">'+
                          '<span class="input-group-text"><a href="#" class="save--file-name" data-id="' + $data.file.id + '"><i class="fa fa-floppy-o"></i></a></span>'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</li>';
                $('#sortable-files').prepend(html);
            }

            if ($data.errors) {
                messageError($data.errors);
            }
        }
    });

  $("body").on('click', '.toMainPhoto', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id'),
        model      = self.data('model');
    $.ajax({
        url: '/admin/ajax/mainPhoto/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), news_id: $("#news_id").val(), model: model},
        success: function(data) {
            if (data.errors) {
                messageError(data.errors);
            } else {
                $(".toMainPhoto i.fa").removeClass('fa-check-circle-o').addClass('fa-circle-o');
                self.find('i.fa').removeClass('fa-circle-o').addClass('fa-check-circle-o');
            }
        }
    });
  });

  $("body").on('click', '.deleteMedia', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id'),
        model      = self.data('model');
    $.ajax({
        url: '/admin/ajax/deleteMedia/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), model: model},
        success: function(data) {
            if (data.errors) {
                messageError(data.errors);
            } else {
                self.parents('#mediaSortable_' + id).remove();
            }
        }
    });
  });

  $("body").on('click', '.change--lang', function(e) {
    e.preventDefault();
    var self = $(this);
    var id = self.attr('data-id');

    $.ajax({
        url: '/admin/ajax/change-file-lang/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content')},
        success: function(data) {
            if (data.errors) {
                messageError(data.errors);
            } else {
                self.find('img').attr('src', '/avl/img/icons/flags/' + data.file.key + '--16.png');
            }
        }
    });

  });

  // Save filename
  $("body").on('click', '.save--file-name', function(e) {
    e.preventDefault();
    var id         = $(this).attr('data-id');
    var title      = $("#title--" + id).val();
    console.log(title);

    $.ajax({
        url: '/admin/ajax/saveFileName/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), title: title},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          } else {
            messageSuccess(data.success);
          }
        }
    });
  });


  $("body").on('click', '.save--video_link', function(e) {
    e.preventDefault();
    var id         = $(this).attr('data-id');
    var news_id         = $(this).attr('data-news_id');
    var title      = $("#title_video").val();
    var link      = $("#link_video").val();
    var lang      = $("#select--language-video").val();

    $.ajax({
        url: '/admin/ajax/saveVideoLink',
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), title: title, lang: lang, link: link, id: id, news_id: news_id},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          } else {

              var html =
              '<li class="col-md-12 list-group-item files--item" id="videoSortable_'+ data.file.id +'">'+
                '<div class="img-thumbnail">'+
                  '<div class="input-group">'+
                    '<div class="input-group-prepend">'+
                      '<span class="input-group-text" style="cursor: move;"><img src="/avl/img/icons/flags/'+ data.file.lang +'--16.png" alt=""></a></span>'+
                      '<span class="input-group-text"><a href="#" class="change--status" data-model="Media" data-id="'+ data.file.id +'"><i class="fa fa-eye"></i></a></span>'+
                      '<span class="input-group-text"><a href="#" class="deleteVideo" data-model="Media" data-id="'+ data.file.id +'"><i class="fa fa-trash-o"></i></a></span>'+
                    '</div>'+
                    '<input type="text" id="title--'+ data.file.id +'" class="form-control" value="' + data.file['title_' + data.file.lang] +'">'+
                    '<input type="text" id="link--'+ data.file.id +'" class="form-control" value="'+ data.file.link +'">'+
                    '<div class="input-group-append">'+
                      '<span class="input-group-text"><a href="#" class="update--video" data-id="'+ data.file.id +'"><i class="fa fa-floppy-o"></i></a></span>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</li>';

            messageError(data.errors);
            messageSuccess(data.success);
            $('#sortable-video').prepend(html);
            $("#title_video").val('');
            $("#link_video").val('');
          }
        }
    });
  });

  $("body").on('click', '.update--video', function(e) {
    e.preventDefault();
    var id         = $(this).attr('data-id');
    var title      = $("#title--" + id).val();
    var link      = $("#link--" + id).val();

    $.ajax({
        url: '/admin/ajax/updateVideoLink/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), title: title, link: link},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          } else {
            messageSuccess(data.success);
          }
        }
    });
  });

  $("body").on('click', '.deleteVideo', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id'),
        model      = self.data('model');
    $.ajax({
        url: '/admin/ajax/deleteVideo/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), model: model},
        success: function(data) {
            if (data.errors) {
                messageError(data.errors);
            } else {
                messageSuccess(data.success);
                self.parents('#videoSortable_' + id).remove();
            }
        }
    });
  });

  $("body").on('click', '.add--area-sections', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('area');

    $.ajax({
        url: '/admin/ajax/add-area-sections/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content') },
        success: function (data) {

					var html = '<div class="input-group mb-3">' +
												'<select name="sections['+ id +'][]" class="form-control d-inline">' +
													'<option selected value="0">------</option>' +
													data.view +
												'</select>' +
												'<div class="input-group-prepend">' +
													'<a href="#" class="btn btn-danger remove--area-sections" data-area="'+ id +'"><i class="fa fa-trash"></i></a>' +
												'</div>' +
											'</div>';
					// console.log(html);
					$(".col-sections-add-" + id).append(html);
        }
    });
  });

	$("body").on('click', '.remove--area-sections', function(e) {
		e.preventDefault();
		var self       = $(this),
				id         = self.data('area');

		self.parents('.input-group').remove();
	});


  // $("body").on('click', '.save--media-content', function(e) {
  //   e.preventDefault();
  //   var self       = $(this),
  //       id         = self.data('id');
  //   var elements = $("textarea.media--" + id);
  //   var translates = {};
  //   $.each(elements, function(key, element) {
  //     translates[$(this).data('lang')] = $(this).val();
  //   });
  //
  //   $.ajax({
  //       url: '/admin/ajax/news-images/' + id,
  //       type: 'POST',
  //       async: false,
  //       dataType: 'json',
  //       data : { _token: $('meta[name="_token"]').attr('content'), translates: translates},
  //       success: function(data) {
  //         if (data.errors) {
  //           messageError(data.errors);
  //         }
  //         if (data.success) {
  //           messageSuccess(data.success);
  //         }
  //       }
  //   });
  // });

});
