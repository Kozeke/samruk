$(document).ready(function () {
  $('#upload--photos').uploadifive({
      'auto'			: true,
      'removeCompleted' : true,
      'buttonText'	: 'Выберите Изображение',
      'height'	    : '100%',
      'width'			: '100%',
      'checkScript'	: '/admin/ajax/check',
      'uploadScript'	: '/admin/ajax/page-images',
      'fileType'		: 'image/*',
      'formData'		: {
          '_token'      : $('meta[name="_token"]').attr('content'),
          'section_id'  : $('#section_id').val()
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
                          '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="PagesMedia" data-id="' + $data.file.id + '"><i class="fa fa-eye"></i></a> </div>'+
                          '<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMedia" data-model="PagesMedia" data-id="' + $data.file.id + '"><i class="fa fa-trash-o"></i></a> </div>'+
                        '</div>'+
                      '</div>'+
                      '<div class="card-body p-0"><img src="/image/resize/260/230/' + $data.file.src + '"></div>'+
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
                                              '<input class="form-control border-0 media--' + $data.file.id + '" type="text" value="" data-lang="' + $value.key + '" placeholder="' + $value.key + '">'+
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

  $("body").on('click', '.save--media-content', function(e) {
    e.preventDefault();
    var self       = $(this),
        id         = self.data('id');
    var elements = $("input.media--" + id);

    var translates = {};
    $.each(elements, function(key, element) {
      translates[$(this).data('lang')] = $(this).val();
    });

    $.ajax({
        url: '/admin/ajax/page-images/' + id,
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

  $("body").on('click', '.change--image-panel', function(e) {
    e.preventDefault();
    var self = $(this),
        id   = self.data('id');

    $.ajax({
        url: '/admin/ajax/page-images-panel/' + id,
        type: 'POST',
        async: false,
        dataType: 'json',
        data : { _token: $('meta[name="_token"]').attr('content')},
        success: function(data) {
          if (data.errors) {
            messageError(data.errors);
          }
          if (data.success) {
            self.html(data.slider);
            messageSuccess(data.success);
          }
        }
    });
  });

});
