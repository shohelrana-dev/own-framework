<?php

namespace Core\Validation\Rules;

class Confirm implements RuleInterface
{
	private string $message = '{field} should be same as {confirm_field}.';

	public function validate( string $field, string $value, $args = [] ) : bool
	{
		$confirmField = $args['confirm'];
		$confirmValue = $args['data'][ $confirmField ];
		if ( $value === $confirmValue ) {
			return true;
		}
		$this->message = str_replace( '{confirm_field}', $confirmField, $this->message );
		return false;
	}

	public function message() : string
	{
		return $this->message;
	}
}