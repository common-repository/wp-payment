<?php
namespace ElementorModal;

use ElementorModal\Widgets\ElementorModal;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ElementorModalPlugin {

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->add_actions();
	}

	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
	}

	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	private function includes() {
		require __DIR__ . '/wp-elem.php';
	}

	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ElementorModal() );
        \Elementor\Plugin::instance()->elements_manager->add_category(
			'wps-wp-payment-elem',
			[
				'title' => __( 'WP Payment', 'elementor' ),
				'icon' => 'dashicons-before dashicons-feedback'
			],
			1
		);
	}
}

new ElementorModalPlugin();