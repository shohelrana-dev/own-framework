<?php

namespace Core\Middleware;

class AuthMiddleware extends Middleware
{

	public function execute()
	{
		if ( isGuest() && ( empty( $this->actions ) || in_array( app()->controller()->action, $this->actions ) ) ) {
			redirect( '/auth/login' );
		}
	}
}
