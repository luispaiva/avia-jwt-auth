<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;
use Avia\Helpers\JWT;

/**
 * Class JwtTest
 */
final class JwtTest extends TestCase {

	/**
	 * Test login require params.
	 */
	public function testJwtGenerateFailure() {
		$jwt = new JWT();

		$this->assertFalse( $jwt::generate( null ) );
	}

	/**
	 * Test login require params.
	 */
	public function testJwtGenerateSuccess() {
		$user = new \WP_User( 1 );
		$jwt  = new JWT();

		$this->assertIsArray( $jwt::generate( $user ) );
	}
}
