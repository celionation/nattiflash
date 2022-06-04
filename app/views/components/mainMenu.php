<?php


?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?= ROOT ?>app/assets/img/logocolor.jpg" alt="NattiFlash" style="width: 65px; width: 65px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarCollapse">
            <ul class="navbar-nav mx-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/magazine">Magazine</a>
                </li>
            </ul>
            <ul class="navbar-nav mx-end mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" id="search-btn"><span class="fas fa-search"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- __________________SEARCH BOX___________________ -->
<form action="" method="post" class="search-form">
    <input type="search" id="search-box" placeholder="Search here...">
    <label for="search-box" class="fas fa-search"></label>
</form>
<!-- __________________END OF SEARCH BOX___________________ -->
