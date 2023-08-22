$(document).ready(function() {
  if ($('.custom__menu').length) {
    $('li.menu-list-item .toggler').on('click', function() {
      if (!$(this).hasClass('active')) {
        $(this).addClass('active')
        $(this).parents('.has-submenu').next('ul').slideDown();
      } else {
        $(this).removeClass('active')
        $(this).parents('.has-submenu').next('ul').slideUp();
      }
    });
  }
});
