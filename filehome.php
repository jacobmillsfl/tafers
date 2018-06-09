<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/File.php");
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

$errors= array();
if (isset($_GET["delete"]) && Authentication::hasAdminPermission()) {
    $deleteFileId = $_GET["delete"];
    $f = new File($deleteFileId);
    if ($f->getIsPublic() == 1){
        $fname = "files/" . $f->getFileName();
    } else {
        $fname = "../privateFiles/" . $f->getFileName();
    }
    if (unlink($fname)) {
      File::remove($deleteFileId);
    } else {
      $errors[] = "Unable to remove file " . $f->getFileName();
    }
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
        <h1 class="mt-4 mb-3">File Home
            <small>A place for TAFer data...</small>
        </h1>
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
        <div class="row">
            <div class="col-md-8">
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
                                <div class="col-lg-9 ml-auto">
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
                                <div class="col-lg-3">
                                  <?php
                                    if (Authentication::hasAdminPermission())
                                    // Button trigger modal
                                    echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal" . $file->getFileId() . "\">Delete</button>";
                                  ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <?php
                      if (Authentication::hasAdminPermission())
                      echo "<div class=\"modal fade\" id=\"deleteModal" . $file->getFileId() . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deleteModalLabel" . $file->getFileId() . "\" aria-hidden=\"true\">";
                    ?>

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete this file? This action cannot be undone.
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <?php
                              if (Authentication::hasAdminPermission())
                              echo "<a href=\"filehome.php?delete=" . $file->getFileId() . "\" class=\"btn btn-danger\"><i class=\"glyphicon glyphicon-remove\"></i>&nbsp;Delete</a>";
                            ?>
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
                <div class ="text-center">
                    <a href="filehome.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Reset Filter</a>
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
                                    <a href="filehome.php?fileCategoryId=<?php echo $blogcategory->getId(); ?>"><?php echo $blogcategory->getName(); ?></a>
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
</section>
<?php
include('footer.php');
?>
</body>
</html>
