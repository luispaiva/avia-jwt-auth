<?php
/**
 * Main class.
 *
 * @package Avia_Jwt_Auth
 */

namespace Avia;

use Avia\Hooks\Hooks;
use Avia\Api\Routes\Routes;

/**
 * Classe Init
 */
class Init {

	/**
	 * Inicialização da classe.
	 *
	 * @return void
	 */
	public static function init() {
		new Hooks();
		new Routes();
	}
}
