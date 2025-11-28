
<?php if ($this->uri->segment(3)!=''){  ?>

<div class="well well-small" >
  <div class="row">
    <div class="span1 pull-left">
      
      <?php   
      
        $image = $searched_student->avatar;
      
      ?>
      
      <img alt="Upload Image Here" src="<?php echo base_url()?>uploads/<?php echo $image;?>" style=" top:10px; left: 5px; width:70px; height:70px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-circle"/>
      
      <?php } ?>

    </div>
    <div class="span4 pull-left" style="padding-top:5px;">
      
      <?php 
     
        if ($this->uri->segment(3)!=''){
	  	    $student_full_name = "";
	        $student_full_name = $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname; 
	        $student_level_section = $searched_student->level ." / ".$searched_student->section;
	        $student_id = $searched_student->user_id;
	        $slevelID = $searched_student->grade_level_id;
	        $splan = $finance_plan->plan_description;
	        $studentAccountID = $finance_plan->accounts_id;
	        $student_planID = $finance_plan->plan_id;
      ?>               
      
      <h5 style="color:black; margin: 0 0 0 0px;">Name: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h5>
      <h6 style="color:black; margin: 0 0 0 0px;">Student ID: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->user_id;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Grade Level: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->level;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Section: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->section;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Payment Plan: &nbsp;<span id="planName" style="color:#BB0000;"><?php echo $splan;?></span> </h6>
      

    </div>
    <div class="span3 pull-right">
      
      <?php } if ($this->uri->segment(3)!=''){ ?>
      
      <h5 style="color:#379EBC; margin:3px 0;">Account Summary</h5>
      <h6 style="margin: 0 0 0 20px;">Total Charge: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltcharge"></span></h6>
      <h6 style="margin: 0 0 0 20px;">Total Credit: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltcredit"></span></h6>
      <h6 style="margin: 0 0 0 20px;">Total Balance: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltbalance"></span></h6>    
      <h6 style="margin: 0 0 0 20px;">Balance Due: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltbalance_due"></span></h6>    

      <?php } ?>

    </div>
  </div>
</div>