<?php
$sprid = Modules::run('f137/getSPRrec', base64_decode($user_id), $school_year, segment_5, $grade_id);
$acadRec = Modules::run('f137/getSPRFinalGrade', $sprid->spr_id, $school_year);
$spr_rec = Modules::run('f137/getSPRrec', base64_decode($user_id), $school_year, segment_5, $grade_id);
$sch_add = Modules::run('f137/getSchoolAddress', $spr_rec->school_add_id, $school_year);
$isTbl = Modules::run('f137/checkTableExist', 'esk_gs_final_card', $school_year);
?>
<div class="col-md-12">
    <table class="table table-bordered">
        <tr>
            <th style="text-align: center">Grade <?php echo ($grade_id - 1) ?>
                <div id="arec<?php echo $grade_id ?>" class="h-25 d-inline-block pull-right" style="height: 10px" hidden=""><img style="width: 15px; height: 15px" src="<?php // echo base_url() . 'images/icons/loading.gif' ?>" /> Please wait...</div>
                <?php
                if ($isTbl):
                    $isAdmitted = Modules::run('f137/checkAdmission', base64_decode($user_id), $school_year);
                    if ($isAdmitted):
                        ?>
                        <a class="btn btn-xs btn-primary pull-right" id="btn<?php echo $grade_id ?>" onclick="fetchRec('<?php echo $grade_id ?>', '<?php echo $school_year ?>', '#arec<?php echo $grade_id ?>', '#arecMsg<?php echo $grade_id ?>', '#addRec<?php echo $grade_id ?>', '#' + this.id, $(this).hide(), $('#sySelected').val('<?php echo $school_year ?>'), $('#dbExist').val('<?php echo $dbExist ?>'))">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                    <?php else: ?>
                        <a class="btn btn-xs btn-primary pull-right" id="imp<?php echo $grade_id ?>" onclick="$('#importCsv').modal('show'), $('#selectSY').val('<?php echo $school_year ?>'), $('#student_id').val($('#st_id').val()), $('#st_sprid').val('<?php echo $sprid->spr_id ?>'), $('#sLevel').val('<?php echo $grade_id ?>')">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                    <?php endif;
                    ?>
                <?php else: ?>
                    <a class="btn btn-xs btn-primary pull-right" id="imp<?php echo $grade_id ?>" onclick="$('#importCsv').modal('show'), $('#selectSY').val('<?php echo $school_year ?>'), $('#student_id').val($('#st_id').val()), $('#st_sprid').val('<?php echo $sprid->spr_id ?>'), $('#sLevel').val('<?php echo $grade_id ?>')">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                <?php endif; ?>
            </th>
        </tr>
        <tbody>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="text-align: center" colspan="<?php echo ($acadRec ? 5 : 0) ?>">First Semester</th>
                                </tr>
                                <tbody>
                                    <?php if ($acadRec): ?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="well col-lg-12">
                                                    <dl class="dl-horizontal">
                                                        <dt>Grade Level:&nbsp;</dt>
                                                        <span id="span_grade">Grade <?php echo ($grade_id - 1) ?></span>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Section:&nbsp;</dt>
                                                        <span id="span_section<?php echo $grade_id ?>"><?php echo $spr_rec->section ?></span>
                                                        <input style="display: none;" name="input_sec" type="text" id="input_sec<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->section ?>" onblur="" required>
                                                        <i id="editSecBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_sec<?php echo $grade_id ?>').val(), 'section', 'gs_spr', <?php echo $school_year ?>, 'spr_id', <?php echo $sprid->spr_id ?>, 'spr_id', $('#st_id').val())"></i>
                                                        <i id="closeSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>School ID:&nbsp;</dt>
                                                        <span id="span_schID<?php echo $grade_id ?>"><?php echo $spr_rec->sch_id ?></span>
                                                        <input style="display: none;" name="input_schID" type="text" id="input_schID<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->sch_id ?>" onblur="" required>
                                                        <i id="editSchIDBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schID<?php echo $grade_id ?>').val(), 'school_id', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>School Name:&nbsp;</dt>
                                                        <span id="span_schName<?php echo $grade_id ?>"><?php echo $spr_rec->school_name ?></span>
                                                        <input style="display: none;" name="input_schName" type="text" id="input_schName<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->school_name ?>" onblur="" required>
                                                        <i id="editSchNameBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schName<?php echo $grade_id ?>').val(), 'school_name', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>District :&nbsp;</dt>
                                                        <span id="span_district<?php echo $grade_id ?>"><?php echo $spr_rec->district ?></span>
                                                        <input style="display: none;" name="input_district" type="text" id="input_district<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->district ?>" onblur="" required>
                                                        <i id="editDistBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_district<?php echo $grade_id ?>').val(), 'district', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Division :&nbsp;</dt>
                                                        <span id="span_division<?php echo $grade_id ?>"><?php echo $spr_rec->division ?></span>
                                                        <input style="display: none;" name="input_division" type="text" id="input_division<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->division ?>" onblur="" required>
                                                        <i id="editDivBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_division<?php echo $grade_id ?>').val(), 'division', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Region :&nbsp;</dt>
                                                        <span id="span_region<?php echo $grade_id ?>"><?php echo $spr_rec->region ?></span>
                                                        <input style="display: none;" name="input_region" type="text" id="input_region<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->region ?>" onblur="" required>
                                                        <i id="editRegBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_region<?php echo $grade_id ?>').val(), 'region', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Adviser / Teacher :&nbsp;</dt>
                                                        <span id="span_adv<?php echo $grade_id ?>"></span>
                                                        <input style="display: none;" name="input_adv" type="text" id="input_adv<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="Adviser / Teacher" onblur="" required>
                                                        <i id="editAdvBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                                        <i id="closeAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    </dl>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td style="text-align: center">1st</td>
                                            <td style="text-align: center">2nd</td>
                                            <td style="text-align: center">Final</td>
                                            <td style="text-align: center">Remarks</td>
                                        </tr>
                                        <?php
                                        foreach ($acadRec as $ar):
                                            if ($ar->sem == 1):
                                                $subj = Modules::run('sf10/getSubjectDesc', $ar->subject_id);
                                                ?>
                                                <tr>
                                                    <td><?php echo $subj->subject ?></td>
                                                    <td style="text-align: center"><?php echo $ar->first ?></td>
                                                    <td style="text-align: center"><?php echo $ar->second ?></td>
                                                    <?php $subjFinal = round(($ar->first + $ar->second) / 2) ?>
                                                    <td style="text-align: center"><?php echo ($ar->second != '' ? $subjFinal : '') ?></td>
                                                    <td style="text-align: center"><?php echo ($ar->second != '' ? ($subjFinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                                                </tr>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <?php else: ?>
                                        <tr id="emptyRec<?php echo $grade_id ?>">
                                            <td>
                                                <h5 style="color: red; text-align: center" id="arecMsg<?php echo $grade_id ?>">No Records Found!!!</h5><br>
                                                <div class="col-lg-12" hidden="" id="addRec<?php echo $grade_id ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="text-align: center" colspan="<?php echo ($acadRec ? 5 : 0) ?>">Second Semester</th>
                                </tr>
                                <tbody>
                                    <?php if ($acadRec): ?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="well col-lg-12">
                                                    <dl class="dl-horizontal">
                                                        <dt>Grade Level:&nbsp;</dt>
                                                        <span id="span_grade">Grade <?php echo ($grade_id - 1) ?></span>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Section:&nbsp;</dt>
                                                        <span id="span_section<?php echo $grade_id ?>"><?php echo $spr_rec->section ?></span>
                                                        <input style="display: none;" name="input_sec" type="text" id="input_sec<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->section ?>" onblur="" required>
                                                        <i id="editSecBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_sec<?php echo $grade_id ?>').val(), 'section', 'gs_spr', <?php echo $school_year ?>, 'spr_id', <?php echo $sprid->spr_id ?>, 'spr_id', $('#st_id').val())"></i>
                                                        <i id="closeSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>School ID:&nbsp;</dt>
                                                        <span id="span_schID<?php echo $grade_id ?>"><?php echo $spr_rec->sch_id ?></span>
                                                        <input style="display: none;" name="input_schID" type="text" id="input_schID<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->sch_id ?>" onblur="" required>
                                                        <i id="editSchIDBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schID<?php echo $grade_id ?>').val(), 'school_id', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>School Name:&nbsp;</dt>
                                                        <span id="span_schName<?php echo $grade_id ?>"><?php echo $spr_rec->school_name ?></span>
                                                        <input style="display: none;" name="input_schName" type="text" id="input_schName<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->school_name ?>" onblur="" required>
                                                        <i id="editSchNameBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schName<?php echo $grade_id ?>').val(), 'school_name', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>District :&nbsp;</dt>
                                                        <span id="span_district<?php echo $grade_id ?>"><?php echo $spr_rec->district ?></span>
                                                        <input style="display: none;" name="input_district" type="text" id="input_district<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->district ?>" onblur="" required>
                                                        <i id="editDistBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_district<?php echo $grade_id ?>').val(), 'district', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Division :&nbsp;</dt>
                                                        <span id="span_division<?php echo $grade_id ?>"><?php echo $spr_rec->division ?></span>
                                                        <input style="display: none;" name="input_division" type="text" id="input_division<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->division ?>" onblur="" required>
                                                        <i id="editDivBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_division<?php echo $grade_id ?>').val(), 'division', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Region :&nbsp;</dt>
                                                        <span id="span_region<?php echo $grade_id ?>"><?php echo $spr_rec->region ?></span>
                                                        <input style="display: none;" name="input_region" type="text" id="input_region<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->region ?>" onblur="" required>
                                                        <i id="editRegBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_region<?php echo $grade_id ?>').val(), 'region', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                                        <i id="closeRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt>Adviser / Teacher :&nbsp;</dt>
                                                        <span id="span_adv<?php echo $grade_id ?>"></span>
                                                        <input style="display: none;" name="input_adv" type="text" id="input_adv<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="Adviser / Teacher" onblur="" required>
                                                        <i id="editAdvBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '1')"></i>
                                                        <i id="saveAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                                        <i id="closeAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                                    </dl>
                                                    </dl>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td style="text-align: center">1st</td>
                                            <td style="text-align: center">2nd</td>
                                            <td style="text-align: center">Final</td>
                                            <td style="text-align: center">Remarks</td>
                                        </tr>
                                        <?php
                                        foreach ($acadRec as $ar):
                                            if ($ar->sem == 2):
                                                $subj = Modules::run('sf10/getSubjectDesc', $ar->subject_id);
                                                ?>
                                                <tr>
                                                    <td><?php echo $subj->subject ?></td>
                                                    <td style="text-align: center"><?php echo $ar->third ?></td>
                                                    <td style="text-align: center"><?php echo $ar->fourth ?></td>
                                                    <?php $subjFinal = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4) ?>
                                                    <td style="text-align: center"><?php echo ($ar->fourth != '' ? $subjFinal : '') ?></td>
                                                    <td style="text-align: center"><?php echo ($ar->fourth != '' ? ($subjFinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                                                </tr>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <?php else: ?>
                                        <tr id="emptyRec<?php echo $grade_id ?>">
                                            <td>
                                                <h5 style="color: red; text-align: center" id="arecMsg<?php echo $grade_id ?>">No Records Found!!!</h5><br>
                                                <div class="col-lg-12" hidden="" id="addRec<?php echo $grade_id ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>