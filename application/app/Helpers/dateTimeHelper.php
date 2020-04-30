<?php
/** timeHumanReadableFormat 12:00 AM] */
function timeHRF($time) { return date('g:i A', strtotime($time)); }

/** [timeDatabaseFormat 00:00:00 to 24:00:00] */
function timeDatabaseFormat($time) { return date('H:i:s', strtotime($time)); }

/** dayOfTheWeekToday 1 - sunday , 7 - Saturday , will return 1 to 7 */
function dayOfTheWeek($date) { return date('w', strtotime($date)) + 1; }

/** daysOfTheWeekToday Sunday to Saturday , will return Sunday */
function daysOfTheWeek($date) { return date('l', strtotime($date)); }

/** Find Which Day of the week - return day name in short like ( Wed , Thu ) */
function daysOfTheWeekInShort($date) { return date('D', strtotime($date)); }

/** [dateHumanReadableFormat MAR 21, 2020] */
function dateHumanReadableFormat($date) { return date('M d, Y', strtotime($date)); }

/** Date convert to format Y-m-d */
function ymd($date) { return date("Y-m-d", strtotime($date)); }

/** if $day > 7 , will return equivalentday as within [1 to 7] */
function convertToDayOfTheWeek($day) {
	$day = $day % 7; // example 7 % 7 = 0 , 9 % 7 = 2
	return $day == 0 ? 7 : $day;
}

/** [convertToDate 'Y-m-d'] */
function convertToDate($date) {
	return date('Y-m-d', strtotime($date));
}

/** auth login user */
function user(){
	return auth()->user();
}

/** Get day name starting day 1 => Sunday */
function get_day_name($day) {
    $days = [
        1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday',
        5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'
    ];
    return $days[$day];
}

function converToTzs($time="",$toTz='',$fromTz='') {
    $date = new DateTime($time, new DateTimeZone($fromTz));
    $date->setTimezone(new DateTimeZone($toTz));
    $time= $date->format('Y-m-d H:i:s');
    return $time;
}

function get_age($date) {
    return date_diff(date_create($date), date_create('today'))->y;
}
