<?php
/*
Plugin Name: WP Payment
Plugin URI: https://www.wpsuperiors.com/wp-payment-details/
Description: On site payments through Authorize.NET, PayPal Pro and Stripe with Email Notification. Use shortcode '[WP_PAYMENT_FORM]'.
Version: 2.2.8
Author: WPSuperiors
Author URI: https://www.wpsuperiors.com
*/

/*
*	CREATE A ERROR LOG FILE INTO THE PLUGINS DIR.
*/
include_once(ABSPATH.'wp-admin/includes/plugin.php');
add_action('activated_plugin','WP_PYMNT_pay_save_error');
function WP_PYMNT_pay_save_error()
{
    file_put_contents(dirname(__file__).'/error_activation.txt', ob_get_contents());
}

/* 
*	LOAD THE FILES AT THE START
*/

add_action('init','WP_PYMNT_load');
function WP_PYMNT_load()
{
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'WP_PYMNT_action_links' );
	
	wp_register_script('WP_PYMNT_script_1', plugins_url( '/js/jquery.pay.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('WP_PYMNT_script_1');

	wp_register_style('WP_PYMNT_css_1',plugins_url( '/css/style.css', __FILE__ ));
    wp_enqueue_style('WP_PYMNT_css_1');

    wp_register_style('WP_PYMNT_css_2',plugins_url( '/css/tab.css', __FILE__ ));
    wp_enqueue_style('WP_PYMNT_css_2');

    $labels = array(
		'name'               => _x( 'Submitted Payments', 'post type general name', 'payment-submission' ),
		'singular_name'      => _x( 'Submitted Payment', 'post type singular name', 'payment-submission' ),
		'menu_name'          => _x( 'Submitted Payments', 'admin menu', 'payment-submission' ),
		'name_admin_bar'     => _x( 'Submitted Payment', 'add new on admin bar', 'payment-submission' ),
		'add_new'            => _x( 'Add New', 'paymentSubmission', 'payment-submission' ),
		'add_new_item'       => __( 'Add New Submitted Payment', 'payment-submission' ),
		'new_item'           => __( 'New Submitted Payment', 'payment-submission' ),
		'edit_item'          => __( 'Edit Submitted Payment', 'payment-submission' ),
		'view_item'          => __( 'View Submitted Payment', 'payment-submission' ),
		'all_items'          => __( 'All Submitted Payments', 'payment-submission' ),
		'search_items'       => __( 'Search Submitted Payments', 'payment-submission' ),
		'parent_item_colon'  => __( 'Parent Submitted Payments:', 'payment-submission' ),
		'not_found'          => __( 'No payments found.', 'payment-submission' ),
		'not_found_in_trash' => __( 'No payments found in Trash.', 'payment-submission' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'payment-submission' ),
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'paymentSubmission' ),
		'capability_type'    => 'post',
  		'capabilities' => array(
   					'create_posts' => false
 			 ),
  		'map_meta_cap' => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 100,
		'menu_icon'           => 'dashicons-tickets-alt',
		'supports'           => array( 'title')
	);




    register_post_type( 'paymentSubmission', $args);

    require_once(dirname(__file__).'/admin-settings.php');
	require_once(dirname(__file__).'/payment-submission.php');
	WP_PYMNT_submitForm();
}

global $wp_version;
if ( version_compare( $wp_version, '5.1', '>=' ) ) {
	define( 'WP_PAY_JS', plugin_dir_url( __FILE__ ).'js/' );
	require_once(dirname(__file__).'/block/wp-guten.php');
}

if(is_plugin_active('elementor/elementor.php')){
	require 'block/wp-elem-app-wdget.php';
}

add_shortcode('WP_PAYMENT_FORM', 'WP_PYMNT_display_init');
function WP_PYMNT_display_init()
{
	ob_start();
	WP_PYMNT_display();
	return ob_get_clean();
}
function WP_PYMNT_display()
{
	wp_register_script('WP_PYMNT_script_2', plugins_url( '/js/form-validation.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('WP_PYMNT_script_2');
	if( is_plugin_active('wp-payment-layout/index.php') ){
		do_action('add_wp_payment_layouts');
	}else{
		?>
		<div class="form-style-2">
			
			<form name="paymentSubmit" action="" method="POST" id="paymentSubmit">
				<div class="userDetails">
					<div class="form-style-2-heading">User Details</div>
					<label>
						<span>Name<span class="required">*</span></span>
						<input type="text" name="your_name" class="input-field" id="your_name" /> 
						<div id="elmNameError" class="errorMsg"></div>
					</label>
					<label>
						<span>Email<span class="required">*</span></span>
						<input type="text" name="email" class="input-field" id="email" />
						<div id="elmEmailError" class="errorMsg"></div>
					</label>
					<label>
						<span>Comments</span>
						<textarea class="textarea-field" name="comments"></textarea>
					</label>
				</div>
				<?php $paypal_title = get_option('paypal_title') ? esc_attr( get_option('paypal_title') ) : 'By PayPal'; ?>
				<?php $auth_title = get_option('auth_title') ? esc_attr( get_option('auth_title') ) : 'Credit Card (by Authorize.NET)'; ?>
				<?php $auth_status = get_option('auth_status') ? esc_attr( get_option('auth_status') ) : 'enable'; ?>
				<?php $paypal_status = get_option('paypal_status') ? esc_attr( get_option('paypal_status') ) : 'enable'; ?>
				<?php 
					if($auth_status == 'disable' && $paypal_status == 'disable') { 
						echo "Payment system is not available.";
					}else{
				?>
						<div class="payment">
							<div class="form-style-2-heading">Payment Details</div>
							<label for="choosePayment"><span>Payment Through</span>
								<select name="choosePayment" id="choosePayment" onChange="enable();" class="select-field" style="width: 48%;">
									<?php if($auth_status == 'enable'){ ?>
									<option value="authorize"><?php echo $auth_title; ?></option>
									<?php } ?>
									<?php if($paypal_status == 'enable'){ ?>
									<option value="paypal"><?php echo $paypal_title; ?></option>
									<?php } ?>
								</select>
							</label>
							<?php if($paypal_status == 'enable'){ ?>
							<div id="paypal">
								<label>
									<span>Amount(in USD)<span class="required">*</span></span>
									<input type="text" name="paypal_amount" class="input-field" id="paypal_amount" />
									<div id="elmPaypalAmountError" class="errorMsg"></div>
								</label>
								<label><span>Card Type</span>
									<select name="_paypal_card_type" class="select-field" style="width: 48%;">
										<option value="mastercard">MasterCard</option>
										<option value="visa">Visa</option>
										<option value="amex">American Express</option>
										<option value="discover">Discover</option>
									</select>
								</label>
								<label>
									<span>Card No.<span class="required">*</span></span>
									<input type="text" id="cardNo1" rel="19" name="_paypal_card_no" class="input-field" />
									<div id="elmCardNo1Error" class="errorMsg"></div>
								</label>
								<label>
									<span>Card Exp. Date</span>
									<select name="_paypal_card_exp_month" class="select-field" style="width: 19%;">
										<?php
											for ($i=1; $i <=12 ; $i++) { 
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
										?>
									</select>
									<select name="_paypal_card_exp_year" class="select-field" style="width: 28%;">
										<?php
											for ($i=date('Y'); $i <= date('Y')+100 ; $i++) { 
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
										?>
									</select>
								</label>
								
							</div>
							<?php } ?>
							<?php if($auth_status == 'enable'){ ?>
							<div id="authorize">
								<label>
									<span>Amount(in USD)<span class="required">*</span></span>
									<input type="text" name="onetime_auth_amount" class="input-field" id="auth_amount" />
									<div id="elmAuthamountError" class="errorMsg"></div>
								</label>
								
								<label>
									<span>Card No.<span class="required">*</span></span>
									<input type="text" id="cardNo2" rel="19" name="_auth_card_no" class="input-field" />
									<div id="elmCardNo2Error" class="errorMsg"></div>
								</label>
								<label>
									<span>Card Exp. Date</span>
									<select name="_auth_card_exp_month" class="select-field" style="width: 19%;">
										<?php
											for ($i=1; $i <=12 ; $i++) { 
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
										?>
									</select>
									<select name="_auth_card_exp_year" class="select-field" style="width: 28%;">
										<?php
											for ($i=date('Y'); $i <= date('Y')+100 ; $i++) { 
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
										?>
									</select>
								</label>
								
							</div>
							<?php } ?>
							
						</div>
						<input type="submit" name="submit" value="Pay" id="btnSubmit" class="submit" />
						<input type="hidden" name="redirectUrl" value="<?php echo get_permalink();?>" />
				<?php } ?>
				<?php 
					if(isset($_GET['wp_payment_msg']))
					{
						
						if($_GET['appr_status'] == 1)
						{
							?>
								<div class="success">
									<?php print_r($_GET['wp_payment_msg']);?>
								</div>
							<?php
						}
						if($_GET['appr_status'] == 0)
						{
							?>
								<div class="failure">
									<?php print_r($_GET['wp_payment_msg']);?>
								</div>
							<?php
						}

					}
				?>
			</form>
		</div>
		<?php
	}
}

function WP_PYMNT_action_links($links)
{
	$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=payment' ) . '">' . __( 'Payment Gateway') . '</a>',
				'<a href="https://www.wpsuperiors.com/wp-payment-details/">' . __( 'Premium') . '</a>',
				'<a href="https://www.wpsuperiors.com/wp-payment-layouts/">' . __( 'Layouts') . '</a>',
				'<a href="https://www.wpsuperiors.com/wp-payment/">' . __( 'Documentation') . '</a>',
			);
			return array_merge( $plugin_links, $links );
}