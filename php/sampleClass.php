<?php
/**
 * PHP sample class
 */
class sampleClass
{

	function __construct()
	{

	}

	public function where($column)
	{
		return $this;
	}

	public function __call($method, $parameters)
	{
		$query = $this->newQuery(); // create builder object
		return call_user_func_array( [ $query, $method ], func_get_args() ); // call builder methods -> where()
	}

	public static function __callStatic($method, $parameters)
	{
		$instance = new static; // create new instance of the model class
		return call_user_func_array( [ $instance, $method ], $parameters ); // call method with parameter
	}
}

sampleClass::bar('param1'); // __callStatic
