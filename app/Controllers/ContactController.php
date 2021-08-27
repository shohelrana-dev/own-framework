<?php


namespace App\Controllers;


use Core\Controller\Controller;
use Core\Http\Request;

class ContactController extends Controller
{
	public function index( Request $request )
	{
		if ( $request->isPost() ) {
			$this->validate( $request->all(), [
				'subject' => 'required|alpha',
				'email'   => 'required|email',
				'message' => 'required',
			] );
		}
		return $this->view( 'contact' );
	}
}