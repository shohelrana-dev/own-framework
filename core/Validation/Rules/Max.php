<?php

namespace Core\Validation\Rules;

class Max implements RuleInterface
{
	private string $message = '{field} must be equal to or less than {max} character.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		if ( strlen( $value ) <= $args['max'] ) {
			return true;
		}
		$this->message = str_replace( '{max}', $args['max'], $this->message );
		return false;
	}

	public function message() : string
	{
		return $this->message;
	}
}