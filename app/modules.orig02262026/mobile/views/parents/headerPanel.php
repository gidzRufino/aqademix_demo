<div style="z-index: 2000">
    <h1 id="headerTitle" style="text-align:right; padding:5px; margin:0; font-size:30px; color: white"><?php echo $settings->set_school_name ?></h1>
</div>
<div class="col-xs-12 no-padding">
    <a href="#parentRoster" data-transition="flow">
        <div  
        class='col-xs-2 panel mobile-panel-blue no-padding no-margin pointer no-radius '>
       <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
           <img style="width:30px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/studentInfo.png') ?> " />
       </div>
    </div>
    </a>
    <a href="#parentFinance" data-transition="flow" >
        <div 
            class='col-xs-2 panel mobile-panel-red no-padding no-margin pointer no-radius '>
           <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
               <img style="width:23px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/teachers.png') ?> " />
           </div>
        </div>
    </a>
    
   <div onclick="document.location='<?php echo base_url('registrar/getAllStudents') ?>'" 
        class='col-xs-2 panel mobile-panel-orange no-padding no-margin pointer no-radius '>
       <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
           <img style="width:23px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/grading.png') ?> " />
       </div>
   </div>
   <div onclick="document.location='<?php echo base_url('registrar/getAllStudents') ?>'" 
        class='col-xs-2 panel mobile-panel-pink no-padding no-margin pointer no-radius '>
       <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
           <img style="width:23px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/attendance.png') ?> " />
       </div>
   </div>
   <div onclick="document.location='<?php echo base_url('registrar/getAllStudents') ?>'" 
        class='col-xs-2 panel mobile-panel-blue no-padding no-margin pointer no-radius '>
       <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
           <img style="width:30px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/communication.png') ?> " />
       </div>
   </div>
   <div onclick="document.location='<?php echo base_url('registrar/getAllStudents') ?>'" 
        class='col-xs-2 panel mobile-panel-green no-padding no-margin pointer no-radius '>
       <div class='panel-heading text-center no-padding panel-tab-height no-radius'>
           <img style="width:30px; padding-top:3px; margin-bottom:7px; " src="<?php echo base_url('images/icons/finance.png') ?> " />
       </div>
   </div>
</div>