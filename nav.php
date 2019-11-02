<?php
/* Central file for site navigation */

include_once("Utilities/SessionManager.php");
$userNav = SessionManager::getUserName();

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="https://tafers.net/">TAFers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!--<li class="nav-item">
                    <a class="nav-link" href="https://ctf.tafers.net/">TAF CTF</a>
                </li>-->
                <!--<li class="nav-item">
                    <a class="nav-link" href="LifeCounter.html">LifeCounter</a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery.php">Gallery</a>
                </li>
                <?php if (SessionManager::getUserRoleId() == 1 || SessionManager::getUserRoleId() == 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="upload.php">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="filehome.php">Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agenda.php">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="musichome.php">Songs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                <?php endif ?>
                <?php if (SessionManager::getUserId() > 0): ?>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="/account.php">Account</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="/logout.php">Log Out,&nbsp;<?php echo "<p style=\"display: inline;\">" . $userNav . "</p>"; ?></a>
                    </li>
					<li class="nav-item">
						<a class="nav-link" href="/account.php"><img style="max-height: 40px;max-width: 40px;" class="d-flex mr-3 rounded-circle" src="<?php echo SessionManager::getUserIcon() ?>" alt="Account"></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">LogIn</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
