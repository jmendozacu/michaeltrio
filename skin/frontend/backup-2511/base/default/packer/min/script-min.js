jQuery(document).ready(function(e){function t(){jQuery(".rangeslider").each(function(e,t){function a(e,t){var a=jQuery(e.target).closest(".m-filter-item-list").find(".dataurl").val(),r=jQuery(e.target).closest(".m-filter-item-list").find(".dataurl").attr("data-split"),s=jQuery(e.target).closest(".m-filter-item-list").find(".dataurl").attr("data-prefix"),i=jQuery(e.target).closest(".m-filter-item-list").find(".dataurl").attr("data-suffix");"undefined"==typeof i&&(i="");var o=a.match(r+"(.*)");jQuery(e.target).closest(".m-filter-item-list").find(".rangemin").val(s+t.values[0]+i),jQuery(e.target).closest(".m-filter-item-list").find(".rangemax").val(s+t.values[1]+i),a.indexOf("&")>-1&&(o=a.match(r+"(.*)&")),null!=o&&(a=a.replace(o[1],t.values[0]+"%2C"+t.values[1]))}var r=parseFloat(jQuery(this).attr("data-min")),s=parseFloat(jQuery(this).attr("data-max")),i=parseFloat(jQuery(this).attr("data-min-value")),l=parseFloat(jQuery(this).attr("data-max-value"));jQuery(this).slider(jQuery(this).hasClass("carat-slider")?{range:!0,min:r,step:.01,max:s,values:[i,l],slide:function(e,t){a(e,t)},stop:function(e,t){o(jQuery(this).attr("data-filter"),t.values[0],t.values[1])}}:{range:!0,min:r,max:s,values:[i,l],slide:function(e,t){a(e,t)},stop:function(e,t){o(jQuery(this).attr("data-filter"),t.values[0],t.values[1])}}),"true"==jQuery(this).attr("data-disabled")&&(jQuery(this).slider("option","disabled",!0),jQuery(this).closest(".m-filter-item-list").addClass("disable-range"))})}function a(e){jQuery("."+e+" .bSwitch").on("switchChange.bootstrapSwitch",function(t,a){var r="visible-col-"+e;jQuery(".item-list-table").toggleClass(r)})}function r(e,t){var a=e,r=t,s={},i=[];for(var o in r)s[r[o]]=r[o];for(var l in a)"undefined"!=typeof s[a[l]]&&"string"==typeof a[l]&&(i+=a[l]);return i}function s(e,t,a){var s=[];for(e;t>e;e++)s.push(r(a[e],a[e+1]));return s}function i(e,t){jQuery(".loader-diamonds-results").addClass("loader-show"),t&&(m=1,C.page=m,C.sort_field="diamonds_price",C.sort="ASC",jQuery(".table-header").removeClass("sorting")),console.log(C),jQuery.post("/diamonds/ajax/filter/",e,function(e){e=JSON.parse(e),S=e.count,k=e.pages,console.log(e),e=e.data,l(e,!0)})}function o(e,t,a,r){switch(console.log(e),console.log(t),console.log(a),e){case"price":C.price_from=t,C.price_to=a;break;case"d_depth":C.depth_from=t,C.depth_to=a;break;case"d_carat":C.carat_from=t,C.carat_to=a;break;case"d_table":C.table_from=t,C.table_to=a;break;case"d_cut":4==a&&(a=5),C.cut=s(t,a,y);break;case"d_color":C.color=s(t,a,j);break;case"d_clarity":C.clarity=s(t,a,Q);break;case"d_polish":C.polish=s(t,a,b);break;case"d_symmetry":C.symmetry=s(t,a,_);break;case"d_fluorescence":C.fluorescence=s(t,a,g)}i(C,!0)}function l(e,t){t&&(m=1,jQuery("table.diamonds-table-content").html(""),jQuery(".odometer").html(S)),e.each(function(e){function a(e){var t;switch(e){case"FR":t="Fair";break;case"GD":t="Good";break;case"VG":t="Very Good";break;case"EX":t="Excellent";break;case"Signature Ideal":t="Signature Ideal";break;case"H&A":t="Signature Ideal"}return t}var r="";r=a(e.cut),polish=a(e.polish),symmetry=a(e.symmetry);var s=parseFloat(e.diamonds_price);s=s.toFixed(2);var i=parseFloat(e.depth);i=i.toFixed(2);var o=e.shape,l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/round.png";"RD"==o?(o="ROUND",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/round.png"):"PS"==o?(o="Princess",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/princess.png"):"EC"==o?(o="Emerald",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/emerald.png"):"HS"==o?(o="Heart",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/heart.png"):"PR"==o?(o="Pear",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/pear.png"):"CU"==o?(o="Cushion",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/cushion.png"):"RA"==o?(o="Radiant",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/radiant.png"):"OV"==o?(o="Oval",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/oval.png"):"AS"==o?(o="Asscher",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/asscher.png"):"MQ"==o&&(o="Marquise",l="http://michaeltrio.qoobx.com/skin/frontend/base/default/packer/images/diamonds/marquise.png");var n='<tr data-id="'+e.importxls_id+'" class="item_ajax_get_details"><td class="cell-compare"><input class="compare_item" type="checkbox" name="chk[ ]" value=""></td><td class="cell-shape text-center list-img-label text-uppercase"><img src="'+l+'" width="auto" height="20" alt=""> <br> '+o+'</td><td class="cell-carat">'+e.carat+'</td><td class="cell-color">'+e.color+'</td><td class="cell-clarity">'+e.clarity+'</td><td class="cell-fluorescence">'+e.fluorescence+'</td><td class="cell-depth">'+i+'</td><td class="cell-_table">'+e.table_field+'</td><td class="cell-cut">'+r+'</td><td class="cell-polish">'+polish+'</td><td class="cell-symm">'+symmetry+'</td> <td class="cell-price">SGD $'+s+' <i class="fa fa-arrow-right pl30"></i></td></tr>';t?jQuery("table.diamonds-table-content").append(n):jQuery("table.diamonds-table-content tr:last-child").parent().append(n)}),t&&(jQuery(".content").mCustomScrollbar("destroy"),jQuery(".content").mCustomScrollbar({scrollInertia:150,theme:"dark",scrollButtons:{enable:!0},callbacks:{onTotalScroll:function(){n()}}}),setTimeout(function(){jQuery(".loader-diamonds-results").removeClass("loader-show")},200))}function n(){if(!h&&!f){m++,C.page=m,console.log(C),h=!0,jQuery(".loader-diamonds-results").addClass("loader-show");var e="/diamonds/ajax/filter/";jQuery.post(e,C,function(e){e=JSON.parse(e),console.log(e),e=e.data,l(e)}).done(function(){jQuery(".content").mCustomScrollbar("destroy"),jQuery(".content").mCustomScrollbar({scrollInertia:150,theme:"dark",scrollButtons:{enable:!0},callbacks:{onTotalScroll:function(){n()}}}),c(),setTimeout(function(){jQuery(".loader-diamonds-results").removeClass("loader-show")},200),m>=parseInt(window.diamondTotalPages)&&(f=!0),h=!1})}}function c(){var e=jQuery(".diamonds-table-content").height()-6250;jQuery(".content").mCustomScrollbar("scrollTo",e)}var d=jQuery(window).scrollTop();jQuery(document).on("change",".compare_item",function(e){jQuery(".cmp_count").html("("+jQuery(".compare_item:checked").length+")")}),jQuery(document).on("click",".close_pop",function(e){e.preventDefault(),jQuery(this).closest(".mypop").hide()}),jQuery(document).on("click",".btn-clr",function(e){e.preventDefault(),jQuery(this).toggleClass("checked-clr")}),jQuery(document).on("click",".info_title",function(e){e.preventDefault(),jQuery(".mypop").hide();var t=jQuery(this).siblings(".mypop");if(t.length>0){var a=t.width(),r=jQuery(this).offset().top+20-jQuery(window).scrollTop(),s=jQuery(this).offset().left-a/2+8;t.css({top:r,left:s}).show()}}),$(document).on("scroll",function(e){var t=jQuery(window).scrollTop(),a=t-d;jQuery(".mypop:visible").length>0&&jQuery(".mypop:visible").each(function(e,t){var r=jQuery(this).position().top;jQuery(this).css({top:r-a})}),d=t}),jQuery(document).on("click",".mbtn",function(e){e.preventDefault(),jQuery(this).siblings(".mbtn").removeClass("active"),jQuery(this).addClass("active");var t=jQuery(this).attr("data-container"),a=jQuery(this).attr("data-img");t&&null!=t&&jQuery(t).attr("src",a)}),jQuery(document).on("click",".filter_slider",function(e){e.preventDefault(),"1"==jQuery(this).data("position")?(jQuery(this).data("position","2"),jQuery(".list_filters").css("left","-100%"),jQuery(this).html('<i class="fa fa-long-arrow-left"></i> BASIC FILTERS')):(jQuery(this).data("position","1"),jQuery(".list_filters").css("left","0%"),jQuery(this).html('ADVANCE FILTERS <i class="fa fa-long-arrow-right"></i>'))}),jQuery(document).on("click",".compareItems",function(e){if(jQuery(".compare_item:checked").length>0){var t=[];jQuery(".compare_item:checked").each(function(e,a){t.push(jQuery(this).closest("tr").attr("data-id"))}),console.log(t);var a=window.open(BASE_URL+"index.php/catalog/product_compare/index/items/"+t.join(","),"_blank");a.focus()}}),jQuery(document).on("click",".addTocomparefromView",function(e){jQuery('.item_ajax_get_details[data-id="'+jQuery(this).attr("data-id")+'"]').find(".compare_item").prop("checked",!0)}),jQuery(document).on("click",".closeItemInfo",function(e){e.preventDefault(),jQuery(".diamonds-table-header").removeClass("sidebar-open"),jQuery(".cat-results").removeClass("shown-details")}),jQuery(document).on("click",".item_ajax_get_details",function(e){if(jQuery(".diamonds-table-header").addClass("sidebar-open"),!jQuery(e.target).hasClass("compare_item")){e.preventDefault();var t=jQuery(this).attr("data-id");jQuery(".cat-results").addClass("shown-details"),jQuery(".item-info-block").addClass("getting-data"),jQuery.ajax({url:BASE_URL+"index.php/packer/index/getProduct",data:{id:t},type:"POST",success:function(e){jQuery(".item-info-ajax-container").html(e),jQuery(".item-info-block").removeClass("getting-data")}})}}),jQuery(document).on("click",".filter_trigger",function(e){e.preventDefault(),jQuery(".filters_div").is(":visible")?(jQuery(".filters_div").slideUp(500),jQuery(this).html('View Filters <i class="fa fa-long-arrow-down"></i>').removeClass("GREY_BG")):(jQuery(".filters_div").slideDown(500),jQuery(this).html('Hide Filters <i class="fa fa-long-arrow-up"></i>').addClass("GREY_BG")),jQuery(".list_filters").css("width",2*jQuery(".filters_div").width()),jQuery(".ticker-inputs").length>0&&jQuery(".ticker-inputs").each(function(e,t){var a=jQuery(this).find(".tick").length,r=jQuery(this).outerWidth()/a;jQuery(this).find(".tick").css("width",r),jQuery(this).find(".tick:first").css("width",r-1)})});var u;t(),jQuery(".ticker-inputs").length>0&&jQuery(".ticker-inputs").each(function(e,t){var a=jQuery(this).find(".tick").length,r=jQuery(this).outerWidth()/a;jQuery(this).find(".tick").css("width",r)}),jQuery('[data-toggle="tooltip"]').tooltipp(),jQuery(".bSwitch").bootstrapSwitch(),jQuery(".bSwitch").on("switchChange.bootstrapSwitch",function(e,t){1==t?(jQuery(this).closest(".filter_box").find(".rangeslider").slider("option","disabled",!1),jQuery(this).closest(".filter_box").find(".m-filter-item-list").removeClass("disable-range")):(jQuery(this).closest(".filter_box").find(".rangeslider").slider("option","disabled",!0),jQuery(this).closest(".filter_box").find(".m-filter-item-list").addClass("disable-range"))}),a("fluorescence"),a("depth"),a("_table"),jQuery("#Reset_filters").on("click",function(){t(),jQuery(".shapes-filter .ajax-filter").each(function(){jQuery(this).addClass("checked-clr")}),C={page:1,shape:["RD","RA","PS","PR","OV","MQ","HS","EC","CU","AS"],price_from:price_from,price_to:price_to,carat_from:carat_from,carat_to:carat_to,cut:["GD","VG","EX","Signature Ideal","H&A"],color:["J","I","H","G","F","E","D","K"],clarity:["SI2","SI1","VS2","VS1","VVS2","VVS1","IF","FL"],polish:["GD","VG","EX"],symmetry:["GD","VG","EX"],fluorescence:["NONE","FAINT","MEDIUM","STRONG","VSTRONG"],depth_from:depth_min,depth_to:depth_max,table_from:table_min,table_to:table_max,sort:"ASC",sort_field:"diamonds_price"},jQuery(".prices input.rangemin").val("$ "+C.price_from),jQuery(".prices input.rangemax").val("$ "+C.price_to),jQuery(".carat input.rangemin").val(" "+C.carat_from),jQuery(".carat input.rangemax").val(" "+C.carat_to),jQuery(".table-header").removeClass("sorting"),i(C,!0)});var m=1,f=!1,p=101,h=!1,y={0:["GD"],1:["GD","VG"],2:["VG","EX"],3:["EX","Signature Ideal"],4:["Signature Ideal","H&A"],5:["H&A"]},j={0:["K"],1:["K","J"],2:["J","I"],3:["I","H"],4:["H","G"],5:["G","F"],6:["F","E"],7:["E","D"],8:["D"]},Q={0:["SI2"],1:["SI2","SI1"],2:["SI1","VS2"],3:["VS2","VS1"],4:["VS1","VVS2"],5:["VVS2","VVS1"],6:["VVS1","IF"],7:["IF","FL"],8:["FL"]},b={0:["GD"],1:["GD","VG"],2:["VG","EX"],3:["EX"]},_={0:["GD"],1:["GD","VG"],2:["VG","EX"],3:["EX"]},g={0:["NONE"],1:["NONE","FAINT"],2:["FAINT","MEDIUM"],3:["MEDIUM","STRONG"],4:["STRONG","VSTRONG"],5:["VSTRONG"]},v={25:"RD",61:"PS",59:"EC",23:"HS",24:"PR",58:"CU",56:"RA",26:"OV",57:"AS",60:"MQ"},S,k;if("undefined"!=typeof price_from&&"undefined"!=typeof price_to&&"undefined"!=typeof carat_from&&"undefined"!=typeof carat_to&&"undefined"!=typeof depth_min&&"undefined"!=typeof depth_max&&"undefined"!=typeof table_min&&"undefined"!=typeof table_max)var C={page:1,shape:["RD","RA","PS","PR","OV","MQ","HS","EC","CU","AS"],price_from:price_from,price_to:price_to,carat_from:carat_from,carat_to:carat_to,cut:["GD","VG","EX","Signature Ideal","H&A"],color:["J","I","H","G","F","E","D","K"],clarity:["SI2","SI1","VS2","VS1","VVS2","VVS1","IF","FL"],polish:["GD","VG","EX"],symmetry:["GD","VG","EX"],fluorescence:["NONE","FAINT","MEDIUM","STRONG","VSTRONG"],depth_from:depth_min,depth_to:depth_max,table_from:table_min,table_to:table_max,sort:"ASC",sort_field:"diamonds_price",lastSortedBy:"price"};jQuery(".table-header").on("click",function(){var e=jQuery(this),t=e.attr("data-sort");jQuery(".table-header").removeClass("sorting"),e.addClass("sorting"),C.lastSortedBy!=t?(C.sort="ASC",e.addClass("asc"),e.removeClass("desc")):"ASC"==C.sort?(C.sort="DESC",e.addClass("desc"),e.removeClass("asc")):(C.sort="ASC",e.addClass("asc"),e.removeClass("desc")),C.sort_field=t,C.lastSortedBy=t,i(C)}),jQuery(".shapes-filter .ajax-filter").on("click",function(){setTimeout(function(){var e=[];jQuery(".shapes-filter .checked-clr").each(function(){var t=jQuery(this).attr("data-value");e.push(v[t])}),C.shape=e,i(C,!0)},100)}),jQuery(".content").mCustomScrollbar({scrollInertia:150,theme:"dark",scrollButtons:{enable:!0},callbacks:{onTotalScroll:function(){n()},onTotalScrollOffset:500}}),jQuery(".diamonds-sidebar").mCustomScrollbar({scrollInertia:150,theme:"dark",scrollButtons:{enable:!0}}),body=jQuery("body"),body.hasClass("cms-home")||(jQuery(".contact-info").addClass("blackk"),jQuery(".phone-box").addClass("blackk"))});