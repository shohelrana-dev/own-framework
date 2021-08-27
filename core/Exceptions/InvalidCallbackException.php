<?php

namespace Core\Exceptions;

class InvalidCallbackException extends \Exception {
	protected $message = 'The callback is invalid';
	protected $code    = 404;
}