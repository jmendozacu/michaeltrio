jQuery(document).ready(function(e) {
								var currencySymbol;
	jQuery(function($){


		function scrollBack(){
			var target = jQuery('.diamonds-table-content').height() - 6250
			// console.log(target);
			$('.content-diamonds').mCustomScrollbar("scrollTo", target );
		}

		$('.content-diamonds').mCustomScrollbar({
			scrollInertia:150,
			theme:"dark",
	        scrollButtons:{
	            enable:true
	        },
	        callbacks:{
			    onTotalScroll: function(){
			    	loadDiamondsContentOnScroll();
			    },
			    onTotalScrollOffset: 500
			}
		});
		

		$(".diamonds-sidebar").mCustomScrollbar({
			scrollInertia:150,
			theme:"dark",
	        scrollButtons:{
	            enable:true
	        }
		}); 

		var lastScroll = $(window).scrollTop();

		if( $('.page-diamonds').hasClass('cat-results') ){
		   
			/* ------------ Compare product --------------- */		
			$(document).on('change','.compare_item',function(e) {
				$('.cmp_count').html('('+$('.compare_item:checked').length+')');		
		    });
			
			$(document).on('click','.close_pop',function(e) {e.preventDefault();
				$(this).closest('.mypop').hide();
		    });
			
			$(document).on('click','.btn-clr',function(e) {e.preventDefault();
				$(this).toggleClass('checked-clr');
		    });
			
			
			$(document).on('click','.info_title',function(e) { e.preventDefault();
				$('.mypop').hide();
				var _pop = $(this).siblings('.mypop');
				if(_pop.length > 0){
					var _ppw = _pop.width();
					var _ppt = ($(this).offset().top + 20)- $(window).scrollTop();
					var _ppl = ($(this).offset().left - (_ppw/2) + 8)
					_pop.css({top:_ppt,left:_ppl}).show();
				}
		    });
			
			$(document).on( 'scroll', function(e){
				var newScroll = jQuery(window).scrollTop();
		        var _scDiff = (newScroll - lastScroll);
		       	if(jQuery('.mypop:visible').length > 0){
					jQuery('.mypop:visible').each(function(index, element) {
						var __ctop = jQuery(this).position().top;
						//var __ctop = jQuery(this).position().top;
		                jQuery(this).css({top:__ctop-_scDiff});
		            });
				}
			    lastScroll = newScroll;
				
			});
			
			$(document).on('click','.mbtn',function(e) { e.preventDefault();
				jQuery(this).siblings('.mbtn').removeClass('active');
				jQuery(this).addClass('active');
				var _img_to_place = jQuery(this).attr('data-container');
				var _img_src = jQuery(this).attr('data-img');
				if(_img_to_place && _img_to_place != null){
					jQuery(_img_to_place).attr('src',_img_src);
				}
		    });
			
			jQuery(document).on('click','.filter_slider',function(e) { e.preventDefault();
				if(jQuery(this).data('position') == '1'){
					jQuery(this).data('position','2')
					jQuery('.list_filters').css('left','-100%');
					jQuery(this).html('<i class="fa fa-long-arrow-left"></i> BASIC FILTERS');

					$('.filters-panel.slide-1').addClass('slided');
					$('.filters-panel.slide-2').removeClass('slided');
				}else{
					jQuery(this).data('position','1');
					jQuery('.list_filters').css('left','0%');
					jQuery(this).html('ADVANCED FILTERS <i class="fa fa-long-arrow-right"></i>');

					$('.filters-panel.slide-1').removeClass('slided');
					$('.filters-panel.slide-2').addClass('slided');
				}
		    });
			
			 
			

			jQuery(document).on('click','.compareItems',function(e) {
				jQuery('.item-compare-list').addClass('getting-data');
				jQuery(this).hide();
				jQuery('.backTosearch').show();
				if(jQuery('.compare_item:checked').length > 0){
				var itemsToCpm = [];
				jQuery('.compare_item:checked').each(function(index, element) {
		            itemsToCpm.push(jQuery(this).closest('tr').attr('data-id'));
		        });	
				jQuery('.items-table-container').addClass('compare-shown');
				jQuery.ajax({
					url:BASE_URL+'index.php/packer/index/getCompare',
					data:{id:itemsToCpm},
					type:'POST',
					success:function(data){
						jQuery('#compareTable > tbody').html(data);
						jQuery('.item-compare-list').removeClass('getting-data');
					}
				});
				}
		    });

		    jQuery(document).on('click','.backTosearch',function(e){
				jQuery(this).hide();
				jQuery('.compareItems').show();
				jQuery('.items-table-container').removeClass('compare-shown');
			});
			
			jQuery(document).on('click','.addTocomparefromView',function(e){
				jQuery('.item_ajax_get_details[data-id="'+jQuery(this).attr('data-id')+'"]').find('.compare_item').prop('checked',true);
			});
			
		    jQuery(document).on('click','.closeItemInfo',function(e) { e.preventDefault();
		    	jQuery('.diamonds-table-header').removeClass('sidebar-open');
				jQuery('.cat-results').removeClass('shown-details');
		    });

			$(document).on('click','.item_ajax_get_details td',function(e) {

				if(!$(e.target).hasClass('compare_item')){
					$('.diamonds-table-header').addClass('sidebar-open');
					$('.diamonds-table').addClass('expanded');
				 	e.preventDefault();
					var _itemId = $(this).parent().attr('data-id');
					$('.cat-results').addClass('shown-details');
					$('.item-info-block').addClass('getting-data');
					$.ajax({
						url:BASE_URL+'index.php/packer/index/getProduct',
						data:{id:_itemId},
						type:'POST',
						success:function(data){
							data = JSON.parse(data);
							$('.item-info-ajax-container').html(data.html);
							$('.item-info-block').removeClass('getting-data');
							$('.more-item-info').attr('href', data.diamond_url);
						}
					});
				}
		    });
			
			$(document).on('click','.filter_trigger',function(e) { e.preventDefault();
				if($('.filters_div').is(':visible')){
					$('.adv-filters').fadeOut(150);
					$('.filters_div').slideUp(500);

					$(this).html('View Filters <i class="fa fa-long-arrow-down"></i>').removeClass('GREY_BG');
				}else{
					$('.filters_div').slideDown(500,function(){
						$('.adv-filters').fadeIn(500);
					});
					
					$(this).html('Hide Filters <i class="fa fa-long-arrow-up"></i>').addClass('GREY_BG');
				}
				
				$('.list_filters').css('width',$('.filters_div').width()*2);
				
		    });
			
		    var _redirectT;

		    function slidersInit( inputArray ){
				jQuery( ".rangeslider" ).each(function(index, element) {

			    	var _Min = parseFloat(jQuery(this).attr('data-min'));
					var _Max = parseFloat(jQuery(this).attr('data-max'));
					var _Minv = parseFloat(jQuery(this).attr('data-min-value'));
					var _Maxv = parseFloat(jQuery(this).attr('data-max-value'));

					// value: totalRows,
					function rangeSlide( event, ui ){
						var _rurl = jQuery(event.target).closest('.m-filter-item-list').find('.dataurl').val();
						var splitter = jQuery(event.target).closest('.m-filter-item-list').find('.dataurl').attr('data-split');
						var _prefix = jQuery(event.target).closest('.m-filter-item-list').find('.dataurl').attr('data-prefix');
						var _suffix = jQuery(event.target).closest('.m-filter-item-list').find('.dataurl').attr('data-suffix');
						if(typeof _suffix == 'undefined'){ _suffix = '';}

						var testRE = _rurl.match(splitter+"(.*)");
						
						jQuery(event.target).closest('.m-filter-item-list').find('.rangemin').val( _prefix+ui.values[ 0 ]+_suffix);
						// jQuery(event.target).parent().parent().find('.popup-header').find('.value-from').text( _prefix+ui.values[ 0 ]+_suffix );
						jQuery(event.target).closest('.filter_box').find('.slider .value-from').text( _prefix+ui.values[ 0 ]+_suffix );
						
						jQuery(event.target).closest('.m-filter-item-list').find('.rangemax').val(_prefix+ui.values[ 1 ]+_suffix);
						// jQuery(event.target).parent().parent().find('.popup-header').find('.value-to').text( _prefix+ui.values[ 1 ]+_suffix );
						jQuery(event.target).closest('.filter_box').find('.slider .value-to').text( _prefix+ui.values[ 1 ]+_suffix );

						
						if(_rurl.indexOf('&') > -1){
							testRE = _rurl.match(splitter+"(.*)&");	
						}
						if(testRE  != null){
							_rurl = _rurl.replace(testRE[1],ui.values[ 0 ]+'%2C'+ui.values[ 1 ]);
						}
					}

					if( jQuery(this).hasClass('carat-slider') ){

						jQuery(this).slider({
					      range: true,
					      min: _Min,
					      step: 0.01,
					      max: _Max,
					      values: [ _Minv, _Maxv ],

					      slide: function( event, ui ) {
							rangeSlide(event, ui);
						  },
						  stop: function( event, ui ){
						  	updateDiamondsContent( jQuery(this).attr('data-filter') , ui.values[0] , ui.values[1] );
						  }

					    });
					} else {
						jQuery(this).slider({
                            range: true,
                            min: _Min,
                            max: _Max,
                            minRange: 1,
                            values: [_Minv, _Maxv],
                            slide: function (event, ui) {
                                if (jQuery(this).hasClass('step_1_cut_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_color_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_clarity_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_clarity_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_polish_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_symmetry_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else if (jQuery(this).hasClass('step_1_fluorescence_range')) {
                                    if (ui.values[1] - ui.values[0] < 1) {
                                        return false;
                                    }
                                }
                                else {
                                    rangeSlide(event, ui);
                                }
                            },
                            stop: function (event, ui) {
                                updateDiamondsContent(jQuery(this).attr('data-filter'), ui.values[0], ui.values[1]);
                            }

                        });
						
					}

				
					if(jQuery(this).attr('data-disabled') == 'true'){
						jQuery(this).slider( "option", "disabled", true ); 
						jQuery(this).closest('.m-filter-item-list').addClass('disable-range');   
					}
				});

			}

			slidersInit();


			// Append mobile values

			$(document).ready(function(){

				$('.mobile-controls').on('click',function(){
					$('.filter_value').removeClass('display-mobile');
					var _class = $(this).attr('data-control');
					$('.filter_box.' + _class + ' .filter_value').addClass('display-mobile');
				});

				$('.filter_box').each(function(){
					var _class = $(this).find('.mobile-controls').attr('data-control');

					$(this).find('.mobile-controls .value-from').text(function(){
						return $('.filter_box.' + _class + ' input.form-control.rangemin').val();
					});

					$(this).find('.popup-header .value-from').text(function(){
						return $('.filter_box.' + _class + ' input.form-control.rangemin').val();
					});

					$(this).find('.popup-header .value-to').text(function(){
						return $('.filter_box.' + _class + ' input.form-control.rangemax').val();
					});

					$(this).find('.mobile-controls .value-to').text(function(){
						return $('.filter_box.' + _class + ' input.form-control.rangemax').val();
					});
				})

				if( diamondsParamsURL ){
					var resArray = diamondsParamsURL;
					resArray.cut = ["GD", "VG", "EX", "Signature Ideal"];
					setUIconfig( resArray );	
				}
				

				$('.close-values').on('click',function(){
					$(this).closest('.filter_value').removeClass('display-mobile');
				});


			});
			

			jQuery('[data-toggle="tooltip"]').tooltipp();
			jQuery(".bSwitch").bootstrapSwitch();
			 

			jQuery('.bSwitch').on('switchChange.bootstrapSwitch', function(event, state) {
				if(state == true){
				 	jQuery(this).closest('.filter_box').find('.rangeslider').slider( "option", "disabled", false );
					jQuery(this).closest('.filter_box').find('.m-filter-item-list').removeClass('disable-range');   
					$('.diamonds-table').addClass('save-space');
				}else{
				 	jQuery(this).closest('.filter_box').find('.rangeslider').slider( "option", "disabled", true );
					jQuery(this).closest('.filter_box').find('.m-filter-item-list').addClass('disable-range');   
					$('.diamonds-table').removeClass('save-space');
				}
			});

			
			function toggleColumns( inputName ){
				jQuery('.' + inputName + ' .bSwitch').on('switchChange.bootstrapSwitch', function(event, state) {
					var classToToggle = 'visible-col-' + inputName;
					jQuery('.item-list-table').toggleClass(classToToggle);
				});
			}

			toggleColumns('fluorescence');
			toggleColumns('depth');
			toggleColumns('_table');



			var ajaxPageCount = 1;
			var ajaxStop = false;
			var itemId = 101;
			var contentLoadingState = false;

			var cutOptionsArray = { 
				0: ['GD'],
				1: ['GD','VG'],
				2: ['VG','EX'],
				3: ['EX','Signature Ideal'],
				4: ['Signature Ideal','H&A'],
				5: ['H&A']
			};

			var colorOptionsArray = {
				0: ['K'],
				1: ['K','J'],
				2: ['J','I'],
				3: ['I','H'],
				4: ['H','G'],
				5: ['G','F'],
				6: ['F','E'],
				7: ['E','D'],
				8: ['D']
			};

			var clarityOptionsArray = {
				0: ['SI2'],
				1: ['SI2','SI1'],
				2: ['SI1','VS2'],
				3: ['VS2','VS1'],
				4: ['VS1','VVS2'],
				5: ['VVS2','VVS1'],
				6: ['VVS1','IF'],
				7: ['IF','FL'],
				8: ['FL']
			};

			var polishOptionsArray = {
				0: ['GD'],
				1: ['GD','VG'],
				2: ['VG','EX'],
				3: ['EX',],
			};

			var symmetryOptionsArray = {
				0: ['GD'],
				1: ['GD','VG'],
				2: ['VG','EX'],
				3: ['EX',],
			};

			var fluorescenceOptionsArray = {
				0: ['NONE'],
				1: ['NONE','FAINT'],
				2: ['FAINT','MEDIUM'],
				3: ['MEDIUM','STRONG'],
				4: ['STRONG','VSTRONG'],
				5: ['VSTRONG']
			};

			var shapesOptionsArray = {
				25: 'RD',
				61: 'PS',
				59: 'EC', //EMERALD ??
				23: 'HS', //HEART ??
				24: 'PR',
				58: 'CU',
				56: 'RA',
				26: 'OV',
				57: 'AS',
				60: 'MQ',
			}

			var totalContentItems;
			var totalContentPages;


			function toggleCutFilter( state ){
				switch (state){
					case 'disable':
							$('.cut-range').addClass('disable-range');
							$('.cut-range').find('.rangeslider').addClass('ui-state-disabled','ui-slider-disabled');
							diamondsParamsURL.cut = [];
							$('.cut-range .rangeslider').slider('values', 0, 0);
							$('.cut-range .rangeslider').slider('values', 1, 4);
						break;

					case 'enable':
							$('.cut-range').removeClass('disable-range');
							$('.cut-range').find('.rangeslider').removeClass('ui-state-disabled','ui-slider-disabled');

						break;
				}
			}

			function setShapeValues(array){
				var shapesToRender = [];
				array.each(function(entry){
					shapesToRender.push( stepsOfGood(entry) );
				});
				$('.filter_box.shape .values').text(shapesToRender);
			}


			function setUIconfig( inputArray ){

				slidersInit();
				
				jQuery('.shapes-filter .ajax-filter').removeClass('checked-clr');

				if( inputArray.shape ){
					jQuery('.shapes-filter .ajax-filter').each(function(){
						var thiz = jQuery(this);

						inputArray.shape.each(function(entry){
							if( entry == shapesOptionsArray[thiz.attr('data-value')] ){
								thiz.addClass('checked-clr');
							} 	
						});	
						
					});

					setShapeValues(inputArray.shape);
				}


				jQuery('.prices input.rangemin').val('$ ' + inputArray.price_from);
				jQuery('.prices .rangeslider').slider('values',0, inputArray.price_from );
				jQuery('.prices input.rangemax').val('$ ' + inputArray.price_to);
				jQuery('.prices .rangeslider').slider('values',1, inputArray.price_to );


				jQuery('.carat input.rangemin').val( ' ' + inputArray.carat_from);
				jQuery('.carat .rangeslider').slider('values',0, inputArray.carat_from);
				jQuery('.carat input.rangemax').val( ' ' + inputArray.carat_to);
				jQuery('.carat .rangeslider').slider('values',1, inputArray.carat_to);


				jQuery('.depth input.rangemin').val( ' ' + inputArray.depth_from + '%');
				jQuery('.depth .rangeslider').slider('values',0, inputArray.depth_from);
				jQuery('.depth input.rangemax').val( ' ' + inputArray.depth_to + '%');
				jQuery('.depth .rangeslider').slider('values',1, inputArray.depth_to);


				jQuery('.table-range input.rangemin').val( ' ' + inputArray.table_from + '%');
				jQuery('.table-range .rangeslider').slider('values',0, inputArray.table_from);
				jQuery('.table-range input.rangemax').val( ' ' + inputArray.table_to + '%');
				jQuery('.table-range .rangeslider').slider('values',1, inputArray.table_to);


				allColors 		= ["K", "J", "I", "H", "G", "F", "E", "D",];
				allClarity 		= ["SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1", "IF", "FL"];
				allCut 			= ["GD", "VG", "EX", "Signature Ideal"];
				allPolish 		= ['GD','VG','EX'];
				allSymmetry		= ['GD','VG','EX'];
				allFluorescence	= ["NONE", "FAINT", "MEDIUM", "STRONG", "VSTRONG"];



				function setRangeSlider( instanceArray, currentArray, selector ){
					if( typeof currentArray != 'undefined' ){
						if( currentArray == '' ){
							currentArray = instanceArray;	
						}
						var currentColorsArray = currentArray;
						var valueFrom 		= instanceArray.indexOf(currentArray[0]);
						var lastElement 	= currentColorsArray[ currentColorsArray.length - 1];
						var valueTo   		= instanceArray.indexOf( lastElement ) + 1;
						jQuery( selector + ' .rangeslider').slider('values',0, valueFrom);
						jQuery( selector + ' .rangeslider').slider('values',1, valueTo);

						var selector = selector.slice(1, selector.indexOf('-range') );
						setValuesForMobile(selector, valueFrom, valueTo);
					}
				}

				function setRangeSliderCut( instanceArray, currentArray, selector ){
					if( typeof currentArray != 'undefined' ){
						if( currentArray == '' ){
							currentArray = instanceArray;
						}

						if( inputArray.cut.indexOf('H') > -1 ){
							inputArray.cut.splice( inputArray.cut.indexOf('H') , 1);
						}
						var currentColorsArray = currentArray;
						var valueFrom 		= instanceArray.indexOf(currentArray[0]);
						var lastElement 	= currentColorsArray[ currentColorsArray.length - 1];
						var valueTo   		= instanceArray.indexOf( lastElement ) + 1;
						jQuery( selector + ' .rangeslider').slider('values',0, valueFrom);
						jQuery( selector + ' .rangeslider').slider('values',1, valueTo);

						setValuesForMobile('cut', valueFrom, valueTo);
					}
				}

				setRangeSlider( allColors, inputArray.color, '.color-range');
				setRangeSlider( allClarity, inputArray.clarity, '.clarity-range');
				setRangeSliderCut( allCut, inputArray.cut, '.cut-range');
				setRangeSlider( allPolish, inputArray.polish, '.polish-range');
				setRangeSlider( allSymmetry, inputArray.symmetry, '.symmetry-range');
				setRangeSlider( allFluorescence, inputArray.fluorescence, '.fluorescence-range');


				jQuery('.table-header').removeClass('sorting');
			}


			jQuery('#Reset_filters').on('click',function(){

				diamondsParamsURL = {

					page: 				1,
					shape: 				['RD','RA','PS','PR','OV','MQ','HS','EC','CU','AS'],
					price_from:  		price_from,
			     	price_to:  			price_to,
					carat_from:  		carat_from,
			        carat_to: 			carat_to,
			        cut: 				["GD", "VG", "EX", "Signature Ideal"],
			        color: 				["K", "J", "I", "H", "G", "F", "E", "D"],
			        clarity: 			["SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1", "IF", "FL"],
			        polish: 			['GD','VG','EX'],
			        symmetry: 			['GD','VG','EX'],
			        fluorescence: 		["NONE", "FAINT", "MEDIUM", "STRONG", "VSTRONG"],
			        depth_from:  		depth_min,
			        depth_to:  			depth_max,
			        table_from:   		table_min,
			        table_to:  			table_max,
					sort: 				'ASC',
					sort_field: 		'diamonds_price'

				};

				setUIconfig( diamondsParamsURL );
				diamondsParamsURL.cut.push("H&A");
				getDiamondsContent( diamondsParamsURL, true );
			});



			function compareArrays( array1 , array2 ){
				var list1 	= array1;
				var list2 	= array2;
				var lookup  = {};
				var results = [];

				for (var j in list2) {
				    lookup[list2[j]] = list2[j];
				}

				for (var i in list1) {
				    if (typeof lookup[list1[i]] != 'undefined') {
				        
			            if( typeof list1[i] == 'string' ){
			            	// console.log( list1[i] );
						    results+= list1[i];
			             }
				 	} 
				}
				
				return results;
			}

			function filterArrRangeSimilar( min, max, array ){
				var newResults = [];
				for( min; min<max; min++ ){
					newResults.push( compareArrays( array[min] , array[min+1] ) );
				}
				return newResults;
			}



			if( ( typeof price_from !== 'undefined' ) && 
				( typeof price_to 	!== 'undefined' ) && 
				( typeof carat_from !== 'undefined' ) && 
				( typeof carat_to 	!== 'undefined' ) && 
				( typeof depth_min 	!== 'undefined' ) && 
				( typeof depth_max 	!== 'undefined' ) && 
				( typeof table_min 	!== 'undefined' ) && 
				( typeof table_max 	!== 'undefined' )
			  ){

				var diamondsParamsURL = {

					page: 				1,
					pages: 				window.diamondTotalPages,
					shape: 				['RD','RA','PS','PR','OV','MQ','HS','EC','CU','AS'],
					price_from:  		price_from,
			     	price_to:  			price_to,
					carat_from:  		carat_from,
			        carat_to: 			carat_to,
			        cut: 				["GD", "VG", "EX", "Signature Ideal", "H&A"],
			        color: 				[ "K","J", "I", "H", "G", "F", "E", "D",],
			        clarity: 			["SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1", "IF", "FL"],
			        polish: 			['GD','VG','EX'],
			        symmetry: 			['GD','VG','EX'],
			        fluorescence: 		["NONE", "FAINT", "MEDIUM", "STRONG", "VSTRONG"],
			        depth_from:  		depth_min,
			        depth_to:  			depth_max,
			        table_from:   		table_min,
			        table_to:  			table_max,
					sort: 				'ASC',
					sort_field: 		'diamonds_price',
					lastSortedBy: 		'price'

				};

			}



			function parseURLParams(url) {
				var queryStart = url.indexOf("?") + 1,
					queryEnd   = url.indexOf("#") + 1 || url.length + 1,
					query = url.slice(queryStart, queryEnd - 1),
					pairs = query.replace(/\+/g, " ").split("&"),
					parms = {}, i, n, v, nv;

				if (query === url || query === "") {
					return;
				}

				for (i = 0; i < pairs.length; i++) {
					nv = pairs[i].split("=");
					n = decodeURIComponent(nv[0]);
					v = decodeURIComponent(nv[1]);

					if (!parms.hasOwnProperty(n)) {
						parms[n] = [];
					}

					v = v.split(',');

					parms[n].push(nv.length === 2 ? v : null);
				}
				return parms;
			}



			urlString = window.location.search;
			urlParams = parseURLParams(urlString);


			if(urlParams){

				diamondsParamsURL = {
					page: 1
				};

				if( urlParams.shape ){
					diamondsParamsURL.shape = urlParams.shape[0];
				}

				if( urlParams.price_from ){
					diamondsParamsURL.price_from = urlParams.price_from[0][0];
				} else {
					diamondsParamsURL.price_from = price_from;
				}

				if( urlParams.price_to ){
					diamondsParamsURL.price_to = urlParams.price_to[0][0];
				} else {
					diamondsParamsURL.price_to = price_to;
				}

				if( urlParams.carat_from ){
					diamondsParamsURL.carat_from = urlParams.carat_from[0][0];
				} else {
					diamondsParamsURL.carat_from = carat_from;
				}
				if( urlParams.carat_to ){
					diamondsParamsURL.carat_to = urlParams.carat_to[0][0];
				} else {
					diamondsParamsURL.carat_to = carat_to;
				}

				if( urlParams.cut ){
					diamondsParamsURL.cut = urlParams.cut[0];
				} else {
					diamondsParamsURL.cut = ["GD", "VG", "EX", "Signature Ideal"];
				}

				if( urlParams.color ){
					diamondsParamsURL.color = urlParams.color[0];
				} else {
					diamondsParamsURL.color = ["K", "J", "I", "H", "G", "F", "E", "D"];
				}

				if( urlParams.clarity ){
					diamondsParamsURL.clarity = urlParams.clarity[0];
				} else {
					diamondsParamsURL.clarity = ["SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1", "IF", "FL"];
				}

				if( urlParams.polish ){
					diamondsParamsURL.polish = urlParams.polish[0];
				} else {
					diamondsParamsURL.polish = ['GD','VG','EX'];
				}

				if( urlParams.symmetry ){
					diamondsParamsURL.symmetry = urlParams.symmetry[0];
				} else {
					diamondsParamsURL.symmetry = ['GD','VG','EX'];
				}

				if( urlParams.fluorescence ){
					diamondsParamsURL.fluorescence = urlParams.fluorescence[0];
				} else {
					diamondsParamsURL.fluorescence = ["NONE", "FAINT", "MEDIUM", "STRONG", "VSTRONG"];
				}

				if( urlParams.depth_from ){
					diamondsParamsURL.depth_from = urlParams.depth_from[0];
				} else {
					diamondsParamsURL.depth_from = depth_min;
				}

				if( urlParams.depth_to ){
					diamondsParamsURL.depth_to = urlParams.depth_to[0];
				} else {
					diamondsParamsURL.depth_to = depth_max;
				}

				if( urlParams.table_from ){
					diamondsParamsURL.table_from = urlParams.table_from[0];
				} else {
					diamondsParamsURL.table_from = table_min;
				}

				if( urlParams.table_to ){
					diamondsParamsURL.table_to = urlParams.table_to[0];
				} else {
					diamondsParamsURL.table_to = table_max;
				}
				if( urlParams.sort ){
					diamondsParamsURL.sort = urlParams.sort[0];
				} else {
					diamondsParamsURL.sort = 'ASC';
				}

				if( urlParams.sort_field ){
					diamondsParamsURL.sort_field = urlParams.sort_field[0];
				} else {
					diamondsParamsURL.sort_field = 'diamonds_price';
				}

				if( urlParams.lastSortedBy ){
					diamondsParamsURL.lastSortedBy = urlParams.lastSortedBy[0];
				} else {
					diamondsParamsURL.lastSortedBy = 'price';
				}


				setUIconfig( diamondsParamsURL );

				if( urlParams.cut ){
					if( urlParams.cut[0].indexOf("Signature Ideal") > -1 ){
						urlParams.cut[0].push('H&A');
					}
				}

				getDiamondsContent( diamondsParamsURL, true );
				jQuery('a.filter_trigger').click();
			}

			function getDiamondsContent( params, isFiltering ){
                                
                                

			        jQuery('.loader-diamonds-results').addClass('loader-show'); 
				
				if( isFiltering ){
					ajaxPageCount = 1;
					diamondsParamsURL.page = ajaxPageCount;
					diamondsParamsURL.sort_field = 'diamonds_price';
					diamondsParamsURL.sort = 'ASC';
					jQuery('.table-header').removeClass('sorting');
				}

				console.log( diamondsParamsURL );

				if (history.pushState) {
					var newurl = window.location.protocol 
					+ "//" + window.location.host + window.location.pathname 
					+ '?shape=' 		+ diamondsParamsURL.shape
					+ '&price_from=' 	+ diamondsParamsURL.price_from
					+ '&price_to='		+ diamondsParamsURL.price_to
					+ '&carat_from=' 	+ diamondsParamsURL.carat_from
					+ '&carat_to=' 		+ diamondsParamsURL.carat_to
					+ '&cut='			+ diamondsParamsURL.cut
					+ '&color='			+ diamondsParamsURL.color
					+ '&clarity='		+ diamondsParamsURL.clarity
					+ '&polish='		+ diamondsParamsURL.polish
					+ '&symmetry='		+ diamondsParamsURL.symmetry
					+ '&fluorescence='	+ diamondsParamsURL.fluorescence
					+ '&depth_from=' 	+ diamondsParamsURL.depth_from
					+ '&depth_to=' 		+ diamondsParamsURL.depth_to
					+ '&table_from=' 	+ diamondsParamsURL.table_from
					+ '&table_to=' 		+ diamondsParamsURL.table_to
					+ '&sort=' 			+ diamondsParamsURL.sort
					+ '&sort_field=' 	+ diamondsParamsURL.sort_field
					+ '&lastSortedBy=' 	+ diamondsParamsURL.lastSortedBy
					window.history.pushState({path:newurl},'',newurl);
				}

				if( params.shape.indexOf('RD') === -1 ){
					toggleCutFilter('disable');
				} else {
					toggleCutFilter('enable');
				}

				jQuery.post(BASE_URL+'diamonds/ajax/filter/' , 
						params , 
						function(data){
							data = JSON.parse(data);
							totalContentItems = data.count;
							totalContentPages = data.pages;
							diamondsParamsURL.pages = data.pages;
							currencySymbol =data.currencySymbol;
							console.log(data);

							data = data.data;
							renderFilteredElements( data , true );
						});
			}

			function setValuesForMobile(target, min, max){
				if( $('.filter_box').hasClass(target) ){
					var arrTarget;
					switch(target){
						case 'cut':
							arrTarget = allCut;
							break;

						case 'color':
							arrTarget = allColors;
							break;

						case 'clarity':
							arrTarget = allClarity;
							break;

						case 'polish':
							arrTarget = allPolish;
							break;

						case 'symmetry':
							arrTarget = allSymmetry;
							break;

						case 'fluorescence':
							arrTarget = allFluorescence;
							break;

						default:
							arrTarget = 'undefined';
							var _prefix = $('.filter_box.' + target + ' .dataurl').attr('data-prefix');
							var _suffix = $('.filter_box.' + target + ' .dataurl').attr('data-suffix');

							if(typeof _prefix == 'undefined'){ _prefix = '';}
							if(typeof _suffix == 'undefined'){ _suffix = '';}

							$('.filter_box.' + target + ' .popup-header').find('.value-from').text( _prefix + min + _suffix );
							$('.filter_box.' + target + ' .mobile-controls').find('.value-from').text( _prefix + min + _suffix );
							
							$('.filter_box.' + target + ' .popup-header').find('.value-to').text( _prefix + max + _suffix );
							$('.filter_box.' + target + ' .mobile-controls').find('.value-to').text( _prefix + max + _suffix );

							break;
					}

					if( arrTarget !== 'undefined' ){
						// console.log( arrTarget );
						$('.filter_box.' + target + ' .popup-header .value-from').text( stepsOfGood(arrTarget[min]) );
						$('.filter_box.' + target + ' .mobile-controls .value-from').text( stepsOfGood(arrTarget[min]) );
						
						$('.filter_box.' + target + ' .popup-header .value-to').text( stepsOfGood(arrTarget[max-1]) );
						$('.filter_box.' + target + ' .mobile-controls .value-to').text( stepsOfGood(arrTarget[max-1]) );	
					}
					
				}
			}

			function updateDiamondsContent( target , min , max , array ){
				// array value is going to be used for multiple diamonds
				console.log( target );
				console.log( min );
				console.log( max );

				switch(target){
					case 'price':
							diamondsParamsURL.price_from = min;
							diamondsParamsURL.price_to   = max;
						break;

					case 'd_depth':
							diamondsParamsURL.depth_from = min;
							diamondsParamsURL.depth_to   = max;
						break;

					case 'd_carat':
							diamondsParamsURL.carat_from = min;
							diamondsParamsURL.carat_to   = max;
						break;

					case 'd_table':
							diamondsParamsURL.table_from = min;
							diamondsParamsURL.table_to   = max;
						break;

					case 'd_cut':
							if( max == 4 ){ max = 5 }
							jQuery('.shapes-filter .ajax-filter').removeClass('checked-clr');
							jQuery('.shapes-filter .ajax-filter[data-value="25"]').addClass('checked-clr');
							diamondsParamsURL.shape = ['RD'];

							diamondsParamsURL.cut = filterArrRangeSimilar( min, max, cutOptionsArray );

							if( max == 5 ){ max = 4 }
						break;

					case 'd_color':
							diamondsParamsURL.color = filterArrRangeSimilar( min, max, colorOptionsArray );
						break;

					case 'd_clarity':
							diamondsParamsURL.clarity = filterArrRangeSimilar( min, max, clarityOptionsArray );
						break;

					case 'd_polish':
							diamondsParamsURL.polish = filterArrRangeSimilar( min, max, polishOptionsArray );
						break;

					case 'd_symmetry':
							diamondsParamsURL.symmetry = filterArrRangeSimilar( min, max, symmetryOptionsArray );
						break;

					case 'd_fluorescence':
							diamondsParamsURL.fluorescence = filterArrRangeSimilar( min, max, fluorescenceOptionsArray );
						break;

					default: 
						break;
				}

				if( target ){
					target.indexOf('d_') > -1 ? target = target.slice( 2, target.length ) : target=target ;	
					target == 'table' ? target = '_table' : target = target;
				}
				
				setValuesForMobile( target, min, max);

				getDiamondsContent( diamondsParamsURL, true );
			}

			// Sorting
			jQuery('.table-header').on('click',function(){
				var thiz = jQuery(this);
				var sortField = thiz.attr('data-sort');
				jQuery('.table-header').removeClass('sorting');
				thiz.addClass('sorting');

				if( diamondsParamsURL.lastSortedBy != sortField ){
					diamondsParamsURL.sort = 'ASC';
					thiz.addClass('asc');
					thiz.removeClass('desc');
				} else {
					if( diamondsParamsURL.sort == 'ASC' ){
						diamondsParamsURL.sort = 'DESC';	
						thiz.addClass('desc');
						thiz.removeClass('asc');
					} else {
						diamondsParamsURL.sort = 'ASC';
						thiz.addClass('asc');
						thiz.removeClass('desc');
					}		
				}

				diamondsParamsURL.sort_field = sortField;
				diamondsParamsURL.lastSortedBy = sortField;
				diamondsParamsURL.page = 1;
				getDiamondsContent( diamondsParamsURL );
			});



			$('.diamonds-table-content').on('click',function(){
				// $('.diamonds-table').addClass('expanded');
			});

			$('.closeItemInfo').on('click',function(){
				$('.diamonds-table').removeClass('expanded');
			});



			jQuery('.shapes-filter .ajax-filter').on('click',function(){
				
				setTimeout(function(){
					var shapesArray = [];
					jQuery('.shapes-filter .checked-clr').each(function(){
						var key = jQuery(this).attr('data-value');
						shapesArray.push( shapesOptionsArray[key] );
					});
					// console.log( shapesArray );
					diamondsParamsURL.shape = shapesArray;

					diamondsParamsURL.cut = [];
							$('.cut-range .rangeslider').slider('values', 0, 0);
							$('.cut-range .rangeslider').slider('values', 1, 4);
					getDiamondsContent( diamondsParamsURL, true );

					setShapeValues( diamondsParamsURL.shape );
				},100);
				
			});


			function stepsOfGood( input ){
						var output;
						switch(input) {

							// Sapes
							case 'CU':
						        output = 'Cusion';
						        break;

						    case 'EC':
						        output = 'Emerald';
						        break;

						    case 'HS':
						        output = 'Heart';
						        break;

						    case 'MQ':
						        output = 'Marquise';
						        break;

						    case 'OV':
						        output = 'Oval';
						        break;

						    case 'PR':
						        output = 'Pear';
						        break;

						    case 'PS':
						        output = 'Princess';
						        break;

						    case 'RA':
						        output = 'Radiant';
						        break;

						    case 'RD':
						        output = 'Round';
						        break;

						    case 'AS':
						        output = 'Asscher';
						        break;


							case 'FR':
						        output = 'Fair';
						        break;
						   
						    case 'GD':
						        output = 'Good';
						        break;
						    
						    case 'VG':
						        output = 'Very Good';
						        break;
						   
						   	case 'EX':
						        output = 'Excellent';
						        break;

						    case 'Signature Ideal':
						        output = 'Signature Ideal';
						        break;
						    
						    case 'H&A':
						        output = 'Signature Ideal';
						        break;

						    case 'VSTRONG':
						        output = 'Extreme';
						        break;

						    case 'STRONG':
						        output = 'Strong';
						        break;

						    case 'MEDIUM':
						        output = 'Medium';
						        break;

						    case 'FAINT':
						        output = 'Faint';
						        break;

						    case 'NONE':
						        output = 'None';
						        break;


						    default:
						    	if( input == 'undefined' ){
						    		output = '';	
						    	} else {
						    		output = input;
						    	}
						    	
						    	break;					    
						}
						return output;
					}


			function renderFilteredElements( inputArray , isFiltering ){
				
				if( isFiltering ){
					ajaxPageCount = 1;
					jQuery('table.diamonds-table-content').html('');

					jQuery('.odometer').html(totalContentItems);
				}

				inputArray.each(function(entry){

					var cut = '';

					cut = stepsOfGood( entry.diamond_cut );
					polish = stepsOfGood( entry.diamond_polish );
					symmetry = stepsOfGood( entry.diamond_symmetry );

					var diamondPrice = parseFloat( entry.price );
					diamondPrice = diamondPrice.toFixed(2);

					var depth = parseFloat( entry.diamond_depth );
					depth = depth.toFixed(2);


					var shape = entry.diamond_shape;
					var imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/round.png';
					if( shape == 'RD'){
						shape = 'ROUND';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/round.png';
					} else if( shape == 'PS' ){
						shape = 'Princess';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/princess.png';
					} else if( shape == 'EC' ){
						shape = 'Emerald';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/emerald.png';
					} else if( shape == 'HS' ){
						shape = 'Heart';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/heart.png';
					}  else if( shape == 'PR' ){
						shape = 'Pear';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/pear.png';
					} else if( shape == 'CU' ){
						shape = 'Cushion';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/cushion.png';
					} else if( shape == 'RA' ){
						shape = 'Radiant';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/radiant.png';
					} else if( shape == 'OV' ){
						shape = 'Oval';
						imgUrl = BASE_URL+'/skin/frontend/base/default/packer/images/diamonds/oval.png';
					} else if( shape == 'AS' ){
						shape = 'Asscher';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/asscher.png';
					} else if( shape == 'MQ' ){
						shape = 'Marquise';
						imgUrl = BASE_URL+'skin/frontend/base/default/packer/images/diamonds/marquise.png';
					}


					var elementToAppend = '<tr data-id="' + entry.entity_id + '" class="item_ajax_get_details">' +
			                '<td class="cell-compare"><input class="compare_item" type="checkbox" name="chk[ ]" value=""></td>' +
			                '<td class="cell-shape text-center list-img-label text-uppercase"><img src="' + imgUrl + '" width="auto" height="20" alt=""> <br> ' + shape + '</td>' +
			                '<td class="cell-carat">' + entry.diamond_carat + '</td>' +
			                '<td class="cell-color">' + entry.diamond_color + '</td>' +
			                '<td class="cell-clarity">' + entry.diamond_clarity + '</td>' +

			                '<td class="cell-fluorescence">' + entry.diamond_fluorescence + '</td>' +
			                '<td class="cell-depth">' + depth + '</td>' +
			                '<td class="cell-_table">' + entry.table_field + '</td>' +

			                '<td class="cell-cut">' + cut + '</td>' +
			                '<td class="cell-polish">' + polish + '</td>' +
			                '<td class="cell-symm">' + symmetry + '</td> ' +
			                '<td class="cell-price">'+ currencySymbol + diamondPrice + ' <i class="fa fa-arrow-right pl30"></i></td>'+
						'</tr>';

					if( isFiltering ){
						jQuery('table.diamonds-table-content').append(elementToAppend);	
					} else {
						jQuery('table.diamonds-table-content tr:last-child').parent().append(elementToAppend);
					}
					
				});

				if( isFiltering ){

					$('.content-diamonds').mCustomScrollbar('destroy')
					$('.content-diamonds').mCustomScrollbar({
						scrollInertia:150,
						theme:"dark",
				        scrollButtons:{
				            enable:true
				        },
				        callbacks:{

						    onTotalScroll: function(){
						    	loadDiamondsContentOnScroll();
						    }
						}
				    });

					setTimeout(function(){
						jQuery('.loader-diamonds-results').removeClass('loader-show');
					},200);

				}
			}

			function loadDiamondsContentOnScroll(){

				// console.log( diamondsParamsURL.page );
				// console.log( diamondsParamsURL.pages );

				if( !contentLoadingState ){

			    	if( !ajaxStop ){

			    		if( diamondsParamsURL.page < diamondsParamsURL.pages ){

				    		ajaxPageCount++;	
					    	diamondsParamsURL.page = ajaxPageCount;

				    		console.log( diamondsParamsURL );
				    		contentLoadingState = true;

				    		jQuery('.loader-diamonds-results').addClass('loader-show');
				    		var requestUrl = BASE_URL+'diamonds/ajax/filter/';
					    	
					    	jQuery.post( requestUrl , diamondsParamsURL ,function(data){ 
					    		
					    		data = JSON.parse(data);
					    		console.log(data);
					    		diamondsParamsURL.pages = data.pages;

					    		data = data.data;
					    		
					    		renderFilteredElements( data );			    	
						    	
					    	}).done(function( data ){
					    		$('.content-diamonds').mCustomScrollbar('destroy')
					    		$('.content-diamonds').mCustomScrollbar({
									scrollInertia:150,
									theme:"dark",
							        scrollButtons:{
							            enable:true
							        },
							        callbacks:{

									    onTotalScroll: function(){
									    	loadDiamondsContentOnScroll();
									    }
									}
							    });

					    		scrollBack();
					    		setTimeout(function(){
					    			jQuery('.loader-diamonds-results').removeClass('loader-show');
					    		},200);

					    		if( ajaxPageCount >= parseInt(window.diamondTotalPages) ){
					    			ajaxStop = true;
					    		}

					    		contentLoadingState = false;
					    	});

					    }

				    }
				}

			}

		}
	});
});
