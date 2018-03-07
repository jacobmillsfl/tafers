<?php
/* Central file for site navigation */

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">TAFers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#TAFCTF">TAF CTF</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#LifeCounter">LifeCounter</a>
                </li>
                <?php if (SessionManager::getUserId() > 0): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/account.php">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout.php">LogOut</a>
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