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

public function menuTree($menu)
{
	$menuAry = [];
	foreach ($menu as $sub) {
		$block = [];
		if (isset($sub->title)) {
			$block['id']   = $sub->id;
			$block['name'] = $sub->title;
			$block['url']  = $sub->link;
			if ($sub->childs()->count()) $block['submenu'] = $this->arrangeMenu($sub->childs);
			$menuAry[] = $block;
		}
	}
	return $menuAry;
}
