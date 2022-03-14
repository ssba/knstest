<?php

namespace Core;


use Exceptions\NotFoundException;

class Application
{

    private $request = null;
    private $requestData = null;
    private $controller = null;
    private $method = null;

    private $routes = [
        'post' => [
            "/auth" => "App\UserController@login",
        ],
        'get' => [
            "/users" => "App\UserController@getListPaginated"
        ],
        'delete' => [
            "/auth" => "App\UserController@logout"
        ]
    ];


    public function __construct()
    {
        $this->request = parse_url($_SERVER['REQUEST_URI']);

        parse_str(file_get_contents("php://input"), $POSTDATA);
        $this->requestData = array_merge($_GET, $_POST, $POSTDATA);

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        foreach ($this->routes[$method] as $route => $controller) {

            $route = trim($route, "//");

            $pattern = "/^\/*" . str_replace(['/', '{guid}', '{id}'], ['\/'], $route) . "\/*$/";

            if (preg_match($pattern, $this->request['path'], $matches, PREG_OFFSET_CAPTURE)) {

                $controller = explode("@", $controller);

                $this->controller = $controller[0];
                $this->method = $controller[1];

                break;
            }
        }

        if (empty($this->controller)){
            throw new NotFoundException();
        }


    }

    public function run()
    {
        try{
            $controller = new $this->controller;

            return call_user_func_array(array($controller, $this->method), $this->requestData);
        }catch (\Exception $exception){
            throw $exception;
        }
    }
}
