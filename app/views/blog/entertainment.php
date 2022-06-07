<?php $this->start('head') ?>
<?php $this->end() ?>

<?php $this->start('content') ?>

    <div class="sub-menu mt-5 p-3 bg-primary">
        <h1 class="text-uppercase text-white border-bottom border-dark border-1 pb-2 mb-3">Entertainment</h1>
        <div class="sub-menu-item px-2 d-flex justify-content-between align-items-center">
            <div>
                <a href="/" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Home</a>
                <a href="/football" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Football</a>
                <a href="/basketball" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Basketball</a>
                <a href="/rudgy" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Rudgy</a>
                <a href="/formula1" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Formula 1</a>
            </div>
            <div>
                <a class="nav-link dropdown-toggle text-black fw-bold" type="button" id="menuList"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    More
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuList">
                    <li>
                        <h6 class="dropdown-header">Dropdown header</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-8">
                <!-- news -->
                <div class="news-page">
                    <h1>Entertainment Page</h1>
                    <!-- End of News -->

                    <!-- Pagination -->

                    <!-- //Pagination -->
                </div>
            </div>
            <?php $this->components('mainSidebar') ?>
        </div>
    </div>

<?php $this->end() ?>