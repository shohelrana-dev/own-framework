<?php

namespace Core\Http;

use Core\Support\ErrorBag;

class Redirect
{
	private Session $session;
	private Request $request;

	private string  $redirectUrl = '';
	private bool    $isBack      = false;

	public function __construct()
	{
		$this->session = app()->session();
		$this->request = app()->request();
	}

	public function to( string $url = '' )
	{
		$this->redirectUrl = $url;

		return $this;
	}

	public function __destruct()
	{
		if ( empty( $this->redirectUrl ) && $this->isBack ) {
			header( 'Location: ' . $this->request->referer() );
			die;
		}

		header( 'Location: ' . $this->redirectUrl );
		die;
	}

	public function back()
	{
		$this->isBack = true;

		return $this;
	}

	public function with( $key, $value )
	{
		$this->session->flash( $key, $value );

		return $this;
	}

	public function withErrors( array $errors = [] )
	{
		$errorBag = ErrorBag::getInstance();

		if ( ! empty( $errors ) ) {
			$errorBag->setErrors( $errors );
		}

		$this->session->flash( 'errors', $errorBag );

		return $this;
	}

	public function withInput( array $input = null )
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

