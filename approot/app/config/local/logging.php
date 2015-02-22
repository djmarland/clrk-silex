<?php

use Monolog\Logger;

return [
    [
        'type' => 'Stream',
        'path' => __DIR__ . '/../../../log/development.log',
        'level' => Logger::DEBUG,
    ],
];
