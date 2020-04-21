# PHP

## string
```php
if ( is_null( $val ) ) { }
if ( is_string( $val ) ) { }
if ( strpos( $val, '.' ) === false ) { }
```

## Number
```php
if ( is_numeric( $val ) ) { }
```
## class
```php
// check variable is instanceof the closure -> function() {}
if ( $var instanceof Closure ) { }
```

## function
```php
# check no of parameters passed
if ( func_num_args() == 2 ) { }

// optional array
function func( $array = array() ) { }
// array argument
function func(array $array ) { }
// closure argument -> function() { }
function func(Closure $array ) { }
```

## array
```php
# check is_array
if ( is_array( $column ) ) { }

list( $val, $key ) = [ 'vignesh', 'name' ];

if ( array_key_exists( $key, $array ) ) { }
```
