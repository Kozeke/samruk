$(document).ready(function() {
  $("body").on('change', '#template_template', function (e) {
      e.preventDefault();
      var self = $(this);
      $.ajax({
          url: '/admin/settings/templates/get-files',
          type: 'POST',
          async: false,
          dataType: 'json',
          data : { _token: $('meta[name="_token"]').attr('content'), type: $(this).val()},
          success: function(data) {
            $("#template_file_short").html(toHtml(data.shortFiles));
            $("#template_file_full").html(toHtml(data.fullFiles));
            $("#template_file_col").html(toHtml(data.colFiles));
            $("#template_file_category").html(toHtml(data.categoryFiles));
          }
      });
  });


  $("body").on('click', '.removeTemplate', function (e) {
      e.preventDefault();
      var id = $(this).data('id');

      $.ajax({
          url: '/admin/settings/templates/' + id,
          type: 'DELETE',
          async: false,
          dataType: 'json',
          data : { _token: $('meta[name="_token"]').attr('content')},
          success: function(data) {
            if (data.success) {
              $("#template--" + id).remove();
              messageSuccess(data.success);
            } else {
              messageError(data.errors);
            }
          }
      });
  });


});

function toHtml (files) {
  var options = '<option value="0">Выберите шаблон</option>';
  $.each(files, function(key, file) {
    options += '<option value="'+ file.filename +'">'+ file.filename +'</option>';
  });
  return options;
}
