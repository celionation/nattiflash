<?php


use core\forms\Form;


?>


<?php $this->start('content') ?>

<div class="row">
    <div class="col-md-8 offset-md-2 poster">
        <h2><?= $this->heading ?></h2>

        <form method="post">
            <div class="row">
                <?= Form::csrfField(); ?>
                <?= Form::inputField('Region Name', 'name', $this->region->name, ['class' => 'form-control'], ['class' => 'mb-3 col-md-12'], $this->errors); ?>
            </div>

            <div class="text-end">
                <a href="/admin/regions" class="btn btn-secondary">Cancel</a>
                <input class="btn btn-primary" value="Save" type="submit" />
            </div>
        </form>
    </div>
</div>

<?php $this->end() ?>