
jQuery(document).ready(function($) {
    $('#mobile-bottom-menu .menu-item').on('click', function(e) {
        e.preventDefault();
        $('#mobile-bottom-menu .menu-item').removeClass('active').css('background-color', '');
        $(this).addClass('active');

        let color = $(this).data('color');
        $(this).css('background-color', color);
        $('#mobile-bottom-menu').css('background-color', color);
    });
});
