(function ($) {
    var ww = $(window).width();
    var wh = $(window).height();
    var windowResize_t;
    var $logoImg = $('.header-wrapper .header-container .logo img.x1');
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
    if (frontendData.enableSticky) {
        $("#main-header").sticky({ topSpacing: 0 });
        $("#mobile-sticky").sticky({ topSpacing: 0 });
    }
    if (pixelRatio > 1) {
        if($('.cms-index-index').length>0){ 
            $logoImg.attr('src', $logoImg.attr('src').replace(frontendData.logoHome, frontendData.logoHomeRetina));
        }else{
            $logoImg.attr('src', $logoImg.attr('src').replace(frontendData.logo, frontendData.logoRetina));
        }
    }

    $(".header-maincart .cart-content").mCustomScrollbar({
        scrollInertia:150,
        scrollButtons:{
            enable:true
        }
    });
    
    if (pixelRatio > 1) {
        $('img[data-srcX2]').each(function () {
            if ($(this).hasClass('lazy') || $(this).hasClass('lazyOwl')) {
                return;
            } else {
                $(this).attr('src', $(this).attr('data-srcX2'));
            }
        });
        /*$('.products-grid').find('a.product-image').click(function(e){
            e.preventDefault();
            return false;
        });*/
    }
    function setGridItemsHeight() {
        var ww = $(window).width();
        var SPACING = 20;
        if (ww >= 480) {
            $('.show-grid').removeClass("auto-height");
            var gridItemMaxHeight = 0;
            $('.show-grid > .item').each(function () {
                $(this).css("height", "auto");
                if (frontendData.displayAddtocart == 2 || frontendData.displayAddtolink == 2) {
                    var actionsHeight = $(this).find('.actions').height();
                    $(this).css("padding-bottom", (actionsHeight + SPACING) + "px");
                }
                gridItemMaxHeight = Math.max(gridItemMaxHeight, $(this).height());
            });
            $('.show-grid > .item').css("height", gridItemMaxHeight + "px");
        } else {
            $('.show-grid').addClass("auto-height");
            $('.show-grid > .item').css("height", "auto");
            $('.show-grid > .item').css("padding-bottom", "20px");
        }
    }

    function setGridItem() {
        var ww = $(window).width();
        var col = frontendData.colFull;
        if (ww > 768) {
            newcol = col;
        }
        if (ww <= 768 && ww > 640) {
            newcol = frontendData.col768_640;
        }
        if (ww > 480 && ww <= 640) {
            newcol = frontendData.col480_640;
        }
        if (ww <= 480) {
            newcol = frontendData.col480;
        }
        for (var i = 1; i < 8; i++) {
            $('.catalog-category-view .category-products .show-grid').removeClass('products-itemgrid-'+i+'col');
        }
        $('.catalog-category-view .category-products .show-grid').addClass('products-itemgrid-'+newcol+'col');
        $i = 0;
        $('.show-grid > .item').each(function () {
            $i++;
            $(this).removeClass('first');
            $(this).removeClass('last');
            if (($i - 1) % newcol == 0) {
                $(this).addClass('first');
            } else if ($i % newcol == 0) {
                $(this).addClass('last');
            }
        });
    }

    setGridItem();
    $(window).resize(function () {
        var wnw = $(window).width();
        var wnh = $(window).height();
        if (ww != wnw || wh != wnh) {
            clearTimeout(windowResize_t);
            windowResize_t = setTimeout(function () {
                $(document).trigger("themeResize");
                if (frontendData.confGridEqualHeight) {
                    setGridItemsHeight($);
                }
                setGridItem($);
            }, 200);
        }
        ww = wnw;
        wh = wnh;
    });
    if (frontendData.confGridEqualHeight) {
        setGridItemsHeight();
    }
    $("img.lazy").lazy({
        effect: "fadeIn",
        effectTime: 800,
        threshold: 50,
        afterLoad: function (element) {
            if (frontendData.confGridEqualHeight) {
                setGridItemsHeight();
            }
        }
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
    $('#back-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    
    $(".nav-mobile-accordion, #categories_nav").mobileMenu({
        accordion: true,
        speed: 400,
        closedSign: 'collapse',
        openedSign: 'expand',
        mouseType: 0,
        easing: 'easeInOutQuad'
    });
    
    // $('#product-tab a[href="#product_tabs_tabreviews"]').click(function (e) {
    //     // $(this).tab('show');
    //     $('#product-tab>li').removeClass('active');
    //     $(this).parent().addClass('active');
    //     $('.tab-content>div').removeClass('active');
    //     $('#product_tabs_tabreviews').addClass('active');
    // });

    $('#product-tab a').click(function (e) {
        e.preventDefault();
        var index = $(this).parent().index() + 1;
        $('#product-tab>li').removeClass('active');
        $(this).parent().addClass('active');
        $('.tab-content>div').removeClass('active');
        $('.tab-content>div:nth-child(' + index + ')').addClass('active');
    });

    $('div.product-view p.no-rating a, div.product-view .rating-links a').click(function () {
        $('#product-tab a[href="#product_tabs_tabreviews"]').trigger('click');
        $('#product-tab').scrollToMe();
        return false;
    });
    $.browserSelector();
    if ($("html").hasClass("chrome")) {
        $.smoothScroll();
    }
    if ($("html").hasClass("safari")) {
        $.smoothScroll();
    }
    $.fn.clickToggle = function (a, b) {
        var ab = [b, a];

        function cb() {
            ab[this._tog ^= 1].call(this);
        }

        return this.on("click", cb);
    };
    $('.main-add-to-links .social-share, .add-to-links .social-share').clickToggle(function () {
        $(this).addClass('active');
    }, function () {
        $(this).removeClass('active');
    });
    $('.mobile-button').addClass("active");
    $('.mobile-button').click(function(){
        if($(this).parents('.footer-block-title, .block-title').next().is(":visible")){
            $(this).addClass("active");
        }else{
            $(this).removeClass("active");
        }
        $(this).parents('.footer-block-title, .block-title').next().toggle(400);
    });
})(jQuery);