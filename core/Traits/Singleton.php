<?php

namespace Core\Traits;

trait Singleton
{
	/**
	 * put classes instances
	 *
	 * @var array
	 */
	private static array $instance = [];

	/**
	 * Get the class instance
	 *
	 * @return object
	 */
	final static function getInstance()
	{
		$calledClass = get_called_class();

		if ( ! isset( static::$instance[ $calledClass ] ) ) {
			static::$instance[ $calledClass ] = new $calledClass;
		}

		return static::$instance[ $calledClass ];
	}
}
