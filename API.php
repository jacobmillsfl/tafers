<?php

session_start();
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("DAL/BlogLike.php");

Authentication::hasGeneralPermission();
$errors= array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = SessionManager::getUserId();
    $method = $_POST["method"];
    if ($method === "BlogLike") {
        $blogId = $_POST["blogId"];
        BlogLike::toggle($blogId,$userId);
        echo $blogId . " " . $userId;
    }
}
?>
