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
		$this->assertNotFalse( has_action( 'init', 'wordpress_slideshow_register_shortcode' ) );
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
