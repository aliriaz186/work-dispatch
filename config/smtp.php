<?php
return [
    'gmail' => [
        'Host' => env('GMAIL_SMTP_HOST', 'smtp.gmail.com'),
        'Port' => 587,
        'SMTPSecure' => 'tls',
        'SMTPAutoTLS' => false,
        'From' => 'task.board007@gmail.com',
        'Timeout' => 5,
        'Username' => 'task.board007@gmail.com',
        'Password' => 'Toystory@123',
    ]
];
