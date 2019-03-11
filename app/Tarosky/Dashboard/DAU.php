<?php

namespace Tarosky\Dashboard;


use Tarosky\Dashboard\DAU\Pattern\AppBase;

class DAU extends AppBase {

	/**
	 * Constructor.
	 */
	protected function init() {
		$this->autoload();
	}

	/**
	 * Autoload registered hooks.
	 */
	protected function autoload() {
		// Autoscan and activate.
		foreach ( [ 'Hooks' ] as $dir ) {
			$dir = __DIR__ . '/DAU/' . $dir;
			if ( ! is_dir( $dir ) ) {
				continue;
			}
			// Scan all files.
			foreach ( scandir( $dir ) as $file ) {
				if ( ! preg_match( '#^(.*)\.php$#u', $file, $match ) ) {
					continue;
				}
				$class_name = sprintf( 'Tarosky\\Dashboard\\DAU\\Hooks\\%s', $match[1] );
				if ( class_exists( $class_name ) && is_callable( [ $class_name, 'get_instance' ] ) ) {
					call_user_func( [ $class_name, 'get_instance' ] );
				}
			}
		}

	}


}
