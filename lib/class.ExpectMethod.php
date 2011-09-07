<?php

class ExpectMethod {

	public $success;
	public $failure;

	public $method;

	public function __construct($method, $success, $failure) {
		$this->method = $method;
		$this->success = $success;
		$this->failure = $failure;
	}

	public function __invoke() {
		return call_user_func_array($this->method, func_get_args());
	}



}