<?php
/*
 * Author:      Jacob Mills
 * Date:        10/16/2017
 * Description: This utility provides static functions to implement centralized accessor/mutator methods for all session values.
 *
 */

class SessionManager
{

/*  Examples

    public static function getTestMessage() {
        if (isset($_SESSION['msg']))
            return $_SESSION['msg'];
        else
            return "";

    }

    public static function setTestMessage($arg1){
        $_SESSION['msg'] = $arg1;
    }
*/


    public static function getUserId() {
        if (isset($_SESSION['userId']))
            return $_SESSION['userId'];
        else
            return 0;

    }

    public static function setUserId($arg1){
        $_SESSION['userId'] = $arg1;
    }

}

