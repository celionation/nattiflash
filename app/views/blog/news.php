<?php


use core\helpers\StringFormat;
use core\helpers\TimeFormat;


?>

<?php $this->start('head') ?>

<?php $this->end() ?>

<?php $this->start('content') ?>

    <div class="sub-menu mt-5 p-3 bg-warning">
        <h1 class="text-uppercase text-white border-bottom border-dark border-1 pb-2 mb-3">News</h1>
        <div class="sub-menu-item px-2 d-flex justify-content-between align-items-center">
            <div>
                <a href="/" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Home</a>
                <a href="/world" class="fw-bold text-black border-end border-1 px-2 text-capitalize">World</a>
                <a href="/business" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Business</a>
                <a href="/tech" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Tech</a>
                <a href="/science" class="fw-bold text-black border-end border-1 px-2 text-capitalize">Science</a>
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
                <div class="news-list">
                    <?php if ($this->total !== 0) : ?>
                        <?php foreach ($this->articles as $article) : ?>
                            <div class="card rounded-4 mt-2">
                                <div class="card">
                                    <img src="<?= '/' . $article->img ?>" alt="" height="600px" width="100%" style="object-fit: fill">
                                    <div class="card-header">
                                        <a href="#" class="text-dark">
                                            <h2 class="text-shadow h2 text-capitalize border-bottom border-3 border-danger pb-2">
                                                <?= html_entity_decode($article->title) ?>
                                            </h2>
                                        </a>
                                        <div class="info border-bottom border-3 border-danger pb-2 d-flex justify-content-around align-items-center">
                                            <a class="text-dark small"><i class="far fa-clock"></i> <?= TimeFormat::FBTimeAgo($article->created_at) ?></a> &bull;
                                            <span class="text-dark small"><i class="fas fa-map-marker-alt"></i> <?= $article->region ?></span> &bull;
                                            <a class="text-dark small"><span class="fas fa-tag"></span>
                                                <span class="badge bg-primary py-2"><?= $article->category ?></span>
                                            </a>
                                        </div>
                                        <p class="text-shadow fst-italic"><?= StringFormat::Excerpt(html_entity_decode($article->body), 350) ?></p>
                                        <a href="/blog/read/<?= $article->id ?>" class="btn btn-primary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h2 class="text-center mx-auto mt-5 text-white bg-danger p-3">No Post Available</h2>
                    <?php endif; ?>
                </div>
                <!-- End of News -->

                <!-- Pagination -->

                <!-- //Pagination -->
            </div>
        </div>
        <?php $this->components('mainSidebar') ?>
    </div>
</div>

<?php $this->end() ?>