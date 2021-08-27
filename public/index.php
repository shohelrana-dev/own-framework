<?php
/**
 * -----------------------
 *Own php framework
 *------------------------
 * @author Shohel Rana <shohelrrrana@gmail.com>
 */

/**
 * -----------------------------------------------------------------
 * Load the autoloader that will generated class that will be used
 * -----------------------------------------------------------------
 */
require __DIR__ . './../vendor/autoload.php';

/**
 * Create instance of the Application and register route
 */

use Core\Application;
use App\Controllers\AddressController;
use App\Controllers\ContactController;
use App\Controllers\AuthController;

$app = new Application();

$app->get( '/auth/login', [ AuthController::class, 'login' ] );
$app->post( '/auth/login', [ AuthController::class, 'login' ] );
$app->get( '/auth/signup', [ AuthController::class, 'signup' ] );
$app->post( '/auth/signup', [ AuthController::class, 'signup' ] );
$app->get( '/auth/email-verify/{token}', [ AuthController::class, 'emailVerify' ] );
$app->get( '/auth/logout', [ AuthController::class, 'logout' ] );

$app->get( '/', [ AddressController::class, 'index' ] );
$app->get( '/address', [ AddressController::class, 'index' ] );
$app->get( '/address/create', [ AddressController::class, 'create' ] );
$app->post( '/address/create', [ AddressController::class, 'create' ] );
$app->get( '/address/edit/{id}', [ AddressController::class, 'edit' ] );
$app->post( '/address/edit/{id}', [ AddressController::class, 'edit' ] );
$app->get( '/address/delete/{id}', [ AddressController::class, 'delete' ] );

$app->get( '/contact', [ ContactController::class, 'index' ] );
$app->post( '/contact', [ ContactController::class, 'index' ] );

//Run the Application
$app->run();