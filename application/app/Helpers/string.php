<?php
/*
|--------------------------------------------------------------------------
| convertNullsAsEmpty
|--------------------------------------------------------------------------
*/
function convertNullsAsEmpty($array) {
	array_walk_recursive($array, function (&$value, $key) {
		$value = is_int($value) ? (String)$value : $value;
		$value = $value === null ? "" : $value;
	});
	return $array;
}

/*
|--------------------------------------------------------------------------
| getRandomString
|--------------------------------------------------------------------------
*/
function getRandomString($length) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';

	for ($i = 0; $i < $length - 5; $i++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}
	return mt_rand(10000, 99999) . $string;
}

/*
|--------------------------------------------------------------------------
| Encrypt & Decrypt
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| find the given letter in the string , and return the remaining words
|--------------------------------------------------------------------------
| after('vignesh@gmail.com', '@') >>> 'gmail.com'
*/
function after($str, $find) {
	return substr( strrchr($str, $find) , 1);
}
