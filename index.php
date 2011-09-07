<?php

require 'lib/class.J.php';

J::describe('Test Methods of J::Expect', function() {
	
	$arr = array('hi' => 'sup');
	J::expect($arr)->toNotBe(array('hi' => 'df'));

	J::expect($arr[0])->toBeNull();

});

