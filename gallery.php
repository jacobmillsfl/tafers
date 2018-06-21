<?php
/**
 * Author: Thomas Toole
 * Date: 06/20/2018
 * Description: This file is the gallery page for tafers
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/FileUserViewModel.php");

?>


<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>


<body>

<?php include('nav.php'); ?>

<!-- Page Content -->
<section id="Gallery" class="content-section-a">

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
      <!-- Page Heading/Breadcrumbs -->
          <h1 class="mt-4 mb-3">Gallery
              <small>- TAFer images</small>
          </h1>
      <br/>
          <div class="row mt-4">

        <?php
          $fileCategoryId = 5; //pictures
          $columnNumber = 0;
          $viewmodel = FileUserViewModel::loadFileHome($filename,$fileCategoryId,$pageNum);

          foreach($viewmodel as $file)
          {
                if ($file->getIsPublic() == 0) {
                  continue;
                }

                if ($columnNumber == 0) {
                    ?>
                    <div class="row">
                        <div class="col-lg-12 ml-auto">
                          <div class="row card-deck">
                    <?php
                }
              ?>

              <div class="card col-lg-3">
                <div class="card-body">
                  <a href="<?php echo $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . "/files/". $file->getFileName(); ?>" target="_blank">
                  <img class="card-img-top" style="height: 200px;max-width: 260px;" src="<?php echo $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . "/files/". $file->getFileName(); ?>" alt="<?php echo $file->getFileName(); ?>">
                  </a>
                </div>
              </div>

         <?php
               $columnNumber = $columnNumber + 1;
               if ($columnNumber >= 4) {
                   ?>
                       </div>
                     </div>
                   </div>
                   <?php
               }
          }
         ?>

    </div>
    <!-- /.container -->
</section>

<?php include "footer.php" ?>
</body>

</html>
