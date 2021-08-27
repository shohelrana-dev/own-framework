<?php

namespace Core\Router;

use Core\Controller\Controller;
use Core\Exceptions\ActionNotFoundException;
use Core\Exceptions\ControllerNotFoundException;
use Core\Exceptions\InvalidCallbackException;
use Core\Exceptions\NotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\Middleware;

/**
 * Class Route
 *
 * @package Core\Router
 */
class Route
{

	/**
	 * Put registered routes
	 *
	 * @var array
	 */
	private array $routes = [];

	/**
	 * Put instance of Request class
	 *
	 * @var Request
	 */
	private Request $request;

	/**
	 * Put instance of Response class
	 *
	 * @var Response
	 */
	private Response $response;

	/**
	 * 404 template file
	 *
	 * @var string
	 */
	private string $template404 = VIEW_PATH . DS . '404.php';

	/**
	 * Route constructor.
	 *
	 * @param Request $request
	 * @param Response $response
	 */
	public function __construct( Request $request, Response $response )
	{
		$this->request  = $request;
		$this->response = $response;
	}

	/**
	 * Add route
	 *
	 * @param $requestMethod
	 * @param $routePath
	 * @param $callback
	 *
	 * @return void
	 */
	public function addRoute( string $requestMethod, string $routePath, $callback ) : void
	{

		//Check if parameters route
		if ( $this->isParamsRoute( $routePath ) ) {
			$routePath = preg_replace( "~{\w+}~", '(.*)', $routePath );
		}

		switch ( $requestMethod ) {
			case $this->request::METHOD_GET:
				$this->routes[ $this->request::METHOD_GET ][ $routePath ] = $callback;
				break;

			case $this->request::METHOD_POST:
				$this->routes[ $this->request::METHOD_POST ][ $routePath ] = $callback;
				break;

			case $this->request::METHOD_PUT:
				$this->routes[ $this->request::METHOD_PUT ][ $routePath ] = $callback;
				break;

			case $this->request::METHOD_PATCH:
				$this->routes[ $this->request::METHOD_PATCH ][ $routePath ] = $callback;
				break;

			case $this->request::METHOD_DELETE:
				$this->routes[ $this->request::METHOD_DELETE ][ $routePath ] = $callback;
				break;

			default:
				$this->response->setStatusCode( 404 );

				if ( file_exists( $this->template404 ) ) {
					include_once $this->template404;
				}
		}
	}

	/**
	 * Resolve the request
	 *
	 * @return mixed
	 * @throws NotFoundException
	 * @throws \Exception
	 */
	public function execute()
	{

		if ( $this->matches() === false ) {
			$this->response->setStatusCode( 404 );
			throw new NotFoundException();
		}

		$callback = $this->matches()['callback'];
		$params   = $this->matches()['params'];

		//If callback is class
		if ( is_array( $callback ) ) {
			if ( class_exists( $callback[0] ) ) {
				if ( method_exists( $callback[0], $callback[1] ) ) {
					/**
					 * @var Controller $controller
					 * @var Middleware $middleware
					 */
					$controller = new $callback[0]();
					$action     = $callback[1];

					app()->setController( $controller );

					$controller->action = $action;

					foreach ( app()->controller()->getMiddlewares() as $middleware ) {
						$middleware->execute();
					}

					$responseBody = $controller->$action( ...[ ...$params, $this->request ] );
				}
				else {
					throw new ActionNotFoundException();
				}
			}
			else {
				throw new ControllerNotFoundException();
			}
		}
		//If callback is function
		elseif ( is_callable( $callback ) ) {
			$responseBody = call_user_func_array( $callback, [ ...$params, $this->request, $this->response ] );
		}
		else {
			throw new InvalidCallbackException();
		}


		//Return Output
		if ( is_string( $responseBody ) ) {
			return $responseBody;
		}
		elseif ( is_array( $responseBody ) || is_object( $responseBody ) ) {
			return $this->response->json( $responseBody );
		}
	}

	/**
	 * Check Route Match and return matches
	 *
	 * @return array|bool
	 */
	private function matches()
	{

		$routePaths = array_keys( $this->routes[ $this->request->method() ] );

		foreach ( $routePaths as $routePath ) {

			if ( preg_match( "~^$routePath/?$~", $this->request->path(), $matches ) ) {
				$params   = array_slice( $matches, 1 );
				$callback = $this->routes[ $this->request->method() ][ $routePath ] ?? null;

				return [
					'callback' => $callback,
					'params'   => $params
				];

			}

		}

		return false;
	}

	/**
	 * Check Params Route
	 *
	 * @param $routePath
	 *
	 * @return bool
	 */
	private function isParamsRoute( string $routePath ) : bool
	{
		return preg_match( "~/.*\{.*}~", $routePath );
	}
}