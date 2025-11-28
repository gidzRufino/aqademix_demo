<?php
function levelDesc($gradeID) {
    switch ($gradeID):
        case 1:
            return 'Kinder';
        case 2:
            return 'Grade 1';
        case 3:
            return 'Grade 2';
        case 4:
            return 'Grade 3';
        case 5:
            return 'Grade 4';
        case 6:
            return 'Grade 5';
        case 7:
            return 'Grade 6';
        case 8:
            return 'Grade 7';
        case 9:
            return 'Grade 8';
        case 10:
            return 'Grade 9';
        case 11:
            return 'Grade 10';
    endswitch;
}
?>
<div class="well col-lg-12">
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                Grade Level:
            </dt>
            <dd >
                <span id="acad_level_span">
                    <?php echo strtoupper(levelDesc($stDetails->grade_level_id)) ?>
                </span>
                <select style="width:225px; display: none" name="acad_level" id="acad_level">
                    <option>Select Grade Level</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo ($i + 1) ?>" <?php echo ($stDetails->grade_level_id == ($i + 1) ? 'selected' : '') ?>>Grade <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
<!--                <input style="display: none;" name="acad_level" type="text" data-date-format="yyyy-mm-dd" id="acad_level" value="<?php //echo $stDetails->grade_level_id;                                                 ?>" placeholder="Grade Level" 
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
                    <?php echo strtoupper($stDetails->section) ?>
                </span>
                <input style="display: none;" name="acad_section" type="text" data-date-format="yyyy-mm-dd" id="acad_section" value="<?php echo $stDetails->section; ?>" placeholder="School Name" 
                       onblur="" required>
                <i id="acad_editsectionBtn" onclick="$('#acad_section_span').hide(), $('#acad_section').show(), $('#acad_section').focus(), $('#acad_closesectionBtn').show(), $('#acad_savesectionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savesectionBtn" onclick="$('#editVal').val($('#acad_section').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('section', 'gs_spr', 'st_id'), $('#acad_section').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $('#acad_closesectionBtn').hide(), $('#acad_section_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closesectionBtn" onclick="$('#acad_section_span').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <?php if ($stDetails->grade_level_id == 12 || $stDetails->grade_level_id == 13): ?>
            <?php $strand = Modules::run('sf10/getStrandCode', $stDetails->strandid); ?>
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
                    <i id="acad_savestrandBtn" onclick="$('#editVal').val($('#acad_strand').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('strandid', 'gs_spr', 'st_id'), $('#acad_strand').show(), $('#acad_strand').hide(), $('#acad_editstrandBtn').show(), $('#acad_savestrandBtn').hide(), $('#acad_closestrandBtn').hide(), $('#acad_strand_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <?php echo strtoupper($stDetails->school_name) ?>
                </span>
                <input type="text" name="acad_school" id="acad_school" value="<?php echo $stDetails->school_name; ?>" placeholder="School Name" style="display: none;"
                       onblur="" required>
                <i id="acad_editschoolBtn" onclick="$('#acad_school_span').hide(), $('#acad_school').show(), $('#acad_school').focus(), $('#acad_closeschoolBtn').show(), $('#acad_saveschoolBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschoolBtn" onclick="$('#editVal').val($('#acad_school').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_name', 'gs_spr', 'st_id'), $('#acad_school_span').show(), $('#acad_school').hide(), $('#acad_editschoolBtn').show(), $('#acad_saveschoolBtn').hide(), $('#acad_closeschoolBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeschoolBtn" onclick="$('#acad_school_span').show(), $('#acad_school').hide(), $('#acad_editschoolBtn').show(), $('#acad_saveschoolBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                School ID :
            </dt>
            <dd >
                <span id="acad_schID_span">
                    <?php echo strtoupper($stDetails->school_id) ?>
                </span>
                <input style="display: none;" name="acad_school_id" type="text" data-date-format="yyyy-mm-dd" id="acad_school_id" value="<?php echo $stDetails->school_id; ?>" placeholder="School ID" 
                       onblur="" required>
                <i id="acad_editschIDBtn" onclick="$('#acad_schID_span').hide(), $('#acad_school_id').show(), $('#acad_school_id').focus(), $('#acad_closeschIDBtn').show(), $('#acad_saveschIDBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveschIDBtn" onclick="$('#editVal').val($('#acad_school_id').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('school_id', 'gs_spr', 'st_id'), $('#acad_schID_span').show(), $('#acad_school_id').hide(), $('#acad_editschIDBtn').show(), $('#acad_saveschIDBtn').hide(), $('#acad_closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <?php echo strtoupper($stDetails->district); ?>
                </span>
                <input style="display: none;" name="acad_district" type="text" data-date-format="yyyy-mm-dd" id="acad_district" value="<?php echo $stDetails->district; ?>" placeholder="School district" 
                       onblur="" required>
                <i id="acad_editdistrictBtn" onclick="$('#acad_district_span').hide(), $('#acad_district').show(), $('#acad_district').focus(), $('#acad_closedistrictBtn').show(), $('#acad_savedistrictBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedistrictBtn" onclick="$('#editVal').val($('#acad_district').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('district', 'gs_spr', 'st_id'), $('#acad_district_span').show(), $('#acad_district').hide(), $('#acad_editdistrictBtn').show(), $(this).hide(), $('#acad_closedistrictBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedistrictBtn" onclick="$('#acad_district_span').show(), $('#acad_district').hide(), $('#acad_editdistrictBtn').show(), $('#acad_savedistrictBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Division :
            </dt>
            <dd >
                <span id="acad_division_span">
                    <?php echo strtoupper($stDetails->division); ?>
                </span>
                <input style="display: none;" name="acad_division" type="text" data-date-format="yyyy-mm-dd" id="acad_division" value="<?php echo $stDetails->division; ?>" placeholder="School division" 
                       onblur="" required>
                <i id="acad_editdivisionBtn" onclick="$('#acad_division_span').hide(), $('#acad_division').show(), $('#acad_division').focus(), $('#acad_closedivisionBtn').show(), $('#acad_savedivisionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savedivisionBtn" onclick="$('#editVal').val($('#acad_division').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('division', 'gs_spr', 'st_id'), $('#acad_division_span').show(), $('#acad_division').hide(), $('#acad_editdivisionBtn').show(), $(this).hide(), $('#acad_closedivisionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closedivisionBtn" onclick="$('#acad_division_span').show(), $('#acad_division').hide(), $('#acad_editdivisionBtn').show(), $('#acad_savedivisionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Region :
            </dt>
            <dd >
                <span id="acad_region_span">
                    <?php echo strtoupper($stDetails->region); ?>
                </span>
                <input style="display: none;" name="acad_region" type="text" data-date-format="yyyy-mm-dd" id="acad_region" value="<?php echo strtoupper($stDetails->region); ?>" placeholder="Region" 
                       onblur="" required>
                <i id="acad_editregionBtn" onclick="$('#acad_region_span').hide(), $('#acad_region').show(), $('#acad_region').focus(), $('#acad_closeregionBtn').show(), $('#acad_saveregionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveregionBtn" onclick="$('#editVal').val($('#acad_region').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('region', 'gs_spr', 'st_id'), $('#acad_region_span').show(), $('#acad_region').hide(), $('#acad_editregionBtn').show(), $(this).hide(), $('#acad_closeregionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeregionBtn" onclick="$('#acad_region_span').show(), $('#acad_region').hide(), $('#acad_editregionBtn').show(), $('#acad_saveregionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Adviser / Teacher :
            </dt>
            <dd >
                <span id="acad_adviser_span">
                    <?php echo strtoupper($stDetails->spr_adviser); ?>
                </span>
                <input style="display: none;" name="acad_adviser" type="text" data-date-format="yyyy-mm-dd" id="acad_adviser" value="<?php echo $stDetails->spr_adviser; ?>" placeholder="Adviser / Teacher" 
                       onblur="" required>
                <i id="acad_editadviserBtn" onclick="$('#acad_adviser_span').hide(), $('#acad_adviser').show(), $('#acad_adviser').focus(), $('#acad_closeadviserBtn').show(), $('#acad_saveadviserBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveadviserBtn" onclick="$('#editVal').val($('#acad_adviser').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('spr_adviser', 'gs_spr', 'st_id'), $('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $(this).hide(), $('#acad_closeadviserBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeadviserBtn" onclick="$('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $('#acad_saveadviserBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <?php 
        $s_firstAdd = Modules::run('sf10/getAddress', $stDetails->st_id, 2, $gsYR); ?>
        <dl class="dl-horizontal">
            <dt>
                School Address:
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
                   $data['user_id'] = $stDetails->sprp_id;
                   $data['is_home'] = 2;
                   $data['gsYr'] = $gsYR;
                   $this->load->view('addressInfo', $data);
                   
                   ?>
                   "></i>
            </dd>
        </dl>
        <div id="url"></div>
    </div> 
    <a href="#" onclick="$('#attendanceOveride<?php echo $stDetails->semester ?>').modal('show')" id="addAttendance<?php echo $stDetails->semester ?>">
        <i class="pull-right fa fa-clock-o  fa-2x pointer"></i>
    </a> 
    
    <a title="openRecords" href="#selection"  onclick="addRecords(), $('#acadSPRId').val('<?php echo $stDetails->spr_id ?>'), $('#acadSemester').val('<?php echo $stDetails->semester ?>')" id="addRecords" data-toggle="modal" class="pull-right">
        <i onclick="checkIfAcadExist()" class="fa fa-folder-open pointer fa-2x"></i>
    </a>  &nbsp;&nbsp;
</div>

<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-5">Subject</th>
        <th class="text-center">1</th>
        <th class="text-center">2</th>
        <th class="text-center">3</th>
        <th class="text-center">4</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2">Final Rating</th>
        <?php if ($gsYR != $this->session->school_year): ?>
            <th style="vertical-align: middle; text-align: center;">Action</th>
        <?php endif; ?>
    </tr>

    <?php
    // print_r($acadRecords);

    $aRec1 = 0;
    $aRec2 = 0;
    $aRec3 = 0;
    $aRec4 = 0;


    $count = 0;
    foreach ($acadRecords->result() as $ar):
        
        if ($ar->subject_id != 0):
            $count++;
            ?>
            <tr>
                <td class="col-lg-5"><?php echo $ar->subject ?></td>
                <td class="col-lg-1" style="text-align: center;"><?php echo $ar->first ?></td>
                <td class="col-lg-1" style="text-align: center;"><?php echo $ar->second ?></td>
                <td class="col-lg-1" style="text-align: center;"><?php echo $ar->third ?></td>
                <td class="col-lg-1" style="text-align: center;"><?php echo $ar->fourth ?></td>
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

<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'right',
            html: true
        });
    });
</script>