$(document).ready(function() {
  $("body").on('change', '.section_type', function (e) {
      e.preventDefault();
      var self = $(this);
      $.ajax({
          url: '/admin/settings/templates/get-templates',
          type: 'POST',
          async: false,
          dataType: 'json',
          data : { _token: $('meta[name="_token"]').attr('content'), type: $(this).val()},
          success: function(data) {
            $(".section_template").html(toHtml(data.templates));
          }
      });
  });
});

function toHtml (templates) {
  var options = '<option value="0">Выберите шаблон</option>';
  $.each(templates, function(key, template) {
    options += '<option value="'+ template.id +'">'+ template.title +'</option>';
  });
  return options;
}
