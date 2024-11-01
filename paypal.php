<?php

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
			$api_username 	= $sandbox ? esc_attr( get_option('paypal_api_username') ) : 'LIVE_USERNAME_GOES_HERE';
			$api_password 	= $sandbox ? esc_attr( get_option('paypal_api_password') ) : 'LIVE_PASSWORD_GOES_HERE';
			$api_signature 	= $sandbox ? esc_attr( get_option('paypal_api_signature') ) : 'LIVE_SIGNATURE_GOES_HERE';

			$card_num 		= $payment_fields['_paypal_card_no'];
			$card_exp_date 	= $payment_fields['_paypal_card_exp_date'];
			$card_cvv2 		= $payment_fields['_paypal_cvv2'];

			$request_params = array
                    (
                    'METHOD' => 'DoDirectPayment', 
                    'USER' => $api_username, 
                    'PWD' => $api_password, 
                    'SIGNATURE' => $api_signature, 
                    'VERSION' => $api_version, 
                    'PAYMENTACTION' => 'Sale',                   
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' => 'MasterCard', 
                    'ACCT' => $card_num,                        
                    'EXPDATE' => $card_exp_date,           
                    'CVV2' => $card_cvv2, 
                    'FIRSTNAME' => 'Tester', 
                    'LASTNAME' => 'Testerson', 
                    'STREET' => '707 W. Bay Drive', 
                    'CITY' => 'Largo', 
                    'STATE' => 'FL',                     
                    'COUNTRYCODE' => 'US', 
                    'ZIP' => '33770', 
                    'AMT' => $cal_fields['total'], 
                    'CURRENCYCODE' => 'USD', 
                    'DESC' => 'Testing Payments Pro'
                    );
			$nvp_string = '';
			foreach($request_params as $var=>$val)
			{
			    $nvp_string .= '&'.$var.'='.urlencode($val);    
			}

			// Send NVP string to PayPal and store response
			$curl = curl_init();
			        curl_setopt($curl, CURLOPT_VERBOSE, 1);
			        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
			        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
			 
			$result = curl_exec($curl);     
			curl_close($curl);

			

			// Parse the API response
			$nvp_response_array = parse_str($result);
			$response_arr = explode("&",$result);
			$response_arr2 = explode("=",$response_arr[9]);
			$transaction_id = $response_arr2[1];
			$response_arr3 = explode("=",$response_arr[2]);
			$ack = $response_arr3[1];
			if($ack == 'Success')
			{
				$save = true;
		        $ninja_forms_processing->add_success_msg($form_id,'<br/>Transaction Id: '.$transaction_id.'.<br/>Successfully Submitted.');

			}
			if($ack == 'Failure')
			{
				$save = false;
		        $ninja_forms_processing->add_error($form_id,'<br/>Transaction failure. Please try again after sometimes or<br/>Try another payemnt gateway.');

			}