<?php


function WP_PYMNT_submitForm()
{
	if(isset($_POST['submit']))
	{
	   WP_PYMNT_paymentDone();
	} 
}

function WP_PYMNT_paymentDone()
{
	//echo "<pre>"; print_r($_POST); echo "</pre>";
	if($_POST['choosePayment'] == 'authorize')
	{
		if(!$_POST['_auth_card_no']){
			$_GET['wp_payment_msg'] = 'Card Number Missing. Please check all the form details.';
	    	$_GET['appr_status'] = 0;
	    	return;
		}
		if(!$_POST['onetime_auth_amount']){
			$_GET['wp_payment_msg'] = 'Amount is missing. Please check all the form details.';
	    	$_GET['appr_status'] = 0;
	    	return;
		}
		WP_PYMNT_payment_authorize();

	}
	
	elseif($_POST['choosePayment'] == 'paypal')
	{
		if(!$_POST['_paypal_card_no']){
			$_GET['wp_payment_msg'] = 'Card Number Missing. Please check all the form details.';
	    	$_GET['appr_status'] = 0;
	    	return;
		}
		if(!$_POST['paypal_amount']){
			$_GET['wp_payment_msg'] = 'Amount is missing. Please check all the form details.';
	    	$_GET['appr_status'] = 0;
	    	return;
		}
		WP_PYMNT_paymentPaypal();
	}
	
}

/*
	*	SIMPLE AUTHORIZE.NET 	*
*/
function WP_PYMNT_payment_authorize()
{
	require dirname(__file__).'/authorize/autoload.php';

	$auth_loginId 	= esc_attr( get_option('auth_api_username') );
	$auth_tran_key 	= esc_attr( get_option('auth_api_signature') );
	$auth_mode 		= esc_attr( get_option('auth_mode') );
	define("AUTHORIZENET_API_LOGIN_ID", $auth_loginId);
	define("AUTHORIZENET_TRANSACTION_KEY", $auth_tran_key);
	if($auth_mode=='live')
	{
		define("AUTHORIZENET_SANDBOX", false);
	}
	else
	{
		define("AUTHORIZENET_SANDBOX", true);
	}
	
	$card_num 		= str_replace(' ', '', $_POST['_auth_card_no']);
	$card_exp_date 	= $_POST['_auth_card_exp_month'].'/'.$_POST['_auth_card_exp_year']; 
	$sale = new AuthorizeNetAIM;
	$sale->amount = $_POST['onetime_auth_amount'];
	$sale->card_num = $card_num;
	$sale->exp_date = $card_exp_date;

	$response 		= $sale->authorizeAndCapture();
	$appr_status 	= $response->approved;
	$dec_status 	= $response->declined;
	$tran_id 		= $response->transaction_id;
    
    if($appr_status == 1)
    {
    	
    	$userDetailsAuth = array('transactionId' => $tran_id,
									'amount' => $_POST['onetime_auth_amount'],
									'name' => $_POST['your_name'],
									'email' => $_POST['email'],
									'comments' => $_POST['comments'],
									'date' => date('Y-m-d H:i:s')
									);
		WP_PYMNT_saveData('authorize',$userDetailsAuth);

    	$_GET['wp_payment_msg'] = 'The transaction is successfully submitted.
    							<br/>Transaction Id: '.$tran_id;
    	$_GET['appr_status'] = 1;
    }
    else
    {
    	$_GET['wp_payment_msg'] = 'The transaction is not successfully submitted.
    							<br/>'.$response->response_reason_text." ".$response->error_message;
    	$_GET['appr_status'] = 0;
    	
    }
}



/*
	*	SIMPLE PAYPAL 	*
*/
function WP_PYMNT_paymentPaypal()
{
	if(esc_attr( get_option('paypal_mode') ) == 'sandbox')
	{
		$sandbox 	= TRUE;
	}
	if(esc_attr( get_option('paypal_mode') ) == 'live')
	{
		$sandbox 	= FALSE;
	}
	
	
	$api_version 	= '85.0';
	$api_endpoint 	= $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
	$api_username 	= esc_attr( get_option('paypal_api_username') );
	$api_password 	= esc_attr( get_option('paypal_api_password') );
	$api_signature 	= esc_attr( get_option('paypal_api_signature') );

	$card_num 		= str_replace(' ', '', $_POST['_paypal_card_no']);
	$card_exp_date 	= $_POST['_paypal_card_exp_month'].$_POST['_paypal_card_exp_year'];
	$card_cvv2 		= $_POST['_paypal_cvv2'];
	$card_type 		= $_POST['_paypal_card_type'];
 	
 	$request_params = array
            (
            'METHOD' => 'DoDirectPayment', 
            'USER' => $api_username, 
            'PWD' => $api_password, 
            'SIGNATURE' => $api_signature, 
            'VERSION' => $api_version, 
            'PAYMENTACTION' => 'Sale',                   
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $card_type, 
            'ACCT' => $card_num,                        
            'EXPDATE' => $card_exp_date,           
            'CVV2' => $card_cvv2, 
            'COUNTRYCODE' => 'US', 
            'AMT' => $_POST['paypal_amount'], 
            'CURRENCYCODE' => 'USD', 
            'DESC' => 'Payment'
            );
	$nvp_string = '';
	foreach($request_params as $var=>$val)
	{
	    $nvp_string .= '&'.$var.'='.urlencode($val);    
	}

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_URL, $api_endpoint);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
	 
	$result = curl_exec($curl);     
	curl_close($curl);
	$nvp_response_array = parse_str($result);
	$response_arr = explode("&",$result);
	$response_arr2 = explode("=",$response_arr[9]);
	$transaction_id = $response_arr2[1];
	$response_arr3 = explode("=",$response_arr[2]);
	$ack = $response_arr3[1];
	$tran_arr = explode("=",$response_arr[9]);
	
	if($ack == 'Success')
	{
		$userDetailsPaypal = array('transactionId' => $tran_arr[1],
									'amount' => $_POST['amount'],
									'name' => $_POST['your_name'],
									'email' => $_POST['email'],
									'comments' => $_POST['comments'],
									'date' => date('Y-m-d H:i:s')
									);
		WP_PYMNT_saveData('paypal',$userDetailsPaypal);
		$_GET['wp_payment_msg'] = 'The transaction is successfully submitted.<br/>Transaction ID: '.$tran_arr[1];
    	$_GET['appr_status'] = 1;

	}
	if($ack == 'Failure')
	{
		$message = explode("=",$response_arr[7]);
		$garbage = array("%20","%2e","%3");
		$replace = array(" ","."," ");
		$_GET['wp_payment_msg'] = 'The transaction is not successfully submitted.<br/>'.str_replace($garbage, $replace, $message[1]);
    	$_GET['appr_status'] = 0;
	}

}

function WP_PYMNT_saveData($gateway, $userDetails)
{
	if($gateway=='authorize')
	{
		$pay_through = 'Authorize.NET';
	}
	if($gateway=='paypal')
	{
		$pay_through = 'PayPal';
	}
	$my_post = array(
						'post_title'    => $userDetails['name'].', payment through '.$pay_through,
						'post_status'   => 'publish',
						'post_author'   => 1,
						'post_type'     => 'paymentSubmission'
						);
 
	$post_id = wp_insert_post( $my_post );
	update_post_meta($post_id, 'is_recurring', 'no');

	if ( ! add_post_meta( $post_id, 'transactionId', $userDetails['transactionId'], true ) ) { 
   		update_post_meta ( $post_id, 'transactionId', $userDetails['transactionId'] );
	}

	if ( ! add_post_meta( $post_id, 'pay_amount', $userDetails['amount'], true ) ) { 
   		update_post_meta ( $post_id, 'pay_amount', $userDetails['amount'] );
	}

	if ( ! add_post_meta( $post_id, 'payer_email', $userDetails['email'], true ) ) { 
   		update_post_meta ( $post_id, 'payer_email', $userDetails['email'] );
	}

	if ( ! add_post_meta( $post_id, 'payer_comments', $userDetails['comments'], true ) ) { 
   		update_post_meta ( $post_id, 'payer_comments', $userDetails['comments'] );
	}

	if ( ! add_post_meta( $post_id, 'pay_throygh', $pay_through, true ) ) { 
   		update_post_meta ( $post_id, 'pay_throygh', $pay_through );
	}

	if ( ! add_post_meta( $post_id, 'payer_name', $userDetails['name'], true ) ) { 
   		update_post_meta ( $post_id, 'payer_name', $userDetails['name'] );
	}

	send_email_notification($userDetails, $post_id, $pay_through, $_payment_currency);
}
function send_email_notification($userDetails,$post_id, $pay_through, $_payment_currency){

	$headers = array('Content-Type: text/html; charset=UTF-8');

	$notification_send_type = get_option('notification_send_type') ? esc_attr( get_option('notification_send_type') ) : 'both';

	if( $notification_send_type == 'admin' || $notification_send_type == 'both' ){
		$to = get_option('notiemailid') ? esc_attr( get_option('notiemailid') ) : get_option('admin_email');
		$admin_email_sub = get_option('admin_email_sub') ? esc_attr( get_option('admin_email_sub') ) : 'Payment Notification From Your Site';
		
		$adminemailbody = 'Hello Admin,<br/><br/>
						<p>One payment is done.</p>
						<p><u>Payment details:</u></p>
						<br/>
						[WP_PAYMENT_DETAILS]
						<br/>
						<p><u>User details:</u></p>
						<br/>
						[WP_PAYMENT_USER_DETAILS]
						<br/>
						<p>Login to Admin and get the details From WP Payment -> Records.</p>
						<p><i>Thanks</i></p>';
		$admin_email_content = get_option('admin_email_body') ? get_option('admin_email_body') : $adminemailbody ;

		wp_mail( $to, $admin_email_sub, $admin_email_content, $headers );
	}

	if( $notification_send_type == 'user' || $notification_send_type == 'both' ){
		$useremailbody = 'Hello dear,<br/><br/>
						<p>Your payment is successful and competed.</p>
						<p><u>Here is your payment details:</u></p>
						<br/>
						[WP_PAYMENT_DETAILS]
						<br/>
						<p>Keep the ID safe, for future reference.</p>
						<p><i>Thanks</i></p>';
		$user_email_content = get_option('user_email_body') ? get_option('user_email_body'): $useremailbody;

		$user_email_sub = get_option('user_email_sub') ? esc_attr( get_option('user_email_sub') ) : 'Payment Confirmation From '.get_bloginfo('name');
		wp_mail( $userDetails['email'], $user_email_sub, $user_email_content, $headers );
	}
}