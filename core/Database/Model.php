<?php

namespace Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class DB for database connection
 *
 * @package Core\Database
 */
class Model extends BaseModel {
	protected $schema;

	public function __construct() {
		$this->connect();
	}

	/**
	 * Build connection with database
	 *
	 * @return void
	 */
	private function connect() : void {
		$capsule = new Capsule();
		$capsule->addConnection( [
			'driver'    => DB_DRIVER,
			'host'      => DB_HOSTNAME,
			'database'  => DB_NAME,
			'username'  => DB_USERNAME,
			'password'  => DB_PASSWORD,
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		] );

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

	}

	protected function schema() {
		return Capsule::schema();
	}
}