<?php
    /*include_once HOME_DIR."/Classes/Validator.php";*/

class LoginController
{

    public function ValidateLoginUser(&$username, &$password)
    {
        $errors = "";
        $userValidation = Validator::handleUsername($username);
        $passValidation = Validator::handlePassword($password);

        if (!$userValidation || !$passValidation) {
            $userValidation == false ? $errorArray[] = "Невалиден потребител." : $errorArray[] = "";
            $passValidation == false ? $errorArray[] = "Невалидна парола." : $errorArray[] = "";
            if (!$userValidation) {
                $errors .= "Невалиден потребител.";
            }
            if (!$passValidation) {
                $errors .= "<br/>Невалидна парола.";
            }
            return $errors;
        }

        $sql = "Select username FROM admins WHERE username = :username AND password = :password";
        $sth = Connection::$connection->prepare($sql);
        $sth->execute(array(':username' => $username, ':password' => md5($password)));
        $user = $sth->fetch();
        return $user;
    }

    public function Logout()
    {
        session_destroy();
    }
}

