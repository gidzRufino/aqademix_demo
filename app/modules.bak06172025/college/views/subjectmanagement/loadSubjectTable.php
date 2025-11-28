<div class="col-lg-12">
    <table class="table table-stripped">
        <tr>
            <th>Subject</th>
            <th>Section Code</th>
            <th>Descriptive Title</th>
            <th>Schedule</th>
            <th>Action</th>
            <th># of Students</th>
            <th>Status</th>
        </tr>
        <?php
        foreach ($subjects as $s):
            $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $sem, $school_year); 
            $sched = json_decode($scheds);
            $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $s->sec_id, $sem,$school_year);
            
            if($s->sec_sem == $sem):
                ?>
                <tr>
                    <td><?php echo $s->sub_code; ?></td>
                    <td><?php echo $s->section ?></td>
                    <td><?php echo $s->s_desc_title; ?></td>
                    <td class="text-center">
                        <?php
                                echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                        ?>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-xs btn-danger" onclick="addSubject('<?php echo $s->s_id ?>','<?php echo ($s->pre_req=="None"?'None':$s->pre_req) ?>','<?php echo $s->sec_id ?>')"><i class="fa fa-plus"></i></button>
                    </td>
                    <td class="text-center"><?php 

                        if($students->num_rows()>=45):
                            $style = 'text-danger';
                        else:
                            $style = 'text-success';
                        endif;
                    ?>
                        <span class="<?php echo $style ?>">
                            <?php echo $students->num_rows(); ?>
                        </span>
                    </td>
                    <td>
                        <?php
                            if($students->num_rows()>45):
                                $status = 'Over Populated';
                            elseif($students->num_rows()==45):
                                $status = 'Closed';
                            elseif($students->num_rows()<45):
                                $status = 'Open';
                            endif;
                        ?>
                        <span class="<?php echo $style ?>">
                            <?php echo $status ?>
                        </span>
                    </td>
                </tr>
                <?php    
            endif;
        endforeach;
        ?>
    </table>
</div>