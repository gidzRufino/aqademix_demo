<div class="card">
    <div class="card-header text-center">
        My Subjects
        <i class="fa fa-search float-right"></i>
    </div>
    <div class="card-body">
        <div class="list-group">
         <?php
                foreach ($subjectsList as $sub)
                {   
            ?><a class="list-group-item list-group-item-action" href="<?php echo base_url();?>opl/student/classBulletin/<?php echo $sub->subject_id;?>/<?php echo $this->session->school_year?>">
                        <span style="color:#BB0000;">
                            <?php 
                             echo $sub->subject
                            ?>
                        </span>  
                    </a>   
                    
            <?php } ?>
        </div>
    </div>
</div>