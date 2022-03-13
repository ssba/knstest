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
