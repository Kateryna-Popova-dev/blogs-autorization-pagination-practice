<?php

include_once __DIR__ . './config.php';

function connect(){
    try {
        static $connect = null;

        if (is_null($connect)) {

            $connect = new PDO('mysql:host=127.0.0.1; dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
        }
        return $connect;
    } catch (PDOException $exception) {
        return false;
    }
}
