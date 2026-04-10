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
</style>
<div class="row attendance-page">
    <div class="col-lg-12">
        <div class="attendance-header clearfix">
            <div>
                <h2 class="attendance-title">Manual Attendance</h2>
                <p class="attendance-subtitle">
                    Review, search, and update attendance records for your section.
                </p>
            </div>
            <div class="attendance-header-actions">
                <div class="form-group input-group attendance-date-group">
                    <input type="hidden" id="section_id" value="<?php echo $section_id; ?>" />
                    <input style="height:34px;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d"); ?>" id="inputBdate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button class="btn btn-success" onclick="searchAttendance($('#inputBdate').val())" title="Search attendance by date">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <button class="btn btn-success" onclick="getAttendanceProgress('<?php echo $section_id; ?>', '', '')" title="View monthly attendance progress">
                    <i class="fa fa-line-chart"></i>
                </button>
            </div>
        </div>
        <input type="hidden" id="selectStudentIds" name="selectStudentId" />
    </div>

    <?php
    $teacher = $this->session->userdata('position');
    ?>
    <div class="col-lg-12 attendance-widget-strip" id="attendanceSearchResult">
        <?php
        if ($this->session->userdata('is_admin')):
            if ($this->uri->segment(3) != NULL):
        ?>
                <div class="attendance-panel">
                    <div class="attendance-panel-header">
                        <span><i class="fa fa-user-check"></i> Manual Attendance List</span>
                    </div>
                    <div class="attendance-panel-body">
                        <table id="presentStudents" align="center" class='table table-striped '>
                            <tr>
                                <td colspan="" style="text-align: center">
                                    <h6 class="attendance-status-header"><strong>Present</strong></h6>
                                </td>
                                <td colspan="" style="text-align: center; width:50%;">
                                    <h6 class="attendance-status-header"><strong>Absent</strong></h6>
                                </td>
                            </tr>

                            <tr>
                                <td id="attendanceResult" style="padding:0">
                                    <table style="width:100%; padding:0; margin:0;" align="center" class='table table-striped table-bordered'>
                                        <tr>
                                            <td style="width:5%; text-align: center;">
                                                <h6 id="att_total" style="margin:0px;"><?php echo $records->num_rows() ?></h6>
                                            </td>
                                            <td>Name of Student</td>
                                            <td>Remarks
                                                <a style="font-size:10px; float: right;" class="help-inline pull-right attendance-rem-cta"
                                                    rel="clickover"
                                                    data-content=" 
                                           <div style='width:100%;'>
                                           <h6>Add Attendance Remark</h6>

                                           <select name='inputRemark' id='inputRemark' class='' required>
                                           <option>Select Remark</option>                     
                                           <option value='1'>Late</option>                     
                                           <option value='2'>Cutting Classes</option>                     

                                           </select>
                                           <div style='margin:5px 0;'>
                                           <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                           <a href='#' id='Department' data-dismiss='clickover' onclick='saveAttendanceRemarks()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                                           </div>
                                           "
                                                    class="btn" data-toggle="modal" href="#"> ADD REMARK</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i = 1;
                                        //print_r($records);
                                        foreach ($records->result() as $row) {
                                            if ($this->session->userdata('attend_auto')):
                                                $remarks = Modules::run('attendance/getAttendanceRemark', $row->u_rfid, $row->date);
                                            else:
                                                $remarks = Modules::run('attendance/getAttendanceRemark', $row->st_id, $row->date);
                                            endif;
                                        ?>
                                            <tr id="<?php echo $row->user_id; ?>_tr" onmouseout="$('#delete_<?php echo $row->user_id ?>').hide()" onmouseover="$('#delete_<?php echo $row->user_id ?>').show()">
                                                <td style="padding:5px 0 5px 5px">
                                                    <?php if ($this->session->userdata('attend_auto')): ?>
                                                        <input id="<?php echo $row->user_id; ?>" name="remarksRadio" onclick="getMe('<?php echo $row->u_rfid; ?>')" type="radio" />
                                                    <?php else: ?>
                                                        <input id="<?php echo $row->user_id; ?>" name="remarksRadio" onclick="getMe('<?php echo $row->st_id; ?>')" type="radio" />
                                                    <?php endif; ?>
                                                </td>
                                                <td id="remarks_<?php echo $row->rfid ?>_td" style="padding:5px 0 5px 5px">
                                                    <h6 style="margin:0px; ">
                                                        <a id="<?php echo $row->user_id; ?>_name" href="<?php echo base_url(); ?>registrar/viewDetails/<?php echo base64_encode($row->st_id) ?>"><?php echo strtoupper($row->lastname . ', ' . $row->firstname) ?></a>

                                                    </h6>

                                                </td>

                                                <td>
                                                    <strong class="pull-left"><?php echo $remarks->row()->category_name ?></strong>
                                                    <?php if ($remarks->row()->remarks != 0): ?>
                                                        <strong class="pull-right">Remark Given By: <a href="<?php echo base_url() . 'hr/viewTeacherInfo/' . base64_encode($remarks->row()->remarks_from) ?>"><?php echo $remarks->row()->remarks_from ?></a></strong>
                                                    <?php endif; ?>
                                                    <i style="display:none;" id="delete_<?php echo $row->user_id ?>" class="fa fa-close pull-right pointer" onclick="deleteAttendance('<?php echo $row->att_id ?>', '<?php
                                                                                                                                                                                                                if ($row->u_rfid != ""): echo $row->user_id;
                                                                                                                                                                                                                else: echo $row->u_rfid;
                                                                                                                                                                                                                endif
                                                                                                                                                                                                                ?>')"></i>
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td>
                                    <?php echo Modules::run('attendance/getAbsents', $this->uri->segment(4), $this->session->userdata('attend_auto')); ?>

                                </td>


                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            else:
                foreach ($section->result() as $sec):
                    $data = array(
                        'date' => $date != null ? $date : date('Y-m-d'),
                        'section' => $sec->section_id,
                        'grade' => $sec->grade_id
                    );
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 col-12">';
                    echo '<div class="attendance-panel">';
                    echo '  <div class="attendance-panel-header">';
                    echo '      <span><i class="fa fa-chart-line"></i> Attendance Performance &mdash; ' . strtoupper($sec->level) . ' - ' . strtoupper($sec->section) . '</span>';
                    echo '  </div>';
                    echo '  <div class="attendance-panel-body">';
                    echo        Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data);
                    echo '  </div>';
                    echo '</div>';
                    echo '</div>';
                endforeach;
            endif;
        else:
            ?>

            <div class="attendance-panel">
                <div class="attendance-panel-header">
                    <span><i class="fa fa-user-check"></i> Manual Attendance List</span>
                </div>
                <div class="attendance-panel-body">
                    <table id="presentStudents" align="center" class='table table-striped '>
                        <tr>
                            <td colspan="" style="text-align: center">
                                <h6 class="attendance-status-header"><strong>Present</strong></h6>
                            </td>
                            <td colspan="" style="text-align: center; width:50%;">
                                <h6 class="attendance-status-header"><strong>Absent</strong></h6>
                            </td>
                        </tr>

                        <tr>
                            <td id="attendanceResult" style="padding:0">
                                <table style="width:100%; padding:0; margin:0;" align="center" class='table table-striped table-bordered'>
                                    <tr>
                                        <td style="width:5%; text-align: center;">
                                            <h6 id="att_total" style="margin:0px;"><?php echo $records->num_rows() ?></h6>
                                        </td>
                                        <td>Name of Student</td>
                                        <td>Remarks
                                            <a style="font-size:10px; float: right;" class="help-inline pull-right attendance-rem-cta"
                                                rel="clickover"
                                                data-content=" 
                                       <div style='width:100%;'>
                                       <h6>Add Attendance Remark</h6>

                                       <select name='inputRemark' id='inputRemark' class='' required>
                                       <option>Select Remark</option>                     
                                       <option value='1'>Late</option>                     
                                       <option value='2'>Cutting Classes</option>                     

                                       </select>
                                       <div style='margin:5px 0;'>
                                       <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                       <a href='#' id='Department' data-dismiss='clickover' onclick='saveAttendanceRemarks()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                                       </div>
                                       "
                                            class="btn" data-toggle="modal" href="#"> ADD REMARK</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($records->result() as $row) {
                                        $remarks = Modules::run('attendance/getAttendanceRemark', $row->st_id, $row->date);
                                    ?>
                                        <tr id="<?php echo $row->user_id; ?>_tr" onmouseout="$('#delete_<?php echo $row->user_id ?>').hide()" onmouseover="$('#delete_<?php echo $row->user_id ?>').show()">
                                            <td style="padding:5px 0 5px 5px">
                                                <?php if ($this->session->userdata('attend_auto')): ?>
                                                    <input id="<?php echo $row->user_id; ?>" name="remarksRadio" onclick="getMe('<?php echo $row->u_rfid; ?>')" type="radio" />
                                                <?php else: ?>
                                                    <input id="<?php echo $row->user_id; ?>" name="remarksRadio" onclick="getMe('<?php echo $row->st_id; ?>')" type="radio" />
                                                <?php endif; ?>
                                            </td>
                                            <td id="remarks_<?php echo $row->rfid ?>_td" style="padding:5px 0 5px 5px">
                                                <h6 style="margin:0px; ">
                                                    <a id="<?php echo $row->user_id; ?>_name" href="<?php echo base_url(); ?>registrar/viewDetails/<?php echo base64_encode($row->st_id) ?>"><?php echo strtoupper($row->lastname . ', ' . $row->firstname) ?></a>

                                                </h6>

                                            </td>

                                            <td>
                                                <strong class="pull-left"><?php echo $remarks->row()->category_name ?></strong>
                                                <?php if ($remarks->row()->remarks != 0): ?>
                                                    <strong class="pull-right">Remark Given By: <a href="<?php echo base_url() . 'hr/viewTeacherInfo/' . base64_encode($remarks->row()->remarks_from) ?>"><?php echo $remarks->row()->remarks_from ?></a></strong>
                                                <?php endif; ?>
                                                <i style="display:none;" id="delete_<?php echo $row->user_id ?>" class="fa fa-close pull-right pointer" onclick="deleteAttendance('<?php echo $row->att_id ?>', '<?php echo $row->st_id ?>')"></i>
                                                <!--<i style="display:none;" id="delete_<?php // echo $row->user_id 
                                                                                    ?>" class="fa fa-close pull-right pointer" onclick="deleteAttendance('<?php // echo $row->att_id 
                                                                                                                                                            ?>', '<?php // if ($row->u_rfid != ""): echo $row->user_id; else: echo $row->u_rfid; endif; 
                                                                                                                                                                                                ?>')"></i>-->
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>

                            <td>
                                <?php echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto')); ?>
                            </td>


                        </tr>
                    </table>
                </div>
            </div>

        <?php
        endif;
        ?>
    </div>

</div>

<div style="padding:0; margin:20px;" id="attendanceProgress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h4>Monthly Attendance Progress Report <i data-dismiss="modal" class="fa fa-close fa-fw pointer pull-right"></i><span id="levelSection" class="pull-right"></span> </h4>

        </div>
        <div id="apGraph" class="panel-body">

        </div>
    </div>
</div>
<script type="text/javascript">
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