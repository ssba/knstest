<?php

session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Autoload.php';

$autoloader = new Autoload();
$autoloader->addNamespace('Exceptions', __DIR__ . '/Exceptions');
$autoloader->addNamespace('Core', __DIR__ . '/Core');
$autoloader->addNamespace('App', __DIR__ . '/App');
$autoloader->register();

try{

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }


    $app = new Core\Application();
    $responce = $app->run();

    Core\Response::json($responce);
}catch (\Exception $exception){
    http_response_code( $exception->getCode() );
    $result = [
        "code" => $exception->getCode(),
        "error" => $exception->getMessage()
    ];
    Core\Response::json($result);
}
