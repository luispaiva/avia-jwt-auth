<?php

namespace Avia\Api\Routes;

use Avia\Api\Controllers\AuthController;

/**
 * Class AuthRoute
 */
class AuthRoute {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			'auth',
			'/login',
			array(
				'methods'  => \WP_REST_Server::CREATABLE,
				'callback' => function ( \WP_REST_Request $request ) {
					return ( new AuthController() )->login( $request );
				},
				'args'     => array(
					'username' => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'password' => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			)
		);
	}
}
