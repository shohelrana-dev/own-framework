<?php

namespace Core\Http;

use Core\Support\ErrorBag;

class Redirect
{
	/**
	 * hold session class instance
	 *
	 * @var Session
	 */
	private Session $session;

	/**
	 * hold Request class instance
	 *
	 * @var Request
	 */
	private Request $request;

	/**
	 * @var string
	 */
	private string  $redirectUrl = '';
	/**
	 * @var bool
	 */
	private bool    $isBack = false;

	/**
	 * Redirect constructor.
	 */
	public function __construct()
	{
		$this->session = app()->session;
		$this->request = app()->request;
	}

	/**
	 * Redirect to url
	 *
	 * @param string $url
	 *
	 * @return $this
	 */
	public function to( string $url = '' )
	{
		$this->redirectUrl = $url;

		return $this;
	}

	/**
	 * Redirect destruct.
	 */
	public function __destruct()
	{
		if ( empty( $this->redirectUrl ) && $this->isBack ) {
			header( 'Location: ' . $this->request->referer() );
			die;
		}

		header( 'Location: ' . $this->redirectUrl );
		die;
	}

	/**
	 * Redirect previous url
	 *
	 * @return $this
	 */
	public function back() : Redirect
	{
		$this->isBack = true;

		return $this;
	}

	/**
	 * Redirect with flash session
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function with( $key, $value ) : Redirect
	{
		$this->session->flash( $key, $value );

		return $this;
	}

	/**
	 * Redirect with errors
	 *
	 * @param array $errors
	 *
	 * @return $this
	 */
	public function withErrors( array $errors = [] ) : Redirect
	{
		$errorBag = ErrorBag::getInstance();

		if ( ! empty( $errors ) ) {
			$errorBag->setErrors( $errors );
		}

		$this->session->flash( 'errors', $errorBag );

		return $this;
	}

	/**
	 * Redirect input value
	 *
	 * @param array|null $input
	 *
	 * @return $this
	 */
	public function withInput( array $input = null ) : Redirect
	{
		if ( is_null( $input ) ) {
			$this->session->flashInput( $this->request->all() );
		}
		else {
			$this->session->flashInput( $this->request->all() );
		}

		return $this;
	}
}

