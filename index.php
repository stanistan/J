<?php

require 'lib/class.J.php';

J::describe('Test Methods of J::Expect', function() {
	
	$arr = array('hi' => 'sup');
	J::expect(array_keys($arr))->toBe(array('hi'));
	J::expect($arr)->toNotBe(array('hi' => 'df'));

	J::expect($arr[0])->toBeNull();
	
	J::expect(6)->toBeGreaterThan(5);
	J::expect(6)->toBeGreaterThanOrEqualTo(6);

	J::expect(5)->toBeLessThan(10);
	J::expect(5)->toBeLessThanOrEqualTo(10);

	$string = 'abc';
	J::expect($string)->toMatch('/a/');
	J::expect($string)->toNotMatch('/d/');

	J::expect(' ')->toNotBeSet();
	$a = 'a';
	J::expect($a)->toBeSet();

	J::expect($a)->toBeTruthy();
	J::expect(' ')->toBeFalsy();

});

