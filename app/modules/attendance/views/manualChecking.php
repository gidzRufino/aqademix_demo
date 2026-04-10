<style>
    .attendance-page {
        background: radial-gradient(circle at top left, #f0f5ff 0, #f7f9fc 40%, #eef2f7 100%);
        padding: 10px 10px 25px;
        border-radius: 12px;
    }

    .attendance-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .attendance-title {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2933;
        letter-spacing: 0.02em;
    }

    .attendance-subtitle {
        color: #6b7280;
        font-size: 12px;
        margin-top: 3px;
    }

    .attendance-header-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 5px;
    }

    .attendance-date-group .input-group-addon,
    .attendance-date-group .btn,
    .attendance-date-group input {
        border-radius: 999px !important;
    }

    .attendance-date-group input {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-color: #d1d5db;
        box-shadow: none;
    }

    .attendance-date-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .attendance-page .btn-success {
        border-radius: 999px;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        border: none;
    }

    .attendance-page .btn-success .fa {
        font-size: 14px;
    }

    .attendance-widget-strip {
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .attendance-widget-strip > .panel {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .attendance-panel {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
        background: #ffffff;
        margin-top: 5px;
    }

    .attendance-panel-header {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        padding: 8px 15px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .attendance-panel-body {
        padding: 8px 10px 10px;
        background: #ffffff;
    }

    .attendance-page table.table {
        margin-bottom: 5px;
        background: #ffffff;
    }

    .attendance-page table.table > thead > tr > th,
    .attendance-page table.table > tbody > tr > td {
        vertical-align: middle;
        font-size: 12px;
    }

    .attendance-page h6 {
        font-weight: 600;
        color: #111827;
    }

    .attendance-status-header {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
    }

    .attendance-status-header strong {
        color: #111827;
    }

    .attendance-rem-cta {
        font-size: 10px !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #2563eb;
    }

    .attendance-rem-cta:hover {
        color: #1d4ed8;
    }

    @media (max-width: 767px) {
        .attendance-page {
            padding: 5px;
        }

        .attendance-header {
            align-items: flex-start;
        }

        .attendance-header-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .attendance-title {
            font-size: 20px;
        }
    }

    /* Hover lift effect */
.hover-shadow:hover {
    transform: translateY(-4px);
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.attendance-row:hover {
    background-color: #f8f9fa;
}

.pointer {
  cursor: pointer;
  pointer-events: auto;
}

.badge {
    font-weight: 500;
}

</style>
<div class="attendance-page p-3 p-lg-4 rounded-3 bg-light">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
            <h2 class="attendance-title mb-1">Manual Attendance</h2>
            <p class="attendance-subtitle mb-0">Review, search, and update attendance records for your section.</p>
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            <div class="input-group rounded-pill shadow-sm" style="overflow:hidden;">
                <input type="hidden" id="section_id" value="<?php echo $section_id; ?>" />
                <input type="text" class="form-control border-end-0" style="height:38px;" name="inputBdate"
                    data-date-format="yyyy-mm-dd" value="<?= $date != null ? $date : date('Y-m-d'); ?>" id="inputBdate" placeholder="Search for Date" required>
                <button class="btn btn-success" onclick="searchAttendance($('#inputBdate').val())" title="Search attendance by date">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <button class="btn btn-success shadow-sm" onclick="getAttendanceProgress('<?php echo $section_id; ?>', '', '')" title="View monthly attendance progress">
                <i class="fa fa-line-chart"></i>
            </button>
        </div>
    </div>

    <input type="hidden" id="selectStudentIds" name="selectStudentId" />

    <!-- Attendance Widget / Table -->
    <div id="attendanceSearchResult">

        <?php if ($this->session->userdata('is_admin')): ?>
            <?php if ($this->uri->segment(3) != NULL): ?>
                <!-- Manual Attendance List -->
                <div class="card shadow-sm mb-4 border-0">
                    <!-- Header -->
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-user-check fs-5"></i>
                            <div>
                                <div class="fw-semibold">Manual Attendance</div>
                                <small class="opacity-75">Mark present students & add remarks</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="w-50">Present Students</th>
                                        <th class="w-50">Absent Students</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <!-- PRESENT -->
                                        <td class="p-0">
                                            <?php if($records->num_rows() > 0): ?>
                                            <table class="table table-hover table-sm mb-0 align-middle">
                                                <thead class="table-secondary small text-uppercase">
                                                    <tr>
                                                    <th style="width:5%; text-align: center;"><h6 id="att_total" style="margin:0px;"><?php echo $records->num_rows() ?></h6></th>
                                                        <th>Student Name</th>
                                                        <th class="text-start">
                                                            Remarks
                                                            <button
                                                                class="btn btn-outline-primary btn-sm rounded-pill float-end"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#attendanceRemarkModal"
                                                            >
                                                                <i class="fa fa-plus me-1"></i> Remark
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody id="attendanceResult">
                                                    <?php foreach ($records->result() as $row):
                                                        $remarks = Modules::run('attendance/getAttendanceRemark', $row->st_id, $row->date); ?>
                                                        <tr
                                                            id="<?php echo $row->user_id; ?>_tr"
                                                            class="attendance-row"
                                                            onmouseenter="$('#delete_<?php echo $row->user_id ?>').show()"
                                                            onmouseleave="$('#delete_<?php echo $row->user_id ?>').hide()"
                                                        >
                                                            <td class="text-center">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="radio"
                                                                    name="remarksRadio"
                                                                    onclick="getMe('<?php echo $row->st_id; ?>')"
                                                                >
                                                            </td>

                                                            <td class="text-start">
                                                                <a class="fw-semibold text-decoration-none"
                                                                href="<?php echo base_url(); ?>registrar/viewDetails/<?php echo base64_encode($row->st_id) ?>">
                                                                    <?php echo strtoupper($row->lastname . ', ' . $row->firstname); ?>
                                                                </a>
                                                            </td>

                                                            <td class="text-start">
                                                                <span class="badge bg-info-subtle text-dark">
                                                                    <?php echo $remarks->row()->category_name; ?>
                                                                </span>

                                                                <?php if ($remarks->row()->remarks != 0): ?>
                                                                    <small class="d-block text-muted mt-1">
                                                                        Remark by:
                                                                        <a href="<?php echo base_url().'hr/viewTeacherInfo/'.base64_encode($remarks->row()->remarks_from) ?>">
                                                                            <?php echo $remarks->row()->remarks_from; ?>
                                                                        </a>
                                                                    </small>
                                                                <?php endif; ?>

                                                                <i
                                                                    class="fa fa-trash text-danger float-end pointer"
                                                                    style="display:none"
                                                                    id="delete_<?php echo $row->user_id; ?>"
                                                                    onclick="deleteAttendance('<?php echo $row->att_id ?>','<?php echo $row->st_id ?>')"
                                                                    title="Remove attendance"
                                                                ></i>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php endif; ?>
                                        </td>

                                        <!-- ABSENT -->
                                        <td class="bg-light">
                                            <div class="p-3">
                                                <?php echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto'), $date); ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div id="attPerformance" class="row g-4">
                    <?php foreach ($section->result() as $sec):
                        $date = $date != null ? $date : date('Y-m-d');
                        $data = ['date' => $date, 'section' => $sec->section_id, 'grade' => $sec->grade_id];
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="card shadow-sm h-100 border-0 pointer hover-shadow" 
                            onclick="//getAttendanceProgress('<?= $sec->section_id ?>','<?= strtoupper($sec->level) ?>','<?= strtoupper($sec->section) ?>')">
                            
                            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                <i class="fa fa-chart-line fs-5"></i>
                                <span class="fw-semibold small text-uppercase">Attendance &mdash; <?= strtoupper($sec->level) ?> - <?= strtoupper($sec->section) ?></span>
                            </div>
                            
                            <div class="card-body p-3">
                                <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data); ?>
                            </div>
                            
                            <div class="card-footer bg-light text-center py-2">
                                <a href="<?= base_url(); ?>attendance/dailyPerSubject/NULL/<?= $sec->section_id ?>/<?= $date ?>" class="text-decoration-none fw-semibold small">
                                    <?= strtoupper($sec->level) ?> - <?= strtoupper($sec->section) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Non-admin view -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-user-check me-2"></i> Manual Attendance List
                </div>
                <div class="card-body p-3">
                    <!-- Table same as above (reuse table structure) -->
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
  const popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );

  popoverTriggerList.forEach(function (popoverTriggerEl) {
    new bootstrap.Popover(popoverTriggerEl, {
      container: 'body',
      trigger: 'click',
      html: true
    });
  });
});
    function getAttendanceProgress(id, level, section) {
        $('#levelSection').html(level + ' - ' + section);
        $('#attendanceProgress').modal('show');
        var url = '<?php echo base_url() . 'attendance/getApGraph/' ?>'
        $.ajax({
            type: "POST",
            url: url,
            data: 'section_id=' + id + "&date=" + $('#inputBdate').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {
                showLoading('apGraph');
            },
            success: function(data) {
                $('#apGraph').html(data);

            }
        });
    }

    function getMe(id) {
        //document.getElementById(id).style.background='#9F9F9F'
        document.getElementById("selectStudentIds").value = id;

    }

    function saveAttendance(st_id, rfid) {
        var date = $('#inputBdate').val();
        var url = "<?php echo base_url() . 'attendance/saveAttendanceManually/' ?>"; // the script where you handle the form input.
        $("#h6_" + st_id).fadeOut();
        var att_total = $('#att_total').html();
        var totalAtt = parseInt(att_total) + parseInt(1);
        $('#att_total').html(totalAtt);
        $.ajax({
            type: "POST",
            url: url,
            data: "id=" + rfid + "&section_id=" + '<?php echo ($section_id == "" ? 0 : $section_id); ?>' + '&st_id=' + st_id + '&date=' + date + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {
                if (st_id == '0') {
                    showLoading('presentStudents');
                }
            },
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                if (st_id == '0') {
                    location.reload();
                } else {
                    //  stopLoading('presentStudents')
                    $('#attendanceResult').html(data);
                }

            }
        });

        return false;
    }


    function searchAttendance(date) {
        var url = "<?php echo base_url() . 'attendance/searchAttendance' ?>"; // the script where you handle the form input.
        var section_id = $('#section_id').val();
        $.ajax({
            type: "POST",
            url: url,
            data: "date=" + date + "&section_id=" + section_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {
                showLoading('attendanceSearchResult');
            },
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                $('#attPerformance').fadeIn(5000);
                $('#attendanceSearchResult').html(data);
            }
        });

        return false;
    }

    function saveSearchAttendance(user_id, rfid) {
        var url = "<?php echo base_url() . 'attendance/saveSearchAttendance' ?>"; // the script where you handle the form input.
        var date = $('#inputBdate').val()
        $("#h6_" + user_id).fadeOut();
        $.ajax({
            type: "POST",
            url: url,
            data: "id=" + rfid + "&section_id=" + '<?php echo ($section_id == "" ? 0 : $section_id); ?>' + "&user_id=" + user_id + "&date=" + date + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                $('#attendanceResult').html(data);
                //location.reload();
            }
        });

        return false;
    }

    function saveAttendanceRemarks() {
        var url = "<?php echo base_url() . 'attendance/saveAttendanceRemark' ?>";
        var remark = $('#inputRemark').val()
        var st_id = $('#selectStudentIds').val()
        var date = $('#inputBdate').val()
        var remark_from = "<?php echo $this->session->userdata('username') ?>"
        $.ajax({
            type: "POST",
            url: url,
            data: "date=" + date + "&st_id=" + st_id + "&remark=" + remark + "&remark_from=" + remark_from + "&section_id=" + '<?php echo ($section_id == "" ? 0 : $section_id); ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()

                $('#attendanceResult').html(data);
            }
        });
        return false;
    }


    function deleteAttendance(id, st_id) {
        var date = $('#inputBdate').val();
        var url = "<?php echo base_url() . 'attendance/deleteAttendance' ?>"; // the script where you handle the form input.
        var att_total = $('#att_total').html();
        var totalAtt = parseInt(att_total - 1);
        $('#att_total').html(totalAtt);
        $("#" + st_id + "_tr").fadeOut();
        $.ajax({
            type: "POST",
            url: url,
            data: "att_id=" + id + '&date=' + date + '&st_id=' + st_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {
                showLoading('attendanceSearchResult');
            },
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                location.reload();
            }
        });
        return false;
    }
</script>