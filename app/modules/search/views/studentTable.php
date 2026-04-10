<?php $access = $this->session->userdata('position_id'); ?>
<table class="table table-hover align-middle mb-0" style="font-size:14px;">

    <thead class="table-light">
        <tr class="text-center">
            <th>Student</th>
            <th>User ID</th>
            <th>Grade</th>
            <th>Section</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Remarks</th>

            <?php if (in_array($access, [1, 2, 43, 49]) || $this->session->userdata('position') === 'Admin Officer'): ?>
                <th style="min-width:160px;">Actions</th>
                <th>School Year</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($students as $s):
            $nxt_lvl = Modules::run('registrar/getlevelByOrder', ($s->order == 15 ? $s->order : ($s->order + 1)));
            $name = strtoupper($s->firstname . ' ' . $s->lastname);
        ?>
            <tr class="text-center">

                <!-- ===== Student Column (Avatar + Name) ===== -->
                <td class="text-start">
                    <div class="d-flex align-items-center gap-3">
                        <?php
                        $avatar = ($s->avatar && file_exists('uploads/' . $s->avatar))
                            ? 'uploads/' . $s->avatar
                            : 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png');
                        ?>

                        <img src="<?= base_url($avatar) ?>"
                            class="rounded-circle border"
                            style="width:48px; height:48px; object-fit:cover;">

                        <div>
                            <div class="fw-semibold"
                                style="cursor:pointer"
                                onclick="document.location='<?= base_url('registrar/viewDetails/' . base64_encode($s->uid)) ?>/'">
                                <?= strtoupper($s->lastname) ?>,
                            </div>
                            <small class="text-muted">
                                <?= strtoupper($s->firstname . ' ' . $s->middlename) ?>
                            </small>
                        </div>
                    </div>
                </td>

                <!-- ===== User ID ===== -->
                <td>
                    <a class="fw-semibold text-decoration-none"
                        href="<?= base_url('registrar/viewDetails/' . base64_encode($s->uid)) ?>">
                        <?= $s->uid ?: $s->user_id ?>
                    </a>
                </td>

                <!-- ===== Grade ===== -->
                <td>
                    <span class="badge bg-primary-subtle text-primary">
                        <?= $s->level ?>
                    </span>
                </td>

                <!-- ===== Section ===== -->
                <td>
                    <span class="badge bg-info-subtle text-info">
                        <?= $s->section ?>
                    </span>
                </td>

                <!-- ===== Gender ===== -->
                <td>
                    <span class="badge bg-secondary">
                        <?= $s->sex ?>
                    </span>
                </td>

                <!-- ===== Status ===== -->
                <td>
                    <a href="#adminRemarks" data-bs-toggle="modal">
                        <img onclick="getRemarks('<?= $s->st_id ?>','<?= $s->user_id ?>')"
                            src="<?= base_url($s->status ? 'images/official.png' : 'images/unofficial.png') ?>"
                            style="width:22px; cursor:pointer;">
                    </a>
                </td>

                <!-- ===== Remarks ===== -->
                <td class="text-start"
                    onmouseout="$('#delete_<?= $s->uid ?>').hide()"
                    onmouseover="$('#delete_<?= $s->uid ?>').show()">

                    <?php
                    $remarks = Modules::run('main/getAdmissionRemarks', $s->uid, NULL, $s->school_year);
                    if ($remarks->num_rows() > 0):
                        echo $remarks->row()->code . ' ' .
                            $remarks->row()->remarks . ' - ' .
                            $remarks->row()->remark_date;
                    ?>
                        <button id="delete_<?= $s->uid ?>"
                            type="button"
                            class="btn-close btn-sm ms-2"
                            style="display:none"
                            onclick="deleteAdmissionRemark('<?= $s->uid ?>',<?= $remarks->row()->code_indicator_id ?>)">
                        </button>
                    <?php endif; ?>
                </td>

                <!-- ===== Actions ===== -->
                <?php if (in_array($access, [1, 2, 43, 49]) || $this->session->userdata('position') === 'Admin Officer'): ?>
                    <td>
                        <div class="d-flex justify-content-center gap-1 flex-wrap">

                            <?php if (!$s->rfid || $s->rfid === "NULL"): ?>
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addId"
                                    onclick="showAddRFIDForm('<?= $s->u_id ?>','RFID', '<?= $name ?>')">
                                    Add RFID
                                </button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addId"
                                    onclick="showAddRFIDForm('<?= $s->u_id ?>','<?= $s->rfid ?>', '<?= $name ?>')">
                                    Edit RFID
                                </button>
                            <?php endif; ?>

                            <button class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteIDConfirmation"
                                onclick="showDeleteConfirmation('<?= $s->uid ?>','<?= $s->psid ?>')">
                                Delete
                            </button>
                            <button class="btn btn-sm btn-outline-success"
                                data-bs-toggle="modal"
                                data-bs-target="#rollOver"
                                onclick="
                            $('#ro_st_id').val('<?= $s->uid ?>');
                                    $('#curr_grade_id').val('<?= $s->grade_id ?>');
                                    $('#ro_grade_id').val('<?= $nxt_lvl->grade_id ?>');
                                    $('#curr_lDesc').html('<?= $s->level ?>');
                                    $('#stName').html('<?= $name ?>');
                                    $('#new_lDesc').html('<?= $nxt_lvl->level ?>');">
                                Roll Over
                            </button>
                        </div>
                    </td>

                    <!-- ===== School Year ===== -->
                    <td>
                        <span class="badge bg-dark">
                            <?= $s->school_year ?> - <?= $s->school_year + 1 ?>
                        </span>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<script type="text/javascript">
    var admission_id = 0;

    // function setRO(grade_id, section_id)
    // {
    //     alert('test')
    //     var x
    //     var grade
    //     var curr_grade = $('#curr_grade_id').val()
    //     var loop = parseInt(curr_grade) - 10;
    //     for (x = 0; x <= loop; x++) {
    //         grade = 10 + x;
    //         //alert(grade)
    //         $('#tr_' + grade).attr('style', 'background:#BCBCBC;')
    //     }
    //     var prevSec = $('#ro_prev_sec_selected').val()
    //     var badge = $('#badge_' + section_id).html()
    //     var indicator = $('#ro_badgeIndicator').val()
    //     $('#ro_grade_id').val(grade_id)
    //     $('#ro_section_id').val(section_id)
    //     if (indicator < 1) {
    //         $('#badge_' + section_id).html(parseInt(badge) + 1)
    //         $('#ro_badgeIndicator').val(1)
    //         $('#td_' + section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
    //     } else {
    //         if (prevSec != section_id) {
    //             $('#badge_' + section_id).html(parseInt(badge) + 1)
    //             $('#badge_' + prevSec).html(parseInt($('#badge_' + prevSec).html()) - 1)
    //             $('#td_' + prevSec).attr('style', 'background:#C1FFF9; border:1px solid gray;')
    //             $('#td_' + section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
    //         }
    //     }
    //     $('#ro_prev_sec_selected').val(section_id);
    // }

    function setRO(grade_id, section_id) {
        alert('test')
        if (section_id != 0) {
            var x
            var grade
            var curr_grade = $('#curr_grade_id').val()
            var loop = parseInt(curr_grade) - 10;
            for (x = 0; x <= loop; x++) {
                grade = 10 + x;
                alert(grade)
                $('#tr_' + grade).attr('style', 'background:#BCBCBC;')
            }
            var prevSec = $('#ro_prev_sec_selected').val()
            var badge = $('#badge_' + section_id).html()
            var indicator = $('#ro_badgeIndicator').val()
            $('#ro_grade_id').val(grade_id)
            $('#ro_section_id').val(section_id)
            if (indicator < 1) {
                $('#badge_' + section_id).html(parseInt(badge) + 1)
                $('#ro_badgeIndicator').val(1)
                $('#td_' + section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
            } else {
                if (prevSec != section_id) {
                    $('#badge_' + section_id).html(parseInt(badge) + 1)
                    $('#badge_' + prevSec).html(parseInt($('#badge_' + prevSec).html()) - 1)
                    $('#td_' + prevSec).attr('style', 'background:#C1FFF9; border:1px solid gray;')
                    $('#td_' + section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
                }
            }
            $('#ro_prev_sec_selected').val(section_id);
        } else {
            var x
            var grade
            var curr_grade = $('#curr_grade_id').val()
            var loop = parseInt(curr_grade) - 10;
            alert(loop);
            for (x = 0; x <= loop; x++) {
                grade = 10 + x;
                alert(grade)
                $('#tr_' + grade).attr('style', 'background:#BCBCBC;')
            }
        }
    }

    function saveRO() {
        var sem = ($('#semRoll').is(':checked') ? 3 : 0);
        var grade_id = $('#ro_grade_id').val();
        var section_id = $('#ro_section_id').val()
        var st_id = $('#ro_st_id').val()
        var school_year = $('#inputSY').val()
        // var str_id = $('#ro_strand').val()
        var str_id = 0;

        var url = "<?php echo base_url() . 'registrar/saveOnlineRO/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "grade_id=" + grade_id + '&section_id=' + section_id + '&st_id=' + st_id + '&str_id=' + str_id + '&school_year=' + school_year + '&sem=' + sem + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data.remarks);
                location.reload()
                //console.log(data)
            }
        });

        return false;
    }

    function getSection(grade_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + grade_id; // the script where you handle the form input.

        $.ajax({
            type: "GET",
            url: url,
            data: "grade_id=" + grade_id, // serializes the form's elements.
            success: function(data) {
                // location.reload()
                $('#ro_grade_id').val(grade_id)
                $('#ro_section_id').html(data);
            }
        });

        return false;

    }

    function search(value) {
        var sy = $('#inputSY').val();
        var option = $('#searchOption').val()
        $('#verify_icon').removeClass('fa-search')
        $('#verify_icon').addClass('fa-spinner fa-spin');
        if (option == 'profile_students_admission.grade_level_id') {
            var url = '<?php echo base_url() . 'search/getStdByGradeLevel/' ?>' + option + '/' + value + '/' + sy;
        } else {
            url = '<?php echo base_url() . 'search/getStudents/' ?>' + option + '/' + value + '/' + sy;
        }

        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                if (data != "") {
                    $('#studentTable').html(data)
                    $('#verify_icon').removeClass('fa-spinner fa-spin')
                    $('#verify_icon').addClass('fa-search');
                } else {

                }


            }
        });

        return false;
    }



    function getSearchOption(value) {
        switch (value) {
            case 'profile_students_admission.grade_level_id':
                $('#grade').show()
                $('#searchBox').hide();
                $('#section').hide()
                break;
            case 'profile_students_admission.section_id':
                $('#section').show();
                $('#grade').hide();
                $('#searchBox').hide();
                break;
            default:
                $('#grade').hide()
                $('#section').hide()
                $('#searchBox').show();
                break;
        }
    }



    function printId(section_id, id, frontBack, pageID) {
        if (frontBack == 'printIdCardBack') {
            var limit = 4;

        } else {
            limit = 8;
        }
        document.getElementById(id).href = '<?php echo base_url() . 'registrar/' ?>' + frontBack + '/' + section_id + '/' + limit + '/' + pageID
    }

    function showDeleteConfirmation(st_id, psid, adm_id) {
        //alert(psid)
        admission_id = adm_id
        $('#stud_id').val(psid)
        $('#adm_id').val(adm_id)
        $('#sp_stud_id').html(st_id)
        document.getElementById("user_id").focus()
    }

    function deleteROStudent() {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val();
        var adm_id = $('#adm_id').val();
        var sy = $('#sy').val()
        var rsure = confirm("Are you Sure You Want to delete student ( " + st_id + " ) from the list?");
        if (rsure == true) {
            if ($('#deleteAll').is(":checked")) {

                var url = "<?php echo base_url() . 'registrar/deleteID/' ?>" + st_id;
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "st_id=" + st_id + "&user_id=" + user_id + '&adm_id=' + admission_id + '&school_year=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            alert(data.msg);
                            location.reload();
                        } else {
                            alert(data.msg);
                            location.reload();
                        }
                    }
                });

                return false;


            }
            var url = "<?php echo base_url() . 'registrar/deleteROStudent/' ?>" + st_id; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "st_id=" + st_id + "&user_id=" + user_id + '&sy=' + sy + '&adm_id=' + admission_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                //dataType: 'json',
                success: function(data) {
                    alert(data);
                    location.reload();
                    //console.log(data)
                }
            });

            return false;

        } else {
            location.reload();
        }

    }

    function getRemarks(st_id, user_id) {
        $('#st_id').val(st_id);
        $('#us_id').val(user_id);
    }

    function getStudentBySection(id) {
        var url = "<?php echo base_url() . 'registrar/getAllStudentsBySection/' ?>" + id
        document.location = url;
    }

    function getStudentByLevel(id) {
        var url = "<?php echo base_url() . 'registrar/getAllStudentsByGradeLevel/' ?>" + id + '/'; // the script where you handle the form input.
        document.location = url;

    }

    function getStudentByYear(id) {
        var url = "<?php echo base_url() . 'registrar/getStudentByYear/' ?>" + id + '/'; // the script where you handle the form input.
        document.location = url;

    }

    function deleteAdmissionRemark(st_id, code_id) {
        var url = "<?php echo base_url() . 'main/deleteAdmissionRemark/' ?>" + st_id + '/' + code_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "st_id=" + st_id, // serializes the form's elements.
            success: function(data) {
                location.reload()
                //$('#inputSection').html(data);
            }
        });

        return false;

    }

    function showAddRFIDForm(id, st_id, name) {
        $('#addId').show();
        $('#secretContainer').html($('#addId').html())
        $('#secretContainer').fadeIn(500)
        $('#stName').text(name)
        $('#stud_id').val(id)
        $("#inputCard").attr('placeholder', st_id);
        document.getElementById("inputCard").focus()
    }

    function updateProfile(pk, table, column) {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var pk_id = $('#stud_id').val();
        var value = $('#inputCard').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert('RFID Successfully Saved');
                location.reload();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    $(document).ready(function() {
        $("#inputGrade").select2({});
        $("#inputSection").select2();
        $("#inputSY").select2();

        if ($('#hiddenSection').val() != "") {
            $('#CSVExportBtn').show();
            var CSVUrl = "<?php echo base_url() . 'reports/exportToCsv/' ?>" + "Null" + '/' + $('#hiddenSection').val();
            <?php if ($this->session->userdata('is_superAdmin')): ?>
                document.getElementById('CSVExportBtn').href = CSVUrl
            <?php endif; ?>
        }


    });
</script>

<style>
    .table {
        font-size: 14px;
    }

    .table thead th {
        font-weight: 400;
    }
</style>