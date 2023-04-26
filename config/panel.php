<?php

return [
    'date_format'               => 'F j, Y',
    'time_format'               => 'g:i a',
    'primary_language'          => 'ar',
    'available_languages'       => [
        'ar' => 'العربية',
        'en' => 'English',
    ],
    'colors' => [
        'delivery_status' => [
            'primary' => 'pending',
            'secondary' => 'on_review',
            'secondary' => 'on_delivery',
            'success' => 'delivered',
            'warning' => 'delay',
            'danger' => 'cancel',
        ],
        'payment_status' => [
            'success' => 'paid',
            'secondary' => 'un_paid',
        ],
        'playlist_status' => [
            'primary' => 'pending',
            'secondary' => 'design',
            'secondary' => 'manufacturing',
            'warning' => 'prepare',
            'danger' => 'send_to_delivery',
            'success' => 'finish',
        ],
    ]
];
