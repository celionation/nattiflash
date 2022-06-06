<?php


use core\forms\Form;

?>

<?php $this->start('head') ?>
    <script src="<?= ROOT ?>app/assets/vendor/ckeditor5/ckeditor.js"></script>

    <script>
        window.addEventListener('load', function() {
            ClassicEditor
                .create(document.querySelector('#body'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }

        .is-invalid+.ck-editor .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: crimson;
        }
    </style>
<?php $this->end() ?>

<?php $this->start('content') ?>

    <h2><?= $this->heading ?></h2>

    <div class="poster mb-2">
        <form action="" method="post" enctype="multipart/form-data" >
            <?= Form::csrfField() ?>
            <div class="row">
                <?= Form::inputField('Title', 'title', $this->article->title, ['class' => 'form-control'], ['class' => 'mb-3 col-md-12'], $this->errors); ?>
                <?= Form::selectField('Status', 'status', $this->article->status, $this->statusOptions, ['class' => 'form-control'], ['class' => 'mb-3 col-md-4'], $this->errors); ?>
                <?= Form::selectField('Category', 'category_id', $this->article->category_id, $this->categoryOptions, ['class' => 'form-control'], ['class' => 'mb-3 col-md-4'], $this->errors); ?>
                <?= Form::selectField('Region', 'region_id', $this->article->region_id, $this->regionOptions, ['class' => 'form-control'], ['class' => 'mb-3 col-md-4'], $this->errors); ?>
                <?= Form::textareaField('Article Body', 'body', html_entity_decode($this->article->body), ['class' => 'form-control', 'rows' => "15"], ['class' => 'mb-3 col-md-12'], $this->errors); ?>
            </div>

            <div class="text-end">
                <a href="/admin/articles" class="btn btn-secondary">Cancel</a>
                <input class="btn btn-primary" value="Save" type="submit" />
            </div>
        </form>
    </div>

<?php $this->end() ?>