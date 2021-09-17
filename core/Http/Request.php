<?php

namespace Core\Http;

/**
 * Class Request
 *
 * @package Core\Http
 */
class Request
{

	/**
	 * Request method constants
	 */
	public const METHOD_GET    = 'GET';
	public const METHOD_POST   = 'POST';
	public const METHOD_PUT    = 'PUT';
	public const METHOD_PATCH  = 'PATCH';
	public const METHOD_DELETE = 'DELETE';

	public function __construct()
	{
		$this->setupProperties();
	}

	/**
	 * get the request path
	 *
	 * @return string
	 */
	public function path() : string
	{
		return $_SERVER['REQUEST_URI'] ?? '/';
	}

	/**
	 * get the request method
	 *
	 * @return string
	 */
	public function method() : string
	{
		return strtoupper( $_SERVER['REQUEST_METHOD'] );
	}

	/**
	 * Check, is the request is GET
	 *
	 * @return boolean
	 */
	public function isGet() : bool
	{
		return $this->method() === self::METHOD_GET;
	}

	/**
	 * Check, is the request is POST
	 *
	 * @return boolean
	 */
	public function isPost() : bool
	{
		return $this->method() === self::METHOD_POST;
	}

	/**
	 * Check, is the request is PUT
	 *
	 * @return boolean
	 */
	public function isPut() : bool
	{
		return $this->method() === self::METHOD_PUT;
	}

	/**
	 * Check, is the request is PATCH
	 *
	 * @return boolean
	 */
	public function isPatch() : bool
	{
		return $this->method() === self::METHOD_PATCH;
	}

	/**
	 * Check, is the request is DELETE
	 *
	 * @return boolean
	 */
	public function isDelete() : bool
	{
		return $this->method() === self::METHOD_DELETE;
	}

	/**
	 * Setup properties
	 *
	 * @return void
	 */
	private function setupProperties() : void
	{
		foreach ( $this->all() as $key => $value ) {
			if ( ! property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * get the request values
	 *
	 * @return array
	 */
	public function all() : array
	{
		$body = [];

		switch ( $this->method() ) {
			case $this::METHOD_GET:
				foreach ( $_GET as $key => $value ) {
					$body[ $key ] = filter_input( INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS );
				}
				break;

			case $this::METHOD_POST:
				foreach ( $_POST as $key => $value ) {
					$body[ $key ] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS );
				}
				break;
		}

		return $body;
	}

	/**
	 * get the request value
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function input( string $name ) : string
	{
		return isset( $this->all()[ $name ] ) ? $this->all()[ $name ] : '';
	}

	/**
	 * http referer
	 *
	 * @return string
	 */
	public function referer() : string
	{
		return isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
	}
}
