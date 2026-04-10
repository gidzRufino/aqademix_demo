<div class="col-md-12">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="clearfix" style="margin-bottom:10px;">
                    <h3 class="pull-left">
                        Employee's Daily Attendance
                    </h3>
                    <div class="pull-right" style="max-width: 320px;">
                        <label class="control-label" for="inputBdate" style="font-weight: 600; margin-bottom: 3px;">Select Date</label>
                        <div class="form-group input-group" style="margin-bottom:0;">
                            <input
                                style="height:34px;"
                                name="inputBdate"
                                type="date"
                                data-date-format="yyyy-mm-dd"
                                value="<?php echo $date; ?>"
                                id="inputBdate"
                                max="<?php echo date('Y-m-d'); ?>"
                                placeholder="Search for Date"
                                required
                            >
                            <span class="input-group-btn">
                                <button id="btnSearchAttendance" class="btn btn-success" type="button">
                                    <i id="verify_icon" class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <small id="attendanceDateHelp" class="text-muted">View attendance records for a specific day.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 panel">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 style="text-align: center">Present</h4>
                    </div>
                    <div class="panel-body clearfix attendance-scroll" id="present_em">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center">Name</th>
                                    <th style="text-align: center">Time IN [AM]</th>
                                    <th style="text-align: center">Time OUT [AM]</th>
                                    <th style="text-align: center">Time IN [PM]</th>
                                    <th style="text-align: center">Time OUT [PM]</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($presents->result() as $basicInfo):
                                    if ($basicInfo->time_in != "") {
                                        if (mb_strlen($basicInfo->time_in) <= 3):
                                            $time_in = date("g:i a", strtotime("0" . $basicInfo->time_in));
                                        else:
                                            $time_in = date("g:i a", strtotime($basicInfo->time_in));
                                        endif;
                                    } else {
                                        $time_in = "";
                                    }

                                    if ($basicInfo->time_out != "") {
                                        if (mb_strlen($basicInfo->time_out) <= 3):
                                            $time_out = date("g:i a", strtotime('0' . $basicInfo->time_out));
                                        else:
                                            $time_out = date("g:i a", strtotime($basicInfo->time_out));
                                        endif;
                                    } else {
                                        $time_out = "";
                                    }

                                    if ($basicInfo->time_in_pm != "") {
                                        $time_in_pm = date("g:i a", strtotime($basicInfo->time_in_pm));
                                    } else {
                                        $time_in_pm = "";
                                    }
                                    if ($basicInfo->time_out_pm != "") {
                                        $time_out_pm = date("g:i a", strtotime($basicInfo->time_out_pm));
                                    } else {
                                        $time_out_pm = "";
                                    }
                                ?>
                                    <tr data-toggle="modal" data-target="#updateTime" class="presentTR pointer" style="text-align: center">
                                        <td>
                                            <!-- <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php
                                                                                                                        // if ($basicInfo->avatar != ""):echo base_url() . 'uploads/' . $basicInfo->avatar;
                                                                                                                        // else:echo base_url() . 'uploads/noImage.png';
                                                                                                                        // endif;
                                                                                                                        ?>" />  -->
                                            <?php if ($basicInfo->avatar != ''):
                                                if (file_exists('uploads/' . $basicInfo->avatar)):
                                            ?>
                                                    <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'uploads/' . $basicInfo->avatar  ?>" />
                                                <?php else: ?>
                                                    <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'images/avatar/' . ($basicInfo->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'images/avatar/' . ($basicInfo->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo strtoupper($basicInfo->firstname . ' ' . $basicInfo->lastname) ?>
                                        </td>
                                        <td>
                                            <?php echo $time_in ?>
                                        </td>
                                        <td>
                                            <?php echo $time_out ?>
                                        </td>
                                        <td>
                                            <?php echo $time_in_pm ?>
                                        </td>
                                        <td>
                                            <?php echo $time_out_pm ?>
                                        </td>
                                    </tr>

                                    <div id="updateTime" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 style="text-align: center">Update Employee Time Attendance</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <b>Select Time </b><br />
                                                    <select id='<?php echo $basicInfo->att_st_id ?>_hr' style='width:70px;'>
                                                        <?php
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            if ($i < 10) {
                                                                $i = '0' . $i;
                                                            }
                                                        ?>
                                                            <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select id='<?php echo $basicInfo->att_st_id ?>_min' style='width:70px;'>
                                                        <?php
                                                        for ($i = 0; $i <= 60; $i++) {
                                                            if ($i < 10) {
                                                                $i = '0' . $i;
                                                            }
                                                        ?>
                                                            <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select id='<?php echo $basicInfo->att_st_id ?>_ampm' style='width:70px;'>
                                                        <option> Select Choice </option>
                                                        <option value='AM'>AM</option>
                                                        <option value='PM'>PM</option>
                                                    </select>

                                                    <select id='<?php echo $basicInfo->att_st_id ?>_inout' style='width:70px;'>
                                                        <option value='in'>IN</option>
                                                        <option value='out'>OUT</option>
                                                    </select>
                                                    <input type='hidden' value='<?php echo $basicInfo->att_st_id ?>' id='<?php echo $basicInfo->att_st_id ?>_dtr' />
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
                                                    <button onclick="saveTime('<?php echo $basicInfo->att_st_id ?>')" class="btn btn-primary btn-lg" data-dismiss="modal">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 panel">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 style="text-align: center">Absent</h4>
                    </div>
                    <div class="panel-body clearfix attendance-scroll">
                        <?php
                        foreach ($employees->result() as $basicInfo):
                            if ($basicInfo->rfid == ''):
                                $t_id = $basicInfo->employee_id;
                            else:
                                $t_id = $basicInfo->rfid;
                            endif;
                            $ifPresent = Modules::run('attendance/ifPresent', $basicInfo->employee_id, date('d', strtotime($date)), date('m', strtotime($date)), NULL, TRUE);
                            if (!$ifPresent):
                        ?>
                                <div class="row emList pointer" data-toggle="modal" data-target="#updateAttendance" style="padding-left: 20px;">
                                    <div class="col-lg-2">
                                        <!-- <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php
                                                                                                                    // if ($basicInfo->avatar != ""): echo base_url() . 'uploads/' . $basicInfo->avatar;
                                                                                                                    // else: echo base_url() . 'uploads/noImage.png';
                                                                                                                    // endif;
                                                                                                                    ?>" /> -->
                                        <?php if ($basicInfo->avatar != ''):
                                            if (file_exists('uploads/' . $basicInfo->avatar)):
                                        ?>
                                                <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'uploads/' . $basicInfo->avatar  ?>" />
                                            <?php else: ?>
                                                <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'images/avatar/' . ($basicInfo->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img class="img-circle" style="width:50px;" src="<?php echo base_url() . 'images/avatar/' . ($basicInfo->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-10">
                                        <h4><?php echo strtoupper($basicInfo->firstname . ' ' . $basicInfo->lastname) ?></h4>
                                    </div>
                                </div>
                                <div id="updateAttendance" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 style="text-align: center">Update Employee Attendance</h3>
                                            </div>
                                            <div class="modal-body">
                                                <b>Select Time </b><br />
                                                <select id='<?php echo $basicInfo->employee_id ?>_hr' style='width:70px;'>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        if ($i < 10) {
                                                            $i = '0' . $i;
                                                        }
                                                    ?>
                                                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                                    <?php } ?>
                                                </select>
                                                <select id='<?php echo $basicInfo->employee_id ?>_min' style='width:70px;'>
                                                    <?php
                                                    for ($i = 0; $i <= 60; $i++) {
                                                        if ($i < 10) {
                                                            $i = '0' . $i;
                                                        }
                                                    ?>
                                                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                                    <?php } ?>
                                                </select>
                                                <select id='<?php echo $basicInfo->employee_id ?>_ampm' style='width:70px;'>
                                                    <option> Select Choice </option>
                                                    <option value='AM'>AM</option>
                                                    <option value='PM'>PM</option>
                                                </select>

                                                <select id='<?php echo $basicInfo->employee_id ?>_inout' style='width:70px;'>
                                                    <option value='in'>IN</option>
                                                    <option value='out'>OUT</option>
                                                </select>
                                                <input type='hidden' value='<?php echo $basicInfo->employee_id ?>' id='<?php echo $basicInfo->employee_id ?>_dtr' />
                                                <input type='hidden' value='<?php echo $basicInfo->employee_id ?>' id='<?php echo $basicInfo->employee_id ?>_eid' />
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
                                                <button onclick="saveTime('<?php echo $basicInfo->employee_id ?>')" class="btn btn-primary btn-lg" data-dismiss="modal">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .emList:hover {
        cursor: pointer;
        background-color: #ebccd1;
        color: white;
    }

    .presentTR:hover {
        cursor: pointer;
        background-color: #ff9800;
        color: white;
    }

    .attendance-scroll {
        max-height: 450px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .attendance-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .attendance-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .attendance-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .attendance-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<script type="text/javascript">
    function saveTime(id) {
        //$('.clickover').popover('hide');
        var hour = $('#' + id + '_hr').val();
        var min = $('#' + id + '_min').val();
        var select = $('#' + id + '_ampm').val();
        var t_id = id;
        var date = $('#inputBdate').val();
        var inout = $('#' + id + '_inout').val();
        var uid = $('#' + id + '_eid').val();

        // basic validation to avoid sending incomplete data
        if (!hour || !min || !select || select === ' Select Choice ') {
            alert('Please select a complete time (hour, minutes, and AM/PM) before updating.');
            return;
        }

        if (!date) {
            alert('Please select a date first.');
            return;
        }

        var url = "<?php echo base_url() . 'hr/saveManualHrAttendance/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 't_id=' + t_id + '&hour=' + hour + '&min=' + min + '&ampm=' + select + '&date=' + date + '&inout=' + inout + '&uid=' + uid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#present_em').html(data)
                location.reload();
            },
            error: function(data) {
                alert('error')
            }
        })
    }

    function searchAttendance(date) {
        if (!date) {
            alert('Please select a date.');
            $('#inputBdate').focus();
            return;
        }
        var url = "<?php echo base_url() . 'hr/getDailyAttendance/' ?>" + date; // the script where you handle the form input.
        document.location = url;
    }

    $(document).ready(function() {
        $("[data-toggle=popover]").popover({
            placement: 'top',
            html: true
        });

        $('#btnSearchAttendance').on('click', function() {
            searchAttendance($('#inputBdate').val());
        });

        $('#inputBdate').on('keyup change', function(e) {
            if (e.keyCode === 13) {
                searchAttendance($(this).val());
            }
        });
    });
</script>