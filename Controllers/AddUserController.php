<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 7.11.2016 г.
 * Time: 16:19 ч.
 */
class AddUserController
{
    public function AddNewUser(&$first_name, &$middle_name, &$surname, &$birthday)
    {
        if (Validator::handleCyrilicName($first_name) && Validator::handleCyrilicName($middle_name) && Validator::handleCyrilicName($surname) && Validator::handleBirthdate($birthday)) {
            $stmt = Connection::$connection->prepare("INSERT INTO users (first_name,middle_name,surname,birthday) VALUES (?, ?,?,?)");


            $stmt->bindParam(1, $first_name);
            $stmt->bindParam(2, $middle_name);
            $stmt->bindParam(3, $surname);
            $stmt->bindParam(4, $birthday);
            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            return json_encode($affectedRows);
        }
    }
}