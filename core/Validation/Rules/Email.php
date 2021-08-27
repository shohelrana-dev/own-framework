<?php

namespace Core\Validation\Rules;

class Email implements RuleInterface
{
	private string $message = '{field} should be valid email.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		return filter_var( $value, FILTER_VALIDATE_EMAIL );
	}

	public function message() : string
	{
		return $this->message;
	}
}