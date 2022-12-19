<?php

namespace Tests\Integration;

use WP_Slideshow_Shortcode;

require_once __DIR__ . '/../../includes/class-wp-slideshow-shortcode.php';
beforeEach(
	function () {
		parent::setUp();
		WP_Slideshow_Shortcode::get_instances();
		do_action( 'init' );
		set_current_screen( 'front' );
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
		$this->assertNotFalse( has_action( 'init', array( WP_Slideshow_Shortcode::get_instances(), 'add' ) ) );
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
			->toContain( 'swiffy-slider' );
	}
);
