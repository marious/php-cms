<?php

class Database
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec("SET NAMES 'utf8'");
            } catch (PDOException $e) {
                die($e->getMessage());
            }

            return self::$instance;
        }
    }
}