<?php if (!isset($this)) exit(); ?>

<form class="form-horizontal">
<div id="report-filter">
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-1 control-label" for="date">Date</label>
            <div class="col-md-2">
                <input id="date" name="date" type="text" placeholder="" class="form-control input-md" value="<?php echo $model->date; ?>">
            </div>

            <label class="col-md-1 control-label" for="login">User</label>
            <div class="col-md-2">
                <select id="user-id" name="user_id" class="form-control">
                    <?php $selected = ($model->user_id == 'all') ? ' selected="selected" ' : ''; ?>
                    <option <?php echo $selected; ?> value="all">All</option>
<?php
                    foreach ($users as $user) {
?>
                        <?php $selected = ($model->user_id == $user['id']) ? ' selected="selected" ' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $user['id']; ?>"><?php echo $user['login']; ?></option>
<?php
                    }
?>
                </select>
            </div>

            <label class="col-md-1 control-label" for="login">Type</label>
            <div class="col-md-2">
                <select id="type" name="type" class="form-control">
                    <?php $selected = ($model->type == 'all') ? ' selected="selected" ' : ''; ?>
                    <option <?php echo $selected; ?> value="all">All</option>
<?php
                    foreach ($types as $type) {
?>
                        <?php $selected = ($model->type == $type) ? ' selected="selected" ' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $type; ?>"><?php echo $type; ?></option>
<?php
                    }
?>

                </select>
            </div>

            <div class="col-md-2">
                <button value="filter" id="__action" name="__action" class="btn btn-primary">Show</button>
            </div>
        </div>
</div>
</form>