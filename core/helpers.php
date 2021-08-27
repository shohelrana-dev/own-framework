<?php

/**
 * Dumps data
 *
 * @param $data
 */
function dd( $data )
{
	echo "<pre>";
	print_r( $data );
	echo "</pre>";
	die();
}

/**
 * Application
 *
 * @return Core\Application
 */
function app()
{
	return Core\Application::$app;
}

/**
 * Redirect Url
 *
 * @param string $path
 *
 * @return Core\Http\Redirect
 */
function redirect( string $path = '' )
{
	return app()->response()->redirect( $path );
}

/**
 * Get request old value
 *
 * @param $name
 *
 * @return string
 */
function old( string $name )
{
	return app()->session()->get( 'old_input_' . $name );
}

/**
 * Session set and get by key
 *
 * @param $key
 * @param $value
 *
 * @return mixed
 */
function session( string $key = null, string $value = null )
{
	if ( is_null( $key ) && is_null( $value ) ) {
		return app()->session();
	}
	elseif ( ! is_null( $key ) && is_null( $value ) ) {
		return app()->session()->get( $key );
	}
	elseif ( ! is_null( $key ) && ! is_null( $value ) ) {
		app()->session()->set( $key, $value );
	}
}

/**
 * Session flash
 *
 * @param string $key
 * @param $value
 *
 * @return mixed
 */
function session_flash( string $key, $value ) : void
{
	app()->session()->flash( $key, $value );
}

/**
 * Session has
 *
 * @param string $key
 *
 * @return bool
 */
function session_has( string $key ) : bool
{
	return app()->session()->has( $key );
}

/**
 * route
 *
 * @param string $path
 *
 * @return string
 */
function url( string $path = '/' ) : string
{
	return ROOT_URL . $path;
}

/**
 * root url
 *
 * @return string
 */
function root_url() : string
{
	return ROOT_URL;
}

/**
 * assets url
 *
 * @param string $path
 *
 * @return string
 */
function asset( string $path = '' ) : string
{
	if ( empty( $path ) ) {
		return ROOT_URL . '/assets';
	}
	return ROOT_URL . '/assets' . $path;
}

/**
 * Root Path
 *
 * @param string $path
 *
 * @return string
 */
function root_path( string $path = '' ) : string
{
	if ( empty( $path ) ) {
		return ROOT_PATH;
	}
	return ROOT_PATH . $path;
}

/**
 * View Path
 *
 * @param string $path
 *
 * @return string
 */
function view_path( string $path = '' ) : string
{
	if ( empty( $path ) ) {
		return VIEW_PATH;
	}
	return VIEW_PATH . $path;
}

/**
 * Check Auth
 *
 * @return bool
 */
function isAuth()
{
	return app()->isAuth();
}

/**
 * Check Guest
 *
 * @return bool
 */
function isGuest()
{
	return app()->isGuest();
}
