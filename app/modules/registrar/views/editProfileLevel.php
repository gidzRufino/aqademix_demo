<div id='editProfileLevel'>
    <div class='control-group' style='margin-right:20px; width:165px;'>
        <label class='control-label'>Grade  Level</label>
        <div class='controls'>
          <select name='inputGrade' style='width:230px;' onclick='selectSection(this.value)' id='inputGrade' class='controls' required>
              <option>Select Grade Level</option> 
             <?php 
                    foreach ($gradeLevel as $level)
                      {   
                ?>                        
              <option value='<?php echo $level->grade_id; ?>'><?php echo $level->level; ?></option>
              <?php }?>
            </select>
        </div>
  </div> 
    <div class='control-group' style='width:230px;'>
        <label class='control-label'>Section</label>
        <div class='controls' id='AddedSection'>
          <select name='inputSection' style='width:230px;' id='inputSection' class='pull-left controls' required>
              <option>Select Section</option>  
          </select>
        </div>
    </div>
    <div id='tle_specs' class='control-group' style='width:230px; display: none;'>
        <label class='control-label'>Specialization</label>
        <div class='controls'>
          <select name='inputSpecialization' style='width:230px;' id='inputSpecialization' class='pull-left controls' required>
                <option>Select Specialization</option>
                <?php
                  foreach ($specs as $s)
                  { 
                ?>                        
                    <option value='<?php echo $s->specialization_id; ?>'><?php echo $s->specialization; ?></option>
                
                <?php
                  }
                ?>
          </select>
        </div>
    </div>
    <div id='sh_strand' class='control-group' style='width:230px; display: none;'>
        <label class='control-label'>Strand</label>
        <div class='controls'>
            <?php $strand = Modules::run('registrar/getSHOfferedStrand'); ?>
          <select name='inputStrand' style='width:230px;' id='inputStrand' class='pull-left controls' required>
                <option>Select Strand</option>
                <?php
                  foreach ($strand as $str)
                  { 
                ?>                        
                    <option value='<?php echo $str->st_id; ?>'><?php echo $str->strand; ?></option>
                
                <?php
                  }
                ?>
          </select>
        </div>
    </div>
    <div class='control-group col-lg-12 no-padding'>
        <label class='control-label' for='inputBirthDate'>School Year</label>
        <select tabindex='-1' id='inputEditSY' name='inputEditSY' style='width:230px; font-size: 15px;'>
           <option>School Year</option>
           <?php 
                 foreach ($ro_year as $ro)
                  {   
                     $roYears = $ro->ro_years+1;
                     if($this->uri->segment(4)==$ro->ro_years):
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
     
    <input type='hidden' id='st_id' value='<?php echo base64_encode($st_id) ?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='saveProfileLevel()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    
</div>
