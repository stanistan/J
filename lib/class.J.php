<?php

require 'class.ExpectMethod.php';
require 'class.Expect.php';

class J {

	public static $last_it;

	public static function describe($note, $fn = null) {
		if (!is_callable($fn)) {
			throw new Exception('J::describe expects second parameter to be a function.');
		}
		print($note.PHP_EOL);
		print('--'.PHP_EOL);
		$fn();
	}


	public static function expect($fn) {
		if (is_callable($fn)) $fn = $fn();
		return new Expect($fn, self::$last_it);
	}

}