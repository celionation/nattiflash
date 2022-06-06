<?php


use core\helpers\StringFormat;
use core\helpers\TimeFormat;


?>


<?php $this->start('content') ?>

    <div class="d-flex justify-content-between align-items-center">
        <h2>Your Articles</h2>
        <a class="btn btn-primary" href="/admin/article/new">New Article</a>
    </div>

    <table class="table table-striped table-hover table-sm" id="dataTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Create Date</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->articles as $article) : ?>
            <tr>

                <td><img src="<?= asset("/$article->img") ?>" class="image-fluid" width="60" height="60"> &nbsp;<?= StringFormat::Excerpt($article->title, 50) ?></td>
                <td><?= $article->fname . ' ' . $article->lname ?></td>
                <td><?= $article->category ?></td>
                <td><?= TimeFormat::TimeInAgo($article->created_at) ?></td>
                <td><?= $article->status ?></td>
                <td class="text-end">
                    <a href="/admin/article/<?= $article->id ?>" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="deleteArticle('<?= $article->id ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function deleteArticle(id) {
            if (window.confirm("Are you sure you want to delete this article? This cannot be undone!")) {
                window.location.href = `/admin/deleteArticle/${id}`;
            }
        }
    </script>

<?php $this->end() ?>