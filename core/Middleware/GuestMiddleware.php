<?php

namespace Core\Middleware;

class GuestMiddleware extends Middleware
{

	public function execute()
	{
		if ( isAuth() && ( empty( $this->actions ) || in_array( app()->controller()->action, $this->actions ) ) ) {
			redirect( '/' );
		}
	}
}
