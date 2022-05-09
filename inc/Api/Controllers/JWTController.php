<?php
/**
 * JWT Helper.
 *
 * @package Avia_Jwt_Auth
 */

namespace Avia\Api\Controllers;

use \Firebase\JWT\JWT as FbJWT;
use \Firebase\JWT\Key;

/**
 * Class JWTController
 */
class JWTController {

	/**
	 * Secret key.
	 *
	 * @var string
	 */
	private static $secret_key = 'M9:9&!v+UzXFai+]68J_[U$lQ|2zO_97G|?pFv+YLeD@h&4~#4AuFB8u,GC;0OQt';

	/**
	 * Constructor.
	 *
	 * @param string|null $secret_key Secret key.
	 */
	public function __construct( ?string $secret_key = null ) {
		self::$secret_key = $secret_key ?? self::$secret_key;
	}

	/**
	 * Generate token.
	 *
	 * @param \WP_User $user User.
	 *
	 * @return bool|array
	 */
	public static function generate( $user ) {

		if ( ! $user instanceof \WP_User ) {
			return false;
		}

		$issued_at  = time();
		$not_before = apply_filters( 'jwt_auth_not_before', $issued_at, $issued_at );
		$expire     = apply_filters( 'jwt_auth_token_expire', $issued_at + ( DAY_IN_SECONDS * 7 ) );

		$token = array(
			'iss'  => get_bloginfo( 'url' ),
			'iat'  => $issued_at,
			'nbf'  => $not_before,
			'exp'  => $expire,
			'data' => array(
				'user' => array(
					'id' => $user->data->ID,
				),
			),
		);

		$token = FbJWT::encode( $token, self::$secret_key );

		$data = array(
			'token'           => $token,
			'user_name'       => $user->data->display_name,
			'user_email'      => $user->data->user_email,
			'user_registered' => $user->data->user_registered,
		);

		return apply_filters( 'jwt_auth_token_before_dispatch', $data, $user );
	}

	/**
	 * Validate token.
	 *
	 * @param string $token Token.
	 */
	public static function validate( string $token ) {
		try {
			return FbJWT::decode( $token, new Key( self::$secret_key, 'HS256' ) );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'rest_auth_invalid_token', $e->getMessage(), array( 'status' => 403 ) );
		}
	}
}
