
<div class="row">
    <div class="col-lg-12 clearfix">
        <h3 style="margin:5px;" class="page-header text-center">
            <small class="pull-left" style="color:#BB0000; margin-top:5px;" id="name_header"></small>  
            
            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
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
                                    $level['admission_id'] = $students->admission_id;
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
                     <!-- <input type="hidden" id="admission_user_id" value="<?php echo $user_id ?>" />-->
                     <!--<input style="display: none; width:300px" type="text" id="input_user_id" value="<?php echo $students->uid ?>" -->
                     <!--   onkeypress="if (event.keyCode==13){editId_number('<?php echo $students->uid ?>', 'user_id'),$('#a_user_id').show(), $('#input_user_id').hide()}"/> -->
                     <!-- <i id="editUserIDBtn" onclick="$('#a_user_id').hide(), $('#input_user_id').show(),$('#input_user_id').focus(), $('#saveUserIDBtn').show(), $('#closeUserIDBtn').show(), $(this).hide()" style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   -->
                     <!-- <i id="saveUserIDBtn" onclick="editId_number('<?php echo $students->uid ?>', 'user_id'),$('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $('#closeUserIDBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>-->
                     <!-- <i id="closeUserIDBtn" onclick="$('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i> -->
                    </small>
                </h3>
            <h3 style="color:black; margin:3px 0;">
                <small>
                    Status : 
                    <?php
                    switch ($students->status):
                        case 0:
                            $status = 'FOR EVALUATION';
                            $fa = 'fa-minus-circle';
                            $color = 'red';
                            break;
                        case 1:
                        case 2:
                            $status = 'OFFICIALLY ENROLLED';
                            $fa = 'fa-check-circle';
                            $color = 'green';
                            break;
                        case 3:
                            $status = 'FOR PAYMENT';
                            $fa = 'fa-minus-circle';
                            $color = 'red';
                            break;
                        case 4:
                            $status = 'FOR PAYMENT EVALUATION';
                            $fa = 'fa-minus-circle';
                            $color = 'red';
                            break;
                        case 5:
                            $status = 'FOR PAYMENT CONFIRMATION';
                            $fa = 'fa-minus-circle';
                            $color = 'red';
                            break;
                        case 6:
                            $status = 'FOR EVALUATION';
                            $fa = 'fa-minus-circle';
                            $color = 'red';
                            break;
                        case 7:
                            $status = 'WITHDRAW';
                            $fa = 'fa-minus-circle';
                            $color = 'gray';
                            break;
                        case 8:
                            $status = 'TRANSFERRED OUT';
                            $fa = 'fa-minus-circle';
                            $color = 'gray';
                            break;
                    endswitch;

                    echo $status;
                    ?>
                    <i class="fa <?php echo $fa ?>" style="color: <?php echo $color ?>"></i>
                </small>
            </h3>
            </div>
        
    </div>
</div>
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="profile_tab">
            <li class="active"><a onclick="maxMin('prof','max')" href="#PersonalInfo">Personal Information</a></li>
            <li><a class="active" href="#academicInformation">Academic Information</a></li>
            <li><a  onclick="maxMin('prof','min')" href="#studyLoad">Study Load Information</a></li>
    </ul>
    
    <div class="tab-content col-lg-12">
        <div style="padding-top: 15px;" class="tab-pane active" id="PersonalInfo">
            <div class="col-lg-6">
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
                          
                           title="press enter to save your edit"
                           />
                        <i id="editContactBtn" onclick="$('#a_mobile').hide(), $('#mobile').show(),$('#mobile').focus(),$(this).hide(), $('#saveContactBtn').show(), $('#closeContactBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveContactBtn" onclick="saveMobile('<?php echo $user_id ?>',$('#mobile').val(), 'cd_mobile'), $('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $('#closeContactBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeContactBtn" onclick="$('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
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
        </div>
        
                <div class="col-lg-6 pull-right">
                    <img class="img-circle img-responsive pull-right" style="width:150px; border:5px solid #fff" src="<?php if($students->avatar!=""):echo base_url().'uploads/sign/'.$user_id.'.png';else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                </div>
        <div class="col-lg-12">
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
                                    $data['pos'] = 'f';
                                    $data['st_user_id'] = $user_id;
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
                           onkeypress=""
                           title="press enter to save your edit"
                           />
                        <i id="editFOccBtn" onclick="$('#a_f_occupation').hide(), $('#f_occupation').show(),$('#f_occupation').focus(), $('#closeFOccBtn').show(), $('#saveFOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveFOccBtn" onclick="updateOccupation($('#f_occupation').val(), '<?php echo $f->fid; ?>', 'f'),$('#a_f_occupation').show(), $('#m_occupation').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $('#closeFOccBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeFOccBtn" onclick=" $('#a_f_occupation').show(), $('#f_occupation').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_f_office_name" ><?php if($f->f_office_name!=""):echo $f->f_office_name; else: echo "[empty]"; endif; ?></span>
                        <input style="display: none; width:300px" type="text" id="f_office_name" value="<?php echo $students->f_office_name; ?>" 
                               />
                        <i id="editF_office_nameBtn" onclick="$('#a_f_office_name').hide(), $('#f_office_name').show(),$('#f_office_name').focus(), $('#closeM_office_nameBtn').show(), $('#saveF_office_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveF_office_nameBtn" onclick="updateProfile('<?php echo base64_encode('parent_id') ?>','<?php echo base64_encode('esk_profile_parents')?>',<?php echo $students->parent_id ?>,'f_office_name',$('#f_office_name').val(),'f_office_name'),$('#a_f_office_name').show(), $('#f_office_name').hide(), $('#editF_office_nameBtn').show(), $('#saveF_office_nameBtn').hide(), $('#closeF_office_nameBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeF_office_nameBtn" onclick=" $('#a_f_office_name').show(), $('#f_office_name').hide(), $('#editF_office_nameBtn').show(), $('#saveF_office_nameBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fmobile" ><?php if($f->cd_mobile!=""):echo $f->cd_mobile; else: echo "[empty]"; endif; ?></span>
                        <input style="display: none; width:300px" type="text" id="fmobile" value="<?php echo $f->cd_mobile; ?>" 
                              
                               title="press enter to save your edit"
                               />
                        <i id="editFMobileBtn" onclick="$('#a_fmobile').hide(), $('#fmobile').show(),$('#fmobile').focus(), $('#closeFMobileBtn').show(), $('#saveFMobileBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveFMobileBtn" onclick="updateProfile('<?php echo base64_encode('contact_id') ?>','<?php echo base64_encode('esk_profile_contact_details')?>','<?php echo ($f->fid) ?>','cd_mobile',$('#fmobile').val(),'fmobile');$('#a_fmobile').show(), $('#fmobile').hide(),$('#editFMobileBtn').show(), $('#saveFMobileBtn').hide(), $('#closeFMobileBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeFMobileBtn" onclick=" $('#a_fmobile').show(), $('#fmobile').hide(), $('#editFMobileBtn').show(), $('#saveFMobileBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                        
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
                                    $data['pos'] = 'm';
                                    $data['st_user_id'] = $user_id;
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
                        <input style="display: none; width:250px" type="text" id="m_occupation" value="<?php echo $m->occupation; ?>" 
                           onkeypress="if (event.keyCode==13){updateOccupation(this.value, '<?php echo $m->mid; ?>', 'm')}"
                           title="press enter to save your edit"
                           />
                        <i id="editMOccBtn" onclick="$('#a_m_occupation').hide(), $('#m_occupation').show(),$('#m_occupation').focus(), $('#closeMOccBtn').show(), $('#saveMOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveMOccBtn" onclick="updateOccupation($('#m_occupation').val(), '<?php echo $m->mid; ?>', 'm'),$('#a_m_occupation').show(), $('#m_occupation').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $('#closeMOccBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeMOccBtn" onclick="$('#a_m_occupation').show(), $('#m_occupation').hide(), $('#a_m_occupation').show(), $('#m_occupation').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_m_office_name" ><?php if($students->m_office_name!=""):echo $students->m_office_name; else: echo "[empty]"; endif; ?></span>
                        <input style="display: none; width:300px" type="text" id="m_office_name" value="<?php echo $students->m_office_name; ?>" 
                               />
                        <i id="editM_office_nameBtn" onclick="$('#a_m_office_name').hide(), $('#m_office_name').show(),$('#m_office_name').focus(), $('#closeM_office_nameBtn').show(), $('#saveM_office_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveM_office_nameBtn" onclick="updateProfile('<?php echo base64_encode('parent_id') ?>','<?php echo base64_encode('esk_profile_parents')?>',<?php echo $students->parent_id ?>,'m_office_name',$('#m_office_name').val(),'m_office_name'),$('#a_m_office_name').show(), $('#m_office_name').hide(), $('#editM_office_nameBtn').show(), $('#saveM_office_nameBtn').hide(), $('#closeM_office_nameBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeM_office_nameBtn" onclick=" $('#a_m_office_name').show(), $('#m_office_name').hide(), $('#editM_office_nameBtn').show(), $('#saveM_office_nameBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mmobile" ><?php if($m->cd_mobile!=""):echo $m->cd_mobile; else: echo "[empty]"; endif; ?></span>
                    <input style="display: none; width:250px" type="text" id="mmobile" value="<?php echo $m->cd_mobile; ?>" 
                           
                           title="press enter to save your edit"
                           />
                       
                        <i id="editMMobileBtn" onclick="$('#a_mmobile').hide(), $('#mmobile').show(),$('#mmobile').focus(), $('#closeMMobileBtn').show(), $('#saveMMobileBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                        <i id="saveMMobileBtn" onclick="updateProfile('<?php echo base64_encode('contact_id') ?>','<?php echo base64_encode('esk_profile_contact_details')?>','<?php echo ($m->mid) ?>','cd_mobile',$('#mmobile').val(),'mmobile'),$('#a_mmobile').show(), $('#mmobile').hide(), $('#editMMobileBtn').show(), $('#saveMMobileBtn').hide(), $('#closeMMobileBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeMMobileBtn" onclick=" $('#a_mmobile').show(), $('#mmobile').hide(), $('#editMMobileBtn').show(), $('#saveMMobileBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
            </div>
            <hr style="margin:3px 0;" />
            <h5 >In Case of Emergency:</h5>
            <hr style="margin:3px 0 15px;" /> 
                <div class="col-lg-6" style="padding-left: 0;">
                    <dl class="dl-horizontal">
                        <dt>
                            Contact Name :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_ice_name" ><?php if($students->ice_name!=""):echo $students->ice_name; else: echo "[empty]"; endif; ?></span>
                            <input style="display: none; width:300px" type="text" id="ice_name" value="<?php echo $students->ice_name; ?>" 
                                   />
                            <i id="editIce_nameBtn" onclick="$('#a_ice_name').hide(), $('#ice_name').show(),$('#ice_name').focus(), $('#closeIce_nameBtn').show(), $('#saveIce_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveIce_nameBtn" onclick="updateProfile('<?php echo base64_encode('parent_id') ?>','<?php echo base64_encode('esk_profile_parents')?>',<?php echo $user_id ?>,'ice_name',$('#ice_name').val(),'ice_name'),$('#a_ice_name').show(), $('#ice_name').hide(), $('#editIce_nameBtn').show(), $('#saveIce_nameBtn').hide(), $('#closeIce_nameBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeIce_nameBtn" onclick=" $('#a_ice_name').show(), $('#ice_name').hide(), $('#editIce_nameBtn').show(), $('#saveIce_nameBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>
                            Contact Number :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_ice_contact" ><?php if($students->ice_contact!=""):echo $students->ice_contact; else: echo "[empty]"; endif; ?></span>
                            <input style="display: none; width:300px" type="text" id="ice_contact" value="<?php echo $students->ice_contact; ?>" 
                                   />
                            <i id="editIce_contactBtn" onclick="$('#a_ice_contact').hide(), $('#ice_contact').show(),$('#ice_contact').focus(), $('#closeIce_contactBtn').show(), $('#saveIce_contactBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveIce_contactBtn" onclick="updateProfile('<?php echo base64_encode('parent_id') ?>','<?php echo base64_encode('esk_profile_parents')?>',<?php echo $students->parent_id ?>,'ice_contact',$('#ice_contact').val(),'ice_contact'),$('#a_ice_contact').show(), $('#ice_contact').hide(), $('#editIce_contactBtn').show(), $('#saveIce_contactBtn').hide(), $('#closeIce_contactBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeIce_contactBtn" onclick=" $('#a_ice_contact').show(), $('#ice_contact').hide(), $('#editIce_contactBtn').show(), $('#saveIce_contactBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                </div>
                
            </div>    
            
        </div>
        <div class="tab-pane" id="academicInformation">
           <?php 
                echo Modules::run('college/subjectmanagement/academicInformation' , $students, $students->semester); 
           ?>
        </div>
        <div class="tab-pane" id="studyLoad">
           <?php 
           echo Modules::run('college/subjectmanagement/addSubjectLoad', $students, $students->course_id, $students->year_level, $students->semester, $students->school_year) ?>
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
    setFocus();
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
      
    
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
        var adm_id = $('#editAdmission_id').val();
        var year_level = $('#inputYear').val();
        var course = $('#inputGrade').val();
        var semester = $('#inputSemester').val();
        var school_year = $('#inputSY').val();

        var url = "<?php echo base_url().'college/coursemanagement/editCollegeLevel/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'st_id='+st_id+'&admission_id='+adm_id+'&school_year='+school_year+'&year_level='+year_level+'&course='+course+'&semester='+semester+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
      
          
    function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }
    
    
    function scanStudents(value)
    {
         var url = "<?php echo base_url().'college/scanStudent/'?>"+value; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#rfid').val('');
                       document.location = '<?php echo base_url('college/viewCollegeDetails/') ?>'+data.st_id
                       //console.log(data)
                   }
                 });

            return false;  
    }
</script>
