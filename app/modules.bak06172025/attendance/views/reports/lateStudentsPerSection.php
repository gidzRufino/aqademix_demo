<table class="table table-stripped">
    <tr class="alert-info">
        <th class="col-lg-1">#</th>
        <th class="col-lg-2">ID</th>
        <th class="col-lg-5 text-center">Full Name</th>
        <th class="col-lg-2 text-center">Time In</th>
        <th class="col-lg-2 text-center">Time In PM</th>
        <td class="text-center">Action</td>
    </tr>
    <?php
        $i=0;
        foreach ($tardy->result() as $t):
            $i++;
    ?>
    <tr id="trLate_<?php echo $t->att_id ?>">
        <td><?php echo $i ?></td>
        <td><?php echo $t->st_id ?></td>
        <td class=" text-center"><?php echo strtoupper($t->lastname.', '.$t->firstname) ?></td>
        <td class=" text-center"><?php echo ($t->time_in!=''?date('h:i a', strtotime(strlen($t->time_in)<4?'0'.$t->time_in:$t->time_in)):'') ?></td>
        <td class=" text-center"><?php echo ($t->time_in_pm!=''?date('h:i a', strtotime($t->time_in_pm)):'') ?></td>
        <td class="text-center"><button class="btn btn-xs btn-danger" onclick="removeFromLate('<?php echo $t->att_id ?>')">remove</button></td>
    </tr>
    <?php 
        endforeach;
    ?>
</table>
