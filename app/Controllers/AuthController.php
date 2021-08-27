<?php


namespace App\Controllers;

use Core\Middleware\GuestMiddleware;
use App\Models\User;
use Core\Controller\Controller;
use Core\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
	private User $user;

	public function __construct()
	{
		//Create user table on database
		$this->user = new User();
		$this->user->createTable();

		//GuestMiddleware
		$this->middleware( new GuestMiddleware( [ 'login', 'signup', 'emailVerify' ] ) );
	}

	public function login( Request $request )
	{

		if ( $request->isPost() ) {
			$email    = $request->input( 'email' );
			$password = $request->input( 'password' );

			$this->validate( $request->all(), [
				'email'    => 'required|email',
				'password' => 'required'
			] );

			$user = User::where( 'email', $email )->first();

			if ( $user ) {
				if ( $user->email_verified == 'yes' ) {
					if ( password_verify( $password, $user->password ) ) {
						app()->login( $user->id, $user->name );
						redirect( '/' );
					}
					redirect()->back()->with( 'error_msg', 'Your password incorrect' );
				}
				redirect()->back()->with( 'error_msg', 'Your email is not verified. Please check your mail box' );
			}
			else {
				redirect()->back()->with( 'error_msg', 'Your email address not match' );
			}

		}

		return $this->view( 'auth/login' );
	}

	public function signup( Request $request )
	{
		if ( $request->isPost() ) {
			$name                     = $request->name;
			$email                    = $request->email;
			$password                 = $request->password;
			$email_verification_token = sha1( time() );

			$this->validate( $request->all(), [
				'name'            => 'required|alpha',
				'email'           => 'required|email',
				'password'        => 'required|min:6|max:20',
				'confirmPassword' => 'required|confirm:password'
			] );


			if ( User::where( 'email', $email )->exists() ) {
				redirect( '/auth/login' )->with( 'error_msg', 'You are already registered with the email.' );
			}

			$user = $this->user;

			$user->name                     = $name;
			$user->email                    = $email;
			$user->password                 = password_hash( $password, PASSWORD_BCRYPT );
			$user->email_verification_token = $email_verification_token;

			if ( $user->save() ) {
				$subject = 'Email Verification';
				$body    = sprintf( "Hi Mr/Ms %s<br>", $name );
				$body    .= sprintf( "Thank you to join our website %s<br>", route() );
				$body    .= sprintf( 'Please Verify your email <a href="%s/auth/email-verify/%s"><strong>Click Here</strong></a><br>', route(), $email_verification_token );
				$body    .= 'Thank you.';

				$mail = new PHPMailer( true );
				try {
					//Server settings
					$mail->SMTPDebug = SMTP::DEBUG_SERVER;
					$mail->isSMTP();
					$mail->Host       = 'smtp.gmail.com';
					$mail->SMTPAuth   = true;
					$mail->Username   = 'sohademo143@gmail.com';
					$mail->Password   = 'sohademopass';
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
					$mail->Port       = 465;

					//Recipients
					$mail->setFrom( 'demo@mail.com' );
					$mail->addAddress( 'shohelrrrana@gmail.com' );

					//Content
					$mail->isHTML( true );
					$mail->Subject = $subject;
					$mail->Body    = $body;

					$mail->send();
					echo 'Message has been sent';
				} catch ( Exception $e ) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}

				redirect( '/auth/login' )->with( 'success_msg', 'Signup is success. Need verify your email. Please check inbox' );
			}

			redirect()->back()->with( 'error_msg', 'Somthing went wrong, please contact us' );

		}

		return $this->view( 'auth/signup' );
	}

	public function emailVerify( $token )
	{
		if ( empty( $token ) ) {
			redirect( '/auth/login' )->with( 'error_msg', 'Email Verification token required' );
		}


		$user = User::where( 'email_verification_token', $token )->first();

		if ( $user ) {
			$user->email_verified = 'yes';
			if ( $user->save() ) {
				redirect( '/auth/login' )->with( 'success_msg', 'Your email has been verified. Now you can login' );
			}
		}

		redirect( '/auth/login' )->with( 'error_msg', 'Invalid token' );

	}

	public function logout()
	{
		if ( app()->logout() ) {
			redirect( '/auth/login' )->with( 'success_msg', 'You have been logged out' );
		}
	}
}