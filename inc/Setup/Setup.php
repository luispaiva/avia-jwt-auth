<?php
/**
 * Initial Setup.
 *
 * @package Avia_Jwt_Auth
 */

namespace Avia\Setup;

/**
 * Class Setup
 */
class Setup {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ) );
	}

	/**
	 * Load plugin textdomain.
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain(
			'avia-auth',
			false,
			dirname( plugin_basename( AVIA_AUTH_FILE ) ) . '/languages/'
		);
	}

	/**
	 * Activation the plugin
	 *
	 * @return void
	 */
	public static function activation() {
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 *
	 * @return void
	 */
	public static function deactivation() {
		flush_rewrite_rules();
	}

	/**
	 * Uninstall the plugin.
	 *
	 * @return void
	 */
	public static function uninstall() {
		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			die;
		}
	}
}
