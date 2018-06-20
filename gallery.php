<?php
/**
 * Author: Thomas Toole
 * Date: 06/20/2018
 * Description: This file is the gallery page for tafers
 */

session_start();

include_once("Utilities/Authentication.php");

Authentication::checkFilePermissions();

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
              <small>- images for TAFer data</small>
          </h1>
      <br/>
          <div class="row mt-4">
              <div class="col-md-8">

        <div class="row">
            <div class="col-lg-12 ml-auto">
              <div class="card-group">
                <div class="card">
                  <img class="card-img-top" src="images/avacyn.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Trifold Ecstacy</h5>
                    <p class="card-text">The song is essentially complete, the current version will need vocals to be rerecorded to be more in tune to the song.</p>
                    <p class="card-text"><small class="text-muted">Almost complete - needs new vocals</small></p>
                  </div>
                </div>
                <div class="card">
                  <img class="card-img-top" src="images/sorin.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Entropy</h5>
                    <p class="card-text">We added more vocals to the beginning and end of the song. Needs to be mixed and mastered.</p>
                    <p class="card-text"><small class="text-muted">Vocal Remix Pt. 2</small></p>
                  </div>
                </div>
                <div class="card">
                  <img class="card-img-top" src="images/serra.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Audacity</h5>
                    <p class="card-text">I have no idea what the progress on this song is, it's almost done right?</p>
                    <p class="card-text"><small class="text-muted">??????</small></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</section>

<?php include "footer.php" ?>
</body>

</html>
