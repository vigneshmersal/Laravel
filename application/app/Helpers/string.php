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

function uniqueId() {
	return uniqid(); //5f2ad9c159c64
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

/** $str = "[[\"37\",\"text\",\"\\"\\"\"],[\"38\",\"text\",\"\\"\\"\"],[\"39\",\"text\",\"\\"one word two words. Hello? \\\\"escape\\\\" lol\\"\"]]"; */
function decode($str) {
	$str = utf8_encode($str);
	return json_decode($str,JSON_UNESCAPED_SLASHES);
}

/* $str = [\"350\"] */
function decode1($str) {
	return json_decode(stripslashes($str));
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
function middle($str, $start, $last) { // "^1$" -> 1
	return substr($str,  1, -1);
}

/* ----------name to url---------- */
function linkCode($name, $join = "_") {
	return Str::slug(Str::lower($name), $join);
}
