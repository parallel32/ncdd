$(function() {
    $('#mainTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#discoverTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#learnTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#discoverPageTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#learnPageTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#boardCertificationMenu a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#discover').click(function () {
        $('.discover').toggle();
         if( $('.learn:visible')) {
            $('.learn').hide();
        }
        else{}
    });
    $('#learn').click(function () {
        $('.learn').toggle();
        if( $('.discover:visible')) {
            $('.discover').hide();
        }
        else{}
    });
    $(".fullWidthDropDown .close").click(function () {
        $(this).closest('.fullWidthDropDown').hide();
    });
    $(".mapsPhone .dropdown-toggle").click(function() {
        $(".mapsPhone .mapsPhoneDropdown").toggleClass("open")
    });
    if( $('body').width() < 769 ) {
            $('.pager').insertAfter('aside').wrap('<div class="text-center"></div>');
        }
        else{
            $('.pager').insertAfter('.postBody:last').wrap('<div class="text-center"></div>');
        };
    $(window).resize(function(){
        if( $('body').width() < 769 ) {
            $('.pager').insertAfter('aside').wrap('<div class="text-center"></div>');
        }
        else{
            $('.pager').insertAfter('.postBody:last').wrap('<div class="text-center"></div>');
        };
    });
    $('.visible-phone .btn-navbar-phone').click(function(){
        $('.wrapper').toggleClass('menuVisible')
    });
    $("#archiveAccordion").collapse();
});