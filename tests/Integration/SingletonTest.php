<?php

namespace Tests\Integration;

use WP_Slideshow;
use function PHPUnit\Framework\assertInstanceOf;

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
		$wp_slideshow1 = WP_Slideshow::get_instances();
		$wp_slideshow2 = WP_Slideshow::get_instances();
		$this->assertInstanceOf( 'WP_Slideshow', $wp_slideshow1 );
		$this->assertInstanceOf( 'WP_Slideshow', $wp_slideshow2 );
		$this->assertSame( $wp_slideshow1, $wp_slideshow2 );
	}
);
