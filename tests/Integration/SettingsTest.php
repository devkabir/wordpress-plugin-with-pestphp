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
require_once __DIR__ . '/../../includes/class-wp-slideshow-assets.php';

use WP_Slideshow_Assets;
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
		error_reporting( error_reporting() & ~E_WARNING );
		$this->screen_id = 'toplevel_page_wordpress-slideshow-plugin';
		set_current_screen( $this->screen_id );
		wp_set_current_user( 1 );
		WP_Slideshow_Assets::get_instances();
		WP_Slideshow_Settings::get_instances()->page();
		do_action( 'admin_enqueue_scripts' );
		do_action( 'admin_init' );
		do_action( 'admin_menu' );

	}
);

afterEach(
	function () {
		set_current_screen( 'front' );
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
	'is admin',
	function() {
		assertTrue( is_admin() );
		assertSame( $this->screen_id, get_current_screen()->id );
	}
);
test(
	'admin can access to settings',
	function () {
		assertTrue( current_user_can( 'manage_options' ) );
		assertNotFalse( has_action( 'admin_menu', array( WP_Slideshow_Settings::get_instances(), 'menu' ) ) );
		$expected = 'http://example.org/wp-admin/admin.php?page=wordpress-slideshow-plugin';
		assertSame( $expected, menu_page_url( 'wordpress-slideshow-plugin', false ) );
	}
);

test(
	'settings are registered properly',
	function () {
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
	'settings enqueued scripts properly',
	function () {
		assertTrue( is_admin() );
		assertSame( $this->screen_id, get_current_screen()->id );
		assertTrue( wp_style_is( 'wordpress-slideshow' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow' ) );
		assertTrue( wp_style_is( 'wordpress-slideshow-notification' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow-notification' ) );
	}
);

test(
	'script location added correctly',
	function () {
		assertSame( $this->screen_id, get_current_screen()->id );
		$styles = get_echo( 'wp_print_styles' );
		expect( $styles )
			->toBeString()
		->toContain( '/wp-content/plugins/wordpress-slideshow/assets/admin.css' );
		$scripts = get_echo( 'wp_print_scripts' );
		expect( $scripts )
			->toBeString()
			->toContain( '/wp-content/plugins/wordpress-slideshow/assets/admin.js' );
	}
);

test(
	'slides meta box rendered correctly',
	function () {
		$slides = get_echo( 'do_meta_boxes', array( $this->screen_id, 'normal', null ) );
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
	'upload form meta box rendered correctly',
	function () {
		$upload_form = get_echo( 'do_meta_boxes', array( $this->screen_id, 'side', null ) );
		assertStringContainsString( 'Upload', $upload_form );
	}
);
