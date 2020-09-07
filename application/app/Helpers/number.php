<?php
function round_to_no_of_digits($number, $digit) {
	return sprintf("%0".$digit."u", $number);
}

function uniqueId() {
	return uniqid(); //5f2ad9c159c64
}
