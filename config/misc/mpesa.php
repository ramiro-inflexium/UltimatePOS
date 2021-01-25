<?php

return [
    'c2b' => [
        'sandbox' => [
            'short_code' => '600000',
            'validation_key'   => 'X3pcYw5b40ebvUK119ZpC0gtPQBhENIb',
            'confirmation_key'   => 'nU1hcmZ7BOu2l3tS6effhfBVIfWmJIdx',
            'consumer_secret' => 'A1ycuMIbxzYag8iX',
            'consumer_key'   => 'gQUWNBpqO7GlUNcVvjZv4jEHNUxRyVED',
            'endpoints'         => [
                'registration' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl'
            ],
        ],
        'live' => [
            'short_code' => '',
            'validation_key'   => '',
            'confirmation_key'   => '',
            'consumer_secret' => 'A1ycuMIbxzYag8iX',
            'consumer_key'   => 'gQUWNBpqO7GlUNcVvjZv4jEHNUxRyVED',
            'endpoints'         => [
                'registration' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl'
            ],
        ]
    ]
];
