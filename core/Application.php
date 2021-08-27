<?php


namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\Router\Route;
use Core\Traits\SingletonClasses;

/**
 * The main class of framework
 *
 * @package Core\Bootstrap
 */
final class Application
{
	use SingletonClasses;

	/**
	 * Put instance of the class
	 *
	 * @var Application $app
	 */
	public static Application $app;

	/**
	 * Put instance of Route class
	 *
	 * @var Route $route
	 */
	private Route $route;

	/**
	 * Application constructor.
	 */
	public function __construct()
	{
		$this->checkDebugMode();
		$this->defineConstants();

		self::$app = $this;

		$this->request  = new Request();
		$this->response = new Response();
		$this->session  = new Session();

		$this->session()->start();

		$this->route = new Route( $this->request, $this->response );
	}

	/**
	 * Check the application debug mode
	 *
	 * @return void
	 */
	public function checkDebugMode() : void
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
	private function defineConstants() : void
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
		if ( $this->session()->has( 'user_logged_in' ) ) {
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
		if ( $this->session()->has( 'user_logged_in' ) ) {
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
		if ( ! session_has( 'user_logged_in' ) || session_has( 'logged_in_user_id' ) ) {
			session( 'user_logged_in', true );
			session( 'logged_in_user_id', $userId );
			session( 'logged_in_user_name', $userName );
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
		if ( $this->session()->has( 'user_logged_in' ) ) {
			$this->session()->remove( 'user_logged_in' );
			$this->session()->destroy();
		}

		return $this->isGuest();
	}
}