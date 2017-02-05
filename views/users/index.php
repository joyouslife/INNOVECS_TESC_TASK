<?php if (!isset($this->app)) exit(); ?>
<?php $this->app->displayHeader(); ?>
<div id="users">
    <div class="row">
        <div class="col-lg-12">
<?php
            if ($this->app->service('access')->canAddUser()) {
?>
                <a href="/users/add" class="btn btn-primary">Add New User</a>
<?php
            }
?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table id="report-table" class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php


                $n  = 0;
                foreach ($users as $key => $user) {
                    ++$n;
                    ?>

                    <tr>
                        <th scope="row"><?php echo $n; ?></th>
                        <td><?php echo ($user['id']) ? $user['id'] : '-'; ?></td>
                        <td><?php echo ($user['login']) ? $user['login'] : '-'; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><?php echo date('d/m/Y H:i:s', $user['ctime']); ?></td>
                        <td>
<?php
                                if ($this->app->service('access')->canModifyuser()) {
?>
                            <a class="edit" href="/users/edit/<?php echo $user['id']; ?>">edit</a>
<?php
                                }
?>

<?php
                                if ($this->app->service('access')->canDeleteUser($user['id'])) {
?>
                                    | <a  data-user-id="<?php echo $user['id']; ?>" class="delete" href="#">delete</a>
<?php
                                }
?>
                            </a>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            </table>

        </div>
    </div>
</div>
<?php $this->app->displayFooter(); ?>
