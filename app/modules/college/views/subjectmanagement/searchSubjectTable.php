<div class="col-lg-12">
    <table class="table table-stripped">
        <tr>
            <th>Subject</th>
            <th>Section Code</th>
            <th>Descriptive Title</th>
            <th>Schedule</th>
            <th>Semester</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($subjects as $s):
        ?>
        <tr>
            <td><?php echo $s->sub_code; ?></td>
            <td><?php echo $s->section; ?></td>
            <td><?php echo $s->s_desc_title; ?></td>
                <td class="text-center">
                    <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $sem, $school_year); 
                        $sched = json_decode($scheds);
                        echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                    ?>
                </td>
                <td class="text-center"><?php echo ($sem==1?'1st':($sem==2?'2nd':'Summer')) ?></td>
            <td class="text-center">
                <button class="btn btn-xs btn-danger" onclick="assignSubject('<?php echo $sched->sched_code; ?>', '<?php echo $s->spc_id; ?>', '<?php echo $s->sec_id ?>' )"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        <?php    
        endforeach;
        ?>
    </table>
</div>