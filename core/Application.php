<?php


namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\Router\Route;

/**
 * The main class of framework
 *
 * @property Request $request
 * @property Response $response
 * @property Session $session
 * @property Route $route
 *
 * @package Core\Bootstrap
 */
final class Application
{
	/**
	 * Hold class objects
	 *
	 * @var array
	 */
	private array $container = [];

	/**
	 * Put instance of the class
	 *
	 * @var Application $app
	 */
	public static Application $app;

	/**
	 * Application constructor.
	 */
	public function __construct()
	{
		$this->debugMode();
		$this->constants();

		self::$app = $this;

		$this->container['request']  = new Request();
		$this->container['response'] = new Response();
		$this->container['session']  = new Session();
		$this->container['route']    = new Route( $this->request, $this->response );
	}

	/**
	 * Magic method to set property
	 *
	 * @param $name
	 *
	 * @param $value
	 */
	public function __set( $name, $value )
	{
		$this->container[ $name ] = $value;
	}

	/**
	 *  Magic method to get property
	 *
	 * @param $name
	 * @return mixed
	 */
	public function __get( $name )
	{
		if ( array_key_exists( $name, $this->container ) ) {
			return $this->container[ $name ];
		}
	}

	/**
	 * Check the application debug mode
	 *
	 * @return void
	 */
	public function debugMode() : void
	{
		if ( defined( 'DEBUG' ) && DEBUG === true ) {
			ini_set( 'display_errors', 1 );
			ini_set( 'display_startup_errors', 1 );
			error_reporting( E_ALL );
		}
		else {
			ini_set( 'display_errors', 0 );
			ini_set( 'display_startup_errors', 0 );
			error_reporting( 0 );
		}
	}

	/**
	 * Define necessary constants
	 *
	 * @return void
	 */
	private function constants() : void
	{
		define( 'DS', DIRECTORY_SEPARATOR );
		define( 'ROOT_PATH', realpath( dirname( __DIR__ ) ) );
		define( 'VIEW_PATH', ROOT_PATH . DS . 'app' . DS . 'views' );
	}


	/**
	 * Register get method to route
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return Application
	 */
	public function get( $path, $callback ) : Application
	{
		$this->route->addRoute( $this->request::METHOD_GET, $path, $callback );

		return $this;
	}

	/**
	 * Register post method to route
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return Application
	 */
	public function post( $path, $callback ) : Application
	{
		$this->route->addRoute( $this->request::METHOD_POST, $path, $callback );

		return $this;
	}

	/**
	 * Register put method to route
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return Application
	 */
	public function put( $path, $callback ) : Application
	{
		$this->route->addRoute( $this->request::METHOD_PUT, $path, $callback );

		return $this;
	}

	/**
	 * Register patch method to route
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return Application
	 */
	public function patch( $path, $callback ) : Application
	{
		$this->route->addRoute( $this->request::METHOD_PATCH, $path, $callback );

		return $this;
	}

	/**
	 * Register delete method to route
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return Application
	 */
	public function delete( $path, $callback ) : Application
	{
		$this->route->addRoute( $this->request::METHOD_DELETE, $path, $callback );

		return $this;
	}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public function run()
	{
		try {
			echo $this->route->execute();
		} catch ( \Exception $e ) {
			echo $e->getCode() . ' ' . $e->getMessage();
		}
	}

	/**
	 * Check Authentication
	 *
	 * @return bool
	 */
	public function isAuth() : bool
	{
		if ( $this->session->has( 'user_logged_in' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check is guest
	 *
	 * @return bool
	 */
	public function isGuest() : bool
	{
		if ( $this->session->has( 'user_logged_in' ) ) {
			return false;
		}
		return true;
	}

	/**
	 * User log in
	 *
	 * @param int $userId
	 * @param string $userName
	 *
	 * @return bool
	 */
	public function login( int $userId, string $userName ) : bool
	{
		if ( ! $this->session->has( 'user_logged_in' ) || $this->session->has( 'logged_in_user_id' ) ) {
			$this->session->set( 'user_logged_in', true );
			$this->session->set( 'logged_in_user_id', $userId );
			$this->session->set( 'logged_in_user_name', $userName );
		}
		return true;
	}

	/**
	 * User log out
	 *
	 * @return bool
	 */
	public function logout() : bool
	{
		if ( $this->session->has( 'user_logged_in' ) ) {
			$this->session->remove( 'user_logged_in' );
			$this->session->destroy();
		}

		return $this->isGuest();
	}
}