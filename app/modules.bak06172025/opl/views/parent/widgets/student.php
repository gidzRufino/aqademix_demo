<div class="card">
    <div class="card-header text-center">
        <span>My Kids</span>
    </div>
    <div class="card-body" id="subjectListMain">
        <div class="list-group">
            <?php
            $childLinks = explode(',', $this->session->basicInfo->child_links);

            foreach ($childLinks as $cl):
                if ($cl != ''):
                    $student = Modules::run('opl/p/getSingleStudent', $cl, $this->session->school_year);
                    //print_r($student);
                    ?>
                    <a class="list-group-item list-group-item-action search-list" href="<?php echo base_url('opl/p/classBulletin/' . $student->grade_id . '/' . $student->section_id . '/' . $student->school_year); ?>">
                        <span style="color:#BB0000;">
                            <?php echo ucwords(strtolower($student->firstname . ' ' . $student->lastname)); ?>&nbsp;[<?php echo $student->level . ' - ' . $student->section ?>]
                        </span>
                        <span class="badge badge-danger right float-right"></span>  
                    </a>  
                    <?php
                endif;
            endforeach;
            ?>

        </div>
    </div>
</div>