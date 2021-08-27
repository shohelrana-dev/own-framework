<?php

namespace Core\Validation\Rules;

interface RuleInterface
{
	public function validate( string $field, string $value, $args = [] ) : bool;

	public function message() : string;
}
