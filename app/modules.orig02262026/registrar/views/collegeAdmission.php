<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label>First Name</label>
          <?php
             $inputFirstName = array(
                            'name'        => 'inputCFirstName',
                            'id'          => 'inputCFirstName',
                            'class'          => 'form-control',
                            'placeholder'  => 'First Name',
                            'onkeypress' => "notEmpty(document.getElementById('inputGrade'), 'Please Select Grade Level')",
                            'style' => 'margin-bottom:0;'


                          );

              echo form_input($inputFirstName);

            ?>    
    </div>
  <div class="form-group col-lg-3">
    <label>Middle Name</label>

      <?php
         $inputMiddleName = array(
                        'name'        => 'inputCMiddleName',
                        'id'          => 'inputCMiddleName',
                        'class'       => 'form-control',
                        'placeholder' => 'Middle Name',
                        'onkeypress' => "notEmpty(document.getElementById('inputCFirstName'), 'Please input First Name')",
                        'style' => 'margin-bottom:0;'
                      );

          echo form_input($inputMiddleName);

        ?> 
  </div>

  <div class="form-group  col-lg-3">
    <label>Last Name</label>
      <?php
         $inputLastName = array(
                        'name'        => 'inputCLastName',
                        'id'          => 'inputCLastName',
                        'class'          => 'form-control',
                        'placeholder'  => 'Last Name',
                        'onkeypress' => "notEmpty(document.getElementById('inputCMiddleName'), 'Please input Middle Name')",
                        'style' => ' margin-right:10px; margin-bottom:0;'
                      );

          echo form_input($inputLastName);

        ?> 
  </div>

  <div class="form-group col-lg-3">
      <label>Select Course</label><br />
         <select style="height:35px; width: 200px;" name="getCourse" onclick="setId(this.value)" id="getCourse" required>
              <option>Select Course</option> 
                <?php 
                       foreach ($course as $level)
                         {   
                   ?>                        
                        <option value="<?php echo $level->course_id; ?>"><?php echo $level->short_code; ?></option>
                <?php }?>
            </select>
  </div> 
</div>

<div class="col-lg-12">
   <div class="form-group col-lg-3">
        <label>Year Level</label><br />
        <div id="AddedSection">
          <select name="inputYear" id="inputYear" style="width:225px;" required>
                <option>Select Year Level</option>
                <option value="1">First Year</option>
                <option value="2">Second Year</option>
                <option value="3">Third Year</option>
                <option value="4">Fourth Year</option>
                <option value="5">Fifth Year</option>
            </select>
        </div>
    </div>
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputNationaly">Nationality</label>
        <input class="form-control"  name="inputCNationality" type="text" id="inputCNationality" placeholder="Nationality">

    </div>
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputCReligion">Religion</label>
        <div class="controls">
            <select name="inputCReligion" id="inputCreligion" style="width:225px;" required>
            <option>Select Religion</option>
            <?php 
                foreach ($religion as $r)
                  {   
                ?>                        
              <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

              <?php } 

              ?>
            </select><a class="help-inline" 
              rel="clickover" 
              data-content=" 
                   <div style='width:100%;'>
                   <h6>Add Religion</h6>
                   <input type='text' id='addreligion' />
                   <div style='margin:5px 0;'>
                   <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                   <a href='#' id='religion' data-dismiss='clickover' table='religion' column='religion' pk='rel_id' retrieve='getReligion' onclick='saveNewValue(this.id)' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                   </div>
                    "   
              class="btn" data-toggle="modal" href="#">[ Add Religion ]</a>
        </div>
    </div>     

    <div class="form-group col-lg-3">
        <label class="control-label" for="inputGender">Gender</label>
        <div class="controls">
            <select name="inputCGender" id="inputCGender" style="width:225px;" required>
                <option>Select Your Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

    </div> 
</div>    

<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputBirthDate">Date Enrolled</label>
        <input class="form-control" name="inputCEdate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="inputEdate" placeholder="Date Enrolled" required>

    </div> 
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputBirthDate">School Year</label>
        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputCSY" name="inputCSY" style="width:200px; font-size: 15px;">
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
               <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
               <?php }?>
       </select>
    </div>
    <div class="form-group col-lg-3">
        <label>Semester</label><br />
        <div id="AddedSection">
          <select name="inputSemester" id="inputSemester" style="width:225px;" required>
                <?php
                    $sem = Modules::run('main/getSemester');
                    switch ($sem):
                        case 1:
                            $first = 'Selected';
                            $second='';
                            $third='';
                        break;
                        case 2:
                            $first = '';
                            $second='selected';
                            $third='';
                        break;
                        case 3:
                            $first = '';
                            $second='';
                            $third='Selected';
                        break;
                    endswitch;
                ?>
                <option <?php echo $first ?> value="1">First</option>
                <option <?php echo $second ?> value="2">Second</option>
                <option <?php echo $third ?> value="3">Summer</option>
            </select>
        </div>
    </div>

      <div class="form-group col-lg-3">
        <label class="control-label" >School Last Attended:</label>
          <input style="margin-bottom:0;" class="form-control"  name="inputCSLA" type="text" id="inputSLA" placeholder="School Last Attended">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" >Address of School Last Attended:</label>
          <input style="margin-bottom:0;" class="form-control"  name="inputCAddressSLA" type="text" id="inputAddressCSLA" placeholder="Address">
      </div>
</div>