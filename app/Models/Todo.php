<?php

namespace App\Models;

use Core\Database\Model;
use Illuminate\Database\Schema\Blueprint;

class Todo extends Model
{
	protected $table    = 'todos';
	protected $fillable = [ 'title', 'content' ];

	public function createTable()
	{
		if ( ! $this->schema()->hasTable( 'todos' ) ) {
			$this->schema()->create( 'todos', function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'title' );
				$table->string( 'content' )->nullable();
				$table->string( 'updated_at' )->nullable();
				$table->string( 'created_at' )->nullable();
			} );
		}
	}
}
