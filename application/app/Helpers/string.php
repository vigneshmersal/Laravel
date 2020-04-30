<?php
/**
 * [convertNullsAsEmpty description]
 * @param  [type] $array [description]
 * @return [type]        [description]
 */
function convertNullsAsEmpty($array) {
	array_walk_recursive($array, function (&$value, $key) {
		$value = is_int($value) ? (String)$value : $value;
		$value = $value === null ? "" : $value;
	});
	return $array;
}

/**
 * getRandomString
 * @param type $length
 * @return type unique random string
 */
function getRandomString($length) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';

	for ($i = 0; $i < $length - 5; $i++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}
	return mt_rand(10000, 99999) . $string;
}

function encryptStr($str) {
	return encrypt($str); // serialization - object & array
	return Crypt::encryptString($str); // without serialization
}

function decryptStr($str) {
	try {
		return decrypt($str);
		return Crypt::decryptString($str);
	} catch (DecryptException $e) {
		\Log::info($e->getMessage());
	}
}
