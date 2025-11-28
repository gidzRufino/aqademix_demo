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
                    <a href="<?php echo base_url('reports/generateForm137') ?>" class="pull-right "><i class="fa fa-search fa-2x pointer"></i></a>
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
            <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->school_year . ' - ' . ($this->session->school_year + 1) ?> <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php
                $ro_years = Modules::run('install/spr_records/databaseList');
                $settings = $this->eskwela->getSet();
                $numString = strlen($settings->short_name) + 8;
                foreach ($ro_years as $ro) {
                    if ("eskwela_" . strtolower($settings->short_name) == substr($ro, 0, $numString)) {
                        ?>
                        <li onclick="$('#btnControl').html('<?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?>  <span class=\'caret\'></span>'), $('#inputSchoolYear').val('<?php echo substr($ro, $numString + 1, $numString + 5) ?>')"><a href="#"><?php echo substr($ro, $numString + 1, $numString + 5) . ' - ' . (substr($ro, $numString + 1, $numString + 5) + 1); ?></a></li>
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
        <div class="col-lg-6">
            <dl class="dl-horizontal">
                <dt>
                    Name :
                </dt>
                <dd >
                    <?php echo strtoupper($student->firstname . " " . substr($student->middlename, 0, 1) . ". " . $student->lastname . " " . $student->sprp_extname) ?>
                    <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"
                       rel="clickover" 
                       data-content=" 
                       <?php
                       $data['pos'] = 's';
                       $data['st_user_id'] = $student->st_id;
                       $data['user_id'] = $student->st_id;
                       $data['firstname'] = $student->firstname;
                       $data['middlename'] = $student->middlename;
                       $data['lastname'] = $student->lastname;
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
                    <i id="saveBdateBtn" onclick="$('#editVal').val($('#bdate').val()), editInfo('sprp_bdate', 'gs_spr_profile', 'sprp_st_id'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <span id="lrn_span"><?php echo (strtoupper($student->sprp_lrn != '0000-00-00' ? $student->sprp_lrn : 'not set')); ?></span>
                    <input style="display: none;" name="inputLRN" type="text" data-date-format="yyyy-mm-dd" id="lrn" value="<?php echo $student->sprp_lrn; ?>" placeholder="LRN" 
                           onblur="" required>
                    <i id="editLRNBtn" onclick="$('#lrn_span').hide(), $('#lrn').show(), $('#lrn').focus(), $('#closeLRNBtn').show(), $('#saveLRNBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer <?php echo $editable ?>"></i>   
                    <i id="saveLRNBtn" onclick="$('#editVal').val($('#lrn').val()), editInfo('sprp_lrn', 'gs_spr_profile', 'sprp_st_id'), $('#lrn_span').show(), $('#lrn').hide(), $('#editLRNBtn').show(), $('#saveLRNBtn').hide(), $('#closeLRNBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="saveschoolBtn" onclick="$('#editVal').val($('#school').val()), editInfo('school_name', 'gs_spr', 'st_id'), $('#school_span').show(), $('#school').hide(), $('#editschoolBtn').show(), $('#saveschoolBtn').hide(), $('#closeschoolBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="saveschIDBtn" onclick="$('#editVal').val($('#school_id').val()), editInfo('school_id', 'gs_spr', 'st_id'), $('#schID_span').show(), $('#school_id').hide(), $('#editschIDBtn').show(), $('#saveschIDBtn').hide(), $('#closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="savedistrictBtn" onclick="$('#editVal').val($('#district').val()), editInfo('district', 'gs_spr', 'st_id'), $('#district_span').show(), $('#district').hide(), $('#editdistrictBtn').show(), $(this).hide(), $('#closedistrictBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="savedivisionBtn" onclick="$('#editVal').val($('#division').val()), editInfo('division', 'gs_spr', 'st_id'), $('#division_span').show(), $('#division').hide(), $('#editdivisionBtn').show(), $(this).hide(), $('#closedivisionBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="saveregionBtn" onclick="$('#editVal').val($('#region').val()), editInfo('region', 'gs_spr', 'st_id'), $('#region_span').show(), $('#region').hide(), $('#editregionBtn').show(), $(this).hide(), $('#closeschIDBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
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
                    <i id="saveadviserBtn" onclick="$('#editVal').val($('#adviser').val()), editInfo('spr_adviser', 'gs_spr', 'st_id'), $('#adviser_span').show(), $('#adviser').hide(), $('#editadviserBtn').show(), $(this).hide(), $('#closeadviserBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeadviserBtn" onclick="$('#adviser_span').show(), $('#adviser').hide(), $('#editadviserBtn').show(), $('#saveadviserBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                </dd>
            </dl>
        </div>    
    </div>
</div>
<?php echo Modules::run('reports/reports_f137/generateF137', base64_encode($student->st_id), $status, $dataSY) ?>
<input type="hidden" id="skulYR" value="<?php echo $student->school_year ?>" />
<input type="hidden" id="editVal" />
<input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
<input type="hidden" id="getSPR" value="<?php echo $student->spr_id ?>" />
<?php
$subject['subjects'] = $subjects;

$this->load->view('inputManually', $subject)
?>

<script type="text/javascript">
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
        var url = '<?php echo base_url() . 'reports/reports_f137/getPersonalInfo/' ?>' + st_id + '/' + status + '/' + year;
        document.location = url;
    }

    function search(value)
    {
        var sy = $('#inputSchoolYear').val();
        var url = '<?php echo base_url() . 'reports/reports_f137/searchStudent/' ?>' + value + '/' + sy;
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

        var url = "<?php echo base_url() . 'reports/generateF137/' ?>" + st_id;
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
        var url = "<?php echo base_url() . 'reports/saveSchoolDays/' ?>";
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
        var url = "<?php echo base_url() . 'reports/getSchoolDays/' ?>";
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
        var url = "<?php echo base_url() . 'reports/getDaysPresentModal/' ?>";
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

    function saveAcademicRecords()
    {
        var url = "<?php echo base_url() . 'reports/reports_f137/saveAcademicRecords/' ?>" + $('#st_id').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year: $('#form137School_year').val(),
                school: $('#school').val(),
                first: $('#first').val(),
                second: $('#second').val(),
                third: $('#third').val(),
                fourth: $('#fourth').val(),
                average: $('#average').val(),
                generalAverage: $('#generalAverage').val(),
                subject_id: $('#inputSubject').val(),
                grade_id: $('#inputGradeLevel').val(),
                spr_id: $('#spr_id').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (data)
            {
                $('#acadResults').html(data);
            }
        })
    }


    function deleteSPRecord()
    {
        var url = "<?php echo base_url() . 'reports/deleteSPRecords/' ?>" + $('#spr_id').val()
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
        var url = "<?php echo base_url() . 'reports/deleteSingleRecord/' ?>" + id
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
        var name_id = $('#name_id').val()
        var sy = $('#skulYR').val();
        var url = "<?php echo base_url() . 'reports/reports_f137/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&nameExt=' + $('#nameExt').val() + '&rowid=' + $('#rowid').val() + '&user_id=' + $('#st_user_id').val() + '&pos=' + $('#pos').val() + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#' + name_id).html(data);
                location.reload;
            }
        });

        return false;
    }

    function editInfo(field, tbl_name, stid)
    {
        var newVal = $('#editVal').val();
        var owner = $('#st_id').val();
        var sy = $('#skulYR').val();
        var url = "<?php echo base_url() . 'reports/reports_f137/editInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'newVal=' + newVal + '&owner=' + owner + '&sy=' + sy + '&field=' + field + '&tbl_name=' + tbl_name + '&stid=' + stid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                location.reload();
            }
        });

        return false;
    }

    function saveGender() {

    }

</script>
