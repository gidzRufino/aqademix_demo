<h3>Teacher's Load</h3><h6>[ Click each row to view Class List ]</h6>
<table class="table table-bordered">
    <tr>
        <th>Subject</th>
        <th>Section Code</th>
        <th>Descriptive Title</th>
        <th>Units</th>
        <th>Days</th>
        <th>Time</th>
        <th>Room</th>
        <th># of Students</th>        
    </tr>
    <?php
    $tLoad = Modules::run('college/schedule/getSchedulePerTeacher', $teacher_id, $sem, $school_year, 1);
    foreach ($tLoad as $r):
        $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $r->sec_id, $r->semester, $school_year);
        ?>
        <tr class="pointer" onclick="window.open('<?php echo base_url('college/subjectmanagement/printStudentsPerSubject/') . $r->s_id . '/' . $r->sec_id . '/' . $r->semester . '/' . $school_year ?>', '_blank')">
            <td><?php echo $r->sub_code; ?></td>
            <td><?php echo $r->section; ?></td>
            <td><?php echo $r->s_desc_title; ?></td>
            <td><?php echo $r->s_lect_unit ?></td>
            <td>
                <?php
                $scheds = Modules::run('college/schedule/getSchedulePerSection', $r->sec_id, $sem, $school_year);
                $sched = json_decode($scheds);
                echo ($sched->count > 0 ? $sched->day : '');
                ?>
            </td>
            <td><?php echo ($sched->count > 0 ? $sched->time : '') ?></td>
            <td><?php echo ($sched->count > 0 ? $sched->room : 'TBA'); ?></td>
            <td class="text-center"><?php echo $students->num_rows();    ?></td>
        </tr>
        <?php
    endforeach;
//    foreach ($result as $r):
//        $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $r->sec_id, $r->semester, $r->school_year);
//        $scheds = Modules::run('college/schedule/getSchedulePerSection', $r->sec_id, $r->semester, $r->school_year);
//        $sched = json_decode($scheds);
//        
    ?>
<!--        <tr class="pointer" onclick="window.open('//<?php // echo base_url('college/subjectmanagement/printStudentsPerSubject/') . $r->s_id . '/' . $r->sec_id . '/' . $r->semester . '/' . $r->school_year    ?>', '_blank')">
    <td>//<?php // echo $r->sub_code    ?></td>
    <td>//<?php // echo $r->section    ?></td>
    <td>//<?php // echo $r->sec_id    ?></td>
    <td class="text-center">//<?php // echo $r->s_lect_unit    ?></td>
    <td class="text-center">
        //<?php // echo ($sched->count > 0 ? $sched->day : 'TBA');    ?>
    </td> 
    <td class="text-center">-->
    <?php
//                echo ($sched->count > 0 ? $sched->time : 'TBA');
//                
    ?>
    <!--            </td>
                <td class="text-center">
                    //<?php
//                echo ($sched->count > 0 ? $sched->room : 'TBA');
//                
    ?>
                </td>
                <td class="text-center">//<?php // echo $students->num_rows();    ?></td>
            </tr>-->
<?php // endforeach;   ?>
</table>
<style type="text/css">
    tr:hover{
        background-color: #ffff99;
    }
</style>