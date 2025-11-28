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
            <th style="text-align: center" colspan="<?php echo ($acadRec ? 7 : 0) ?>">Grade <?php echo ($grade_id - 1) ?>
                <div id="arec<?php echo $grade_id ?>" class="h-25 d-inline-block pull-right" style="height: 10px" hidden=""><img style="width: 15px; height: 15px" src="<?php // echo base_url() . 'images/icons/loading.gif' ?>" /> Please wait...</div>
                <?php
                if ($acadRec):
                    ?>
                    <a class="btn btn-xs btn-danger pull-right" id="delBtn" onclick="$('#deleteOpt').modal('show'), $('#sySelected').val('<?php echo $school_year ?>'), $('#selectedSprid').val('<?php echo $sprid->spr_id ?>')">Delete record&nbsp;<i class="fa fa-trash fa-sm"></i></a>
                    <?php
                endif;
                if ($isTbl):
                    $isAdmitted = Modules::run('f137/checkAdmission', base64_decode($user_id), $school_year);
                    if ($isAdmitted):
                        ?>
                        <a class="btn btn-xs btn-primary pull-right" id="btn<?php echo $grade_id ?>" onclick="fetchRec('<?php echo $grade_id ?>', '<?php echo $school_year ?>', '#arec<?php echo $grade_id ?>', '#arecMsg<?php echo $grade_id ?>', '#addRec<?php echo $grade_id ?>', '#' + this.id, $(this).hide(), $('#delBtn').hide(), $('#sySelected').val('<?php echo $school_year ?>'), $('#dbExist').val('<?php echo $dbExist ?>'))">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                    <?php else: ?>
                        <a class="btn btn-xs btn-primary pull-right" id="imp<?php echo $grade_id ?>" onclick="$('#importCsv').modal('show'), $('#selectSY').val('<?php echo $school_year ?>'), $('#student_id').val($('#st_id').val()), $('#st_sprid').val('<?php echo $sprid->spr_id ?>'), $('#sLevel').val('<?php echo $grade_id ?>'), $('#delBtn').hide()">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                    <?php endif;
                    ?>
                <?php else: ?>
                    <a class="btn btn-xs btn-primary pull-right" id="imp<?php echo $grade_id ?>" onclick="$('#importCsv').modal('show'), $('#selectSY').val('<?php echo $school_year ?>'), $('#student_id').val($('#st_id').val()), $('#st_sprid').val('<?php echo $sprid->spr_id ?>'), $('#sLevel').val('<?php echo $grade_id ?>'), $('#delBtn').hide()">Fetch  / Import File <i class="fa fa-folder-open fa-sm pointer"></i></a>
                <?php endif; ?>
            </th>
        </tr>
        <tbody>
            <?php if ($acadRec): ?>
                <tr>
                    <td colspan="7">
                        <div class="well col-lg-12">
                            <div class="col-md-7">
                                <label>Grade Level:</label>
                                <span id="span_grade">Grade <?php echo ($grade_id - 1) ?></span>
                                <br>

                                <label>Section:&nbsp;</label>
                                <span id="span_section<?php echo $grade_id ?>"><?php echo $spr_rec->section ?></span>
                                <input style="display: none;" name="input_sec" type="text" id="input_sec<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->section ?>" onblur="" required>
                                <i id="editSecBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_sec<?php echo $grade_id ?>').val(), 'section', 'gs_spr', <?php echo $school_year ?>, 'spr_id', <?php echo $sprid->spr_id ?>, 'spr_id', $('#st_id').val())"></i>
                                <i id="closeSecBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_section', 'editSecBtn', 'saveSecBtn', 'input_sec', 'closeSecBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>School ID:&nbsp;</label>
                                <span id="span_schID<?php echo $grade_id ?>"><?php echo $spr_rec->sch_id ?></span>
                                <input style="display: none;" name="input_schID" type="text" id="input_schID<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->sch_id ?>" onblur="" required>
                                <i id="editSchIDBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schID<?php echo $grade_id ?>').val(), 'school_id', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                <i id="closeSchIDBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schID', 'editSchIDBtn', 'saveSchIDBtn', 'input_schID', 'closeSchIDBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>School Name:&nbsp;</label>
                                <span id="span_schName<?php echo $grade_id ?>"><?php echo $spr_rec->school_name ?></span>
                                <input style="display: none;" name="input_schName" type="text" id="input_schName<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->school_name ?>" onblur="" required>
                                <i id="editSchNameBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_schName<?php echo $grade_id ?>').val(), 'school_name', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                <i id="closeSchNameBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_schName', 'editSchNameBtn', 'saveSchNameBtn', 'input_schName', 'closeSchNameBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>District :&nbsp;</label>
                                <span id="span_district<?php echo $grade_id ?>"><?php echo $spr_rec->district ?></span>
                                <input style="display: none;" name="input_district" type="text" id="input_district<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->district ?>" onblur="" required>
                                <i id="editDistBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_district<?php echo $grade_id ?>').val(), 'district', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                <i id="closeDistBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_district', 'editDistBtn', 'saveDistBtn', 'input_district', 'closeDistBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Division :&nbsp;</label>
                                <span id="span_division<?php echo $grade_id ?>"><?php echo $spr_rec->division ?></span>
                                <input style="display: none;" name="input_division" type="text" id="input_division<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->division ?>" onblur="" required>
                                <i id="editDivBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_division<?php echo $grade_id ?>').val(), 'division', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                <i id="closeDivBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_division', 'editDivBtn', 'saveDivBtn', 'input_division', 'closeDivBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Region :&nbsp;</label>
                                <span id="span_region<?php echo $grade_id ?>"><?php echo $spr_rec->region ?></span>
                                <input style="display: none;" name="input_region" type="text" id="input_region<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="<?php echo $spr_rec->region ?>" onblur="" required>
                                <i id="editRegBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2'), editSchoolInfo($('#input_region<?php echo $grade_id ?>').val(), 'region', 'gs_spr_school', <?php echo $school_year ?>, 'esk_gs_spr_school_code', <?php echo ($spr_rec->esk_gs_spr_school_code != '' ? $spr_rec->esk_gs_spr_school_code : 0) ?>, 'spr_school_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)"></i>
                                <i id="closeRegBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_region', 'editRegBtn', 'saveRegBtn', 'input_region', 'closeRegBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Adviser / Teacher :&nbsp;</label>
                                <span id="span_adv<?php echo $grade_id ?>"></span>
                                <input style="display: none;" name="input_adv" type="text" id="input_adv<?php echo $grade_id ?>" value="<?php echo $stDetails->section; ?>" placeholder="Adviser / Teacher" onblur="" required>
                                <i id="editAdvBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="saveAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-save pointer" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                <i id="closeAdvBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_adv', 'editAdvBtn', 'saveAdvBtn', 'input_adv', 'closeAdvBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>
                            </div>
                            <div class="col-md-5">
                                <h4 style="text-align: center">Observed Values</h4>
                                <hr>
                                <label>Maka-Dios: &nbsp;</label>
                                <span id="span_md<?php echo $grade_id ?>"><?php echo Modules::run('f137/observeValues', $spr_rec->maka_dios) ?></span>
                                <select style="display: none;" name="input_md" id="input_md<?php echo $grade_id ?>" onchange="editSchoolInfo($(this).val(), 'maka_dios', 'gs_spr_ov', <?php echo $school_year ?>, 'esk_gs_spr_ov_code', <?php echo ($spr_rec->esk_gs_spr_ov_code != '' ? $spr_rec->esk_gs_spr_ov_code : 0) ?>, 'ov_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)">
                                    <option <?php echo ($spr_rec->maka_dios == 0 ? 'selected' : '') ?> disabled="">Select Option</option>
                                    <option value="1" <?php echo ($spr_rec->maka_dios == 1 ? 'selected' : '') ?> onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '2')">Always Observed</option>
                                    <option value="2" <?php echo ($spr_rec->maka_dios == 2 ? 'selected' : '') ?> onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '2')">Rarely Observed</option>
                                    <option value="3" <?php echo ($spr_rec->maka_dios == 3 ? 'selected' : '') ?> onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '2')">Sometimes Observed</option>
                                    <option value="4" <?php echo ($spr_rec->maka_dios == 4 ? 'selected' : '') ?> onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '2')">Not Observed</option>
                                </select>
                                <i id="editmdBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="closemdBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_md', 'editmdBtn', 'savemdBtn', 'input_md', 'closemdBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Makatao: &nbsp;</label>
                                <span id="span_mt<?php echo $grade_id ?>"><?php echo Modules::run('f137/observeValues', $spr_rec->maka_tao) ?></span>
                                <select style="display: none;" name="input_mt" id="input_mt<?php echo $grade_id ?>" onchange="editSchoolInfo($(this).val(), 'maka_tao', 'gs_spr_ov', <?php echo $school_year ?>, 'esk_gs_spr_ov_code', <?php echo ($spr_rec->esk_gs_spr_ov_code != '' ? $spr_rec->esk_gs_spr_ov_code : 0) ?>, 'ov_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)">
                                    <option <?php echo ($spr_rec->maka_tao == 0 ? 'selected' : '') ?> disabled="">Select Option</option>
                                    <option value="1" <?php echo ($spr_rec->maka_tao == 1 ? 'selected' : '') ?> onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '2')">Always Observed</option>
                                    <option value="2" <?php echo ($spr_rec->maka_tao == 2 ? 'selected' : '') ?> onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '2')">Rarely Observed</option>
                                    <option value="3" <?php echo ($spr_rec->maka_tao == 3 ? 'selected' : '') ?> onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '2')">Sometimes Observed</option>
                                    <option value="4" <?php echo ($spr_rec->maka_tao == 4 ? 'selected' : '') ?> onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '2')">Not Observed</option>
                                </select>
                                <i id="editmtBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="closemtBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_mt', 'editmtBtn', 'savemtBtn', 'input_mt', 'closemtBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Makakalikasan: &nbsp;</label>
                                <span id="span_mk<?php echo $grade_id ?>"><?php echo Modules::run('f137/observeValues', $spr_rec->maka_kalikasan) ?></span>
                                <select style="display: none;" name="input_mk" id="input_mk<?php echo $grade_id ?>" onchange="editSchoolInfo($(this).val(), 'maka_kalikasan', 'gs_spr_ov', <?php echo $school_year ?>, 'esk_gs_spr_ov_code', <?php echo ($spr_rec->esk_gs_spr_ov_code != '' ? $spr_rec->esk_gs_spr_ov_code : 0) ?>, 'ov_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)">
                                    <option <?php echo ($spr_rec->maka_kalikasan == 0 ? 'selected' : '') ?> disabled="">Select Option</option>
                                    <option value="1" <?php echo ($spr_rec->maka_kalikasan == 1 ? 'selected' : '') ?> onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '2')">Always Observed</option>
                                    <option value="2" <?php echo ($spr_rec->maka_kalikasan == 2 ? 'selected' : '') ?> onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '2')">Rarely Observed</option>
                                    <option value="3" <?php echo ($spr_rec->maka_kalikasan == 3 ? 'selected' : '') ?> onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '2')">Sometimes Observed</option>
                                    <option value="4" <?php echo ($spr_rec->maka_kalikasan == 4 ? 'selected' : '') ?> onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '2')">Not Observed</option>
                                </select>
                                <i id="editmkBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="closemkBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_mk', 'editmkBtn', 'savemkBtn', 'input_mk', 'closemkBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                                <label>Makabansa: &nbsp;</label>
                                <span id="span_mb<?php echo $grade_id ?>"><?php echo Modules::run('f137/observeValues', $spr_rec->maka_bansa) ?></span>
                                <select style="display: none;" name="input_mb" id="input_mb<?php echo $grade_id ?>" onchange="editSchoolInfo($(this).val(), 'maka_bansa', 'gs_spr_ov', <?php echo $school_year ?>, 'esk_gs_spr_ov_code', <?php echo ($spr_rec->esk_gs_spr_ov_code != '' ? $spr_rec->esk_gs_spr_ov_code : 0) ?>, 'ov_id', $('#st_id').val(), <?php echo $spr_rec->sch_id ?>)">
                                    <option <?php echo ($spr_rec->maka_bansa == 0 ? 'selected' : '') ?> disabled="">Select Option</option>
                                    <option value="1" <?php echo ($spr_rec->maka_bansa == 1 ? 'selected' : '') ?> onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '2')">Always Observed</option>
                                    <option value="2" <?php echo ($spr_rec->maka_bansa == 2 ? 'selected' : '') ?> onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '2')">Rarely Observed</option>
                                    <option value="3" <?php echo ($spr_rec->maka_bansa == 3 ? 'selected' : '') ?> onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '2')">Sometimes Observed</option>
                                    <option value="4" <?php echo ($spr_rec->maka_bansa == 4 ? 'selected' : '') ?> onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '2')">Not Observed</option>
                                </select>
                                <i id="editmbBtn<?php echo $grade_id ?>" class="fa fa-pencil-square-o pointer" onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '1')"></i>
                                <i id="closembBtn<?php echo $grade_id ?>" style="display: none" class="fa fa-close clickover pointer text-danger" onclick="editAcad('span_mb', 'editmbBtn', 'savembBtn', 'input_mb', 'closembBtn', <?php echo $grade_id ?>, '2')"></i>
                                <br>

                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td style="text-align: center">1st</td>
                    <td style="text-align: center">2nd</td>
                    <td style="text-align: center">3rd</td>
                    <td style="text-align: center">4th</td>
                    <td style="text-align: center">Final</td>
                    <td style="text-align: center">Remarks</td>
                </tr>
                <?php
                $mcount = 0;
                foreach ($acadRec as $ar):
                    $subj = Modules::run('sf10/getSubjectDesc', $ar->subject_id);
                    if ($subj->parent_subject == 18):
                        $mFirst += $ar->first;
                        $mSecond += $ar->second;
                        $mThird += $ar->third;
                        $mFourth += $ar->fourth;
                        $mcount++;
                    endif;
                endforeach;

                $qFirstMapeh = round($mFirst / $mcount);
                $qSecondMapeh = round($mSecond / $mcount);
                $qThirdMapeh = round($mThird / $mcount);
                $qFourthMapeh = round($mFourth / $mcount);
                $mfinal = round(($qFirstMapeh + $qSecondMapeh + $qThirdMapeh + $qFourthMapeh) / 4);
                foreach ($acadRec as $ar):
                    $subj = Modules::run('sf10/getSubjectDesc', $ar->subject_id);
                    if ($subj->parent_subject == 18):
                        if ($subj->subject_id == 13):
                            ?>
                            <tr>
                                <td>MAPEH</td>
                                <td style="text-align: center"><?php echo ($qFirstMapeh != 0 ? $qFirstMapeh : '') ?></td>
                                <td style="text-align: center"><?php echo ($qSecondMapeh != 0 ? $qSecondMapeh : '') ?></td>
                                <td style="text-align: center"><?php echo ($qThirdMapeh != 0 ? $qThirdMapeh : '') ?></td>
                                <td style="text-align: center"><?php echo ($qFourthMapeh != 0 ? $qFourthMapeh : '') ?></td>
                                <td style="text-align: center"><?php echo ($qFourthMapeh != 0 ? $mfinal : '') ?></td>
                                <td style="text-align: center"><?php echo ($qFourthMapeh != 0 ? ($mfinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;<?php echo $subj->subject ?></td>
                                <td style="text-align: center"><?php echo $ar->first ?></td>
                                <td style="text-align: center"><?php echo $ar->second ?></td>
                                <td style="text-align: center"><?php echo $ar->third ?></td>
                                <td style="text-align: center"><?php echo $ar->fourth ?></td>
                                <?php $subjFinal = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4) ?>
                                <td style="text-align: center"><?php echo ($ar->fourth != '' ? $subjFinal : '') ?></td>
                                <td style="text-align: center"><?php echo ($ar->fourth != '' ? ($subjFinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                                <td class="ar_id<?php echo $school_year ?> pointer" hidden="" id="<?php echo $ar->subject_id ?>" onclick="deleteArec(this.id)"><i class="fa fa-close" style="color: red"></i></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;<?php echo $subj->subject ?></td>
                                <td style="text-align: center"><?php echo $ar->first ?></td>
                                <td style="text-align: center"><?php echo $ar->second ?></td>
                                <td style="text-align: center"><?php echo $ar->third ?></td>
                                <td style="text-align: center"><?php echo $ar->fourth ?></td>
                                <?php $subjFinal = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4) ?>
                                <td style="text-align: center"><?php echo ($ar->fourth != '' ? $subjFinal : '') ?></td>
                                <td style="text-align: center"><?php echo ($ar->fourth != '' ? ($subjFinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                                <td class="ar_id<?php echo $school_year ?> pointer" hidden="" id="<?php echo $ar->subject_id ?>" onclick="deleteArec(this.id)"><i class="fa fa-close" style="color: red"></i></td>
                            </tr>
                        <?php endif; ?>
                    <?php else: ?>
                        <tr>
                            <td><?php echo $subj->subject ?></td>
                            <td style="text-align: center"><?php echo $ar->first ?></td>
                            <td style="text-align: center"><?php echo $ar->second ?></td>
                            <td style="text-align: center"><?php echo $ar->third ?></td>
                            <td style="text-align: center"><?php echo $ar->fourth ?></td>
                            <?php $subjFinal = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4) ?>
                            <td style="text-align: center"><?php echo ($ar->fourth != '' ? $subjFinal : '') ?></td>
                            <td style="text-align: center"><?php echo ($ar->fourth != '' ? ($subjFinal < 75 ? 'FAILED' : 'PASSED') : '') ?></td>
                            <td class="ar_id<?php echo $school_year ?> pointer" hidden="" id="<?php echo $ar->subject_id ?>" onclick="deleteArec(this.id)"><i class="fa fa-close" style="color: red"></i></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
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
    </table>
</div>
<?php
// echo $this->load->view('uploadAcadRecords'); ?>