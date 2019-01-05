( function( $ ) {

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
