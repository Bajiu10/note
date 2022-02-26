<?php

return [
    'handler' => 'Max\Session\Handlers\File',
    'options' => [
        'path'          => base_path('storage/session'),
        'gcDivisor'     => 100,
        'gcProbability' => 1,
        'gcMaxLifetime' => 1440,
    ],
];
