<?php

// Autoload everything for unit tests.
$ds = DIRECTORY_SEPARATOR;
require_once dirname( __FILE__, 2 ) . $ds . 'vendor' . $ds . 'autoload.php';

/**
 * Include core bootstrap for an integration test suite
 *
 * This will only work if you run the tests from the command line.
 * Running the tests from IDE such as PhpStorm will require you to
 * add additional argument to the test run command if you want to run
 * integration tests.
 */
if ( ! file_exists( dirname( __FILE__, 2 ) . '/wp/tests/phpunit/wp-tests-config.php' ) ) {
	// We need to set up core config details and test details
	copy(
		dirname( __FILE__, 2 ) . '/wp/wp-tests-config-sample.php',
		dirname( __FILE__, 2 ) . '/wp/tests/phpunit/wp-tests-config.php'
	);

	// Change certain constants from the test's config file.
	$testConfigPath     = dirname( __FILE__, 2 ) . '/wp/tests/phpunit/wp-tests-config.php';
	$testConfigContents = file_get_contents( $testConfigPath );

	$testConfigContents = str_replace(
		"dirname( __FILE__ ) . '/src/'",
		"dirname(__FILE__, 3) . '/src/'",
		$testConfigContents
	);
	$testConfigContents = str_replace( 'youremptytestdbnamehere', $_SERVER['DB_NAME'], $testConfigContents );
	$testConfigContents = str_replace( 'yourusernamehere', $_SERVER['DB_USER'], $testConfigContents );
	$testConfigContents = str_replace( 'yourpasswordhere', $_SERVER['DB_PASSWORD'], $testConfigContents );
	$testConfigContents = str_replace( 'localhost', $_SERVER['DB_HOST'], $testConfigContents );

	file_put_contents( $testConfigPath, $testConfigContents );
}

// Give access to tests_add_filter() function.
require_once dirname( __FILE__, 2 ) . '/wp/tests/phpunit/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require_once 'D:\server\opensource\rtcamp\wp-content\plugins\wordpress-slideshow\wordpress-slideshow.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );
/**
 * Filter the plugins URL to pretend the plugin is installed in the test environment.
 *
 * @param string $url    The complete URL to the plugins directory including scheme and path.
 * @param string $path   Path relative to the URL to the plugins directory. Blank string
 *                       if no path is specified.
 * @param string $plugin The plugin file path to be relative to. Blank string if no plugin
 *                       is specified.
 *
 * @return string
 */
function _plugins_url( $url, $path, $plugin ) {
	$plugin_dir = dirname( dirname( __DIR__ ) );
	if ( $plugin === $plugin_dir . '/wordpress-slideshow.php' ) {
		$url = str_replace( dirname( $plugin_dir ), '', $url );
	}

	return $url;
}
// Overwrite the plugin URL to not include the full path.
tests_add_filter( 'plugins_url', '_plugins_url', 10, 3 );
require_once dirname( __FILE__, 2 ) . '/wp/tests/phpunit/includes/bootstrap.php';
