<?php

namespace Core\Http;

class Cookie {
	/**
	 * Set new cookie
	 *
	 * @param string $key
	 * @param string $value
	 *
	 * @return string $value
	 */
	public static function set( string $key, $value ) {
		$expired = time() + ( 1 * 365 * 24 * 60 * 60 );
		setcookie( $key, $value, $expired, '/', '', false, true );

		return $value;
	}

	/**
	 * Check that cookie has the key
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function has( string $key ) : bool {
		return isset( $_COOKIE[ $key ] );
	}

	/**
	 * Get cookie by the given key
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public static function get( string $key ) : string {
		return static::has( $key ) ? $_COOKIE[ $key ] : '';
	}

	/**
	 * Remove cookie by the given key
	 *
	 * @param string $key
	 * @return void
	 */
	public static function remove( $key ) : void {
		unset( $_COOKIE[ $key ] );
		setcookie( $key, null, '-1', '/' );
	}

	/**
	 * Return all cookies
	 *
	 * @return array
	 */
	public static function all() : array {
		return $_COOKIE;
	}

	/**
	 * Destroy the cookie
	 *
	 * return void
	 */
	public static function destroy() : void {
		foreach ( static::all() as $key => $value ) {
			static::remove( $key );
		}
	}
}