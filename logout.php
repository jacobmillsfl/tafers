<?php
/**
 * Author: Jacob Mills
 * Date: 03/06/2018
 * Description: Navigation to this page should logout the current user and redirect to the login page.
 */


session_start();
session_unset();
header('location:/login.php');