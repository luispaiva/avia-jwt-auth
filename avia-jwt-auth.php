<?php
/**
 * Plugin Name:     Avia - JWT Auth
 * Plugin URI:      https://github.com/luispaiva/avia-jwt-auth/
 * Description:     Plugin desenvolvido para autenticação de usuários utilizando JWT.
 * Author:          Luis Paiva
 * Author URI:      https://www.luispaiva.com.br/
 * Text Domain:     avia-auth
 * Domain Path:     /languages
 * Version:         0.0.1
 *
 * @package         Avia_Jwt_Auth
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! defined( 'AVIA_AUTH_FILE' ) ) {
	define( 'AVIA_AUTH_FILE', __FILE__ );
}

if ( ! defined( 'AVIA_AUTH_PATH' ) ) {
	define( 'AVIA_AUTH_PATH', plugin_dir_path( __FILE__ ) );
}

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

add_action( 'plugins_loaded', array( '\Avia\Init', 'init' ) );

register_activation_hook( __FILE__, array( \Avia\Setup\Setup::class, 'activation' ) );
register_deactivation_hook( __FILE__, array( \Avia\Setup\Setup::class, 'deactivation' ) );
register_uninstall_hook( __FILE__, array( \Avia\Setup\Setup::class, 'uninstall' ) );
