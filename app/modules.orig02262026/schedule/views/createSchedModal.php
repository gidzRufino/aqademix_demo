<div id="schedDay"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Schedule
        </div>
        <div class="panel-body clearfix">
            <?php
                $attributes = array('class' => 'form-inline','role'=>'form', 'id'=>'addSched');
                echo form_open(base_url().'', $attributes);
            ?>
                <div class="control-group ">
                        <div class="controls">
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                From:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <span id="timeFrom_span"></span>
                                    
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                To:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <span id="timeTo_span"></span>
                                    <input type="hidden" id="cTimeID" name="time" />
                                </dd>
                            </dl
                            
                            
                        </div>
                    </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Day</dt>
                        <dd style="margin-left:35%;">
                            <span id="currentDay"></span>
                            <input type="hidden" id="cDayHidden" name="day" />
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Room:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputRoom" id="inputRoom" required>
                              <option value="0">Select Room</option> 
                                <?php 
                                       foreach ($rooms as $r)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $r->rm_id; ?>"><?php echo $r->room; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>  
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Select Option:</dt>
                        <dd style="margin-left:35%;">
                          <select onclick="selectDepartment(this.value)" name="inputOption" id="inputOption" style="width:100px; color:black;" required>
                            <option value="1">K-12</option>
                            <option value="2">College</option>
                        </select>
                        </dd>
                    </dl>
                </div>
            <div id="collegeDept" style="display: none">
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Course:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputCollegeCourse" id="inputCollegeCourse" style="width:250px;"  class="controls-row" required>
                               <option value="0">Select Course</option> 
                             <?php  foreach ($course as $c)
                                {     
                             ?>
                              <option value="<?php echo $c->course_id; ?>"><?php echo $c->course ?></option>  
                             <?php } ?>
                          </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Subject:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputCollegeSubject" id="inputCollegeSubject" style="width:120px;"  class="controls-row" required>
                               <option value="0">Select Subject</option> 
                             <?php  foreach ($collegeSubjects as $cs)
                                {     
                             ?>
                              <option value="<?php echo $cs->s_id; ?>"><?php echo $cs->sub_code ?></option>  
                             <?php } ?>
                          </select>
                        </dd>
                    </dl>
                </div>
            </div>
            <div id="k12" style="display: none;">
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Subject:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputSubject" id="inputSubject" style="width:120px;"  class="controls-row" required>
                               <option value="0">Select Subject</option> 
                             <?php  foreach ($subjects as $s)
                                {     
                             ?>
                              <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></option>  
                             <?php } ?>
                          </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Grade / Section:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputGrade" onclick="selectSection(this.value)" id="inputGrade" required>
                              <option>Select Grade Level</option> 
                                <?php 
                                       foreach ($grade as $level)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                <?php }?>
                            </select>
                            <select style="width:120px;"  name="inputSection" id="getSection" required>
                                  <option>Select Section</option>  
                              </select>
                        </dd>
                    </dl>
                </div>
            </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Teacher:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputTeacher" id="inputTeacher" required>
                              <option value="">Select Teacher</option> 
                                <?php 
                                       foreach ($employees->result() as $em)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $em->employee_id; ?>"><?php echo $em->lastname.', '.$em->firstname; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>
              <input type='hidden' name="timeFrom" id='inputTimeFrom' value='' />
              <input type='hidden' name="timeTo" id='inputTimeTo' value='' />

            <?php
                echo form_close();
            ?>            
          
            
        </div>
        <div class="panel-footer clearfix">
             <div class="control-group pull-right">
                <button onclick="createSched()" id="addRoomBtn" class="btn btn-small btn-primary">Create</button>
            </div>
        </div>
        
    </div>
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        $('#inputTeacher').select2()
        //$('#inputCollegeSubject').select2()
        //$('#inputCollegeCourse').select2()
});

    function selectDepartment(value)
    {
        if(value=='1')
            {
                $('#k12').show();
                $('#collegeDept').hide();
            }else{
                $('#collegeDept').show();
                $('#k12').hide();
            }
    }
    
    
    function createSched()
    {
        var option = $('#inputOption').val();
        if(option=='1')
        {
            var url = "<?php echo base_url().'schedule/createSched/' ?>"; // the script where you handle the form input.
        }else
        {
            url = "<?php echo base_url().'schedule/createCollegeSched/' ?>"; // the script where you handle the form input.
        }
        
        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: $('#addSched').serialize(), // serializes the form's elements.
               success: function(data)
               {
                   alert(data.msg)
                   if(option=='1')
                   {
                       document.location = "<?php echo base_url().'schedule/' ?>"
                   }else{
                       document.location = "<?php echo base_url().'schedule/college/' ?>"
                   }
               }
             });

        return false;
    }
    
    function finalTime(fromTo)
{
    var hour = $('#inputHour'+fromTo).val()
    var minutes = $('#inputMinutes'+fromTo).val()
    var AmPm = $('#'+fromTo).val()
    
    if(AmPm=="PM"){
        hour = parseInt(hour) + 12;
    }

    $('#inputFinal'+fromTo).val(hour+':'+minutes+':'+'00')
}

    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#getSection').html(data);
               }
             });

        return false;
    }
</script>