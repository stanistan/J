<?php

class Expect {

	private $val;
	private $message;

	// defined in initializer, you can't set an array with functions :(
	public static $_methods = null;

	public function __construct($val = null, $message = null) {
		if ($val) $this->val = $val;
		if ($message) $this->message = $message;
		$this->init();
	}

	public function init() {
		if (self::$_methods) return;
		
		self::$_methods = new stdClass;
	
		$this->addMethod('toBe', function($c, $e) {
					return ($c === $e);
				}, '%s is the same as %s.', '%s is not the same as %s.')
			->addMethod('toNotBe', function($c, $e) {
					return ($c !== $e);
				}, $this->getFailure('toBe'), $this->getSuccess('toBe'))
			->addMethod('toEqual', function($c, $e) {
					return ($c == $e);
				}, '%s is equal to %s.', '%s is not equal to %s.')
			->addMethod('toNotEqual', function($c, $e) {
					return (!Expect::call('toEqual', func_get_args()));
				}, $this->getFailure('toEqual'), $this->getSuccess('toEqual'))
			->addMethod('toMatch', function($c, $e) {
					return (preg_match($c, $e));
				}, '%s matches pattern: %s', '%s does not match pattern: %s')
			->addMethod('toNotMatch', function($c, $e) {
					return (!Expect::call('toMatch', func_get_args()));
				}, $this->getFailure('toMatch'), $this->getSuccess('toMatch'))
			->addMethod('toBeSet', function($c) {
					return (isset($c));
				}, '%s is set.', '%s is not set.')
			->addMethod('toNotBeSet', function($c) {
					return (!Expect::call('toBeSet', func_get_args()));
				}, $this->getFailure('toBeSet'), $this->getSuccess('toBeSet'))
			->addMethod('toBeNull', function($c) {
					return (Expect::call('toBe', array($c, NULL)));
				}, $this->getSuccess('toBe'), $this->getFailure('toBe'))
			->addMethod('toBeTruthy', function($c) {
					return (!!$c);
				}, '%s is truthy.', '%s is not truthy.')
			->addMethod('toBeFalsy', function($c) {
					return (!$current);
				}, '%s is falsy.', '%s is not falsy.')
			->addMethod('toBeLessThan', function($c, $e) {
					return ($c < $e);
				}, '%s is less than %s.', '%s is not less thatn %s.')
			->addMethod('toBeLessThanOrEqualTo', function($c, $e) {
					return ($c <= $e);
				}, '%s is less than or equal to %s', '%s is not less than or equal to %s')
			->addMethod('toBeGreaterThan', function($c, $e) {
					return ($c > $e);
				}, '%s is greater than %s.', '%s is not greater than %s')
			->addMethod('toBeGreaterThanOrEqualTo', function($c, $e) {
					return ($c >= $e);
				}, '%s is greater than or equal to %s', '%s is not grater than or equal to %s');
	}

	public function addMethod($name, $method, $success, $failure) {
		self::$_methods->$name = new ExpectMethod($method, $success, $failure);
		return $this;
	}

	public function getSuccess($method) {
		return self::$_methods->$method->success;
	}

	public function getFailure($method) {
		return self::$_methods->$method->failure;
	}

	public function call($method, $args) {
		if (!self::$_methods->{$method}) {
			throw new Exception('Cannot call a method <strong>'.$method.'</strong> in Expect that does not exist.');
		}
		if (!is_callable(self::$_methods->{$method}->method)) {
			throw new Exception('Method: <strong>'.$method.'</strong> is not callable.');
		}
		return call_user_func_array(self::$_methods->$method, $args);
	}

	public function __call($method, $args) {
		if (is_array($args)) array_unshift($args, $this->val);
		else $args = array($this->val);
		$result = $this->call($method, $args);
		$r = ($result) ? 'Test Success: '.$this->getSuccess($method) : 'Test Failure: '.$this->getFailure($method);
		printf($r, self::toString($args[0]), self::toString($args[1]));
	}

	public static function toString($a = null) {
		if ($a === null) return 'NULL';
		if (is_string($a)) return $a;
		return var_export($a, true);
	}
		
}