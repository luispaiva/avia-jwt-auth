<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Avia\Api\Controllers\AuthController;

/**
 * Class AuthControllerTest
 */
final class AuthControllerTest extends TestCase {

	/**
	 * Test login require params.
	 */
	public function testLoginRequireParams() {
		$request  = new \WP_REST_Request();
		$response = ( new AuthController() )->login( $request );

		$error_data    = $response->get_error_data();
		$error_code    = $response->get_error_code();
		$error_message = $response->get_error_message();

		$this->assertEquals( 401, $error_data['status'] );
		$this->assertEquals( 'required_params', $error_code );
		$this->assertEquals( 'Usuário e senha são obrigatórios!', $error_message );
	}

	/**
	 * Test login invalid.
	 */
	public function testLoginInvalidCredentials() {
		$request = new \WP_REST_Request();
		$request->set_param( 'username', 'luis.balduino' );
		$request->set_param( 'password', 'lorem' );
		$response = ( new AuthController() )->login( $request );

		$error_data    = $response->get_error_data();
		$error_code    = $response->get_error_code();
		$error_message = $response->get_error_message();

		$this->assertEquals( 401, $error_data['status'] );
		$this->assertEquals( 'authentication_failed', $error_code );
		$this->assertEquals( 'Usuário ou senhas inválidos!', $error_message );
	}

	/**
	 * Test login Success.
	 */
	public function testLoginAuthSuccess() {
		$request = new \WP_REST_Request();
		$request->set_param( 'username', 'luis.balduino' );
		$request->set_param( 'password', '123qwe' );

		$response = ( new AuthController() )->login( $request );
		$data     = $response->get_data();

		$this->assertTrue( isset( $data['token'] ) );
		$this->assertEquals( 200, $response->get_status() );
	}
}
