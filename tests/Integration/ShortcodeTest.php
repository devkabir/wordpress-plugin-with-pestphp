<?php

namespace Tests\Integration;


beforeEach(
	function () {
		parent::setUp();
		\WP_Slideshow::get_instances();
	}
);

afterEach(
	function () {
		global $shortcode_tags;
		unset( $shortcode_tags['myslideshow'] );
		parent::tearDown();
	}
);


test(
	'shortcode callback added to init hooks',
	function () {
		$instances = \WP_Slideshow::get_instances();
		$this->assertNotFalse( has_action( 'init', array( $instances, 'add_shortcode' ) ) );
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
		$output = do_shortcode( '[myslideshow]' );
		expect( $output )
			->toBeString()
			->toEqual( 'hello' );
	}
);
