
jQuery('.add-to-setting a').on('click', function () {
    var productName = jQuery(this).closest('.product-content').find('.product-name a').text();
    var productPrice = jQuery(this).closest('.product-content').find('.price-box .price').text();
    var productPriceVal = jQuery(this).closest('.product-content').find('.price-box .price').attr('data-price-val');
    var ringUrl = jQuery(this).closest('.product-content').find('.product-name a').attr('href');
    var ringImg = jQuery(this).closest('.item').find('.img-responsive.lazy').attr('src');
    var selectedRingId = jQuery(this).attr('data-ring');

    // console.log( productPriceVal );
    jQuery('.sidebar-container').removeClass('closed');


    var saveRingUrl = BASE_URL + 'diamonds/diamond/setringtosetting/';
    jQuery.post(saveRingUrl, {ring_id: selectedRingId}, function (response) {
        console.log(response);
    });

    showSweetCart({
        url: ringImg,
        name: productName,
        message: ' was added to your configuration',
        // btnViewRing: true,
        // btnViewRingUrl: ringUrl,
        btnClose: true
    });
    renderSidebarContent();

    // console.log(window.localStorage);
});




jQuery(function ($) {

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

        $('.loader-diamonds-results').addClass('loader-show');
        $.post(filterRingUrl, sourceArray, function () {
            $('.products-grid').html(' ');
        }).done(function (data) {
            var data = JSON.parse(data)
            renderContent(data);
        });
    }

    function getRingswithPriceContent(sourceArray) {
        $('.loader-diamonds-results').addClass('loader-show');
        $.post(filterRingUrl, sourceArray, function () {
            $('.products-grid').html(' ');
        }).done(function (data) {
            var data = JSON.parse(data)
            renderwithPriceContent(data);
        });
    }


function renderwithPriceContent(inputData) {

        var output = '';
        if (inputData.total_count > 0) {
            console.log(inputData);
            
            inputData.objects.each(function (product) {
                console.log(product);

                output += '<li class="item  hover-effect first" style="">' +
                        '<div class="product-action">' +
                        '<a href="' + product.product_full_url + '?step=setting" title="' + product.name + '" class="product-image">' +
                        '<img id="product-collection-image-' + product.entity_id + '" data-srcx2="' + product.product_image_url + '" src="' + product.product_image_url + '" class="img-responsive lazy" alt="<?php echo $product_name; ?>" style="display: block;">' +
                        '</a>' +
                        '<div class="actions">' +
                        '<div class="action-list quickview hidden-xs">' +
                        '<div class="quickview-wrapper" onclick="quickview(this);" data-url="' + product.product_full_url + '">' +
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
                        '</div>' +
                        '</li>';
            });
        }

        if (!output) {
            $('.products-grid').html('<p class="note-msg">There are no products matching the selection.</p>');
        } else {
            $('.products-grid').html(output);
        }

        $('.loader-diamonds-results').removeClass('loader-show');
    }
    function renderContent(inputData) {

        var output = '';
        if (inputData.total_count > 0) {
            console.log(inputData);

            $('.prices-data .value-from').text(inputData.currSymbol+inputData.min_price);
            $('.prices-data .value-to').text(inputData.currSymbol+inputData.max_price);
            $(".rangeslider-s2" ).slider( "option", "max", parseInt(inputData.max_price));
            $(".rangeslider-s2").slider("option", "min", parseInt(inputData.min_price)); // left handle should be at the left end, but it doesn't move
            $(".rangeslider-s2").slider("option", "values", [inputData.min_price, inputData.max_price]); // the left handle is now at the left end, but doing this triggers events
            $("input[type='range']").slider( "refresh" );
            
            inputData.objects.each(function (product) {
                console.log(product);

                output += '<li class="item  hover-effect first" style="">' +
                        '<div class="product-action">' +
                        '<a href="' + product.product_full_url + '?step=setting" title="' + product.name + '" class="product-image">' +
                        '<img id="product-collection-image-' + product.entity_id + '" data-srcx2="' + product.product_image_url + '" src="' + product.product_image_url + '" class="img-responsive lazy" alt="<?php echo $product_name; ?>" style="display: block;">' +
                        '</a>' +
                        '<div class="actions">' +
                        '<div class="action-list quickview hidden-xs">' +
                        '<div class="quickview-wrapper" onclick="quickview(this);" data-url="' + product.product_full_url + '">' +
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
                        '</div>' +
                        '</li>';
            });
        }

        if (!output) {
            $('.products-grid').html('<p class="note-msg">There are no products matching the selection.</p>');
        } else {
            $('.products-grid').html(output);
        }

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

            case 'shape':
                $(this).toggleClass('checked');
                addOrRemove(sourceArray.shape, $(this).attr('data-value'));
                break;

            case 'style':
                $(this).toggleClass('checked');                
                addOrRemove(sourceArray.style, $(this).attr('data-value'));
                break;
        }
        sourceArray.price_from = '0';
        sourceArray.price_to = '0';
        getRingsContent(sourceArray);
    });



    $('.rangeslider-s2').slider({
        range: true,
        step: 1,
        min: min_price,
        max: max_price,
        values: [min_price, max_price],
        slide: function (event, ui) {
            $('.prices-data .value-from').text('$' + ui.values[0]);
            $('.prices-data .value-to').text('$' + ui.values[1]);
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
