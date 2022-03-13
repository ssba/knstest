<?php

namespace Core;

use Core\DB;
use PDO;
use PDOException;

class Auth
{
    static private $instance = null;


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public static function login(string $username, string $password, bool $remember = false)
    {
        return Auth::getInstance()->_login($username, $password, $remember);
    }

    public static function logout()
    {
        return Auth::getInstance()->_logout();
    }

    public static function auth()
    {
        Auth::getInstance()->_auth();
    }

    private function _login(string $username, string $password, bool $remember = false)
    {
        $account = DB::fetch( "SELECT * FROM `api_users` WHERE username = :username", ["username" =>  $username] );

        if($account != NULL) {
            if (password_verify($password, $account['password'])){

                $responce = [
                    "auth" => true
                ];

                if($remember){
                    $query_args = [
                        "username" =>  $username,
                        "token" => sha1(openssl_random_pseudo_bytes(64))
                    ];
                    DB::execute( "UPDATE `api_users` SET token = :token WHERE username = :username", $query_args);
                    $responce['token'] = $query_args['token'];
                }

                return $responce;
            } else {
               throw new \Exception("", 401);
            }
        } else {
            throw new \Exception("", 401);
        }
    }

    private function _auth()
    {
        $token = $this->getBearer();
        if(is_null($token)){
            throw new \Exception("", 401);
        }

        $query_args = [
           "token" =>  $token
        ];

        $request = DB::fetch( "SELECT * FROM `api_users` WHERE token = :token", $query_args );

        if(!$request){
            throw new \Exception("", 401);
        }
    }

    private function _logout()
    {
        $token = $this->getBearer();
        if(is_null($token)){
            return true;
        }

        $query_args = [
            "token" =>  $token
        ];
        DB::execute( "UPDATE `api_users` SET token = NULL WHERE token = :token", $query_args);

        return true;
    }

    private function getBearer() {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $header = trim($_SERVER["HTTP_AUTHORIZATION"]);

            if (!empty($header)) {
                if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                    return $matches[1];
                }
            }
        }

        return null;
    }
}
