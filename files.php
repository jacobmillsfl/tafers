<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/File.php");

Authentication::checkFilePermissions();

?>


<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>



<!-- Page Content -->
<section id="Files" class="content-section-b mt-3">

    <div class="container">

        <?php
        $files = File::loadall();

        foreach($files as $file)
        {
            ?>
            <div class="row">
                <div class="col-lg-3 ml-auto">
                    <p>File ID: <?php echo $file->getId(); ?></p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>Uploaded By: <?php echo $file->getUserId(); ?></p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>File Name: <?php echo $file->getFileName(); ?></p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>Upload IP: <?php echo $file->getUploadIP(); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 ml-auto">
                    <p>Upload Date: <?php echo $file->getUploadDate(); ?></p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>File Extension: <?php echo $file->getFileExtension(); ?></p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>File Size: <?php echo $file->getFileSize(); ?> bytes</p>
                </div>
                <div class="col-lg-3 ml-auto">
                    <p>File Type: <?php echo $file->getFileType(); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ml-auto">
                    <p>URL:
                        <?php
                            if ($file->getIsPublic() == 0){
                                echo "<a href=\"http://tafers.net/files/" . $file->getFileName() . "\">" . $file->getFileName() ."</a>";
                            } else {
                                echo "<a href=\"http://tafers.net/download.php?fid=" . $file->getId() . "\">" . $file->getFileName() ."</a>";
                            }
                        ?>

                    </p>
                </div>
            </div>

            <hr>
        <?php
        }
        ?>


    </div>
    <!-- /.container -->
</section>

<!-- Footer -->
<?php

include('footer.php');

?>

</body>
</html>