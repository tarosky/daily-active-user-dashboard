<?php

namespace Tarosky\Dashboard\DAU\Pattern;


/**
 * Application base.
 *
 * @package dau
 * @property string $version
 * @property string $root_dir
 * @property string $root_url
 * @property \wpdb  $db
 */
abstract class AppBase extends Singleton {

	/**
	 * Getter
	 *
	 * @param string $name
	 */
	public function __get( $name ) {
		switch ( $name ) {
			case 'version':
				return dau_version();
				break;
			case 'root_dir':
				return dirname( dirname( dirname( dirname( dirname( __DIR__ ) ) ) ) );
				break;
			case 'root_url':
				return untrailingslashit( plugin_dir_url( $this->root_dir . '/asset' ) );
				break;
			case 'db':
				global $wpdb;
				return $wpdb;
				break;
		}
	}
}
