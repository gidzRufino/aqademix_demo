<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Section Code</th>
            <th>Descriptive Title</th>
            <th>Schedule</th>
            <th class="text-center">Units</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <?php
    $totalUnits = 0;
    foreach ($subjects as $s):
        $totalUnits += $s->s_lect_unit;
    ?>
    <tr id="tr_<?php echo $s->sched_gcode ?>">
        <td><?php echo $s->sub_code; ?></td>
        <td><?php echo $s->section; ?></td>
        <td><?php echo $s->s_desc_title; ?></td>
        <td>
            <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year); 
                $sched = json_decode($scheds);
                echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'');
            ?>
        </td>
        <td class="text-center"><?php echo $s->s_lect_unit; ?></td>
        <td class="text-center">
            <button onclick="getDeansListOfStudentPerSubject('<?php echo $s->faculty_id; ?>', '<?php echo $s->sec_id; ?>', '<?php echo $s->sec_sub_id; ?>')" class="btn btn-xs btn-danger">View Grades</button>
        </td>
    </tr>
    <?php    
    endforeach;
    if($totalUnits > 0):
    ?>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th class="text-center"><?php echo $totalUnits; ?></th>
            <th></th>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>