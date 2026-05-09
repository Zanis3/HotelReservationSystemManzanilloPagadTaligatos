<?php

class Database
{
    private $host = 'localhost';
    private $db = 'db_pagadmanzanillotaligatoshotelreservationsystem';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';
    protected $pdo;

    public function __construct()
    {
        //GET THE TIME IN PH TIME ZONE
        date_default_timezone_set("Asia/Manila");

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            return $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
