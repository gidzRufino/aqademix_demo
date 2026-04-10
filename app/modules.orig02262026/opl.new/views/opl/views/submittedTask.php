<?php if ($totalStudents > 0): ?>
    <div class='card '>
        <div class='card-header text-center'>
            Students who submitted
        </div>
        <div class='card-body no-padding'>
            <div class='list-group'>

                <?php
                foreach ($submittedTask as $st):
                    $student = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $st->ts_submitted_by, $this->session->school_year);
                    ?>
                <a class='list-group-item' href='<?php echo base_url('opl/viewTaskDetails/'.$st->ts_task_id.'/'.$grade_level.'/'.$section_id.'/'.$subject_id) ?>'>
                        <?php echo ucwords(strtolower($student->lastname . ', ' . $student->firstname)); ?>
                    </a>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>

    <?php
else:
    echo "<h6 class='text-center'> No Students has Submitted </h6>";
endif;