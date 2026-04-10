<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top:5px; margin-bottom: 5px;">Form 137 - A [ New Info ]
            <div class="form-group pull-right" style="margin-right:20px;font-size: 15px;">
                    <div class="controls" id="AddedSection">
                        <a href="#form137Settings" data-toggle="modal">
                            <i title="settings" data-toggle="tooltip" data-placement="top"  class="fa fa-cog fa-2x pull-right pointer tip-top"></i>
                        </a>
                        <a href="<?php echo base_url('reports/generateForm137') ?>" class="pull-right "><i class="fa fa-search fa-2x pointer"></i></a>
                    </div>
                
            </div>
        </h3>
	
    </div>
</div>
<div class="col-lg-12">
    <div class="formHeader row">
        
        <?php
            $attributes = array('class' => '','role'=>'form', 'id'=>'sprSubmitForm');
            echo form_open(base_url().'reports/reports_f137/saveNewInfo', $attributes);
        ?>
            <input name="inputIdNum"  class="pull-left" style="width:200px;" value="" type="hidden" id="inputIdNum" placeholder="<?php echo $this->session->school_year ?>"> 
            
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Student's Information
                    <button id="saveNewInfo" class="btn btn-sm btn-success pull-right "><i class="fa fa-save fa-fw fa-2x"></i></button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                    <label>LRN</label>
                                    <input class="form-control" style="margin-bottom: 10px;" onkeyup="checkID(this.value)" name="inputLRN" type="text" id="inputLRN" placeholder="Enter Student's LRN" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-3">
                                <label>First Name</label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputFirstName" type="text" id="inputFirstName" placeholder="First Name" required />
                                   
                            </div>
                          <div class="form-group col-lg-3">
                            <label>Middle Name</label>

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

                          <div class="form-group  col-lg-3">
                            <label>Last Name</label>
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

                          <div class="form-group col-lg-3">
                              <label>Grade  Level</label><br />
                                 <select style="height:35px; width: 200px;" name="inputGrade" onclick="selectSection(this.value), setId(this.value)" id="inputGrade" required>
                                      <option>Select Grade Level</option> 
                                        <?php 
                                               foreach ($grade as $level)
                                                 {   
                                                   if($level->grade_id<14):
                                           ?>                        
                                                <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                            <?php 
                                                    endif;
                                                 }?>
                                    </select>
                          </div> 
                        </div>

                        <div class="col-lg-12">

                            <div class="form-group col-lg-3">
                                <label>Date of Birth</label>
                                <input style="margin-right: 10px;" class="form-control" name="sprBdate" type="text" data-date-format="yyyy-mm-dd" id="sprBdate" placeholder="Date of Birth" required>

                            </div>

                            <div class="form-group col-lg-3">
                                <label>Place of Birth</label>
                                <input  style="margin-right: 10px;" class="form-control"  name="inputPlaceOfBirth" type="text" id="inputPlaceOfBirth" placeholder="Place of Birth" required>
                            </div>


                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputNationaly">Nationality</label>
                                <input class="form-control"  name="inputNationality" value="Filipino" type="text" id="inputNationality" placeholder="Nationality">

                            </div> 
                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputReligion">Religion</label>
                                <div class="controls">
                                    <select name="inputReligion" id="inputreligion" style="width:225px;" required>
                                    <option>Select Religion</option>
                                    <?php 
                                        foreach ($religion as $r)
                                          {   
                                        ?>                        
                                      <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

                                      <?php } 

                                      ?>
                                    </select><br />
                                    <a class="help-inline" 
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
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Father's Complete Name</label>
                              <input style="margin-bottom:0;" class="form-control" name="nameOfFather" type="text" id="nameOfFather" placeholder="Father's Complete Name" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Father's Occupation</label>
                              <input style="margin-bottom:0;" class="form-control" name="fatherOcc" type="text" id="fatherOcc" placeholder="Father's Occupation" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Mother's Complete Name</label>
                              <input style="margin-bottom:0;" class="form-control" name="nameOfMother" type="text" id="nameOfMother" placeholder="Mother's Complete Name" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Mother's Occupation</label>
                              <input style="margin-bottom:0;" class="form-control" name="motherOcc" type="text" id="motherOcc" placeholder="Mother's Occupation" required>
                        </div>
                    </div>
                    <div class="col-lg-12" style="border-top:1px solid #ccc;margin-bottom: 20px;"></div>
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="inputAddress">Street</label>
                              <input style="margin-bottom:0;" class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street" required>
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
                              <input style="margin-bottom:0;" class="form-control"  name="inputPostal" type="text" id="inputPostal" placeholder="Postal Code" required>
                          </div>

                          <div class="form-group col-lg-3">
                            <label class="control-label" for="inputContact">Contact Number:</label>
                              <input style="margin-bottom:0;" class="form-control"  name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                          </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label" for="inputContact">Country:</label>
                                <input style="margin-bottom:0;" class="form-control"  name="country" type="text" value="Philippines" id="country" placeholder="Country">
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
      
        
    function search(value)
    {
      var url = '<?php echo base_url().'search/searchStudentAccountsK12/' ?>'+value;
        $.ajax({
           type: "GET",
           url: url,
           data: "id="+value, // serializes the form's elements.
           success: function(data)
           {
                 $('#searchName').show();
                 $('#searchName').html(data);
           }
         });

    return false;
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
          
           url = "<?php echo base_url().'registrar/getLatestIdNum/'?>"+levelCode; // the script where you handle the form input. 
         

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
                            $('#schoolID').html('( '+<?php echo $this->session->school_year.'15' ?>+prefix+id+' )');
                            $('#inputIdNum').val(<?php echo $this->session->school_year.'15' ?>+prefix+id); 
                        }else{
                            $('#schoolID').html('( '+<?php echo $this->session->school_year ?>+data.deptCode+levelCode+prefix+id+' )');
                            $('#inputIdNum').val(<?php echo $this->session->school_year ?>+data.deptCode+levelCode+prefix+id); 
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
      
      
      $(document).ready(function() {
          $('#sprBdate').datepicker();
          $("#inputreligion").select2(); 
          $("#inputGrade").select2();   
          $("#inputMunCity").select2({maximumSelectionSize: 1 }); 
          
          $("#saveNewInfo").click(function() {
             var url = "<?php echo base_url().'reports/reports_f137/saveNewInfo/'?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: $('#sprSubmitForm').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                        alert(data)
                   }
                 });

          });
        });
        
        

</script>
