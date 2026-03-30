<?php
$host = 'localhost';
$db   = 'db_pagadmanzanillotaligatoshotelreservationsystem';
$user = 'root';
$pass = '';


try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
