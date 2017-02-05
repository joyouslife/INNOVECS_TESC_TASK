<?php if (!isset($this->app)) exit(); ?>
<?php $this->app->displayHeader(); ?>

<form id="add-user-form" class="form-horizontal" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>Add New User</legend>

        <div  id="message" class="alert"></div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="login">Login</label>
            <div class="col-md-4">
                <input id="login" name="login" type="text" placeholder="login" class="form-control input-md">
                <p class="message-login error-message"></p>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="role">Role</label>
            <div class="col-md-4">
                <select id="role" name="role" class="form-control">
                    <?php
                    foreach ($roles as $role) {
                        ?>
                        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                        <?php
                    }
                    ?>

                </select>
                <p class="message-role error-message"></p>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Create</button>
            </div>
        </div>

    </fieldset>
</form>

<?php $this->app->displayFooter(); ?>
