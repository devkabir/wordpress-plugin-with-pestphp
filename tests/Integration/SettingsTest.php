<?php
/**
 * WP Slideshow Settings Test
 *
 * @package    WP_Slideshow
 * @subpackage SettingsTest
 * @since      1.0.0
 */

namespace Tests\Integration;

require_once __DIR__ . '/../../includes/class-wp-slideshow-settings.php';

use WP_Slideshow_Settings;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertStringNotContainsString;
use function PHPUnit\Framework\assertTrue;


beforeEach(
	function () {
		parent::setUp();
		wp_set_current_user( 1 );
	}
);

afterEach(
	function () {
		parent::tearDown();
	}
);

test(
	'Settings class follow singleton',
	function () {
		$instance1 = WP_Slideshow_Settings::get_instances();
		$instance2 = WP_Slideshow_Settings::get_instances();
		assertInstanceOf( 'WP_Slideshow_Settings', $instance1 );
		assertInstanceOf( 'WP_Slideshow_Settings', $instance2 );
		assertSame( $instance1, $instance2 );
	}
);

test(
	'admin can access to settings',
	function () {
		assertTrue( current_user_can( 'manage_options' ) );
		assertNotFalse( has_action( 'admin_menu', array( WP_Slideshow_Settings::get_instances(), 'menu' ) ) );
		WP_Slideshow_Settings::get_instances()->menu();
		$expected = 'http://example.org/wp-admin/admin.php?page=wordpress-slideshow-plugin';
		assertSame( $expected, menu_page_url( 'wordpress-slideshow-plugin', false ) );
	}
);

test(
	'settings are registered properly',
	function () {
		WP_Slideshow_Settings::get_instances()->init();
		$registered = get_registered_settings();
		$option     = 'wordpress_slideshow_slides';
		assertArrayHasKey( $option, $registered );
		$args  = $registered[ $option ];
		$group = 'wordpress_slideshow_settings';
		assertSame( $group, $args['group'] );

		// Check defaults.
		assertSame( 'array', $args['type'] );
		assertFalse( $args['show_in_rest'] );

	}
);

test(
	'sanitization of the option working correctly',
	function () {
		WP_Slideshow_Settings::get_instances()->init();
		$filtered = apply_filters( 'sanitize_option_wordpress_slideshow_slides', 'smart' );
		expect( $filtered )
			->toBeArray()
			->toBeEmpty();
		$filtered = apply_filters( 'sanitize_option_wordpress_slideshow_slides', array( 'smart' ) );
		expect( $filtered )
			->toBeArray()
			->toContain( 'smart' );
	}
);

test(
	'slides rendered rendered correctly',
	function () {
		set_current_screen( 'toplevel_page_wordpress-slideshow-plugin' );
		WP_Slideshow_Settings::get_instances()->menu();
		ob_start();
		do_meta_boxes( get_current_screen()->id, 'normal', null );
		$slides = ob_get_clean();
		assertStringContainsString( 'Slides', $slides );
		$option = get_option( 'wordpress_slideshow_slides', array() );
		if ( empty( $option ) ) {
			assertStringContainsString( 'No slide available', $slides );
		} else {
			assertStringNotContainsString( 'No slide available', $slides );
		}
	}
);

test(
	'upload form rendered rendered correctly',
	function () {
		set_current_screen( 'toplevel_page_wordpress-slideshow-plugin' );
		WP_Slideshow_Settings::get_instances()->menu();
		ob_start();
		do_meta_boxes( get_current_screen()->id, 'side', null );
		$slides = ob_get_clean();
		assertStringContainsString( 'Upload', $slides );
	}
);
