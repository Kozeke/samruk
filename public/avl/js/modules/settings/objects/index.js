$(document).ready(function() {

  $('body').on('click', '.remove--object', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var section = $(this).attr('data-section');

    $.ajax({
      url: '/admin/settings/sections/' + section + '/objects/' + id,
      type: 'DELETE',
      dataType: 'json',
      data : { _token: $('meta[name="_token"]').attr('content')},
      success: function(data) {
        if (data.success) {
          $("#objects--item-" + id).remove();
          messageSuccess(data.success);
        } else {
          messageError(data.errors);
        }
      }
    });
  });

});
