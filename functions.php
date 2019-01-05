<?php
/*====================================================================================*/

// Function to add subscribe text to posts and pages
function wait_list_function() {
    $count = 0;$result = "";
    if($waitlist = get_option('waitlist_option'))
        $count = count($waitlist);
    if(!empty($waitlist)) {
        foreach ($waitlist as $key => $value) {
            $email = "NULL";
            $phone = "NULL";
            $style_counter = $key % 2 == 0 ? 2 : 1;
            if (email_validate($value["email_phone"]))
                $email = 'xxxx@' . explode('@', $value["email_phone"])[1];
            else
                $phone = 'xxxxxxxx' . $value["email_phone"][strlen($value["email_phone"]) - 2] . $value["email_phone"][strlen($value["email_phone"]) - 1];
            $result .= '<div class="waiting-list-data' . $style_counter . '">
                    <div class="waiting11">
                        ' . ++$key . '
                    </div>

                    <div class="waiting22">
                        ' . $value["username"] . '
                    </div>

                    <div class="waiting33">
                        ' . $email . '
                    </div>

                    <div class="waiting44">
                        ' . $phone . '
                    </div>
                </div>';
        }
    }
    /*--subscription box--*/
    $text_field =
        '<div class="form-head">
            <h5><span></span> '.$count.' Users Live Now Join Them! </h5>
        </div>
        <div class="form-bg">
            <form>
                <h5> Join Them !</h5>
                <input type="text" id="waitlist_username" placeholder="Username" name="">
                <input type="email" id="waitlist_email_phone" placeholder="Email or Phone Number" name="">
                <button type="button" id="submit_waitlist_email_phone" > Go !</button>
                <button type="button" id="waitlist_hidden_modal" hidden data-toggle="modal" data-target=".bs-example-modal-lg"> Go !</button>
            </form>
        </div>';

    /*--table section--*/
    $text_field .= '<div class="waiting-list">
            <div class="waiting-bg">
                <div class="waiting-list-head">
                    <h5> Waitlist </h5>
                </div>
                <div class="waiting-list-data1">
                    <div class="waiting1">
                        No:
                    </div>

                    <div class="waiting2">
                        Username:
                    </div>

                    <div class="waiting3">
                        Email:
                    </div>

                    <div class="waiting4">
                        Phone Number:
                    </div>
                </div>
                '.$result.'
            </div>
        </div>';

    /*--hidden modal--*/
    $text_field .= '<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="popup-box">
                <div class="popup-head">
                    <h3 id="waitlist_popup_first_text"> Congratulations , you are # 6,789 on the Waiting list! Check your email for updates.
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </h3>
                    <h5> Thank you! </h5>
                    <p> We have added your email address to the signup queue.</p>
                </div>
                <div class="popup-middle">
                    <h5> 354,611 People ahead of you!</h5>
                    <p> This reservation is hold for <b> Mr . Anthony James </b>. Is this <a href=""> not you?</a></p>
                </div>
                <div class="popup-last">
                    <h5> Interested in priority access?</h5>
                    <p> Get early access by referring your friends,
                        The more friends that join, the sooner you\'ll get access.</p>
                </div>
                <div class="popup-social">
                    <h6>
                        <a href="">
                            <i class="fab fa-twitter"> </i>
                            Tweet
                        </a>

                        <a href="">
                            <i class="fab fa-facebook"> </i>
                            Share
                        </a>

                        <a href="">
                            <i class="fa fa-envelope"> </i>
                            Email
                        </a>
                        <a href="">
                            <i class="fab fa-linkedin"> </i>
                            Share
                        </a>
                    </h6>
                    <h5> Or share this unique link:</h5>
                    <span><a href=""> https://www.robinhood.com</a> </span>
                </div>
            </div>
        </div>
    </div>
</div>';

    return $text_field;
}
add_shortcode('wait_list', 'wait_list_function');

function waitlist_enqueue_script(){
    wp_enqueue_style( 'waitlist_css', get_template_directory_uri() . '/assets/css/custom_01.css', '', false);
    wp_enqueue_style( 'waitlist_bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', '', false);

    wp_enqueue_script( 'waitlist_js', get_template_directory_uri() . '/assets/js/custom.js', array(), false, true );
    wp_enqueue_script( 'waitlist_bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'waitlist_enqueue_script' );

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_action( 'wp_ajax_waitlist_new_customer', 'waitlist_new_customer_entry' );
add_action( 'wp_ajax_nopriv_waitlist_new_customer', 'waitlist_new_customer_entry' );

function waitlist_new_customer_entry() {

    $email_phone = $_POST['email_phone'];
    $username = $_POST['username'];
    $return_msg = "Please fill field(s) properly. Thanks!";
    if(isset($_POST['email_phone']) && isset($_POST['username']) && (email_validate($email_phone) || ctype_digit($email_phone))){
        $data = [
            'username' => $username,
            'email_phone' => $email_phone,
            'joined' => 1,
            'error' => ""
        ];
        $return_msg = $data;
        $fetched = get_option('waitlist_option');
        if($fetched){
            $flag = true;
            foreach ($fetched as $fetch){
                if(is_array($fetch) && in_array($email_phone, $fetch)) {
                    $return_msg['error'] = 'Email or phone number already exist!';
                    $flag = false;
                    break;
                }
            }
            if($flag) {
                array_push($fetched, $data);
                update_option('waitlist_option', $fetched);
                if($waitlist = get_option('waitlist_option'))
                    $return_msg['joined'] = count($waitlist);
            }
        }else{
            empty($fetched) ? update_option('waitlist_option', array($data)) : add_option('waitlist_option', array($data));
        }
        echo json_encode($return_msg);
    }else
        echo json_encode(['error' => $return_msg]);

    wp_die(); // this is required to terminate immediately and return a proper response
}

function email_validate($email){
    if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email)){
        return false;/*invalid*/
    }else{
        return true;/*valid*/
    }
}
