<table class="table">
    <tr>
        <th></th>
        <th>Name</th>
        <th>Position</th>
        <th>Action</th>
    </tr>
    <?php
    //print_r($employee);
    foreach ($employee as $s) {
        //echo $s->isActive;
        ?>
        <tr>
            <td style="width:60px; text-align: center;"><img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'uploads/' . ($s->avatar == "" ? 'noImage.png' : $s->avatar) ?>" /></td>
            <td><?php echo strtoupper($s->lastname . ', ' . $s->firstname . ($s->middlename != '' ? ' ' . substr($s->middlename, 0,1) . '.' : '')); ?></td>
            <td><?php echo $s->position; ?></td>
            <td><button class="btn btn-md btn-success" onclick="addSubNotif('<?php echo base64_encode($s->uid) ?>', '<?php echo $s->firstname . ' ' . $s->lastname ?>')"><i class="fa fa-plus-circle"></i>&nbsp;Add</button></td>
        </tr> 
    <?php } ?>

</table> 