<?php

/**
 * WordPress Slideshow Settings
 *
 *
 * @package    WP_Slideshow
 * @subpackage Settings
 * @since      1.0.0
 */


/**
 * It's a singleton class that adds a menu page to the admin menu.
 *
 * @package    WP_Slideshow
 */
final class WP_Slideshow_Settings {
	use WP_Slideshow_Singleton;


	/**
	 * This is a WordPress function that adds a new menu item to the WordPress admin menu.
	 */
	private function __construct() {
		if ( current_user_can( 'manage_options' ) ) {
			add_action( 'admin_menu', array( $this, 'menu' ) );
			add_action( 'admin_init', array( $this, 'init' ) );
		}
	}


	/**
	 * It adds a menu page to the WordPress admin menu
	 *
	 * @return void
	 */
	public function menu(): void {
		add_menu_page(
			'WordPress Slideshow',
			'WP Slide',
			'manage_options',
			'wordpress-slideshow-plugin',
			array( $this, 'page' ),
			'dashicons-slides',
			2
		);
	}


	public function page(): void {
		echo 'WP Slideshow';
	}

	public function init(): void {
		register_setting(
			'wordpress_slideshow_settings',
			'wordpress_slideshow_slides',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
			)
		);
	}

	public function sanitize( $input ): array {
		$sanitary_values = array();
		if ( isset( $input ) && is_array( $input ) ) {
			$sanitary_values = $input;
		}

		return $sanitary_values;
	}

}
