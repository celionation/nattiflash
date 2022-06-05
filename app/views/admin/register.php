<?php

use core\forms\Form;

?>

<?php $this->start('content') ?>

<div class="row">
    <div class="col-md-12 mx-auto shadow p-2">
        <div class="card card-body bg-light">
            <div class="d-flex align-items-center">
                <h2 class="mx-auto"><?= $this->header ?></h2>
            </div>

            <p class="text-danger text-center border-danger border-bottom border-3">Please fill in all fields
            <p>
            <form action="" method="post">
                <?= Form::csrfField() ?>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <?= Form::inputField('Firstname', 'fname', $this->user->fname, ['class' => 'form-control', 'type' => 'text'], ['class' => 'col mb-3'], $this->errors); ?>
                    </div>
                    <div class="col-md-6">
                        <?= Form::inputField('Lastname', 'lname', $this->user->lname, ['class' => 'form-control', 'type' => 'text'], ['class' => 'col mb-3'], $this->errors); ?>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <?= Form::inputField('E-Mail', 'email', $this->user->email, ['class' => 'form-control', 'type' => 'email'], ['class' => 'col mb-3'], $this->errors); ?>
                    </div>
                    <div class="col-md-6">
                        <?= Form::selectField('Access Level', 'acl', $this->user->acl, $this->acl, ['class' => 'form-control'], ['class' => 'mb-3 col'], $this->errors); ?>
                    </div>
                </div>


                <?= Form::inputField('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'col mb-3'], $this->errors); ?>

                <?= Form::inputField('Confirm Password', 'confirmPassword', $this->user->confirmPassword, ['class' => 'form-control', 'type' => 'password'], ['class' => 'col mb-3'], $this->errors); ?>

                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-success w-100">Save</button>
                    </div>
                    <div class="col">
                        <a href="/admin/users" class="btn btn-danger w-100">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->end() ?>
