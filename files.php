<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/FileUserViewModel.php");

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
        $viewmodel = FileUserViewModel::loadFileHome();
        foreach($viewmodel as $file)
        {
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="media mb-4">
                        <img style="max-height: 50px;max-width: 50px;" class="d-flex mr-3 rounded-circle blogComment" src="<?php echo $file->getImgUrl(); ?>" alt="Icon">
                        <div class="media-body">

                            <div class="row">
                                <div class="col-3">
                                    <h3 style="margin-bottom:0px;"><?php echo $file->getUsername(); ?></h3>
                                </div>
                                <div class="col-6"></div>
                                <div class="col-3">
                                    <small class="float-right"><?php echo $file->getUploadDate(); ?></small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3 ml-auto">
                            <p>Upload IP:  <?php echo $file->getUploadIP(); ?></p>
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
                                <p>
                                    <?php
                                    if ($file->getIsPublic() == 1){
                                    echo "<a href=\"http://tafers.net/files/" . $file->getFileName() . "\">" . $file->getFileName() ."</a>";
                                } else {
                                    echo "<a href=\"http://tafers.net/download.php?fid=" . $file->getFileId() . "\">" . $file->getFileName() ."</a>";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
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