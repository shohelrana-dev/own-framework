<?php

namespace Core\Middleware;

/**
 * Class Middleware
 *
 * @package Core\Middleware
 */
abstract class Middleware
{
	public array $actions = [];

	/**
	 * Middleware constructor.
	 *
	 * @param array $actions
	 */
	public function __construct( array $actions = [] )
	{
		$this->actions = $actions;
	}

	/**
	 * execute middleware
	 *
	 * @return mixed|void
	 */
	abstract public function execute();
}