<?php

namespace Core\Validation\Rules;

class Required implements RuleInterface
{
	private string $message = '{field} is required.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		return ! empty( $value );
	}

	public function message() : string
	{
		return $this->message;
	}
}