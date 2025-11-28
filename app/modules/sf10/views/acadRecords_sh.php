<?php
function levelDesc($gradeID) {
    switch ($gradeID):
        case 12:
            return 'Grade 11';
        case 13:
            return 'Grade 12';
    endswitch;
}


    echo Modules::run('sf10/attendanceManualOveride', base64_encode($stDetailsFirst->st_id), $gsYR, $stDetailsFirst->semester);
    echo Modules::run('sf10/attendanceManualOveride', base64_encode($stDetailsSecond->st_id), $gsYR, $stDetailsSecond->semester);
    
?>
<div class="well col-lg-12">
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                Grade Level:
            </dt>
            <dd >
                <span id="acad_level_span">
                    <?php echo strtoupper(levelDesc($stDetailsFirst->grade_level_id)) ?>
                </span>
                <select style="width:225px; display: none" name="acad_level" id="acad_level">
                    <option>Select Grade Level</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo ($i + 1) ?>" <?php echo ($stDetailsFirst->grade_level_id == ($i + 1) ? 'selected' : '') ?>>Grade <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
<!--                <input style="display: none;" name="acad_level" type="text" data-date-format="yyyy-mm-dd" id="acad_level" value="<?php //echo $stDetailsFirst->grade_level_id;                                                 ?>" placeholder="Grade Level" 
                       onblur="" required>-->
                <i id="acad_editlevelBtn" onclick="$('#acad_level_span').hide(), $('#acad_level').show(), $('#acad_level').focus(), $('#acad_closelevelBtn').show(), $('#acad_savelevelBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savelevelBtn" onclick="$('#editVal').val($('#acad_level').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('grade_level_id', 'gs_spr', 'st_id', 'acad_level_span'), $('#acad_level').show(), $('#acad_level').hide(), $('#acad_editlevelBtn').show(), $('#acad_savelevelBtn').hide(), $('#acad_closelevelBtn').hide(), $('#acad_level_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closelevelBtn" onclick="$('#acad_level_span').show(), $('#acad_level').hide(), $('#acad_editlevelBtn').show(), $('#acad_savelevelBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Section:
            </dt>
            <dd >
                <span id="acad_section_span">
                    <?php echo strtoupper($stDetailsFirst->section) ?>
                </span>
                <input style="display: none;" name="acad_section" type="text" id="acad_section" value="<?php echo $stDetailsFirst->section; ?>" placeholder="School Name" 
                       onblur="" required>
                <i id="acad_editsectionBtn" onclick="$('#acad_section_span').hide(), $('#acad_section').show(), $('#acad_section').focus(), $('#acad_closesectionBtn').show(), $('#acad_savesectionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savesectionBtn" onclick="$('#editVal').val($('#acad_section').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('section', 'gs_spr', 'st_id', 1), $('#acad_section').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $('#acad_closesectionBtn').hide(), $('#acad_section_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closesectionBtn" onclick="$('#acad_section_span').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <?php if ($stDetailsFirst->grade_level_id == 12 || $stDetailsFirst->grade_level_id == 13): ?>
            <?php $strand = Modules::run('sf10/getStrandCode', $stDetailsFirst->strandid); ?>
            <?php $offeredStrand = Modules::run('sf10/getSHOfferedStrand'); ?>
            <dl class="dl-horizontal">
                <dt>
                    Strand:
                </dt>
                <dd >
                    <span id="acad_strand_span">
                        <?php echo strtoupper($strand->short_code) ?>
                    </span>
                    <select style="width:225px; display: none" name="acad_strand" id="acad_strand">
                        <option>Select Strand</option>
                        <?php foreach ($offeredStrand as $os): ?>
                            <option value="<?php echo $os->st_id ?>" <?php echo ($os->st_id == $strand->st_id ? 'selected' : '') ?>><?php echo $os->short_code ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i id="acad_editstrandBtn" onclick="$('#acad_strand_span').hide(), $('#acad_strand').show(), $('#acad_strand').focus(), $('#acad_closestrandBtn').show(), $('#acad_savestrandBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="acad_savestrandBtn" onclick="$('#editVal').val($('#acad_strand').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('strandid', 'gs_spr', 'st_id', 1), $('#acad_strand').show(), $('#acad_strand').hide(), $('#acad_editstrandBtn').show(), $('#acad_savestrandBtn').hide(), $('#acad_closestrandBtn').hide(), $('#acad_strand_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="acad_closestrandBtn" onclick="$('#acad_strand_span').show(), $('#acad_strand').hide(), $('#acad_editstrandBtn').show(), $('#acad_savestrandBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
        <?php endif; ?>
        <dl class="dl-horizontal">
            <dt>
                School Name:
            </dt>
            <dd >
                <span id="acad_school_span">
                    <?php echo strtoupper($stDetailsFirst->school_name) ?>
                </span>
                <input type="text" name="acad_school" id="acad_school" value="<?php echo $stDetailsFirst->school_name; ?>" placeholder="School Name" style="display: none;"
                       onblur="" required>
                <i id="acad_editschoolBtn" onclick="$('#acad_school_span').hide(), $('#acad_school').show(), $('#acad_school').focus(), $('#acad_closeschoolBtn').show(), $('#acad_saveschoolBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschoolBtn" onclick="$('#editVal').val($('#acad_school').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_name', 'gs_spr', 'st_id', 1), $('#acad_school_span').show(), $('#acad_school').hide(), $('#acad_editschoolBtn').show(), $('#acad_saveschoolBtn').hide(), $('#acad_closeschoolBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeschoolBtn" onclick="$('#acad_school_span').show(), $('#acad_school').hide(), $('#acad_editschoolBtn').show(), $('#acad_saveschoolBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                School ID :
            </dt>
            <dd >
                <span id="acad_schID_span">
                    <?php echo strtoupper($stDetailsFirst->school_id) ?>
                </span>
                <input style="display: none;" name="acad_school_id" type="text" data-date-format="yyyy-mm-dd" id="acad_school_id" value="<?php echo $stDetailsFirst->school_id; ?>" placeholder="School ID" 
                       onblur="" required>
                <i id="acad_editschIDBtn" onclick="$('#acad_schID_span').hide(), $('#acad_school_id').show(), $('#acad_school_id').focus(), $('#acad_closeschIDBtn').show(), $('#acad_saveschIDBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschIDBtn" onclick="$('#editVal').val($('#acad_school_id').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_id', 'gs_spr', 'st_id', 1), $('#acad_schID_span').show(), $('#acad_school_id').hide(), $('#acad_editschIDBtn').show(), $('#acad_saveschIDBtn').hide(), $('#acad_closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeschIDBtn" onclick="$('#acad_schID_span').show(), $('#acad_school_id').hide(), $('#acad_editschIDBtn').show(), $('#acad_saveschIDBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
    </div>
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                District :
            </dt>
            <dd >
                <span id="acad_district_span">
                    <?php echo strtoupper($stDetailsFirst->district); ?>
                </span>
                <input style="display: none;" name="acad_district" type="text" data-date-format="yyyy-mm-dd" id="acad_district" value="<?php echo $stDetailsFirst->district; ?>" placeholder="School district" 
                       onblur="" required>
                <i id="acad_editdistrictBtn" onclick="$('#acad_district_span').hide(), $('#acad_district').show(), $('#acad_district').focus(), $('#acad_closedistrictBtn').show(), $('#acad_savedistrictBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedistrictBtn" onclick="$('#editVal').val($('#acad_district').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('district', 'gs_spr', 'st_id', 1), $('#acad_district_span').show(), $('#acad_district').hide(), $('#acad_editdistrictBtn').show(), $(this).hide(), $('#acad_closedistrictBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedistrictBtn" onclick="$('#acad_district_span').show(), $('#acad_district').hide(), $('#acad_editdistrictBtn').show(), $('#acad_savedistrictBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Division :
            </dt>
            <dd >
                <span id="acad_division_span">
                    <?php echo strtoupper($stDetailsFirst->division); ?>
                </span>
                <input style="display: none;" name="acad_division" type="text" data-date-format="yyyy-mm-dd" id="acad_division" value="<?php echo $stDetailsFirst->division; ?>" placeholder="School division" 
                       onblur="" required>
                <i id="acad_editdivisionBtn" onclick="$('#acad_division_span').hide(), $('#acad_division').show(), $('#acad_division').focus(), $('#acad_closedivisionBtn').show(), $('#acad_savedivisionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedivisionBtn" onclick="$('#editVal').val($('#acad_division').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('division', 'gs_spr', 'st_id', 1), $('#acad_division_span').show(), $('#acad_division').hide(), $('#acad_editdivisionBtn').show(), $(this).hide(), $('#acad_closedivisionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedivisionBtn" onclick="$('#acad_division_span').show(), $('#acad_division').hide(), $('#acad_editdivisionBtn').show(), $('#acad_savedivisionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Region :
            </dt>
            <dd >
                <span id="acad_region_span">
                    <?php echo strtoupper($stDetailsFirst->region); ?>
                </span>
                <input style="display: none;" name="acad_region" type="text" data-date-format="yyyy-mm-dd" id="acad_region" value="<?php echo strtoupper($stDetailsFirst->region); ?>" placeholder="Region" 
                       onblur="" required>
                <i id="acad_editregionBtn" onclick="$('#acad_region_span').hide(), $('#acad_region').show(), $('#acad_region').focus(), $('#acad_closeregionBtn').show(), $('#acad_saveregionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveregionBtn" onclick="$('#editVal').val($('#acad_region').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('region', 'gs_spr', 'st_id', 1), $('#acad_region_span').show(), $('#acad_region').hide(), $('#acad_editregionBtn').show(), $(this).hide(), $('#acad_closeregionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeregionBtn" onclick="$('#acad_region_span').show(), $('#acad_region').hide(), $('#acad_editregionBtn').show(), $('#acad_saveregionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Adviser / Teacher :
            </dt>
            <dd >
                <span id="acad_adviser_span">
                    <?php echo strtoupper($stDetailsFirst->spr_adviser); ?>
                </span>
                <input style="display: none;" name="acad_adviser" type="text" data-date-format="yyyy-mm-dd" id="acad_adviser" value="<?php echo $stDetailsFirst->spr_adviser; ?>" placeholder="Adviser / Teacher" 
                       onblur="" required>
                <i id="acad_editadviserBtn" onclick="$('#acad_adviser_span').hide(), $('#acad_adviser').show(), $('#acad_adviser').focus(), $('#acad_closeadviserBtn').show(), $('#acad_saveadviserBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveadviserBtn" onclick="$('#editVal').val($('#acad_adviser').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('spr_adviser', 'gs_spr', 'st_id',1), $('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $(this).hide(), $('#acad_closeadviserBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeadviserBtn" onclick="$('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $('#acad_saveadviserBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                School Address:
                <?php $s_firstAdd = Modules::run('sf10/getAddress', $stDetailsFirst->st_id, 2, $gsYR); ?>
            </dt>
            <dd >
                <span id="address_span"><?php echo strtoupper($s_firstAdd->street . ', ' . $s_firstAdd->barangay_id . ' ' . $s_firstAdd->mun_city . ', ' . $s_firstAdd->province . ', ' . $s_firstAdd->zip_code); ?></span>
                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                   rel="clickover"  id="addClick_one"
                   data-content="  <?php
                   $data['cities'] = Modules::run('main/getCities');
                   $data['address_id'] = $s_firstAdd->address_id;
                   $data['st_id'] = $s_firstAdd->st_id;
                   $data['street'] = $s_firstAdd->street;
                   $data['barangay'] = $s_firstAdd->barangay_id;
                   $data['city'] = $s_firstAdd->city_id;
                   $data['province'] = $s_firstAdd->province;
                   $data['pid'] = $s_firstAdd->province_id;
                   $data['zip_code'] = $s_firstAdd->zip_code;
                   $data['user_id'] = $stDetailsFirst->sprp_id;
                   $data['is_home'] = 2;
                   $data['gsYr'] = $gsYR;
                   $this->load->view('addressInfo', $data)
                   ?>
                   "></i>
            </dd>
        </dl>
        <div id="url"></div>
    </div> 
    <a href="#" onclick="$('#attendanceOveride<?php echo $stDetailsFirst->semester ?>').modal('show')" id="addAttendance<?php echo $stDetailsFirst->semester ?>">
        <i class="pull-right fa fa-clock-o  fa-2x pointer"></i>
    </a> 
    
    <a title="openRecords" href="#selectionSH"  onclick="addRecords(), $('#acadSPRId').val('<?php echo $stDetailsFirst->spr_id ?>'), $('#acadSemester').val('<?php echo $stDetailsFirst->semester ?>')" id="addRecords" data-toggle="modal" class="pull-right">
        <i onclick="checkIfAcadExist()" class="fa fa-folder-open pointer fa-2x"></i>
    </a>  &nbsp;&nbsp;
</div>


<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-5" rowspan="2">Subject</th>
        <th class="text-center" colspan="2">First Semester</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2" rowspan="2">Final Rating</th>
        <?php if ($gsYR != $this->session->school_year): ?>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Action</th>
        <?php endif; ?>
    </tr>
    <tr>
        <th class="col-lg-1 text-center">1</th>
        <th class="col-lg-1 text-center">2</th>
    </tr>

    <?php
    // print_r($acadRecords);

    $aRec1 = 0;
    $aRec2 = 0;
    $aRec3 = 0;
    $aRec4 = 0;


    $count = 0;
    foreach ($acadRecordsFirst->result() as $ar):
        
        if ($ar->subject_id != 0):
            $count++;
            ?>
            <tr>
                <td class="col-lg-5"><?php echo $ar->subject ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->first ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->second ?></td>
                <th style="text-align: center" class="col-lg-1"><?php echo $ar->avg ?></th>
                <?php if ($gsYR != $this->session->school_year): ?>
                    <td style="vertical-align: middle; text-align: center;">
                        <div class="btn-group">    
                            <button onclick="$('#editGrades').modal('show'),
                                                        $('#editSubject').html('<?php echo $ar->subject ?>'),
                                                        $('#editFirst').val('<?php echo $ar->first ?>'),
                                                        $('#editSecond').val('<?php echo $ar->second ?>'),
                                                        $('#editAverage').val('<?php echo $ar->avg ?>'),
                                                        $('#editSem').val('<?php echo $ar->sem ?>'),
                                                        $('#editARid').val('<?php echo $ar->ar_id ?>')
                                    " 

                                    class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                            </button>
                            <button onclick="$('#deleteRecord').modal('show')" onmouseover="$('#inputDeleteARID').val('<?php echo $ar->ar_id ?>'), $('#inputDeleteYear').val('<?php echo $gsYR; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                    <?php
                endif;
                $aveSub += $ar->avg;
                ?>
            </tr>
            <?php
        endif;
    endforeach;
    if($acadAverageFirst->avg!=NULL):
        $generalAveFirst = $acadAverageFirst->avg;
    else:
        $generalAveFirst = round(($aveSub/$count), 2, PHP_ROUND_HALF_UP );
    endif;
    
    ?>
    <tr>
        <th style="text-align: right">General Average</th>
        <th style="text-align: center"></th>
        <th style="text-align: center"></th>
        <th style="text-align: center"><?php echo $generalAveFirst ?></th>
    </tr>
</table>


<div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
    <div class="alert alert-success" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Attendance Record
            <i id="attendRecordsMin" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('attendRecords', 'min')"></i>
            <i id="attendRecordsMax" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('attendRecords', 'max')"></i>   
        </h4>
    </div>
    <div id="attendRecordsBody">
            <table class="table table-bordered">
                <tr>
                    <th colspan="12" class="text-center alert-danger">Number of School Days <?php echo ($for_school?'':'Present') ?>
                        <small id="confirmMsg" class="muted text-info"></i> </small></th>
                </tr>
                <tr>
                    <?php
                        for($i=6; $i<=10; $i++):
                            $m = ($i<10?'0'.$i:$i);
                            $monthName = date('F', strtotime(date('Y-'.($m>12?(($m-12)<10?'0'.($m-12):($m-12)):$m).'-01')));
                    ?>
                            <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                        endfor;
                        
                    ?>
                </tr>
                <?php
                    $attendanceFirst = Modules::run('sf10/getAttendanceOveride',$stDetailsFirst->spr_id, $stDetailsFirst->school_year);
                    if($attendanceFirst):
                ?>
                <tr>
                    <td class="text-center"><?php echo $attendanceFirst->row()->June ?></td>
                    <td class="text-center"><?php echo $attendanceFirst->row()->July ?></td>
                    <td class="text-center"><?php echo $attendanceFirst->row()->August ?></td>
                    <td class="text-center"><?php echo $attendanceFirst->row()->September ?></td>
                    <td class="text-center"><?php echo $attendanceFirst->row()->October ?></td>
                </tr>
                <?php endif; ?>
            </table>    
    </div>
</div>

<div class="well col-lg-12">
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                Grade Level:
            </dt>
            <dd >
                <span id="acad_level_span1">
                    <?php echo strtoupper(levelDesc($stDetailsSecond->grade_level_id)) ?>
                </span>
                <select style="width:225px; display: none" name="acad_level1" id="acad_level1">
                    <option>Select Grade Level</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo ($i + 1) ?>" <?php echo ($stDetailsSecond->grade_level_id == ($i + 1) ? 'selected' : '') ?>>Grade <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
<!--                <input style="display: none;" name="acad_level" type="text" data-date-format="yyyy-mm-dd" id="acad_level" value="<?php //echo $stDetailsFirst->grade_level_id;                                                 ?>" placeholder="Grade Level" 
                       onblur="" required>-->
                <i id="acad_editlevelBtn1" onclick="$('#acad_level_span1').hide(), $('#acad_level1').show(), $('#acad_level1').focus(), $('#acad_closelevelBtn1').show(), $('#acad_savelevelBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savelevelBtn1" onclick="$('#editVal').val($('#acad_level').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('grade_level_id', 'gs_spr', 'st_id', 'acad_level_span1'), $('#acad_level1').show(), $('#acad_level1').hide(), $('#acad_editlevelBtn1').show(), $('#acad_savelevelBtn1').hide(), $('#acad_closelevelBtn1').hide(), $('#acad_level_span1').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closelevelBtn1" onclick="$('#acad_level_span1').show(), $('#acad_level1').hide(), $('#acad_editlevelBtn1').show(), $('#acad_savelevelBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Section:
            </dt>
            <dd >
                <span id="acad_section_span1">
                    <?php echo strtoupper($stDetailsSecond->section) ?>
                </span>
                <input style="display: none;" name="acad_section1" type="text" data-date-format="yyyy-mm-dd" id="acad_section1" value="<?php echo $stDetailsSecond->section; ?>" placeholder="School Name" 
                       onblur="" required>
                <i id="acad_editsectionBtn1" onclick="$('#acad_section_span1').hide(), $('#acad_section1').show(), $('#acad_section1').focus(), $('#acad_closesectionBtn1').show(), $('#acad_savesectionBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savesectionBtn1" onclick="$('#editVal').val($('#acad_section1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('section', 'gs_spr', 'st_id',2), $('#acad_section1').show(), $('#acad_section1').hide(), $('#acad_editsectionBtn1').show(), $('#acad_savesectionBtn1').hide(), $('#acad_closesectionBtn1').hide(), $('#acad_section_span1').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closesectionBtn1" onclick="$('#acad_section_span1').show(), $('#acad_section1').hide(), $('#acad_editsectionBtn1').show(), $('#acad_savesectionBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <?php if ($stDetailsSecond->grade_level_id == 12 || $stDetailsSecond->grade_level_id == 13): ?>
            <?php $strand = Modules::run('sf10/getStrandCode', $stDetailsSecond->strandid); ?>
            <?php $offeredStrand = Modules::run('sf10/getSHOfferedStrand'); ?>
            <dl class="dl-horizontal">
                <dt>
                    Strand:
                </dt>
                <dd >
                    <span id="acad_strand_span1">
                        <?php echo strtoupper($strand->short_code) ?>
                    </span>
                    <select style="width:225px; display: none" name="acad_strand1" id="acad_strand1">
                        <option>Select Strand</option>
                        <?php foreach ($offeredStrand as $os): ?>
                            <option value="<?php echo $os->st_id ?>" <?php echo ($os->st_id == $strand->st_id ? 'selected' : '') ?>><?php echo $os->short_code ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i id="acad_editstrandBtn1" onclick="$('#acad_strand_span1').hide(), $('#acad_strand1').show(), $('#acad_strand1').focus(), $('#acad_closestrandBtn1').show(), $('#acad_savestrandBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="acad_savestrandBtn1" onclick="$('#editVal').val($('#acad_strand1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('strandid', 'gs_spr', 'st_id', 2), $('#acad_strand1').show(), $('#acad_strand1').hide(), $('#acad_editstrandBtn1').show(), $('#acad_savestrandBtn1').hide(), $('#acad_closestrandBtn1').hide(), $('#acad_strand_span1').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="acad_closestrandBtn1" onclick="$('#acad_strand_span1').show(), $('#acad_strand1').hide(), $('#acad_editstrandBtn1').show(), $('#acad_savestrandBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
        <?php endif; ?>
        <dl class="dl-horizontal">
            <dt>
                School Name:
            </dt>
            <dd >
                <span id="acad_school_span1">
                    <?php echo strtoupper($stDetailsSecond->school_name) ?>
                </span>
                <input type="text" name="acad_school" id="acad_school1" value="<?php echo $stDetailsSecond->school_name; ?>" placeholder="School Name" style="display: none;"
                       onblur="" required>
                <i id="acad_editschoolBtn1" onclick="$('#acad_school_span1').hide(), $('#acad_school1').show(), $('#acad_school1').focus(), $('#acad_closeschoolBtn1').show(), $('#acad_saveschoolBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschoolBtn1" onclick="$('#editVal').val($('#acad_school1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_name', 'gs_spr', 'st_id', 2), $('#acad_school_span1').show(), $('#acad_school1').hide(), $('#acad_editschoolBtn1').show(), $('#acad_saveschoolBtn1').hide(), $('#acad_closeschoolBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeschoolBtn1" onclick="$('#acad_school_span1').show(), $('#acad_school1').hide(), $('#acad_editschoolBtn1').show(), $('#acad_saveschoolBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                School ID :
            </dt>
            <dd >
                <span id="acad_schID_span1">
                    <?php echo strtoupper($stDetailsSecond->school_id) ?>
                </span>
                <input style="display: none;" name="acad_school_id" type="text" data-date-format="yyyy-mm-dd" id="acad_school_id1" value="<?php echo $stDetailsSecond->school_id; ?>" placeholder="School ID" 
                       onblur="" required>
                <i id="acad_editschIDBtn1" onclick="$('#acad_schID_span1').hide(), $('#acad_school_id1').show(), $('#acad_school_id1').focus(), $('#acad_closeschIDBtn1').show(), $('#acad_saveschIDBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschIDBtn1" onclick="$('#editVal').val($('#acad_school_id1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_id', 'gs_spr', 'st_id', 2), $('#acad_schID_span1').show(), $('#acad_school_id1').hide(), $('#acad_editschIDBtn1').show(), $('#acad_saveschIDBtn1').hide(), $('#acad_closeschIDBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeschIDBtn1" onclick="$('#acad_schID_span1').show(), $('#acad_school_id1').hide(), $('#acad_editschIDBtn1').show(), $('#acad_saveschIDBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
    </div>
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                District :
            </dt>
            <dd >
                <span id="acad_district_span1">
                    <?php echo strtoupper($stDetailsSecond->district); ?>
                </span>
                <input style="display: none;" name="acad_district" type="text" data-date-format="yyyy-mm-dd" id="acad_district1" value="<?php echo $stDetailsSecond->district; ?>" placeholder="School district" 
                       onblur="" required>
                <i id="acad_editdistrictBtn1" onclick="$('#acad_district_span1').hide(), $('#acad_district1').show(), $('#acad_district1').focus(), $('#acad_closedistrictBtn1').show(), $('#acad_savedistrictBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedistrictBtn1" onclick="$('#editVal').val($('#acad_district1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('district', 'gs_spr', 'st_id', 2), $('#acad_district_span1').show(), $('#acad_district1').hide(), $('#acad_editdistrictBtn1').show(), $(this).hide(), $('#acad_closedistrictBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedistrictBtn1" onclick="$('#acad_district_span1').show(), $('#acad_district1').hide(), $('#acad_editdistrictBtn1').show(), $('#acad_savedistrictBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Division :
            </dt>
            <dd >
                <span id="acad_division_span1">
                    <?php echo strtoupper($stDetailsSecond->division); ?>
                </span>
                <input style="display: none;" name="acad_division" type="text" data-date-format="yyyy-mm-dd" id="acad_division1" value="<?php echo $stDetailsSecond->division; ?>" placeholder="School division" 
                       onblur="" required>
                <i id="acad_editdivisionBtn1" onclick="$('#acad_division_span1').hide(), $('#acad_division1').show(), $('#acad_division1').focus(), $('#acad_closedivisionBtn1').show(), $('#acad_savedivisionBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedivisionBtn1" onclick="$('#editVal').val($('#acad_division1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('division', 'gs_spr', 'st_id', 2), $('#acad_division_span1').show(), $('#acad_division1').hide(), $('#acad_editdivisionBtn1').show(), $(this).hide(), $('#acad_closedivisionBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedivisionBtn1" onclick="$('#acad_division_span1').show(), $('#acad_division1').hide(), $('#acad_editdivisionBtn1').show(), $('#acad_savedivisionBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Region :
            </dt>
            <dd >
                <span id="acad_region_span1">
                    <?php echo strtoupper($stDetailsSecond->region); ?>
                </span>
                <input style="display: none;" name="acad_region" type="text" data-date-format="yyyy-mm-dd" id="acad_region1" value="<?php echo strtoupper($stDetailsSecond->region); ?>" placeholder="Region" 
                       onblur="" required>
                <i id="acad_editregionBtn1" onclick="$('#acad_region_span1').hide(), $('#acad_region1').show(), $('#acad_region1').focus(), $('#acad_closeregionBtn1').show(), $('#acad_saveregionBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveregionBtn1" onclick="$('#editVal').val($('#acad_region1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('region', 'gs_spr', 'st_id', 2), $('#acad_region_span1').show(), $('#acad_region1').hide(), $('#acad_editregionBtn1').show(), $(this).hide(), $('#acad_closeregionBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeregionBtn1" onclick="$('#acad_region_span1').show(), $('#acad_region1').hide(), $('#acad_editregionBtn1').show(), $('#acad_saveregionBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Adviser / Teacher :
            </dt>
            <dd >
                <span id="acad_adviser_span1">
                    <?php echo strtoupper($stDetailsSecond->spr_adviser); ?>
                </span>
                <input style="display: none;" name="acad_adviser" type="text" data-date-format="yyyy-mm-dd" id="acad_adviser1" value="<?php echo $stDetailsSecond->spr_adviser; ?>" placeholder="Adviser / Teacher" 
                       onblur="" required>
                <i id="acad_editadviserBtn1" onclick="$('#acad_adviser_span1').hide(), $('#acad_adviser1').show(), $('#acad_adviser1').focus(), $('#acad_closeadviserBtn1').show(), $('#acad_saveadviserBtn1').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveadviserBtn1" onclick="$('#editVal').val($('#acad_adviser1').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('spr_adviser', 'gs_spr', 'st_id', 2), $('#acad_adviser_span1').show(), $('#acad_adviser1').hide(), $('#acad_editadviserBtn1').show(), $(this).hide(), $('#acad_closeadviserBtn1').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeadviserBtn1" onclick="$('#acad_adviser_span1').show(), $('#acad_adviser1').hide(), $('#acad_editadviserBtn1').show(), $('#acad_saveadviserBtn1').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                School Address:
                <?php $s_secondAdd = Modules::run('sf10/getAddress', $stDetailsSecond->st_id, 3, $gsYR); 
                ?>
            </dt>
            <dd >
                <span id="address_span"><?php echo strtoupper($s_secondAdd->street . ', ' . $s_secondAdd->barangay_id . ' ' . $s_secondAdd->mun_city . ', ' . $s_secondAdd->province . ', ' . $s_secondAdd->zip_code); ?></span>
                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                   rel="clickover"  id="addClick_two"
                   data-content="  <?php
                   $data['cities'] = Modules::run('main/getCities');
                   $data['address_id'] = $s_secondAdd->address_id;
                   $data['st_id'] = $s_secondAdd->st_id;
                   $data['street'] = $s_secondAdd->street;
                   $data['barangay'] = $s_secondAdd->barangay_id;
                   $data['city'] = $s_secondAdd->city_id;
                   $data['province'] = $s_secondAdd->province;
                   $data['pid'] = $s_secondAdd->province_id;
                   $data['zip_code'] = $s_secondAdd->zip_code;
                   $data['user_id'] = $stDetailsSecond->sprp_id;
                   $data['is_home'] = 3;
                   $data['gsYr'] = $gsYR;
                   $this->load->view('addressInfo', $data)
                   ?>
                   "></i>
            </dd>
        </dl>
        <div id="url"></div>
    </div>  
    
    <a href="#" onclick="$('#attendanceOveride<?php echo $stDetailsSecond->semester ?>').modal('show')" id="addAttendance<?php echo $stDetailsSecond->semester ?>">
        <i class="pull-right fa fa-clock-o  fa-2x pointer"></i>
    </a> 
    <a title="openRecords" href="#selectionSH" onclick="addRecords(), $('#acadSPRId').val('<?php echo $stDetailsSecond->spr_id ?>'), $('#acadSemester').val('<?php echo $stDetailsSecond->semester ?>')" id="addRecords" data-toggle="modal" class="pull-right">
        <i onclick="checkIfAcadExist()" class="fa fa-folder-open pointer fa-2x"></i>
    </a> &nbsp;&nbsp;
</div>

<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-5" rowspan="2">Subject</th>
        <th class="text-center" colspan="2">Second Semester</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2" rowspan="2">Final Rating</th>
        <?php if ($gsYR != $this->session->school_year): ?>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Action</th>
        <?php endif; ?>
    </tr>
    <tr>
        <th class="col-lg-1 text-center">1</th>
        <th class="col-lg-1 text-center">2</th>
    </tr>

    <?php
    $aRec1 = 0;
    $aRec2 = 0;
    $aRec3 = 0;
    $aRec4 = 0;


    $count2 = 0;
    foreach ($acadRecordsSecond->result() as $ar):
        $count2++;

        if ($ar->subject_id != 0):
            ?>
            <tr>
                <td class="col-lg-5"><?php echo $ar->subject ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->third ?></td>
                <td class="col-lg-2" style="text-align: center;"><?php echo $ar->fourth ?></td>
                <th style="text-align: center" class="col-lg-1"><?php echo $ar->avg ?></th>
                <?php if ($gsYR != $this->session->school_year): ?>
                    <td style="vertical-align: middle; text-align: center;">
                        <div class="btn-group">    
                            <button onclick="$('#editGrades').modal('show'),
                                                        $('#editSubject').html('<?php echo $ar->subject ?>'),
                                                        $('#editFirst').val('<?php echo $ar->third ?>'),
                                                        $('#editSecond').val('<?php echo $ar->fourth ?>'),
                                                        $('#editAverage').val('<?php echo $ar->avg ?>'),
                                                        $('#editSem').val('<?php echo $ar->sem ?>'),
                                                        $('#editARid').val('<?php echo $ar->ar_id ?>')
                                    " 

                                    class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                            </button>
                            <button onclick="$('#deleteRecord').modal('show')" onmouseover="$('#inputDeleteARID').val('<?php echo $ar->ar_id ?>'), $('#inputDeleteYear').val('<?php echo $gsYR; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                <?php
                endif;
                $aveSub2 += $ar->avg;
                ?>
            </tr>
            <?php
        endif;
    endforeach;
    if($acadAverageSecond->avg!=NULL):
        $generalAveSecond = $acadAverageSecond->avg;
    else:
        $generalAveSecond = round(($aveSub2/$count2), 2, PHP_ROUND_HALF_UP );
    endif;
    ?>
    <tr>
        <th style="text-align: right">General Average</th>
        <th style="text-align: center"></th>
        <th style="text-align: center"></th>
        <th style="text-align: center"><?php echo $generalAveSecond ?></th>
</table>

<div style="margin: 50px auto 0;" class="modal col-lg-3" id="deleteRecord" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="deleteNewBody" class="alert alert-danger clearfix text-center" style="margin-bottom: 0; padding: 3px;">
        Are you sure you want to Delete this Record ? Please note that you cannot undo the process. Continue ?<br />
        <button class="btn btn-success btn-sm" onclick="deleteRecord()">YES</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">NO</button>
        <input type="hidden" id="inputDeleteARID" />
        <input type="hidden" id="inputDeleteYear" />
    </div>
</div>

<div id="editGrades"  style="margin: 50px auto 0;" class="modal fade col-lg-4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="panel panel-green" style="min-height: 100px; overflow-y: auto;">
        <div class="panel-heading">
            <h5>Edit Subject : <span id="editSubject"></span></h5>
        </div>
        <div class="panel-body">
            <div class="col-lg-4">
                <label>First</label>
                <input type="text" class="form-control text-center" id="editFirst" value="" required/>
            </div>
            <div class="col-lg-4">
                <label>Second</label>
                <input type="text" class="form-control text-center" id="editSecond" value="" required/>
            </div>
            <div class="col-lg-4">
                <label>Average</label>
                <input type="text" class="form-control text-center" id="editAverage" value="" required/>
            </div>   
        </div>
        <input type="hidden" id="editARid" />
        <input type="hidden" id="editSem" />
        <div class="panel-footer clearfix">
            <div class="pull-right">
                <button onclick="editAcademicRecordsSH()" type="button" class="btn btn-warning btn-xs"><i class="fa fa-save fa-fw"></i> Update</button>
                <button data-dismiss="modal" type="button" class="btn btn-danger btn-xs"><i class="fa fa-close fa-fw"></i> close</button>
            </div> 
        </div>

    </div>
</div>

<div class="col-lg-12 no-padding">
    <div class="alert alert-success" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Attendance Record
            <i id="attendRecordsMin" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('attendRecords', 'min')"></i>
            <i id="attendRecordsMax" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('attendRecords', 'max')"></i>   
        </h4>
    </div>
    <div id="attendRecordsBody">

            <table class="table table-bordered">
                <tr>
                    <th colspan="12" class="text-center alert-danger">Number of School Days <?php echo ($for_school?'':'Present') ?>
                        <small id="confirmMsg" class="muted text-info"></i> </small></th>
                </tr>
                <tr>
                    <?php
                        for($i=11; $i<=15; $i++):
                            $m = ($i<10?'0'.$i:$i);
                            $monthName = date('F', strtotime(date('Y-'.($m>12?(($m-12)<10?'0'.($m-12):($m-12)):$m).'-01')));
                    ?>
                            <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                        endfor;
                    
                    ?>
                </tr>
                <?php
                $attendanceSecond = Modules::run('sf10/getAttendanceOveride',$stDetailsSecond->spr_id, $stDetailsSecond->school_year);
                if($attendanceSecond):
                ?>
                <tr>
                    <td class="text-center"><?php echo $attendanceSecond->row()->November ?></td>
                    <td class="text-center"><?php echo $attendanceSecond->row()->December ?></td>
                    <td class="text-center"><?php echo $attendanceSecond->row()->January ?></td>
                    <td class="text-center"><?php echo $attendanceSecond->row()->February ?></td>
                    <td class="text-center"><?php echo $attendanceSecond->row()->March ?></td>
                </tr>
                <?php endif; ?>
            </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'right',
            html: true
        });
    });
</script>