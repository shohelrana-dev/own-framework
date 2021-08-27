<?php

namespace Core\Traits;

use Core\Controller\Controller;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;

trait SingletonClasses
{


	/**
	 * Put instance of Request class
	 *
	 * @var Request $request
	 */
	private Request $request;

	/**
	 * Put instance of Response class
	 *
	 * @var Response $response
	 */
	private Response $response;

	/**
	 * Put instance of Response class
	 *
	 * @var Session $session
	 */
	private Session $session;

	/**
	 * Put instance of Response class
	 *
	 * @var Controller $controller
	 */
	private Controller $controller;

	/**
	 * @return Request
	 */
	public function request() : Request
	{
		return $this->request;
	}

	/**
	 * @return Response
	 */
	public function response() : Response
	{
		return $this->response;
	}

	/**
	 * @return Session
	 */
	public function session() : Session
	{
		return $this->session;
	}

	/**
	 * @return Controller
	 */
	public function controller() : Controller
	{
		return $this->controller;
	}

	/**
	 * Put Controller class instance
	 *
	 * @param Controller $controller
	 *
	 * @return void
	 */
	public function setController( Controller $controller ) : void
	{
		$this->controller = $controller;
	}
}