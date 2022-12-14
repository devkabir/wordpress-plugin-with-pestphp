<?php
/**
 * wordpress-slideshow.php
 *
 * @package    wpcs-devkabir
 * @subpackage wordpress-slideshow.php
 * @since      1.0.0
 */
/**
 * Plugin Name: WordPress Slideshow
 *  Requires PHP:      7.4
 *  Requires at least: 6.1.1
 *  Version:           1.0.0
 */
add_action( 'init', 'wordpress_slideshow_register_shortcode' );

function wordpress_slideshow_register_shortcode() {
	add_shortcode( 'myslideshow', 'wordpress-slideshow-shortcode' );
}
