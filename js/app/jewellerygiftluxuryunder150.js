
jQuery(function ($) {

    var ajaxPageCount = 1;
    var ajaxStop = true;
    var contentLoadingState = true;

    function scrollBack() {
        var target = jQuery('.content-ring-diamonds').height() - 6250
        $('.content-ring-diamonds').mCustomScrollbar("scrollTo", target);
    }

//    $('.content-ring-diamonds').mCustomScrollbar({
//        scrollInertia: 650,
//        theme: "dark",
//        scrollButtons: {
//            enable: true
//        },
//        callbacks: {
//            onTotalScroll: function () {
//
//                loadRingsContentOnScroll();
//            },
//            onTotalScrollOffset: 700
//        }
//    });

	var processing;
	$(document).scroll(function (e) {


		var scrollper;
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		scrollper='0.6';
		}
		else
		{
		scrollper='0.8';
		}
		
/*		console.log(($(document).height() - $(window).height()) * scrollper);
		console.log($(window).scrollTop());
*/
        if (processing)
            return false;	

	
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * scrollper) {
            processing = true;
			
            loadRingsContentOnScroll();
        }
    });

    function loadRingsContentOnScroll() {

		console.log(sourceArray.page);
		//alert(sourceArray.pages);
		//alert(ajaxPageCount);
        if (sourceArray.page < sourceArray.pages) {

            ajaxPageCount++;
            sourceArray.page = ajaxPageCount;

            console.log(sourceArray);
            contentLoadingState = true;

            jQuery('.loader-diamonds-results').addClass('loader-show');
            var requestUrl = BASE_URL + 'diamonds/ajax/filterjewellerygiftringluxury/';

            jQuery.post(requestUrl, sourceArray, function (data) {

                data = JSON.parse(data);
                console.log(data);
                sourceArray.pages = data.pages;
                //data = data.data;
                renderwithPriceContent(data);
                processing = false;
				
            }).done(function (data) {
//                $('.content-ring-diamonds').mCustomScrollbar('destroy')
//                $('.content-ring-diamonds').mCustomScrollbar({
//                    scrollInertia: 250,
//                    theme: "dark",
//                    scrollButtons: {
//                        enable: true
//                    },
//                    callbacks: {
//                        onTotalScroll: function () {
//                            loadRingsContentOnScroll();
//                        }
//                    }
//                });
//
//                scrollBack();
                setTimeout(function () {
                    jQuery('.loader-diamonds-results').removeClass('loader-show');
                }, 200);

                if (ajaxPageCount >= parseInt(window.ringTotalPages)) {
                    ajaxStop = true;
                }

                contentLoadingState = false;
            });

        }


    }

    $("#sort_by  >li > a").click(function (e) {
        e.preventDefault();
        sourceArray.sortby = $(this).html();
        $("#sort_by_main").html($(this).html());
        getRingswithPriceContent(sourceArray);
    });

    $("#limiter  >li > a").click(function (e) {
        e.preventDefault();
        sourceArray.limiter = $(this).html();
        $("#limiter_by_main").html($(this).html() + ' items/page');
        getRingswithPriceContent(sourceArray)
    });

    $(".direction-list  > a").click(function (e) {
        e.preventDefault();
        console.log(sourceArray);
        sourceArray.diraction = $(this).attr('data-dire');
        if ($(this).attr('data-dire') == 'desc')
        {
            $("#desc_by_dir").hide();
            $("#asc_by_dir").show();
        }
        else if ($(this).attr('data-dire') == 'asc')
        {
            $("#asc_by_dir").hide();
            $("#desc_by_dir").show();
        }

        console.log(sourceArray);
        getRingswithPriceContent(sourceArray)
    });


    function getRingsContent(sourceArray) {

        sourceArray.page = 1;
		ajaxPageCount = 1;
        $('.loader-diamonds-results').addClass('loader-show');
        $.post(filterRingUrl, sourceArray, function () {
            $('.products-grid').html(' ');
			processing = false;
        }).done(function (data) {
            var data = JSON.parse(data)
			console.log(sourceArray.page);
            renderContent(data, true);
        });
    }

    function getRingswithPriceContent(sourceArray) {
        sourceArray.page = 1;
		ajaxPageCount = 1;
        $('.loader-diamonds-results').addClass('loader-show');
        $.post(filterRingUrl, sourceArray, function () {
            $('.products-grid').html(' ');
			processing = false;
        }).done(function (data) {
            var data = JSON.parse(data)
			console.log(sourceArray.page);
            renderwithPriceContent(data, true);
        });
    }


    function renderwithPriceContent(inputData, isFiltering) {

        if (isFiltering) {
            ajaxPageCount = 1;
            sourceArray.page = 1;
            sourceArray.pages = inputData.pages;
            window.ringTotalPages = inputData.ringTotalPages;

            if (inputData.ringTotalPages >= 12)
            {
                //$('.content-ring-diamonds').css("height", "1510px");
            }
            else
            {
                $('.products-grid').append(output);
            }

            $('.products-grid').html('');
        }
        var output = '';
        if (inputData.total_count > 0) {
            console.log(inputData);

            inputData.objects.each(function (product) {
                console.log(product);

                output += '<li class="itemwedding  hover-effect first img-product-img-' + product.entity_id + '" style="min-height: 395px;">' +
                        '<div class="product-action">' +
                        '<a href="' + product.product_full_url + '" title="' + product.name + '" class="product-image">' +
                        '<img id="product-collection-image-' + product.entity_id + '" data-srcx2="' + product.product_image_url + '" src="' + product.product_image_url + '" class="img-responsive lazy" alt="' + product.name + '" style="display: block;">' +
                        '</a>' +
                        '<div class="actions">' +
                        '<div class="action-list quickview hidden-xs">' +
                        '<div class="quickview-wrapper" onclick="quickview(this);" data-url="' + product.product_data_url + '">' +
                        '<i class="fa fa-search-plus"></i>' +
                        '</div>' +
                        '</div>' +
                        '<div class="action-list">' +
                        '<ul class="add-to-links">' +
                        '<li class="wishlist"><a href="" class="link-wishlist bootstrap-tooltip" data-toggle="tooltip" data-placement="left" title="" data-original-title="Wishlist"><i class="fa fa-heart"></i></a></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-content">' +
                        '<h3 class="product-name"><a href="' + product.product_full_url + '" title="' + product.name + '">' + product.name + '</a></h3>' +
                        '<div class="price-box">' +
                        '<span class="regular-price" id="product-price-' + product.entity_id + '">' +
                        '<span class="price"> ' + product.price + '</span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' + product.ringclasshtml +
                        '</li>';
            });

            if (isFiltering) {
                if (!output) {
                    $('.content-ring-diamonds').css("height", "auto");
                    $('.products-grid').html('<p class="note-msg">There are no products matching the selection.</p>');
                } else {
                    $('.products-grid').append(output);
                }
            } else {
                //alert(output);
                $('.products-grid').append(output);
            }
        }
        else
        {
            $('.content-ring-diamonds').css("height", "auto");
        }

//        if (isFiltering) {
//            $('.content-ring-diamonds').mCustomScrollbar('destroy')
//            $('.content-ring-diamonds').mCustomScrollbar({
//                scrollInertia: 250,
//                theme: "dark",
//                scrollButtons: {
//                    enable: true
//                },
//                callbacks: {
//                    onTotalScroll: function () {
//                        loadRingsContentOnScroll();
//                    }
//                }
//            });
//        }

        var addfirstlast = 1;
        jQuery('.products-grid > .itemwedding').each(function () {

            switch (addfirstlast) {
                case 1:
                    if (!jQuery(this).hasClass('first')) {
                        jQuery(this).addClass('first');
                    }
                    addfirstlast++;
                    break;
                case 2:
                    if (jQuery(this).hasClass('first')) {
                        jQuery(this).removeClass('first');
                    }
                    addfirstlast++;
                    break;
                case 3:
                    if (jQuery(this).hasClass('first')) {
                        jQuery(this).removeClass('first');
                    }
                    if (!jQuery(this).hasClass('last')) {
                        jQuery(this).addClass('last');
                    }
                    addfirstlast = 1;
                    break;
            }
        });

        $('.loader-diamonds-results').removeClass('loader-show');
    }
    function renderContent(inputData, isFiltering) {

        if (isFiltering) {

            sourceArray.page = 1;
            sourceArray.pages = inputData.pages;
            window.ringTotalPages = inputData.ringTotalPages;
            if (inputData.ringTotalPages >= 12)
            {
                //$('.content-ring-diamonds').css("height", "1510px");
            }
            else
            {
                $('.products-grid').append(output);
            }
            $('.products-grid').html('');
        }

        var output = '';
        if (inputData.total_count > 0) {
            console.log(inputData);

            $('.prices-data .value-from').text(inputData.currSymbol + inputData.min_price);
            $('.prices-data .value-to').text(inputData.currSymbol + inputData.max_price);
            $(".rangeslider-s2").slider("option", "max", parseInt(inputData.max_price));
            $(".rangeslider-s2").slider("option", "min", parseInt(inputData.min_price)); // left handle should be at the left end, but it doesn't move
            $(".rangeslider-s2").slider("option", "values", [inputData.min_price, inputData.max_price]); // the left handle is now at the left end, but doing this triggers events
            $("input[type='range']").slider("refresh");
            var chaneheight = 1;
            inputData.objects.each(function (product) {
                console.log(product);

                output += '<li class="itemwedding  hover-effect first img-product-img-' + product.entity_id + '" style="min-height: 395px;">' +
                        '<div class="product-action">' +
                        '<a href="' + product.product_full_url + '" title="' + product.name + '" class="product-image">' +
                        '<img id="product-collection-image-' + product.entity_id + '" data-srcx2="' + product.product_image_url + '" src="' + product.product_image_url + '" class="img-responsive lazy" alt="' + product.name + '" style="display: block;">' +
                        '</a>' +
                        '<div class="actions">' +
                        '<div class="action-list quickview hidden-xs">' +
                        '<div class="quickview-wrapper" onclick="quickview(this);" data-url="' + product.product_data_url + '">' +
                        '<i class="fa fa-search-plus"></i>' +
                        '</div>' +
                        '</div>' +
                        '<div class="action-list">' +
                        '<ul class="add-to-links">' +
                        '<li class="wishlist"><a href="" class="link-wishlist bootstrap-tooltip" data-toggle="tooltip" data-placement="left" title="" data-original-title="Wishlist"><i class="fa fa-heart"></i></a></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-content">' +
                        '<h3 class="product-name"><a href="' + product.product_full_url + '" title="">' + product.name + '</a></h3>' +
                        '<div class="price-box">' +
                        '<span class="regular-price" id="product-price-' + product.entity_id + '">' +
                        '<span class="price"> ' + product.price + '</span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' + product.ringclasshtml +
                        '</li>';
                chaneheight++;
            });


            if (isFiltering) {
                if (!output) {
                    $('.content-ring-diamonds').css("height", "auto");
                    $('.products-grid').html('<p class="note-msg">There are no products matching the selection.</p>');
                } else {
                    $('.products-grid').append(output);
                }
            } else {
                //alert(output);
                $('.products-grid').append(output);
            }

        }
        else
        {
            $('.content-ring-diamonds').css("height", "auto");
        }


//        if (isFiltering) {
//            $('.content-ring-diamonds').mCustomScrollbar('destroy')
//            $('.content-ring-diamonds').mCustomScrollbar({
//                scrollInertia: 250,
//                theme: "dark",
//                scrollButtons: {
//                    enable: true
//                },
//                callbacks: {
//                    onTotalScroll: function () {
//                        loadRingsContentOnScroll();
//                    }
//                }
//            });
//        }
        var addfirstlast = 1;
        jQuery('.products-grid > .itemwedding').each(function () {

            switch (addfirstlast) {
                case 1:
                    if (!jQuery(this).hasClass('first')) {
                        jQuery(this).addClass('first');
                    }
                    addfirstlast++;
                    break;
                case 2:
                    if (jQuery(this).hasClass('first')) {
                        jQuery(this).removeClass('first');
                    }
                    addfirstlast++;
                    break;
                case 3:
                    if (jQuery(this).hasClass('first')) {
                        jQuery(this).removeClass('first');
                    }
                    if (!jQuery(this).hasClass('last')) {
                        jQuery(this).addClass('last');
                    }
                    addfirstlast = 1;
                    break;
            }
        });

        $('.loader-diamonds-results').removeClass('loader-show');
    }


    $('.filter li a').on('click', function () {

        if ($(this).attr('data-value') == 'false') {
            return false;
        }

        var filterType = $(this).closest('ul').attr('data-filter');
        //alert(filterType);
        switch (filterType) {
            case 'price':
                sourceArray.price_from = parseInt($(this).attr('data-price-from'));
                $(this).attr('data-price-to') ? sourceArray.price_to = parseInt($(this).attr('data-price-to')) : sourceArray.price_to = null;
                break;
            case 'style':
                $(this).toggleClass('checked');
                addOrRemove(sourceArray.style, $(this).attr('data-value'));
                break;
            case 'colours':
                $(this).toggleClass('checked');
                addOrRemove(sourceArray.colours, $(this).attr('data-value'));

                break;
            case 'metals':
                $(this).toggleClass('checked');
                addOrRemove(sourceArray.metals, $(this).attr('data-value'));
                break;

        }
        sourceArray.price_from = '0';
        //sourceArray.price_to = '0';
        getRingsContent(sourceArray);
    });

    $('.rangeslider-s2').slider({
        range: true,
        step: 1,
        min: min_price,
        max: max_price,
        values: [min_price, max_price],
        slide: function (event, ui) {
            $('.prices-data .value-from').text(sourceArray.currSymbol + ui.values[0]);
            $('.prices-data .value-to').text(sourceArray.currSymbol + ui.values[1]);
        },
        stop: function (event, ui) {
            // console.log( 'val1 - ' + ui.values[0] + 'val2 - ' + ui.values[1] );
            sourceArray.price_from = ui.values[0];
            sourceArray.price_to = ui.values[1];
            getRingswithPriceContent(sourceArray);
        }
    });

});

function addOrRemove(array, value) {
    var index = array.indexOf(value);

    if (index === -1) {
        array.push(value);
    } else {
        array.splice(index, 1);
    }
}
