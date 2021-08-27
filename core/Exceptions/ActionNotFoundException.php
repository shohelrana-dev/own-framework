<?php

namespace Core\Exceptions;

class ActionNotFoundException extends \Exception {
	protected $code    = 404;
	protected $message = 'The action is not found on the controller';
}
