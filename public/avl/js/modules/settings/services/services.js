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

  if ($("#map").length) {
    ymaps.ready(init);
  }

});

// center: [51.128433, 71.430546],
function init() {
  var myMap, myPlacemark;

  var defaultCoords = $("#services_coords").val().split(',');

  myMap = new ymaps.Map("map", {
      center: defaultCoords,
      zoom: 11,
  });

  myPlacemark = new ymaps.Placemark(defaultCoords, {}, {
      draggable: true
  });
  myMap.geoObjects.add(myPlacemark);

  myPlacemark.events.add("dragend", function (e) {
    coords = this.geometry.getCoordinates();
    updateCoordsInput (coords);
  }, myPlacemark);

  myMap.events.add('click', function (e) {
    var coords = e.get('coords');
    myPlacemark.geometry.setCoordinates(coords);
    updateCoordsInput (coords);
  });

}

function updateCoordsInput (coords) {
  $("#services_coords").attr("value", coords);
}
