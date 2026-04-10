<?php
   $sy = $settings->school_year;

   $is_admin = $this->session->userdata('is_admin');
?>
<div class="row">
    <div class="col-lg-12">
        <h2 style="margin-top: 20px;" class="page-header">College Admission <small id="schoolID">( <?php echo $sy ?> ) <span style="cursor: pointer;" onclick="$('#schoolID').fadeOut(500), $('#inputLRN').fadeIn(500),$('#inputLRN').focus(),$('#inputLRN').val('')" >[Set Student ID Manually]</span></small>
        <button id="saveAdmission" class="btn btn-sm btn-success pull-right "><i class="fa fa-save fa-fw fa-2x"></i></button>
        <button onclick="document.location='<?php echo base_url('college') ?>'" style="margin-right:5px;" class="btn btn-sm btn-warning pull-right"><i class="fa fa-close fa-fw fa-2x"></i></button>
        </h2>
    </div>
</div>

    <div class="formHeader row">
        <?php
            $attributes = array('class' => '','role'=>'form', 'id'=>'admissionForm');
            echo form_open(base_url().'college/saveAdmission', $attributes);
        ?>
        <div>
           <input class="form-control" style="display:none; margin-bottom: 10px;" onkeyup="checkID(this.value)" name="inputLRN" type="text" id="inputLRN" placeholder="Enter Student ID (LRN)">
            <small class="help-inline hide" style="color:red;" id="infoReply"></small>
            <input name="inputIdNum"  class="pull-left" style="width:200px;" value="" type="hidden" id="inputIdNum" placeholder="<?php echo $sy ?>">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Personal Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="collegeAd">
                        <?php $this->load->view('collegeAdmission'); ?>
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
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Street</label>
                              <input style="margin-bottom:0;" class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street" required>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Barangay:<span class="error">*</span></label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputBarangay" type="text" id="inputBarangay" placeholder="Barangay" required>
                              <div id="inputBarangayEmpty"></div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputCity">City / Municipality:<span class="error">*</span></label>
                            <select onclick="getProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="inputMunCity" name="inputMunCity">
                                <?php foreach($cities as $city): ?>
                                    <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city.' [ '.$city->province.' ]' ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!--<input style="margin-bottom:0;" class="form-control"  name="inputMunCity" class="select2-search" type="text" id="inputMunCity" placeholder="City / Municipality" required>-->
                              <div id="inputMunCityEmpty"></div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputState">Province:<span class="error">*</span></label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputProvince" type="text" id="inputProvince" placeholder="State / Province" required>
                              <input style="margin-bottom:0;" class="form-control"  name="inputPID" type="hidden" id="inputPID" placeholder="State / Province" required>
                              <div id="inputProvinceEmpty"></div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputPostal">Postal Code:<span class="error">*</span></label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputPostal" type="text" id="inputPostal" placeholder="Postal Code" required>
                              <div id="inputPostalEmpty"></div>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputContact">Contact Number:</label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputEmail">Email:</label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputEmail" type="text" id="inputEmail" placeholder="Email">
                          </div>
                    </div>
                </div>

            </div>
            <div class="panel panel-yellow ">
                <div class="panel-heading">
                    Parent / Guardian Information:
                    <div class="btn-group" style="margin-left:10px;" data-toggle="buttons-radio">
                        <button onclick="selectPG(0)" type="button" class="btn btn-sm btn-default active">Parent</button>
                        <button onclick="selectPG(1)"type="button" class="btn btn-sm btn-default">Guardian</button>
                        <input name="pgSelect" type="hidden" id="pgSelect" />
                    </div>
                </div>

                <div class="panel-body ">
                    <div id="Parents">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputFather">Father's First Name</label>
                                <input name="inputFExist" type="hidden" id="inputFExist" placeholder="Father's First and Middle Name" required>
                                <input style="margin-bottom:0;" class="form-control"   name="inputFName" type="text" id="inputFName" placeholder="Father's First Name" required>
                            </div>

                            <div class="form-group col-lg-3">
                              <label class="control-label" for="inputF_occ">Father's Middle Name:</label>
                                <input style="margin-bottom:0;" class="form-control"   name="inputFMName" type="text" id="inputFMName" placeholder="Father's Middle Name" required>
                            </div>

                            <div class="form-group col-lg-3">
                              <label class="control-label" for="inputF_occ">Father's Last Name:</label>
                                <input style="margin-bottom:0;" class="form-control"   name="inputFLName" type="text" id="inputFLName" placeholder="Father's Last Name" required>
                            </div>

                            <div class="form-group col-lg-3">
                              <label class="control-label" for="inputF_occ">Profession / Occupation:</label>
                                <input style="margin-bottom:0;" class="form-control"   name="inputF_occ" type="text" id="inputF_occ" placeholder="Father's Occupation" required>
                            </div>

                            <div class="form-group col-lg-3">
                              <label class="control-label" for="inputF_num">Contact Number:</label>
                                <input style="margin-bottom:0;" class="form-control"   name="inputF_num" type="text" id="inputF_num" placeholder="Father's Contact Number" required>
                            </div>

                            <div class="form-group col-lg-3">
                              <label class="control-label" for="inputPEmail">Email:</label>
                                <input style="margin-bottom:0;" class="form-control"   name="inputPEmail" type="text" id="inputPEmail" placeholder="Father's Email" required>
                            </div>

                             <div class="form-group  col-lg-3">
                              <label class="control-label" for="inputFather">Educational Attainment:</label>
                                  <select name="inputFeduc" id="inputFeduc" style="width:100%; height:50px;" required>
                                      <option>Select Educational Attainment</option>
                                      <?php foreach ($educ_attain as $EA) { ?>
                                         <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                      <?php }?>

                                   </select>
                            </div>
                            <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputAddress">Father's Office Name</label>
                                      <input style="margin-bottom:0;" class="form-control" name="f_officeName" type="text" id="f_officeName" placeholder="Office Name" required>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <h5 style="margin:0;">Father's Office Address:</h5>
                                <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputAddress">Street</label>
                                      <input style="margin-bottom:0;" class="form-control" name="f_officeStreet" type="text" id="f_officeStreet" placeholder="Street" required>
                                  </div>

                                  <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputAddress">Barangay:</label>
                                      <input style="margin-bottom:0;" class="form-control"  name="f_officeBarangay" type="text" id="f_officeBarangay" placeholder="Barangay" required>
                                  </div>

                                  <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputCity">City / Municipality:</label>
                                    <select onclick="getFofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="f_officeMunCity" name="f_officeMunCity">
                                        <?php foreach($cities as $city): ?>
                                            <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city.' [ '.$city->province.' ]' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                  </div>
                                    <div class="form-group col-lg-3">
                                      <label class="control-label" for="inputState">Province:</label>
                                        <input style="margin-bottom:0;" class="form-control"  name="f_officeProvince" type="text" id="f_officeProvince" placeholder="State / Province" required>
                                        <input style="margin-bottom:0;" class="form-control"  name="f_officePID" type="hidden" id="f_officePID" placeholder="State / Province" required>
                                    </div>
                            </div>
                        </div>

                        <div class="col-lg-12" style="border-top: 1px solid gray; padding-top:10px;">
                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputMother">Mother's First Name:</label>
                                  <input style="width:220px; margin-right:10px; margin-bottom:0;" class="form-control" name="inputMother" type="text" id="inputMother" placeholder="Mother's First Name" required>
                              </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputMother">Mother's Middle Name:</label>
                                  <input style="margin-bottom:0;" class="form-control" name="inputMMName" type="text" id="inputMMName" placeholder="Mother's Middle Name" required>
                              </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputMother">Mother's Last Name:</label>
                                  <input style="margin-bottom:0;" class="form-control" name="inputMLName" type="text" id="inputMLName" placeholder="Mother's Last Name" required>
                              </div>

                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputM_num">Profession / Occupation:</label>
                                  <input style="margin-bottom:0;" class="form-control" name="inputM_occ" type="text" id="inputM_occ" placeholder="Mother's Occupation" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label class="control-label" for="inputM_occ">Contact Number:</label>
                                  <input style="margin-bottom:0;" class="form-control" name="inputM_num" type="text" id="inputM_num" placeholder="Mother's Contact Number" required>
                              </div>

                               <div class="form-group col-lg-3">
                                <label class="control-label" for="inputFather">Educational Attainment:</label>
                                    <select name="inputMeduc" id="inputMeduc" style="width:100%;" required>
                                        <option>Select Educational Attainment</option>
                                        <?php foreach ($educ_attain as $EA) { ?>
                                        <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                        <?php }?>

                                      </select>
                               </div>
                                 <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputAddress">Mother's Office Name</label>
                                      <input style="margin-bottom:0;" class="form-control" name="m_officeName" type="text" id="m_officeName" placeholder="Office Name" required>
                                </div>
                                <div class="col-lg-12 no-padding">
                                    <h5 style="margin:0;">Mother's Office Address:</h5>
                                    <div class="form-group col-lg-3">
                                        <label class="control-label" for="inputAddress">Street</label>
                                          <input style="margin-bottom:0;" class="form-control" name="m_officeStreet" type="text" id="m_officeStreet" placeholder="Street" required>
                                      </div>

                                      <div class="form-group col-lg-3">
                                        <label class="control-label" for="inputAddress">Barangay:</label>
                                          <input style="margin-bottom:0;" class="form-control"  name=" " type="text" id="m_officeBarangay" placeholder="Barangay" required>
                                      </div>

                                      <div class="form-group col-lg-3">
                                        <label class="control-label" for="inputCity">City / Municipality:</label>
                                        <select onclick="getMofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="m_officeMunCity" name="m_officeMunCity">
                                            <?php foreach($cities as $city): ?>
                                                <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city.' [ '.$city->province.' ]' ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                      </div>
                                        <div class="form-group col-lg-3">
                                          <label class="control-label" for="inputState">Province:</label>
                                            <input style="margin-bottom:0;" class="form-control"  name="m_officeProvince" type="text" id="m_officeProvince" placeholder="State / Province" required>
                                            <input style="margin-bottom:0;" class="form-control"  name="m_officePID" type="hidden" id="m_officeProvince" placeholder="State / Province" required>
                                        </div>
                                </div>
                            </div>
                        
                            <div class="col-lg-12" style="border-top: 1px solid gray; padding-top:10px;">
                                <h5>(IN CASE OF EMERGENCY):</h5>
                                <div class="form-group col-lg-3">
                                    
                                    <label class="control-label" for="inputEmail">Contact Name:</label>
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
                                  <label class="control-label" for="inputEmail">Contact Number:</label>
                                  <div class="controls">
                                    <?php
                                           $inputInCaseContact = array(
                                                          'name'        => 'inputInCaseContact',
                                                          'id'          => 'inputInCaseContact',
                                                          'placeholder'  => 'Contact Number',
                                                          'class'        => 'form-control',
                                                          'style'        => 'width:230px;'
                                                        );

                                            echo form_input($inputInCaseContact);

                                          ?>    

                                  </div>
                                </div>
                            </div>

                        </div>
                        <div style="display: none;" id="Guardian">
                            <div class="col-lg-12">
                                <div class="form-group col-lg-3">
                                 <label class="control-label" for="inputFather">Guardian's First Name:</label>
                                   <input name="inputGExist" type="hidden" id="inputGExist" placeholder="Father's Name" required>
                                   <input style="margin-bottom:0;" class="form-control"   name="inputGFName" type="text" id="inputGFName" placeholder="Guardian's Full Name" required>
                               </div>

                               <div class="form-group col-lg-3" >
                                 <label class="control-label" for="inputG_occ">Guardian's Middle Name:</label>
                                   <input style="margin-bottom:0;" class="form-control" name="inputGMName" type="text" id="inputGMName" placeholder="Guardian's Middle Name" required>
                               </div>

                               <div class="form-group col-lg-3" >
                                 <label class="control-label" for="inputG_occ">Guardian's Last Name:</label>
                                   <input style="margin-bottom:0;" class="form-control" name="inputGLName" type="text" id="inputGLName" placeholder="Guardian's Last Name" required>
                               </div>

                               <div class="form-group col-lg-3" >
                                 <label class="control-label" for="inputG_occ">Relationship:</label>
                                   <input style="margin-bottom:0;" class="form-control" name="inputRelationship" type="text" id="inputRelationship" placeholder="Relation to Student" required>
                               </div>
                                <div class="form-group col-lg-3">
                                    <label class="control-label" for="inputGuardGender">Gender</label>
                                    <div class="controls">
                                        <select name="inputGuardGender" id="inputGuardGender" style="width:225px;" required>
                                            <option>Select Your Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>

                                </div>
                               <div class="form-group col-lg-3">
                                 <label class="control-label" for="inputF_num">Contact Number:</label>
                                   <input style="margin-bottom:0;" class="form-control"  name="inputG_num" type="text" id="inputG_num" placeholder="Contact Number" required>
                               </div>
                               <div class="form-group col-lg-3">
                                 <label class="control-label" for="inputPEmail">Email:</label>
                                   <input style="margin-bottom:0;" class="form-control"  name="inputGEmail" type="text" id="inputGEmail" placeholder="Email" required>
                               </div>
                                <div class="form-group col-lg-3">
                                     <label class="control-label" for="inputFather">Educational Attainment:</label>
                                         <select name="inputGeduc" id="inputGeduc" style="width:100%;" required>
                                             <option>Select Educational Attainment</option>
                                             <?php foreach ($educ_attain as $EA) { ?>
                                             <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                             <?php }?>

                                           </select>
                                   </div>
                            </div>
                        </div>

                   </div>
            </div>
            <div class="panel panel-red ">
                <div class="panel-heading">
                    Medical Information:
                </div>
                <div class="panel-body ">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputSSS">Blood Type:</label>
                            <input  style="margin-bottom:0;" class="form-control"  name="inputBType" type="text" id="inputBType" placeholder="Blood Type" required>
                        </div>

                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputSSS">Height(in meters):</label>
                            <input  style="margin-bottom:0;" class="form-control"  name="height" type="text" id="height" placeholder="height" required>
                        </div>

                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputSSS">Weight(in Kilograms):</label>
                            <input  style="margin-bottom:0;" class="form-control"  name="weight" type="text" id="weight" placeholder="weight" required>
                        </div>

                        <div class="form-group col-lg-3" style="margin-right:25px; width:200px;">
                           <label class="control-label" for="Family Physician"/>Family Physician:</label>
                           <div class="controls" id="AddedSection">
                            <select name="inputFPhy" id="inputFPhy" class=""  required>
                                <option>Search for existing Physician</option>
                                  <?php
                                      foreach ($physician as $p)
                                        {
                                  ?>
                                <option value="<?php echo $p->physician_id; ?>"><?php echo $p->physician; ?></option>
                                <?php }?>


                              </select><a class="help-inline" role="button" class="btn" data-toggle="modal" href="#addPhysician">add physician</a>
                          </div>
                        </div>
                        <div class="form-group  col-lg-3">
                          <label class="control-label" for="inputSSS">Allergies(food, medicine, insects, plants):</label>
                            <input style="margin-bottom:0;" class="form-control"  name="inputAllergies" type="text" id="inputAllergies" placeholder="" required>
                        </div>
                        <div class="form-group col-lg-3">
                          <label class="control-label" for="inputSSS">Other Important Medical Information:</label>
                            <input style="margin-bottom:0;" class="form-control"  name="inputOtherMedInfo" type="text" id="inputOtherInfo" placeholder="" required>
                        </div>

                    </div>
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

       function refreshIdGeneration()
      {
          var url = "<?php echo base_url().'main/refreshIdGeneration/'?>";
          $.ajax({
                       type: "GET",
                       url: url,
                       dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {

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

          var url = "<?php echo base_url().'college/getLatestCollegeNum/'?>"+levelCode;


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
                       $('#schoolID').html('( '+<?php echo $sy.'15' ?>+prefix+id+' )');
                       $('#inputIdNum').val(<?php echo $sy.'15' ?>+prefix+id);


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
          $("#getCourse").select2();
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

          $("#saveAdmission").click(function() {
             var url = "<?php echo base_url().'college/saveAdmission/'?>"; // the script where you handle the form input.
             var proceed = 1;
             var warning = " is required";
             if($("#inputCFirstName").val() === ''){
                proceed = 0;
                $("#inputCFirstNameEmpty").html("<small class='error'>Firstname"+warning+"</small>");
             }
             if($("#inputCLastName").val() === ''){
                proceed = 0;
                $("#inputCLastNameEmpty").html("<small class='error'>Lastname"+warning+"</small>");

             }
             if($("#getCourse").val() == "none"){
                proceed = 0;
                $("#inputCourseEmpty").html("<small class='error'>Course"+warning+"</small>");
             }
             if($("#inputYear").val() == "none"){
                proceed = 0;
                $("#inputYearEmpty").html("<small class='error'>School year"+warning+"</small>");
             }
             if($("#inputBdate").val() == ""){
                proceed = 0;
                $("#inputBdateEmpty").html("<small class='error'>Birthdate"+warning+"</small>");
             }
             if($("#inputCGender").val() == 'none'){
                proceed = 0;
                $("#inputCGenderEmpty").html("<small class='error'>Gender"+warning+"</small>");
             }
             if($("#inputCSY").val() == 'none'){
                proceed = 0;
                $("#inputCSYEmpty").html("<small class='error'>School Year"+warning+"</small>");
             }

             if($("#inputBarangay").val() == ''){
                proceed = 0;
                $("#inputBarangayEmpty").html("<small class='error'>Barangay"+warning+"</small>");
             }
             if($("#inputMunCity").val() == null){
                proceed = 0;
                $("#inputMunCityEmpty").html("<small class='error'>Municipality"+warning+"</small>");
             }
             if($("#inputProvince").val() == ''){
                proceed = 0;
                $("#inputProvinceEmpty").html("<small class='error'>Province"+warning+"</small>");
             }
             if($("#inputPostal").val() == ''){
                proceed = 0;
                $("#inputPostalEmpty").html("<small class='error'>Postal"+warning+"</small>");
             }
            if(proceed == 1){
                $.ajax({
                   type: "POST",
                   url: url,
                   data: $('#admissionForm').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                        alert("Student Information Saved")
                        var answer = confirm("do you want to admit more students?")

                        if(answer==true){

                            document.location="<?php echo base_url();?>college/admission"
                        }else{

                            document.location="<?php echo base_url();?>main/dashboard"
                        }
                   }
                 });
            }else{
                setTimeout(clearEmptyMessage, 3000);
            }

          });

        });

        $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })

        function clearEmptyMessage(){
            $("#inputCFirstNameEmpty").html('')
            $("#inputCLastNameEmpty").html('')
            $("#inputCourseEmpty").html("");
            $("#inputYearEmpty").html("");
            $("#inputBdateEmpty").html("");
            $("#inputCGenderEmpty").html("");
            $("#inputCSYEmpty").html("");
            $("#inputBarangayEmpty").html("");
            $("#inputMunCityEmpty").html("");
            $("#inputProvinceEmpty").html("");
            $("#inputPostalEmpty").html("");
        }


</script>
