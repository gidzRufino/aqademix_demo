<!--Add Subject Modal-->

<div id="addSubjectModal" class="modal fade" style="width:300px; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h6 class="no-margin">Add Subject</h6>
        </div>
        <div class="panel-body clearfix">
            <div class="control-group">
               <div class="controls">
                   <select  tabindex="-1" id="inputSubjectAssign" style="width:100%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                       <option>Select Subject Here</option>
                       <option value="add">Add Subject</option>
                       <?php 
                            foreach ($subjects as $s) 
                              {   
                             ?>                        
                                <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject; ?></option>
                           <?php }?>
                   </select>

                </div>
            </div> 
            <div class="control-group">
                    <div class="controls">
                        <select onclick="selectSectionAssign(this.value)" style="width:100%; margin-bottom: 5px;"  tabindex="-1" id="inputGradeAssign"  class="populate select2-offscreen span2">
                            <option value='0'>Select Grade Level</option>
                            <?php 
                                  foreach ($GradeLevel as $level)
                                   {   
                                  ?>                        
                                     <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                <?php }?>
                        </select>

                     </div>
             </div> 
            <div class="control-group">
                    <div class="controls">
                        <select   tabindex="-1" id="inputSectionAssign" style="width:100%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                            <option>Select Section</option>

                        </select>

                     </div>

             </div> 
         <div class="pull-right">
             <a  href="#" id="submitAdmission" style="display:none;" onclick="setAssignment()" class="btn btn-danger">
                  Add Assignment
              </a>
             <a  href="#" id="submitAdmissionDisabled" disabled class="btn btn-danger">
                  Add Assignment
              </a>
         </div>   
         </div>    
         
        </div>
    </div>
</div>
<!--Schedule Modal-->

<div id="schedule" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
    <h3 id="myModalLabel">Set a Schedule</h3>
  </div>
  <div class="modal-body">
      <?php
            $attributes = array('class' => 'form-horizontal', 'id'=>'addSchedForm');
            echo form_open(base_url().'index.php/employee/saveSchedule', $attributes);
        ?> 
          <div class="control-group">
              <label class="control-label" for="input">DAY:</label> 
              <div class="controls">
                <select name="inputDay" id="inputDay" style="width:200px;">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
              </div>  
          </div>
          <div class="control-group">
              <label class="control-label" for="input">FROM:</label> 
              <div class="controls">
                      <select onclick="setFinalHour()" id="inputHourFrom" style="width:50px;">
                        <?php
                        for ($i=1; $i<=12; $i++)
                        {
                            if($i<10)
                            {
                                $i="0".$i;
                            }
                        ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                    </select> :  
                    <select onclick="setFinalHour()" id="inputMinutesFrom" style="width:50px;">
                        <?php
                        for ($i=1; $i<=60; $i++)
                        {
                            if($i<10)
                            {
                                $i="0".$i;
                            }
                        ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                    <select onclick="setFinalHour()" id="inputAmPmFrom" style="width:60px;">
                        
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                       
                    </select>
              </div>      
           </div>
          <div class="control-group"> 
              <label class="control-label" for="input">TO: </label> 
              <div class="controls">
                     <select onclick="setFinalHour()" id="inputHourTo" style="width:50px;">
                          <?php
                          for ($i=1; $i<=12; $i++)
                          {
                              if($i<10)
                              {
                                  $i="0".$i;
                              }
                          ?>
                          <option value="<?php echo $i ?>"><?php echo $i ?></option>
                          <?php } ?>
                      </select> :  
                      <select onclick="setFinalHour()" id="inputMinutesTo" style="width:50px;">
                          <?php
                          for ($i=1; $i<=60; $i++)
                          {
                              if($i<10)
                              {
                                  $i="0".$i;
                              }
                          ?>
                          <option value="<?php echo $i ?>"><?php echo $i ?></option>
                          <?php } ?>
                      </select>
                      <select onclick="setFinalHour()" id="inputAmPmTo" style="width:60px;">
                        
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                       
                    </select>
              </div>       
          </div>
          <input name="finalTime" type="hidden" id="finalTime" placeholder="08:00 AM - 09:00 AM" value="08:00 AM - 09:00 AM" />
          <input type="hidden" id="inputAssignmentID" name="inputAssignmentID" placeholder=""  required>
      </form>    
  </div>
    
  <div class="modal-footer">
        <div id="resultSection" class="help-block" ></div>
  </div>
</div>
<!--Advisory Assignment Modal-->


<div id="advisoryModal" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green clearfix">
        <div class="panel-heading clearfix">
            <h4 class="pull-left">Advisory Assignment</h4>
            <i class="pull-right fa fa-close pointer" data-dismiss="modal"></i>
        </div>
        <div class="panel-body">
                <select name="inputGradeModal" onclick="selectSection(this.value)" tabindex="-1" id="inputGradeModal" style="width:150px" class="populate select2-offscreen span2">
                     <option>Select Grade Level</option>
                     <?php 
                           foreach ($GradeLevel as $level)
                            {   
                           ?>                        
                              <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                         <?php }?>
                 </select>
                 <select  tabindex="-1" id="inputSectionModal" name="inputSectionModal" style="width:150px" class="populate select2-offscreen span2">
                     <option>Select Section</option>

                 </select>

        
        </div>
        <div class="pull-right">
             <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button data-dismiss="modal" id="addAdvisorySubmit" class="btn btn-primary">Save </button>

        </div>
    </div>
    
</div>

<script type="text/javascript">
    
         
    function setAssignment()
     {
         var teacher = $('#em_id').val();
         var subject = document.getElementById("inputSubjectAssign").value;
         var gradelevel = document.getElementById("inputGradeAssign").value;
         var section = document.getElementById("inputSectionAssign").value;
         
        var url = "<?php echo base_url().'academic/setAssignment'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "teacher="+teacher+"&subject="+subject+"&gradeLevel="+gradelevel+"&section="+section+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   if(data.status){
                       $('#notify_me').html(data.msg)
                   }else{
                       $('#subjectsAssignedTable').html(data.data)
                       $('#notify_me').html(data.msg)
                   }
                    $('#notify_me').show();
                    $('#notify_me').fadeOut(5000);
//                   $('#notify_me').html(data);
//                   $('#alert-info').fadeOut(5000);
               }
             });

        return false; 
     }
     
    function setFinalHour()
    {
        var hourFrom = document.getElementById("inputHourFrom").value;
        var minutesFrom = document.getElementById("inputMinutesFrom").value;
        var AmPmFrom = document.getElementById("inputAmPmFrom").value;
        var hourTo = document.getElementById("inputHourTo").value;
        var minutesTo = document.getElementById("inputMinutesTo").value;
        var AmPmTo = document.getElementById("inputAmPmTo").value;
        
        var finalTime = hourFrom+":"+minutesFrom+" "+AmPmFrom+" - "+hourTo+":"+minutesTo+" "+AmPmTo
        document.getElementById("finalTime").value = finalTime
        
    }
    
    $(document).ready(function() {

          $("#addSchedSubmit").click(function() {
            $("#addSchedForm").submit();
          }); 
          $("#addAdvisorySubmit").click(function() {
                var url = "<?php echo base_url().'academic/setAdviser/'?>"
                $.ajax({
                   type: "POST",
                   url: url,
                   data:'inputFacultyID='+$('#em_id').val()+"&inputGradeModal="+$('#inputGradeModal').val()+'&inputSectionModal='+$('#inputSectionModal').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements. 
                   success: function(data)
                   {
                       alert(data)
                       $('#advisoryModal').modal('hide');
                   }
                 });

            return false;  
          }); 
          $("#inputGradeModal").select2();
          $("#inputSectionModal").select2();
    });
</script>

<!-- End of Schedule Modal-->
