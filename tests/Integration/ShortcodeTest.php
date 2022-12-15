<?php

namespace Tests\Integration;

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
	'shortcode callback added to init hooks',
	function () {
		$this->assertNotFalse( has_action( 'init', array( \WP_Slideshow::get_instances(), 'add_shortcode' ) ) );
	}
);


test(
	'callback added shortcode',
	function () {
		global $shortcode_tags;
		expect( $shortcode_tags )
		->toBeArray()
		->toHaveKey( 'myslideshow' );
	}
);

test(
	'shortcode can render content',
	function () {
		$this->assertFalse( has_shortcode( 'hello', 'myslideshow' ) );
	}
);
