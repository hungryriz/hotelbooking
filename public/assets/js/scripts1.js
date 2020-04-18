$(document).ready(function() {

    var $window = $(window);

    function setCSS() {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();

        // var  secRight= $(".sec-sub-content").outerHeight(true);
        // var productImgTop = (productImg - productImgBtm);
        // var cartHeadFoot = (cartFoot + cartHead);
        // var cartContent = (sidebarWrapper - cartHeadFoot);

        var disRight = $(".dis-right").outerHeight(true);

        // $('#basic-map').height( $(window).height() - 200 );
        $('.dis-left').css('height', disRight);

        // $('.sec-img').css('min-height', secRight);
        // $('.testi-block-left').css('min-height', testiRight);
        // $('.login-left-img').css('min-height', logBg + 'px');
        // $('.cart-count-block-top').css('height', productImgTop + 'px');
    };

    setCSS();
    $(window).on('load resize', function() {
        setCSS();
    });
});

// Rating
$('.rating').rating({
    filled: 'fa fa-star',
    empty: 'fa fa-star-o'
});

$(function() { 
    //$('.editor').froalaEditor() 
    $('.editor').froalaEditor({
    // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikeThrough','fontSize','align','paragraphFormat','subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', 'html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic', 'underline']
    });
});