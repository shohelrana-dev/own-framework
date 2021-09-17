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
 * Create instance of the Application and register routes
 */

use Core\Application;
use App\Controllers\TodoController;
use App\Controllers\ContactController;
use App\Controllers\AuthController;

$app = new Application();

$app->get( '/auth/login', [ AuthController::class, 'login' ] );
$app->post( '/auth/login', [ AuthController::class, 'login' ] );
$app->get( '/auth/signup', [ AuthController::class, 'signup' ] );
$app->post( '/auth/signup', [ AuthController::class, 'signup' ] );
$app->get( '/auth/email-verify/{token}', [ AuthController::class, 'emailVerify' ] );
$app->get( '/auth/logout', [ AuthController::class, 'logout' ] );

$app->get( '/', [ TodoController::class, 'index' ] );
$app->get( '/todos', [ TodoController::class, 'index' ] );
$app->get( '/todos/create', [ TodoController::class, 'create' ] );
$app->post( '/todos/create', [ TodoController::class, 'create' ] );
$app->get( '/todos/edit/{id}', [ TodoController::class, 'edit' ] );
$app->post( '/todos/edit/{id}', [ TodoController::class, 'edit' ] );
$app->get( '/todos/delete/{id}', [ TodoController::class, 'delete' ] );

$app->get( '/contact', [ ContactController::class, 'index' ] );
$app->post( '/contact', [ ContactController::class, 'index' ] );

//Run the Application
$app->run();