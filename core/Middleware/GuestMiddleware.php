<?php

namespace Core\Middleware;

/**
 * Class GuestMiddleware
 *
 * @package Core\Middleware
 */
class GuestMiddleware extends Middleware
{
	/**
	 * execute the middleware
	 *
	 * @return mixed|void
	 */
	public function execute()
	{
		if ( isAuth() && ( empty( $this->actions ) || in_array( app()->controller->action, $this->actions ) ) ) {
			redirect( '/' );
		}
	}
}
