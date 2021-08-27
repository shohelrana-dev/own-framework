<?php

namespace Core\Http;

/**
 * Class Session
 *
 * @package Core\Http
 */
class Session
{
	/**
	 * hold flash session keys
	 *
	 * @var array
	 */
	private array   $flash = [];

	/**
	 * check clear old flash
	 *
	 * @var bool
	 */
	private bool    $clearOldFlash = false;

	/**
	 * Session constructor.
	 */
	public function __construct()
	{
		if ( ! session_id() ) {
			ini_set( 'session.use_only_cookies', 1 );
			session_start();
		}

		$this->clearOldFlash();
	}

	/**
	 * Set new session
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return mixed $value
	 */
	public function set( string $key, $value ) : void
	{
		$_SESSION[ $key ] = $value;
	}

	/**
	 * Check that session has the key
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has( string $key ) : bool
	{
		if ( isset( $this->flash[ $key ] ) ) {
			return true;
		}
		elseif ( isset( $_SESSION[ $key ] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Get session by the given key
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get( string $key )
	{
		if ( isset( $this->flash[ $key ] ) ) {
			return $this->flash[ $key ];
		}
		elseif ( isset( $_SESSION[ $key ] ) ) {
			return $_SESSION[ $key ];
		}
		return null;
	}

	/**
	 * Remove session by the given key
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public function remove( string $key ) : void
	{
		unset( $_SESSION[ $key ] );
	}

	/**
	 * Return all sessions
	 *
	 * @return array
	 */
	public function all() : array
	{
		return $_SESSION;
	}

	/**
	 * Destroy the session
	 *
	 * return void
	 */
	public function destroy() : void
	{
		foreach ( $this->all() as $key => $value ) {
			$this->remove( $key );
		}
	}

	/**
	 * set flash session
	 *
	 * @param string $key
	 * @param $value
	 *
	 * @return void
	 */
	public function flash( string $key, $value ) : void
	{
		$this->set( $key, $value );

		$flash         = $this->get( 'flash' ) ? $this->get( 'flash' ) : [];
		$flash[ $key ] = $key;

		$this->set( 'flash', $flash );
	}

	/**
	 * clear old flash from session
	 * @return void
	 */
	private function clearOldFlash() : void
	{
		if ( $this->clearOldFlash === true ) return;

		$flashVars = $this->get( 'flash' );

		if ( is_array( $flashVars ) && ! empty( $flashVars ) ) {
			foreach ( $flashVars as $flashVar ) {
				$this->flash[ $flashVar ] = $this->get( $flashVar );
				$this->remove( $flashVar );
			}
		}

		$this->remove( 'flash' );
		$this->clearOldFlash = true;
	}

	/**
	 * Input set on session flash
	 *
	 * @param array $input
	 */
	public function flashInput( array $input ) : void
	{
		foreach ( $input as $name => $value ) {
			$this->flash( 'old_input_' . $name, $value );
		}
	}
}