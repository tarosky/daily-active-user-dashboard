<?php
namespace Tarosky\Dashboard\DAU\Pattern;


/**
 * Singleton pattern.
 *
 * @package adu
 */
abstract class Singleton {

	/**
	 * @var static[] Instance of this subclass.
	 */
	private static $instances = [];

	/**
	 * Singleton constructor.
	 */
	final private function __construct() {
		$this->init();
	}

	/**
	 * Initialize class.
	 */
	protected function init() {}


	/**
	 * Get instance.
	 *
	 * @return static
	 */
	public static function get_instance() {
		$class_name = get_called_class();
		if ( ! isset( self::$instances[ $class_name ] ) ) {
			self::$instances[ $class_name ] = new $class_name();
		}
		return self::$instances[ $class_name ];
	}
}
