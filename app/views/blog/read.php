<?php

use core\helpers\TimeFormat;

?>

<?php $this->start('content') ?>

    <main class="container-fluid mt-5">
        <div class="row mb-3">
            <div class="col-12 col-lg-8 col-md-8 col-sm-12">
                <div class="card">
                    <img src="<?= '/' . $this->article->img ?>" alt="" class="w-100 img-fluid rounded-2">
                    <div class="card-header">
                        <h2 class="text-shadow h4 text-capitalize border-bottom border-top border-3 border-danger pb-2"><?= html_entity_decode($this->article->title) ?></h2>
                        <div class="info border-bottom border-3 border-danger pb-2 d-flex justify-content-around align-items-center">
                            <a class="text-dark small"><span class="far fa-clock"></span> <?= TimeFormat::TimeInAgo($this->article->created_at) ?></a> &bull;
                            <a class="text-dark small"><span class="fas fa-map-marker-alt"></span> <?= $this->article->region ?></a> &bull;
                            <a class="text-dark small"><span class="fas fa-user"></span> <?= $this->article->fname . ' '. $this->article->lname ?></a>
                            <a class="text-dark small"><span class="fas fa-tag"></span>
                                <span class="badge bg-primary py-2"><?= $this->article->category ?></span>
                            </a>
                        </div>
                        <div class="single-content">
                            <div class="text-shadow fs-5 fst-italic lh-sm border-bottom border-danger border-3">
                                <p class="m-0 p-0 my-2">
                                    <?= html_entity_decode($this->article->body) ?>
                                </p>
                            </div>
                        </div>
                        <!-- Comment Section -->

                    </div>
                </div>
            </div>
            <?= $this->components('mainSidebar') ?>
        </div>
    </main>

<?php $this->end() ?>