$(document).ready(function() {

  $('.datetimepicker').datetimepicker({
    lang: 'ru',
  	formatTime:'H:i',
  	formatDate:'Y-m-d',
  	step: 5,
  	timepickerScrollbar:true,
    onChangeDateTime:function(dp,$input) {

      var newDate = dateFormat(dp, "yyyy-mm-dd HH:MM");

      $.ajax({
        url: '/admin/ajax/change-news-date/' + $input.attr('data-id'),
        type: 'POST',
        dataType: 'json',
        data : {
          _token: $('meta[name="_token"]').attr('content'),
          published: newDate
        },
        success: function(data) {
          if (data.success) {
            $input.parents('.change--datetime').find('span').html(data.published);
            $input.val(data.published);
            messageSuccess(data.success);
          } else {
            messageError(data.errors);
          }
        }
      });
    }
  });

  $('body').on('click', '.remove--news', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var section = $(this).attr('data-section');

    $.ajax({
      url: '/admin/settings/sections/' + section + '/news/' + id,
      type: 'DELETE',
      dataType: 'json',
      data : { _token: $('meta[name="_token"]').attr('content')},
      success: function(data) {
        if (data.success) {
          $("#news--item-" + id).remove();
          messageSuccess(data.success);
        } else {
          messageError(data.errors);
        }
      }
    });
  });

  $('body').on('click', '.change--fixed', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var self = $(this);

    $.ajax({
      url: '/admin/ajax/fixedNews/' + id,
      type: 'POST',
      dataType: 'json',
      data : { _token: $('meta[name="_token"]').attr('content')},
      success: function(data) {
        if (data.success) {
          var fa = self.find('.fa');
          if (fa.hasClass('fa-check-circle-o')) {
            fa.removeClass('fa-check-circle-o').addClass('fa-circle-o');
          } else {
            fa.removeClass('fa-circle-o').addClass('fa-check-circle-o');
          }
          messageSuccess(data.success);
        } else {
          messageError(data.errors);
        }
      }
    });
  });
});
