<?php
namespace ElementorModal\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Frontend;
use WP_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ElementorModal extends Widget_Base {
	
	protected $_has_template_content = false;
	
	public function get_name() {
		return 'WP Payment';
	}
	public function get_title() {
		return __( 'WP Payment', 'elementor' );
	}
	public function get_icon() {
		return 'dashicons-before dashicons-feedback';
	}
	public function get_categories() {
		return [ 'general' ];
	}
	/*public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'modal-for-elementor' ),
			'sm' => __( 'Small', 'modal-for-elementor' ),
			'md' => __( 'Medium', 'modal-for-elementor' ),
			'lg' => __( 'Large', 'modal-for-elementor' ),
			'xl' => __( 'Extra Large', 'modal-for-elementor' ),
		];
	}
	protected function get_popups() {
		$popups_query = new WP_Query( array(
			'post_type' => 'elementor-popup',
			'posts_per_page' => -1,
		) );

		if ( $popups_query->have_posts() ) {
			$popups_array = array();
			$popups = $popups_query->get_posts();
			
			$i = 0;
			foreach( $popups as $popap ) {
				$popups_array[$popap->ID] = $popap->post_title;
				if($i === 0)
					$selected = $popap->ID;
				$i++;
			}
			
			$popups = array(
				'first_popup' => $selected,
				'popups' => $popups_array,
			);
			return $popups;
		}
	}*/
	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_popup',
			[
				'label' => __( 'WP Payment Form Settings', 'elementor' ),
			]
		);
		
		
		$this->add_control(
			'wps_wp_pay_form_shortcode',
			[
				'label' => __( 'Shortcode', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '[WP_PAYMENT_FORM]',
				'return_value' => 'yes',
				'description' => __( 'Want to change the form style? <a target="_blank;" href="'.admin_url("admin.php?page=wp-form-template").'">Click Here</a><br/>Want to change payment settings? <a target="_blank;" href="'.admin_url("admin.php?page=payment").'">Click Here</a>', 'elementor' ),
			]
		);

		// $this->add_responsive_control(
  //           'wps_wp_pay_alignment',
		// 	[
		// 		'label' => __('Alignment', 'elementor'),
		// 		'type' => Controls_Manager::CHOOSE,
		// 		'options' => [
		// 			'left' => [
		// 				'title' => __('Left', 'elementor'),
		// 				'icon' => 'fa fa-align-left',
		// 			],
		// 			'center' => [
		// 				'title' => __('Center', 'elementor'),
		// 				'icon' => 'fa fa-align-center',
		// 			],
		// 			'right' => [
		// 				'title' => __('Right', 'elementor'),
		// 				'icon' => 'fa fa-align-right',
		// 			],
		// 			'justify' => [
		// 				'title' => __('Justified', 'elementor'),
		// 				'icon' => 'fa fa-align-justify',
		// 			],
		// 		],
		// 		'prefix_class' => 'elementor%s-align-',
		// 		'default' => '',
  //           ]
  //       );
        
        
		$this->end_controls_section();         

	}
	protected function render() {
		$settings 	= $this->get_settings();

		if( $settings['wps_wp_pay_form_shortcode'] ){
			echo do_shortcode( $settings['wps_wp_pay_form_shortcode'] );
		}else{
			echo do_shortcode( '[WP_PAYMENT_FORM]' );
		}
		
		

		
	}
	protected function _content_template() {}

}