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

	public static function it($note, $fn) {
		self::$last_it = $note;
		$fn();
	}

	public static function expect($fn) {
		if (is_callable($fn)) $fn = $fn();
		return new Expect($fn, self::$last_it);
	}

	public static function result($message = null, $status, $expected = null, $given = null) {
		if ($status) {
			print_r('Successfull test: '.$message);
		} else {
			print_r('Test Failed: '.$message);
			if ($expected != $given) {
				$expected = J::valToString($expected);
				$given = J::valToString($given);
				print_r("\n--[$expected] Expected. Result was [$given]");
			}
		}
		print_r("\n");
	}

	public static function valToString($val) {
		if (is_string($val)) return $val;
		if (is_null($val)) return 'NULL';
		if (is_object($val)) return var_export($val, true);
	}

}