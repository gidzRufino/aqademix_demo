<section>
    <div class="card card-outline card-blue">
            <?php 
                if(count($discussionDetails) != 0): ?>
        <div class="card-body col-md-12 col-sm-12 row">
            <?php
                    $i=1;
                    foreach($discussionDetails as $discussion):?>
                <div class="card col-md-4 col-sm-4 float-left">
                    <div class="card-body">
                        <i class="fa fa-arrow-circle-right fa-fw"></i> 
                        <a href="#" onclick="document.location='<?php echo base_url('opl/student/discussionDetails/'.$discussion->dis_sys_code.'/'.$this->session->school_year.'/'.$gradeLevel.'/'.$subject_id)?>'" ><?php echo ucwords(strtolower($discussion->dis_title)) ?></a>
                    </div>
                </div>
            <?php endforeach; 
            ?>
        </div>
        <?php
                else:
                    ?>
                    <div class="card-body text-center">
                        <div>
                            <h3>No Lessons Available</h3>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
    </div>
</section>