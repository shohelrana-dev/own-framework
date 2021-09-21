<?php

namespace Core\Validation\Rules;

class Min implements RuleInterface
{
	private string $message = '{field} must be equal to or greater than {min} character.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		if ( strlen( $value ) >= $args['min'] ) {
			return true;
		}
		$this->message = str_replace( '{min}', $args['min'], $this->message );
		return false;
	}

	public function message() : string
	{
		return $this->message;
	}
}