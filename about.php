
<?php
   /**
    * Author: Jacob Mills
    * Date: 08/17/2018
    * Description: This file is a page that describes "About TAFers"
    */
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);

   session_start();

   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include('head.php'); ?>
   <body>
      <?php include('nav.php'); ?>
      <!-- Page Content -->
      <section id="SectionName" class="content-section-a">
         <!-- Page Content -->
         <div class="container">
            <!-- Page Heading/Breadcrumbs -->
            <h1 class="mt-4 mb-3">The Ambient Funk
            </h1>
            <!-- Intro Content -->
            <div class="row">
               <div class="col-lg-6">
                  <img class="img-fluid rounded mb-4" src="/images/TAF_logo.png" alt="logo">
               </div>
               <div class="col-lg-6">
                  <h2>Background</h2>
                  <p>The Ambient Funk (TAF) is reshaping the process of music composition and production through collaboration with various artist and integration of analog and digital technolgies. Members of TAF, along with the TAF community, are known as TAFers. In addition to music composition and performance, each TAFer specializes in different skills in the field of music, art, and technology. </p>
                  <p>Our mission is to create a platform for artists to continually share and refine music of any genre and present the collective works to audiences across the globe in new and exciting ways. To accomplish this goal we plan to combine our experience with art, music, production, and technology to create a unique </p>
               </div>
            </div>
            <!-- /.row -->
            <!-- Team Members -->
            <h2>Meet The TAFers</h2>
            <div class="row">
               <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                     <img class="card-img-top" src="images/Mills_Jacob.jpg" alt="Member Icon">
                     <div class="card-body">
                        <h4 class="card-title">Jacob Mills</h4>
                        <h6 class="card-subtitle mb-2 text-muted"> Producer </h6>
                        <p class="card-text"></p>
                     </div>
                     <div class="card-footer"><a href="#">jacob@tafers.net</a></div>
                  </div>
               </div>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                     <img class="card-img-top" src="images/missing.png" alt="Member Icon">
                     <div class="card-body">
                        <h4 class="card-title">Bradley Williams</h4>
                        <h6 class="card-subtitle mb-2 text-muted"> Manager </h6>
                        <p class="card-text">Coming soon.</p>
                     </div>
                     <div class="card-footer"><a href="#">brad@tafers.net</a></div>
                  </div>
               </div>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                     <img class="card-img-top" src="images/missing.png" alt="Member Icon">
                     <div class="card-body">
                        <h4 class="card-title">Edwin Carillos</h4>
                        <h6 class="card-subtitle mb-2 text-muted"> DJ </h6>
                        <p class="card-text">Coming soon.</p>
                     </div>
                     <div class="card-footer"><a href="#">edwin@tafers.net</a></div>
                  </div>
               </div>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                     <img class="card-img-top" src="images/missing.png" alt="Member Icon">
                     <div class="card-body">
                        <h4 class="card-title">Thomas Toole</h4>
                        <h6 class="card-subtitle mb-2 text-muted"> Boss </h6>
                        <p class="card-text">Coming soon.</p>
                     </div>
                     <div class="card-footer"><a href="#">thomas@tafers.net</a></div>
                  </div>
               </div>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                     <img class="card-img-top" src="images/missing.png" alt="Member Icon">
                     <div class="card-body">
                        <h4 class="card-title">Rick Meshell</h4>
                        <h6 class="card-subtitle mb-2 text-muted"> Design Lead </h6>
                        <p class="card-text">Coming soon.</p>
                     </div>
                     <div class="card-footer"><a href="#">rick@tafers.net</a></div>
                  </div>
               </div>
            </div>
            <!-- /.row -->
            <!-- Our Partners -->
            <h2>Our Partners</h2>
            <div class="row">
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid"
                     src="images/DigitalOcean_Logo.png"
                     alt="DigitalOcean">
               </div>
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid" src="images/Ubuntu_Logo.png" alt="Ubuntu">
               </div>
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid" src="images/Nginx_Logo.png" alt="Nginx">
               </div>
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid"
                     src="images/PhpStorm_Logo.png"
                     alt="PHPStorm">
               </div>
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid" src="images/Xampp_Logo.jpg" alt="XAMPP">
               </div>
               <div class="col-lg-2 col-sm-4 mb-4">
                  <img class="img-fluid" src="images/MySQL_Logo.jpg" alt="MySQL">
               </div>
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container -->
      </section>
      <!-- Footer -->
      <?php include('footer.php'); ?>
   </body>
</html>

© FreeFormatter.com - FREEFORMATTER is a d/b/a of 10174785 Canada Inc. - Copyright Notice - Privacy Statement - Terms of Use
