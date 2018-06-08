<?php
/**
 * Author: Jacob Mills
 * Date: 10/05/2017
 * Description: This file is the landing page for tafers
 */

session_start();

include("DAL/SiteBanner.php");
include("DAL/User.php");
include("Utilities/SessionManager.php");

?>


<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

<?php include('nav.php'); ?>

<?php
$banner = new SiteBanner(1);


echo "<header class=\"intro-header\" style=\"background: url(" . $banner->getImgUrl() . ") no-repeat center center; background-size: cover;\">";
echo "<div class=\"container\">";
echo "<div class=\"intro-message\">";
echo "<h1>" . $banner->getTitle() . "</h1>";
echo "<h3>" . $banner->getMessage() . "</h3>";
echo "<hr class=\"intro-divider\">";
echo "<ul class=\"list-inline intro-social-buttons\">";
echo "<li class=\"list-inline-item\">";
echo "<a href=\"https://soundcloud.com/theambientfunk\" class=\"btn btn-secondary btn-lg\">";
echo "<i class=\"fa fa-soundcloud fa-fw\"></i>";
echo "<span class=\"network-name\">&nbsp;Soundcloud</span>";
echo "</a>";
echo "</li>";
echo "<li class=\"list-inline-item\">";
echo "<a href=\"#\" class=\"btn btn-secondary btn-lg\">";
echo "<i class=\"fa fa-facebook fa-fw\"></i>";
echo "<span class=\"network-name\">Facebook</span>";
echo "</a>";
echo "</li>";
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</header>";



?>
<section id="TAFMusic" class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ml-auto">
                <hr style="float: left;width: 355px;border-top: 3px solid #e7e7e7;">
                <div class="clearfix"></div>
                <h2 class="section-heading">The Ambient Funk Music</h2>
                <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/users/459410589&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Page Content -->
<!-- CTF is out of season
<section id="TAFCTF" class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 ml-auto">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">TAF CTF</h2>
                <p class="lead">Register for our
				<a target="https://ctf.tafers.net/" href="https://ctf.tafers.net/">TAF CTF</a>
				and compete today!</p>
            </div>
            <div class="col-lg-5 ml-auto order-lg-1">
                <img class="img-fluid" src="images/Tafers2-02.png" alt="TAF CTF">
            </div>
        </div>
    </div>
</section>
-->
<!-- Probably doesn't need a section..
<section id="LifeCounter" class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mr-auto order-lg-2">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">Magic The Gathering:<br>Life Counter</h2>
                <p class="lead">Try our
                    <a target="_blank" href="LifeCounter.html">LifeCounter</a>
                    for Magic The Gathering.</p>
            </div>
            <div class="col-lg-5 mr-auto">
                <img class="img-fluid" src="images/liliana.jpg" alt="">
            </div>
        </div>

    </div>

</section>
-->

<section class="content-section-a">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <hr class="">
            <div class="row">
              <div class="col-lg-7">
                  <h2 class="section-heading">About Us</h2>
                  <p class="lead">The Ambient Funk is reshaping the process of music composition and production through collaboration with various artist and integration of analog and digital technolgies. Our mission is to create a platform for artists to continually share and refine music of any genre and present the collective works to audiences across the globe in new and exciting ways.</p>
              </div>
              <div class="col-lg-5 mt-5">
                <p>The works featured on this site are the collective effort of the following artists:</p>
                <ul>
                  <li>Jacob Mills</li>
                  <li>Bradley Williams</li>
                  <li>Edwin Carrillos</li>
                  <li>Thomas Toole</li>
                  <li>Rick Meshell</li>
                </ul>
              </div>
            </div>


          </div>

        </div>
    </div>
    <!-- /.container -->
</section>
<!-- /.content-section-a -->

<aside class="banner">

    <div class="container">

        <div class="row">
            <div class="col-lg-6 my-auto">
                <h2>TAFer Community</h2>
            </div>
            <div class="col-lg-6 my-auto">
                <ul class="list-inline banner-social-buttons">
                    <li class="list-inline-item">
                        <a href="https://soundcloud.com/theambientfunk" class="btn btn-secondary btn-lg">
                            <i class="fa fa-soundcloud fa-fw"></i>
                            <span class="network-name">Soundcloud</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://github.com/H0r53/tafers" class="btn btn-secondary btn-lg">
                            <i class="fa fa-github fa-fw"></i>
                            <span class="network-name">Github</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-secondary btn-lg">
                            <i class="fa fa-facebook fa-fw"></i>
                            <span class="network-name">Facebook</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <!-- /.container -->

</aside>
<!-- /.banner -->

<!-- Footer -->
<?php

include('footer.php');

?>

</body>

</html>
