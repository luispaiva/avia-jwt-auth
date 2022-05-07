<?php

namespace Avia\Api\Routes;

/**
 * Classe Routes
 */
class Routes {

	/**
	 * Inicialização da classe.
	 *
	 * @return void
	 */
	public function __construct() {
		new AuthRoute();
	}
}
