<?php
/**
 * This file will add and render shortcode.
 *
 * @package    WP_Slideshow
 * @since      1.0.0
 */

/**
 * `WP_Slideshow` is a singleton class that adds a shortcode called `myslideshow`
 *  that returns the string `hello`
 *
 * @package    WP_Slideshow
 */
class WP_Slideshow {
	use WP_Slideshow_Singleton;


	/* Adding shortcode callback to the `init` hook. */
	private function __construct() {
		add_action( 'init', array( $this, 'add_shortcode' ) );
	}

	/**
	 * It adds a shortcode called `myslideshow` that returns the string `hello`
	 *
	 * @return void 'hello'
	 */
	final public function add_shortcode(): void {
		add_shortcode(
			'myslideshow',
			static function () {
				return 'hello';
			}
		);
	}

}
