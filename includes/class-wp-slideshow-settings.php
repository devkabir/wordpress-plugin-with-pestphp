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
class WP_Slideshow_Settings {
	use WP_Slideshow_Singleton;


	/**
	 * This is a WordPress function that adds a new menu item to the WordPress admin menu.
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
	}


	/**
	 * It adds a menu page to the WordPress admin menu
	 *
	 * @return void
	 */
	final public function menu(): void {
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


	final public function page(): void {
		echo 'WP Slideshow';
	}

}
