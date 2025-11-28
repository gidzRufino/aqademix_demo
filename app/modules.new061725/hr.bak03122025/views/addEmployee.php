<?php
   $sy = $settings->school_year;
   $is_admin = $this->session->userdata('is_admin');
?>
<div class="row">
    <div class="col-lg-12">
        <h2 style="margin-top: 20px;" class="page-header">Add Employee <small id="schoolID">( <?php echo $sy ?> ) <a href="<?php echo base_url().'reports/importUser' ?>">[ import csv ]</a></small>
        <button id="saveAdmission" class="btn btn-sm btn-success pull-right "><i class="fa fa-save fa-fw fa-2x"></i></button>
        <button onclick="document.location='<?php echo base_url('main/dashboard') ?>'" style="margin-right:5px;" class="btn btn-sm btn-warning pull-right"><i class="fa fa-close fa-fw fa-2x"></i></button> 
        </h2>
    </div>
</div>
<div class="formHeader">
        <?php
            $attributes = array('class' => '', 'id'=>'addEmployeeForm');
            echo form_open(base_url().'hr/saveProfile', $attributes);
        ?>
        <div class="row">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Personal Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <input class="form-control" name="inputIdNum" style="width:230px;" value="" type="text" id="inputIdNum" placeholder="Enter Employee ID">
                    <div class="form-group col-lg-3">
                        <label  for="inputFirstName">First Name</label>
                          <?php
                             $inputFirstName = array(
                                            'name'        => 'inputFirstName',
                                            'id'          => 'inputFirstName',
                                            'placeholder'  => 'First Name',
                                            'style' => 'width:230px; margin-bottom:0;',
                                            'class' => 'form-control'

                                          );

                              echo form_input($inputFirstName);

                            ?>   
                  </div>
                    
                    <div class="form-group col-lg-3">
                     <label class="control-label" for="inputMiddleName">Middle Name</label>
                          <?php
                            $inputMiddleName = array(
                                           'name'        => 'inputMiddleName',
                                           'id'          => 'inputMiddleName',
                                           'placeholder'  => 'Middle Name',
                                           'style' => 'width:230px; margin-bottom:0;',
                                            'class' => 'form-control'
                                         );

                             echo form_input($inputMiddleName);

                           ?> 
                   </div>
                    
                    <div class="form-group col-lg-3">
                    <label class="control-label" for="inputLastName">Last Name</label>
                          <?php
                            $inputLastName = array(
                                           'name'        => 'inputLastName',
                                           'id'          => 'inputLastName',
                                           'placeholder'  => 'Last Name',
                                            'class' => 'form-control'
                                         );

                             echo form_input($inputLastName);

                           ?> 
                   </div>
                    
                    <div class="form-group col-lg-3">
                        <label class="control-label" for="inputBirthDate">Date of Birth</label>
                        <input class="form-control" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="inputBdate" placeholder="Date of Birth" required>
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label class="control-label" for="inputGender">Gender</label>
                            <select name="inputGender" style="width:230px;" id="inputGender" required>
                            <option>Select Your Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                    </div>   
                    
                    <div class="form-group col-lg-3">
                        <label class="control-label" for="inputStatus">Status</label>
                        <?php
                                $status = array(
                                                ''  => 'Select Status',
                                                'Single'    => 'Single',
                                                'Married'   => 'Married',
                                                'Widow'   => 'Widow',

                                              );
                                $statusOptions = 'id="inputStatus" class="controls-row" style="width:230px;" name="inputStatus"'; 

                              echo form_dropdown('inputStatus', $status,'', $statusOptions);
                        ?>
                    </div> 
                    
<!--                    <div class="form-group col-lg-3" style="">
                        <label class="control-label" for="inputNationaly">Married to <small>(if married)</small>:</label>
                        <input class="form-control"  name="inputMarried" type="text" id="inputMarried" placeholder="Married To">
                    </div>-->
                    
                    <div class="form-group col-lg-3">
                  <label class="control-label" for="inputNationaly">Nationality</label>
                     <?php
                       $inputNationality = array(
                                      'name'        => 'inputNationality',
                                      'id'          => 'inputNationality',
                                      'placeholder'  => 'Nationality',
                                      'style' => 'width:230px; margin-bottom:0;',
                                      'class' => 'form-control'
                                    );

                        echo form_input($inputNationality);

                      ?> 
                </div>
                    
                 <div class="form-group col-lg-3" style="margin-right:20px; width:230px;">
                    <label class="control-label" for="inputReligion">Religion</label>
                        <select name="inputReligion" id="inputReligion" style="width:230px;" required>
                        <option>Select Religion</option>
                        <?php 
                            foreach ($religion as $r)
                              {   
                            ?>                        
                          <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

                          <?php }?>
                        </select><a class="help-inline pull-left" 
                          rel="clickover" 
                          data-content=" 
                               <div style='width:100%;'>
                               <h6>Add Religion</h6>
                               <input class='form-control' type='text' id='addReligion' />
                                <div style='margin:5px 0;'>
                                     <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                     <button data-dismiss='clickover' onclick='saveReligion()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</button>
                                </div>
                               </div>
                                "   
                          class="btn" data-toggle="modal" href="#">add Religion</a>
                </div>
                    
                </div>
            </div>
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    Contact Information
                </div>
                <div class="panel-body ">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Street</label>
                              <input  class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street" required>
                        </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputAddress">Barangay:</label>
                                  <input style="margin-bottom:0;" class="form-control"  name="inputBarangay" type="text" id="inputBarangay" placeholder="Barangay" required>
                              </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputCity">City / Municipality:</label>
                                <select onclick="getProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="inputMunCity" name="inputMunCity">
                                    <?php foreach($cities as $city): ?>
                                        <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city.' [ '.$city->province.' ]' ?></option>
                                    <?php endforeach; ?>
                                </select>  
                                <!--<input style="margin-bottom:0;" class="form-control"  name="inputMunCity" class="select2-search" type="text" id="inputMunCity" placeholder="City / Municipality" required>-->
                              </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputState">Province:</label>
                                  <input style="margin-bottom:0;" class="form-control"  name="inputProvince" type="text" id="inputProvince" placeholder="State / Province" required>
                                  <input style="margin-bottom:0;" class="form-control"  name="inputPID" type="hidden" id="inputPID" placeholder="State / Province" required>
                              </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputPostal">Postal Code:</label>
                            <div class="controls">
                              <input   class="form-control"  name="inputPostal" type="text" id="inputPostal" placeholder="Postal Code" required>
                            </div>
                          </div>
                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputContact">Contact Number:</label>
                            <div class="controls">
                              <input  class="form-control"  name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                            </div>
                          </div>
                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputEmail">Email:</label>
                            <div class="controls">
                              <input  class="form-control"  name="inputEmail" type="text" id="inputEmail" placeholder="Email">
                            </div>
                          </div>
                    </div>    
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputEmail">(IN CASE OF EMERGENCY):</label>
                          <div class="controls">
                             <?php
                                   $inputInCaseName = array(
                                                  'name'        => 'inputInCaseName',
                                                  'id'          => 'inputInCaseName',
                                                  'placeholder'  => 'Contact Name',
                                                  'class'        => 'form-control',
                                                  'style'        => 'width:230px;'

                                                );

                                    echo form_input($inputInCaseName);

                                  ?> 

                          </div>
                        </div> 
                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputRelation">Relation:</label>
                          <div class="controls">
                              <?php
                                   $inputInCaseRelation = array(
                                                  'name'        => 'inputInCaseRelation',
                                                  'id'          => 'inputInCaseRelation',
                                                  'placeholder'  => 'Relation',
                                                  'class'        => 'form-control',
                                                  'style'        => 'width:230px; margin-right:10px',
                                                  'onkeypress' => "notEmpty(document.getElementById('inputInCaseName'), 'Please Enter Contacts Complete Name')"
                                                );

                                    echo form_input($inputInCaseRelation);

                                  ?>                 
                          </div>
                        </div>
                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputEmail">Contact Number:</label>
                          <div class="controls">
                            <?php
                                   $inputInCaseContact = array(
                                                  'name'        => 'inputInCaseContact',
                                                  'id'          => 'inputInCaseContact',
                                                  'placeholder'  => 'Contact Number',
                                                  'class'        => 'form-control',
                                                  'style'        => 'width:230px;',
                                                  'onkeypress' => "notEmpty(document.getElementById('inputInCaseRelation'), 'Please Enter Relation')"
                                                );

                                    echo form_input($inputInCaseContact);

                                  ?>    

                          </div>
                        </div>
                    </div>
                       
                </div>
            </div>
            
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    Academic Information
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputCourse">Course:</label>
                            <div class="controls">
                              <input autocomplete="off"  class="form-control" onkeydown="searchCourse(this.value)" style="width:230px; margin-right: 10px;" name="inputCourse" type="text" id="inputCourse" placeholder="" required>
                              <input type="hidden" id="courseId" name="courseId" value="0" />
                            </div>
                            <div style="min-height: 30px; background: #FFF; width:230px; display: none;" class="resultOverflow" id="courseSearch">

                            </div>
                          </div> 

                          <?php
                              $year = date('Y')-40;

                          ?>

                           <div class="form-group col-lg-3">
                              <label class="control-label" for="YearGraduated"/>Year Graduated:</label> 
                              <div class="controls" id="AddedSection">
                               <select name="inputYearGraduated" id="inputYearGraduated" style="width:230px; height:35px;"  required>
                                   <option>Select Year</option>
                                     <?php 

                                         for($x=$year;$x<=date('Y');$x++)
                                           {   
                                     ?>                        
                                   <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                   <?php }?>


                                 </select>
                             </div>   
                           </div>

                           <div class="form-group col-lg-3">
                              <label class="control-label" for="YearGraduated">Name of School</label>
                              <div class="controls">
                                  <input autocomplete="off" class="form-control" onkeydown="searchSchool(this.value)" style="width:220px; margin-right: 10px" name="inputNameOfSchool" type="text" id="inputNameOfSchool" placeholder="Name of School" required>
                                  <input type="hidden" id="collegeId" name="collegeId" value="0" />

                              </div>
                              <div style="min-height: 30px; background: #FFF; display: none;" class="resultOverflow" id="collegeSearch">

                              </div>
                            </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="YearGraduated">Address of School</label>
                            <div class="controls">
                               <?php
                                     $inputAddressOfSchool = array(
                                                    'name'        => 'inputAddressOfSchool',
                                                    'id'          => 'inputAddressOfSchool',
                                                    'placeholder'  => 'Address of School',
                                                    'class'        => 'form-control',

                                                  );

                                      echo form_input($inputAddressOfSchool);

                                ?> 

                            </div>
                          </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="panel panel-red">
                <div class="panel-heading">
                    HR Information:
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                        <label class="control-label" for="inputAdmissionDate">Date Hired</label>
                        <div class="controls">
                                <input onblur="generateID()" class="form-control" name="inputDateHired" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd" id="dp2" >
                        </div>
                      </div>
                    
                     <div class="form-group col-lg-3">
                        <label class="control-label" for="inputDepartment">Department</label>
                        <div class="controls">
                          <select style="width:230px;" name="inputDepartment"  onclick="getPosition(this.value)"  id="inputDepartment" required>
                                <option value="0">Select Department</option>
                             <?php 
                                    foreach ($position as $p)
                                      {   
                                ?>                        
                              <option value="<?php echo $p->dept_id; ?>"><?php echo $p->department; ?></option>

                              <?php }?>
                            </select>
                        </div>
                      </div>

                      <div class="form-group col-lg-3" id="Pos">
                            <label id="labelPosition" class="control-label" for="inputSection">Position</label>
                            <div class="controls" id="AddedPosition">
                              <select onclick="selectSection()" name="inputPosition" style="width:230px;" id="inputPosition" required>
                                <option value="0"></option>

                                </select>
                            </div>
                      </div>
                    
                    <div class="form-group col-lg-3">
                        <label id="labelPosition" class="control-label" for="inputEmploymentStatus">Employment Status</label>
                        <div class="controls" >
                          <select  name="inputEmploymentStatus" id="inputEmploymentStatus" class="controls-row span12" required>
                                <option value="0">Select Employment Status</option>
                              <option value="Regular">Regular</option>
                              <option value="Contractual">Contractual</option>

                            </select>
                        </div>
                  </div>
                    
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputSSS">PRC ID:</label>
                            <div class="controls">
                                <?php
                                      $inputPRC = array(
                                                     'name'        => 'inputPRC',
                                                     'id'          => 'inputPRC',
                                                     'placeholder'  => 'PRC ID',
                                                     'class'        => 'form-control',
                                                   );

                                       echo form_input($inputPRC);

                                 ?>
                            </div>
                       </div>
                    </div> 

                </div>
                
            </div>    
            
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Statutory Benefits
                </div>
                <div class="panel-body">
                    
                    <div class="form-group col-lg-3">
                        <label class="control-label" for="inputSSS">SSS #:</label>
                            <div class="controls">
                                <?php
                                     $inputSSS = array(
                                                    'name'        => 'inputSSS',
                                                    'id'          => 'inputSSS',
                                                    'placeholder'  => 'SSS',
                                                      'class'        => 'form-control',
                                                      'style'        => 'width:230px; margin-right:10px;',

                                                  );

                                      echo form_input($inputSSS);

                                ?> 

                            </div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputSSS">PhilHealth #:</label>
                            <div class="controls">
                               <?php
                                     $inputPH = array(
                                                    'name'        => 'inputPH',
                                                    'id'          => 'inputPH',
                                                    'placeholder'  => 'PhilHealth',
                                                      'class'        => 'form-control',
                                                      'style'        => 'width:230px; margin-right:10px;',
                                                  );

                                      echo form_input($inputPH);

                                ?>  

                            </div>
                          </div>
                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputSSS">Pag-Ibig #:</label>
                            <div class="controls">
                                <?php
                                     $inputPagIbig = array(
                                                    'name'        => 'inputPagIbig',
                                                    'id'          => 'inputPagIbig',
                                                    'placeholder'  => 'Pag - Ibig',
                                                      'class'        => 'form-control',
                                                      'style'        => 'width:230px; margin-right:10px;',
                                                  );

                                      echo form_input($inputPagIbig);

                                ?>

                            </div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputSSS">TIN:</label>
                            <div class="controls">
                              <?php
                                     $inputTin = array(
                                                    'name'        => 'inputTin',
                                                    'id'          => 'inputTin',
                                                    'placeholder'  => 'TIN',
                                                      'class'        => 'form-control',
                                                      'style'        => 'width:230px;',
                                                  );

                                      echo form_input($inputTin);

                                ?>

                            </div>
                          </div> 
                    
                </div>
                
            </div>
        <?php
            echo form_close();
        ?>
    </div>
</div>

<style type="text/css">
    .error {
        color: red;
        margin-left: 5px;
    }
</style>
<script type="text/javascript">
    
       function getProvince(value)
      {
          var url = "<?php echo base_url().'main/getProvince/'?>"+value;
          $.ajax({
                       type: "GET",
                       url: url,
                       dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {
                           $('#inputProvince').val(data.name)
                           $('#inputPID').val(data.id)
                       }
          })
      }
    
    
      function getPosition(){
          var department_id = document.getElementById("inputDepartment").value;
             var url = "<?php echo base_url().'hr/getPosition/'?>"+department_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "dept_id="+department_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#Pos').show();
                       $('#inputPosition').html(data);
                   }
                 });

            return false; 
      }
      
      function searchCourse(value)
      {
          var url = "<?php echo base_url().'hr/searchCourse/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#courseSearch').hide();
              $('#courseId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#courseSearch').show();
                       $('#courseSearch').html(data);
                   }
                 });

            return false;  
          }
            
      } 
      
      
      function generateID()
      {
          var url = "<?php echo base_url().'hr/generateId/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+$('#dp2').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                      // alert(data);
                       $('#inputIdNum').val(data);
                   }
                 });

            return false;  
          
      } 
      
      function searchSchool(value)
      {
          var url = "<?php echo base_url().'hr/searchCollege/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#collegeSearch').hide();
              $('#collegeId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#collegeSearch').show();
                       $('#collegeSearch').html(data);
                   }
                 });

            return false;  
          }
            
      } 
      
      function saveReligion()
      {
          var value = document.getElementById('addReligion').value;
          
          var url = "<?php echo base_url().'users/saveReligion/'?>"+value; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "religion="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#inputReligion').html(data);
                   }
                 });

            return false; 
      } 
       
      
      $(document).ready(function() {
          generateID();
          $("#inputGrade").select2(); 
          $("#inputGender").select2(); 
          $("#inputSection").select2(); 
          $("#inputEmploymentStatus").select2(); 
          $("#inputReligion").select2({
              allowClear: true
          }); 
          $("#inputMunCity").select2({maximumSelectionSize: 1 }); 
          $("#inputPosition").select2(); 
          $("#inputDepartment").select2(); 
          $("#inputStatus").select2(); 
          $('#inputBdate').datepicker();
          $('#dp2').datepicker();
          
          $("#iA").blur(function(){
            
            var url = "<?php echo base_url().'index.php/employee/validateUserID/' ?>"+$("#iA").val(); // the script where you handle the form input.

                $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#MessagingSystem").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                           if(data){
                            alert(data);
                            $("#inputIdNum").val("");
                             $("#iA").val("");
                           }
                       }
                     });

                return false; // avoid to execute the actual submit of the form.
                
          });
          
        $("#saveAdmission").click(function () {
            var id = $('#inputIdNum').val();
            var fname = $("#inputFirstName").val();
            var lname = $("#inputLastName").val();
            var dept = $('#inputDepartment').val();
            var position = $('#inputPosition').val();
            var eStat = $('#inputEmploymentStatus').val();
            if (id.length < 1 || fname.length < 1 || lname.length < 1 || dept == 0 || position == 0 || eStat == 0) {
                if (id.length < 1) {
                    $('#inputIdNum').after('<span class="error pull-left">ID number is required</span><br>');
                }
                if (fname.length < 1) {
                    $('#inputFirstName').after('<span class="error">First Name is required</span>');
                }
                if (lname.length < 1) {
                    $('#inputLastName').after('<span class="error">Last Name is required</span>');
                }
                if (dept == 0) {
                    $('#inputDepartment').after('<br><span class="error">Department is required</span>');
                }
                if (position == 0) {
                    $('#inputPosition').after('<br><span class="error">Position is required</span>');
                }
                if (eStat == 0) {
                    $('#inputEmploymentStatus').after('<br><span class="error">Employment Status is required</span>');
                }
            } else {
                var url = "<?php echo base_url() . 'hr/saveProfile' ?>"
                $.ajax({
                   type: "POST",
                   url: url,
                   data: $("#addEmployeeForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data);
                   }
                 });
            }
          });
      
        });
        
        $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })
        
$(function(){ // document ready
 
  if (!!$('.sticky').offset()) { // make sure ".sticky" element exists
 
    var stickyTop = $('.sticky').offset().top; // returns number
 
    $(window).scroll(function(){ // scroll event
 
      var windowTop = $(window).scrollTop(); // returns number
 
      if (stickyTop < windowTop){
        $('.sticky').css({ position: 'fixed', top: 0 });
      }
      else {
        $('.sticky').css('position','static');
      }
 
    });
 
  }
 
});
</script>
