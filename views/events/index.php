<?php if (!isset($this)) exit(); ?>
<?php $this->app->displayHeader(); ?>
<div id="events-report">
    <?php $this->app->service('eventsForm')->display(); ?>

    <div class="row">
        <div class="col-lg-12">
            <table id="report-table" class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Type</th>
                    <th>Request</th>
                    <th>Date Time</th>
                </tr>
                </thead>
                <tbody>
                <?php


                $n  = 0;
                foreach ($reportData as $key => $row) {
                    ++$n;
                    ?>

                    <tr>
                        <th scope="row"><?php echo $n; ?></th>
                        <td><?php echo ($row['id']) ? $row['id'] : '-'; ?></td>
                        <td><?php echo ($row['login']) ? $row['login'] : '-'; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['request']; ?></td>
                        <td><?php echo date('d/m/Y H:i:s', $row['ctime']); ?></td>
                    </tr>

                    <?php
                }
                ?>
            </table>

        </div>
    </div>
</div>
<?php $this->app->displayFooter(); ?>
