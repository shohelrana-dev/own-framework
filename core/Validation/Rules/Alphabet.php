<?php

namespace Core\Validation\Rules;

class Alphabet implements RuleInterface
{
	private string $message = '{field} should be valid Alphabet.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		return preg_match( '~^([a-zA-Z\s])+$~', $value );
	}

	public function message() : string
	{
		return $this->message;
	}
}