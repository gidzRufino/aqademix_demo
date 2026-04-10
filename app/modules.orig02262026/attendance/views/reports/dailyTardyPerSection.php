<table class="table table-stripped">
    <tr class="alert-info">
        <th class="col-lg-3">Section</th>
         <th class="text-center">Number of Present Students</th>
        <th class="text-center">Number of Late Students</th>
    </tr>
    <?php 
        foreach ($section->result() as $sec):
            $totalAttendance = Modules::run('attendance/attendance_reports/getAttendancePerSection', $sec->s_id, $date);
            $totalTardy = Modules::run('attendance/attendance_reports/tardyPerSection', $date,  $sec->s_id);
    ?>
    <tr onclick="lateStudentsPerSection('<?php echo $date ?>', '<?php echo $sec->s_id ?>', '<?php echo $sec->level.' - '.$sec->section ?>')">
        <td><?php echo $sec->section ?></td>
        <th class="text-center"><?php echo $totalAttendance->num_rows(); ?></th>
        <th class="text-center pointer" ><?php echo $totalTardy->num_rows(); ?></th>
    </tr>
    <?php 
        endforeach;
    ?>
</table>
