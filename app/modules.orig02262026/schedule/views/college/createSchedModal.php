<div id="schedDay"  style="width:50%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Schedule
        </div>
        <div class="panel-body clearfix">
            <?php
                $attributes = array('class' => 'form-inline','role'=>'form', 'id'=>'addSched');
                echo form_open(base_url().'', $attributes);
            ?>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Room:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width:250px;"  name="inputRoom" id="inputRoom" required>
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
                        <dt style="width:30%;">Year Level:</dt>
                        <dd style="margin-left:35%;">
                          <select tabindex="-1" id="yearLevel" name="yearLevel" style="width:250px;" >
                                <option>Select Year Level</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                                <option value="5">Fifth Year</option>

                            </select>
                        </dd>
                    </dl>
                    
                 </div>

                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Semester:</dt>
                        <dd style="margin-left:35%;">
                            <select onclick="getCollegeSubjects()" tabindex="-1" id="inputSem" name="inputSem" style="width:250px;" >
                              <option>Select Semester</option>
                              <option value="1">First Semester</option>
                              <option value="2">Second Semester</option>
                              <option value="3">Summer</option>

                          </select>
                        </dd>
                    </dl>
                    
                 </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Subject:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputCollegeSubject" id="inputCollegeSubject"  style="width:250px;"  class="controls-row" required>
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
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Teacher:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width:250px;"  name="inputTeacher" id="inputTeacher" required>
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
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Pick Schedule Color:</dt>
                        <dd style="margin-left:35%;">
                          <input type="text" value="000" style="width:50px;" name="colorCode" class="pick-a-color form-control">
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
                <button onclick="getSchedule()" id="addRoomBtn" class="btn btn-small btn-primary">Create</button>
            </div>
        </div>
        
    </div>
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        $('#inputTeacher').select2();
        $(".pick-a-color").pickAColor();
        //$('#inputCollegeSubject').select2()
        //$('#inputCollegeCourse').select2()
});

  

    function getCollegeSubjects(){
      var yearLevel = $('#yearLevel').val();
      var sem = $('#inputSem').val();
      var course_id = $('#inputCollegeCourse').val();
      var url = "<?php echo base_url().'coursemanagement/selectSpecificSubjectPerCourse/'?>"+course_id+'/'+yearLevel+'/'+sem; // the script where you handle the form input.

        $.ajax({
               type: "GET",
               url: url,
               data: "level_id="+yearLevel+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputCollegeSubject').html(data);
               }
             });

        return false;
    }
</script>