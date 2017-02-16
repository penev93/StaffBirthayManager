<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 4.11.2016 г.
 * Time: 09:37 ч.
 */
class Connection
{
    /**/

    static $connection;

    static function init()
    {
        $dsn = 'mysql:dbname=' . DATABASE_NAME . ';host=' . DATABASE_HOST . ';charset=utf8';
        $user = DATABASE_USER;
        $password = DATABASE_PASSWORD;

        try {
            self::$connection = new PDO($dsn, $user, $password);
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}