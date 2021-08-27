<?php

namespace Core\Support;

use Core\Traits\Singleton;

class ErrorBag
{
	use Singleton;

	private array $errors = [];

	public function any()
	{
		return ! empty( $this->errors );
	}

	public function addError( string $field, string $message )
	{
		$this->errors[ $field ] = $message;
	}

	public function setErrors( array $errors = [] ) : void
	{
		$this->errors = $errors;
	}

	public function has( string $name )
	{
		return isset( $this->errors[ $name ] );
	}

	public function get( string $name )
	{
		return $this->has( $name ) ? $this->errors[ $name ] : '';
	}

	public function all()
	{
		return $this->errors;
	}
}
