<?php


use core\forms\Form;


?>

<?php $this->start('content') ?>
<section>
    <div class="imgBox">
        <img src="<?= asset('/app/assets/img/img.jpg') ?>" alt="">
    </div>
    <div class="contentBox">
        <div class="formBox">
            <h2>Login</h2>
            <form action="" method="post">
                <?= Form::csrfField() ?>
                <div class="inputBox">
                    <?= Form::inputField('E-Mail', 'email', $this->user->email, ['type' => 'email'], [], $this->errors) ?>
                </div>
                <div class="inputBox">
                    <?= Form::inputField('Password', 'password', $this->user->password, ['type' => 'password'], [], $this->errors) ?>
                </div>
                <div class="remember">
                    <?= Form::checkInput(' Remember Me', 'remember', $this->user->remember == 'on', ['class' => 'form-check-input'], ['class' => 'form-check'], $this->errors); ?>
                </div>
                <div class="inputBox">
                    <button type="submit">Sign In</button>
                </div>
                <div class="inputBox">
                    <p>Don't have an account? <a href="/auth/register">Sign Up</a></p>
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
