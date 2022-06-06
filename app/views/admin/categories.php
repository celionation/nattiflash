<?php


?>


<?php $this->start('content') ?>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Categories</h2>
        <a href="/admin/category" class="btn btn sm btn-primary">New Category</a>
    </div>

    <table class="table table-striped" id="dataTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->categories as $key => $cat) : ?>
            <tr>
                <th scope="row"><?= $key + 1 ?></th>
                <td><?= $cat->name ?></td>
                <td class="text-end">
                    <a href="/admin/category/<?= $cat->id ?>" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="deleteCategory('<?= $cat->id ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <script>
        function deleteCategory(userId) {
            if (window.confirm("Are you sure you want to delete this Category? This cannot be undone!")) {
                window.location.href = `/admin/deleteCategory/${userId}`;
            }
        }
    </script>

<?php $this->end() ?>