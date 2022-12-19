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
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

require_once __DIR__ . '/../../includes/class-wp-slideshow-assets.php';
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
	'assets class registered admin scripts',
	function () {
		WP_Slideshow_Assets::get_instances()->admin();
		assertTrue( wp_style_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_style_is( 'wordpress-slideshow-notification', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow-notification', 'registered' ) );
	}
);

test(
	'assets class registered web scripts',
	function () {
		WP_Slideshow_Assets::get_instances()->web();
		assertTrue( wp_style_is( 'wordpress-slideshow', 'registered' ) );
		assertTrue( wp_script_is( 'wordpress-slideshow', 'registered' ) );
	}
);
