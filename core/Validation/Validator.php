<?php

namespace Core\Validation;

use Core\Support\ErrorBag;
use Core\Validation\Rules\Alphabet;
use Core\Validation\Rules\Confirm;
use Core\Validation\Rules\Email;
use Core\Validation\Rules\Max;
use Core\Validation\Rules\Min;
use Core\Validation\Rules\Number;
use Core\Validation\Rules\Required;
use Core\Validation\Rules\RuleInterface;

class Validator
{

	private ErrorBag $errors;
	private array    $rules = [];

	public function __construct()
	{
		$this->errors = ErrorBag::getInstance();
		$this->defaultRules();
	}

	private function defaultRules()
	{
		$this->rules['required'] = Required::class;
		$this->rules['email']    = Email::class;
		$this->rules['min']      = Min::class;
		$this->rules['max']      = Max::class;
		$this->rules['num']      = Number::class;
		$this->rules['alpha']    = Alphabet::class;
		$this->rules['confirm']  = Confirm::class;
	}

	/**
	 * Make Validate
	 *
	 * @param array $data
	 * @param array $rules
	 *
	 * @return bool
	 */
	public function make( array $data, array $rules ) : bool
	{
		foreach ( $data as $field => $value ) {
			if ( ! array_key_exists( $field, $rules ) ) {
				continue;
			}
			$userRules = explode( '|', $rules[ $field ] );

			foreach ( $userRules as $userRule ) {
				if ( $this->errors()->has( $field ) ) {
					continue;
				}

				//Parse Parameter
				$params = [];
				if ( strpos( $userRule, ':' ) ) {
					$params               = explode( ':', $userRule, 2 );
					$userRule             = $params[0];
					$params[ $params[0] ] = $params[1];
					$params['data']       = $data;
				}

				/**
				 * @var RuleInterface $ruleInstance
				 */
				if ( isset( $this->rules[ $userRule ] ) ) {
					$ruleClass    = $this->rules[ $userRule ];
					$ruleInstance = new $ruleClass();

					$validate = $ruleInstance->validate( $field, $value, $params );

					if ( ! $validate ) {
						$ruleMessage = str_replace( '{field}', ucfirst( $field ), $ruleInstance->message() );
						$this->errors->addError( $field, $ruleMessage );
					}
				}
				else {
					die( "Rule {$userRule} is not recognized." );
				}
			}
		}

		return ! $this->errors->any();
	}

	public function isFailed()
	{
		return $this->errors->any();
	}

	public function isSuccess()
	{
		return ! $this->errors->any();
	}

	public function errors() : ErrorBag
	{
		return $this->errors;
	}
}
