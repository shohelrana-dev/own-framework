<?php

namespace Core\Traits;

trait Singleton {
	/**
	 * put classes instance
	 *
	 * @var array
	 */
	private static array $instance = [];

	/**
	 * Get the class instance
	 *
	 * @return object
	 */
	final static function getInstance () {
		$called_class = get_called_class();

		if ( ! isset( static::$instance[ $called_class ] ) ) {
			static::$instance[ $called_class ] = new $called_class;
		}

		return static::$instance[ $called_class ];
	}
}
