<?php 
class WPaymentGutenBlock
{
	
	public function __construct()
	{
		add_action('enqueue_block_editor_assets', array( $this, 'WP_Pay_Guten_load_block' ) );
	}
	public function WP_Pay_Guten_load_block(){
 		wp_enqueue_script(
		    'wp-payment-gutenbarg',
		    WP_PAY_JS . 'wp-payment-gutenbarg.js',
		    array('wp-blocks','wp-editor'),
		    true
		);
	}
}
new WPaymentGutenBlock;
?>