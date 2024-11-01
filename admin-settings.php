<?php

function WP_PYMNT_menu() {
add_menu_page ( 
    'WP Payment', 
    'WP Payment',
    'manage_options',
    'payment',
    'WP_PYMNT_payment_options',
    'dashicons-feedback'
    );
add_submenu_page (
    'payment',
    'General Settings',
    'General Settings',
    'manage_options',
    'wp-general-settings',
    'WP_PYMNT_General_Settings'
    );
add_submenu_page (
    'payment',
    'Payment Settings',
    'Payment Settings',
    'manage_options',
    'wp-payment-settings',
    'WP_PYMNT_Payment_Gateway_Settings'
    );
add_submenu_page (
    'payment',
    'Form Template',
    'Form Template',
    'manage_options',
    'wp-form-template',
    'WP_PYMNT_Payment_form_template'
    );
add_submenu_page (
    'payment',
    'Email Settings',
    'Email Settings',
    'manage_options',
    'wp-form-email-settings',
    'WP_PYMNT_Payment_form_email_settings'
    );
  
add_submenu_page (
    'payment',
    'Records',
    'Records',
    'manage_options',
    'edit.php?post_type=paymentsubmission',
    NULL
    );

  
  add_action( 'admin_init', 'register_WP_PYMNT_settings' );
  }
add_action( 'admin_menu', 'WP_PYMNT_menu' );

function WP_PYMNT_Payment_Gateway_Settings(){
	?>
	<div class="wrap">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
		<div class="tabs">
		  <input type="radio" id="tab1" name="tab-control" checked>
		  <input type="radio" id="tab2" name="tab-control">
		  <input type="radio" id="tab3" name="tab-control">
		  <input type="radio" id="tab4" name="tab-control">
		  	<ul>
			    <li title="Delivery Contents" class="wps-pay-active">
			     	<label for="tab1" role="button">
			      		<img src="<?php echo plugins_url( '/images/paypal.png', __FILE__ ) ?>" style="width:65%; height:auto;">
			        </label>
			    </li>
			    <li title="Shipping">
			    	<label for="tab2" role="button">
			    		<img src="<?php echo plugins_url( '/images/authorize-net.png', __FILE__ ) ?>" style="width:63%; height:auto;">
			        </label>
			    </li>
			    <li title="Stripe">
			    	<label for="tab3" role="button">
			    		<img src="<?php echo plugins_url( '/images/Stripe_Logo.png', __FILE__ ) ?>" style="width:63%; height:auto;">
			        </label>
			    </li>
			    
		  	</ul>
			
		  	<div class="content">
			    <section>
			    	<form method="post" action="options.php">
					    <?php 
					    	settings_fields( 'WP-PYMNT-settings-group-paypal' ); 
					    	do_settings_sections( 'WP-PYMNT-settings-group-paypal' );
					    	settings_errors();
					    ?>
					    <label>Status<span>,whether this payment system is available in frontend or not.</span></label>
		        		<select name="paypal_status">
		        			<option value="enable" <?php if(esc_attr( get_option('paypal_status') )=='enable'){echo 'selected';}?>>Enable</option>
		        			<option value="disable" <?php if(esc_attr( get_option('paypal_status') )=='disable'){echo 'selected';}?>>Disable</option>
		        		</select>
		        		<label>Title<span>,this tile shown into frontend form.</span></label>
		        		<?php $paypal_title = get_option('paypal_title') ? esc_attr( get_option('paypal_title') ) : 'By PayPal'; ?>
				        <input class="regular-text code" type="text" name="paypal_title" value="<?php echo $paypal_title; ?>" />
				        <label>API Username</label>
				        <input class="regular-text code" type="text" name="paypal_api_username" value="<?php echo esc_attr( get_option('paypal_api_username') ); ?>" />
			         
				        <label>API Password</label>
				        <input class="regular-text code" type="text" name="paypal_api_password" value="<?php echo esc_attr( get_option('paypal_api_password') ); ?>" />
			        
			        	<label>API Signature</label>
			        	<input class="regular-text code" type="text" name="paypal_api_signature" value="<?php echo esc_attr( get_option('paypal_api_signature') ); ?>" />

			        	<label>Merchant Email</label>
			        	<input class="regular-text code" type="text" name="paypal_api_merchant_email" value="<?php echo esc_attr( get_option('paypal_api_merchant_email') ); ?>" />
			        	<label>Mode</label>
		        		<select name="paypal_mode">
		        			<option value="sandbox" <?php if(esc_attr( get_option('paypal_mode') )=='sandbox'){echo 'selected';}?>>Sandbox(Testing)</option>
		        			<option value="live" <?php if(esc_attr( get_option('paypal_mode') )=='live'){echo 'selected';}?>>Live</option>
		        		</select>
		        		<?php submit_button(); ?>
	        		</form>
	        		<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
			  		<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
			  		<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>
			  	</section>
			    
			    <section>
			    	<form method="post" action="options.php">
				    	<?php 
				    		settings_fields( 'WP-PYMNT-settings-group-auth' );
		    				do_settings_sections( 'WP-PYMNT-settings-group-auth' ); 
		    				settings_errors();
		    			?>
		    			 <span style="font-size: 12px;font-weight: 400; color:black;width: 100%;display: block;text-align: center;letter-spacing: 2px;">Authorize.NET Recurring process is available in Premium version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span>
					    <br/>
		    			<label>Status<span>,whether this payment system is available in frontend or not.</span></label>
		        		<select name="auth_status">
		        			<option value="enable" <?php if(esc_attr( get_option('auth_status') )=='enable'){echo 'selected';}?>>Enable</option>
		        			<option value="disable" <?php if(esc_attr( get_option('auth_status') )=='disable'){echo 'selected';}?>>Disable</option>
		        		</select>
		        		<label>Title<span>,this tile shown into frontend form.</span></label>
		        		<?php $auth_title = get_option('auth_title') ? esc_attr( get_option('auth_title') ) : 'Credit Card (by Authorize.NET)'; ?>
				        <input class="regular-text code" type="text" name="auth_title" value="<?php echo $auth_title; ?>" />
				        	
					        <label style="float:left;">Type Of Payment<span>, this means is it One Time payment or Recurring basis payment. Choose 'Both' if you want to depend on user's choice.</span></label>
					  		<select id="auth_typeofpay" onchange="auth_check_recurring();">
					  			<option value="onetime">One Time</option>
					  			<option value="recurring">Recurring</option>
					  			<option value="both">Both</option>
					  		</select>
					  		<div id="auth_renewlength_set">
					  			<label>Renew Length Set By<span>, if you want to set Renew Interval Length then choose 'Admin', else choose 'Frontend User' if you want to depend on user's choice.</span></label>
						  		<select id="auth_renewlength_set_by" onchange="auth_check_typeofpay();">
						  			<option value="admin">Admin</option>
						  			<option value="user">Frontend User</option>
						  		</select>
					  		</div>

					  		<div id="auth_recurring_settings" style="margin-bottom:10px;">
					  			<label>Renewal Length<span>, number of days / months / years after next payment will be made. Minimum 7 days.</span></label>
					  			<input type="text" id="auth_renewlength" class="auth_renew_length"/>
					  			<label>Renewal Length Unit<span>, the unit of previously given Renewal Length.</span></label>
					  			<select id="auth_relengthunit">
						  			<option value="days">Day</option>
						  			<option value="months">Month</option>
						  			<option value="years">Year</option>
						  		</select>
						  		<label><span>( NOTE: We Are Assuming Recurring Payment Is Occuring With Lifetime validity. )</span></label>
					  		</div>
				        <label>API Login ID</label>
				        <input class="regular-text code" type="text" name="auth_api_username" value="<?php echo esc_attr( get_option('auth_api_username') ); ?>" />
			        	<label>Transaction Key</label>
			        	<td><input class="regular-text code" type="text" name="auth_api_signature" value="<?php echo esc_attr( get_option('auth_api_signature') ); ?>" />
			        	<label>Mode</label>
		        		<select name="auth_mode">
		        			<option value="sandbox" <?php if(esc_attr( get_option('auth_mode') )=='sandbox'){echo 'selected';}?>>Sandbox(Testing)</option>
		        			<option value="live" <?php if(esc_attr( get_option('auth_mode') )=='live'){echo 'selected';}?>>Live</option>
		        		</select>
		        		<?php submit_button(); ?>
		        	</form>
		        	<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
		        	<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
			  	</section>

			  	<section>
			    	<form method="post" action="options.php">
					    <?php 
					    	settings_fields( 'WP-PYMNT-settings-group-stripe' ); 
					    	do_settings_sections( 'WP-PYMNT-settings-group-stripe' );
					    	settings_errors();
					    ?>
					    <span style="font-size: 12px;font-weight: 400; color:black;width: 100%;display: block;text-align: center;letter-spacing: 2px;">Stripe is available in Premium version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span>
					    <br/>
					    <label>Status<span>,whether this payment system is available in frontend or not.</span></label>
		        		<select name="stripe_status">
		        			<option value="enable">Enable</option>
		        			<option value="disable">Disable</option>
		        		</select>
		        		<label>Title<span>,this tile shown into frontend form.</span></label>
				        <input class="regular-text code" type="text" name="stripe_title" value="By Stripe" />
				        <label>Publishable Key</label>
				        <input class="regular-text code" type="text" name="stripe_publish_key" value="" />
			         
				        <label>Secret Key</label>
				        <input class="regular-text code" type="text" name="stripe_private_key" value="" />
			        
			        	
			        	<label>Mode</label>
		        		<select name="stripe_mode">
		        			<option value="sandbox">Sandbox</option>
		        			<option value="live">Live</option>
		        		</select>
		        		<?php submit_button(); ?>
	        		</form>
	        		<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
	        		<p style="margin-top:30px;">Still Confused? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
					<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a> and on <a href="http://wpsuperiors.com/shop/wp-payment/" target="_blank;">WPSuperiors.</a>
				  		</p>
				</section>

		  	</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(".tabs li").click(function(){
			jQuery(".tabs li").removeClass("wps-pay-active");
			jQuery(this).addClass("wps-pay-active");
		});
	</script>
	
	<?php
}

function WP_PYMNT_General_Settings(){
	?>
	<form method="post" action="options.php">
	    <?php settings_fields( 'WP-PYMNT-settings-general' ); ?>
	    <?php do_settings_sections( 'WP-PYMNT-settings-group-paypal' ); ?>
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
		<div class="wrap">
			<div class="tabs">
				<input type="radio" id="tab1" name="tab-control" checked>
				<ul>
				    <li title="Delivery Contents">
				     	<label for="tab1" role="button" style="height:50px;">
				      		<span style="font-size:20px; font-family: raleway; font-style:italic;">General Settings</label>
				        </label>
				    </li>
				</ul>
				<div class="content">
				    <section>
				      	<h2>General</h2>
				      	<label>Notification Email ID<span>, this email will be notified after successfull payment made, with payment details.</span></label>
				  		<?php $notiemailid = get_option('notiemailid') ? esc_attr( get_option('notiemailid') ) : get_option('admin_email'); ?>
				  		<input type="text" value="<?php echo $notiemailid; ?>" name="notiemailid" id="notiemailid"/>
				  		
				  		<label>Paypal Payment's Currency<span>Available only in Premium Version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span></label>
				  		<select name="paypal_payment_currency">
				  			<option value="AUD">Australian Dollar ( AUD )</option>
				  			<option value="BRL">Brazilian Real ( BRL )</option>
				  			<option value="CAD">Canadian Dollar ( CAD )</option>
				  			<option value="CZK">Czech Koruna ( CZK )</option>
				  			<option value="DKK">Danish Krone ( DKK )</option>
				  			<option value="EUR">Euro ( EUR )</option>
				  			<option value="HKD">Hong Kong Dollar ( HKD )</option>
				  			<option value="ILS">Israeli New Sheqel ( ILS )</option>
				  			<option value="MYR">Malaysian Ringgit ( MYR )</option>
				  			<option value="MXN">Mexican Peso ( MXN )</option>
				  			<option value="NOK">Norwegian Krone ( NOK )</option>
				  			<option value="NZD">New Zealand Dollar ( NZD )</option>
				  			<option value="PHP">Philippine Peso ( PHP )</option>
				  			<option value="PLN">Polish Zloty ( PLN )</option>
				  			<option value="GBP">Pound Sterling ( GBP )</option>
				  			<option value="SGD">Singapore Dollar ( SGD )</option>
				  			<option value="SEK">Swedish Krona ( SEK )</option>
				  			<option value="CHF">Swiss Franc ( CHF )</option>
				  			<option value="THB">Thai Baht ( THB )</option>
				  			<option value="USD">U.S. Dollar ( USD )</option>
				  		</select>
				  		
				  		<br/>
				  		<label>Authorize.NET Payment's Currency<span>Available only in Premium Version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span></label>
				  		<select name="auth_payment_currency">
				  			<option value="AUD">Australian Dollar ( AUD )</option>
				  			<option value="DKK">Danish Krone ( DKK )</option>
				  			<option value="EUR">Euro ( EUR )</option>
				  			<option value="NOK">Norwegian Krone ( NOK )</option>
				  			<option value="NZD">New Zealand Dollar ( NZD )</option>
				  			<option value="PLN">Polish Zloty ( PLN )</option>
				  			<option value="GBP">Pound Sterling ( GBP )</option>
				  			<option value="SEK">Swedish Krona ( SEK )</option>
				  			<option value="CHF">Swiss Franc ( CHF )</option>
				  			<option value="USD">U.S. Dollar ( USD )</option>
				  		</select>
				  		<label>Stripe Payment's Currency<span>Available only in Premium Version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span></label>
				  		<?php 
				  			$stripe_payment_currency = get_option('stripe_payment_currency') ? esc_attr( get_option('
				  			stripe_payment_currency') ) : 'USD'; 
				  			$stripe_currency_arr = array('USD','AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BIF','BMD','BND','BOB','BRL','BSD','BWP','BZD','CAD','CDF','CHF',   'CLP','CNY','COP','CRC','CVE','CZK','DJF','DKK','DOP','DZD','EGP','ETB','EUR','FJD','FKP', 'GBP','GEL','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','INR',  'ISK','JMD','JPY','KES','KGS','KHR','KMF','KRW','KYD','KZT','LAK','LBP','LKR','LRD','LSL',  'MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRO','MUR','MVR','MWK','MXN','MYR','MZN','NAD','NGN','NIO','NOK','NPR','NZD','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD','SCR','SEK','SGD','SHP','SLL','SOS','SRD','STD','SZL','THB','TJS','TOP','TRY','TTD','TWD','TZS','UAH','UGX','UYU','UZS','VND','VUV','WST','XAF','XCD','XOF','XPF','YER','ZAR','ZMW');
				  		?>
				  		<select name="stripe_payment_currency">
				  			<?php foreach($stripe_currency_arr as $currency){ ?>
				  				<option value="<?php echo $currency; ?>" <?php if($stripe_payment_currency == $currency){ echo 'selected';} ?>><?php echo $currency; ?></option>
				  			<?php } ?>

				  			
				  		</select>

				  		<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
				  		<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
				  		<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>

				  	</section>
				  	<?php submit_button(); ?>
				</div>
			</div>
		</div>
	</form>
	<?php
}

function register_WP_PYMNT_settings() {

	register_setting( 'WP-PYMNT-settings-general', 'notiemailid' );
	

	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_title' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_status' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_api_username' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_api_password' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_api_signature' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_api_merchant_email' );
	register_setting( 'WP-PYMNT-settings-group-paypal', 'paypal_mode' );

	register_setting( 'WP-PYMNT-settings-group-auth', 'auth_title' );
	register_setting( 'WP-PYMNT-settings-group-auth', 'auth_status' );
	register_setting( 'WP-PYMNT-settings-group-auth', 'auth_api_username' );
	register_setting( 'WP-PYMNT-settings-group-auth', 'auth_api_signature' );
	register_setting( 'WP-PYMNT-settings-group-auth', 'auth_mode' );

	register_setting("WP-PYMNT-settings-group-stripe", "stripe_title");
	register_setting("WP-PYMNT-settings-group-stripe", "stripe_status");
	register_setting("WP-PYMNT-settings-group-stripe", "stripe_publish_key");
	register_setting("WP-PYMNT-settings-group-stripe", "stripe_private_key");
	register_setting("WP-PYMNT-settings-group-stripe", "stripe_mode");
	
}

function WP_PYMNT_Payment_form_template(){
	?>
		<form method="post" action="options.php">
			<?php settings_fields( 'WP-PYMNT-settings-general' ); ?>
			<?php settings_errors(); ?>	
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 

		<div class="wrap">

			<div class="tabs">

				<input type="radio" id="tab1" name="tab-control" checked>
				<ul>
				    <li title="Delivery Contents">
				     	<label for="tab1" role="button" style="height:50px;">
				      		<span style="font-size:20px; font-family: raleway; font-style:italic;">Form Template</label>
				        </label>
				    </li>
				</ul>
				<div class="content">
					
	    			
				    <section>
				  		<?php $templateid = get_option('templateid') ? esc_attr(get_option('templateid')) : 1; ?>
				  		
				  		<select class="wp-payment-select-css" name="templateid" id="templateid">
							<option value="1" <?php if($templateid==1){ echo 'selected=selected';} ?>>Layout 1 - Default</option>
							<option value="2" <?php if($templateid==2){ echo 'selected=selected';} ?>>Layout 2 - Bootstrap</option>
							<option value="3" <?php if($templateid==3){ echo 'selected=selected';} ?>>Layout 3 - Poppins</option>
							<option value="4" <?php if($templateid==4){ echo 'selected=selected';} ?>>Layout 4 - Montserrat</option>
							<option value="5" <?php if($templateid==5){ echo 'selected=selected';} ?>>Layout 5 - Josefin</option>
							<option value="6" <?php if($templateid==6){ echo 'selected=selected';} ?>>Layout 6 - Oswald</option>
							<option value="7" <?php if($templateid==7){ echo 'selected=selected';} ?>>Layout 7 - PlayFair</option>
						</select>

						<div id="preview-box">
							<div id="preview-1" class="preview-image" style="display: none;">
								<span class="prev-desc">Default form style.</span>
								<img src="<?php echo plugins_url( '/templates/images/template-1.png', __FILE__ ) ?>" alt="Template 1" />
							</div>

							<div id="preview-2" class="preview-image" style="display: none;">
								<span class="prev-desc">Bootstrap form style, with default font family. 
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?>
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-2.png', __FILE__ ) ?>" alt="Template 2" />
							</div>
							<div id="preview-3" class="preview-image" style="display: none;">
								<span class="prev-desc">Bar animation form style, black and white, inspired by Google, with Poppins font family.
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?> 
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-3.png', __FILE__ ) ?>" alt="Template 3" />
							</div>
							<div id="preview-4" class="preview-image" style="display: none;">
								<span class="prev-desc">Box animation form style, viloet color combination, with Monsterrat font family.
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?>
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-4.png', __FILE__ ) ?>" alt="Template 4" />
							</div>
							<div id="preview-5" class="preview-image" style="display: none;">
								<span class="prev-desc">Label-Input box form style, black and gray, inpired by Hulk, with Josefin font family.
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?>
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-5.png', __FILE__ ) ?>" alt="Template 5" />
							</div>
							<div id="preview-6" class="preview-image" style="display: none;">
								<span class="prev-desc">Professional rectangle form style, green and black, with Oswald font family.
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?>
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-6.png', __FILE__ ) ?>" alt="Template 6" />
							</div>
							<div id="preview-7" class="preview-image" style="display: none;">
								<span class="prev-desc">Rounded shadow form style, gradient color combination, with PlayFair font family.
									<?php if( !is_plugin_active('wp-payment-layout/index.php') ){ ?>
										<a href="https://www.wpsuperiors.com/wp-payment-layouts/" target="_blank;">Get This Style</a>
									<?php } ?>
								</span>
								<img src="<?php echo plugins_url( '/templates/images/template-7.png', __FILE__ ) ?>" alt="Template 7" />
							</div>
						</div>

						<br/>
						<br/>
						<script type="text/javascript">
							jQuery( document ).ready(function() {
								var selected_layout = jQuery("#templateid").val();
								jQuery("#preview-"+selected_layout).show();
							});
							jQuery("#templateid").change(function(){
								var id = jQuery(this).val();
								jQuery(".preview-image").fadeOut('slow');
								jQuery("#preview-"+id).fadeIn('slow');
							});
						</script>
				  		
						<span class="gen_set_submit"><?php submit_button(); ?></span>
						<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
		        		<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
		        		<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>
						
				  	</section>
				  	
				</div>
			</div>
		</div>
	</form>
	<?php
}

function WP_PYMNT_Payment_form_email_settings(){
	?>
	<form method="post" action="options.php">
	    <?php settings_fields( 'WP-PYMNT-settings-email' ); ?>
	    <?php settings_errors(); ?>
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
		<div class="wrap">
			<div class="tabs">
				<input type="radio" id="tab1" name="tab-control" checked>
				<ul>
				    <li title="Delivery Contents">
				     	<label for="tab1" role="button" style="height:50px;">
				      		<span style="font-size:20px; font-family: raleway; font-style:italic;">Email Settings<span style="font-size: 10px;font-weight: 100; color:black; letter-spacing: 2px;">Available only in Premium version. <a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank">Get The Premium Version.</a></span></label>
				        </label>
				    </li>
				</ul>
				<div class="content">
				    <section>
				      	<div style="margin-bottom: 20px;border: 1px solid #e0d5d5;padding: 23px;">
				      		<h3 style="font-size: 20px;">Shortocode</h3>
				      		<label>[WP_PAYMENT_USER_DETAILS] <span> - Frontend User's Name and Email and Comments.</span></label>
				      		<br/>
				      		<label>[WP_PAYMENT_DETAILS] <span> - Successful Payments Amount, Type, Transaction ID / Subscription ID, Used Payment Gateway and Record ID.</span></label>
				      	</div>
				      	<label>User Email Body</label>
				      	<?php
				      	$useremailbody = 'Hello dear,<br/><br/>
						<p>Your payment is successful and competed.</p>
						<p><u>Here is your payment details:</u></p>
						<br/>
						[WP_PAYMENT_DETAILS]
						<br/>
						<p>Keep the ID safe, for future reference.</p>
						<p><i>Thanks</i></p>';
				      	$content = get_option('user_email_body') ? get_option('user_email_body'): $useremailbody;
          				wp_editor( $content, 'user_email_body', $settings = array('textarea_rows'=> '10') );
				      	?>
				      	<br/>
				      	<label>Admin Email Body</label>
				      	<?php
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
				      	$content = get_option('admin_email_body') ? get_option('admin_email_body') : $adminemailbody ;
          				wp_editor( $content, 'admin_email_body', $settings = array('textarea_rows'=> '10') );
				      	?>
				      	<br/>
				      	<label>User Email Subject<span>, this text used as Email Subject, do not use any special character like #, *, ! etc.</span></label>
				  		<?php $user_email_sub = get_option('user_email_sub') ? esc_attr( get_option('user_email_sub') ) : 'Payment Confirmation From '.get_bloginfo('name'); ?>
				  		<input type="text" value="<?php echo $user_email_sub; ?>" name="user_email_sub" id="user_email_sub"/>
				      	<label>Admin Email Subject<span>, this text used as Email Subject, do not use any special character like #, *, ! etc.</span></label>
				  		<?php $admin_email_sub = get_option('admin_email_sub') ? esc_attr( get_option('admin_email_sub') ) : 'Payment Notification From Your Site'; ?>
				  		<input type="text" value="<?php echo $admin_email_sub; ?>" name="admin_email_sub" id="admin_email_sub"/>

				      	<span class="gen_set_submit"><?php submit_button(); ?></span>
					  	<p style="font-family: raleway; margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
						<p style="font-family: raleway; margin-top:30px;">Still Confused? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
						<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>
					</section>
				</div>
			</div>
		</div>
	</form>

	<?php
}
function WP_PYMNT_payment_options()
{
	?>
	<div class="wrap">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
		<div class="tabs">
		  <input type="radio" id="tab1" name="tab-control" checked>
		  <input type="radio" id="tab2" name="tab-control">
		  <input type="radio" id="tab3" name="tab-control">
		  <input type="radio" id="tab4" name="tab-control">
		  	<ul>
			    <li title="Delivery Contents" class="wps-pay-active">
			     	<label for="tab1" role="button">
			      		<img src="<?php echo plugins_url( '/images/paypal.png', __FILE__ ) ?>" style="width:65%; height:auto;">
			        </label>
			    </li>
			    <li title="Shipping">
			    	<label for="tab2" role="button">
			    		<img src="<?php echo plugins_url( '/images/authorize-net.png', __FILE__ ) ?>" style="width:63%; height:auto;">
			        </label>
			    </li>
			    <li title="Stripe">
			    	<label for="tab3" role="button">
			    		<img src="<?php echo plugins_url( '/images/Stripe_Logo.png', __FILE__ ) ?>" style="width:63%; height:auto;">
			        </label>
			    </li>
			    
		  	</ul>
			
		  	<div class="content">
			    <section>
			    	<h3>Paypal Settings Tutorial</h3>
			    	<hr>
			    	<p>
			    		We need to obtain <span style="font-size:15px; font-style:italic;">1. API Username, 2. API Password, 3. API Signature</span>, the steps are below.
			    	</p>
			    	<p><b>#1.</b> Login to your Paypal Dashboard Account.</p>
			    	<p><b>#2.</b> At the below of the page, click 'Developer'.</p>
			    	<p><b>#3.</b> Into the top of the on menu, click 'APIs'.</p>
			    	<p><b>#4.</b> At the last grid of Page Content 'API Basics'.</p>
			    	<p><b>#5.</b> There is two options, 'Sandbox' and 'Go Live'. Click anyone, as you need, and follow the instruction.</p>
			  		<p><b>Please Note,</b> If you use sandbox account then set 'Mode' to 'Sandbox(Testing)' else 'Live' in <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=wp-payment-settings" target="_blank;">PayPal Settings Page</a>.</p>
			  		<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
			  		<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>
			  	</section>
			    <section>
			    	<h3>Authorize.NET Settings Tutorial</h3>
			    	<hr>
			    	<p>
			    		We need to obtain <span style="font-size:15px; font-style:italic;">1. API Login ID, 2. Transaction Key</span>, the steps are below.
			    	</p>
			    	<p><b>#1.</b> Login to your Authorize.NET Dashboard Account.</p>
			    	<p><b>#2.</b> For live account, <a href="https://www.authorize.net/" target="_blank;">https://www.authorize.net/</a></p>
			    	<p><b>#3.</b> For sandbox / test account, <a href="https://sandbox.authorize.net/" target="_blank;">https://sandbox.authorize.net/</a></p>
			    	<p><b>#4.</b> At left-hand menu of your dashboard under 'A C C O U N T' section, click 'Settings'.</p>
			    	<p><b>#5.</b> Under 'Security Settings ', click 'API Credentials & Keys '.</p>
			    	<p><b>#6.</b> API Login ID is already there, just Create New Keys, which is actualy your 'Transaction Key'.</p>
			  		<p><b>#7.</b> Default answer of 'What is your pet's name?' is 'Simon'.</p>
			  		<p><b>Please Note,</b> If you use sandbox account then set 'Mode' to 'Sandbox(Testing)' else 'Live' in <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=wp-payment-settings" target="_blank;">Authorize.NET Settings Page</a>.</p>
			  		<p style="margin-top:30px; font-size:12px;">Put Shortcode <b>[WP_PAYMENT_FORM]</b> on your page.</p>
			  		<p style="margin-top:30px; font-size:12px;">Still Confused? Need to Add / Delete form fields? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
			  		<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a>
				  		</p>
			  	</section>
			  	<section>
			    	<h3>Stripe Settings Tutorial</h3>
			    	<hr>
			    	<p>
			    		We need to obtain <span style="font-size:15px; font-style:italic;">1. Publishable Key, 2. Secret Key</span>, the steps are below.
			    	</p>
			    	<p><b>#1.</b> Login to your Stripe Dashboard Account.</p>
			    	<p><b>#2.</b> At left side of your dashboard click 'Developers'.</p>
			    	<p><b>#3.</b> Under 'Developers', click 'API keys '.</p>
			    	<p><b>#4.</b> Get the keys from 'Standard keys' section.</p>
			  		<p><b>Please Note,</b> If you use sandbox account then set 'Mode' to 'Sandbox(Testing)' else 'Live' in <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=wp-payment-settings" target="_blank;">Stripe Settings Page</a>.</p>
			      	<p style="margin-top:30px;">Still Confused? Need our help? Feel free to write on us <a style="text-decoration:none;" href="mailto:support@wpsuperiors.com">support@wpsuperiors.com</a> OR visit <a style="text-decoration:none;" href="http://www.wpsuperiors.com/contact-us/" target="_blank">Contact Us</a></p>
					<p>Love to use this plugin? Show your love by giving 
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span>
				  			<span style="font-size:200%;color:yellow;">&starf;</span> review on <a href="https://wordpress.org/support/plugin/wp-payment/reviews/#new-post" target="_blank;">WordPress</a> and on <a href="http://wpsuperiors.com/shop/wp-payment/" target="_blank;">WPSuperiors.</a>
				  		</p>
				</section>
			    
		  	</div>
			
		</div>
	</div>
	<?php
}

function WP_PYMNT_common_header()
{
	?>
	<div style="float:right; margin: 10px 20px 30px; ">
		<a target="_blank;" href="http://www.wpsuperiors.com/contact-us/"><img src="<?php echo plugins_url( '/images/ads.jpg', __FILE__ ) ?>" />
		</a>
	</div>
	<?php
}

add_filter( 'post_row_actions', 'WP_PYMNT_remove_row_actions', 10, 1 );

function WP_PYMNT_remove_row_actions( $actions )
{
    //print_r($actions);
    if( get_post_type() === 'paymentsubmission' )
        unset( $actions['view'] );
    	unset( $actions['inline hide-if-no-js'] );
    return $actions;
}

add_filter('post_updated_messages', 'WP_PYMNT_updated_messages');
function WP_PYMNT_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['paymentsubmission'] = array(
    1 => sprintf( __('Submitted data updated.')),
  );

  return $messages;
}
function WP_PYMNT_columns($columns) {
   
    $new_columns['cb'] = '<input type="checkbox" />';
     
    $new_columns['title'] = _x('Title', 'column name');

    $new_columns['tran'] = _x('Transaction ID / Subscription ID', 'column name');

    $new_columns['amount'] = _x('Amount', 'column name');
 
    $new_columns['pay_date'] = _x('Payment Date', 'column name');
 
    return $new_columns;
}
add_filter('manage_paymentsubmission_posts_columns' , 'WP_PYMNT_columns');




function WP_PYMNT_post_column( $column ) {
    global $post;
   
    switch ( $column ) {
      case 'tran':
      	if(get_post_meta( $post->ID , 'transactionId' , true )){
        	echo get_post_meta( $post->ID , 'transactionId' , true );
        }else{
        	echo get_post_meta( $post->ID , 'subscription_id' , true );
        }
        break;
       case 'pay_date':
       	echo $post->post_date;
       	break;
       case 'amount':
       	echo get_post_meta( $post->ID , 'pay_amount' , true ).' USD';
       	break;

    }
}
add_action( 'manage_paymentsubmission_posts_custom_column' , 'WP_PYMNT_post_column' );

function WP_PYMNT_payment_publishing_actions()
{
	$mg_post_type = 'paymentsubmission';
	global $post;
	if($post->post_type == $mg_post_type){
	echo '<style type="text/css">
			#misc-publishing-actions,
			#minor-publishing-actions{
			display:none;
			}
			</style>';
		}
}
add_action('admin_head-post.php', 'WP_PYMNT_payment_publishing_actions');
add_action('admin_head-post-new.php', 'WP_PYMNT_payment_publishing_actions');


add_action( 'add_meta_boxes', 'WP_PYMNT_add_pay_submit_metaboxes' );

function WP_PYMNT_add_pay_submit_metaboxes()
{
	add_meta_box('WP_PYMNT_display_pay_submit_metabox', 'User Details', 'WP_PYMNT_display_pay_submit_metabox', 'paymentsubmission');
}

function WP_PYMNT_display_pay_submit_metabox()
{
	global $post;
	?>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
	
		<div class="payDetails">
			<h3>Personal Details</h3>
			<p><span class="left">Name:</span><span class="text"><?php echo get_post_meta($post->ID, 'payer_name', true); ?></span></p>
			<p><span class="left">Email:</span><span class="text"><?php echo get_post_meta($post->ID, 'payer_email', true); ?></span></p>
			<p><span class="left">Comments:</span> <span class="text"><?php echo get_post_meta($post->ID, 'payer_comments', true); ?></span></p>
			
			<h3>Payment Details</h3>
			<p><span class="left">Amount:</span> <span class="text"><?php echo get_post_meta($post->ID, 'pay_amount', true).' USD'; ?></span></p>
			<p><span class="left">Transaction Id:</span> <span class="text"><?php echo get_post_meta($post->ID, 'transactionId', true); ?></span></p>
			<p><span class="left">Payment Gateway:</span> <span class="text"><?php echo get_post_meta($post->ID, 'pay_throygh', true); ?></span></p>
			<p><span class="left">Date:</span> <span class="text"><?php echo $post->post_date; ?></span></p>
			<h3>Subscription Details</h3>
			<p><span class="left">Amount:</span></p>
			<p><span class="left">Subscription Id:</span></p>
			<p><span class="left">Interval Length:</span></p>
			<p><span class="left">Interval Unit:</span></p>
			<p><span class="left">Customer ID:</span></p>
			<p><span class="left">Invoice ID:</span></p>
			<p><span class="left">Refference ID:</span></p>
			<p><span class="left">Date:</span></p>
			<div class="premium">
	        	<span class="premium_link">
	        		<img src="<?php echo plugins_url( '/images/premium.png', __FILE__ ) ?>">
	        	</span>
	        	<span class="buynow_link" style="">
	        		<a href="https://www.wpsuperiors.com/shop/wp-payment/" target="_blank;">
	        			<img style="width: 22%;" src="<?php echo plugins_url( '/images/buynow.gif', __FILE__ ) ?>">
	        		</a>
	        	</span>
			</div>
		</div>
		<?php
}

