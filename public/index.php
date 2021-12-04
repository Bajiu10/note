<?php

namespace Max\Foundation;

require __DIR__ . '/../vendor/autoload.php';

(new App())->start(function(App $app) {
    $http     = $app->http;
    $request  = $http->request();
    $response = $http->response($request);

    $http->end($response);
});
