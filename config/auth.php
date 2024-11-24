<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

    

        'admin' => [
        'driver' => 'session',
        'provider' => 'admins', // Asegúrate de que este proveedor existe
    ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class, // Cambia por tu modelo de admin
    ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


    ],
    

    'password_timeout' => 10800,

];
