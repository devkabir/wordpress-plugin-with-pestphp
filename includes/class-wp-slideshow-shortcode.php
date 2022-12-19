<?php
/**
 * This file will add and render shortcode.
 *
 * @package    WP_Slideshow
 * @since      1.0.0
 */

/**
 * `WP_Slideshow_Shortcode` is a singleton class that adds a shortcode called `myslideshow`
 *  that returns the string `hello`
 *
 * @package    WP_Slideshow
 */
class WP_Slideshow_Shortcode {
	use WP_Slideshow_Singleton;


	/* Adding shortcode callback to the `init` hook. */
	private function __construct() {
		add_action( 'init', array( $this, 'add' ) );
	}

	/**
	 * It adds a shortcode called `myslideshow` that returns the string `hello`
	 *
	 * @return void
	 */
	final public function add(): void {
		add_shortcode(
			'myslideshow',
			function () {
				wp_enqueue_style( 'wordpress-slideshow' );
				wp_enqueue_script( 'wordpress-slideshow' );
				$images = get_option( 'wordpress_slideshow_slides', array() );
				ob_start();
				include __DIR__ . '/../templates/shortcode.php';
				return ob_get_clean();
			}
		);
	}

}

