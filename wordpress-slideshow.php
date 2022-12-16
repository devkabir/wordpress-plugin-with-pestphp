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
	require_once plugin_dir_path( __FILE__ ) . '/includes/trait-wp-slideshow-singleton.php';
}

/* Checking if the class WP_Slideshow_Assets exists and if it doesn't, it is including it. */
if ( ! class_exists( 'WP_Slideshow_Assets' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-slideshow-assets.php';
}
WP_Slideshow_Assets::get_instances();

/* Checking if the user is in the admin area and if it is,
it is including the class WP_Slideshow_Settings.
If the user is not in the admin area,
it is including the class WP_Slideshow. */
if ( is_admin() ) {
	/* Checking if the class WP_Slideshow_Settings exists and if it doesn't, it is including it. */
	if ( ! class_exists( 'WP_Slideshow_Settings' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-slideshow-settings.php';
	}
	WP_Slideshow_Settings::get_instances();
} else {
	/* Checking if WP_Slideshow exists and if it doesn't, it is creating it. */
	if ( ! class_exists( 'WP_Slideshow' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-slideshow.php';
	}
	WP_Slideshow::get_instances();
}
