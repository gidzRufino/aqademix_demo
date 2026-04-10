<div class="col-lg-12 no-padding">
    <table class="table table-stripped table-responsive">
        <tr>
            <th>Subject</th>
            <th>Section Code</th>
            <th>Descriptive Title</th>
            <th>Schedule</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($subjects as $s):
        ?>
        <tr
            tr_id ="<?php echo $s->s_id ?>"
            >
            <td><?php echo $s->sub_code; ?></td>
            <td><?php echo $s->section; ?></td>
            <td><?php echo $s->s_desc_title; ?></td>
            <td class="text-center">
                <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester,  $school_year); 
                    $sched = json_decode($scheds);
                    echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                    
                    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);
                ?>
            </td>
            <td class="text-center">
                <button class="btn btn-xs btn-danger" 
                        onclick="modalControl('studentDashboard', 'scheduleModal'), 
                        fetchSchedule('<?php echo $s->sub_code ?>','<?php echo strtoupper($sched->instructor) ?>','<?php echo $s->sec_id ?>'
                        , '<?php echo $s->s_lect_unit + $s->s_lab_unit ?>'
                        ,'<?php echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA'); ?>','<?php echo $s->s_id ?>'
                        ,'<?php echo $sched->time_from ?>','<?php echo $sched->time_to ?>','<?php echo $sched->day ?>');
                        
                        " ><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        <?php    
        endforeach;
        ?>
    </table>
</div>