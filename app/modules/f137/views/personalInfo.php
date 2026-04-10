<style>
    .dl-grid dt {
        font-weight: 600;
    }

    .dl-grid dd {
        margin-bottom: .4rem;
    }

    .pointer {
        cursor: pointer;
    }
</style>

<div id="generatedResult" class="row">

    <!-- ================= ACTION DROPDOWN ================= -->
    <div class="col-12 text-end mb-2">

        <div class="dropdown d-inline-block">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                data-bs-toggle="dropdown">
                Add Record
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#" onclick="$('#autoSelect').modal('show')">
                        Academic
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" onclick="$('#attendanceInformation').modal('show')">
                        Attendance
                    </a>
                </li>
            </ul>
        </div>

    </div>


    <!-- ================= PROFILE CARD ================= -->
    <div class="col-12">
        <div class="card shadow-sm border-0" id="profBody">
            <div class="card-body">

                <div class="row g-4">

                    <!-- ================= LEFT COLUMN ================= -->
                    <div class="col-lg-6">

                        <h5 class="fw-bold mb-3">Personal Information</h5>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">Name :</dt>
                            <dd class="col-sm-8">
                                <span id="nameInfo">
                                    <?php echo strtoupper($student->sprp_firstname . " " . substr($student->sprp_middlename, 0, 1) . ". " . $student->sprp_lastname . " " . $student->sprp_extname) ?>
                                </span>

                                <i class="fa fa-pencil-square-o ms-2 pointer"
                                    onclick="$('#skulYR').val(<?php echo $student->school_year ?>)"
                                    rel="clickover"
                                    data-content="<?php
                                                    $data['pos'] = 's';
                                                    $data['st_user_id'] = $student->st_id;
                                                    $data['user_id'] = $student->st_id;
                                                    $data['firstname'] = $student->sprp_firstname;
                                                    $data['middlename'] = $student->sprp_middlename;
                                                    $data['lastname'] = $student->sprp_lastname;
                                                    $data['ext'] = $student->sprp_extname;
                                                    $data['name_id'] = 'name';
                                                    $this->load->view('basicInfo', $data);
                                                    ?>"></i>
                            </dd>
                        </dl>


                        <!-- ===== DOB ===== -->
                        <dl class="row dl-grid">
                            <dt class="col-sm-4">Date of Birth :</dt>
                            <dd class="col-sm-8">

                                <span id="a_bdate">
                                    <?php echo strtoupper(date('F d, Y', strtotime($student->sprp_bdate))); ?>
                                </span>

                                <input class="form-control form-control-sm mt-1"
                                    style="display:none"
                                    id="bdate">

                                <div class="mt-1">
                                    <i id="editBdateBtn"
                                        class="fa fa-pencil-square-o pointer text-secondary"
                                        onclick="$('#bdate').datepicker(),$('#a_bdate').hide(),$('#bdate').show(),$('#saveBdateBtn,#closeBdateBtn').show(),$(this).hide()"></i>

                                    <i id="saveBdateBtn"
                                        class="fa fa-save pointer ms-2"
                                        style="display:none"
                                        onclick="$('#editVal').val($('#bdate').val()),$('#skulYR').val(<?php echo $gsYR ?>),editInfo('sprp_bdate','gs_spr_profile','sprp_st_id',0)"></i>

                                    <i id="closeBdateBtn"
                                        class="fa fa-times pointer text-danger ms-2"
                                        style="display:none"
                                        onclick="$('#a_bdate').show(),$('#bdate').hide(),$('#editBdateBtn').show(),$('#saveBdateBtn,#closeBdateBtn').hide()"></i>
                                </div>

                            </dd>
                        </dl>


                        <!-- ===== SAMPLE FIELD PATTERN (converted layout) ===== -->

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">Place of Birth:</dt>
                            <dd class="col-sm-8">

                                <span id="Bplace_span"><?php echo $student->sprp_bplace ?></span>

                                <input class="form-control form-control-sm mt-1"
                                    style="display:none"
                                    id="Bplace"
                                    value="<?php echo $student->sprp_bplace ?>">

                                <div class="mt-1">
                                    <i id="editBplaceBtn"
                                        class="fa fa-pencil-square-o pointer text-secondary"
                                        onclick="$('#Bplace_span').hide(),$('#Bplace').show(),$('#saveBplaceBtn,#closeBplaceBtn').show(),$(this).hide()"></i>

                                    <i id="saveBplaceBtn"
                                        class="fa fa-save pointer ms-2"
                                        style="display:none"
                                        onclick="$('#editVal').val($('#Bplace').val()),editInfo('sprp_bplace','gs_spr_profile','sprp_st_id',0)"></i>

                                    <i id="closeBplaceBtn"
                                        class="fa fa-times pointer text-danger ms-2"
                                        style="display:none"
                                        onclick="$('#Bplace_span').show(),$('#Bplace').hide(),$('#editBplaceBtn').show(),$('#saveBplaceBtn,#closeBplaceBtn').hide()"></i>
                                </div>

                            </dd>
                        </dl>


                        <!-- ⚠️ Repeat same converted pattern for your remaining fields
   (Nationality, Religion, Parents, Contact, etc.)
   Only layout changed — your JS kept intact
-->

                    </div>


                    <!-- ================= RIGHT COLUMN ================= -->
                    <div class="col-lg-6">

                        <h5 class="fw-bold mb-3">School Information</h5>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">LRN:</dt>
                            <dd class="col-sm-8">
                                <span id="lrn_span">
                                    <?php echo strtoupper($student->sprp_lrn != '' ? $student->st_id : 'not set'); ?>
                                </span>
                            </dd>
                        </dl>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">School Name:</dt>
                            <dd class="col-sm-8">
                                <?php echo strtoupper($student->school_name) ?>
                            </dd>
                        </dl>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">School ID:</dt>
                            <dd class="col-sm-8">
                                <?php echo strtoupper($student->school_id) ?>
                            </dd>
                        </dl>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">District:</dt>
                            <dd class="col-sm-8">
                                <?php echo strtoupper($student->district); ?>
                            </dd>
                        </dl>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">Division:</dt>
                            <dd class="col-sm-8">
                                <?php echo strtoupper($student->division); ?>
                            </dd>
                        </dl>

                        <dl class="row dl-grid">
                            <dt class="col-sm-4">Region:</dt>
                            <dd class="col-sm-8">
                                <?php echo strtoupper($student->region); ?>
                            </dd>
                        </dl>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ================= F137 CONTENT ================= -->
    <div class="col-12 mt-3">
        <?php echo Modules::run('f137/generateF137', base64_encode($student->st_id), $dataSY, segment_5, $student->grade_level_id) ?>
    </div>


    <!-- ================= BS5 MODAL ================= -->
    <div class="modal fade" id="createnew" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">

                <div class="modal-body text-center">

                    <div class="alert alert-success">
                        Are you sure you want to Create a New Record?
                    </div>

                    <button class="btn btn-success btn-sm me-2"
                        onclick="createNewRecord()"
                        data-bs-dismiss="modal">YES</button>

                    <button class="btn btn-danger btn-sm"
                        data-bs-dismiss="modal">NO</button>

                </div>

            </div>
        </div>
    </div>

</div>

<input type="hidden" id="skulYR" value="<?php echo segment_5 ?>" />
<input type="hidden" id="editVal" />
<input type="hidden" id="sprid" value="<?php echo $student->spr_id ?>" />
<input type="hidden" id="uid" value="<?php echo $student->u_id ?>" />
<input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
<input type="hidden" id="pgLevel" value="<?php echo $student->grade_level_id ?>" />
<input type="hidden" id="strand_id" value="<?php echo $student->strandid ?>" />
<input type="hidden" id="sySelected" />
<input type="hidden" id="levelSelected" />
<input type="hidden" id="selectedSprid" />
<input type="hidden" id="dbExist" />
<input type="hidden" id="eligField" />
<?php
$subject['subjects'] = $subjects;
$this->load->view('inputManually', $subject);
//echo $this->load->view('uploadAcadRecords');
echo $this->load->view('actionOption');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#addedSubjects").select2({
            tags: [<?php
                    foreach ($subjects as $s) {
                        echo '"' . $s->subject . '",';
                    }
                    ?>]
        });
        $("#addedSHSubjects").select2({
            tags: [<?php
                    foreach ($subject as $s) {
                        echo '"' . $s->subject . '",';
                    }
                    ?>]
        });

        $("#inputGrade").select2();
        $('#dcms_tab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'f137/displayCredentialPresented/' ?>' + $('#st_id').val() + '/' + $('#elemSY').val(),
            success: function(data) {
                $('#credPresented').html(data);
            }
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'f137/getEligibilityInfo/' ?>' + $('#st_id').val() + '/' + $('#elemSY').val(),
            dataType: 'json',
            success: function(data) {
                $('#sch_name').text(data.school_name);
                $('#sch_sid').text(data.sch_id);
            }
        });
    });

    function displaySchoolList() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'f137/displaySchoolList/' ?>' + $('#elemSY').val(),
            success: function(data) {
                $('#schoolList').html(data);
            }
        });
    }

    function updateSchoolInfo(field) {
        var value = $('#schoolList').val();
        var sy = $('#elemSY').val();
        var stid = $('#st_id').val();
        alert(field + ' ' + value + ' ' + sy + ' ' + stid);
        var url = '<?php echo base_url() . 'f137/updateEligibility' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'stid=' + stid + '&field=' + field + '&value=' + value + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                location.reload();
            }
        });

    }

    function loadStudentDetails(st_id, status, year, level) {
        var url = '<?php echo base_url() . 'f137/getPersonalInfo/' ?>' + st_id + '/' + status + '/' + year + '/' + level;
        document.location = url;
    }

    function search(value) {
        var sy = $('#inputSchoolYear').val();
        var url = '<?php echo base_url() . 'f137/searchStudent/' ?>' + value + '/' + sy;
        //        alert(url);
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                $('#searchName').show();
                $('#searchName').html(data);
            }
        });

        return false;
    }

    function editAcad(span, edit, save, input, close, grade, opt) {
        switch (opt) {
            case '1':
                $('#' + span + grade).hide();
                $('#' + edit + grade).hide();
                $('#' + save + grade).show();
                $('#' + input + grade).show();
                $('#' + close + grade).show();
                break;
            case '2':
                $('#' + span + grade).show();
                $('#' + edit + grade).show();
                $('#' + save + grade).hide();
                $('#' + input + grade).hide();
                $('#' + close + grade).hide();
                break;
        }
    }

    function editSchoolInfo(newVal, field, tbl_name, sy, id, owner, primary_key, st_id, sch_id) {
        var url = "<?php echo base_url() . 'f137/editSchoolInfo/' ?>";
        //        alert(newVal + ' ' + owner + ' ' + sy + ' ' + field + ' ' + tbl_name + ' ' + sch_id + ' ' + id);
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'newVal=' + newVal + '&owner=' + owner + '&sy=' + sy + '&field=' + field + '&tbl_name=' + tbl_name + '&id=' + id + '&primary_key=' + primary_key + '&st_id=' + st_id + '&sch_id=' + sch_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload();
                //window.location.href = '<?php // echo base_url() . 'reports/reports_f137/getPersonalInfo/' . base64_encode($student->st_id) . '/1/' . $student->school_year                                                                               
                                            ?>';
            }
        });
    }

    function editInfo(field, tbl_name, stid) {
        var newVal = $('#editVal').val();
        var owner = $('#st_id').val();
        var sy = $('#skulYR').val();
        //        alert(newVal + ' ' + owner + ' ' + sy + ' ' + field + ' ' + tbl_name + ' ' + stid);
        var url = "<?php echo base_url() . 'f137/editInfo/' ?>"; // + sem; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'newVal=' + newVal + '&owner=' + owner + '&sy=' + sy + '&field=' + field + '&tbl_name=' + tbl_name + '&stid=' + stid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload();
                //window.location.href = '<?php // echo base_url() . 'reports/reports_f137/getPersonalInfo/' . base64_encode($student->st_id) . '/1/' . $student->school_year                                                                               
                                            ?>';
            }
        });

        return false;
    }
    //
    function editAddressInfo() {
        var street = $('#street').val();
        var brgy = $('#barangay').val();
        var city = $('#city').val();
        var province = $('#inputPID').val();
        var user_id = $('#address_user_id').val();
        var zip_code = $('#zip_code').val();
        var is_home = $('#is_home').val();
        var sy = $('#gsYr').val();
        var schID = $('#schID').val();
        var add_id = $('#address_id').val();
        var url = '<?php echo base_url() . 'f137/editAddressInfo' ?>';

        $.ajax({
            type: 'POST',
            data: 'street=' + street + '&brgy=' + brgy + '&city=' + city + '&province=' + province + '&zip_code=' + zip_code + '&user_id=' + user_id + '&is_home=' + is_home + '&sy=' + sy + '&schID=' + schID + '&add_id=' + add_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function(data) {
                location.reload();
            }
        });
    }

    function getProvince(value) {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#inputProvince').val(data.name)
                $('#inputPID').val(data.id)
            }
        })
    }

    function addSchool() {
        var nSchool = $('#nameSchool').val();
        var idSchool = $('#idSchool').val();
        var street = $('#street').val();
        var brgy = $('#barangay').val();
        var city = $('#city').val();
        var province = $('#inputPID').val();
        var sy = $('#elemSY').val();

        $.ajax({
            type: 'POST',
            data: 'school_name=' + nSchool + '&idSchool=' + idSchool + '&street=' + street + '&brgy=' + brgy + '&city=' + city + '&province=' + province + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: '<?php echo base_url() . 'f137/addSchool' ?>',
            success: function(data) {

            }
        });
    }

    function fetchRec(grade_id, sy, msg, mes, bid, addR) {
        var spr_id = $('#sprid').val();
        var st_id = $('#st_id').val();
        var strand = $('#strand_id').val();
        // alert(grade_id + ' ' + sy + ' ' + strand);
        var url = '<?php echo base_url() . 'f137/fetchAcadRecord' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),
                st_id: st_id,
                spr_id: spr_id,
                grade_level: grade_id,
                sy: sy,
                strand_id: strand
            },
            dataType: 'json',
            beforeSend: function() {
                $(msg).show();
            },
            success: function(data) {
                if (data.status) {
                    location.reload();
                } else {
                    $(bid).show();
                    $(msg).hide();
                    $(mes).text(data.msg);
                    $(addR).show();
                }
            }
        });

    }
    //
    function createNewRecord() {
        var url = "<?php echo base_url() . 'f137/newRecord/' ?>";
        var sy = $('#sySelected').val();
        var stid = $('#st_id').val();
        var sprid = $('#sprid').val();
        var gLevel = $('#levelSelected').val();
        var lastSYen = '<?php echo segment_5 ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),
                spr_id: sprid,
                st_id: stid,
                school_year: sy,
                lastSYen: lastSYen,
                current_year: '<?php echo $this->sesion->school_year ?>',
                grade_level_id: gLevel
            },
            beforeSend: function() {
                showLoading('createNewBody');
            },
            success: function(data) {
                location.reload();
            }
        });
    }

    function saveSubjects() {
        var addSubjects = $('#addedSubjects').val();
        var sy = $('#sySelected').val();
        var stid = $('#st_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'f137/addSubjects' ?>',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&addSubjects=' + addSubjects + '&sy=' + sy + '&stid=' + stid,
            success: function(data) {
                location.reload();
            }
        });
    }

    function printOpt(level) {
        if (level >= 2 && level <= 7) {
            printForm(1);
        } else {
            $('#printOpt').modal('show');
        }
    }

    function printForm(val) {
        var url = "<?php echo base_url() . 'f137/printF137/' ?>" + $('#st_id').val() + '/' + <?php echo segment_5 ?> + '/' + val;
        //        alert(url);
        $('#printOpt').modal('hide');
        window.open(url, '_blank');
    }

    function deleteArec(subj_id) {
        var id = $('#selectedSprid').val();
        var sy = $('#sySelected').val();
        //        alert(id + ' ' + sy + ' ' + subj_id);
        var del = confirm('Are you sure you want to delete the Academic Records?');

        if (del == true) {
            var url = '<?php echo base_url() . 'f137/deleteRec' ?>';

            $.ajax({
                type: 'POST',
                url: url,
                data: 'id=' + id + '&sy=' + sy + '&subj_id=' + subj_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                dataType: 'json',
                beforeSend: function() {
                    showLoading('createNewBody');
                },
                success: function(data) {
                    if (data.status) {
                        alert(data.msg);
                    } else {
                        alert(data.msg);
                    }
                    location.reload();
                }
            });
        }
    }

    function checkBox(id, sy, field, stid) {
        if ($('#box_' + id).is(':checked')) {
            var opt = 1;
        } else {
            var opt = 0;
        }

        var url = '<?php echo base_url() . 'f137/updateCheckBox' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'stid=' + stid + '&field=' + field + '&opt=' + opt + '&sy=' + sy + '&certp=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {

            }
        });
    }
</script>