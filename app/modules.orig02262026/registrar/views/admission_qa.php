<?php
   $sy = $settings->school_year;
   $is_admin = $this->session->userdata('is_admin');
?>
<div class="row">
    <div class="col-lg-12">
        <h2 style="margin-top: 20px;" class="page-header"> Admission Form / شكل القبول
        <button id="saveAdmission" class="btn btn-sm btn-success pull-right "><i class="fa fa-save fa-fw fa-2x"></i></button>
        <button onclick="document.location='<?php echo base_url('main/dashboard') ?>'" style="margin-right:5px;" class="btn btn-sm btn-warning pull-right"><i class="fa fa-close fa-fw fa-2x"></i></button> 
        </h2>
    </div>
</div>

    <div class="formHeader row">
        <?php
            $attributes = array('class' => '','role'=>'form', 'id'=>'admissionForm');
            echo form_open(base_url().'registrar/saveAdmission', $attributes);
        ?>
        <div>
           <input class="form-control" style="display:none; margin-bottom: 10px;" onkeyup="checkID(this.value)" name="inputLRN" type="text" id="inputLRN" placeholder="Enter Student ID">
            <small class="help-inline hide" style="color:red;" id="infoReply"></small>
            <input name="inputIdNum"  class="pull-left" style="width:200px;" value="" type="hidden" id="inputIdNum" placeholder="<?php echo $sy ?>"> 
            
            <div class="panel panel-green">
                <div class="panel-heading">
                    Student Personal Data / البيانات الشخصية للطالب
                    <small class="pull-right" id="schoolID">( <?php echo $sy ?> ) <span style="cursor: pointer;" onclick="$('#schoolID').fadeOut(500), $('#inputLRN').fadeIn(500),$('#inputLRN').focus(),$('#inputLRN').val('')" >[Set Student ID Manually]</span></small>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    
                    <div class="pull-left">
                        <div style="border-bottom: 1px solid #ccc; margin-bottom: 10px;" class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>First Name <br /> إسم الطالب</label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputFirstName" type="text" id="inputFirstName" placeholder="First Name" required />
                                   
                            </div>
                          <div class="form-group col-lg-4">
                            <label>Middle Name <br /> إسم الوالد</label>

                              <?php
                                 $inputMiddleName = array(
                                                'name'        => 'inputMiddleName',
                                                'id'          => 'inputMiddleName',
                                                'class'       => 'form-control',
                                                'placeholder' => 'Middle Name',
                                                'onkeypress' => "notEmpty(document.getElementById('inputFirstName'), 'Please input First Name')",
                                                'style' => 'margin-bottom:0;'
                                              );

                                  echo form_input($inputMiddleName);

                                ?> 
                          </div>

                          <div class="form-group  col-lg-4">
                            <label>Family Name <br /> إسم العائلة</label>
                              <?php
                                 $inputLastName = array(
                                                'name'        => 'inputLastName',
                                                'id'          => 'inputLastName',
                                                'class'          => 'form-control',
                                                'placeholder'  => 'Last Name',
                                                'onkeypress' => "notEmpty(document.getElementById('inputMiddleName'), 'Please input Middle Name')",
                                                'style' => ' margin-right:10px; margin-bottom:0;'
                                              );

                                  echo form_input($inputLastName);

                                ?> 
                          </div>
                            <div class="form-group col-lg-4">
                                <label>First Name (in Arabic) </label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputFirstName" type="text" id="inputFirstName" placeholder="First Name  (in Arabic)" required />
                                   
                            </div>
                            <div class="form-group col-lg-4">
                              <label>Middle Name (in Arabic)</label>

                                <?php
                                   $inputMiddleName = array(
                                                  'name'        => 'inputMiddleName',
                                                  'id'          => 'inputMiddleName',
                                                  'class'       => 'form-control',
                                                  'placeholder' => 'Middle Name (in Arabic)',
                                                  'onkeypress' => "notEmpty(document.getElementById('inputFirstName'), 'Please input First Name')",
                                                  'style' => 'margin-bottom:0;'
                                                );

                                    echo form_input($inputMiddleName);

                                  ?> 
                            </div>

                            <div class="form-group  col-lg-4">
                              <label>Family Name (in Arabic)</label>
                                <?php
                                   $inputLastName = array(
                                                  'name'        => 'inputLastName',
                                                  'id'          => 'inputLastName',
                                                  'class'          => 'form-control',
                                                  'placeholder'  => 'Last Name (in Arabic)',
                                                  'onkeypress' => "notEmpty(document.getElementById('inputMiddleName'), 'Please input Middle Name')",
                                                  'style' => ' margin-right:10px; margin-bottom:0;'
                                                );

                                    echo form_input($inputLastName);

                                  ?> 
                            </div>
                        </div>
                        <div style="border-bottom: 1px solid #ccc; margin-bottom: 10px;" class="col-lg-12">
                          <div class="form-group col-lg-4">
                              <label>Anticipated Grade of Entry <br /> المرحلة المراد الالتحاق بها</label><br />
                                 <select class="form-control" style="width: 280px;" name="inputGrade" onclick="selectSection(this.value), setId(this.value)" id="inputGrade" required>
                                      <option>Select an Option</option> 
                                        <?php 
                                               foreach ($grade as $level)
                                                 {   
                                           ?>                        
                                                <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                        <?php }?>
                                    </select>
                          </div> 
                           <div class="form-group col-lg-4">
                               <label>Section <br />قسم</label><br />
                                <div id="AddedSection">
                                  <select class="form-control" style="width: 280px;"  name="inputSection" id="inputSection" required>
                                      <option>Select Section</option>  
                                  </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputBirthDate">Enrollment Year <br /> سنة التسجيل</label>
                                <select class="form-control " onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" name="inputSY" style="width:280px; font-size: 15px;">
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
                            
                        </div>
                        

                        <div class="col-lg-12">
                            <div class="form-group col-lg-4 ">
                                <label>Qatar ID <br /> رقم البطاقة الشخصية</label></label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputQatarId" type="text" id="inputQatarId" placeholder="Qatar ID" required>
                            </div>
                            <div class="form-group col-lg-4">
                              <label> Nationality <br /> الجنسية</label><br />
                                 <select  style="width: 280px;" name="inputNationality" id="inputNationality" required>
                                      <option>Select an Option</option> 
                                        <?php 
                                               foreach ($nationality as $nat)
                                                 {   
                                           ?>                        
                                                <option value="<?php echo $nat->nat_id; ?>"><?php echo $nat->nationality; ?></option>
                                        <?php }?>
                                    </select>
                            </div>
                            <div class="form-group col-lg-4 ">
                                <label>Passport No. <br /> رﻗﻢ ﺟﻮاز السفر</label></label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputPassNo" type="text" id="inputPassNo" placeholder="Passport No." required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Date of Birth <br /> تاريخ الميلاد</label>
                                <input style="margin-right: 10px;" class="form-control" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="inputBdate" placeholder="Date of Birth" required>

                            </div>

                            <div class="form-group col-lg-4 ">
                                <label>City of Birth <br /> (المدينة) مكان الولادة </label></label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputPlaceOfBirth" type="text" id="inputPlaceOfBirth" placeholder="City of Birth" required>
                            </div>
                            <div class="form-group col-lg-4">
                              <label> Country of Birth <br /> (الدولة) مكان الولادة</label><br />
                                 <select  style="width: 280px;" name="inputCountryOfBirth" id="inputCountryOfBirth" required>
                                      <option>Select an Option</option> 
                                        <?php 
                                               foreach ($countries as $country)
                                                 {   
                                           ?>                        
                                                <option value="<?php echo $country->id; ?>"><?php echo $country->countries; ?></option>
                                        <?php }?>
                                    </select>
                            </div>

                        </div>    

                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="inputGender">Gender <br />الجنس</label>
                                <div class="controls">
                                    <select name="inputGender" id="inputGender" style="width: 280px;" required>
                                        <option>Select Your Gender</option>
                                        <option value="Male">Male </option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="inputReligion">Religion <br />الديانة </label>
                                <div class="controls">
                                    <select name="inputReligion" id="inputreligion" style="width:280px;" required>
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
                        </div>
                    </div>
                    
                  
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    Contact Information
                </div>
                <div class="panel-body ">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-4">
                            <label class="control-label" for="inputAddress">Street / P.O. Box No.</label>
                              <input style="margin-bottom:0;" class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street" required>
                          </div>
                          <div class="form-group col-lg-8">
                            <label class="control-label" for="inputCity">City of Residence / منطقة السكن</label>
                            <select placeholder="City of Residence" class="populate select2-offscreen " style="width:100%;" multiple="" id="inputMunCity" name="inputMunCity">
                                <?php foreach($cities as $city): ?>
                                    <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city.' [ '.$city->province.' ]' ?></option>
                                <?php endforeach; ?>
                            </select>  
                            <!--<input style="margin-bottom:0;" class="form-control"  name="inputMunCity" class="select2-search" type="text" id="inputMunCity" placeholder="City / Municipality" required>-->
                          </div>

                          <div class="form-group col-lg-4">
                            <label class="control-label" for="inputContact">Contact Number:</label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                          </div>

                          <div class="form-group col-lg-4">
                            <label class="control-label" for="inputEmail">Email:</label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputEmail" type="text" id="inputEmail" placeholder="Email">
                          </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-yellow ">
                <div class="panel-heading">
                   Schools Previously Attended by the Applicant / ً المدارس التي ارتادها الطالب سابقا
                   <button class="btn btn-danger pull-right btn-xs" id="addSchoolBtn">Add School</button>
                <input type="hidden" id="schoolFormCounter" value="0" />
                </div>
                <div id="addSchoolWrapper" class="panel-body ">
                
                </div>
            </div>  
            
            
        </div>
        
        <?php
            echo form_close();
        ?>
    </div>
</div>

<script type="text/javascript">
    

    function selectDepartment(value)
    {
        if(value=='1')
            {
                $('#k-12').show();
                $('#collegeAd').hide();
            }else{
                $('#collegeAd').show();
                $('#k-12').hide();
            }
    }
    
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
    
       function getFofficeProvince(value)
      {
          var url = "<?php echo base_url().'main/getProvince/'?>"+value;
          $.ajax({
                       type: "GET",
                       url: url,
                       dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {
                           $('#f_officeProvince').val(data.name)
                           $('#f_officePID').val(data.id)
                       }
          })
      }
    
       function getMofficeProvince(value)
      {
          var url = "<?php echo base_url().'main/getProvince/'?>"+value;
          $.ajax({
                       type: "GET",
                       url: url,
                       dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {
                           $('#m_officeProvince').val(data.name)
                           $('#m_officePID').val(data.id)
                       }
          })
      }
    
      function checkID(value)
      {
          var url = "<?php echo base_url().'registrar/checkID' ?>"; // the script where you handle the form input.

                $.ajax({
                       type: "POST",
                       url: url,
                       data: 'id='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       dataType:'json',
                       success: function(data)
                       {
                          if(data.status)
                              {
                                  $('#infoReply').html(data.msg)
                                  $('#infoReply').fadeIn()
                                  $('#inputFirstName').attr('disabled','disabled');
                                  $('#inputMiddleName').attr('disabled','disabled');
                                  $('#inputLastName').attr('disabled','disabled');
                                 // $('#inputLRN').val('');
                              }else{
                                  $('#infoReply').html(data.msg)
                                  $('#infoReply').fadeOut(5000)
                                  $('#inputFirstName').removeAttr('disabled');
                                  $('#inputMiddleName').removeAttr('disabled');
                                  $('#inputLastName').removeAttr('disabled');
                              }
                       }
                     });

                return false; // avoid to execute the actual submit of the form.
                
      }
      function selectPG(pgSelect)
      {
          if(pgSelect==0){
              document.getElementById('pgSelect').value='0'
              document.getElementById('Guardian').style.display='none'
              document.getElementById("Parents").style.display=""
          }else if(pgSelect==1){
              document.getElementById('pgSelect').value='1'
              document.getElementById("Guardian").style.display=""
              document.getElementById("Parents").style.display="none"
          }
      }
    
      function selectSection(level_id){
          var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#inputSection').html(data);
                   }
                 });

            return false;
            
      }
      
      function saveNewValue(table){
         var db_table = $('#'+table).attr('table')
         var db_column = $('#'+table).attr('column')
         var pk = $('#'+table).attr('pk')
         var retrieve = $('#'+table).attr('retrieve')
         var db_value = $('#add'+db_column).val()
         var url = "<?php echo base_url().'registrar/saveNewValue/'?>"// the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "table="+db_table+"&column="+db_column+"&value="+db_value+"&pk="+pk+"&retrieve="+retrieve+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#input'+db_column).html(data)
                   }
                 });

            return false;
   
      }
      
      function setId(levelCode){
          
          var option = $('#inputOption').val(); 
          if(option==2){
             var url = "<?php echo base_url().'registrar/getLatestCollegeNum/'?>"+levelCode; // the script where you handle the form input.   
          }else{
              url = "<?php echo base_url().'registrar/getLatestIdNums/'?>"+levelCode; // the script where you handle the form input. 
          }
         

            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: "level_id="+levelCode+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       var id = parseInt(data.id) + parseInt(1)
                       var prefix = '000';
                       if(id<10)
                           {
                               prefix='000';
                           }else
                           {
                               if(id<100){
                                  prefix='00'; 
                               }else{
                                  prefix='0'; 
                               }
                               
                           }
                       var option = $('#inputOption').val(); 
                        if(option==2){
                            $('#schoolID').html('( '+<?php echo $sy.'15' ?>+prefix+id+' )');
                            $('#inputIdNum').val(<?php echo $sy.'15' ?>+prefix+id); 
                        }else{
                            $('#schoolID').html('( '+<?php echo $sy ?>+data.deptCode+levelCode+prefix+id+' )');
                            $('#inputIdNum').val(<?php echo $sy ?>+data.deptCode+levelCode+prefix+id); 
                        }
                       //console.log(data.deptCode)
                       
                   }
                 });

            return false;
   
      }

      function searchGrade(){
          var value = document.getElementById("inputCourse").value;
          
            getInfo(value)
      }
      
      function setSection(){
          
            
            var data = new Array();
            
            data[0] = document.getElementById('inputNewSection').value;
            data[1] = document.getElementById('inputGrade').value;
            
            
            saveAdmission(data);
      }
      
      $(document).ready(function() {
          $("#inputreligion").select2(); 
          $("#inputNationality").select2();  
          $("#inputCountryOfBirth").select2();  
          //$("#inputSection").select2(); 
          $("#inputMunCity").select2({maximumSelectionSize: 1 }); 
          $("#m_officeMunCity").select2({maximumSelectionSize: 1 }); 
          $("#f_officeMunCity").select2({maximumSelectionSize: 1 }); 
          $("#inputFPhy").select2(); 
          $("#inputFeduc").select2(); 
          $("#inputGeduc").select2(); 
          $("#inputMeduc").select2(); 
          $("#inputmother_tongue").select2(); 
          $("#inputethnic_group").select2();  
          $('#inputBdate').datepicker({orientation: 'auto'});
          $('#inputEdate').datepicker({orientation: 'auto'});
          
          $("#addSchoolBtn").click(function(e) {
                e.preventDefault();
                var value = parseInt($('#schoolFormCounter').val())+1;
                var url = "<?php echo base_url().'registrar/registrar_forms/addSchoolForm/'?>"+value;
                $.ajax({
                       type: "GET",
                       url: url,
                       //dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {
                           $('#addSchoolWrapper').append(data)
                           $('#schoolFormCounter').val(value)
                       }
                  });
            });
          
          $("#saveAdmission").click(function() {
             var url = "<?php echo base_url().'registrar/saveAdmission/'?>"; // the script where you handle the form input.
             alert('Demo Purposes Only!')
//            $.ajax({
//                   type: "POST",
//                   url: url,
//                   data: $('#admissionForm').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
//                   success: function(data)
//                   {
//                        alert("Student Information Saved")
//                        var answer = confirm("do you want to admit more students?")
//
//                        if(answer==true){
//
//                            //document.location="<?php echo base_url();?>registrar/admission"
//                        }else{
//
//                            //document.location="<?php echo base_url();?>main/dashboard"
//                        }
//                   }
//                 });

          });
      
        });
        
        $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })
        

</script>
