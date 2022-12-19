<?php
/**
 * Ajax Test
 *
 * @since 1.0.0
 */
namespace tests\Ajax;

require_once __DIR__ . '/../../includes/class-wp-slideshow-ajax.php';
beforeEach(
	function () {
		parent::setUp();
		WP_Slideshow_Ajax::get_instances();
		$this->response = '';
		add_filter( 'wp_doing_ajax', '__return_true' );
		add_filter(
			'wp_die_ajax_handler',
			function ( $message ) {
				$this->response .= ob_get_clean();
				if ( '' === $this->response ) {
					if ( is_scalar( $message ) ) {
						throw new WPAjaxDieStopException( (string) $message );
					} else {
						throw new WPAjaxDieStopException( '0' );
					}
				} else {
					throw new WPAjaxDieContinueException( $message );
				}
			},
			1,
			1
		);
		error_reporting( error_reporting() & ~E_WARNING );
		set_current_screen( 'ajax' );
		do_action( 'admin_init' );
	}
);
afterEach(
	function () {
		$_REQUEST = array();
		set_current_screen( 'front' );
		parent::tearDown();
	}
);
test(
	'slide order update by ajax working properly',
	function () {
		$_REQUEST = array(
			'slide_nonce_1' => wp_create_nonce( 'slide-order-update' ),
			'item'          => array( wp_rand( 1, 100 ) ),
		);
		try {
			// Start output buffering.
			ini_set( 'implicit_flush', false );
			ob_start();
			do_action( 'wp_ajax_slideshow_ajax', null );
			// Save the output.
			$buffer = ob_get_clean();
			if ( ! empty( $buffer ) ) {
				$this->response = $buffer;
			}
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$response = json_decode( $this->response, true );
		expect( $response )
			->toBeArray()
			->toHaveKey( 'success', true )
			->toHaveKey( 'data', 'Slider order updated!' );
	}
);

test(
	'delete slide by ajax working properly',
	function () {
		update_option( 'wordpress_slideshow_slides', range( 1, 5 ) );
		$_REQUEST = array(
			'slide_nonce_2' => wp_create_nonce( 'slide-delete' ),
			'image'         => 5,
		);
		try {
			// Start output buffering.
			ini_set( 'implicit_flush', false );
			ob_start();
			do_action( 'wp_ajax_slideshow_ajax', null );
			// Save the output.
			$buffer = ob_get_clean();
			if ( ! empty( $buffer ) ) {
				$this->response = $buffer;
			}
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$response = json_decode( $this->response, true );
		expect( $response )
			->toBeArray()
			->toHaveKey( 'success', true )
			->toHaveKey( 'data', 'Slider removed!' );
		expect( get_option( 'wordpress_slideshow_slides' ) )
			->toBeArray()
			->toEqual( range( 1, 4 ) );
	}
);
