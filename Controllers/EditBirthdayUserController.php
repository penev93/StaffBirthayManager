<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 8.11.2016 г.
 * Time: 15:17 ч.
 */
class EditBirthdayUserController
{

    /*static function create*/

    static function checkBirthday(&$gift_id)
    {
        //TOODO
        $query = "SELECT u.id, u.first_name,u.middle_name,u.surname,g.price,ug.note,ug.is_active,ug.is_paid,g.lock_birthday
                FROM users AS u
                LEFT JOIN users_gifts AS ug ON ug.user_id_from=u.id
                LEFT JOIN gifts AS g on ug.gift_id=g.id
                WHERE ug.gift_id=:gift_id "; /*AND u . is_delete IS NULL */
        $userQ = " SELECT u.first_name,u.surname FROM users  AS u LEFT JOIN gifts AS g ON u.id=g.user_id WHERE g.id=:gift_id ";

        $stmt = Connection::$connection->prepare($query);
        $stmtUser = Connection::$connection->prepare($userQ);
        $stmtUser->execute(array(':gift_id' => $gift_id));
        $stmt->execute(array(':gift_id' => $gift_id));
        $user['connections'] = $stmt->fetchAll();
        $data = $stmtUser->fetchAll();
        $user['birthday_boy'] = $data;
        return $user;
    }

    static function load(&$gift_id)
    {
        $isBirthdayExists = self::checkBirthday($gift_id);
        return $isBirthdayExists;
    }

    static function LockBirthday(&$gift_id, &$price, &$users_id_is_active)
    {
        $query_users_active = "";
        //TODO set active and not active foreach all possible elements
        $query = "UPDATE `gifts` SET `lock_birthday` = :lock_birthday, `price`= :price WHERE `id` = :gift_id ;";
        foreach ($users_id_is_active as $user_data) {
            $isTrueOne = (($user_data['is_active'] == 'true') ? 1 : 0);
            $query_users_active .= " UPDATE `users_gifts` SET `is_active`='" . $isTrueOne . "' WHERE `gift_id`=:gift_id AND `user_id_from`=" . $user_data['id'] . "; ";
        }
        $query .= $query_users_active;

        $stmt = Connection::$connection->prepare($query);
        $curr_date = date('Y-m-d');
        $stmt->execute(array(":lock_birthday" => $curr_date, ":price" => $price, ":gift_id" => $gift_id));

        $affectedRows = $stmt->rowCount();
        return json_encode($affectedRows);
    }

    static function InsertPayment(&$user_id, &$gift_id, &$is_paid)
    {

        $query = "UPDATE `users_gifts` SET  `is_paid`= :is_paid WHERE `gift_id` = :gift_id AND `user_id_from` = :user_id_from";

        $stmt = Connection::$connection->prepare($query);
        $stmt->execute(array(":user_id_from" => $user_id, ":gift_id" => $gift_id, ":is_paid" => $is_paid));
        $affectedRows = $stmt->rowCount();
        return json_encode($affectedRows);
    }

    static function AddNoteRoute(&$note, &$user_from_id, &$gift_id)
    {
        $query = "UPDATE `users_gifts` SET  `note`= :note WHERE `gift_id` = :gift_id AND `user_id_from`=:user_id_from";
        $stmt = Connection::$connection->prepare($query);
        $stmt->execute(array(":user_id_from" => $user_from_id, ":gift_id" => $gift_id, ":note" => $note));
        $affectedRows = $stmt->rowCount();
        return json_encode($affectedRows);
    }

    static function getNotes(&$user_from_id, &$gift_id)
    {
        $query = "SELECT `note` from `users_gifts` WHERE `gift_id`=:gift_id AND user_id_from=:user_from_id;";
        $stmt = Connection::$connection->prepare($query);
        $stmt->execute(array(":user_from_id" => $user_from_id, ":gift_id" => $gift_id));
        $note = $stmt->fetch();

        return json_encode($note);
    }

}