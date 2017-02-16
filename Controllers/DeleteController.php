<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 4.11.2016 г.
 * Time: 09:36 ч.
 */
class DeleteController
{
    public function deleteUser(&$user_id)
    {

        if(Validator::handleDigits($user_id))
        {
            $query="UPDATE `users` SET `is_delete`=:date,`id`=:id WHERE `id`=:id";
            $stmt=Connection::$connection->prepare($query);
            $curr_date = date('Y-m-d');
            $stmt->bindParam(":id", $user_id);
            $stmt->bindParam(":date",$curr_date );
            $stmt->execute();
            $affected_rows = $stmt->rowCount();

            return json_encode($affected_rows);
        }
        else if(!Validator::handleDigits($user_id))
        {
            return json_encode("Невалидно идентификационнен номер.");
        }
    }
}