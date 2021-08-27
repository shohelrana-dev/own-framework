<?php


namespace App\Controllers;


use Core\Middleware\AuthMiddleware;
use App\Models\Address;
use Core\Controller\Controller;
use Core\Http\Request;

class AddressController extends Controller
{
	private Address $address;

	public function __construct()
	{
		//Create user table on database
		$this->address = new Address();
		$this->address->createTable();

		//AuthMiddleware
		$this->middleware( new AuthMiddleware() );
	}

	public function index()
	{
		return $this->view( 'address/index', [ 'addresses' => $this->address->all() ] );
	}

	public function create( Request $request )
	{
		if ( $request->isPost() ) {
			$this->validate( $request->all(), [
				'name'    => 'required',
				'address' => 'required',
			] );

			$address          = new Address();
			$address->name    = $request->input( 'name' );
			$address->email   = $request->input( 'email' );
			$address->address = $request->input( 'address' );

			if ( $address->save() ) {
				redirect( '/' )->with( 'success_msg', 'Address created' );
			}
			redirect()->back()->with( 'error_msg', 'Something went wrong' );
		}

		return $this->view( 'address/create' );
	}

	public function edit( $id, Request $request )
	{
		$address = Address::where( 'id', $id )->first();

		if ( $request->isPost() ) {
			$this->validate( $request->all(), [
				'name'    => 'required',
				'address' => 'required',
			] );

			$address->name    = $request->input( 'name' );
			$address->email   = $request->input( 'email' );
			$address->address = $request->input( 'address' );

			if ( $address->save() ) {
				redirect( '/' )->with( 'success_msg', 'Address updated' );
			}
			redirect()->back()->with( 'error_msg', 'Something went wrong' );
		}

		return $this->view( 'address/edit', [ 'id' => $id, 'address' => $address ] );
	}

	public function delete( $id )
	{

		if ( is_int( intval( $id ) ) ) {
			Address::where( 'id', $id )->delete();
		}
		redirect()->back()->with( 'success_msg', 'Address deleted' );
	}
}