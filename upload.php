<?php

session_start();

include_once("DAL/File.php");
include_once("DAL/FileCategory.php");
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");

Authentication::hasGeneralPermission();

$maxFileSize = 2147483648; // Roughly 2 GB
$errors= array();
$file_name = "";
$file_size = "";
$file_type = "";
$file_ext= "";

$userId = SessionManager::getUserId();
$currentDate = date('Y-m-d H:i:s');
$ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
            getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                    getenv('REMOTE_ADDR');
$isPublic = false;
$file = new File();

if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $tmp = explode('.',$file_name);
    $file_ext=strtolower(end($tmp));
    $isPublic = isset($_POST['filePublic']) ? 1 : 0;
    $cat = !isset($_POST['filecategory']) ? 0 : $_POST['filecategory'];

    // Validation

    //$expensions= array("zip","tar","7z",);
    //if(in_array($file_ext,$expensions)=== false){
    //    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    //}

    // Enable large file uploads
    if($file_size > $maxFileSize) {
        $errors[]='File size must be less than 2 GB';
    }
    else if ($file_size == 0) {
        $errors[]='No file selected';
    }

    // Validate category ID
    $validCategoryID = false;
    $categories = FileCategory::loadall();
    foreach ($categories as $category) {
        if ($category->getId() == $cat){
            $validCategoryID = true;
            break;
        }
    }

    if (!$validCategoryID) {
        $errors[]="Invalid File Category ID";
    }

    // If no errors attempt upload
    if(empty($errors)==true) {
        if ($isPublic == 1)
        {
          if (file_exists("files/".$file_name)) {
            $errors[]="A file with that name already exists.";
            $success = false;
          } else {
            $success = move_uploaded_file($file_tmp,"files/".$file_name);
          }
        }
        else
        {
          if (file_exists("../privateFiles/".$file_name)) {
            $errors[]="A file with that name already exists.";
            $success = false;
          } else {
            $success = move_uploaded_file($file_tmp,"../privateFiles/".$file_name);
          }
        }



        if ($success)
        {
            // Save to database
            $file->setUserId($userId);
            $file->setFileName($file_name);
            $file->setFileSize($file_size);
            $file->setFileExtension($file_ext);
            $file->setFileType($file_type);
            $file->setUploadDate($currentDate);
            $file->setUploadIP($ip);
            $file->setIsPublic($isPublic);
            $file->setCategoryTypeId($cat);
            $file->save();
        }
        else
        {
            $errors[]='Unable to create file. Please check system permissions.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>

<!-- Page Content -->
<section id="Upload" class="content-section-b">

    <div class="container">

        <?php
        if(empty($errors)==false){
            foreach($errors as $err){
                echo "<div class=\"row\">";
                echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" style=\"width:100%;\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
                echo "<span aria-hidden=\"true\">&times;</span>";
                echo "</button>";
                echo "<strong>Error</strong> " . $err;
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
        <div class="row mt-lg-5">
            <div class="col-lg-12 ml-auto">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 mt-2" >
                            <label for="fileInput">File</label><br/>
                            <input id ="fileInput" type = "file" name = "file" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize; ?>">
                        </div>

                        <div class="col-lg-6 mt-2" >
                            <div class="controls">
                                <label for="filecategory">File Category</label>
                                <br/><small>Please Enter a the category that this file falls under.</small>
                                <select name="filecategory" id="filecategory" class="form-control" style="height:34px !important;">
                                    <option value="0">--Select Category--</option>
                                    <?php
                                    $categories = FileCategory::loadall();
                                    foreach ($categories as $category) {
                                        echo "<option value=\"" . $category->getId() . "\">" . $category->getName() . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2" >
                            <label for="filePublic">Is Public?</label><br/>
                            <input id="filePublic" type="checkbox" name ="filePublic" />
                        </div>
                        <div class="col-lg-12 mt-5">
                            <button type="submit" class="btn btn-primary btn-block float-left">Upload</button>
                        </div>
                    </div>
                    <br/><br/><br/><br/>
                    <?php if (isset($_FILES['file']) && empty($errors)==true): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>File Statistics</h3><br/>
                            <ul>
                                <li>UserID: <?php echo $file->getUserId();  ?>
                                <li>User: <?php echo SessionManager::getUserName();  ?>
                                <li>FileName: <?php echo $file->getFileName();  ?>
                                <li>FileSize: <?php echo $file->getFileSize();  ?>
                                <li>FileExtension: <?php echo $file->getFileExtension();  ?>
                                <li>FileType: <?php echo $file->getFileType();  ?>
                                <li>UploadDate: <?php echo $file->getUploadDate();  ?>
                                <li>UploadIP: <?php echo $file->getUploadIP();  ?>
                                <li>IsPublic: <?php echo $file->getIsPublic() == 1 ? "Yes" : "No";  ?>

                            </ul>
                        </div>
                    </div>
                    <?php elseif (empty($errors)==false): ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Errors</h3><br/>
                                <?php
                                    echo "<ol>";
                                    foreach ($errors as $error)
                                    {
                                        echo "<li>" . $error . "</li>";
                                    }
                                    echo "</ol>";
                                ?>
                            </div>
                        </div>
                    <?php endif ?>

                </form>
            </div>
        </div>

    </div>
    <!-- /.container -->
</section>

<!-- Footer -->
<?php

include('footer.php');

?>

</body>
</html>
