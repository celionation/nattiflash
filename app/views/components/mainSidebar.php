<?php


?>

<div class="col-12 col-lg-4 col-md-4 col-sm-12">
    <div class="card mb-2">
        <img src="/app/assets/img/tags/travel-tag.jpg" alt="" class="w-100 img-fluid rounded-3">
    </div>
    <div class="card">
        <h2 class="text-shadow h4 text-uppercase rounded-3 text-center border-bottom border-3 border-danger pb-2">
            Subscribe</h2>
        <div class="card-body">
            <p class="text-center text-italic">Subscribe To Our Weekly Newsletter And Receive Updates Via Email.
            </p>
            <div class="mb-3">
                <form action="/newsletter" method="post">
                    <?= Form::csrfField() ?>
                    <input type="email" name="email" id="" class="form-control" placeholder="E-Mail">
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card mb-2 mt-2">
        <h2 class="text-shadow h4 text-uppercase rounded-3 p-2 text-start border-bottom border-3 border-danger pb-1">
            News Updates</h2>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="#" class="text-black">
                        <h2 class="text-shadow h6 text-capitalize border-bottom border-3 border-danger pb-2">
                            Twitter's New Retweet With Comment Counter Is Now Available On Andriod & Web</h2>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-black">
                        <h2 class="text-shadow h6 text-capitalize border-bottom border-3 border-danger pb-2">
                            Twitter's New Retweet With Comment Counter Is Now Available On Andriod & Web</h2>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-black">
                        <h2 class="text-shadow h6 text-capitalize border-bottom border-3 border-danger pb-2">
                            Twitter's New Retweet With Comment Counter Is Now Available On Andriod & Web</h2>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card position-relative overflow-hidden mb-3">
        <img src="/img/older_posts/older_posts_4.jpg" alt="" class="w-100 img-fluid rounded-3">
        <div class="text position-absolute bottom-0">
            <a href="#" class="text-white">
                <h2 class="text-shadow h5 text-capitalize border-bottom border-3 border-danger p-3">Twitter's New Retweet With Comment Counter Is Now Available On Andriod & Web</h2>
            </a>
        </div>
    </div>
    <div class="card position-relative overflow-hidden mb-3">
        <img src="/img/older_posts/older_posts_5.jpg" alt="" class="w-100 img-fluid rounded-3">
        <div class="text position-absolute bottom-0">
            <a href="#" class="text-white">
                <h2 class="text-shadow h5 text-capitalize border-bottom border-3 border-danger p-3">Twitter's New Retweet With Comment Counter Is Now Available On Andriod & Web</h2>
            </a>
        </div>
    </div>
    <div class="card mb-2 bg-light">
        <div class="card-header d-flex justify-content-between px-3 py-3 align-items-start">
            <a href="#" class="text-primary"><span class="fab fa-facebook-f fa-2x"></span></a>
            <a href="#" class="text-info"><span class="fab fa-twitter fa-2x"></span></a>
            <a href="#" class="text-danger"><span class="fab fa-instagram fa-2x"></span></a>
        </div>
    </div>
    <div class="card mb-2">
        <img src="/img/tags/travel-tag.jpg" alt="" class="w-100 img-fluid rounded-3">
    </div>
    <!-- Tag Section -->
    <div class="card mt-3">
        <h2 class="text-shadow h4 text-uppercase rounded-3 text-center border-bottom border-3 border-danger pb-2">
            Tags</h2>
        <div class="card-body">
            <a href="#">
                <span class="btn btn-primary rounded mt-2">Software</span>
            </a>
            <a href="#">
                <span class="btn btn-primary rounded mt-2">Technology</span>
            </a>
            <a href="#">
                <span class="btn btn-primary rounded mt-2">Travel</span>
            </a>
            <a href="#">
                <span class="btn btn-primary rounded mt-2">Love</span>
            </a>
            <a href="#">
                <span class="btn btn-primary rounded mt-2">Javascript</span>
            </a>
            <a href="#">
                <span class="btn btn-primary rounded mt-2">PHP</span>
            </a>
        </div>
    </div>
</div>
