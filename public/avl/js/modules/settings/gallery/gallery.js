$(document).ready(function() {

  $("#datepicker").datepicker({
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
      handle: 'img',
      opacity: 0.8,
      dropOnEmpty: false,
      placeholder: "sortable-placeholder",

      stop: function(event, ui) {
          var sort = $("#sortable").sortable("serialize");
          $.get('/admin/ajax/'+ $("#gallery_id").val() +'/gallery-sortable?' + sort, {
              _token:$('meta[name="_token"]').attr('content'),
              sort: sort,
              gallery_id: $("#gallery_id").val()
          });

          $("#" + ui.item.attr('id')).find('textarea').each(function () {
            tinymce.get($(this).attr('id')).destroy();

            tinymce_mini('tinymce-mini');
          });
      }
  });

  $("#sortable").disableSelection();

  $('#upload--photos').uploadifive({
      'auto'			: true,
      'removeCompleted' : true,
      'buttonText'	: 'Выберите Изображение',
      'height'	    : '100%',
      'width'			: '100%',
      'checkScript'	: '/admin/ajax/check',
      'uploadScript'	: '/admin/ajax/gallery-images',
      'fileType'		: 'image/*',
      'formData'		: {
          '_token'      : $('meta[name="_token"]').attr('content'),
          'gallery_id'	: $('#gallery_id').val()
       },
      'folder'		: '/uploads/tmps/',

      'onUploadComplete' : function( file, data ) {
          var $data = JSON.parse(data);
          if ($data.success) {
              var html =
              '<li id="gallerySortable_' + $data.file.id + '" class="col-md-6 mb-3 float-left ui-sortable-handle">'+
                '<div class="col-12">'+
                  '<div class="row border p-2">'+
                    '<div class="col-12 col-md-12 col-lg-4 p-0">' +
                      '<div class="card mb-0">'+
                        '<div class="card-header p-2">'+
                          '<div class="row">'+
                            '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-eye"></i></a> </div>'+
                            '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="toMainPhoto" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-circle-o"></i></a> </div>'+
                            '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMediaGallery" data-model="Media" data-id="' + $data.file.id + '"><i class="fa fa-trash-o"></i></a> </div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="card-body p-0"><img src="/image/resize/260/230/' + $data.file.src + '"></div>'+
                      '</div>'+
                    '</div>'+
                    '<div class="col-12 col-md-12 col-lg-8 p-0">' +
                      '<div class="card mb-0">' +
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
                                              '<textarea class="form-control tinymce-mini border-0 media--' + $data.file.id + '" data-lang="' + $value.key + '" placeholder="' + $value.key + '">'+ ($data['file']['title_' + $value.key] ? $data['file']['title_' + $value.key] : '') +'</textarea>'+
                                              '<button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="' + $data.file.id + '">Save</button>'+
                                            '</div>';
                                });
                            html += '</div>'+
                        '</div>'+

                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</li>';

              $('#sortable').prepend(html);
              tinymce_mini('tinymce-mini');
          }

          if ($data.errors) {
              messageError($data.errors);
          }
      }
  });

  $("body").on('click', '.toMainPhoto', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id');

    $.ajax({
        url: '/admin/ajax/mainPhotoGallery/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), gallery_id: $("#gallery_id").val()},
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

  $("body").on('click', '.deleteMediaGallery', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id'),
        model      = self.data('model');
    $.ajax({
        url: '/admin/ajax/deleteMediaGallery/'+ id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), model: model},
        success: function(data) {
            if (data.errors) {
                messageError(data.errors);
            } else {
                self.parents('#gallerySortable_' + id).remove();
            }
        }
    });
  });

  $("body").on('click', '.save--video_link', function(e) {
    e.preventDefault();
    var gallery_id = $("#gallery_id").val();
    var title      = $("#title_video").val();
    var link       = $("#link_video").val();
    var lang       = $("#select--language-video").val();

    $.ajax({
        url: '/admin/ajax/addGalleryVideo',
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), title: title, lang: lang, link: link, gallery_id: gallery_id},
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

  $("body").on('click', '.save--media-content', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.attr('data-id');
    var elements = $("textarea.media--" + id);
    var translates = {};
    $.each(elements, function(key, element) {
      translates[$(this).attr('data-lang')] = tinymce.get($(this).attr('id')).getContent();
    });

    $.ajax({
        url: '/admin/ajax/news-images/' + id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content'), translates: translates},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          }
          if (data.success) {
            messageSuccess(data.success);
          }
        }
    });
  });

});
