<?php

namespace App\Models;

use Core\Database\Model;
use Illuminate\Database\Schema\Blueprint;

class Address extends Model
{
	protected $table    = 'addresses';
	protected $fillable = [ 'name', 'email', 'address' ];

	public function createTable()
	{
		if ( ! $this->schema()->hasTable( 'addresses' ) ) {
			$this->schema()->create( 'addresses', function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'name' );
				$table->string( 'email' )->nullable();
				$table->string( 'address' );
				$table->string( 'updated_at' )->nullable();
				$table->string( 'created_at' )->nullable();
			} );
		}
	}
}
