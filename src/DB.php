<?php

namespace Quantox;

use PDO;

class DB {
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    // The db connection is established in the private constructor.
    private function __construct()
    {
        $db_host = getenv('DB_HOST');
        $db_user = getenv('DB_USER');
        $db_pass = getenv('DB_PASS');
        $db_name = getenv('DB_NAME');
        $this->conn = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user,$db_pass,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}