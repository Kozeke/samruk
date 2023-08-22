$(document).ready(function() {

  $("body").on('click', '.remove--complexe', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var section = $(this).attr('data-section');

		$.ajax({
			url: '/admin/settings/sections/' + section + '/calculator/' + id,
			type: 'DELETE',
			dataType: 'json',
			data : { _token: $('meta[name="_token"]').attr('content')},
			success: function(data) {
				if (data.success) {
					$("#complexe--item-" + id).remove();
					messageSuccess(data.success);
				} else {
					messageError(data.errors);
				}
			}
		});
  });

  $("body").on('click', '.remove--apartment', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var section = $(this).attr('data-section');
		var complex = $(this).attr('data-complex');

		$.ajax({
			url: '/admin/settings/sections/' + section + '/calculator/' + complex + '/apartment/' + id,
			type: 'DELETE',
			dataType: 'json',
			data : { _token: $('meta[name="_token"]').attr('content')},
			success: function(data) {
				if (data.success) {
					$("#apartment--item-" + id).remove();
					messageSuccess(data.success);
				} else {
					messageError(data.errors);
				}
			}
		});
  });

});
