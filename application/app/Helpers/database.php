<?php
/**
 * Get the array of columns
 * @return mixed
 */
function getTableColumns() {
    return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
}

/**
 * Exclude an array of elements from the result.
 * @param $query
 * @param $columns
 * @return mixed
 */
function exclude($query, $columns) {
    return $query->select(array_diff($this->getTableColumns(), (array) $columns));
}
