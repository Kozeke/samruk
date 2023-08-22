/*****
 * CONFIGURATION
 */

//Main navigation
$.navigation = $('nav > ul.nav');

$.panelIconOpened = 'icon-arrow-up';
$.panelIconClosed = 'icon-arrow-down';

//Default colours
$.brandPrimary = '#20a8d8';
$.brandSuccess = '#4dbd74';
$.brandInfo = '#63c2de';
$.brandWarning = '#f8cb00';
$.brandDanger = '#f86c6b';

$.grayDark = '#2a2c36';
$.gray = '#55595c';
$.grayLight = '#818a91';
$.grayLighter = '#d1d4d7';
$.grayLightest = '#f8f9fa';

'use strict';

/*****
 * ASYNC LOAD
 * Load JS files and CSS files asynchronously in ajax mode
 */

/****
 * AJAX LOAD
 * Load pages asynchronously in ajax mode
 */

if ($.ajaxLoad) {

    $(document).on('click', '.nav a[href!="#"]', function (e) {
        if ($(this).parent().parent().hasClass('nav-tabs') || $(this).parent().parent().hasClass('nav-pills')) {
            e.preventDefault();
        } else if ($(this).attr('target') == '_top') {
            e.preventDefault();
            var target = $(e.currentTarget);
            window.location = (target.attr('href'));
        } else if ($(this).attr('target') == '_blank') {
            e.preventDefault();
            var target = $(e.currentTarget);
            window.open(target.attr('href'));
        } else {
            e.preventDefault();
            var target = $(e.currentTarget);
            setUpUrl(target.attr('href'));
        }
    });

    $(document).on('click', 'a[href="#"]', function (e) {
        e.preventDefault();
    });
}

/****
 * MAIN NAVIGATION
 */

$(document).ready(function ($) {
    $("#adminMenu").treeview({
        animated: "fast",
        hitarea: "red",
        collapsed: true,
        control: "#treecontrol",
        persist: "cookie"
    });

    if ($('.timepicker').length) {
        $('.timepicker').timepicker({
            showAnim: 'blind',
            hourText: 'Часы',             // Define the locale text for "Hours"
            minuteText: 'Минуты',         // Define the locale text for "Minute"
            amPmText: ['', ''],
            minutes: {
                starts: 0,                // First displayed minute
                ends: 55,                 // Last displayed minute
                interval: 5               // Interval of displayed minutes
            },
        });
    }

    // Add class .active to current link - AJAX Mode off
    $.navigation.find('a').each(function () {

        var cUrl = String(window.location).split('?')[0];

        if (cUrl.substr(cUrl.length - 1) == '#') {
            cUrl = cUrl.slice(0, -1);
        }

        if ($($(this))[0].href == cUrl) {
            $(this).addClass('active');

            $(this).parents('ul').add(this).each(function () {
                $(this).parent().addClass('open');
            });
        }
    });

    // Dropdown Menu
    $.navigation.on('click', 'a', function (e) {

        if ($.ajaxLoad) {
            e.preventDefault();
        }

        if ($(this).hasClass('nav-dropdown-toggle')) {
            $(this).parent().toggleClass('open');
            resizeBroadcast();
        }
    });

    function resizeBroadcast() {

        var timesRun = 0;
        var interval = setInterval(function () {
            timesRun += 1;
            if (timesRun === 5) {
                clearInterval(interval);
            }
            window.dispatchEvent(new Event('resize'));
        }, 62.5);
    }

    var block = localStorage.getItem('display');
    if (block == 'true') {
        $('body').toggleClass('sidebar-hidden');
    }

    /* ---------- Main Menu Open/Close, Min/Full ---------- */
    $('.sidebar-toggler').click(function () {
        $('body').toggleClass('sidebar-hidden');

        localStorage.setItem('display', $('body').hasClass('sidebar-hidden'));

        resizeBroadcast();
    });

    $('.sidebar-minimizer').click(function () {
        $('body').toggleClass('sidebar-minimized');
        resizeBroadcast();
    });

    $('.brand-minimizer').click(function () {
        $('body').toggleClass('brand-minimized');
    });

    $('.aside-menu-toggler').click(function () {
        $('body').toggleClass('aside-menu-hidden');
        resizeBroadcast();
    });

    $('.mobile-sidebar-toggler').click(function () {
        $('body').toggleClass('sidebar-mobile-show');
        resizeBroadcast();
    });

    $('.sidebar-close').click(function () {
        $('body').toggleClass('sidebar-opened').parent().toggleClass('sidebar-opened');
    });

    /* ---------- Disable moving to top ---------- */
    $('a[href="#"][data-top!=true]').click(function (e) {
        e.preventDefault();
    });

    // custom__menu

    var itemsMenu = (localStorage.getItem('itemsMenu')) ? JSON.parse(localStorage.getItem('itemsMenu')) : [];
    if (itemsMenu && itemsMenu.length > 0) {
        $.each(itemsMenu, function (index, key) {
            $("#menu-list-item-" + key).addClass('active');
        })
    }

    if ($('.custom__menu').length) {
        $('li.menu-list-item .toggler').on('click', function () {
            var menuListItem = $(this).parent('.has-submenu').parent('.menu-list-item');
            if (menuListItem.hasClass('active')) {
                var index = itemsMenu.indexOf($(this).attr('data-id'));
                itemsMenu.splice(index, 1);

                menuListItem.removeClass('active');
            } else {
                if (itemsMenu.indexOf($(this).attr('data-id')) < 0) {
                    itemsMenu.push($(this).attr('data-id'));
                }
                menuListItem.addClass('active');
            }

            localStorage.setItem("itemsMenu", JSON.stringify(itemsMenu));
        });
    }

    /**
     *  Alert close
     */

    $('.alert .close').click(function () {
        $(this).parent('.alert').fadeOut(500, function () {
            $(this).remove();
        });
    });

    $("body").on('click', '.remove--record', function (e) {
        e.preventDefault();
        $(this).parents('.btn-group').next('.remove-message').show();
    });
    $("body").on('click', '.cancel', function (e) {
        e.preventDefault();
        $(this).parents('.remove-message').css('display', 'none');
    });

    $("body").on('click', '.change--status', function (e) {
        e.preventDefault();
        var self = $(this);
        var model = $(this).data('model');
        var id = $(this).data('id');
        var lang = $(this).data('lang');
        $.ajax({
            url: '/admin/ajax/good',
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="_token"]').attr('content'), id: id, model: model, lang: lang},
            success: function (data) {
                if (data.success) {
                    var fa = self.find('.fa');
                    if (fa.hasClass('fa-eye')) {
                        fa.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        fa.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                } else {
                    alert(data.errors);
                }
            }
        });
    });

    $("body").on('click', '.change--order', function (e) {
        e.preventDefault();
        var self = $(this);
        var id = $(this).data('id');
        var order = $("#change--order-" + id).val();

        $.ajax({
            url: '/admin/ajax/change-order',
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="_token"]').attr('content'), id: id, order: order},
            success: function (data) {
                if (data.success) {
                    messageSuccess(data.success);
                } else {
                    messageError(data.errors);
                }
            }
        });
    });

    $("body").on('click', '.change--status-menu', function (e) {
        e.preventDefault();
        var self = $(this);
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/ajax/menu',
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="_token"]').attr('content'), id: id},
            success: function (data) {
                if (data.success) {
                    var fa = self.find('.fa');
                    if (fa.hasClass('fa-eye')) {
                        fa.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        fa.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                } else {
                    alert(data.errors);
                }
            }
        });
    });

    if ($('textarea.tinymce').length) {
        tinymce.init({
            selector: 'textarea.tinymce',
            theme: "modern",
            language: "ru",
            width: '100%',
            height: 350,
            document_base_url: '/',
            relative_urls: false,
            convert_urls: true,
            fontsize_formats: '8px 10px 12px 14px 18px 24px 36px',
            plugins: [
                "addsign advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor filemanager",
            ],
            image_advtab: true,
            menubar: false,
            extended_valid_elements: 'iframe[*],div[*],p[*],span[*],a[*],img[*],b[*],strong[*],i[*],svg[*]',
            toolbar: [
                "undo redo | styleselect formatselect fontsizeselect | cut copy paste | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify pagebreak | bullist numlist outdent indent blockquote ",
                "link unlink anchor insertfile image | preview media fullscreen | removeformat | subscript superscript | forecolor backcolor charmap emoticons filemanager code my-section-gray"
            ],
            external_filemanager_path: "/avl/js/tinymce/plugins/filemanager/",
            filemanager_title: "Responsive Filemanager",
            external_plugins: {"filemanager": "/avl/js/tinymce/plugins/filemanager/plugin.min.js"},
            table_class_list: [
                {title: 'None', value: ''},
                {title: 'Тема #1 (Для контактов)', value: 'table-type-1 js-table-no-wrap'},
            ],
            setup: function (ed) {
                ed.addButton('my-section-gray', {
                    text: 'Добавить серый блок',
                    icon: false,
                    onclick: function () {
                        var text = ed.selection.getContent({
                            'format': 'html'
                        });
                        if (text && text.length > 0) {
                            ed.execCommand('mceInsertContent', false, '<div class="formatted-section-gray">' + text + '</div>');
                        } else {
                            ed.execCommand('mceInsertContent', false, '<div class="formatted-section-gray"><p>Серый блок</p></div>');
                        }
                    }
                });
            }
        });
    }

    $("body").on('change', '.change--area-control', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/admin/ajax/change-area/' + $(this).val(),
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="_token"]').attr('content')},
            success: function (data) {
                if (data.success) {
                    // location.reload();
                    document.location.href = "/admin";
                } else {
                    messageError(data.errors);
                }
            }
        });
    });

});


function tinymce_mini(element) {
    tinymce.init({
        selector: 'textarea.' + element,
        theme: "modern",
        language: "ru",
        width: '100%',
        height: 145,
        document_base_url: '/',
        relative_urls: false,
        convert_urls: true,
        fontsize_formats: '8px 10px 12px 14px 18px 24px 36px',
        plugins: [
            "addsign advlist autolink link print hr spellchecker",
            "searchreplace wordcount visualblocks visualchars code insertdatetime",
            "save table contextmenu directionality template paste textcolor",
        ],
        menubar: false,
        extended_valid_elements: 'iframe[*],div[*],p[*],span[*],a[*],img[*],b[*],strong[*]',
        toolbar: [
            "undo redo | formatselect | fontsizeselect | link unlink ",
            "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | removeformat code"
        ],
    });
}


function alertClose() {
    setTimeout(function () {
        $(".messages .alert").fadeOut(400, function () {
            $(this).remove();
        });
    }, 4000);
}

function messageError(error) {
    var errors = '';
    $.each(error, function (index, value) {
        errors += '<div class="alert alert-danger border border-danger">' +
            '<p class="m-0">' + value + '</p>' +
            '<button type="button" class="close">' +
            '<span aria-hidden="true">×</span>' +
            '</button>' +
            '</div>';
    });
    $('#messages').html(errors).fadeIn();
    alertClose();
    return true;
}

function messageSuccess(success) {
    var messages = '';
    $.each(success, function (index, value) {
        messages += '<div class="alert alert-success border border-success">' +
            '<p class="m-0">' + value + '</p>' +
            '<button type="button" class="close">' +
            '<span aria-hidden="true">×</span>' +
            '</button>' +
            '</div>';
    });
    $('#messages').html(messages).fadeIn();
    alertClose();
    return true;
}
