<?php

use Monolog\Logger;

return [
    [
        'type' => 'Stream',
        'path' => '/var/log/silex-app/debug.log',
        'level' => Logger::WARNING,
    ],
];
