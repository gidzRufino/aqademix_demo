
<?php
//print_r($employee);
foreach ($students as $s) {
    //echo $s->isActive;
    ?>
    <ul class="pointer" style="width: 550px;" onclick="">
        <li style="list-style: none; font-size: small"><?php echo strtoupper($s->lastname . ', ' . $s->firstname . ($s->middlename != '' ? ' ' . substr($s->middlename, 0, 1) . '.' : '')); ?></li>
    </ul> 
<?php } ?>
