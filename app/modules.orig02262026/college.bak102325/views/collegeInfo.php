
<div class="row">
    <div class="col-lg-12 clearfix">
        <h3 style="margin:5px;" class="page-header text-center">
            <small class="pull-left" style="color:#BB0000; margin-top:5px;" id="name_header"></small>  

            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
            Student Information
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college/getStudents') ?>'">Student Rosters</button>
            </div>
        </h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="well col-lg-12" id="profBody">
        <div class="col-lg-2">
            <?php if ($this->session->userdata('position_id') != 4): ?>
                            <!--<a href="<?php echo base_url() . 'main/crop/' . $this->uri->segment(3) ?>">Crop Image</a>-->
                <?php
            endif;
            $user_id = $students->u_id;
            /*
              if($students->u_id==""):
              $user_id = $students->us_id;
              else:
              $user_id = $students->u_id;
              endif; */
            ?>
            <div onclick="imgSignUpload(this.id)" id="photo">
                <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php
                if ($students->avatar != ""):echo base_url() . 'uploads/' . $students->avatar;
                else:echo base_url() . 'uploads/noImage.png';
                endif;
                ?>" />
            </div>
        </div>
        <input type="hidden" id="stdUserID" value="<?php echo $user_id ?>" />
        <div class="col-lg-6">
            <h2 style="margin:3px 0;">
                <span id="name" style="color:#BB0000;"><?php echo strtoupper($students->firstname . " " . $students->lastname) ?></span>
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
                       $this->load->view('basicInfo', $data);

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
                <?php if ($this->session->userdata('is_admin')): ?>
                    <small>
                        <i onclick="$('#inputGrade').select2();" style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                           rel="clickover" 
                           data-content=" 
                           <?php
                           $level['admission_id'] = $students->admission_id;
                           $level['course'] = Modules::run('coursemanagement/getCourses');
                           $level['ro_year'] = Modules::run('registrar/getROYear');
                           $level['st_id'] = $students->uid;
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
                    <!--<input type="hidden" id="admission_user_id" value="<?php echo $user_id ?>" />-->
                    <!--<input style="display: none; width:300px" type="text" id="input_user_id" value="<?php echo $students->uid ?>" -->
                    <!--       onkeypress="if (event.keyCode == 13) {-->
                    <!--                   editId_number('<?php echo $students->uid ?>', 'user_id'), $('#a_user_id').show(), $('#input_user_id').hide()}"/> -->
                    <!--<i id="editUserIDBtn" onclick="$('#a_user_id').hide(), $('#input_user_id').show(), $('#input_user_id').focus(), $('#saveUserIDBtn').show(), $('#closeUserIDBtn').show(), $(this).hide()" style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   -->
                    <!--<i id="saveUserIDBtn" onclick="editId_number('<?php echo $students->uid ?>', 'user_id'), $('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $('#closeUserIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>-->
                    <!--<i id="closeUserIDBtn" onclick="$('#a_user_id').show(), $('#input_user_id').hide(), $('#editUserIDBtn').show(), $('#saveUserIDBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i> -->
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
        <?php
        
        foreach ($menus as $m):
            $menu = Modules::run('college/getMenu', $m);
            if ($menu->cmenu_type == 'tab'):
                ?>
                <li class="<?php echo ($menu->cmenu_id == 15 ? 'pull-right' : 'pull-left') ?>"><a onclick="<?php echo ($menu->cmenu_id == 15 ? $menu->cmenu_link : $menu->cmenu_note) ?>" href="<?php echo $menu->cmenu_link ?>" id="<?php echo ($menu->cmenu_id == 15 ? 'sign' : '') ?>"><?php echo $menu->cmenu_name ?></a></li>

                <?php
            endif;
        endforeach;
        ?>
    </ul>

    <div class="tab-content col-lg-12">
        <div style="padding-top: 15px;" class="tab-pane" id="PersonalInfo">
            <div class="col-lg-6 pull-right">
                <img class="img-responsive pull-right" style="width:150px; border:5px solid #fff" src="<?php
                if ($students->avatar != ""):
                    echo base_url() . 'uploads/sign/' . $user_id . '.png';
                else:
                    echo base_url() . 'uploads/noImage.png';
                endif;
                ?>" />
            </div>
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Address:
                    </dt>
                    <dd >
                        <span id="address_span"><?php echo $students->street . ', ' . $students->barangay . ' ' . $students->mun_city . ', ' . $students->province . ', ' . $students->zip_code; ?></span>
                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                           rel="clickover"  id="addClick"
                           data-content="  <?php
                           $data['cities'] = Modules::run('main/getCities');
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
                        <span title="double click to edit" id="a_mobile" ondblclick="$('#a_mobile').hide(), $('#mobile').show(), $('#mobile').focus()" ><?php
                            if ($students->cd_mobile != ""):echo $students->cd_mobile;
                            else: echo "[empty]";
                            endif;
                            ?></span>
                        <input style="display: none; width:300px" type="text" id="mobile" value="<?php echo $students->cd_mobile; ?>" 

                               title="press enter to save your edit"
                               />
                        <i id="editContactBtn" onclick="$('#a_mobile').hide(), $('#mobile').show(), $('#mobile').focus(), $(this).hide(), $('#saveContactBtn').show(), $('#closeContactBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveContactBtn" onclick="saveMobile('<?php echo $user_id ?>', $('#mobile').val(), 'cd_mobile'), $('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $('#closeContactBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeContactBtn" onclick="$('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
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
                           <?php if ($this->session->userdata('is_admin')): ?>
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
                            <?php echo $students->temp_bdate; ?>
                        </span> 
                        <input style="display: none;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="bdate" value="<?php echo $students->temp_bdate; ?>" placeholder="Date of Birth" 
                               onblur="" onkeypress="if (event.keyCode == 13) {
                                           editBdate(this.value, '<?php echo $students->user_id ?>')
                                       }"   

                               required>
                        <i id="editBdateBtn" onclick="$('#bdate').datepicker(), $('#a_bdate').hide(), $('#bdate').show(), $('#bdate').focus(), $('#closeBdateBtn').show(), $('#saveBdateBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveBdateBtn" onclick="editBdate($('#bdate').val(), '<?php echo $user_id ?>'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeBdateBtn" onclick="$('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
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
                            
                            <span title="double click to edit" id="a_fname" >
                                <?php
                                if ($students->f_lastname != ""):echo strtoupper($students->f_firstname . ' ' . $students->f_lastname );
                                else: echo "[empty]";
                                endif;
                                ?>
                            </span>
                            <small>
                                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> "
                                   rel="clickover" 
                                   data-content=" 
                                   <?php

                                   $data['pos'] = 'f';
                                   $data['school_year']     = $students->school_year;
                                   $data['parent_id']       = $students->p_id;
                                   $data['st_user_id']      = $user_id;
                                   $data['firstname']       = $students->f_firstname;
                                   $data['middlename']      = $students->f_middlename;
                                   $data['lastname']        = $students->f_lastname;
                                   $this->load->view('parentBasicInfo', $data)
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
                            <span id="F_educAttainValue" ><?php echo $f->attainment; ?></span>
                            <small>
                                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                                   rel="clickover" 
                                   data-content=" 
                                   <select id='F_educAttain' name='inputFeduc' style='width:100%;'>
                                   <option>Select Educational Attainment</option> 
                                   <?php foreach ($educ_attain as $EA) { ?>
                                       <option value='<?php echo $EA->ea_id ?>'><?php echo $EA->attainment ?></option> 
                                   <?php } ?>

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
                            <?php $f_occ = Modules::run('registrar/getOccupation', $students->f_occ); ?>
                            <span id="a_f_occupation"><?php echo strtoupper($f_occ->occupation); ?></span>
                            <input style="display: none; width:300px" type="text" id="f_occupation" value="<?php echo $f_occ->occupation; ?>" 
                                   onkeypress=""
                                   title="press enter to save your edit"
                                   />
                            <i id="editFOccBtn" onclick="$('#a_f_occupation').hide(), $('#f_occupation').show(), $('#f_occupation').focus(), $('#closeFOccBtn').show(), $('#saveFOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveFOccBtn" onclick="updateOccupation($('#f_occupation').val(), '<?php echo $students->p_id; ?>', 'f'), $('#a_f_occupation').show(), $('#m_occupation').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $('#closeFOccBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeFOccBtn" onclick=" $('#a_f_occupation').show(), $('#f_occupation').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>
                            Office :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_f_office_name" ><?php
    if ($students->f_office_name != ""):echo strtoupper($students->f_office_name);
    else: echo "[empty]";
    endif;
    ?></span>
                            <input style="display: none; width:300px" type="text" id="f_office_name" value="<?php echo $students->f_office_name; ?>" 
                                   />
                            <i id="editF_office_nameBtn" onclick="$('#a_f_office_name').hide(), $('#f_office_name').show(), $('#f_office_name').focus(), $('#closeM_office_nameBtn').show(), $('#saveF_office_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveF_office_nameBtn" onclick="updateProfile('<?php echo base64_encode('p_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>',<?php echo $students->p_id ?>, 'f_office_name', $('#f_office_name').val(), 'f_office_name'), $('#a_f_office_name').show(), $('#f_office_name').hide(), $('#editF_office_nameBtn').show(), $('#saveF_office_nameBtn').hide(), $('#closeF_office_nameBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeF_office_nameBtn" onclick=" $('#a_f_office_name').show(), $('#f_office_name').hide(), $('#editF_office_nameBtn').show(), $('#saveF_office_nameBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>
                            Contact :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_fmobile" ><?php
                               if ($students->f_mobile != ""):echo $students->f_mobile;
                               else: echo "[empty]";
                               endif;
                               ?></span>
                            <input style="display: none; width:300px" type="text" id="fmobile" value="<?php echo $students->f_mobile; ?>" 

                                   title="press enter to save your edit"
                                   />
                            <i id="editFMobileBtn" onclick="$('#a_fmobile').hide(), $('#fmobile').show(), $('#fmobile').focus(), $('#closeFMobileBtn').show(), $('#saveFMobileBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveFMobileBtn" onclick="updateProfile('<?php echo base64_encode('p_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>',<?php echo $students->p_id ?>, 'f_mobile', $('#fmobile').val(), 'fmobile');
                                    $('#a_fmobile').show(), $('#fmobile').hide(), $('#editFMobileBtn').show(), $('#saveFMobileBtn').hide(), $('#closeFMobileBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeFMobileBtn" onclick=" $('#a_fmobile').show(), $('#fmobile').hide(), $('#editFMobileBtn').show(), $('#saveFMobileBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>

                </div>

                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>
                            Mother's Name :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_mname" ondblclick="$('#a_mname').hide(), $('#mname').show(), $('#mname').focus()" ><?php
                                   if ($students->m_lastname != ""):echo strtoupper($students->m_firstname . ' ' . $students->m_lastname);
                                   else: echo "[empty]";
                                   endif;
                                   ?> </span>
                            <small>
                                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                                   rel="clickover" 
                                   data-content=" 
                                <?php

                                   $data['pos'] = 'm';
                                   $data['school_year'] = $students->school_year;
                                   $data['parent_id'] = $students->p_id;
                                   $data['st_user_id'] = $user_id;
                                   $data['firstname'] = $students->m_firstname;
                                   $data['middlename'] = $students->m_middlename;
                                   $data['lastname'] = $students->m_lastname;
                                   $this->load->view('parentBasicInfo', $data);
                                   print_r($m)                             ?>
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
                            <span id="M_educAttainValue" ><?php echo strtoupper($m->attainment); ?></span>
                            <small>
                                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                                   rel="clickover" 
                                   data-content=" 
                                   <select id='M_educAttain' name='inputFeduc' style='width:100%;'>
                                   <option>Select Educational Attainment</option> 
    <?php foreach ($educ_attain as $EA) { ?>
                                       <option value='<?php echo $EA->ea_id ?>'><?php echo $EA->attainment ?></option> 
    <?php } ?>

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
                            <?php $m_occ = Modules::run('registrar/getOccupation', $students->m_occ); ?>
                            <span id="a_m_occupation"><?php echo strtoupper($m_occ->occupation); ?></span>
                            <input style="display: none; width:250px" type="text" id="m_occupation" value="<?php echo $m_occ->occupation; ?>" 
                                   onkeypress="if (event.keyCode == 13) {
                                               updateOccupation(this.value, '<?php echo $user_id; ?>', 'm')
                                           }"
                                   title="press enter to save your edit"
                                   />
                            <i id="editMOccBtn" onclick="$('#a_m_occupation').hide(), $('#m_occupation').show(), $('#m_occupation').focus(), $('#closeMOccBtn').show(), $('#saveMOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveMOccBtn" onclick="updateOccupation($('#m_occupation').val(), '<?php echo $students->p_id; ?>', 'm'), $('#a_m_occupation').show(), $('#m_occupation').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $('#closeMOccBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeMOccBtn" onclick="$('#a_m_occupation').show(), $('#m_occupation').hide(), $('#a_m_occupation').show(), $('#m_occupation').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>
                            Office :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_m_office_name" ><?php
                                if ($students->m_office_name != ""):echo strtoupper($students->m_office_name);
                                else: echo "[empty]";
                                endif;
    ?></span>
                            <input style="display: none; width:300px" type="text" id="m_office_name" value="<?php echo $students->m_office_name; ?>" 
                                   />
                            <i id="editM_office_nameBtn" onclick="$('#a_m_office_name').hide(), $('#m_office_name').show(), $('#m_office_name').focus(), $('#closeM_office_nameBtn').show(), $('#saveM_office_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveM_office_nameBtn" onclick="updateProfile('<?php echo base64_encode('p_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>',<?php echo $students->p_id ?>, 'm_office_name', $('#m_office_name').val(), 'm_office_name'), $('#a_m_office_name').show(), $('#m_office_name').hide(), $('#editM_office_nameBtn').show(), $('#saveM_office_nameBtn').hide(), $('#closeM_office_nameBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeM_office_nameBtn" onclick=" $('#a_m_office_name').show(), $('#m_office_name').hide(), $('#editM_office_nameBtn').show(), $('#saveM_office_nameBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>
                            Contact :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_mmobile" ><?php
                                if ($students->m_mobile != ""):echo $students->m_mobile;
                                else: echo "[empty]";
                                endif;
    ?></span>
                            <input style="display: none; width:250px" type="text" id="mmobile" value="<?php echo $students->m_mobile; ?>" 

                                   title="press enter to save your edit"
                                   />

                            <i id="editMMobileBtn" onclick="$('#a_mmobile').hide(), $('#mmobile').show(), $('#mmobile').focus(), $('#closeMMobileBtn').show(), $('#saveMMobileBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveMMobileBtn" onclick="updateProfile('<?php echo base64_encode('p_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>', '<?php echo ($students->p_id) ?>', 'm_mobile', $('#mmobile').val(), 'mmobile'), $('#a_mmobile').show(), $('#mmobile').hide(), $('#editMMobileBtn').show(), $('#saveMMobileBtn').hide(), $('#closeMMobileBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeMMobileBtn" onclick=" $('#a_mmobile').show(), $('#mmobile').hide(), $('#editMMobileBtn').show(), $('#saveMMobileBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

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
                            <span title="double click to edit" id="a_ice_name" ><?php
                                if ($students->ice_name != ""):echo strtoupper($students->ice_name);
                                else: echo "[empty]";
                                endif;
    ?></span>
                            <input style="display: none; width:300px" type="text" id="ice_name" value="<?php echo $students->ice_name; ?>" 
                                   />
                            <i id="editIce_nameBtn" onclick="$('#a_ice_name').hide(), $('#ice_name').show(), $('#ice_name').focus(), $('#closeIce_nameBtn').show(), $('#saveIce_nameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveIce_nameBtn" onclick="updateProfile('<?php echo base64_encode('u_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>','<?php echo $user_id ?>', 'ice_name', $('#ice_name').val(), 'ice_name'), $('#a_ice_name').show(), $('#ice_name').hide(), $('#editIce_nameBtn').show(), $('#saveIce_nameBtn').hide(), $('#closeIce_nameBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeIce_nameBtn" onclick=" $('#a_ice_name').show(), $('#ice_name').hide(), $('#editIce_nameBtn').show(), $('#saveIce_nameBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>
                            Contact Number :
                        </dt>
                        <dd>
                            <span title="double click to edit" id="a_ice_contact" ><?php
                    if ($students->ice_contact != ""):echo $students->ice_contact;
                    else: echo "[empty]";
                    endif;
                    ?></span>
                            <input style="display: none; width:300px" type="text" id="ice_contact" value="<?php echo $students->ice_contact; ?>" 
                                   />
                            <i id="editIce_contactBtn" onclick="$('#a_ice_contact').hide(), $('#ice_contact').show(), $('#ice_contact').focus(), $('#closeIce_contactBtn').show(), $('#saveIce_contactBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>
                            <i id="saveIce_contactBtn" onclick="updateProfile('<?php echo base64_encode('u_id') ?>', '<?php echo base64_encode('esk_profile_parent') ?>','<?php echo $user_id ?>', 'ice_contact', $('#ice_contact').val(), 'ice_contact'), $('#a_ice_contact').show(), $('#ice_contact').hide(), $('#editIce_contactBtn').show(), $('#saveIce_contactBtn').hide(), $('#closeIce_contactBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeIce_contactBtn" onclick=" $('#a_ice_contact').show(), $('#ice_contact').hide(), $('#editIce_contactBtn').show(), $('#saveIce_contactBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                        </dd>
                    </dl>
                </div>

            </div>    




        </div>
        <div class="tab-pane" id="academicInformation" style="">
            <?php
            echo Modules::run('college/subjectmanagement/academicInformation', $students, $students->semester);
            ?>
        </div>
        <div class="tab-pane" id="studyLoad" style="">
            <?php echo Modules::run('college/subjectmanagement/addSubjectLoad', $students, $students->course_id, $students->year_level, $students->semester, $students->school_year) ?>
        </div>
        <div class="tab-pane" id="addDrop" style="">
            <?php echo Modules::run('college/subjectmanagement/addDrop', $students, $students->course_id, $students->year_level, $students->semester, $students->school_year) ?>
        </div>
        <div class="tab-pane" id="medicalInformation" style="display:none;">
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Blood Type:
                    </dt>
                    <dd>
                        <span  id="a_blood_type"  >
                            <?php echo ($students->blood_type != "" ? $students->blood_type : "") ?>
                        </span> 
                        <input style="display: none; width:250px" type="text" id="blood_type" value="<?php echo ($students->blood_type != "" ? $students->blood_type : "") ?>" />
                        <i id="editBtypeBtn" onclick="$('#a_blood_type').hide(), $('#blood_type').show(), $('#blood_type').focus(), $('#closeBtypeBtn').show(), $('#saveBtypeBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveBtypeBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>', '<?php echo base64_encode('esk_profile_medical') ?>',<?php echo $students->u_id ?>, 'blood_type', $('#blood_type').val(), 'blood_type'), $('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeBtypeBtn" onclick="$('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Height:
                    </dt>
                    <dd>
                        <span  id="a_height"  >
                            <?php echo ($students->height != "" ? $students->height : "") ?>
                        </span> 
                        <input style="display: none; width:250px" type="text" id="height" value="<?php echo ($students->height != "" ? $students->height : "") ?>"  />
                        <i id="editHeightBtn" onclick="$('#a_height').hide(), $('#height').show(), $('#blood_type').focus(), $('#closeHeightBtn').show(), $('#saveHeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveHeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>', '<?php echo base64_encode('esk_profile_medical') ?>',<?php echo $students->u_id ?>, 'height', $('#height').val(), 'height'), $('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $('#closeHeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeHeightBtn" onclick="$('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Weight:
                    </dt>
                    <dd>
                        <span  id="a_weight"  >
                            <?php echo ($students->weight != "" ? $students->weight : $students->weight) ?>
                        </span> 
                        <input style="display: none; width:250px" type="text" id="weight" value="<?php echo ($students->weight != "" ? $students->weight : $students->weight) ?>" 
                               onkeypress=""
                               />
                        <i id="editWeightBtn" onclick="$('#a_weight').hide(), $('#weight').show(), $('#blood_type').focus(), $('#closeWeightBtn').show(), $('#saveWeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveWeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>', '<?php echo base64_encode('esk_profile_medical') ?>',<?php echo $students->u_id ?>, 'weight', $('#weight').val(), 'weight'), $('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $('#closeWeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeWeightBtn" onclick="$('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
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
                        <i id="editOtherMedInfoBtn" onclick="$('#a_otherMedInfo').hide(), $('#otherMedInfo').show(), $('#otherMedInfo').focus(), $('#closeOtherMedInfoBtn').show(), $('#saveOtherMedInfoBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                        <i id="saveOtherMedInfoBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>', '<?php echo base64_encode('esk_profile_medical') ?>',<?php echo $students->u_id ?>, 'other_important', $('#otherMedInfo').val(), 'otherMedInfo'), $('#a_otherMedInfo').show(), $('#otherMedInfo').hide(), $('#editOtherMedInfoBtn').show(), $('#saveOtherMedInfoBtn').hide(), $('#closeOtherMedInfoBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeOtherMedInfoBtn" onclick="$('#a_otherMedInfo').show(), $('#otherMedInfo').hide(), $('#editOtherMedInfoBtn').show(), $('#saveOtherMedInfoBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>


            </div>
        </div>
        <div class="tab-pane" id="enrollmentRequirements" style="">
            <h3>CheckList</h3>
            <?php
            $data['stid'] = $students->uid;
            $data['level'] = 20;
            echo $this->load->view('checkListPerDept', $data);
            ?>
        </div>

    </div>
</div>
<div id="uploadSignature"  style="width:20%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h6>Upload Signature</h6>

        </div>
        <div class="panel-body">
            <?php
            $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
            echo form_open_multipart(base_url() . 'main/do_upload', $attributes);
            ?>
            <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
            <br /><br />

            <input type="hidden" name="picture_option" value="sign" />
            <input type="submit" value="upload" class="btn-info"/>
            <input type="hidden" name="id" value="<?php echo $user_id ?>" />
            <input type="hidden" name="location" value="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) ?>" />

            </form>
        </div>
    </div>
</div>

<div id="overideStudyLoad"  style="width:50%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Sorry, This subject cannot be taken due to subject prerequisite issue, do you still want to overide this and load the subject?
            </h3>
        </div>
        <div class="panel-body bg-danger">
            <div style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='overidePreReq()' style='margin-right:10px; color: white;' class='btn btn-small btn-success pull-right'>Yes</a>
                <button data-dismiss='modal' class='btn  btn-small btn-warning pull-right'  style='margin-right:10px; color: white;'>No</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<input type="hidden" id="admission_id" value="<?php echo $students->admission_id ?>" />
<?php $this->load->view('imgCrop'); ?>
<script type="text/javascript">

    $(document).ready(function () {

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




    function saveMobile(user_id, mobile_no, column)
    {
        var url = "<?php echo base_url() . 'hr/saveContacts/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'user_id=' + user_id + '&mobile_no=' + mobile_no + '&column=' + column + '&sy='+'<?php echo $students->school_year ?>' +'&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#a_mobile').html(mobile_no)
                alert('Successfully Updated');
            }
        })
    }

    function maxMin(body, action)
    {
        if (action == "max") {
            $('#' + body + 'Min').removeClass('hide');
            $('#' + body + 'Max').addClass('hide')
            $('#' + body + 'Body').removeClass('hide fade');
            $('#name_header').html('')
            $('#attend_widget').attr('style', 'max-height: 250px; overflow-y: scroll;');
            //$('#attendance_container').attr('style', 'max-height: 250px; overflow-y: scroll;');
            $('#attend_widget_body').attr('style', 'max-height: 300px; overflow-y: scroll;');
        } else {
            $('#' + body + 'Min').addClass('hide')
            $('#' + body + 'Max').removeClass('hide');
            $('#' + body + 'Body').addClass('hide fade');
            $('#name_header').html($('#name').html())
            $('#attend_widget').attr('style', 'max-height:auto');
            //$('#attendance_container').attr('style', 'max-height:auto');
            $('#attend_widget_body').attr('style', 'max-height:auto');

        }
    }

    function getProvince(value)
    {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#inputProvince').val(data.name)
                $('#inputPID').val(data.id)
            }
        })
    }

    function updateEducAttain(mf)
    {
        var pk = '<?php echo base64_encode('user_id') ?>'
        var tbl = '<?php echo base64_encode('esk_profile') ?>'
        if (mf == 'F') {
            var pk_value = '<?php echo $f->fid ?>'
        } else {
            var pk_value = '<?php echo $m->mid ?>'
        }
        var column = 'educ_attain_id'
        var value = $('#' + mf + '_educAttain').val()
        var id = mf + '_educAttainValue'

        updateProfile(pk, tbl, pk_value, column, value, id)

    }

    function updateOccupation(occ, user_id, mf)
    {
        var url = "<?php echo base_url() . 'users/editOccupation/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'value=' + occ + '&owner=' + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //alert(data)
                if (mf == 'f') {
                    $('#a_f_occupation').html(data)
                    $('#a_f_occupation').show()
                    $('#f_occupation').hide()
                } else {
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
        var editedIdNum = $('#input_' + id).val();
        var url = "<?php echo base_url() . 'registrar/editIdNumber/' ?>"
        $.ajax({
            type: "POST",
            url: url,
            data: "origIdNumber=" + idNum + "&editedIdNumber=" + editedIdNum + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$('#Pos').show();
                $('#a_' + id).html(data)
                $('#a_' + id).show()
                $('#input_' + id).hide()
            }
        });

        return false;
    }


    function editAddressInfo()
    {
        var url = "<?php echo base_url() . 'registrar/editAddressInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'street=' + $('#street').val() + '&user_id=' + $('#address_user_id').val() + '&barangay=' + $('#barangay').val() + '&city=' + $('#city').val() + '&province=' + $('#inputPID').val() + '&address_id=' + $('#address_id').val() + '&zip_code=' + $('#zip_code').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$("form#quoteForm")[0].reset()
                location.reload();
            }
        });

        return false;
    }

    function editBasicInfo()
    {
        var name_id = $('#name_id').val();
        var school_year = '<?php echo segment_5 ?>';
        var url = "<?php echo base_url() . 'registrar/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&rowid=' + $('#rowid').val()+ '&sy=' + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$("form#quoteForm")[0].reset()

                $('#' + name_id).html(data);
            }
        });

        return false;
    }

    function editBdate(cal_id, owner)
    {
        var url = "<?php echo base_url() . 'calendar/editBdate/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'bDate=' + cal_id + '&owner=' + owner + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
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
        var url = "<?php echo base_url() . 'calendar/editEndate/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'enDate=' + cal_id + '&owner=' + owner + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#a_enDate').show()
                $('#enDate').hide()
                $('#enDate').html(cal_id)

            }
        });

        return false;
    }

    function updateProfile(pk, table, pk_id, column, value, id)
    {
        var sy = '<?php echo segment_5 ?>';
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$("form#quoteForm")[0].reset()
                $('#a_' + id).show()
                $('#' + id).hide()
                $('#a_' + id).html(data.msg)

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function saveCollegeLevel()
    {
        var st_id = $('#editCourse_st_id').val();
        var adm_id = $('#editAdmission_id').val();
        var year_level = $('#inputYear').val();
        var course = $('#inputGrade').val();
        var semester = $('#inputSemester').val();
        var school_year = $('#inputSY').val();

        var url = "<?php echo base_url() . 'college/coursemanagement/editCollegeLevel/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'st_id=' + st_id + '&admission_id=' + adm_id + '&school_year=' + school_year + '&year_level=' + year_level + '&course=' + course + '&semester=' + semester + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data.msg);
                location.reload()

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function selectSection(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#inputSection').html(data);
            }
        });

        return false;
    }

    function saveGender()
    {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $students->u_id ?>'
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + st_id + '&column=sex&value=' + $('#inputGender').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$("form#quoteForm")[0].reset()
                $('#st_sex').html(data.msg)

            }
        });
        return false;
    }

    function saveReligion()
    {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $students->u_id ?>'
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + st_id + '&column=rel_id&value=' + $('#inputReligion').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$("form#quoteForm")[0].reset()
                $('#a_religion').html(data.msg)

            }
        });
        return false;
    }

    function saveNewValue(table) {
        var db_table = $('#' + table).attr('table')
        var db_column = $('#' + table).attr('column')
        var pk = $('#' + table).attr('pk')
        var retrieve = $('#' + table).attr('retrieve')
        var db_value = $('#add' + db_column).val()
        var url = "<?php echo base_url() . 'registrar/saveNewValue/' ?>"// the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "table=" + db_table + "&column=" + db_column + "&value=" + db_value + "&pk=" + pk + "&retrieve=" + retrieve + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#input' + db_column).html(data)
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
        var url = "<?php echo base_url() . 'college/scanStudent/' ?>" + value; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#rfid').val('');
                document.location = '<?php echo base_url('college/viewCollegeDetails/') ?>' + data.st_id
                //console.log(data)
            }
        });

        return false;
    }


    function imgSignUpload(id) {
        //alert(id + ' ' + $('#stdUserID').val());
        $('#stdUID').val($('#stdUserID').val());
        $('#picture_option').val(id);
        $('#imgUpload').modal('show');
    }


    var sub_id = 0;
    var sec_id = 0;

//    function printStudyLoad(sem, year)
//    {
//        if ($('#reprint').is(':checked')) {
//            var url = "<?php echo base_url('college/subjectmanagement/printStudyLoad/') . base64_encode($student->u_id) ?>/" + sem + '/' + year + '/' + 1;
//        } else {
//            var url = "<?php echo base_url('college/subjectmanagement/printStudyLoad/') . base64_encode($student->u_id) ?>/" + sem + '/' + year;
//        }
//        // the script where you handle the form input.    
//        window.open(url, '_blank');
//    }


    function overidePreReq()
    {
        saveLoadedSubject(sub_id, sec_id, 1);
    }

    function saveLoadedSubject(sub_id, section_id, overided)
    {
        var url = "<?php echo base_url() . 'college/subjectmanagement/saveLoadedSubject/' ?>";
        var school_year = '<?php echo $students->school_year ?>';
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: "subject_id=" + sub_id + '&section_id=' + section_id + '&overide=' + overided+'&school_year='+school_year + '&admission_id=' + '<?php echo $students->admission_id ?>' + '&student_id=' + '<?php echo $students->u_id ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#subjectTaken').html(data);
            }
        });
    }


    function removeLoadedSubject(sub_id, isDropped, user_id = null)
    {
        var url = "<?php echo base_url() . 'college/subjectmanagement/removeLoadedSubject/' ?>";
        var school_year = '<?php echo $students->school_year ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "subject_id=" + sub_id + '&isDropped=' + isDropped + '&user_id=' + user_id +'&school_year='+school_year+ '&admission_id=' + '<?php echo $students->admission_id ?>' + '&student_id=' + '<?php echo $students->u_id ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.

        });
    }

    function removeSubject(subject_id, pre_req)
    {
        var con = confirm('Are you sure you want to remove this subject?');
        if (con == true)
        {
            var lectUnit = $('#' + subject_id + '_lect').html();
            var unitTaken = $('#totalLect_taken').html();
            removeLoadedSubject(subject_id, 0);
            var unitsTaken = parseInt(unitTaken) - parseInt(lectUnit);
            $('#totalLect_taken').html(unitsTaken)

            if (unitsTaken === 0)
            {
                $('#tr_total_taken').hide()
            }
            //        $('#trtaken_'+subject_id).hide();
            //        $('#subjectOffered').prepend('<tr class=\'pointer\' onclick=\'addSubject('+subject_id+', "'+pre_req+'" )\' id=\'tr_'+subject_id+'\'>'+$('#trtaken_'+subject_id).html()+'</tr>')
            $('#trtaken_' + subject_id).remove();
        }

    }

    function removeDropSubject(subject_id, isDropped, user_id)
    {
        var con = confirm('Are you sure you want to remove this subject?');
        if (con == true)
        {
            var lectUnit = $('#' + subject_id + '_lect').html();
            var unitTaken = $('#totalLect_taken').html();
            removeLoadedSubject(subject_id, isDropped, user_id);
            var unitsTaken = parseInt(unitTaken) - parseInt(lectUnit);
            $('#totalLect_taken').html(unitsTaken)

            if (unitsTaken === 0)
            {
                $('#tr_total_taken').hide()
            }
            //        $('#trtaken_'+subject_id).hide();
            //        $('#subjectOffered').prepend('<tr class=\'pointer\' onclick=\'addSubject('+subject_id+', "'+pre_req+'" )\' id=\'tr_'+subject_id+'\'>'+$('#trtaken_'+subject_id).html()+'</tr>')
            $('#trtaken_' + subject_id).remove();
        }

    }
</script>
