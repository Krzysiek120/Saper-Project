<?php

class Db
{
    protected static $instance;
    protected $pdo;

    public function __construct()
    {

        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=" . 'saperProject', 'root', 'coderslab');
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    protected function __clone()
    {
    }

    public static function getInstance() 
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function getPdo()
    {
        return $this->pdo;
    }
}

