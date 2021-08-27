<?php

namespace Core\Middleware;

abstract class Middleware {
	public array $actions = [];

	public function __construct( array $actions = [] ) {
		$this->actions = $actions;
	}

	abstract public function execute();
}