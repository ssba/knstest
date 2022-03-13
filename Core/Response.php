<?php

namespace Core;


class Response
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

    public static function json($obj)
    {
        Response::getInstance()->_json($obj);
    }

    private function _json($obj) {
        echo json_encode($obj,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP |
            JSON_UNESCAPED_UNICODE |
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_SLASHES);
    }

}
