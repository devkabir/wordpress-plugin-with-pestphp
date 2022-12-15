<?php
/**
 * This is plugin bootstrap file.
 *
 * @package    WP_Slideshow
 * @since      1.0.0
 */
/**
 *  Plugin Name: WordPress Slideshow
 *  Requires PHP:      7.4
 *  Requires at least: 5.4
 *  Version:           1.0.0
 *
 * @package    WP_Slideshow
 */

/* A security measure to prevent direct access to the plugin file. */
if ( ! defined( 'WPINC' ) ) {
	die;
}


/* Checking if WP_Slideshow_Singleton exists and if it doesn't, it is including it. */
if ( ! trait_exists( 'WP_Slideshow_Singleton' ) ) {
	require_once __DIR__ . '/trait-wp-slideshow-singleton.php';
}


/* Checking if WP_Slideshow exists and if it doesn't, it is creating it. */
if ( ! class_exists( 'WP_Slideshow' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-wp-slideshow.php';
}
WP_Slideshow::get_instances();
