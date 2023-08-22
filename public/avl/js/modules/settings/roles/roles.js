$(document).ready(function() {
  $('body').on('click', '.remove--role', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      url: '/admin/settings/roles/' + id,
      type: 'DELETE',
      dataType: 'json',
      data : { _token: $('meta[name="_token"]').attr('content'), id: id},
      success: function(data) {
        if (data.success) {
          $("#role--" + id).remove();
          messageSuccess(data.success);
        } else {
          messageError(data.errors);
        }
      }
    });
  });

  $('.check-all').on('click', function (e) {
    e.preventDefault();
    var self = $(this);
    var type = $(this).attr('data-type');

    var inputs = $(".switch--input-"+ type);
    $.each(inputs, function (index, element) {
      if (self.hasClass('checked')) {
        $(element).attr('checked', false);
      } else {
        $(element).attr('checked', true);
      }
    });

    if (self.hasClass('checked')) {
      self.removeClass('checked');
    } else {
      self.addClass('checked');
    }
  });

});
