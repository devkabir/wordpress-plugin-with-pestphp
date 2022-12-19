<?php
/**
 * This file will handle ajax request
 *
 * @package    WP_Slideshow
 * @since      1.0.0
 */

class WP_Slideshow_Ajax {

	use WP_Slideshow_Singleton;

	private function __construct() {
		add_action( 'wp_ajax_slideshow_ajax', array( $this, 'handle' ) );
	}

	final public function handle(): void {
		if ( check_ajax_referer( 'slide-order-update', 'slide_nonce_1', false ) ) {
			$this->reorder_slide( $_REQUEST['item'] );
		} elseif ( check_ajax_referer( 'slide-delete', 'slide_nonce_2', false ) ) {
			$this->delete_slide( $_REQUEST['image'] );
		} else {
			wp_send_json_error( __( 'Something went wrong!', 'wordpress-slideshow' ) );
		}
	}

	private function reorder_slide( $slides ): void {
		if ( update_option( 'wordpress_slideshow_slides', $slides ) ) {
			wp_send_json_success( __( 'Slider order updated!', 'wordpress-slideshow' ) );
		} else {
			wp_send_json_error( __( 'Invalid request!', 'wordpress-slideshow' ) );
		}
	}

	private function delete_slide( $image_id ): void {
		$slides  = get_option( 'wordpress_slideshow_slides', array() );
		$updated = array_filter(
			$slides,
			static function ( $image ) use ( $image_id ) {
				return $image !== $image_id;
			}
		);
		if ( update_option( 'wordpress_slideshow_slides', $updated ) ) {
			wp_send_json_success( __( 'Slider removed!', 'wordpress-slideshow' ) );
		} else {
			wp_send_json_error( __( 'Invalid image id!', 'wordpress-slideshow' ) );
		}
	}


}
