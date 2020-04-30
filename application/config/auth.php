<?php

return [

    'guards' => [

        'api' => [
            'driver' => 'jwt', // Adding Custom Guards
            'driver' => 'custom-token', // custom Request Guards
            'provider' => 'users',
        ],
    ],

    'providers' => [
	    'users' => [
	        'driver' => 'riak', // custom provider
	    ],
	],

];
