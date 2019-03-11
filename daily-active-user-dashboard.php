<?php
/**
 * Plugin Name: Facebook Customer Chat on WP
 * Plugin URI: https://wordpress.org/plugin/fbchat-on-wp
 * Description: Record daily active user and display status.
 * Author: TAROSKY INC
 * Version: 0.1.0
 * Author URI: https://tarosky.co.jp
 * Text Domain: dau
 * Domain Path: /languages/
 *
 * @package dau
 */

defined( 'ABSPATH' ) || die( 'Do not load directly' );


/**
 * Get plugin version.
 *
 * @return string
 */
function dau_version() {
	static $info = null;
	if ( is_null( $info ) ) {
		$info = get_file_data( __FILE__, [
			'version' => 'Version',
		] );
	}
	return $info['version'];
}

/**
 * Activate plugin
 */
function dau_init() {
	load_plugin_textdomain( 'dau', false, basename( __DIR__ ) . '/languages' );
	require __DIR__ . '/vendor/autoload.php';
	call_user_func( [ 'Tarosky\\Dashboard\\DAU', 'get_instance' ] );

}
add_action( 'plugins_loaded', 'dau_init' );
