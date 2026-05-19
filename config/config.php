<?php

return [
    'db' => [
        'host'     => 'mysql',
        'port'     => '3306',
        'name'     => $_ENV['DOCKER_NAME']             ?? 'bblog',
        'user'     => 'root',
        'password' => $_ENV['DOCKER_MYSQL_PASSWORD']   ?? 'secret',
    ],
    'smarty' => [
        'templates'   => __DIR__ . '/../templates',
        'compiled'    => __DIR__ . '/../templates_c',
        'cache'       => __DIR__ . '/../cache',
    ],
    'pagination' => [
        'per_page' => 6,
    ],
];
