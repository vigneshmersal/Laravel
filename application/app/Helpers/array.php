<?php
/* ----------convert array values to uppercasr---------- */
function upperCase(array $array) {
	return array_map('strtoupper', $array);
}

/* ----------join array=[ [1,2], [3,4] ]= [1,2,3,4] ---------- */
function arrayMerge($array) {
	return array_merge(...$array); // [ 1,2,3,4 ]
}

/* ----------join anywhere [1,2] = [a,b,1,2,c]---------- */
function arrayMergeAnyWhere($array) {
	return [ 'a' , 'b', $array, 'c' ];
}
