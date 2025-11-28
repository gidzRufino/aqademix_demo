<div class="row">
    <div class="col-lg-12 clearfix">
        <h3 style="margin:5px;" class="page-header text-center">
            <small class="pull-left" style="color:#BB0000; margin-top:5px;" id="name_header"></small>    
            Student Information
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/getStudents') ?>'">Student Roster</button>
              </div>
        </h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="well col-lg-12" id="profBody">
            <div class="col-lg-2">
                <?php if($this->session->userdata('position_id')!=4): ?>
                <!--<a href="<?php echo base_url().'main/crop/'.$this->uri->segment(3) ?>">Crop Image</a>-->
                <?php endif; 
                if($students->u_id==""):
                        $user_id = $students->us_id;
                    else:
                        $user_id = $students->u_id;
                    endif;
                ?>
                <div rel="clickover" 
                     data-content='<?php echo Modules::run('main/showUploadForm', $user_id) ?>'
                         class="clickover">
                    <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php if($students->avatar!=""):echo base_url().'uploads/'.$students->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                </div>
            </div>
            <div class="col-lg-6">
                <h2 style="margin:3px 0;">
                    <span id="name" style="color:#BB0000;"><?php echo $students->firstname." ". $students->lastname ?></span>
                    <small>
                        <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                           rel="clickover" 
                           data-content=" 
                                <?php 
                                $data['user_id'] = $user_id;
                                $data['firstname'] = $students->firstname;
                                $data['middlename'] = $students->middlename;
                                $data['lastname'] = $students->lastname;
                                $data['name_id'] = 'name';
                                $this->load->view('basicInfo', $data) ;
                                
                                switch ($students->year_level):
                                    case 1:
                                        $year_level = 'First Year';
                                    break;
                                    case 2:
                                        $year_level = 'Second Year';
                                    break;
                                    case 3:
                                        $year_level = 'Third Year';
                                    break;
                                    case 4:
                                        $year_level = 'Fourth Year';
                                    break;
                                    case 5:
                                        $year_level = 'Fifth Year';
                                    break;
                                endswitch;
                                 ?>
                                 " 
                           ></i>
                    </small>
                </h2>
                <h3 style="color:black; margin:3px 0;"><?php echo $students->course; ?> - <span id="a_section"><?php echo $year_level; ?></span>
                <?php if($this->session->userdata('is_admin')): ?>
                    <small>
                        <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                           rel="clickover" 
                           data-content=" 
                                    <?php 
                                    $level['course'] = Modules::run('coursemanagement/getCourses');
                                    $level['ro_year'] = Modules::run('registrar/getROYear');
                                    $level['st_id'] = $user_id;
                                    $this->load->view('collegeEditCourses', $level) 
                                     ?>
                                     "   
                               ></i>
                    </small>
                    
                <?php endif; ?>
                    
                </h3>
                <h3 style="color:black; margin:3px 0;">
                    <small>
                        <a title="double click to edit" id="a_user_id"  style="color:#BB0000;">
                             <?php echo $students->uid ?>
                         </a>
                      <input type="hidden" id="admission_user_id" value="<?php echo $user_id ?>" />
                     <input style="display: none; width:300px" type="text" id="input_user_id" value="<?php echo $students->uid ?>" 
                        onkeypress="if (event.keyCode==13){editId_number('<?php echo $students->uid ?>', 'user_id'),$('#a_user_id').show(), $('#input_user_id').hide()}"/> 
                      <i id="editUserIDBtn" onclick="$('#a_user_id').hide(), $('#input_user_id').show(),$('#input_user_id').focus(), $('#saveUserIDBtn').show(), $('#closeUserIDBtn').show(), $(this).hide()" style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                      <i id="saveUserIDBtn" onclick="editId_number('<?php echo $students->uid ?>', 'user_id'),$('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $('#closeUserIDBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                      <i id="closeUserIDBtn" onclick="$('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i> 
                    </small>
                    
                </h3>
            </div>
        
    </div>
</div>
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="profile_tab">
            <li class="active"><a onclick="maxMin('prof','max')" href="#PersonalInfo">Personal Information</a></li>
        <?php if($this->session->userdata('position')!="Registrar"): ?>
            <li><a href="#academicInformation">Academic Information</a></li>
        <?php endif; ?>
            <li><a  onclick="maxMin('prof','min')" href="#studyLoad">Study Load Information</a></li>
        <?php if($this->session->userdata('position')!="Registrar"): ?>
            <li><a href="#medicalInformation">Medical Information</a></li>
        <?php endif; ?>
            <li class="pull-right pointer"><a href="#" onclick="$('#uploadSignature').modal('show')" >Upload Signature</a></li>
    </ul>
    
    <div class="tab-content col-lg-12">
        <div style="padding-top: 15px;" class="tab-pane active" id="PersonalInfo">
                <dl class="dl-horizontal">
                    <dt>
                    Address:
                    </dt>
                    <dd >
                        <span id="address_span"><?php echo $students->street.', '.$students->barangay.' '.$students->mun_city.', '. $students->province.', '. $students->zip_code; ?></span>
                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                           rel="clickover"  id="addClick"
                           data-content="  <?php
                        $data['cities'] =Modules::run('main/getCities');   
                        $data['address_id'] = $students->address_id;
                        $data['st_id'] = $students->st_id;
                        $data['street'] = $students->street;
                        $data['barangay'] = $students->barangay;
                        $data['city'] = $students->city_id;
                        $data['province'] = $students->province;
                        $data['pid'] = $students->province_id;
                        $data['zip_code'] = $students->zip_code;
                        $data['user_id'] = $user_id;
                        $this->load->view('addressInfo', $data) 

                         ?>
                         "></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                    Contact No:
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mobile" ondblclick="$('#a_mobile').hide(), $('#mobile').show(),$('#mobile').focus()" ><?php if($students->cd_mobile!=""):echo $students->cd_mobile; else: echo "[empty]"; endif; ?></span>
                        <input style="display: none; width:300px" type="text" id="mobile" value="<?php echo $students->cd_mobile; ?>" 
                           onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('contact_id') ?>','<?php echo base64_encode('esk_profile_contact_details')?>',<?php echo $students->contact_id ?>,'cd_mobile',this.value,this.id)}"
                           title="press enter to save your edit"
                           onblur="$('#a_mobile').show(), $('#mobile').hide()"
                           />
                        <i onclick="$('#a_mobile').hide(), $('#mobile').show(),$('#mobile').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                    Gender: 
                    </dt>
                    <dd style="color:black; ">
                        <span id="st_sex">
                           <?php echo $students->sex; ?> 
                        </span>
                        
                         <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                           rel="clickover"  
                         <?php if($this->session->userdata('is_admin')): ?>
                               data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px;'>
                                            <label class='control-label'>Gender</label>
                                            <div class='controls' id='AddedSection'>
                                              <select name='inputGender' id='inputGender' class='pull-left' required>
                                                  <option>Select Gender</option>  
                                                  <option value='Male'>Male</option>  
                                                  <option value='Female'>Female</option>  
                                              </select>
                                            </div>
                                        </div>
                                        <div class'col-lg-12'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='saveGender()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                        </div> 
                                     "
                             <?php endif; ?> ></i>             
                    </dd>
                </dl>
            
            <dl class="dl-horizontal">
                <dt>
                    Birthdate: 
                </dt>
                <dd>
                    <span id="a_bdate" >
                        <?php echo $students->cal_date; ?>
                    </span> 
                    <input style="display: none;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="bdate" value="<?php echo $students->cal_date; ?>" placeholder="Date of Birth" 
                        onblur="" onkeypress="if (event.keyCode==13){editBdate(this.value,'<?php echo $students->user_id ?>')}"   
                       
                           required>
                    <i id="editBdateBtn" onclick="$('#bdate').datepicker(), $('#a_bdate').hide(), $('#bdate').show(),$('#bdate').focus(), $('#closeBdateBtn').show(),$('#saveBdateBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveBdateBtn" onclick="editBdate($('#bdate').val(),'<?php echo $user_id ?>'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBdateBtn" onclick="$('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            
            <dl class="dl-horizontal">
                <dt>
                    Religion: 
                </dt>
                <dd>
                    <span id="a_religion" >
                        <?php echo $students->religion; ?>
                    </span> 
                          <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                           rel="clickover"  
                               data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px;'>
                                            <label class='control-label'>Religion</label>
                                            <div class='controls' id='AddedSection'>
                                              <select name='inputReligion' id='inputReligion' class='pull-left' required>
                                                  <option>Select Religion</option>  
                                                  <?php
                                                   foreach ($religion as $rel):
                                                  ?>
                                                  <option value='<?php echo $rel->rel_id ?>'><?php echo $rel->religion ?></option>
                                                  <?php
                                                   endforeach;
                                                  ?>
                                              </select>
                                            </div>
                                        </div>
                                        <div class'col-lg-12'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='saveReligion()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                        </div> 
                                     " ></i> <a class="help-inline" 
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
                                  class="btn" data-toggle="modal" href="#">[ Add Religion ( if not exist ) ]</a>                 
                </dd>
            </dl>
            
            <hr style="margin:3px 0;" />
                <h5 >Family Information</h5>
            <hr style="margin:3px 0 15px;" />
            <div class="col-lg-6" style="padding-left: 0;">
                 <dl class="dl-horizontal">
                    <dt>
                        Father's Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fname" ><?php if($f->lastname!=""):echo $f->firstname.' '.$f->lastname; else: echo "[empty]"; endif;  ?> </span>
                        <small>
                            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> "
                               rel="clickover" 
                               data-content=" 
                                    <?php 
                                    $data['user_id'] = $f->fid;
                                    $data['firstname'] = $f->firstname;
                                    $data['middlename'] = $f->middlename;
                                    $data['lastname'] = $f->lastname;
                                    $data['name_id'] = 'a_fname';
                                    $this->load->view('basicInfo', $data) 

                                     ?>
                                     " 
                               ></i>
                        </small>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="F_educAttainValue" ><?php echo $f->attainment;   ?></span>
                        <small>
                            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                               rel="clickover" 
                               data-content=" 
                                    <select id='F_educAttain' name='inputFeduc' style='width:100%;'>
                                      <option>Select Educational Attainment</option> 
                                      <?php foreach ($educ_attain as $EA) { ?>
                                         <option value='<?php echo $EA->ea_id ?>'><?php echo $EA->attainment ?></option> 
                                      <?php }?>

                                   </select>
                                   <div class'col-lg-12'>
                                         <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                         <a href='#' data-dismiss='clickover' id='F' onclick='updateEducAttain(this.id)' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                    </div>
                                     " 
                               ></i>
                        </small>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                         Occupation :
                    </dt>
                    <dd>
                        <span id="a_f_occupation"><?php echo $f->occupation; ?></span>
                        <input style="display: none; width:300px" type="text" id="f_occupation" value="<?php echo $f->occupation; ?>" 
                           onkeypress="if (event.keyCode==13){updateOccupation(this.value, '<?php echo $f->fid; ?>', 'f')}"
                           title="press enter to save your edit"
                           onblur="$('#a_f_occupation').show(), $('#f_occupation').hide()"
                           />
                        <i onclick="$('#a_f_occupation').hide(), $('#f_occupation').show(),$('#f_occupation').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fmobile" ><?php if($f->cd_mobile!=""):echo $f->cd_mobile; else: echo "[empty]"; endif; ?></span>
                        <input style="display: none; width:300px" type="text" id="fmobile" value="<?php echo $f->cd_mobile; ?>" 
                               onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('contact_id') ?>','<?php echo base64_encode('esk_profile_contact_details')?>',<?php echo $f->contact_id ?>,'cd_mobile',this.value,this.id)}"
                               title="press enter to save your edit"
                               onblur="$('#a_fmobile').show(), $('#fmobile').hide()"
                               />
                        <i onclick="$('#a_fmobile').hide(), $('#fmobile').show(),$('#fmobile').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    </dd>
                </dl>
            </div>
            <div class="col-lg-6">
                 <dl class="dl-horizontal">
                    <dt>
                        Mother's Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mname" ondblclick="$('#a_mname').hide(), $('#mname').show(),$('#mname').focus()" ><?php if($m->lastname!=""):echo $m->firstname.' '.$m->lastname; else: echo "[empty]"; endif; ?> </span>
                        <small>
                            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                               rel="clickover" 
                               data-content=" 
                                    <?php 
                                    $data['user_id'] = $m->mid;
                                    $data['firstname'] = $m->firstname;
                                    $data['middlename'] = $m->middlename;
                                    $data['lastname'] = $m->lastname;
                                    $data['name_id'] = 'a_mname';
                                    $this->load->view('basicInfo', $data) 

                                     ?>
                                     " 
                               ></i>
                        </small>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="M_educAttainValue" ><?php echo $m->attainment;   ?></span>
                        <small>
                            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                               rel="clickover" 
                               data-content=" 
                                    <select id='M_educAttain' name='inputFeduc' style='width:100%;'>
                                      <option>Select Educational Attainment</option> 
                                      <?php foreach ($educ_attain as $EA) { ?>
                                         <option value='<?php echo $EA->ea_id ?>'><?php echo $EA->attainment ?></option> 
                                      <?php }?>

                                   </select>
                                   <div class'col-lg-12'>
                                         <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                         <a href='#' data-dismiss='clickover' id='M' onclick='updateEducAttain(this.id)' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                    </div>
                                     " 
                               ></i>
                        </small>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                         Occupation :
                    </dt>
                    <dd>
                        <span id="a_m_occupation"><?php echo $m->occupation; ?></span>
                        <input style="display: none; width:300px" type="text" id="m_occupation" value="<?php echo $m->occupation; ?>" 
                           onkeypress="if (event.keyCode==13){updateOccupation(this.value, '<?php echo $m->mid; ?>', 'm')}"
                           title="press enter to save your edit"
                           onblur="$('#a_m_occupation').show(), $('#m_occupation').hide()"
                           />
                        <i onclick="$('#a_m_occupation').hide(), $('#m_occupation').show(),$('#m_occupation').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mmobile" ><?php if($m->cd_mobile!=""):echo $m->cd_mobile; else: echo "[empty]"; endif; ?></span>
                    <input style="display: none; width:300px" type="text" id="mmobile" value="<?php echo $m->cd_mobile; ?>" 
                           onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('contact_id') ?>','<?php echo base64_encode('esk_profile_contact_details')?>',<?php echo $m->contact_id ?>,'cd_mobile',this.value,this.id)}"
                           title="press enter to save your edit"
                           onblur="$('#a_mmobile').show(), $('#mmobile').hide()"
                           />
                        <i onclick="$('#a_mmobile').hide(), $('#mmobile').show(),$('#mmobile').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                    </dd>
                </dl>
            </div>
           
            
            
        </div>
        <div class="tab-pane" id="academicInformation">
           <?php 
           echo Modules::run('college/subjectmanagement/academicInformation' , $data) ?>
        </div>
        <div class="tab-pane" id="studyLoad">
           <?php 
           echo Modules::run('college/subjectmanagement/addSubjectLoad', $students, $students->course_id, $students->year_level, $students->semester, $students->school_year) ?>
        </div>
        <div class="tab-pane" id="medicalInformation">
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Blood Type:
                    </dt>
                    <dd>
                        <span  id="a_blood_type"  >
                            <?php echo ($students->blood_type!=""?$students->blood_type:"") ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="blood_type" value="<?php echo ($students->blood_type!=""?$students->blood_type:"") ?>" />
                    <i id="editBtypeBtn" onclick="$('#a_blood_type').hide(), $('#blood_type').show(),$('#blood_type').focus(), $('#closeBtypeBtn').show(),$('#saveBtypeBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveBtypeBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $students->u_id ?>,'blood_type',$('#blood_type').val(),'blood_type'),$('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBtypeBtn" onclick="$('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Height:
                    </dt>
                    <dd>
                        <span  id="a_height"  >
                            <?php echo ($students->height!=""?$students->height:"")  ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="height" value="<?php echo ($students->height!=""?$students->height:"") ?>"  />
                    <i id="editHeightBtn" onclick="$('#a_height').hide(), $('#height').show(),$('#blood_type').focus(), $('#closeHeightBtn').show(),$('#saveHeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveHeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $students->u_id ?>,'height',$('#height').val(),'height'),$('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $('#closeHeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeHeightBtn" onclick="$('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Weight:
                    </dt>
                    <dd>
                        <span  id="a_weight"  >
                            <?php echo ($students->weight!=""?$students->weight:$students->weight) ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="weight" value="<?php echo ($students->weight!=""?$students->weight:$students->weight)  ?>" 
                           onkeypress=""
                           />
                    <i id="editWeightBtn" onclick="$('#a_weight').hide(), $('#weight').show(),$('#blood_type').focus(), $('#closeWeightBtn').show(),$('#saveWeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveWeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $students->u_id ?>,'weight',$('#weight').val(),'weight'),$('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $('#closeWeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeWeightBtn" onclick="$('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Other Medical Info:
                    </dt>
                    <dd>
                        <span  id="a_otherMedInfo"  >
                            <?php echo $students->other_important ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="otherMedInfo" value="<?php echo $students->other_important ?>" 
                           onkeypress=""
                           />
                    <i id="editOtherMedInfoBtn" onclick="$('#a_otherMedInfo').hide(), $('#otherMedInfo').show(),$('#otherMedInfo').focus(), $('#closeOtherMedInfoBtn').show(),$('#saveOtherMedInfoBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveOtherMedInfoBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $students->u_id ?>,'other_important',$('#otherMedInfo').val(),'otherMedInfo'),$('#a_otherMedInfo').show(), $('#otherMedInfo').hide(), $('#editOtherMedInfoBtn').show(), $('#saveOtherMedInfoBtn').hide(), $('#closeOtherMedInfoBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeOtherMedInfoBtn" onclick="$('#a_otherMedInfo').show(), $('#otherMedInfo').hide(), $('#editOtherMedInfoBtn').show(), $('#saveOtherMedInfoBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                
                
            </div>
        </div>
       
    </div>
</div>
<div id="uploadSignature"  style="width:20%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Upload Signature</h6>
        </div>
        <div class="panel-body">
               <?php
                        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
                        echo form_open_multipart(base_url().'main/do_upload', $attributes);
                        ?>
                    <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
                    <br /><br />

                    <input type="hidden" name="picture_option" value="sign" />
                    <input type="submit" value="upload" class="btn-info"/>
                    <input type="hidden" name="id" value="<?php echo $user_id?>" />
                    <input type="hidden" name="location" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" />

                 </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
         
        $(".clickover").clickover({
                placement: 'right',
                html: true
              });
        $("#Feduc_attain").select2(); 
        $(".tip-top").tooltip();   
    });
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    
    function maxMin(body, action)
     {
         if(action=="max"){
             $('#'+body+'Min').removeClass('hide');
             $('#'+body+'Max').addClass('hide')
             $('#'+body+'Body').removeClass('hide fade');
             $('#name_header').html('')
             $('#attend_widget').attr('style', 'max-height: 250px; overflow-y: scroll;');
             //$('#attendance_container').attr('style', 'max-height: 250px; overflow-y: scroll;');
             $('#attend_widget_body').attr('style', 'max-height: 300px; overflow-y: scroll;');
         }else{
             $('#'+body+'Min').addClass('hide')
             $('#'+body+'Max').removeClass('hide');
             $('#'+body+'Body').addClass('hide fade');
             $('#name_header').html($('#name').html())
             $('#attend_widget').attr('style', 'max-height:auto');
             //$('#attendance_container').attr('style', 'max-height:auto');
             $('#attend_widget_body').attr('style', 'max-height:auto');
             
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
      
    function updateEducAttain(mf)
    {
        var pk = '<?php echo base64_encode('user_id') ?>'
        var tbl = '<?php echo base64_encode('esk_profile')?>'
        if(mf=='F'){
            var pk_value = '<?php echo $f->fid ?>'
        }else{
            var pk_value = '<?php echo $m->mid ?>'
        }
        var column = 'educ_attain_id'
        var value = $('#'+mf+'_educAttain').val()
        var id = mf+'_educAttainValue'
        
        updateProfile(pk,tbl, pk_value, column, value, id)
         
    }
    
    function updateOccupation(occ, user_id, mf)
    {
        var url = "<?php echo base_url().'users/editOccupation/' ?>"; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'value='+occ+'&owner='+user_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               //alert(data)
               if(mf=='f'){
                  $('#a_f_occupation').html(data) 
                  $('#a_f_occupation').show()
                  $('#f_occupation').hide()
               }else{
                   $('#a_m_occupation').html(data) 
                  $('#a_m_occupation').show()
                  $('#m_occupation').hide()
               }
               
               

           }
         });
    
    return false;
    }
    
    function editId_number(idNum, id)
    {
        var editedIdNum = $('#input_'+id).val();
        var url = "<?php echo base_url().'registrar/editIdNumber/'?>"
        $.ajax({
                   type: "POST",
                   url: url,
                   data: "origIdNumber="+idNum+"&editedIdNumber="+editedIdNum+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       //$('#Pos').show();
                        $('#a_'+id).html(data)
                        $('#a_'+id).show()
                        $('#input_'+id).hide()
                   }
                 });

       return false; 
    }
    
    
    function editAddressInfo()
    {
        var url = "<?php echo base_url().'registrar/editAddressInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'street='+$('#street').val()+'&user_id='+$('#address_user_id').val()+'&barangay='+$('#barangay').val()+'&city='+$('#city').val()+'&province='+$('#inputPID').val()+'&address_id='+$('#address_id').val()+'&zip_code='+$('#zip_code').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   
                   $('#address_span').html(data);
               }
             });

        return false;
    }
    
    function editBasicInfo()
    {
        var name_id = $('#name_id').val()
        var url = "<?php echo base_url().'registrar/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'lastname='+$('#lastname').val()+'&firstname='+$('#firstname').val()+'&middlename='+$('#middlename').val()+'&rowid='+$('#rowid').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   
                   $('#'+name_id).html(data);
               }
             });

        return false;
    }
    
    function editBdate(cal_id, owner)
    {
    var url = "<?php echo base_url().'calendar/editBdate/' ?>"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'bDate='+cal_id+'&owner='+owner+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               $('#a_bdate').show()
               $('#bdate').hide()
               $('#a_bdate').html(cal_id)

           }
         });
    
    return false;
    }
    
    function editEnBdate(cal_id, owner)
    {
    var url = "<?php echo base_url().'calendar/editEndate/' ?>"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'enDate='+cal_id+'&owner='+owner+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               $('#a_enDate').show()
               $('#enDate').hide()
               $('#enDate').html(cal_id)

           }
         });
    
    return false;
    }
     
    function updateProfile(pk,table, pk_id, column, value, id)
    {
    var url = "<?php echo base_url().'users/editProfile/'?>"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'id='+pk_id+'&column='+column+'&value='+value+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
               $('#a_'+id).show()
               $('#'+id).hide()
               $('#a_'+id).html(data.msg)

           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    }
     
    function saveCollegeLevel()
    {
        var st_id = $('#admission_user_id').val();
        var year_level = $('#inputYear').val();
        var course = $('#inputGrade').val();
        var semester = $('#inputSemester').val();
        var school_year = $('#inputSY').val();

        var url = "<?php echo base_url().'college/coursemanagement/editCollegeLevel/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'st_id='+st_id+'&school_year='+school_year+'&year_level='+year_level+'&course='+course+'&semester='+semester+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data.msg);
                   location.reload()

               }
             });

        return false; // avoid to execute the actual submit of the form.
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
      
    function saveGender()
    {
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $students->u_id ?>'
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+st_id+'&column=sex&value='+$('#inputGender').val()+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#st_sex').html(data.msg)

               }
             });
             return false;
    }
      
    function saveReligion()
    {
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $students->u_id ?>'
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+st_id+'&column=rel_id&value='+$('#inputReligion').val()+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#a_religion').html(data.msg)

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
</script>
