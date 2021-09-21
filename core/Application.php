<?php


namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\Router\Route;
use Symfony\Component\Dotenv\Dotenv;

/**
 * The main class of framework
 *
 * Put classes objects
 * @property Request $request
 * @property Response $response
 * @property Session $session
 * @property Route $route
 *
 * Register route methods
 * @method get( $path, $callback )
 * @method post( $path, $callback )
 * @method put( $path, $callback )
 * @method delete( $path, $callback )
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
		$this->setupDotenv();

		self::$app = $this;

		$this->container['request']  = new Request();
		$this->container['response'] = new Response();
		$this->container['session']  = new Session();
		$this->container['route']    = new Route( $this->request, $this->response );
	}

	public function setupDotenv(  )
	{
		$dotenv = new Dotenv();
		$dotenv->load(ROOT_PATH . DS . '.env');
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
	 * Register route methods
	 *
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this
	 */
	public function __call( $name, $arguments )
	{
		$path     = isset( $arguments[0] ) ? $arguments[0] : '';
		$callback = isset( $arguments[1] ) ? $arguments[1] : '';

		if ( empty( $path ) || empty( $callback ) ) {
			die( "Route method {$name} called incorrectly!" );
		}

		switch ( $name ) {
			case 'get':
				$this->route->addRoute( $this->request::METHOD_GET, $path, $callback );
				break;

			case 'post':
				$this->route->addRoute( $this->request::METHOD_POST, $path, $callback );
				break;

			case 'put':
				$this->route->addRoute( $this->request::METHOD_PUT, $path, $callback );
				break;

			case 'delete':
				$this->route->addRoute( $this->request::METHOD_DELETE, $path, $callback );
				break;

			default:
				return $this;
		}
	}

	/**
	 * Check the application debug mode
	 *
	 * @return void
	 */
	public function debugMode() : void
	{
		if ( isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === true ) {
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