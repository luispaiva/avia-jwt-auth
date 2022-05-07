<?php
/**
 * Apply Hooks.
 *
 * @package Avia_Jwt_Auth
 */

namespace Avia\Hooks;

use Avia\Helpers\JWT;

/**
 * Classe Hooks
 */
class Hooks {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'rest_pre_dispatch', array( $this, 'rest_pre_dispatch' ), 10, 3 );
	}

	/**
	 * Filter rest_pre_dispatch.
	 *
	 * @param mixed            $result Anything.
	 * @param \WP_REST_Server  $server Server instance.
	 * @param \WP_REST_Request $request Request used to generate the response.
	 *
	 * @return \WP_REST_Server
	 */
	public function rest_pre_dispatch( $result, \WP_REST_Server $server, \WP_REST_Request $request ) {

		if ( false === str_contains( $request->get_route(), 'auth' ) ) {
			list($token) = sscanf( $request->get_header( 'authorization' ), 'Bearer %s' );

			if ( ! $token ) {
				return new \WP_Error(
					'rest_forbidden',
					esc_html__( 'Sem permissão para fazer isso.', 'avia-jwt-auth' ),
					array(
						'status' => 403,
					)
				);
			}

			$jwt = JWT::validate( $token );

			if ( is_wp_error( $jwt ) ) {
				return new \WP_Error(
					$jwt->get_error_code(),
					$jwt->get_error_message(),
					array( 'status' => 401 )
				);
			}

			wp_set_current_user( $jwt->data->user->id );
		}
	}
}
