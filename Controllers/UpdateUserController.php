<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 3.11.2016 г.
 * Time: 16:58 ч.
 */
class UpdateUserController
{

    static function getUser(&$user_id)
    {
        $sql = "SELECT id,first_name, middle_name, surname, birthday FROM users WHERE id=:id";
        $sth = Connection::$connection->prepare($sql);
        $sth->execute(array(':id' => $user_id));
        $user = $sth->fetch();
        return $user;
    }

    public function updateUser(&$user_id, &$first_name, &$middle_name, &$surname, &$birthday)
    {
        if (!Validator::handleCyrilicName($middle_name) ||
            !Validator::handleCyrilicName($first_name) ||
            !Validator::handleCyrilicName($surname) ||
            !Validator::handleBirthdate($birthday)
        ) {
            return json_encode("Моля,въведете валидни данни.");
        } else if (Validator::handleCyrilicName($middle_name) &&
            Validator::handleCyrilicName($first_name) &&
            Validator::handleCyrilicName($surname) &&
            Validator::handleBirthdate($birthday)
        ) {

            $query = "UPDATE `users` SET `first_name` = :first_name,
 `middle_name` = :middle_name,
  `surname`=:surname,
  `birthday`= :birthday
    WHERE `id` = :user_id ";
            
            $stmt = Connection::$connection->prepare($query);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":middle_name", $middle_name);
            $stmt->bindParam(":surname", $surname);
            $stmt->bindParam(":birthday", $birthday);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $affected_rows = $stmt->rowCount();

            return json_encode($affected_rows);
        }
    }
}