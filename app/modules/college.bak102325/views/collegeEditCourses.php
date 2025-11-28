<div id='editProfileLevel'>
    <div class='control-group' style='margin-right:20px; width:200px;'>
        <label class='control-label'>Select Course</label>
        <div class='controls'>
          <select name='inputGrade' id='inputGrade' class='controls' required style='width:200px;'>
              <option>Select Course</option> 
             <?php 
                    foreach ($course as $level)
                      {   
                ?>                        
              <option value='<?php echo $level->course_id; ?>'><?php echo $level->short_code.'[ '.$level->course .' ]'; ?></option>
              <?php }?>
            </select>
        </div>
  </div> 
  <div class='control-group' style='width:230px;'>
        <label>Year Level</label><br />
        <div id='AddedSection'>
          <select name='inputYear' id='inputYear' style='width:200px;' required>
                <option>Select Year Level</option>
                <option value='1'>First Year</option>
                <option value='2'>Second Year</option>
                <option value='3'>Third Year</option>
                <option value='4'>Fourth Year</option>
                <option value='5'>Fifth Year</option>
            </select>
        </div>
    </div>
  <div class='control-group' style='width:230px;'>
       <label>Semester</label><br />
        <div id='AddedSection'>
          <select name='inputSemester' id='inputSemester' style='width:200px;' required>
                <option>Select Semester</option>
                <option value='1'>First</option>
                <option value='2'>Second</option>
                <option value='3'>Summer</option>\
            </select>
        </div>
    </div>
    <div class='control-group'>
        <label class='control-label' for='inputBirthDate'>School Year</label>
        <select tabindex='-1' id='inputSY' name='inputSY' style='width:200px; font-size: 15px;'>
           <option>School Year</option>
           <?php 
                 foreach ($ro_year as $ro)
                  {   
                     $roYears = $ro->ro_years+1;
                     if($this->uri->segment(3)==$ro->ro_years):
                         $selected = 'Selected';
                     else:
                         $selected = '';
                     endif;
                 ?>                        
               <option <?php echo $selected; ?> value='<?php echo $ro->ro_years; ?>'><?php echo $ro->ro_years.' - '.$roYears; ?></option>
               <?php }?>
       </select>
    </div> 
<div style='margin:5px 0 10px; float:right;'>
     
    <input type='hidden' id='editCourse_st_id' value='<?php echo $st_id ?>' />
    <input type='hidden' id='editAdmission_id' value='<?php echo $admission_id ?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='saveCollegeLevel()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    
</div>
