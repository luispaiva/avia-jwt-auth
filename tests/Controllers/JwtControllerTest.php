<?php
/**
 * JWT Test.
 *
 * @package Avia_Jwt_Auth
 */

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Avia\Api\Controllers\JWTController;

/**
 * Class JwtTest
 */
final class JWTControllerTest extends TestCase {

	/**
	 * Test login require params.
	 */
	public function testJwtGenerateFailure() {
		$jwt = new JWTController();

		$this->assertFalse( $jwt::generate( null ) );
	}

	/**
	 * Test login require params.
	 */
	public function testJwtGenerateSuccess() {
		$user = new \WP_User( 1 );
		$jwt  = new JWTController();

		$this->assertIsArray( $jwt::generate( $user ) );
	}
}
