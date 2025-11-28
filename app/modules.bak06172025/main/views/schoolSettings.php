<div class="col-lg-12">
    <div style="position:absolute; top:30%; left:50%;" class="alert alert-error hide" id="notify" data-dismiss="alert-message">
        <h4></h4>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>School Information</h5>
            </div>
            <div class="panel-body">
                <table class="editableTable table table-hover insetBg">
                    <tr>
                        <td><h5 class="pull-right">School ID : </h5></td>
                        <td><h5><span id="school_id" style="color:red;"><?php
                                    if ($settings->school_id != "") {
                                        echo $settings->school_id;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><h5 class="pull-right">Name of School : </h5></td>
                        <td><h5><span id="set_school_name" style="color:red;"><?php
                                    if (!empty($settings)) {
                                        echo $settings->set_school_name;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
    <!--                <tr>
                        <td style="width:30%;"><h5 class="pull-right">Short Name : </h5></td>
                        <td><h5><span id="short_name" style="color:red;"><?php
                    if (!empty($settings)) {
                        echo $settings->short_name;
                    } else {
                        echo '[empty]';
                    }
                    ?></span></h5></td>
                    </tr>-->
                    <tr>
                        <td><h5 class="pull-right">Address : </h5></td>
                        <td><h5><span id="set_school_address" style="color:red;"><?php
                                    if (!empty($settings)) {
                                        echo htmlspecialchars($settings->set_school_address);
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">Region : </h5></td>
                        <td><h5><span id="region" style="color:red;"><?php
                                    if ($settings->region != "") {
                                        echo $settings->region;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">District : </h5></td>
                        <td><h5><span id="district" style="color:red;"><?php
                                    if ($settings->district != "") {
                                        echo $settings->district;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">Division : </h5></td>
                        <td><h5><span id="division" style="color:red;"><?php
                                    if ($settings->division != "") {
                                        echo $settings->division;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">School Year : </h5></td>
                        <td><h5><span id="school_year" style="color:red;"><?php
                                    if ($settings->school_year != "") {
                                        echo $sy;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">Website : </h5></td>
                        <td><h5><span id="web_address" style="color:red;"><?php
                                    if ($settings->web_address != "") {
                                        echo $settings->web_address;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">Official Time In : </h5></td>
                        <td><h5><span id="time_in" style="color:red;"><?php
                                    if ($settings->time_in != "") {
                                        echo $settings->time_in;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
                    <tr>
                        <td><h5 class="pull-right">Official Time Out : </h5></td>
                        <td><h5><span id="time_out" style="color:red;"><?php
                                    if ($settings->time_out != "") {
                                        echo $settings->time_out;
                                    } else {
                                        echo '[empty]';
                                    }
                                    ?></span></h5></td>
                    </tr>
    <!--                <tr>
                        <td><h5 class="pull-right">Final Passing Mark : </h5></td>
                        <td><h5><span id="final_passing_mark" style="color:red;"><?php
                    if ($settings->final_passing_mark != "") {
                        echo $settings->final_passing_mark;
                    } else {
                        echo '[empty]';
                    }
                    ?></span></h5></td>
                    </tr>-->
                </table>
            </div>
        </div>
        <div  class="alert alert-error hide" id="qnotify" data-dismiss="alert-message">
            <h4></h4>

        </div>
        <div class="col-lg-12 pull-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Enrollment Requirements per Department</h5>
                </div>
                <div class="panel-body">
                    <?php
                    echo Modules::run('main/enrollmentRequirements');
//                        $this->load->view('enrollment_requirements');
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Senior High School Strand offered 
                    <i class="pull-right pointer fa fa-2x fa-plus" onclick="$('#seniorHighModal').modal('show')"></i>
                </h5>
            </div>
            <div class="panel-body">
                <ul>
                    <?php
                    $strand = Modules::run('subjectmanagement/getSHOfferedStrand');
                    foreach ($strand as $st):
                        ?>
                        <li><h6><?php echo $st->strand . ' ( ' . $st->short_code . ' )' ?></h6></li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>      
    </div> 
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Attendance Checking </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <h5>
                        <?php
                        if ($settings->att_check):
                            $auto = 'checked="checked"';
                            $manual = '';
                            ?>

                            <?php
                        else:
                            $auto = '';
                            $manual = 'checked="checked"';
                        endif;
                        ?>
                        <input onclick="changeAttendanceSetting(this.value)" style="margin-right: 10px;" <?php echo $auto ?> type="radio" name="att_check" value="1">Check through RFID &nbsp;&nbsp;&nbsp;
                        <input onclick="changeAttendanceSetting(this.value)" style="margin-right: 10px;" <?php echo $manual ?> type="radio" name="att_check" value="0">Check Attendance Manually
                    </h5>
                </div>
            </div>
        </div>      
    </div>
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Grade Level Catered</h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <h5>
                        <?php
                        switch ($settings->level_catered):
                            case 0:
                                $all = 'checked="checked"';
                                $pre = '';
                                $elem = '';
                                $jhs = '';
                                $shs = '';
                                $college = 'checked="checked"';
                                break;
                            case 1:
                                $all = '';
                                $pre = 'checked="checked"';
                                $elem = '';
                                $jhs = '';
                                $shs = '';
                                $college = '';
                                break;
                            case 2:
                                $all = '';
                                $pre = '';
                                $elem = 'checked="checked"';
                                $jhs = '';
                                $shs = '';
                                $college = '';
                                break;
                            case 3:
                                $all = '';
                                $pre = '';
                                $elem = '';
                                $jhs = 'checked="checked"';
                                $shs = '';
                                $college = '';
                                break;
                            case 4:
                                $all = '';
                                $pre = '';
                                $elem = '';
                                $jhs = '';
                                $shs = 'checked="checked"';
                                $college = '';
                                break;

                        endswitch;
                        ?>
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $all ?> type="radio" name="level_check" value="0">All Level
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $pre ?> type="radio" name="level_check" value="1">Preschool
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $elem ?> type="radio" name="level_check" value="2">Elementary
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $jhs ?> type="radio" name="level_check" value="3">Junior HS
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $shs ?> type="radio" name="level_check" value="4">Senior HS
                        <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $college ?> type="radio" name="level_check" value="0">College
                    </h5>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Customized Card </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <h5>
                        <?php
                        if ($gs_settings->customized_card):
                            $auto_c = 'checked="checked"';
                            $manual_c = '';
                            ?>

                            <?php
                        else:
                            $auto_c = '';
                            $manual_c = 'checked="checked"';
                        endif;
                        ?>
                        <input onclick="changeGSSetting(this.value, 'customized_card')" style="margin-right: 10px;" <?php echo $auto_c ?> type="radio" name="card_check" value="1">Customized Report Card &nbsp;&nbsp;&nbsp;
                        <input onclick="changeGSSetting(this.value, 'customized_card')" style="margin-right: 10px;" <?php echo $manual_c ?> type="radio" name="card_check" value="0">Use Default Report
                    </h5>
                </div>
            </div>
        </div>      
    </div>

    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Customized Permanent Record </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <h5>
                        <?php
                        if ($gs_settings->customized_f137):
                            $auto_f = 'checked="checked"';
                            $manual_f = '';
                            ?>

                            <?php
                        else:
                            $auto_f = '';
                            $manual_f = 'checked="checked"';
                        endif;
                        ?>
                        <input onclick="changeGSSetting(this.value, 'customized_f137')" style="margin-right: 10px;" <?php echo $auto_f ?> type="radio" name="f137_check" value="1">Customized Students Permanent Record&nbsp;&nbsp;&nbsp;
                        <input onclick="changeGSSetting(this.value, 'customized_f137')" style="margin-right: 10px;" <?php echo $manual_f ?> type="radio" name="f137_check" value="0">Use Default
                    </h5>
                </div>
            </div>
        </div>      
    </div>
    <div class="col-lg-3 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>End of School Year</h5>
            </div>
            <div class="panel-body">
                <input type="date" class='form-control' school-id='<?php echo $settings->school_id; ?>' change-type="0" eosy="<?php echo $settings->eosy; ?>" value="<?php echo ($settings->bosy != '0000-00-00') ? $settings->eosy : '' ?>" onChange="confirmChange(this)" />
            </div>
        </div>
    </div>
    <div class="col-lg-3 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Beginning of School Year</h5>
            </div>
            <div class="panel-body">
                <input type="date" class='form-control' school-id='<?php echo $settings->school_id; ?>' change-type="1" bosy="<?php echo $settings->bosy; ?>" value="<?php echo ($settings->bosy != '0000-00-00') ? $settings->bosy : '' ?>" onChange="confirmChange(this)" />
            </div>
        </div>
    </div>
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enrollment Schedule
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="date" class='form-control' school-id='<?php echo $settings->school_id; ?>' change-type="0" enrollment_start="<?php echo $settings->enrollment_start; ?>" value="<?php echo ($settings->enrollment_start != '0000-00-00') ? $settings->enrollment_start : '' ?>" onChange="changeEnrollDate(this)" />
                    </div>
                    <div class="col-md-6">
                        <input type="date" class='form-control' school-id='<?php echo $settings->school_id; ?>' change-type="1" enrollment_end="<?php echo $settings->enrollment_end; ?>" value="<?php echo ($settings->enrollment_end != '0000-00-00') ? $settings->enrollment_end : '' ?>" onChange="changeEnrollDate(this)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmChange(input) {
            var put = $(input),
                    changeType = put.attr('change-type'),
                    schoolid = put.attr('school-id'),
                    value = put.val(),
                    date = (changeType == 1) ? put.attr('bosy') : put.attr('eosy'),
                    confirmation = (changeType == 1) ? confirm("Are you sure you want to change the Beginning of the School Year?") : confirm("Are you sure you want to change the End of the School Year?");
            if (confirmation == true) {
                $.ajax({
                    url: "<?php echo site_url('main/updateSchoolDates'); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        type: changeType,
                        school: schoolid,
                        date: value,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data) {
                        alert(data.msg);
                        if (data.status == 0) {
                            put.val(date);
                        }
                    }
                });
            } else {
                put.val(date);
            }
        }

        function changeEnrollDate(input) {
            var put = $(input),
                    changeType = put.attr('change-type'),
                    schoolid = put.attr('school-id'),
                    value = put.val(),
                    date = (changeType == 1) ? put.attr('enrollment_start') : put.attr('enrollment_end'),
                    confirmation = (changeType == 1) ? confirm("Are you sure you want to change the Start of the Enrollment?") : confirm("Are you sure you want to change the End of the Enrollment?");
            if (confirmation == true) {
                $.ajax({
                    url: "<?php echo site_url('main/updateEnrollmentDate'); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        type: changeType,
                        school: schoolid,
                        date: value,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data) {
                        alert(data.msg);
                        if (data.status == 0) {
                            put.val(date);
                        }
                    }
                });
            } else {
                put.val(date);
            }
        }
    </script>

    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-plus-circle fa-2x pull-right" style="cursor: pointer; color: blue; margin-top: 5px" data-toggle="modal" data-target="#addEnReq"></i>
                <h5>Requirement Lists</h5>
            </div>
            <div class="panel-body">
                <?php
                echo Modules::run('main/getAllEnrollmentReq');
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-plus-circle fa-2x pull-right" style="cursor: pointer; color: blue; margin-top: 5px" data-toggle="modal" data-target="#addSubsNotifList"></i>
                <h5>Notification System</h5>
            </div>
            <div class="panel-body">
                <?php
                $this->load->view('notification_system');
                ?>
            </div>
        </div>
    </div>     
</div>

<div id="addEnReq" class="modal fade" role="dialog" style="width: 25%; margin: 5% 0 0 30%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            ADD Requirements
            <i class="fa fa-times-circle pull-right fa-2x" style="cursor: pointer;" onclick="$('#addEnReq').modal('hide')"></i>
        </div>
        <div class="panel panel-body">
            <label>Enter Description:</label>
            <input type="text" name="reqName" id="reqName" required="" placeholder="Enter Requirement"/>
            <button class="btn btn-primary btn-sm" id="addReq"><i class="fa fa-save"></i>&nbsp;Save</button><br/><br/>
            <div class="col-md-12">
                <span id="errorAlert"></span>
            </div>
        </div>
    </div>
</div>

<div id="editEnReq" class="modal fade" role="dialog" style="width: 25%; margin: 15% 0 0 35%">
    <div class="panel panel-default">
        <div class="panel-heading">
            Edit Requirements Description
            <i class="fa fa-times-circle pull-right fa-2x" style="cursor: pointer;" onclick="$('#editEnReq').modal('hide')"></i>
        </div>
        <div class="panel panel-body">
            <label>Edit Description: &nbsp;</label>
            <input id="editReqDesc" name="editReqDesc" />
            <button class="btn btn-success" onclick="editReq($('#editReqDesc').val(), $('#eReqID').val())"><i class="fa fa-save"></i>&nbsp;Update</button>
            <input type="hidden" id="eReqID" name="eReqID" />
        </div>
        <div class="panel panel-footer">
            <span id="updateSuccess"></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });

        $('#addReq').click(function () {
            var req = $('#reqName').val();
            if (req == '') {
                $('#reqName').focus();
                $('#errorAlert').append('<div class="alert alert-danger">' +
                        '<i class="fa fa-exclamation-triangle"></i>&nbsp;' +
                        'This field should not be empty!' +
                        '</div>');

                $('.alert-danger').delay(500).show(10, function () {
                    $(this).delay(3000).hide(10, function () {
                        $(this).remove();
                    });
                });
            } else {
                var url = '<?php echo base_url() . 'main/addEnrollmentReq/' ?>' + req;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        $('#reqName').val('');
                        $('#errorAlert').append('<div class="alert alert-success">' +
                                '<span class="glyphicon glyphicon-ok"></span>&nbsp;' +
                                'Successfuly Added!' +
                                '</div>');

                        $('.alert-success').delay(500).show(10, function () {
                            $(this).delay(3000).hide(10, function () {
                                $(this).remove();
                            });
                        });
                    }
                });
            }
        });
    });


    function editReq(value, id) {
        var url = '<?php echo base_url() . 'main/editReqList' ?>';
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&opt=1' + '&value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function (data) {
                $('#updateSuccess').append('<div class="alert alert-success">' +
                        '<span class="glyphicon glyphicon-ok"></span>&nbsp;' +
                        'Successfuly Updated!' +
                        '</div>');

                $('.alert-success').delay(1500).show(10, function () {
                    $(this).delay(3000).hide(10, function () {
                        $(this).remove();
                    });
                    $('#editEnReq').modal('hide');
                });
            },
            error: function () {
                alert('error');
            }
        });
    }

    function deleteReq(id, option) {
        $.confirm({
            title: 'Confirmation Alert!',
            content: 'Are you sure you want to delete this requirement?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'main/deleteReq/' ?>' + id + '/' + option,
                        success: function (data) {

                        }
                    });
                    $('#viewList').modal('hide');
                    $.alert('Requirement Deleted Successfuly!');
                },
                cancel: function () {
                    $.alert('Canceled!');
                }
            }
        });
    }

    function getSubListByType(id) {
        var url = '<?php echo base_url() . 'main/getSubListByType/' ?>' + id;
        $.ajax({
            type: 'GET',
            data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function (data) {
                $('#notifySubList').html(data);
            }
        });
    }

    function deleteSub(notif_id, emp_id) {
        $.confirm({
            title: 'Confirmation Alert!',
            content: 'Are you sure you want to delete the subscriber?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'main/delSubByID/' ?>' + emp_id + '/' + notif_id,
                        success: function (data) {

                        }
                    });
                    $.alert('Subscriber Deleted Successfuly!');
                },
                cancel: function () {
                    $.alert('Canceled!');
                }
            }
        });
    }

    function searchTeacher(value)
    {
        var url = "<?php echo base_url() . 'main/searchEmployees/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
            },
            success: function (data)
            {
                $('#empList').html(data);
            }
        });
        return false;
    }

    function addSubNotif(emp_id, name) {
        var notifSelected = $('#notifSelected').val();
        if (notifSelected == 0) {
            alert('Please select Notification Type');
        } else {
            $.confirm({
                title: 'Confirmation Alert',
                content: 'Are you sure you want to add ' + name + '?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: '<?php echo base_url() . 'main/addSubNotif/' ?>' + notifSelected + '/' + emp_id,
                            success: function (data) {
                                if (data.status) {
                                    $.alert(name + ' Successfully Added!');
                                    $('#addSubsNotifList').modal('hide');
                                } else {
                                    $.alert(name + ' is already on the Notification List');
                                    $('#addSubsNotifList').modal('hide');
                                }
                            }
                        });
                    },
                    cancel: function () {
                        $.alert('Operation Canceled!');
                    }
                }
            });
        }
    }
</script>

<?php //echo Modules::run('subjectmanagement/seniorHighModal');