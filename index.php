<?php
/**
 * Author: Jacob Mills
 * Date: 10/05/2017
 * Description: This file is the landing page for tafers
 */



include("DAL/SiteBanner.php");


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TAFERS DOT NET</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">TAFers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#LifeCounter">LifeCounter</a>
					<a class="nav-link" href="#TAF CTF">TAF CTF</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Header -->
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
echo "<a href=\"#\" class=\"btn btn-secondary btn-lg\">";
echo "<i class=\"fa fa-twitter fa-fw\"></i>";
echo "<span class=\"network-name\">Twitter</span>";
echo "</a>";
echo "</li>";
echo "<li class=\"list-inline-item\">";
echo "<a href=\"#\" class=\"btn btn-secondary btn-lg\">";
echo "<i class=\"fa fa-github fa-fw\"></i>";
echo "<span class=\"network-name\">Github</span>";
echo "</a>";
echo "</li>";
echo "<li class=\"list-inline-item\">";
echo "<a href=\"#\" class=\"btn btn-secondary btn-lg\">";
echo "<i class=\"fa fa-linkedin fa-fw\"></i>";
echo "<span class=\"network-name\">Linkedin</span>";
echo "</a>";
echo "</li>";
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</header>";

?>

<!-- Page Content -->
<section id="LifeCounter" class="content-section-a">

    <div class="container">
        <div class="row">
            <div class="col-lg-5 ml-auto">
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
    <!-- /.container -->
</section>

<section id="TAF CTF" class="content-section-b">

    <div class="container">

        <div class="row">
            <div class="col-lg-5 mr-auto order-lg-2">
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
    <!-- /.container -->

</section>
<!-- /.content-section-b -->

<section class="content-section-a">

    <div class="container">

        <div class="row">
            <div class="col-lg-5 ml-auto">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">Coming Soon</h2>
                <p class="lead">More content</p>
            </div>
            <div class="col-lg-5 mr-auto ">
                <img class="img-fluid" src="images/butcher.jpg" alt="">
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
                        <a href="#" class="btn btn-secondary btn-lg">
                            <i class="fa fa-twitter fa-fw"></i>
                            <span class="network-name">Twitter</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-secondary btn-lg">
                            <i class="fa fa-github fa-fw"></i>
                            <span class="network-name">Github</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-secondary btn-lg">
                            <i class="fa fa-linkedin fa-fw"></i>
                            <span class="network-name">Linkedin</span>
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
<footer>
    <div class="container">
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="#">Home</a>
            </li>
            <li class="footer-menu-divider list-inline-item">&sdot;</li>
            <li class="list-inline-item">
                <a href="#LifeCounter">About</a>
            </li>
        </ul>
        <p class="copyright text-muted small">Copyright &copy; Tafers 2017. All Rights Reserved</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
