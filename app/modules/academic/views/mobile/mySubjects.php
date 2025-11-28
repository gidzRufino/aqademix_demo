<div data-role="page" id="teachersLoad">
    <div data-role="content">
        <?php echo Modules::run('mobile/teachersHeaderPanel'); ?>
        <div class='mobile-blue-trans no-padding no-margin clearfix' style='height:auto;'>
            <div class="col-xs-12 no-padding">
                <?php
                if($this->session->userdata('is_adviser')){ 
                    $advisory = Modules::run('academic/getAdvisory', $this->session->userdata('employee_id'), $this->session->userdata('school_year'), $this->session->userdata('advisory'));
                    
                    ?>
                <div style="height:30px; font-weight: 600;" class="mobile-panel-blue padding-5 " data-toggle="collapse" data-parent="#accordion" data-target="#personalInfo">
                    Advisory Class:
                 </div> 
                <h4 style="line-height: 10px; color:#fff;" class="selectTableRow" >
                         <a style="text-align:center; margin-left:10px;" href="<?php echo base_url();?>index.php/attendance/dailyPerSubject/<?php echo $advisory->row()->grade_id.'/'.$advisory->row()->section_id; ?> " >
                            <span style="color:#fff;">
                                    <?php 
                                    echo $advisory->row()->level; ?>&nbsp;[&nbsp;<?php echo $advisory->row()->section;?>&nbsp;]
                            </span>
                         </a>  
                    </h4>
                <?php }else{ ?>
                    <h4 style="line-height: 10px;" class="selectTableRow" >Advisory Class:&nbsp;<span style="color:#BB0000;">NONE</span></h4>
                <?php } ?>    
            </div>
        <hr>
        <div class="col-xs-12 no-padding" style="margin-top:20px;">
           <div style="height:30px; font-weight: 600;" class="mobile-panel-blue padding-5 " data-toggle="collapse" data-parent="#accordion" data-target="#personalInfo">
                Subjects Taught:
            </div> 
                <?php

                    foreach ($getAssignment as $ga)
                    {   
                ?>
                <div class='col-xs-12 panel mobile-panel-name pointer'>
                    <h4>
                        <a style='color:black;' onclick='document.location=this.href' href="<?php echo base_url();?>index.php/attendance/dailyPerSubject/<?php echo $ga->grade_id.'/'.$ga->section_id; ?> ">
                            <span><?php echo $ga->subject; ?>&nbsp;-&nbsp;<?php echo $ga->level;?>&nbsp;[&nbsp;<?php echo $ga->section;?>&nbsp;]</span>  
                        </a>
                    </h4>
                </div>        

                <?php } ?>  
        </div>
        </div>
        
    </div>
</div>
<input type="hidden" id="setSection"/>

<script type="text/javascript">

$('body').bind("swiperight", function(e){
              window.history.back()
     })
     $('body').bind("swipeleft", function(e){
              window.history.go('#parentFinance')
     })
    
</script>