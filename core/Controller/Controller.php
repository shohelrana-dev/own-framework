<?php


namespace Core\Controller;

use Core\Middleware\Middleware;
use Core\Support\ErrorBag;
use Core\Validation\Validator;

/**
 * Class Controller
 *
 * @package Core\Controller
 */
abstract class Controller
{
	/**
	 * Default view layout
	 *
	 * @var string $layout
	 */
	private string $layout = 'main';

	/**
	 * hold action
	 *
	 * @var string $action
	 */
	public string $action = '';

	/**
	 * Put all Middleware
	 *
	 * @var array $middlewares
	 */
	private array $middlewares = [];

	private function templateVars()
	{
		$errors   = app()->session()->get( 'errors' );
		$errorBag = $errors ? $errors : new ErrorBag();

		return [
			'errors' => $errorBag
		];
	}

	/**
	 * Get view content with layout
	 *
	 * @param string $view
	 * @param array $params
	 *
	 * @return bool|false|string|string[]
	 */
	protected function view( string $view, array $params = [] ) : string
	{
		$layoutContent = $this->getLayoutContent();
		$viewContent   = $this->getViewContent( $view, $params );

		//Merge view and layout content
		if ( $layoutContent !== null ) {
			$outputContent = str_replace( '{{content}}', $viewContent, $layoutContent );
		}
		else {
			$outputContent = $viewContent;
		}

		return $outputContent;
	}

	/**
	 * Get view file contents
	 *
	 * @param string $view
	 * @param array $params
	 *
	 * @return false|string
	 */
	private function getViewContent( string $view, array $params ) : string
	{
		$viewFile = VIEW_PATH . DS . $view . '.php';

		if ( is_file( $viewFile ) && file_exists( $viewFile ) ) {
			foreach ( $params as $key => $value ) {
				$$key = $value;
			}

			foreach ( $this->templateVars() as $var => $value ) {
				$$var = $value;
			}

			ob_start();
			include_once( $viewFile );

			return ob_get_clean();

		}
		else {
			return "View template  file {$viewFile} is not found";
		}

	}

	/**
	 * Get layout contents
	 *
	 * @return bool|string
	 */
	private function getLayoutContent()
	{
		$layoutFile = VIEW_PATH . DS . 'layouts' . DS . $this->layout . '.php';

		if ( file_exists( $layoutFile ) ) {
			ob_start();
			include_once( $layoutFile );

			return ob_get_clean();
		}

		return null;
	}

	/**
	 * Set layout
	 *
	 * @param string $layout
	 */
	protected function setLayout( string $layout ) : void
	{
		$this->layout = $layout;
	}

	/**
	 * Form validation
	 *
	 * @param array $data
	 * @param array $rules
	 *
	 * @return void
	 */
	protected function validate( array $data, array $rules ) : void
	{
		$validator = new Validator();
		$validator->make( $data, $rules );

		if ( $validator->isFailed() ) {
			redirect()->back()->withErrors()->withInput();
		}
	}

	/**
	 * Add middleware
	 *
	 * @param Middleware $middleware
	 *
	 * @return void
	 */
	public function middleware( Middleware $middleware ) : void
	{
		$this->middlewares[] = $middleware;
	}

	/**
	 * Get middlewares
	 *
	 * @return array
	 */
	public function getMiddlewares() : array
	{
		return $this->middlewares;
	}
}