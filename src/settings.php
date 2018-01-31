<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // establecer en falso en producción
        'addContentLengthHeader' => false, // Permitir que el servidor web envíe el encabezado de longitud del contenido

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Eloquent settings
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'Alquileres',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];
