<?php
/**
 * Assets Test
 *
 * @package    WP_Slideshow
 * @subpackage AssetsTest
 * @since      1.0.0
 */

namespace Tests\Integration;

use WP_Slideshow_Assets;
use function Brain\Monkey\Actions\did;
use function Brain\Monkey\Actions\has;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

require_once __DIR__ . '/../../includes/class-wp-slideshow-assets.php';
beforeEach(
	function () {
		parent::setUp();
		WP_Slideshow_Assets::get_instances();
	}
);

afterEach(
	function () {
		set_current_screen( 'front' );
		parent::tearDown();
	}
);

test(
	'assets class registered admin scripts',
	function () {
		set_current_screen( 'admin' );
		do_action( 'admin_enqueue_scripts' );
		assertTrue( wp_style_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_style_is( 'wordpress-slideshow-notification', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow-notification', 'registered' ) );
	}
);

test(
	'assets class registered web scripts',
	function () {
		do_action( 'wp_enqueue_scripts' );
		assertTrue( wp_style_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow', 'registered' ) );
	}
);
