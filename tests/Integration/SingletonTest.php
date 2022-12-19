<?php

namespace Tests\Integration;

use WP_Slideshow_Shortcode;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

require_once __DIR__ . '/../../includes/class-wp-slideshow-shortcode.php';
beforeEach(
	function () {
		parent::setUp();
	}
);

afterEach(
	function () {
		parent::tearDown();
	}
);


test(
	'signleton trait should return same instance',
	function () {
		$wp_slideshow1 = WP_Slideshow_Shortcode::get_instances();
		$wp_slideshow2 = WP_Slideshow_Shortcode::get_instances();
		assertInstanceOf( 'WP_Slideshow_Shortcode', $wp_slideshow1 );
		assertInstanceOf( 'WP_Slideshow_Shortcode', $wp_slideshow2 );
		assertSame( $wp_slideshow1, $wp_slideshow2 );
	}
);
