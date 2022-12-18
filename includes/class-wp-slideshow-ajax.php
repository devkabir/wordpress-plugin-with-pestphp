<?php
/**
 * This file will handle ajax request
 *
 * @package    WP_Slideshow
 * @since      1.0.0
 */

class WP_Slideshow_Ajax {
	use WP_Slideshow_Singleton;

	public function __construct() {
		add_action( 'wp_ajax_slideshow_ajax', array( $this, 'handle' ) );
	}

	final public function handle(): void {
		if ( array_key_exists( 'slide_nonce_1', $_REQUEST ) ) {
			$this->reorder_slide();
		} elseif ( array_key_exists( 'slide_nonce_2', $_REQUEST ) ) {
			$this->delete_slide();
		} else {
			wp_send_json_error( __( 'Who are you ??', 'wordpress-slideshow' ) );
		}
	}

	private function delete_slide(): void {
		if ( check_ajax_referer( 'slide-delete', 'slide_nonce_2' ) && array_key_exists( 'image', $_REQUEST ) ) {
			$slides  = get_option( 'wordpress_slideshow_slides', array() );
			$updated = array_filter(
				$slides,
				static function ( $image ) {
					return $image !== $_REQUEST['image'];
				}
			);
			if ( update_option( 'wordpress_slideshow_slides', $updated ) ) {
				wp_send_json_success( __( 'Slider removed!', 'wordpress-slideshow' ) );
			} else {
				wp_send_json_error( __( 'Invalid image id!', 'wordpress-slideshow' ) );
			}
		} else {
			wp_send_json_error( __( 'Invalid request!', 'wordpress-slideshow' ) );
		}
	}

	private function reorder_slide(): void {

		if ( check_ajax_referer( 'slide-order-update', 'slide_nonce_1' ) ) {
			$option = $_REQUEST['item'];
			if ( update_option( 'wordpress_slideshow_slides', $option ) ) {
				wp_send_json_success( __( 'Slider order updated!', 'wordpress-slideshow' ) );
			}
		} else {
			wp_send_json_error( __( 'Invalid request', 'wordpress-slideshow' ) );
		}
	}


}
