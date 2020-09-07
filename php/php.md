# PHP

## Issues
Memory limit problems
 /etc/php/7.2/apache2/php.ini
c:/xampp/php/php.ini
```php
;memory_limit=1024MB
memory_limit=-1
```

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

# get class name from instance
get_class($user); // App/User
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
list( $val, $key ) = [ 'vignesh', 'name' ];

# check
is_array( $column )
array_key_exists( $key, $array )

# Modify/convert each values in a array
array_map('strtoupper', $array); // ['key'=>'value'] >>> ['key'=>'VALUE']
```
