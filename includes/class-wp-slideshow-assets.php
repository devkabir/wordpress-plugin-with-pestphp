<?php
/**
 * WP Slideshow Assets
 *
 * @package    WP_Slideshow
 * @subpackage Assets
 * @since      1.0.0
 */


final class WP_Slideshow_Assets {
	/* A trait to make this class singleton */
	use WP_Slideshow_Singleton;

	/**
	 * It add callbacks to page specific actions
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin' ) );
		}
	}

	/**
	 * It registers the admin styles and scripts
	 *
	 * @return void
	 */
	public function admin(): void {
		wp_register_style(
			'wordpress-slideshow',
			plugin_dir_url( __DIR__ ) . 'assets/admin.css',
			array(),
			'1.0.0'
		);
		wp_register_script(
			'wordpress-slideshow',
			plugin_dir_url( __DIR__ ) . 'assets/admin.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_register_style(
			'wordpress-slideshow-notification',
			'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css',
			array(),
			'1.0.0'
		);
		wp_register_script(
			'wordpress-slideshow-notification',
			'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js',
			array(),
			'1.0.0',
			true
		);
	}

}
