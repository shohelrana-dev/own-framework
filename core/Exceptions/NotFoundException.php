<?php

namespace Core\Exceptions;

class NotFoundException extends \Exception {
	protected $code    = 404;
	protected $message = 'The page you are looking is not found';
}
