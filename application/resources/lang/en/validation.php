<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'email' => [
            'required' => 'We need to know your e-mail address!',
        ],
        'person.*.email' => [
	        'unique' => 'Each person must have a unique e-mail address',
	    ]
    ],

    # Renamed validation field message
	'attributes' => [
	    'email' => 'email address',
	],

	'values' => [
	    'payment_type' => [
	        'cc' => 'credit card'
	    ],
	],
];
