<div class="col-lg-12">
    <table class="table table-stripped">
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
                <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year); 
                    $sched = json_decode($scheds);
                    echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                    
                    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);
                ?>
            </td>
            <td class="text-center">
                <button 
                    sub_code ="<?php echo $s->sub_code ?>"
                    tchr ="<?php echo strtoupper($sched->instructor) ?>"
                    sec_id="<?php echo $s->sec_id ?>"
                    units="<?php echo ($s->sub_code=="NSTP 11" || $s->sub_code=="NSTP 12"|| $s->sub_code=="NSTP 1"|| $s->sub_code=="NSTP 2"?3:$s->s_lect_unit + $s->s_lab_unit) ?>"
                    timeDay="<?php echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA'); ?>"
                    s_id="<?php echo $s->s_id ?>"
                    t_from="<?php echo $sched->time_from ?>"
                    t_to="<?php echo $sched->time_to ?>"
                    day="<?php echo $sched->day ?>"
                    
                    class="btn btn-xs btn-danger btn-selectSched" 
                        onclick="modalControl('studentDashboard', 'scheduleModal'), 
                        fetchSearchSubject('<?php echo $s->sub_code ?>','<?php echo strtoupper($sched->instructor) ?>','<?php echo $s->sec_id ?>'
                        , '<?php echo ($s->sub_code=="NSTP 11" || $s->sub_code=="NSTP 12"|| $s->sub_code=="NSTP 1"|| $s->sub_code=="NSTP 2"?3:$s->s_lect_unit + $s->s_lab_unit) ?>'
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