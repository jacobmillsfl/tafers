<?php
/*
 * Author:      Jacob Mills
 * Date:        10/16/2017
 * Description: This utility provides static functions to implement centralized accessor/mutator methods for all session values.
 *
 */

class SessionManager
{
    // User ID
    public static function getUserId() {
        if (isset($_SESSION['userId']))
            return $_SESSION['userId'];
        else
            return 0;

    }

    public static function setUserId($arg1){
        $_SESSION['userId'] = $arg1;
    }

    // User Name
    public static function getUserName() {
        if (isset($_SESSION['userName']))
            return $_SESSION['userName'];
        else
            return "";

    }

    public static function setUserName($arg1){
        $_SESSION['userName'] = $arg1;
    }

    // User Role ID
    public static function getUserRoleId() {
        if (isset($_SESSION['roleId']))
            return $_SESSION['roleId'];
        else
            return 0;

    }

    public static function setRoleId($arg1){
        $_SESSION['roleId'] = $arg1;
    }

    

    // Clear Session Variables
    public static function clearSessionVars() {
        self::setUserId(0);
        self::setRoleId(0);
        self::setUserName("");
    }
}

