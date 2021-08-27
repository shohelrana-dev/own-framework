<?php

namespace Core\Support;

use Core\Traits\Singleton;

/**
 * Class ErrorBag
 *
 * @package Core\Support
 */
class ErrorBag
{
	use Singleton;

	/**
	 * hold errors
	 *
	 * @var array
	 */
	private array $errors = [];

	/**
	 * Check has any error
	 *
	 * @return bool
	 */
	public function any() : bool
	{
		return ! empty( $this->errors );
	}

	/**
	 * Add error
	 *
	 * @param string $field
	 * @param string $message
	 *
	 * @return void
	 */
	public function addError( string $field, string $message ) : void
	{
		$this->errors[ $field ] = $message;
	}

	/**
	 * set errors
	 *
	 * @param array $errors
	 *
	 * @return void
	 */
	public function setErrors( array $errors = [] ) : void
	{
		$this->errors = $errors;
	}

	/**
	 * Check has error by key
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function has( string $name ) : bool
	{
		return isset( $this->errors[ $name ] );
	}

	/**
	 * get error by key
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function get( string $name ) : string
	{
		return $this->has( $name ) ? $this->errors[ $name ] : '';
	}

	/**
	 * get all error
	 *
	 * @return array
	 */
	public function all() : array
	{
		return $this->errors;
	}
}
