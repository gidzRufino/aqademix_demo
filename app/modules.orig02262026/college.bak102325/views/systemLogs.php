<style>
    .pagination
    {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
</style>

<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">System Audit Trail
        
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
          </div>
                
    </h3>
    <div class='col-lg-12' style="height: 100vh; overflow-y: scroll;">
    <div id="links" class="pull-right">
        <?php echo $links; ?>
    </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account Incharge</th>
                    <th>Date / Time</th>
                    <th>System Log</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i=($offset==NULL?1:$offset+1);
            foreach ($systemLogs as $sl):
            ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo strtoupper($sl->firstname.' '.$sl->lastname) ?></td>
                <td><?php echo date('F d, Y G:i:s', strtotime($sl->log_timestamp)); ?></td>
                <td><?php echo $sl->remarks; ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
</div>