<div class="card">
    <div class="card-header text-center">
        My Classes
    </div>
    <div class="card-body">
        <div class="list-group">
         <?php
                foreach ($getAssignment as $ga)
                {   
            ?><a class="list-group-item list-group-item-action" href="<?php echo base_url();?>opl/classBulletin/<?php echo $this->session->school_year?>/NULL/<?php echo $ga->grade_id;?>/<?php echo $ga->section_id;?>/<?php echo $ga->subject_id;?>">
                        <span style="color:#BB0000;">
                            <?php 
                            if($ga->specs_id==0):
                                echo $ga->subject; ?>&nbsp;-&nbsp;<?php echo $ga->level;?>&nbsp;[&nbsp;<?php echo $ga->section; ?>&nbsp;]
                            <?php 
                            else:
                                echo $ga->specialization; ?>&nbsp;-&nbsp;<?php echo $ga->level;?>
                            <?php endif; ?>
                        </span>  <span class="badge badge-danger right float-right">2</span>  
                    </a>  
                    
            <?php } ?>
        </div>
    </div>
</div>