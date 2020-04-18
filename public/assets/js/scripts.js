$(document).ready(function() {

    var $window = $(window);

    function setCSS() {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();

        var disRight = $(".dis-right").outerHeight(true);
        var pageHeader = $(".page-header").outerHeight(true);
        var orderlistSection = (windowHeight - pageHeader);

        // $('#basic-map').height( $(window).height() - 200 );
        $('.dis-left').css('height', disRight);
        $('.win-height').css('height', orderlistSection);
        $('.login').css('min-height', windowHeight);

    };

    setCSS();
    $(window).on('load resize', function() {
        setCSS();
    });
});

// Dipute JQuery
$(".order-box").click(function() {
    if ($('.order-box').hasClass('active')) {
        $('.order-box').removeClass('active'),
            $(this).addClass('active');
    }
});