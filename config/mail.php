<?php

return [

    'driver' => env('MAIL_MAILER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.gmail.com'),

    'port' => env('MAIL_PORT', 587),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'example@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    'username' => env('MAIL_USERNAME', 'example@gmail.com'),

    'password' => env('MAIL_PASSWORD', 'your-gmail-password'),

    'sendmail' => '/usr/sbin/sendmail -bs',

    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
