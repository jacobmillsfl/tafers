<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/FileUserViewModel.php");
include_once("DAL/FileCategory.php");

Authentication::checkFilePermissions();

$userId = SessionManager::getUserId();
$filename = null;
$fileCategoryId = null;
$pageNum = 0;

if (isset($_GET['content'])) {
    $filename = htmlspecialchars($_GET["content"]);
}

if (isset($_GET['fileCategoryId'])) {
    $fileCategoryId = htmlspecialchars($_GET["fileCategoryId"]);
}

if (isset($_GET['page'])) {
    $pageNum = htmlspecialchars($_GET["page"]);
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>



<!-- Page Content -->
<section id="FileHome" class="content-section-a">

    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">TAFers
            <small>File Home</small>
        </h1>
        <ol class="breadcrumb">

        </ol>
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- uses the loadall() method from Blog.php to dynamically load blog images, titles, contents, dates, and user IDs -->
                <?php
                $viewmodel = FileUserViewModel::loadFileHome($filename,$fileCategoryId,$pageNum);
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
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul>
                <!-- Pagination Example
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul> -->

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <div class ="text-center">
                <a href="upload.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>Upload File</a>
                </div>
                <br>

                <!-- Search Widget -->
                <form action="filehome.php" method="GET">
                    <div class="card mb-4">
                        <h5 class="card-header">Search</h5>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                              <button class="btn btn-secondary" type="submit">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </form>


                <!-- Categories Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Categories</h5>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $FileCategoryList = FileCategory::loadall();
                            foreach ($FileCategoryList as $blogcategory){
                                ?>
                                <div class="col-lg-6">
                                    <a href="filehome?fileCategoryId=<?php echo $blogcategory->getId(); ?>"><?php echo $blogcategory->getName(); ?></a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
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