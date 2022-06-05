<?php

use core\forms\Form;

?>

<?php $this->start('content') ?>

<section>
    <div class="imgBox">
        <img src="<?= asset('/app/assets/img/img.jpg') ?>" alt="">
    </div>
    <div class="contentBox mt-4">
        <div class="formBox">
            <h2>Register</h2>
            <form action="" method="post">
                <div class="inputBox">
                    <?= Form::inputField('FullName', 'fullname', '', ['type' => 'text'], [], $this->errors) ?>
                </div>
                <div class="inputBox">
                    <?= Form::inputField('E-mail', 'email', '', ['type' => 'email'], [], $this->errors) ?>
                </div>
                <div class="inputBox">
                    <?= Form::inputField('Password', 'password', '', ['type' => 'password'], [], $this->errors) ?>
                </div>
                <div class="inputBox">
                    <?= Form::inputField('Comfirm Password', 'confirmPassword', '', ['type' => 'password'], [], $this->errors) ?>
                </div>
                <div class="remember">
                    <?= Form::checkInput('Terms and Conditions', 'terms', '', ['class' => 'form-check-input'], ['class' => 'form-check'], $this->errors); ?>
                </div>

                <div class="inputBox">
                    <button type="submit">Sign Up</button>
                </div>
                <div class="inputBox">
                    <p>Already a Member? <a href="/auth/login">Sign In</a></p>
                </div>

            </form>
            <h3 class="h6">Login with Social media</h3>
            <ul class="sci">
                <li><i class="fab fa-facebook"></i></li>
                <li><i class="fab fa-twitter"></i></li>
                <li><i class="fab fa-instagram"></i></li>
            </ul>
        </div>
    </div>
</section>

<?php $this->end() ?>