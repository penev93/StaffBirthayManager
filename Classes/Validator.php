<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 27.10.2016 г.
 * Time: 11:03 ч.
 */
class Validator
{

    static function handleCyrilicNames($names)
    {
        /*This function check First and Family
        Names do they contain only cyrilic */

        $pattern = "/^[а-яА-Я ]+$/u";
        $areNamesTrue = preg_match_all($pattern, $names);

        //return 0 if not match 1 if it match
        return $areNamesTrue;
    }


    static function handleReceiptSerial($data)
    {
        $pattern = "/^[1-9]{10}$/";
        $isSerialTrue = preg_match_all($pattern, $data);

        //return 0 if not match 1 if it match
        return $isSerialTrue;
    }

    static function handleStotinka($data)
    {
        $pattern = "/^[0-9]{1,2}$/";
        $isStotinkaTrue = preg_match_all($pattern, $data);
        //return 0 if not match 1 if it match
        return $isStotinkaTrue;
    }

    static function handleLeva($data)
    {
        $pattern = "/^[0-9]+$/";
        $isLevaTrue = preg_match_all($pattern, $data);
        //return 0 if not match 1 if it match
        return $isLevaTrue;
    }

    static function handleEmail($data)
    {
        $pattern = "/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$/";
        $isLevaTrue = preg_match_all($pattern, $data);
        //return 0 if not match 1 if it match
        return $isLevaTrue;
    }

    static function handlePhone($data)
    {
        $data = trim($data);
        $pattern = "/^((\\+|[0])\\d{1,13})$/";
        $isPhoneTrue = preg_match_all($pattern, $data);
        //return 0 if not match 1 if it match
        return $isPhoneTrue;
    }

    static function handleCheckbox($data)
    {

        if ($data === 'false') {
            return false;
        } else {
            return true;
        }


    }


    static function handlePassword($data)
    {
        $pattern = "/^([\\w\\d!@#$%^&*?]{6,14})$/";

        $isMatch = preg_match_all($pattern, $data);
        if ($isMatch) {
            return 1;
        } else {
            return 0;
        }
    }

    static function handleUsername($data)
    {
        $pattern = "/^([\\w\\d!@#$%^&*?]{6,14})$/";

        $isMatch = preg_match_all($pattern, $data);
        /*if matches correct*/
        if ($isMatch) {
            return 1;
        } else {
            return 0;
        }
    }

    static function handleCyrilicName($name)
    {
        /*This function check signle name type
        Names do they contain only cyrilic */

        $pattern = "/^([а-яА-Я]{1,32})$/u";
        $areNamesTrue = preg_match_all($pattern, $name);

        //return 0 if not match 1 if it match
        return $areNamesTrue;
    }

    static function handleBirthdate($date)
    {
        //validate date with format 1993-10-10
        $pattern = "/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/";
        $isBirthdateTrue = preg_match_all($pattern, $date);
        return $isBirthdateTrue;
    }

    static function handleDigits($data)
    {
        $pattern = "/^[1-9]+$/";
        $isDigits = preg_match_all($pattern, $data);
        return $isDigits;
    }
}