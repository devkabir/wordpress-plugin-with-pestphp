<?php
/**
 * This trait will ensures that a class has only one instance and provides a global point to access it. It ensures that
 * only one object is available all across this plugin in a controlled state.
 *
 * @package    WP_Slideshow
 * @subpackage Trait\Singleton
 * @since      1.0.0
 */

/**
 * Trait Singleton
 *
 * @package WP_Slideshow
 */
trait WP_Slideshow_Singleton {


	/**
	 * Holder for all instances of Singleton
	 *
	 * @since 1.0.0
	 */
	protected static $instances = null;

	/**
	 * To return new or existing Singleton instance of the class from which it is called.
	 * As it sets to final it can't be overridden.
	 *
	 * @since 1.0.0
	 */
	final public static function get_instances() {

		/**
		 * Returns name of the class the static method is called in.
		 */
		$called_class = static::class;
		$arguments    = func_get_args();

		if ( ! isset( static::$instances ) ) {

			static::$instances = new $called_class( ...$arguments );

		}

		return static::$instances;

	}

	/**
	 * Final clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	final public function __clone() {
		// Serializing instances of this class is forbidden.
	}

	/**
	 * Final wakeup method to prevent serializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	final public function __wakeup() {
		// Serializing instances of this class is forbidden.
	}

}
