<?php

session_start();

include_once("DAL/File.php");
include_once("Utilities/SessionManager.php");

if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $tmp = explode('.',$file_name);
    $file_ext=strtolower(end($tmp));

    //$expensions= array("zip","tar","7z",);

    //if(in_array($file_ext,$expensions)=== false){
    //    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    //}

    // Enable large file uploads
    if($file_size > 2147483648) {
        $errors[]='File size must be less than 2 GB';
    }

    if(empty($errors)==true) {
        $success = move_uploaded_file($file_tmp,"files/".$file_name);

        if ($success)
        {
            // Save to database
            $currentDate = date('Y-m-d H:i:s');
            $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                    getenv('HTTP_X_FORWARDED')?:
                        getenv('HTTP_FORWARDED_FOR')?:
                            getenv('HTTP_FORWARDED')?:
                                getenv('REMOTE_ADDR');


            $userId = SessionManager::getUserId();
            echo $userId;
            $file = new File();
            $file->setUserId($userId);
            $file->setFileName($file_name);
            $file->setFileSize($file_size);
            $file->setFileExtension($file_ext);
            $file->setFileType($file_type);
            $file->setUploadDate($currentDate);
            $file->setUploadIP($ip);
            $file->save();
        }

        echo $success == true ? "success" : "unsuccessful";
    }else{
        print_r($errors);
    }


}
?>
<html>
<body>

<form action = "" method = "POST" enctype = "multipart/form-data">
    <input type = "file" name = "file" />
    <input type = "submit"/>
    <?php if (isset($_FILES['file'])): ?>
    <ul>
        <li>Sent file: <?php echo $_FILES['file']['name'];  ?>
        <li>File size: <?php echo $_FILES['file']['size'];  ?>
        <li>File type: <?php echo $_FILES['file']['type'] ?>
    </ul>

    <?php endif ?>
</form>

</body>
</html>