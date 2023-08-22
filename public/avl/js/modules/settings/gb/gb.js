$(document).ready(function() {
	
	if ($("#datepicker").length) {
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
	}

	$('body').on('click', '.remove--gb', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var section = $(this).attr('data-section');

		$.ajax({
			url: '/admin/settings/sections/' + section + '/gb/' + id,
			type: 'DELETE',
			dataType: 'json',
			data : { _token: $('meta[name="_token"]').attr('content')},
			success: function(data) {
				if (data.success) {
					$("#gb--item-" + id).remove();
					messageSuccess(data.success);
				} else {
					messageError(data.errors);
				}
			}
		});
	});

});
