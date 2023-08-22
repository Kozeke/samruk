$(document).ready(function() {
  
  $("body").on('click', '.removeLang', function (e) {
      e.preventDefault();
      var id = $(this).data('id');

      $.ajax({
          url: '/admin/settings/langs/' + id,
          type: 'DELETE',
          async: false,
          dataType: 'json',
          data : { _token: $('meta[name="_token"]').attr('content')},
          success: function(data) {
            if (data.success) {
              $("#lang--item-" + id).remove();
              messageSuccess(data.success);
            } else {
              messageError(data.errors);
            }
          }
      });
  });

  $("body").on('click', '.refresh', function (e) {
      e.preventDefault();

      $.ajax({
          url: '/admin/settings/langs/refresh',
          type: 'POST',
          async: false,
          dataType: 'json',
          data : { _token: $('meta[name="_token"]').attr('content')},
          success: function(data) {
            if (data.success) {
              messageSuccess(data.success);
            } else {
              messageError(data.errors);
            }
          }
      });
  });

});
