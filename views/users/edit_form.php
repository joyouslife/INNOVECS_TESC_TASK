<?php if (!isset($this->app)) exit(); ?>
<?php $this->app->displayHeader(); ?>

<form id="edit-user-form" class="form-horizontal" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>Edit User</legend>

        <div  id="message" class="alert"></div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="login">Login</label>
            <div class="col-md-4">
                <input id="login" name="login" type="text" placeholder="login" class="form-control input-md" value="<?php echo $userModel->login; ?>">
                <p class="message-login error-message"></p>
            </div>
        </div>
<?php
        if ($this->app->service('access')->canModifyUserRole($userModel->id)) {
?>
            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="role">Role</label>
                <div class="col-md-4">
                    <select id="role" name="role" class="form-control">
                        <?php
                        foreach ($roles as $role) {
                            $selected = ($role == $userModel->role) ? 'selected="selected"' : '';
                            ?>
                            <option <?php echo $selected; ?> value="<?php echo $role; ?>"><?php echo $role; ?></option>
                            <?php
                        }
                        ?>

                    </select>
                    <p class="message-role error-message"></p>
                </div>
            </div>
<?php
        }
?>


        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-4">
                <input id="password" name="password" type="password" placeholder="password" class="form-control input-md">
                <p class="message-password error-message"></p>
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="repassword">Repeat Password</label>
            <div class="col-md-4">
                <input id="repassword" name="repassword" type="password" placeholder="password" class="form-control input-md">
                <p class="message-repassword error-message"></p>
            </div>
        </div>

        <input id="user_id" name="user_id" type="hidden" value="<?php echo $userModel->id; ?>">

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
            </div>
        </div>

    </fieldset>
</form>

<?php $this->app->displayFooter(); ?>
