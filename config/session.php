<?php

return [
    'handler' => 'Max\Session\Handlers\Cache',
    'options' => [
        'ttl' => 3600,
        //        'path'          => base_path('storage/session'),
        //        'gcDivisor'     => 100,
        //        'gcProbability' => 1,
        //        'gcMaxLifetime' => 1440,
    ],
];
