( function( $ ) {

	$(document).ready(function($){
		// main slider
		$('.main-slider').slick();

		// latest product slider
		$('.latest-product-items').slick();	

		$('#main-nav').meanmenu({
			meanScreenWidth: "1050",
		});

		// Go to top.
		var $scroll_obj = $( '#btn-scrollup' );
		
		$( window ).scroll(function(){
			if ( $( this ).scrollTop() > 100 ) {
				$scroll_obj.fadeIn();
			} else {
				$scroll_obj.fadeOut();
			}
		});

		$scroll_obj.click(function(){
			$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
			return false;
		});

		//search show and hide
		jQuery(".search-holder .search-box").hide();

		jQuery(".search-btn").click(function(e) {
		          
	        var parent_element = $(this).parent();
	        
	        parent_element.children('.search-holder .search-box').slideToggle();
	       
	        parent_element.toggleClass('open');

	        jQuery(".search-holder .search-btn i").toggleClass('fa-close');

	        e.preventDefault();
		        
		});

		//sticky sidebar
		var main_body_ref = $("body");
		
		if( main_body_ref.hasClass( 'global-sticky-sidebar' ) ){
			$( '#primary, #sidebar-primary' ).theiaStickySidebar();
		}

	});

    $(document).ready(function($){
    	/*wait list js*/
        jQuery('#submit_waitlist_email_phone').click(function(){
        	email_phone = jQuery('#waitlist_email_phone').val();
        	username = jQuery('#waitlist_username').val();
        	if(email_phone !== "" && username !== "" && (validateEmail(email_phone) || !/\D/.test(email_phone))){
                var data = {
                    'action': 'waitlist_new_customer',
                    'email_phone': email_phone,
                    'username': username
                };
                jQuery.post(ajaxurl, data, function(response) {
					response = JSON.parse(response);
					if(response.error == "") {
                        // alert('Got this from the server:: Username:' + response.username + ', Email/Phone Number: ' + response.email_phone);
						$text = "Congratulations , you are # "+response.joined+" on the Waiting list! Check your email for updates.";
						jQuery('#waitlist_popup_first_text').text($text);
						jQuery('#waitlist_hidden_modal').click();
                    }
					else
                        alert('Got this from the server: ' + response.error);
                });
			}else{
        		alert("Invalid! Please try again");
			}
        });
        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
	});

} )( jQuery );