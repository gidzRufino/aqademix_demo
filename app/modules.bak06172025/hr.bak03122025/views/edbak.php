<div id='addressInfo'>
    <div class='control-group pull-left'>
              <label class='control-label'>Course</label>
              <div class='controls'>
                <input onkeydown='searchCourse(this.value)'  type='text' name='street' value='<?php echo $course ?>' placeholder='<?php echo $course ?>' id='inputCourse' />
                
              </div>
              <div style='min-height: 100px; background: #FFF; width:200px; display: none; z-index: 1000;' class='resultOverflow' id='courseSearch'>
                          
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>School</label>
              <div class='controls'>
                <input onkeydown='searchSchool(this.value)' value='<?php echo $school_name ?>' style='width:220px;' name='inputNameOfSchool' type='text' id='inputNameOfSchool' placeholder='Name of School' required>
              </div>
              <div style='min-height: 30px; background: #FFF; width:200px; display: none;' class='resultOverflow' id='collegeSearch'>
                          
               </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Address</label>
              <div class='controls'>
                <input type='text' name='lastname' value='<?php echo $school_add ?>' placeholder='<?php echo $school_add ?>' id='inputAddressOfSchool' />
              </div>
              
    </div>
                 
</div>
<div style='margin:5px 0 10px; float:right;'>
     
    <input type='hidden' id='collegeId' value='<?php echo $school_id ?>' />
    <input type='hidden' id='courseId' value='<?php echo $course_id ?>' />
    <input type='hidden' id='t_id' value='<?php echo $t_id ?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='editAcademicInfo()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    

