$( ".order-box" ).click(function() {
	if ($('.order-box').hasClass('active')) {
		$('.order-box').removeClass('active'),
    	$(this).addClass('active');
	}
});

$(document).ready(function() {

    var $window = $(window);

    function setCSS() {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();

        // var  secRight= $(".sec-sub-content").outerHeight(true);
        // var cartHeadFoot = (cartFoot + cartHead);
        // var cartContent = (sidebarWrapper - cartHeadFoot);

        var pageHeader = $(".page-header").outerHeight(true);
        var orderlistSection = (windowHeight - pageHeader);

        // $('#basic-map').height( $(window).height() - 200 );
        // $('.dis-left').css('height', disRight);

        $('.win-height').css('height', orderlistSection);
        // $('.testi-block-left').css('min-height', testiRight);
        // $('.login-left-img').css('min-height', logBg + 'px');
        // $('.cart-count-block-top').css('height', productImgTop + 'px');
    };

    setCSS();
    $(window).on('load resize', function() {
        setCSS();
    });
});