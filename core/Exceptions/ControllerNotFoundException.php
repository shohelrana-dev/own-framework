<?php

namespace Core\Exceptions;

class ControllerNotFoundException extends \Exception {
	protected $code    = 404;
	protected $message = 'The controller is not found';
}
