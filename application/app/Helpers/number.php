<?php
function round_to_no_of_digits($number, $digit) {
	return sprintf("%0".$digit."u", $number);
}
