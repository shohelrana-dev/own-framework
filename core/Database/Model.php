<?php

namespace Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class DB for database connection
 *
 * @package Core\Database
 */
class Model extends BaseModel
{
	protected $schema;

	public function __construct()
	{
		$this->connect();
	}

	/**
	 * Build connection with database
	 *
	 * @return void
	 */
	private function connect() : void
	{
		$connection = isset( $_ENV['DB_CONNECTION'] ) ? $_ENV['DB_CONNECTION'] : '';
		$host       = isset( $_ENV['DB_HOST'] ) ? $_ENV['DB_HOST'] : '';
		$database   = isset( $_ENV['DB_DATABASE'] ) ? $_ENV['DB_DATABASE'] : '';
		$username   = isset( $_ENV['DB_USERNAME'] ) ? $_ENV['DB_USERNAME'] : '';
		$password   = isset( $_ENV['DB_PASSWORD'] ) ? $_ENV['DB_PASSWORD'] : '';

		$capsule = new Capsule();
		$capsule->addConnection( [
			'driver'    => $connection,
			'host'      => $host,
			'database'  => $database,
			'username'  => $username,
			'password'  => $password,
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		] );

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

	}

	protected function schema()
	{
		return Capsule::schema();
	}
}