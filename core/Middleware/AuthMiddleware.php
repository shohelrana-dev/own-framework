<?php

namespace Core\Middleware;

/**
 * Class AuthMiddleware
 * @package Core\Middleware
 */
class AuthMiddleware extends Middleware
{

	/**
	 * execute the middleware
	 *
	 * @return mixed|void
	 */
	public function execute()
	{
		if ( isGuest() && ( empty( $this->actions ) || in_array( app()->controller()->action, $this->actions ) ) ) {
			redirect( '/auth/login' );
		}
	}
}
