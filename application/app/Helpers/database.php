<?php
function customModel($tableName) { // user_report
	$table = \Str::studly($tableName); // UserReport
	return "App\\$table";
}

/**
 * Get the array of columns
 * @return mixed
 */
function getTableColumns($instance) {
    return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    return \DB::getSchemaBuilder()->getColumnListing($instance->getTable());
    return \Schema::getcolumnListing($instance->getTable());
}

/**
 * Exclude an array of elements from the result.
 * @param $query
 * @param $columns
 * @return mixed
 */
function exclude($instance, $columns) {
    return $instance->select( array_diff( getTableColumns($instance), (array) $columns ) );
}

/**
 * [hasTableColumn description]
 * @param  [type]  $instance [description]
 * @param  [type]  $column   [description]
 * @return boolean           [description]
 */
function hasTableColumn($instance, $column) {
	return Schema::hasColumn( $instance->getTable(), $column );
}
