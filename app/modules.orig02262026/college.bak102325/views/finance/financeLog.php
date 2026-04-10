<?php
    switch ($sem):
        case 1:
            $semester = 'First Semester';
        break;
        case 2:
            $semester = 'Second Semester';
        break;
        case 3:
            $semester = 'Summer';
        break;
    endswitch;
?>
<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Audit Trail
            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
        
        <div class="btn-group pull-right" role="group" aria-label="">
                
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'">Accounts</button>
          </div>
                
    </h3>
    <div class='col-lg-12' style="height: 100vh; overflow-y: scroll;">
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
            $i=1;
            foreach ($financeLog as $fl):
            ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo strtoupper($fl->firstname.' '.$fl->lastname) ?></td>
                <td><?php echo date('F d, Y G:i:s', strtotime($fl->date_time)); ?></td>
                <td><?php echo $fl->remarks; ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
</div>