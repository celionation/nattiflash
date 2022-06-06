<?php


?>


<?php $this->start('content') ?>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Regions</h2>
        <a href="/admin/region" class="btn btn sm btn-primary">New Region</a>
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
        <?php foreach ($this->regions as $key => $reg) : ?>
            <tr>
                <th scope="row"><?= $key + 1 ?></th>
                <td><?= $reg->name ?></td>
                <td class="text-end">
                    <a href="/admin/region/<?= $reg->id ?>" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="deleteRegion('<?= $reg->id ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <script>
        function deleteRegion(userId) {
            if (window.confirm("Are you sure you want to delete this Category? This cannot be undone!")) {
                window.location.href = `/admin/deleteRegion/${userId}`;
            }
        }
    </script>

<?php $this->end() ?>