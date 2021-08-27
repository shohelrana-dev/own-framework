<?php

namespace App\Models;

use Core\Database\Model;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Model {
	protected $table    = 'users';
	protected $fillable = [ 'name', 'email', 'password', 'email_verified', 'email_verification_token' ];

	public function createTable() {
		if ( ! $this->schema()->hasTable( 'users' ) ) {
			$this->schema()->create( 'users', function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'name' );
				$table->string( 'email' )->unique();
				$table->string( 'password' );
				$table->string( 'email_verified' )->default( 'no' );
				$table->string( 'email_verification_token' );
				$table->string( 'updated_at' )->nullable();
				$table->string( 'created_at' )->nullable();
			} );
		}
	}
}