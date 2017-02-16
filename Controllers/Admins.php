<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 11.11.2016 г.
 * Time: 11:34 ч.
 */
class Admins
{
    static function getAdmins()
    {
        $sql = "Select id,first_name,username FROM admins";
        $sth = Connection::$connection->prepare($sql);
        $sth->execute();
        $admins = $sth->fetchAll();
        return $admins;
    }


    static function updateAdmin(&$admin_id, &$username, &$password, &$first_name)
    {

        if (Validator::handleDigits($admin_id) && Validator::handleUsername($username) && Validator::handleCyrilicName($first_name) && Validator::handlePassword($password)) {
                $password= md5($password);
            $sql = "UPDATE `admins` SET `first_name` = :first_name,
                         `password` = :password,
                          `username`=:username 
                            WHERE `id` = :admin_id";
                    $stmt = Connection::$connection->prepare($sql);
                    $stmt->bindParam(":first_name", $first_name);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":admin_id", $admin_id);
                    $stmt->bindParam(":password",$password);
                    $stmt->execute();
                    $affected_rows = $stmt->rowCount();
                    return json_encode($affected_rows);
            }
        else
        {
            return json_encode(0);
        }
    }


    static function updateAdminWithoutPass(&$admin_id, &$username, &$first_name)
    {
        if (Validator::handleDigits($admin_id) && Validator::handleUsername($username) && Validator::handleCyrilicName($first_name)) {
            $sql = "UPDATE `admins` SET `first_name` = :first_name,`username`=:username 
                    WHERE `id` = :admin_id";
            $stmt = Connection::$connection->prepare($sql);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":admin_id", $admin_id);

            $stmt->execute();
            $affected_rows = $stmt->rowCount();
        
            return json_encode($affected_rows);
        }
        else
        {
            return json_encode(0);
        }

    }
}