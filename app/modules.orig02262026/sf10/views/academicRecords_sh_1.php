<br/>
<span class="badge badge-pill badge-light nowrap clickover pointer pull-right" style="background-color: green; cursor: pointer" onclick="printForm(<?php echo $gsYR ?>, $('#strand-id').val())">
    <i style="font-size:15px;" class="fa fa-book"></i> Generate Records
</span>

<div class="well col-lg-12" id="profBody">
    <div class="col-lg-6">
        <dl class="dl-horizontal">
            <dt>
                Grade Level:
            </dt>
            <dd >
                <span id="acad_level_span">
                    <?php echo strtoupper(levelDesc($acadRecords->row()->grade_level_id)) ?>
                </span>
                <select style="width:225px; display: none" name="acad_level" id="acad_level">
                    <option>Select Grade Level</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo ($i + 1) ?>" <?php echo ($acadRecords->row()->grade_level_id == ($i + 1) ? 'selected' : '') ?>>Grade <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
<!--                <input style="display: none;" name="acad_level" type="text" data-date-format="yyyy-mm-dd" id="acad_level" value="<?php //echo $acadRecords->row()->grade_level_id;                                               ?>" placeholder="Grade Level" 
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
                    <?php echo strtoupper($acadRecords->row()->section) ?>
                </span>
                <input style="display: none;" name="acad_section" type="text" data-date-format="yyyy-mm-dd" id="acad_section" value="<?php echo $acadRecords->row()->section; ?>" placeholder="School Name" 
                       onblur="" required>
                <i id="acad_editsectionBtn" onclick="$('#acad_section_span').hide(), $('#acad_section').show(), $('#acad_section').focus(), $('#acad_closesectionBtn').show(), $('#acad_savesectionBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_savesectionBtn" onclick="$('#editVal').val($('#acad_section').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('section', 'gs_spr', 'st_id'), $('#acad_section').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $('#acad_closesectionBtn').hide(), $('#acad_section_span').show()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closesectionBtn" onclick="$('#acad_section_span').show(), $('#acad_section').hide(), $('#acad_editsectionBtn').show(), $('#acad_savesectionBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <?php if ($acadRecords->row()->grade_level_id == 12 || $acadRecords->row()->grade_level_id == 13): ?>
            <?php $strand = Modules::run('sf10/getStrandCode', $acadRecords->row()->strandid); ?>
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
                    <?php echo strtoupper($acadRecords->row()->school_name) ?>
                </span>
                <input type="text" name="acad_school" id="acad_school" value="<?php echo $acadRecords->row()->school_name; ?>" placeholder="School Name" style="display: none;"
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
                    <?php echo strtoupper($acadRecords->row()->school_id) ?>
                </span>
                <input style="display: none;" name="acad_school_id" type="text" data-date-format="yyyy-mm-dd" id="acad_school_id" value="<?php echo $acadRecords->row()->school_id; ?>" placeholder="School ID" 
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
                    <?php echo strtoupper($acadRecords->row()->district); ?>
                </span>
                <input style="display: none;" name="acad_district" type="text" data-date-format="yyyy-mm-dd" id="acad_district" value="<?php echo $acadRecords->row()->district; ?>" placeholder="School district" 
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
                    <?php echo strtoupper($acadRecords->row()->division); ?>
                </span>
                <input style="display: none;" name="acad_division" type="text" data-date-format="yyyy-mm-dd" id="acad_division" value="<?php echo $acadRecords->row()->division; ?>" placeholder="School division" 
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
                    <?php echo strtoupper($acadRecords->row()->region); ?>
                </span>
                <input style="display: none;" name="acad_region" type="text" data-date-format="yyyy-mm-dd" id="acad_region" value="<?php echo strtoupper($acadRecords->row()->region); ?>" placeholder="Region" 
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
                    <?php echo strtoupper($acadRecords->row()->spr_adviser); ?>
                </span>
                <input style="display: none;" name="acad_adviser" type="text" data-date-format="yyyy-mm-dd" id="acad_adviser" value="<?php echo $acadRecords->row()->spr_adviser; ?>" placeholder="Adviser / Teacher" 
                       onblur="" required>
                <i id="acad_editadviserBtn" onclick="$('#acad_adviser_span').hide(), $('#acad_adviser').show(), $('#acad_adviser').focus(), $('#acad_closeadviserBtn').show(), $('#acad_saveadviserBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                <i id="acad_saveadviserBtn" onclick="$('#editVal').val($('#acad_adviser').val()), $('#skulYR').val(<?php echo $gsYR ?>), editInfo('spr_adviser', 'gs_spr', 'st_id'), $('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $(this).hide(), $('#acad_closeadviserBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                <i id="acad_closeadviserBtn" onclick="$('#acad_adviser_span').show(), $('#acad_adviser').hide(), $('#acad_editadviserBtn').show(), $('#acad_saveadviserBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
            </dd>
        </dl>
        <div id="url"></div>
    </div>    
</div>

<div id="recordsTbl">

</div>


<div class="modal fade" id="uRecord" tabindex="-1" role="dialog" aria-labelledby="uRecord" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix">
                Subject: <span id="eSubj"></span>
                <a href="#" data-dismiss="modal">
                    <i class="pull-right fa fa-close pointer"></i>
                </a>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="text-align: center">1st Quarter</th>
                        <th style="text-align: center">2nd Quarter</th>
                        <th style="text-align: center">3rd Quarter</th>
                        <th style="text-align: center">4th Quarter</th>
                    </tr>
                    <tr>
                        <td style="text-align: center" id="sFirst" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sSecond" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sThird" contenteditable="true">

                        </td>
                        <td style="text-align: center" id="sFourth" contenteditable="true">

                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-small" data-dismiss="modal" onclick="updateRec()">Update</button>
                <button class="btn btn-danger btn-small" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="school_yearSH" value="<?php echo $gsYR ?>" />
<input type="hidden" id="arID" />
<input type="hidden" id="subID" />
<input type="hidden" id="getSPR" value="<?php echo $acadRecords->row()->spr_id; ?>" />
<input type="hidden" id="spr_status" value="<?php echo $acadRecords->row()->go_to_next_level; ?>" />
<input type="hidden" id="strand-id" value="<?php echo $acadRecords->row()->strandid ?>" />
<input type="hidden" id="grade_level_id" value="<?php echo $acadRecords->row()->grade_level_id  ?>" />
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
        case 12:
            return 'Grade 11';
        case 13:
            return 'Grade 12';
    endswitch;
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    });

    function updateRec() {
        var spr_id = $('#getSPR').val();
        var subj_id = $('#subID').val();
        var ar_id = $('#arID').val();
        var first = $('#sFirst').text();
        var second = $('#sSecond').text();
        var third = $('#sThird').text();
        var fourth = $('#sFourth').text();
        var sy = $('#sy').val();
        //alert(spr_id + ' ' + ' ' + subj_id + ' ' + ar_id + ' ' + first + ' ' + second + ' ' + third + ' ' + fourth + ' ' + sy);

        var url = '<?php echo base_url() . 'sf10/updateSPRrecord/' ?>' + spr_id + '/' + subj_id + '/' + ar_id + '/' + first + '/' + second + '/' + third + '/' + fourth + '/' + sy;

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + ar_id,
            success: function (data) {
                //window.location.reload();
            },
            error: function (data) {

            }
        });
    }

    function delRec(sprid, sy) {
        alert(sprid + ' ' + sy);
    }

    $(function () {
        function check() {
            //alert($('#st_id').val() + ' ' + $('#sy').val());
            var url = '<?php echo base_url() . 'sf10/checkUpdateAcad/' ?>' + $('#st_id').val() + '/' + $('#sy').val();


            //alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                data: "",
                dataType: 'json',
                success: function (result) {
                    //var level = '';
                    if (result.grade_level_id == 1) {
                        var level = 'KINDER';
                    } else if (result.grade_level_id == 2) {
                        var level = 'GRADE 1';
                    } else if (result.grade_level_id == 3) {
                        var level = 'GRADE 2';
                    } else if (result.grade_level_id == 4) {
                        var level = 'GRADE 3';
                    } else if (result.grade_level_id == 5) {
                        var level = 'GRADE 4';
                    } else if (result.grade_level_id == 6) {
                        var level = 'GRADE 5';
                    } else if (result.grade_level_id == 7) {
                        var level = 'GRADE 6';
                    } else if (result.grade_level_id == 8) {
                        var level = 'GRADE 7';
                    } else if (result.grade_level_id == 9) {
                        var level = 'GRADE 8';
                    } else if (result.grade_level_id == 10) {
                        var level = 'GRADE 9';
                    } else if (result.grade_level_id == 11) {
                        var level = 'GRADE 10';
                    } else if (result.grade_level_id == 12) {
                        var level = 'GRADE 11';
                    } else if (result.grade_level_id == 13) {
                        var level = 'GRADE 12';
                    }

                    $('#acad_level_span').text(level);
                    $('#acad_section_span').text(result.section.toUpperCase());
                    $('#acad_strand_span').text(result.short_code.toUpperCase());
                    $('#strand-id').val(result.strandid);
                    $('#acad_school_span').text(result.school_name.toUpperCase());
                    $('#acad_schID_span').text(result.school_id);
                    $('#acad_district_span').text(result.district.toUpperCase());
                    $('#acad_division_span').text(result.division.toUpperCase());
                    $('#acad_region_span').text(result.region.toUpperCase());
                    $('#acad_adviser_span').text(result.spr_adviser.toUpperCase());
                    //$('#url').text(url);
                    //alert('check');
                }
            });
        }

        function checkRecords() {
            var url = '<?php echo base_url() . 'sf10/checkRecords/' ?>' + $('#st_id').val() + '/' + $('#sy').val() + '/' + <?php echo $acadRecords->row()->grade_level_id ?> + '/' + <?php echo $acadRecords->row()->strandid ?>;
            //alert(url);

            $.ajax({
                type: 'GET',
                url: url,
                data: "",
                //dataType: 'json',
                success: function (data) {
                    $('#recordsTbl').html(data);
                },
                error: function (data) {
                    //alert('error checking');
                }
            });
        }
        //setInterval(check, 10000);
        //setInterval(checkRecords, 10000);
    });
</script>