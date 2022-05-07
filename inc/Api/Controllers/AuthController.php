<?php
/**
 * Auth Controller.
 *
 * @package Avia_Jwt_Auth
 */

namespace Avia\Api\Controllers;

use Avia\Helpers\JWT;

/**
 * Class AuthController
 */
class AuthController {

	/**
	 * Authenticate user.
	 *
	 * @param \WP_REST_Request $request Request.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function login( \WP_REST_Request $request ) {

		if ( empty( $request->get_param( 'username' ) ) || empty( $request->get_param( 'password' ) ) ) {
			return new \WP_Error(
				'required_params',
				esc_html__( 'Usuário e senha são obrigatórios!', 'avia-jwt-auth' ),
				array( 'status' => 401 )
			);
		}

		$user = wp_authenticate(
			$request->get_param( 'username' ),
			$request->get_param( 'password' )
		);

		if ( is_wp_error( $user ) ) {
			return new \WP_Error(
				'authentication_failed',
				esc_html__( 'Usuário ou senhas inválidos!', 'avia-auth' ),
				array( 'status' => 401 )
			);
		}

		$data = JWT::generate( $user );

		return new \WP_REST_Response( $data, 200 );
	}
}
