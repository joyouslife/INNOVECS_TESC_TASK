<?php if (!isset($this->app)) exit(); ?>
<?php $this->app->displayHeader(); ?>

<form id="sign-in-form" class="form-horizontal" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>Sign In</legend>

        <div  id="message" class="alert"></div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="login">Login</label>
            <div class="col-md-4">
                <input id="login" name="login" type="text" placeholder="login" class="form-control input-md">
                <p class="message-login error-message"></p>
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-4">
                <input id="password" name="password" type="password" placeholder="password" class="form-control input-md">
                <p class="message-password error-message"></p>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Sign In</button>
            </div>
        </div>

    </fieldset>
</form>

<?php $this->app->displayFooter(); ?>
