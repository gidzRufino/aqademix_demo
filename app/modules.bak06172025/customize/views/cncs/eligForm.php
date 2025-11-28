<?php
$nursery = Modules::run('f137/getSchoolInfo', $school->nursery_sch_id);
$nursery_add = ($nursery->street != '' ? $nursery->street . ', ' : '') . ($nursery->barangay_id != '' ? $nursery->barangay_id . ', ' : '') . ($nursery->city_id != '' ? $nursery->mun_city : '');
$k1 = Modules::run('f137/getSchoolInfo', $school->kinder1_sch_id);
$k1_add = ($k1->street != '' ? $k1->street . ', ' : '') . ($k1->barangay_id != '' ? $k1->barangay_id . ', ' : '') . ($k1->city_id != '' ? $k1->mun_city : '');
$k2 = Modules::run('f137/getSchoolInfo', $school->kinder2_sch_id);
$k2_add = ($k2->street != '' ? $k2->street . ', ' : '') . ($k2->barangay_id != '' ? $k2->barangay_id . ', ' : '') . ($k2->city_id != '' ? $k2->mun_city : '');
?>
<br>
<div class="col-md-12">
    <div class="well" id="eligElem">
        <div class="row">
            <div class="col-md-4">
                <h4 style="text-align: center">Nursery</h4>
                <div class="input-group">
                    <label>Name of School :</label>
                    <span id="nursery_sch_name"><?php echo $nursery->school_name ?></span>
                    <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer" rel="clickover"  id="schoolName" onclick="displaySchoolList(), $('#lvalue').val('nursery')"
                       data-content="
                       <?php
                       $data['field'] = 'nursery';
                       $this->load->view('csfl/schoolSelect', $data);
                       ?>"></i>
                    <span></span><br>
                    <label>School ID :</label>
                    <span id="nursery_sch_sid"><?php echo $nursery->school_id ?></span><br>
                    <label>Address of School :</label>
                    <span><?php echo $nursery_add ?></span>
                    <i style="font-size:15px; color:#777; width: 40px" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                       rel="clickover"  id="addClick"
                       data-content="  <?php
                       $data['cities'] = Modules::run('main/getCities');
                       $data['address_id'] = $nursery->address_id;
                       $data['st_id'] = $p_add->st_id;
                       $data['street'] = $nursery->street;
                       $data['barangay'] = $nursery->barangay_id;
                       $data['city'] = $nursery->city_id;
                       $data['province'] = $nursery->province;
                       $data['pid'] = $nursery->province_id;
                       $data['zip_code'] = $nursery->zip_code;
                       $data['sch_id'] = $nursery->school_id;
                       $data['user_id'] = '';
                       $data['is_home'] = 0;
                       $this->load->view('addressInfo', $data)
                       ?>
                       "></i>
                    <br>
                    <label>School Year :</label>
                    <span id="nSpanSY"><?php echo $school->nursery_sy ?></span>
                    <input style="display: none;" name="nurserySY" type="text" data-date-format="yyyy-mm-dd" id="nurserySY" value="<?php echo $school->nursery_sy; ?>" placeholder="School Year" onblur="" required>
                    <i id="editnurserySYBtn" onclick="$('#nSpanSY').hide(), $('#nurserySY').show(), $('#nurserySY').focus(), $('#closenurserySYBtn').show(), $('#savenurserySYBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savenurserySYBtn" onclick="$('#editVal').val($('#nurserySY').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('nursery_sy', 'gs_spr_preschool', 'st_id', 0), $('#nSpanSY').show(), $('#nurserySY').hide(), $('#editnurserySYBtn').show(), $(this).hide(), $('#closenurserySYBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closenurserySYBtn" onclick="$('#nSpanSY').show(), $('#nurserySY').hide(), $('#editnurserySYBtn').show(), $('#savenurserySYBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Final Average :</label>
                    <span id="span_nAve"><?php echo $school->nursery_ave ?></span>
                    <input style="display: none;" name="nAve" type="text" data-date-format="yyyy-mm-dd" id="nAve" value="<?php echo $school->nursery_ave; ?>" placeholder="School Year" onblur="" required>
                    <i id="editnAveBtn" onclick="$('#span_nAve').hide(), $('#nAve').show(), $('#nAve').focus(), $('#closenAveBtn').show(), $('#savenAveBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savenAveBtn" onclick="$('#editVal').val($('#nAve').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('nursery_ave', 'gs_spr_preschool', 'st_id', 0), $('#span_nAve').show(), $('#nAve').hide(), $('#editnAveBtn').show(), $(this).hide(), $('#closenAveBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closenAveBtn" onclick="$('#span_nAve').show(), $('#nAve').hide(), $('#editnAveBtn').show(), $('#savenAveBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Days :</label>
                    <span id="span_nDays"><?php echo $school->nursery_days ?></span>
                    <input style="display: none;" name="nDays" type="text" data-date-format="yyyy-mm-dd" id="nDays" value="<?php echo $school->nursery_days; ?>" placeholder="School Year" onblur="" required>
                    <i id="editnDaysBtn" onclick="$('#span_nDays').hide(), $('#nDays').show(), $('#nDays').focus(), $('#closenDaysBtn').show(), $('#savenDaysBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savenDaysBtn" onclick="$('#editVal').val($('#nDays').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('nursery_days', 'gs_spr_preschool', 'st_id', 0), $('#span_nDays').show(), $('#nDays').hide(), $('#editnDaysBtn').show(), $(this).hide(), $('#closenDaysBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closenDaysBtn" onclick="$('#span_nDays').show(), $('#nDays').hide(), $('#editnDaysBtn').show(), $('#savenDaysBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                </div>
            </div>
            <div class="col-md-4">
                <h4 style="text-align: center">Kinder 1</h4>
                <div class="input-group">
                    <label>Name of School :</label>
                    <span id="k1_sch_name"><?php echo $k1->school_name ?></span>
                    <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer" rel="clickover"  id="schoolName" onclick="displaySchoolList()"
                       data-content="
                       <?php
                       $data['field'] = 'kinder1';
                       $this->load->view('csfl/schoolSelect', $data);
                       ?>"></i>
                    <span></span><br>
                    <label>School ID :</label>
                    <span id="k1_sch_sid"><?php echo $k1->school_id ?></span><br>
                    <label>Address of School :</label>
                    <span><?php echo $k1_add ?></span>
                    <i style="font-size:15px; color:#777; width: 45px" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                       rel="clickover"  id="addClick"
                       data-content="  <?php
                       $data['cities'] = Modules::run('main/getCities');
                       $data['address_id'] = $k1->address_id;
                       $data['st_id'] = $p_add->st_id;
                       $data['street'] = $k1->street;
                       $data['barangay'] = $k1->barangay_id;
                       $data['city'] = $k1->city_id;
                       $data['province'] = $k1->province;
                       $data['pid'] = $k1->province_id;
                       $data['zip_code'] = $k1->zip_code;
                       $data['sch_id'] = $k1->school_id;
                       $data['user_id'] = '';
                       $data['is_home'] = 0;
                       $this->load->view('addressInfo', $data)
                       ?>
                       "></i>
                    <br>
                    <label>School Year :</label>
                    <span id="span_kinder1SY"><?php echo $school->kinder1_sy ?></span>
                    <input style="display: none;" name="k1SY" type="text" data-date-format="yyyy-mm-dd" id="k1SY" value="<?php echo $school->kinder1_sy; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk1SYBtn" onclick="$('#span_kinder1SY').hide(), $('#k1SY').show(), $('#k1SY').focus(), $('#closek1SYBtn').show(), $('#savek1SYBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek1SYBtn" onclick="$('#editVal').val($('#k1SY').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder1_sy', 'gs_spr_preschool', 'st_id', 0), $('#span_kinder1SY').show(), $('#k1SY').hide(), $('#editk1SYBtn').show(), $(this).hide(), $('#closek1SYBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek1SYBtn" onclick="$('#span_kinder1SY').show(), $('#k1SY').hide(), $('#editk1SYBtn').show(), $('#savek1SYBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Final Average :</label>
                    <span id="span_k1Ave"><?php echo $school->kinder1_ave ?></span>
                    <input style="display: none;" name="k1Ave" type="text" data-date-format="yyyy-mm-dd" id="k1Ave" value="<?php echo $school->kinder1_ave; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk1AveBtn" onclick="$('#span_k1Ave').hide(), $('#k1Ave').show(), $('#k1Ave').focus(), $('#closek1AveBtn').show(), $('#savek1AveBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek1AveBtn" onclick="$('#editVal').val($('#k1Ave').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder1_ave', 'gs_spr_preschool', 'st_id', 0), $('#span_k1Ave').show(), $('#k1Ave').hide(), $('#editk1AveBtn').show(), $(this).hide(), $('#closek1AveBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek1AveBtn" onclick="$('#span_k1Ave').show(), $('#k1Ave').hide(), $('#editk1AveBtn').show(), $('#savek1AveBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Days :</label>
                    <span id="span_k1Days"><?php echo $school->kinder1_days ?></span>
                    <input style="display: none;" name="k1Days" type="text" data-date-format="yyyy-mm-dd" id="k1Days" value="<?php echo $school->kinder1_days; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk1DaysBtn" onclick="$('#span_k1Days').hide(), $('#k1Days').show(), $('#k1Days').focus(), $('#closek1DaysBtn').show(), $('#savek1DaysBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek1DaysBtn" onclick="$('#editVal').val($('#k1Days').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder1_days', 'gs_spr_preschool', 'st_id', 0), $('#span_k1Days').show(), $('#k1Days').hide(), $('#editk1DaysBtn').show(), $(this).hide(), $('#closek1DaysBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek1DaysBtn" onclick="$('#span_k1Days').show(), $('#k1Days').hide(), $('#editk1DaysBtn').show(), $('#savek1DaysBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                </div>
            </div>
            <div class="col-md-4">
                <h4 style="text-align: center">Kinder 2</h4>
                <div class="input-group">
                    <label>Name of School :</label>
                    <span id="k2_sch_name"><?php echo $k2->school_name ?></span>
                    <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer" rel="clickover"  id="schoolName" onclick="displaySchoolList()"
                       data-content="
                       <?php
                       $data['field'] = 'kinder2';
                       $this->load->view('csfl/schoolSelect', $data);
                       ?>"></i>
                    <span></span><br>
                    <label>School ID :</label>
                    <span id="k2_sch_sid"><?php echo $k2->school_id ?></span><br>
                    <label>Address of School :</label>
                    <span><?php echo $k2_add ?></span>
                    <i style="font-size:15px; color:#777; width: 45px" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?> <?php echo $editable ?>"
                       rel="clickover"  id="addClick"
                       data-content="  <?php
                       $data['cities'] = Modules::run('main/getCities');
                       $data['address_id'] = $k2->address_id;
                       $data['st_id'] = $p_add->st_id;
                       $data['street'] = $k2->street;
                       $data['barangay'] = $k2->barangay_id;
                       $data['city'] = $k2->city_id;
                       $data['province'] = $k2->province;
                       $data['pid'] = $k2->province_id;
                       $data['zip_code'] = $k2->zip_code;
                       $data['sch_id'] = $k2->school_id;
                       $data['user_id'] = '';
                       $data['is_home'] = 0;
                       $this->load->view('addressInfo', $data)
                       ?>
                       "></i>
                    <br>
                    <label>School Year :</label>
                    <span id="span_kinder2SY"><?php echo $school->kinder2_sy ?></span>
                    <input style="display: none;" name="k2SY" type="text" data-date-format="yyyy-mm-dd" id="k2SY" value="<?php echo $school->kinder2_sy; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk2SYBtn" onclick="$('#span_kinder2SY').hide(), $('#k2SY').show(), $('#k2SY').focus(), $('#closek2SYBtn').show(), $('#savek2SYBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek2SYBtn" onclick="$('#editVal').val($('#k2SY').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder2_sy', 'gs_spr_preschool', 'st_id', 0), $('#span_kinder2SY').show(), $('#k2SY').hide(), $('#editk2SYBtn').show(), $(this).hide(), $('#closek2SYBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek2SYBtn" onclick="$('#span_kinder2SY').show(), $('#k2SY').hide(), $('#editk2SYBtn').show(), $('#savek2SYBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Final Average :</label>
                    <span id="span_k2Ave"><?php echo $school->kinder2_ave ?></span>
                    <input style="display: none;" name="k2Ave" type="text" data-date-format="yyyy-mm-dd" id="k2Ave" value="<?php echo $school->kinder2_ave; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk2AveBtn" onclick="$('#span_k2Ave').hide(), $('#k2Ave').show(), $('#k2Ave').focus(), $('#closek2AveBtn').show(), $('#savek2AveBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek2AveBtn" onclick="$('#editVal').val($('#k2Ave').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder2_ave', 'gs_spr_preschool', 'st_id', 0), $('#span_k2Ave').show(), $('#k2Ave').hide(), $('#editk2AveBtn').show(), $(this).hide(), $('#closek2AveBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek2AveBtn" onclick="$('#span_k2Ave').show(), $('#k2Ave').hide(), $('#editk2AveBtn').show(), $('#savek2AveBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                    <label>Days :</label>
                    <span id="span_k2Days"><?php echo $school->kinder2_days ?></span>
                    <input style="display: none;" name="k2Days" type="text" data-date-format="yyyy-mm-dd" id="k2Days" value="<?php echo $school->kinder2_days; ?>" placeholder="School Year" onblur="" required>
                    <i id="editk2DaysBtn" onclick="$('#span_k2Days').hide(), $('#k2Days').show(), $('#k2Days').focus(), $('#closek2DaysBtn').show(), $('#savek2DaysBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="savek2DaysBtn" onclick="$('#editVal').val($('#k2Days').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('kinder2_days', 'gs_spr_preschool', 'st_id', 0), $('#span_k2Days').show(), $('#k2Days').hide(), $('#editk2DaysBtn').show(), $(this).hide(), $('#closek2DaysBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closek2DaysBtn" onclick="$('#span_k2Days').show(), $('#k2Days').hide(), $('#editk2DaysBtn').show(), $('#savek2DaysBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <div id="eligJHS" hidden="">
        Junior High Eligibility
    </div>
    <div id="eligSHS" hidden="">
        Senior High Eligibility
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
//        $.ajax({
//            type: 'GET',
//            url: '<?php echo base_url() . 'f137/getEligibilityInfo/' ?>' + $('#st_id').val() + '/' + $('#elemSY').val(),
//            dataType: 'json',
//            success: function (data) {
//                $('#sch_name').text(data.school_name);
//                $('#sch_sid').text(data.sch_id);
//            }
//        });
    });

    function updateCSFLskulInfo(field) {
        var field = $('#lvalue').val() + '_' + field;
        var value = $('#schoolList').val();
        var sy = $('#elemSY').val();
        var stid = $('#st_id').val();
        var tbl = 'gs_spr_preschool';
        var tbl_id = 'preschool_id';

//        alert(field + ' ' + value + ' ' + sy + ' ' + stid);
        var url = '<?php echo base_url() . 'f137/updateEligibility' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'stid=' + stid + '&field=' + field + '&value=' + value + '&sy=' + sy + '&tbl=' + tbl + '&tbl_id=' + tbl_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data) {
                location.reload();
            }
        });
    }
</script>