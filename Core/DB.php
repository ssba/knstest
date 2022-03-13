<?php

namespace Core;

use PDO;
use PDOException;

class DB
{
    static private $instance = null;

    private $connection = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
            try {
                $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=UTF8", DB_HOST, DB_PORT, DB_NAME);

                self::$instance->connection = new PDO($dsn, DB_USER, DB_PASSWORD);
                self::$instance->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public static function fetch(string $sql, array $args)
    {
        return DB::getInstance()->_fetch($sql, $args);
    }

    public static function execute(string $sql, array $args)
    {
        DB::getInstance()->_execute($sql, $args);
    }

    public static function query(string $sql) : array
    {
        return DB::getInstance()->_query($sql);
    }

    public static function queryAll(string $sql) : array
    {
        return DB::getInstance()->_queryAll($sql);
    }

    private function _query(string $sql) {
        $statement = $this->connection->query($sql, \PDO::FETCH_ASSOC);
        $data = $statement->fetch();

        return $data;
    }

    private function _queryAll(string $sql) {
        $statement = $this->connection->query($sql, \PDO::FETCH_ASSOC);
        $data = $statement->fetchAll();

        return $data;
    }

    private function _execute(string $sql, array $args) {
        $statement = $this->connection->prepare($sql);
        $statement->execute($args);
    }

    private function _fetch(string $sql, array $args) {
        $statement = $this->connection->prepare($sql);
        $statement->execute($args);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
}
