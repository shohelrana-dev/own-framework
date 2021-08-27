<?php


namespace Core\Http;

/**
 * Class Response
 *
 * @package Core\Http
 */
class Response
{

	/**
	 * set http_response_code
	 *
	 * @param int $code
	 */
	public function setStatusCode( int $code ) : void
	{
		http_response_code( $code );
	}

	/**
	 * convert array to string
	 *
	 * @param $data
	 *
	 * @return false|string
	 */
	public function json( $data ) : string
	{
		return json_encode( $data );
	}

	/**
	 * Redirect to url
	 *
	 * @param string $path
	 *
	 * @return Redirect
	 */
	public function redirect( string $path = '' ) : Redirect
	{
		$url = $path ? root_url() . $path : '';

		$redirect = new Redirect();
		$redirect->to( $url );

		return $redirect;
	}
}