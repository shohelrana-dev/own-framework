<?php

namespace Core\Validation\Rules;

class Number implements RuleInterface
{
	private string $message = '{field} should be number.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		return is_numeric( $value );
	}

	public function message() : string
	{
		return $this->message;
	}
}