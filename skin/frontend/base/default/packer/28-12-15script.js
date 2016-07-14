function subsSetcookie(){
    jQuery.cookie('newsletterSubscribe', 'true', {
        expires: 1,
        path: '/'
    });
}

function formatDollar(num) {
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}

function isRFC822ValidEmail(sEmail) {

    var sQtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
    var sDtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
    var sAtom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
    var sQuotedPair = '\\x5c[\\x00-\\x7f]';
    var sDomainLiteral = '\\x5b(' + sDtext + '|' + sQuotedPair + ')*\\x5d';
    var sQuotedString = '\\x22(' + sQtext + '|' + sQuotedPair + ')*\\x22';
    var sDomain_ref = sAtom;
    var sSubDomain = '(' + sDomain_ref + '|' + sDomainLiteral + ')';
    var sWord = '(' + sAtom + '|' + sQuotedString + ')';
    var sDomain = sSubDomain + '(\\x2e' + sSubDomain + ')*';
    var sLocalPart = sWord + '(\\x2e' + sWord + ')*';
    var sAddrSpec = sLocalPart + '\\x40' + sDomain; // complete RFC822 email address spec
    var sValidEmail = '^' + sAddrSpec + '$'; // as whole string
    var reValidEmail = new RegExp(sValidEmail);

    if (reValidEmail.test(sEmail)) {
        return true;
    }

    return false;
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}


function showSweetCart(params){

	// Params:
	// url, name, message, btnCart, btnClose, btnViewRing
	var btnViewRingUrl = params.btnViewRingUrl ? params.btnViewRingUrl : '';
	var btnViewRing = params.btnViewRing ? btnViewRing = '<button data-url="' + btnViewRingUrl + '" class="button go-to-ring"><span><span>View Ring</span></span></button>' : '';
	var btnCart  = params.btnCart ? btnCart = '<button class="button go-to-cart"><span><span>View Cart</span></span></button>' : '';
	var btnClose = params.btnClose ? btnClose = '<button href="javascript:;" class="button sa-close"><span><span>Continue (<b class="countdown">5</b>)</span></span></button>' : '';
	var btnToStep2 = params.btnToStep2 ? btnToStep2 = '<button href="javascript:;" class="button sa-go-to-2"><span><span>Continue (<b class="countdown">5</b>)</span></span></button>' : '';

	swal({
		title: "Success",
		type: 'success',
		html:true,
		text:     '<table class="sw-confirm" width="100%" cellpadding="0" cellspacing="0" border="0" >'
			+     '	<tr>'
			+     '		<td width="">'
			+     '			<img style="width:115px;" src="' + params.url + '" alt="" />'
			+     '		</td>'
			+     '		<td style="font-size:16px;">'
			+     '			<table class="sw-confirm" width="100%" cellpadding="0" cellspacing="0" border="0" >'
			+     '				<tr>'
			+     '					<td style="font-size: 14px; padding-bottom: 4px;">'
			+     '						Product "<strong>' + params.name + '</strong>" <br>' + params.message
			+     '					</td>'
			+     '				</tr>'
			+     '				<tr>'
			+     '					<td>'
			+     '						' + btnCart + ' ' + btnViewRing + ' ' + btnClose + ' ' + btnToStep2 
			+     '					</td>'
			+     '				</tr>'
			+     '			</table>'
			+     '		</td>'
			+     '	</tr>'
			+     '	<tr>'
			+     '		<td>'
			+     '		</td>'
			+     '		<td>'
			+     '			<br>'
			+     '		</td>'
			+     '	</tr>'
			+     '	<tr>'
			+     '	<td>'
			+     '		'
			+     '	</td>'
			+     '	<td>'
			+     '		'
			+     '	</td>'
			+     '	</tr>'
			+     '</table>'
	});

	jQuery('.sa-close').on('click',function(){
		jQuery('.confirm').click();
		clearInterval(refreshIntervalId);
		i = 5;
	});

	jQuery('.go-to-cart').on('click',function(){
		window.location = '/checkout/cart/';
	});

	jQuery('.go-to-ring').on('click',function(){
		jQuery('.sidebar-container').addClass('closed');
		window.location = jQuery(this).attr('data-url');
	});

	jQuery('.sa-go-to-2').on('click',function(){
		jQuery('.confirm').click();
		clearInterval(refreshIntervalId);
		i = 5;
		requestStep2( params.currentUrl, params.diamond_id, params.onlyUrl);
		flag = 1;
	});



	var i = 5;
	var refreshIntervalId = setInterval(function(){
		if( i > 0){
			i--;
			jQuery('.countdown').text(i);	

		} else {
			jQuery('.confirm').click();
			clearInterval(refreshIntervalId);
		}
	},1000);
}	


function renderSidebarContent(){

	jQuery('.loader-sidebar').addClass('loader-show');

	jQuery.post(BASE_URL+'diamonds/ajax/sidebarinfo/',{},function(response){
		var response = JSON.parse(response);
		console.log(response);
		console.log(response.currency_code);
		console.log(response.currency_code == 'undefined');
		var currCode;

		if(typeof response.currency_code === 'undefined'){
		    currCode = ' ';
		} else {
			currCode = response.currency_code;
		}
		
		var totalPrice = 0;

		if( response.diamond_type ){
			jQuery(".setup-diamonds .none-selected").addClass('hidden');
	        jQuery(".setup-diamonds .diamond-selected").removeClass('hidden');
	        jQuery('.setup-diamonds .item-price1').html( response.diamond_data.diamonds_price);
	        jQuery('.setup-diamonds .item-description').text( response.diamond_data.diamonds_name );
	        // jQuery('.btn-view-diamond a').attr('href',  );
	        jQuery('img.sidebar-diamond').attr('src', BASE_URL+'media/wysiwyg/icotheme/diamonds_pics/' + response.diamond_data.shape.toLowerCase() + '_t.jpg' );
	        totalPrice += parseFloat( response.diamond_data.diamonds_price_val );
			jQuery('.diamond-selected').find('.viewdiamond').attr('href',response.diamond_url);
		}else{
			
				jQuery(".setup-diamonds .none-selected").removeClass('hidden');
				jQuery(".setup-diamonds .none-selected").addClass('show');
	       	 jQuery(".setup-diamonds .diamond-selected").removeClass('show');
			jQuery(".setup-diamonds .diamond-selected").addClass('hidden');
			
				
			
			
	        totalPrice += 0;
			}

		if( response.ring != false ){
			jQuery(".setup-settings .none-selected").addClass('hidden');
	        jQuery(".setup-settings .ring-selected").removeClass('hidden');
	        jQuery('.setup-settings .item-price1').html( response.ring_price);
	        jQuery('.setup-settings .item-description').text( response.ring_name );
	       // jQuery('.btn-view-ring a').attr('href', response.ring_url );
	        jQuery('img.sidebar-ring').attr('src', response.ring_img );
	        jQuery('.sidebar-checkout').removeClass('hidden');
	        window.localStorage.setItem('ringImg', response.ring_img);
			window.localStorage.setItem('ringName', response.ring_name);
	        totalPrice += parseFloat( response.ring_price_val );
			jQuery('.ring-selected').find('.viewring').attr('href',response.ring_url+"?step=setting");
		}else{
				jQuery(".setup-settings .none-selected").removeClass('hidden');
				jQuery(".setup-settings .none-selected").addClass('show');
				jQuery(".setup-settings .ring-selected").removeClass('show');
					jQuery(".setup-settings .ring-selected").addClass('hidden');
	       	 totalPrice += 0;
			
			}

		if( response.diamond == false ){
			currCode = '';
		}
		jQuery('.total-price').html( response.totalprice);
		jQuery('.loader-sidebar').removeClass('loader-show');
	});
}



function iCheckActivate(){
	jQuery('.contact-form input').iCheck({
	    checkboxClass: 'icheckbox_square-aero',
	    radioClass: 'iradio_square-aero',
	    increaseArea: '20%' // optional
	});
}



jQuery(document).ready(function(e) {

	jQuery(function($){

	// Closing all possible popups
		$(document).on('keyup',function(e){
			if( e.keyCode == 27 ){
				$('.close-values').click();
				$('.close-popup').click();
			}
		});

	// Mute video
		var baseURL = $('.mute-video img').attr('data-baseurl');
		function mute(){ 
			$("#promo-video").prop('muted', true); $('.mute-video img').attr('src', baseURL + 'sound-off.png');  
			document.cookie = 'soundMuted=true; expires=Fri, 3 Aug 2021 20:47:11 UTC; path=/'
		}
		function unMute(){ 
			$("#promo-video").prop('muted', false);  $('.mute-video img').attr('src', baseURL + 'sound-on.png'); 
			document.cookie = 'soundMuted=true; expires=Fri, 3 Aug 2001 20:47:11 UTC; path=/'
		}

		if( readCookie('soundMuted') ){ mute(); }

		var state = $("#promo-video").prop('muted');
		
		$('.mute-video').on('click',function(){
			state ? unMute() : mute();
			state = $("#promo-video").prop('muted');
		});


	// Apointment form submit
		$(".appointment-form").on('submit',function(){
			$('.contact-form .spinner-container').fadeIn();
			$('.contact-form .alert').slideUp(100);

			var name 	 = $(".contact-form .name").val();
			var email 	 = $(".contact-form .email").val();
			var contact  = $(".contact-form .contact").val();
			var date     = $(".contact-form .date-picker").val();
			var time     = $(".contact-form .time-picker").val();
			var comments = $(".contact-form .comments").val();
			var cProposalRing = $('.contact-form .c-proposal-ring').prop('checked');
			var cWeddingRing = $('.contact-form .c-wedding-ring').prop('checked');
			var cOther   = $('.contact-form .c-other').prop('checked');

			console.log( name + ' ' + email + ' ' + contact + ' ' + comments );

			challengeField = $("input#recaptcha_challenge_field").val();
			responseField = $("input#recaptcha_response_field").val();
 
			$.post( BASE_URL + 'trdforms/ajax/savecontactsform/',
				{   name:name, 
					email:email, 
					contact:contact, 
					text:comments, 
					date:date, 
					time: time, 
					proposal_ring: cProposalRing,
					wedding_ring: cWeddingRing,
					other: cOther,
					challengeField, 
					responseField: grecaptcha.getResponse() },
				function( data ){
					var data = JSON.parse(data);
					console.log( data );
			}).done(function(response){
				var response = JSON.parse(response);
				if( response.status == 'true' && response.message == 'success' ){
					
					// $('.contact-form .btn-form-submit').slideUp();
					setTimeout( $('.contact-form .spinner').fadeOut(function(){ 
						$('.contact-form .success').fadeIn(function(){
							var i = 5;
							var refreshIntervalId = setInterval(function(){
								if( i > 0){
									i--;
									$('.closing-in').text(i);	
								} else {
									$('.contact-form .close-popup').click();
									clearInterval(refreshIntervalId);
									$('.closing-in').text('5');
									$('.contact-form .spinner-container').hide()
									$('.contact-form input').val('')
									$('.contact-form textarea').val('')
									$('.contact-form .c-proposal-ring').prop('checked',false );
									$('.contact-form .c-wedding-ring').prop('checked',false );
									$('.contact-form .c-other').prop('checked',false );
									$('.contact-form .btn-form-submit').show();
									grecaptcha.reset();
									iCheckActivate();
								}
							},1000);
						}); 
					}) , 1000);	
				} else if( response.message == 'captcha' ){
					$('.contact-form .captcha-message').show();
					setTimeout( $('.contact-form .spinner-container').fadeOut() , 1000);	
				}
				
			});
		});


		$('.date-picker').datetimepicker({
			format: 'DD/MM/YYYY'
		});

		$('.time-picker').timepicker({
			'disableTimeRanges': [
		        ['9pm', '11:59pm'],
		        ['0:00am', '11:59am']
		    ]
		});

		iCheckActivate();

		$('.selectpicker').selectpicker();
	// END :: Apointment form submit



		// Single Product View
		$('.engraving span').on('click',function(){
			$('.engraving span').removeClass('active');
			$(this).addClass('active');
		});

		$('.metals-select span').on('click',function(){
			$('.metals-select span').removeClass('active');
			$(this).addClass('active');
		});

		$('.color-select span').on('click',function(){
			$('.color-select span').removeClass('active');
			$(this).addClass('active');
		});

		$('.open-popup').on('click',function(){
			var target = $(this).attr('data-target');
			$('.'+target).fadeIn();
		});

		$('.close-popup').on('click',function(){
			var target = $(this).attr('data-target');
			$('.'+target).fadeOut();
		});

	    


		// Subscribe footer
		$("#newsletter-validate-detail").on('submit',function(){
			
			email = $('#newsletter');
			console.log(email);

	        if ( email.val() === "" || !isRFC822ValidEmail(email.val()) ){   
	            email.focus();
	        } else {

	          $.get("js/Mailchimp/subscribe-user.php?mc=1&email="+email.val(), function( data ) {

	            var email = $('#newsletter');
	            console.log(data);
	            if (data.error == "0" && data.result.email === email.val()) {
	                console.log('success');
	                // $("#newsletter").css({'opacity':'0'});
	                $('.success-message-footer').slideDown();
	                setTimeout(function(){
	                	email.val(' ');	
	                	$('.success-message-footer').slideUp();
	                },5000)
	                
	                subsSetcookie();
	            } else {
	                email.focus();
	            }

	          });

	        }

			return false;
		});


		// Cart scripts
		$('.cart-upd').on('click',function(){
		// 	$('.cart-form').submit();
			return false;
		});

		$(".toggle").on('click',function(){
			$(this).toggleClass('collapsed');
			var target = $(this).attr('data-target');
			$('.'+target).slideToggle();
		});


	// Sidebar Ring&Diamonds
		$('.sidebar-toggle').on('click',function(){
			$('.sidebar-container').toggleClass('closed');
		});


        renderSidebarContent();
	// END:: Sidebar Ring&Diamonds




	// Location detection
		$.get("http://ipinfo.io", function(response) {
		    // console.log(response);
		    userChangedCurrency = readCookie('userChangedCurrency');
		    if( !userChangedCurrency ){
		    	if( response.country != 'SG' ){
			    	if( $('.select-language li:first-child').hasClass('current-language') ){
			    		window.location = $('.select-language li:nth-child(2) a').attr('href')
			    	}
			    } else{
			    	if( !$('.select-language li:first-child').hasClass('current-language') ){
			    		window.location = $('.select-language li:first-child a').attr('href')
			    	}
			    }	
		    }
		    
		}, "jsonp");

		$('.select-language li a').on('click',function(){
			var date = new Date();
			date.setDate(date.getDate() + 2);
			document.cookie = 'userChangedCurrency=true; expires=' + date + '; path=/';
		});
	// Location detection :: END


		 
	});

	jQuery('button.sidebar-button.sidebar-checkout').click(function (e) {

		e.preventDefault();
		jQuery('.loader-sidebar').addClass('loader-show');

		var ringId = window.selectedRingId ? window.selectedRingId : 'none';
		var addRingToCartUrl = window.location.origin + '/diamonds/diamond/addringtocart/';
		jQuery.post(addRingToCartUrl, {product_id: ringId}, function (response) {
			response = JSON.parse(response);
			if (response.status) {

				ringImg = window.localStorage.getItem('ringImg');
				ringName = window.localStorage.getItem('ringName');
				jQuery('.loader-sidebar').removeClass('loader-show');

				renderSidebarContent();

				showSweetCart({
					url:  ringImg,
					name: ringName,
					message: ' was added to shopping cart',
					btnCart:  true,
					btnClose: true
				});

				window.location.reload();

			} else {
				jQuery('.loader-sidebar').removeClass('loader-show');
				alert(response.message);
			}
		});
	});

	jQuery('.select-diamond-step').click(function (e) {
		var step = parseInt(jQuery(e.currentTarget).attr('step'));
		if (step == 1 || step == 2 || step == 3) {
			var goToStepUrl = window.location.origin + '/diamonds/diamond/gotostep/';

			jQuery.post(goToStepUrl, {step: step}, function (response) {
				response = JSON.parse(response);
				if (response.status) {
					window.location.href = response.url;
				} else {
					alert('Error! Please try later');
				}
			})
		}
	});
});


(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-69891614-1', 'auto');
ga('send', 'pageview');