<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-success pull-right" style="margin-top:5px; margin-left:5px;" onclick="getAttendanceProgress('<?php echo $section_id; ?>', '', '')">
            <i class="fa fa-line-chart"></i>
        </button>
        <h2 class="page-header" style="margin:0">Attendance
            <small class="pull-right" style="margin-top:5px;">

                <div class="form-group input-group pull-right">
                    <input type="hidden" id="section_id" value="<?php echo $section_id; ?>" />
                    <input style="height:34px;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d"); ?>" id="inputBdate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button class="btn btn-success" onclick="searchAttendance($('#inputBdate').val())">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </small>

            <input type="hidden" id="selectStudentIds" name="selectStudentId" />
        </h2>

    </div>

    <?php
    $teacher = $this->session->userdata('position');
    ?>
    <div class="col-lg-12" id="attendanceSearchResult">
        <?php
        if ($this->session->userdata('is_admin')):
            if ($this->uri->segment(3) != NULL):
        ?>
                <table id="presentStudents" align="center" class='table table-striped '>
                    <tr>
                        <td colspan="" style="text-align: center">
                            <h6>Present</h6>
                        </td>
                        <td colspan="" style="text-align: center; width:50%;">
                            <h6>Absent</h6>
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
                                        <a style="font-size:10px; float: right;" class="help-inline pull-right"
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
            <?php
            else:
                foreach ($section->result() as $sec):
                    $data = array(
                        'date' => date('Y-m-d'),
                        'section' => $sec->section_id,
                        'grade' => $sec->grade_id
                    );
                    echo Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data);
                endforeach;
            endif;
        else:
            ?>

            <table id="presentStudents" align="center" class='table table-striped '>
                <tr>
                    <td colspan="" style="text-align: center">
                        <h6>Present</h6>
                    </td>
                    <td colspan="" style="text-align: center; width:50%;">
                        <h6>Absent</h6>
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
                                    <a style="font-size:10px; float: right;" class="help-inline pull-right"
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