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
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;


beforeEach(
	function () {
		parent::setUp();
		set_current_screen( 'admin' );
		wp_set_current_user( 1 );
		update_option( 'siteurl', 'http://example.com' );
		$this->plugin = 'wordpress-slideshow/wordpress-slideshow.php';
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
	'Current screen is admin',
	function () {
		assertTrue( is_admin() );
	}
);

test(
	'temp site url set',
	function () {
		$siteurl = get_option( 'siteurl' );
		expect( $siteurl )
			->toBeString()
			->toEqual( 'http://example.com' );
	}
);

test(
	'plugin is not available',
	function () {
		$this->assertSame( array(), validate_active_plugins() );
	}
);

test(
	'make plugin available',
	function () {
		activate_plugin( $this->plugin );
		$this->assertTrue( is_plugin_active( $this->plugin ) );
	}
);


test(
	'admin get access to settings',
	function () {
		assertTrue( current_user_can( 'manage_options' ) );
		assertTrue( is_plugin_active( $this->plugin ) );
		assertNotFalse( has_action( 'admin_menu', array( WP_Slideshow_Settings::get_instances(), 'menu' ) ) );
		WP_Slideshow_Settings::get_instances()->menu();
		$expected = 'http://example.com/wp-admin/admin.php?page=wordpress-slideshow-plugin';
		assertSame( $expected, menu_page_url( 'wordpress-slideshow-plugin', false ) );
	}
);


