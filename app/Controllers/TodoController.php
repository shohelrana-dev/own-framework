<?php


namespace App\Controllers;


use Core\Middleware\AuthMiddleware;
use App\Models\Todo;
use Core\Controller\Controller;
use Core\Http\Request;

class TodoController extends Controller
{
	private Todo $todo;

	public function __construct()
	{
		//Create user table on database
		$this->todo = new Todo();
		$this->todo->createTable();

		//AuthMiddleware
		$this->middleware( new AuthMiddleware() );
	}

	public function index()
	{
		return $this->view( 'todos/index', [ 'todos' => $this->todo->all() ] );
	}

	public function create( Request $request )
	{
		if ( $request->isPost() ) {
			$this->validate( $request->all(), [
				'title'    => 'required',
				'content' => 'required',
			] );

			$todo          = new Todo();
			$todo->title    = $request->input( 'title' );
			$todo->content   = $request->input( 'content' );

			if ( $todo->save() ) {
				redirect( '/' )->with( 'success_msg', 'Todo created' );
			}
			redirect()->back()->with( 'error_msg', 'Something went wrong' );
		}

		return $this->view( 'todos/create' );
	}

	public function edit( $id, Request $request )
	{
		$todo = Todo::where( 'id', $id )->first();

		if ( $request->isPost() ) {
			$this->validate( $request->all(), [
				'title'    => 'required',
				'content' => 'required',
			] );

			$todo->title    = $request->input( 'title' );
			$todo->content   = $request->input( 'content' );

			if ( $todo->save() ) {
				redirect( '/' )->with( 'success_msg', 'Todo updated' );
			}
			redirect()->back()->with( 'error_msg', 'Something went wrong' );
		}

		return $this->view( 'todos/edit', [ 'id' => $id, 'todo' => $todo ] );
	}

	public function delete( $id )
	{

		if ( is_int( intval( $id ) ) ) {
			Todo::where( 'id', $id )->delete();
		}
		redirect()->back()->with( 'success_msg', 'Todo deleted' );
	}
}