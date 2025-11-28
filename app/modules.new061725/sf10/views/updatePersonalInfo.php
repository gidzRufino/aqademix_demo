<div class="col-lg-6">
    <dl class="dl-horizontal">
        <dt>
            Name :
        </dt>
        <dd id="test">
            <?php echo strtoupper($student->sprp_firstname . " " . substr($student->sprp_middlename, 0, 1) . ". " . $student->sprp_lastname . " " . $student->sprp_extname) ?>
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
                <?php echo strtoupper(date('F d, Y', strtotime($student->sprp_bdate))) ?>
            </span>
            <input style="display: none;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="bdate" value="<?php echo $students->bdate_id; ?>" placeholder="Date of Birth" 
                   onblur="" required>
            <i id="editBdateBtn" onclick="$('#bdate').datepicker(), $('#a_bdate').hide(), $('#bdate').show(), $('#bdate').focus(), $('#closeBdateBtn').show(), $('#saveBdateBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
            <i id="saveBdateBtn" onclick="$('#editVal').val($('#bdate').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('sprp_bdate', 'gs_spr_profile', 'sprp_st_id'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closeBdateBtn" onclick="$('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
        </dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>
            Gender:
        </dt>
        <dd >
            <span id="a_bdate" >
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

</div>
<div class="col-lg-6">
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
            <input style="display: none;" name="region" type="text" data-date-format="yyyy-mm-dd" id="region" value="<?php echo $student->school_id; ?>" placeholder="Region" 
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