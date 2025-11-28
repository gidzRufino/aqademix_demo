<style>
    dl.dl-horizontal
    {
        margin-bottom: 0px !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top:5px; margin-bottom: 5px;">Generate DepEd Form 137 - A
            <div class="form-group pull-right" style="margin-right:20px;font-size: 15px;">
                <div class="controls" id="AddedSection">
                    <a href="#form137Settings" data-toggle="modal">
                        <i title="settings" data-toggle="tooltip" data-placement="top"  class="fa fa-cog fa-2x pull-right pointer tip-top"></i>
                    </a>
                    <a href="<?php echo base_url('sf10/generateForm137') ?>" class="pull-right "><i class="fa fa-search fa-2x pointer"></i></a>
                </div>
            </div>
        </h3>
    </div>
</div>

<div class="col-lg-12" id="searchStudent">
    <div class="col-lg-2"></div>
    <div class="input-group col-lg-8">
        <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
        <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none; top:50px" class="resultOverflow" id="searchName">

        </div>
        <div class="input-group-btn">
            <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (segment_6 == '' ? $this->session->school_year : segment_6) . ' - ' . ((segment_6 == '' ? $this->session->school_year : segment_6) + 1) ?> <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php
                $ro_years = Modules::run('install/spr_records/databaseList');
                $settings = $this->eskwela->getSet();
                $numString = strlen($settings->short_name) + 8;
                foreach ($ro_years as $ro) {
                    if ("eskwela_" . strtolower($settings->short_name) == substr($ro, 0, $numString)) {
                        ?>
                        <li onclick="$('#btnControl').html('<?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?>  <span class=\'caret\'></span>'), $('#inputSchoolYear').val('<?php echo substr($ro, $numString + 1, $numString + 5) ?>')" class="<?php echo (substr($ro, $numString + 1, $numString + 5) == substr(segment_6, 0, 4) ? 'active' : '') ?>"><a href="#"><?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <input type="hidden" id="inputSchoolYear" value="<?php echo $this->session->school_year ?>" />
        </div><!-- /btn-group -->
    </div>
</div>
<div id="generatedResult" class="row col-lg-12">
    <div class="btn-group pull-right">
        <button  class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add a Record</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li onclick="$('#autoSelect').modal('show')"><a href="#">Academic</a></li>
            <li onclick="$('#attendanceInformation').modal('show')"><a href="#">Attendance</a></li>
        </ul>
    </div>
    <div class="well col-lg-12" id="profBody">
        <div class="col-lg-6"><h3>Personal Information </h3>
            <dl class="dl-horizontal">
                <dt>
                    Name :
                </dt>
                <dd id="test">
                    <span id="nameInfo">
                        <?php echo strtoupper($student->sprp_firstname . " " . substr($student->sprp_middlename, 0, 1) . ". " . $student->sprp_lastname . " " . $student->sprp_extname) ?>
                    </span>
                    <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>" onclick="$('#skulYR').val(<?php echo $student->school_year ?>)"
                       rel="clickover" 
                       data-content=" 
                       <?php
                       $data['pos'] = 's';
                       $data['st_user_id'] = $student->st_id;
                       $data['user_id'] = $student->st_id;
                       $data['firstname'] = $student->sprp_firstname;
                       $data['middlename'] = $student->sprp_middlename;
                       $data['lastname'] = $student->sprp_lastname;
                       $data['ext'] = $student->sprp_extname;
                       $data['name_id'] = 'name';
                       $this->load->view('basicInfo', $data)
                       ?>
                       " 
                       ></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Date of Birth :
                </dt>
                <dd>
                    <span id="a_bdate" >
                        <?php echo strtoupper(date('F d, Y', strtotime($student->sprp_bdate))) ;
 //print_r($student);
                                ?>
                    </span>
                    <input style="display: none;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="bdate" value="<?php echo $student->temp_bdate; ?>" placeholder="Date of Birth" 
                           onblur="" required>
                    <i id="editBdateBtn" onclick="$('#bdate').datepicker(), $('#a_bdate').hide(), $('#bdate').show(), $('#bdate').focus(), $('#closeBdateBtn').show(), $('#saveBdateBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveBdateBtn" onclick="$('#editVal').val($('#bdate').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_bdate', 'gs_spr_profile', 'sprp_st_id'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBdateBtn" onclick="$('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Place of Birth:
                </dt>
                <dd >
                    <span id="Bplace_span"><?php echo $student->sprp_bplace ?></span>
                    <input style="display: none;" name="Bplace" type="text" id="Bplace" value="<?php echo $student->sprp_bplace ?>" placeholder="Bplace" 
                           onblur="" required>
                    <i id="editBplaceBtn" onclick="$('#Bplace_span').hide(), $('#Bplace').show(), $('#Bplace').focus(), $('#closeBplaceBtn').show(), $('#saveBplaceBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveBplaceBtn" onclick="$('#editVal').val($('#Bplace').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_bplace', 'gs_spr_profile', 'sprp_st_id'), $('#Bplace_span').show(), $('#Bplace').hide(), $('#editBplaceBtn').show(), $('#saveBplaceBtn').hide(), $('#closeBplaceBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBplaceBtn" onclick="$('#Bplace_span').show(), $('#Bplace').hide(), $('#editBplaceBtn').show(), $('#saveBplaceBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Gender:
                </dt>
                <dd >
                    <span id="a_gender" >
                        <?php echo strtoupper($student->sprp_gender) ?>
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
                           <a href='#' id='sprp_gender' data-dismiss='clickover' onclick='$(&quot;#editVal&quot;).val($(&quot;#inputGender&quot;).val()), editInfo(this.id, &quot;gs_spr_profile&quot;, &quot;sprp_st_id&quot;)' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                           </div> 
                           "
                       <?php endif; ?>>
                    </i>    
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Nationality:
                </dt>
                <dd >
                    <span id="nationality_span"><?php echo $student->sprp_nationality ?></span>
                    <input style="display: none;" name="nationality" type="text" id="nationality" value="<?php echo $student->sprp_nationality ?>" placeholder="Nationality" 
                           onblur="" required>
                    <i id="editNationalityBtn" onclick="$('#nationality_span').hide(), $('#nationality').show(), $('#nationality').focus(), $('#closeNationalityBtn').show(), $('#saveNationalityBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveNationalityBtn" onclick="$('#editVal').val($('#nationality').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_nationality', 'gs_spr_profile', 'sprp_st_id'), $('#nationality_span').show(), $('#nationality').hide(), $('#editNationalityBtn').show(), $('#saveNationalityBtn').hide(), $('#closeNationalityBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeNationalityBtn" onclick="$('#nationality_span').show(), $('#nationality').hide(), $('#editNationalityBtn').show(), $('#saveNationalityBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Religion:
                </dt>
                <dd >
                    <span id="religion_span"><?php echo $student->sprp_rel_id ?></span>
                    <input style="display: none;" name="religion" type="text" id="religion" value="<?php echo $student->sprp_rel_id ?>" placeholder="Religion" 
                           onblur="" required>
                    <i id="editReligionBtn" onclick="$('#religion_span').hide(), $('#religion').show(), $('#religion').focus(), $('#closeReligionBtn').show(), $('#saveReligionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveReligionBtn" onclick="$('#editVal').val($('#religion').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_rel_id', 'gs_spr_profile', 'sprp_st_id'), $('#religion_span').show(), $('#religion').hide(), $('#editReligionBtn').show(), $('#saveReligionBtn').hide(), $('#closeReligionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeReligionBtn" onclick="$('#religion_span').show(), $('#religion').hide(), $('#editReligionBtn').show(), $('#saveReligionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Tel./Cel.No:
                </dt>
                <dd >
                    <span id="contacNum_span"><?php echo $student->tel_no  ?></span>
                    <input style="display: none;" name="contactNum" type="text" id="contactNum" value="<?php  ?>" placeholder="Contact Number" 
                           onblur="" required>
                    <i id="editContactBtn" onclick="$('#contacNum_span').hide(), $('#contactNum').show(), $('#contactNum').focus(), $('#closeContactBtn').show(), $('#saveContactBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveContactBtn" onclick="$('#editVal').val($('#contactNum').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('tel_no', 'gs_spr_profile', 'sprp_st_id'), $('#contacNum_span').show(), $('#contactNum').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $('#closeContactBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeContactBtn" onclick="$('#contacNum_span').show(), $('#contactNum').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Address:
                    <?php $p_add = Modules::run('sf10/getAddress', $student->st_id, 1); ?>
                </dt>
                <dd >
                    <span id="address_span"><?php echo strtoupper($p_add->street . ', ' . $p_add->barangay_id . ' ' . $p_add->mun_city . ', ' . $p_add->province . ', ' . $p_add->zip_code); ?></span>
                    <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                       rel="clickover"  id="addClick"
                       data-content="  <?php
                       $data['cities'] = Modules::run('main/getCities');
                       $data['address_id'] = $p_add->address_id;
                       $data['st_id'] = $p_add->st_id;
                       $data['street'] = $p_add->street;
                       $data['barangay'] = $p_add->barangay;
                       $data['city'] = $p_add->city_id;
                       $data['province'] = $p_add->province;
                       $data['pid'] = $p_add->province_id;
                       $data['zip_code'] = $p_add->zip_code;
                       $data['user_id'] = $p_add->sprp_id;
                       $data['is_home'] = 1;
                       $this->load->view('addressInfo', $data)
                       ?>
                       "></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Father's Name:
                </dt>
                <dd >
                    <span id="father_span"><?php echo $student->sprp_father ?></span>
                    <input style="display: none;" name="fatherName" type="text" id="fatherName" value="<?php echo $student->sprp_father ?>" placeholder="Father Name" 
                           onblur="" required>
                    <i id="editFatherBtn" onclick="$('#father_span').hide(), $('#fatherName').show(), $('#fatherName').focus(), $('#closeFatherBtn').show(), $('#saveFatherBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveFatherBtn" onclick="$('#editVal').val($('#fatherName').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_father', 'gs_spr_profile', 'sprp_st_id'), $('#father_span').show(), $('#fatherName').hide(), $('#editFatherBtn').show(), $('#saveFatherBtn').hide(), $('#closeFatherBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeFatherBtn" onclick="$('#father_span').show(), $('#fatherName').hide(), $('#editFatherBtn').show(), $('#saveFatherBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Father's Occupation:
                </dt>
                <dd >
                    <span id="fatherOcc_span"><?php echo $student->sprp_father_occ ?></span>
                    <input style="display: none;" name="fatherOcc" type="text" id="fatherOcc" value="<?php echo $student->sprp_father_occ ?>" placeholder="Father's Occupation" 
                           onblur="" required>
                    <i id="editFOccBtn" onclick="$('#fatherOcc_span').hide(), $('#fatherOcc').show(), $('#fatherOcc').focus(), $('#closeFOccBtn').show(), $('#saveFOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveFOccBtn" onclick="$('#editVal').val($('#fatherOcc').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_father_occ', 'gs_spr_profile', 'sprp_st_id'), $('#fatherOcc_span').show(), $('#fatherOcc').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $('#closeFOccBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeFOccBtn" onclick="$('#fatherOcc_span').show(), $('#fatherOcc').hide(), $('#editFOccBtn').show(), $('#saveFOccBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Mother's Name:
                </dt>
                <dd >
                    <span id="mother_span"><?php echo $student->sprp_mother ?></span>
                    <input style="display: none;" name="motherName" type="text" id="motherName" value="<?php echo $student->sprp_mother ?>" placeholder="Mother Name" 
                           onblur="" required>
                    <i id="editMotherBtn" onclick="$('#mother_span').hide(), $('#motherName').show(), $('#motherName').focus(), $('#closeMotherBtn').show(), $('#saveMotherBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveMotherBtn" onclick="$('#editVal').val($('#motherName').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_mother', 'gs_spr_profile', 'sprp_st_id'), $('#mother_span').show(), $('#motherName').hide(), $('#editMotherBtn').show(), $('#saveMotherBtn').hide(), $('#closeMotherBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeMotherBtn" onclick="$('#mother_span').show(), $('#motherName').hide(), $('#editMotherBtn').show(), $('#saveMotherBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Mother's Occupation:
                </dt>
                <dd >
                    <span id="motherOcc_span"><?php echo $student->sprp_mother_occ ?></span>
                    <input style="display: none;" name="motherOcc" type="text" id="motherOcc" value="<?php echo $student->sprp_mother_occ ?>" placeholder="Mother's Occupation" 
                           onblur="" required>
                    <i id="editMOccBtn" onclick="$('#motherOcc_span').hide(), $('#motherOcc').show(), $('#motherOcc').focus(), $('#closeMOccBtn').show(), $('#saveMOccBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveMOccBtn" onclick="$('#editVal').val($('#motherOcc').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_mother_occ', 'gs_spr_profile', 'sprp_st_id'), $('#motherOcc_span').show(), $('#motherOcc').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $('#closeMOccBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeMOccBtn" onclick="$('#motherOcc_span').show(), $('#motherOcc').hide(), $('#editMOccBtn').show(), $('#saveMOccBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
        </div>
        <div class="col-lg-6"><h3>School Information</h3>
            <dl class="dl-horizontal">
                <dt>
                    LRN:
                </dt>
                <dd >
                    <span id="lrn_span"><?php echo (strtoupper($student->sprp_lrn != '' ? $student->sprp_lrn : 'not set')); ?></span>
                    <input style="display: none;" name="inputLRN" type="text" data-date-format="yyyy-mm-dd" id="lrn" value="<?php echo $student->sprp_lrn; ?>" placeholder="LRN" 
                           onblur="" required>
                    <i id="editLRNBtn" onclick="$('#lrn_span').hide(), $('#lrn').show(), $('#lrn').focus(), $('#closeLRNBtn').show(), $('#saveLRNBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveLRNBtn" onclick="$('#editVal').val($('#lrn').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_lrn', 'gs_spr_profile', 'sprp_st_id'), $('#lrn_span').show(), $('#lrn').hide(), $('#editLRNBtn').show(), $('#saveLRNBtn').hide(), $('#closeLRNBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeLRNBtn" onclick="$('#lrn_span').show(), $('#lrn').hide(), $('#editLRNBtn').show(), $('#saveLRNBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    School Name:
                </dt>
                <dd >
                    <span id="school_span">
                        <?php echo strtoupper($student->school_name) ?>
                    </span>
                    <input style="display: none;" name="inputSchool" type="text" data-date-format="yyyy-mm-dd" id="school" value="<?php echo $student->school_name; ?>" placeholder="School Name" 
                           onblur="" required>
                    <i id="editschoolBtn" onclick="$('#school_span').hide(), $('#school').show(), $('#school').focus(), $('#closeschoolBtn').show(), $('#saveschoolBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveschoolBtn" onclick="$('#editVal').val($('#school').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_name', 'gs_spr', 'st_id'), $('#school_span').show(), $('#school').hide(), $('#editschoolBtn').show(), $('#saveschoolBtn').hide(), $('#closeschoolBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeschoolBtn" onclick="$('#school_span').show(), $('#school').hide(), $('#editschoolBtn').show(), $('#saveschoolBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>

            <dl class="dl-horizontal">
                <dt>
                    School ID :
                </dt>
                <dd >
                    <span id="schID_span">
                        <?php echo strtoupper($student->school_id) ?>
                    </span>
                    <input style="display: none;" name="school_id" type="text" data-date-format="yyyy-mm-dd" id="school_id" value="<?php echo $student->school_id; ?>" placeholder="School ID" 
                           onblur="" required>
                    <i id="editschIDBtn" onclick="$('#schID_span').hide(), $('#school_id').show(), $('#school_id').focus(), $('#closeschIDBtn').show(), $('#saveschIDBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveschIDBtn" onclick="$('#editVal').val($('#school_id').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_id', 'gs_spr', 'st_id'), $('#schID_span').show(), $('#school_id').hide(), $('#editschIDBtn').show(), $('#saveschIDBtn').hide(), $('#closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeschIDBtn" onclick="$('#schID_span').show(), $('#school_id').hide(), $('#editschIDBtn').show(), $('#saveschIDBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    District :
                </dt>
                <dd >
                    <span id="district_span">
                        <?php echo strtoupper($student->district); ?>
                    </span>
                    <input style="display: none;" name="district" type="text" data-date-format="yyyy-mm-dd" id="district" value="<?php echo $student->district; ?>" placeholder="School district" 
                           onblur="" required>
                    <i id="editdistrictBtn" onclick="$('#district_span').hide(), $('#district').show(), $('#district').focus(), $('#closedistrictBtn').show(), $('#savedistrictBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savedistrictBtn" onclick="$('#editVal').val($('#district').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('district', 'gs_spr', 'st_id'), $('#district_span').show(), $('#district').hide(), $('#editdistrictBtn').show(), $(this).hide(), $('#closedistrictBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closedistrictBtn" onclick="$('#district_span').show(), $('#district').hide(), $('#editdistrictBtn').show(), $('#savedistrictBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Division :
                </dt>
                <dd >
                    <span id="division_span">
                        <?php echo strtoupper($student->division); ?>
                    </span>
                    <input style="display: none;" name="division" type="text" data-date-format="yyyy-mm-dd" id="division" value="<?php echo $student->division; ?>" placeholder="School division" 
                           onblur="" required>
                    <i id="editdivisionBtn" onclick="$('#division_span').hide(), $('#division').show(), $('#division').focus(), $('#closedivisionBtn').show(), $('#savedivisionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savedivisionBtn" onclick="$('#editVal').val($('#division').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('division', 'gs_spr', 'st_id'), $('#division_span').show(), $('#division').hide(), $('#editdivisionBtn').show(), $(this).hide(), $('#closedivisionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closedivisionBtn" onclick="$('#division_span').show(), $('#division').hide(), $('#editdivisionBtn').show(), $('#savedivisionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Region :
                </dt>
                <dd >
                    <span id="region_span">
                        <?php echo strtoupper($student->region); ?>
                    </span>
                    <input style="display: none;" name="region" type="text" data-date-format="yyyy-mm-dd" id="region" value="<?php echo $student->region; ?>" placeholder="Region" 
                           onblur="" required>
                    <i id="editregionBtn" onclick="$('#region_span').hide(), $('#region').show(), $('#region').focus(), $('#closeregionBtn').show(), $('#saveregionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveregionBtn" onclick="$('#editVal').val($('#region').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('region', 'gs_spr', 'st_id'), $('#region_span').show(), $('#region').hide(), $('#editregionBtn').show(), $(this).hide(), $('#closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeregionBtn" onclick="$('#region_span').show(), $('#region').hide(), $('#editregionBtn').show(), $('#saveregionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Adviser / Teacher :
                </dt>
                <dd >
                    <span id="adviser_span">
                        <?php echo strtoupper($student->spr_adviser); ?>
                    </span>
                    <input style="display: none;" name="adviser" type="text" data-date-format="yyyy-mm-dd" id="adviser" value="<?php echo $student->spr_adviser; ?>" placeholder="Adviser / Teacher" 
                           onblur="" required>
                    <i id="editadviserBtn" onclick="$('#adviser_span').hide(), $('#adviser').show(), $('#adviser').focus(), $('#closeadviserBtn').show(), $('#saveadviserBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveadviserBtn" onclick="$('#editVal').val($('#adviser').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('spr_adviser', 'gs_spr', 'st_id'), $('#adviser_span').show(), $('#adviser').hide(), $('#editadviserBtn').show(), $(this).hide(), $('#closeadviserBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeadviserBtn" onclick="$('#adviser_span').show(), $('#adviser').hide(), $('#editadviserBtn').show(), $('#saveadviserBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
        </div>    
    </div>
</div>
<?php echo Modules::run('sf10/generateF137', base64_encode($student->st_id), $status, $dataSY) ?>
<input type="hidden" id="skulYR" value="<?php echo $dataSY ?>" />
<input type="hidden" id="editVal" />
<input type="hidden" id="uid" value="<?php echo $student->u_id ?>" />
<input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
<input type="hidden" id="pgLevel" value="<?php echo $student->grade_level_id ?>" />
<input type="hidden" id="sySelected" />
<?php

$subject['subjects'] = $subjects;
$this->load->view('inputManually', $subject)
?>

<script type="text/javascript">

    $(function () {
        //setTimeout(check, 10000);
    });
    
    
    function check() {
        var url = '<?php echo base_url() . 'sf10/checkStudentsInfo/' ?>' + $('#st_id').val() + '/' + <?php echo segment_5 ?>;
//            alert(url);
        $.ajax({
            //type: 'GET',
            url: url,
            data: "",
            dataType: 'json',
            success: function (result) {
                $('#nameInfo').text(result.sprp_firstname.toUpperCase() + ' ' + result.sprp_middlename.substring(0,1).toUpperCase() + ' ' + result.sprp_lastname.toUpperCase());
                $('#a_bdate').text(result.sprp_bdate);
                $('#a_gender').text(result.sprp_gender);
                $('#lrn_span').text(result.sprp_lrn);
                $('#school_span').text(result.school_name.toUpperCase());
                $('#schID_span').text(result.school_id);
                $('#district_span').text(result.district.toUpperCase());
                $('#division_span').text(result.division.toUpperCase());
                $('#region_span').text(result.region);
                $('#adviser_span').text(result.spr_adviser.toUpperCase());                    
            }
        });
    }

    $(document).ready(function () {
        $("#inputMonthForm137").select2();
        $("#inputStudent").select2();
        $("#inputSubject").select2();
        $("#inputGradeLevel").select2();
        $(".tip-top").tooltip();

        // alert($.cookie('csrf_cookie_name'))
        $(".clickover").clickover({
            placement: 'right',
            html: true
        });

    });

    function loadStudentDetails(st_id, status, year)
    {
        var url = '<?php echo base_url() . 'sf10/getPersonalInfo/' ?>' + st_id + '/' + status + '/' + year;
        document.location = url;
    }

    function search(value)
    {
        var sy = $('#inputSchoolYear').val();
        var url = '<?php echo base_url() . 'sf10/searchStudent/' ?>' + value + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#searchName').show();
                $('#searchName').html(data);
            }
        });

        return false;
    }

    function generateForm(st_id)
    {

        var url = "<?php echo base_url() . 'sf10/generateF137/' ?>" + st_id;
        $.ajax({
            type: "GET",
            url: url,
            data: 'qcode=' + st_id, // serializes the form's elements.
            success: function (data)
            {
                $('#generatedResult').html(data)

            }
        });
    }

    function saveNumberOfDays()
    {
        var url = "<?php echo base_url() . 'sf10/saveSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val() + '&month=' + $('#inputMonthForm137').val() + "&numOfSchoolDays=" + $('#numOfSchoolDays').val(), // serializes the form's elements.
            success: function (data)
            {
                $('#sd_' + data.month).html(data.days);
            }
        });
    }

    function getSchoolDays(value)
    {
        var url = "<?php echo base_url() . 'sf10/getSchoolDays/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&year=' + $('#year').val(),
            success: function (data)
            {
                $('#tableDays').html(data);
            }
        })
    }

    function getDaysPresent(value)
    {
        var url = "<?php echo base_url() . 'sf10/getDaysPresentModal/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'month=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&spr_id=' + $('#spr_id').val(),
            success: function (data)
            {
                $('#daysPresentResult').html(data);
            }
        })
    }


    function deleteSPRecord()
    {
        var url = "<?php echo base_url() . 'sf10/deleteSPRecords/' ?>" + $('#spr_id').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }

    function deleteSingleRecord(id)
    {
        var url = "<?php echo base_url() . 'sf10/deleteSingleRecord/' ?>" + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                if (data.status) {
                    alert('Successfully Deleted');
                } else {
                    alert('Internal Error Occured');
                }
            }
        })
    }

    function editBasicInfo()
    {
        var name_id = $('#name_id').val();
        var sy = $('#skulYR').val();
        var url = "<?php echo base_url() . 'sf10/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&nameExt=' + $('#nameExt').val() + '&rowid=' + $('#rowid').val() + '&user_id=' + $('#st_user_id').val() + '&pos=' + $('#pos').val() + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
//                $('#' + name_id).html(data);
//                window.location.href = '<?php //echo base_url() . 'reports/reports_f137/getPersonalInfo/' . base64_encode($student->st_id) . '/1/'   ?>' + sy;
            }
        });

        return false;
    }

    function editInfo(field, tbl_name, stid, sem = null)
    {
        var newVal = $('#editVal').val();
        var owner = $('#st_id').val();
        var sy = $('#skulYR').val();
//        alert(newVal + ' ' + owner + ' ' + sy + ' ' + field + ' ' + tbl_name + ' ' + stid);
        var url = "<?php echo base_url() . 'sf10/editInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'newVal=' + newVal + '&owner=' + owner + '&sem=' + sem + '&sy=' + sy + '&field=' + field + '&tbl_name=' + tbl_name + '&stid=' + stid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //window.location.href = '<?php// echo base_url() . 'reports/reports_f137/getPersonalInfo/' . base64_encode($student->st_id) . '/1/' . $student->school_year ?>';
            }
        });

        return false;
    }
    
    function editAddressInfo()
    {
        var url = "<?php echo base_url() . 'sf10/editAddressInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'street=' + $('#street').val() + '&user_id='+$('#address_user_id').val() + '&barangay=' + $('#barangay').val() + '&city=' + $('#city').val() + '&province=' + $('#inputPID').val() + '&address_id=' + '<?php echo $student->sprp_id ?>' + '&zip_code=' + $('#zip_code').val() + '&sy=' + $('#gsYr').val() + '&isHome=' + $('#is_home').val() +  '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$('#address_span').html(data);
                //location.reload();
            }
        });

        return false;
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
    
    

</script>
