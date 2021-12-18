<?php

namespace Max\Foundation;

if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
    return false;
}

require __DIR__ . "/vendor/autoload.php";

(new App(('cli' === PHP_SAPI) ? '../' : './'))->handle(function(App $app) {
    $http     = $app->http;
    $request  = $http->request();
    $response = $http->response($request);

    $http->end($response);
});
