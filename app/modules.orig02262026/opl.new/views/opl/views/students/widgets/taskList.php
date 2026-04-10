<div class="card">
    <div class="card-header text-center">
        My Tasks
    </div>
    <div class="card-body">
        <?php if(count($tasks)!=0): ?>
        <div class="list-group">
         <?php
                foreach ($tasks as $t)
                {   
            ?><a class="list-group-item list-group-item-action" href="<?php echo base_url();?>opl/student/viewTaskDetails/<?php echo $t->task_auto_id;?>/<?php echo $t->task_subject_id;?>/<?php echo $this->session->school_year?>">
                        <span style="color:#BB0000;">
                            <?php 
                             echo $t->task_title .' [ '.$t->tt_type.' ]';
                            ?>
                        </span>  
                    </a>   
                    
            <?php } ?>
        </div>
        <?php else:
                echo '<p class="text-center">No Task this time</p>';
            endif; ?>
    </div>
</div>