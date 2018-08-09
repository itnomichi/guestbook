<?php

class DB
{
    public static function open()
    {
        try {
            $host = DB_HOST;
            $db = DB_DATABASE;
            $user = DB_USERNAME;
            $pass = DB_PASSWORD;
            $charset = 'utf8';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, $user, $pass, $opt);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $pdo;
    }
}