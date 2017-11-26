<?php
if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

    //$expensions= array("zip","tar","7z",);

    //if(in_array($file_ext,$expensions)=== false){
    //    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    //}

    // Enable large file uploads
    if($file_size > 2147483648) {
        $errors[]='File size must be less than 2 GB';
    }

    if(empty($errors)==true) {
        move_uploaded_file($file_tmp,"files/".$file_name);
        echo "Success";
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
    <?php if (isset($_POST['file'])): ?>
    <ul>
        <li>Sent file: <?php echo $_FILES['file']['name'];  ?>
        <li>File size: <?php echo $_FILES['file']['size'];  ?>
        <li>File type: <?php echo $_FILES['file']['type'] ?>
    </ul>

    <?php endif ?>
</form>

</body>
</html>