<?php


?>


<?php $this->start('content') ?>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Users</h2>
        <a href="/admin/register" class="btn btn sm btn-primary">New User</a>
    </div>

    <table class="table table-striped" id="dataTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">E-Mail</th>
            <th scope="col">Access Level</th>
            <th scope="col">Status</th>
            <th scope="col text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->users as $key => $user) : ?>
            <tr>
                <th scope="row"><?= $key + 1 ?></th>
                <td><?= $user->displayName() ?></td>
                <td><?= $user->email ?></td>
                <td><?= ucwords($user->acl) ?></td>
                <td><?= $user->blocked ? "Blocked" : "Active" ?></td>
                <td class="text-end">
                    <a href="/admin/register/<?= $user->id ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="/admin/toggleUser/<?= $user->id ?>" class="btn btn-sm <?= $user->blocked ? "btn-warning" : "btn-secondary" ?>">
                        <?= $user->blocked ? "Unblock" : "Block" ?>
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $user->id ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <script>
        function confirmDelete(userId) {
            if (window.confirm("Are you sure you want to delete the user? This cannot be undone!")) {
                window.location.href = `/admin/deleteUser/${userId}`;
            }
        }
    </script>

<?php $this->end() ?>