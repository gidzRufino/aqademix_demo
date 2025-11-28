<?php
$payDay = date('d');
if ($payDay > 15) {
    $from = date('Y') . '-' . date('m') . '-16';
    $to = date('Y') . '-' . date('m') . '-30';
} else {
    $from = date('Y') . '-' . date('m') . '-01';
    $to = date('Y') . '-' . date('m') . '-15';
}

$officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $info->time_group_id);
$officialTimeInAm = ($officialTime ? $officialTime->ps_from : '08:00:00');
$officialTimeOutAm = ($officialTime ? $officialTime->ps_to : '12:00:00');
$totalTimeMorning = round(abs(strtotime($officialTimeInAm) - strtotime($officialTimeOutAm)) / 60, 2);

$officialTimeInPm = ($officialTime ? $officialTime->ps_from_pm : '13:00:00');
$officialTimeOutPm = ($officialTime ? $officialTime->ps_to_pm : '17:00:00');
$totalTimeAfternoon = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutPm)) / 60, 2);

$lunchBreak = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutAm)) / 60, 2);
$totalHoursReq = $totalTimeMorning + $totalTimeAfternoon;
$totalHoursReq = ($totalHoursReq >= 450 ? 480 : $totalHoursReq);

$leaveSpent = Modules::run('hr/payroll/getTotalLeaveSpent', $info->employee_id);
$daysLCredited = Modules::run('hr/payroll/getLeaveCredited', $info->employee_id, null);
// echo ($info->leave_credits * 8) - $leaveSpent->totalLeaveSpent;
$remLeave = ($info->leave_credits * 8) - $leaveSpent->totalLeaveSpent - $daysLCredited->leaveCredited;

?>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-left col-lg-9" style="margin-top:5px; font-size: 13px;">

            <div class="control-group  pull-left">
                <div class="controls">
                    <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date From</label>
                    <input name="dateFrom" type="text" value="<?php echo $from; ?>" data-date-format="yyyy-mm-dd" id="dateFrom">
                    <input type="hidden" name="owners_id" value="<?php echo $info->uid ?>" id="owners_id" />
                </div>
            </div>
            <div class="control-group pull-left">
                <div class="controls">
                    <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date to</label>
                    <input name="dateTo" type="text" value="<?php echo $to; ?>" data-date-format="yyyy-mm-dd" id="dateTo">
                    <!--<a href="#" onclick="editDateFrom(document.getElementById('dateFrom').value, document.getElementById('dateTo').value, '<?php echo $info->uid ?>')" data-toggle="modal" style="margin-top:0;margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Edit</a>-->

                    <button onclick="getEPaySlip(document.getElementById('dateFrom').value, document.getElementById('dateTo').value), $('#dtrBtns').hide()" style="margin-top:0; margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Load e-Payslip</button>
                    <button onclick="getDateFrom(document.getElementById('dateFrom').value, document.getElementById('dateTo').value), $('#dtrBtns').show()" style="margin-top:0; margin-left: 10px;" class="btn btn-success btn-xs pull-right">search</button>
                </div>

            </div>
        </div>
        <div class="pull-right" id="dtrBtns">
            <?php if ($info->uid == $this->session->user_id): ?>
                <i class="fa fa-calendar fa-2x pull-left pointer text-warning leaveOver" rel="clickover" data-content="
                <ul class='list-group'>
                    <li class='list-group-item pointer' onclick='$(&quot;#leaveList&quot;).modal(&quot;show&quot;), $(&quot;.leaveOver&quot;).clickover(&quot;hide&quot;), fetchLeave()'><i class='fa fa-eye'></i> View Leave Requests</li>
                    <li class='list-group-item pointer' onclick='$(&quot;#leaveReq&quot;).modal(&quot;show&quot;), $(&quot;.leaveOver&quot;).clickover(&quot;hide&quot;)'><i class='fa fa-eye'></i> Request for Leave</li></ul>"></i>
                <!-- <i class="fa fa-calendar fa-2x pull-left pointer text-warning" title="Request for Leave" onclick="$('#leaveReq').modal('show')"></i> -->
            <?php endif; ?>

            <i class="fa fa-paper-plane fa-2x pull-left pointer text-success" title="Submit to Payroll" id="submitBtn" onclick="$('#submitPayroll').modal('show'), $('#payrollHoursRendered').val($('#totalHoursRendered').val())">
            </i>
            <i class="fa fa-print fa-2x pull-left pointer" id="print" onclick="print(document.getElementById('dateFrom').value, document.getElementById('dateTo').value, '<?php echo $this->uri->segment(3) ?>')">
            </i>
            <?php if ($this->session->is_superAdmin || $this->session->position == 'Human Resource Department Head' || $this->session->position == 'Human Resource Department Staff' || $this->session->position == 'HRMO Secretary' || $this->session->position == 'Accounting - Admin'): ?>
                <i class="fa fa-plus fa-2x pull-left pointer" id="addHours" onclick="editTimeData('','','<?php echo $info->rfid ?>','<?php echo $info->employee_id ?>')">
                </i>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="pull-left col-lg-12" id="TableResult">
    <table border="1" style="margin:0; border: 1px solid #DDDDDD;" class="table">
        <tr>
            <td width="10%" rowspan="2">
                <h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5>
            </td>
            <td colspan="2">
                <h5>MORNING</h5>
            </td>
            <td colspan="2">
                <h5>AFTERNOON</h5>
            <td>
                <h5>OVERTIME</h5>
            <td width="10%" rowspan="2">
                <h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5>
            </td>
        </tr>
        <tr>
            <td style="width:12%">
                <h5>IN</h5>

            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
            <td style="width:12%">
                <h5>IN</h5>

            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
        </tr>
    </table>
    <table class='table table-striped'>
        <?php
        $finalhours = 0;
        $finaltardy = 0;
        $finalunder = 0;
        $tard = 0;
        $under = 0;
        foreach ($records as $row) {
            if ($row->time_in != "") {
                if ($row->time_in < 1000) {
                    $time_in = date("g:i a", strtotime($row->time_in));
                    $timeInCompute = '0' . $row->time_in;
                } else {
                    $time_in = date("g:i a", strtotime($row->time_in));
                    $timeInCompute = $row->time_in;
                }
            } else {
                $time_in = "";
            }

            if ($row->time_out != "") {
                if ($row->time_out < 1000) {

                    $time_out = date("g:i a", strtotime($row->time_out));
                } else {
                    $time_out = date("g:i a", strtotime($row->time_out));
                }
                $timeOutCompute = $row->time_out;
            } else {
                $time_out = "";
            }

            if ($row->time_in_pm != "") {
                $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                $timeInCompute = $row->time_in_pm;
            } else {
                $time_in_pm = "";
            }
            if ($row->time_out_pm != "") {
                $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                $timeOutCompute = $row->time_out_pm;
            } else {
                $time_out_pm = "";
            }

        ?>
            <tr>
                <td width="10%">
                    <h5><?php echo $row->date ?></h5>

                </td>
                <td style="width:12%">
                    <h5><?php echo $time_in ?></h5>

                </td>
                <td style="width:12%">
                    <h5><?php echo $time_out ?></h5>
                </td>
                <td style="width:12%">
                    <h5><?php echo $time_in_pm ?></h5>

                </td>
                <td style="width:12%">
                    <h5><?php echo $time_out_pm ?></h5>
                </td>
                <td style="width:12%">
                    <h5>0</h5>

                </td>
                <td width="10%">
                    <h5>
                        <?php

                        $Hours = $hrdb->getManHours($timeInCompute, $timeOutCompute, $row->date);
                        $totaltime = json_decode($Hours);
                        //echo $Hours['early'].'<br>';
                        //echo $Hours['over'].'<br>';
                        echo $totaltime->totalTime . 'h ' . $totaltime->minutes . 'm';

                        ?>

                    </h5>
                </td>
            </tr>
        <?php
        }
        ?>

        <!--records is taken from controller dtr-->

    </table>
</div>
<div id="main_content">

</div>
<input type="hidden" id="setAction" />

<div id="submitPayroll" data-backdrop="static" style="width:20%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="viewDTR">Submit to Payroll</span>
        </div>
        <div class="panel-body" id="payrollBdy">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Number of Hours Rendered</label>
                    <input type="text" id="payrollHoursRendered" class="form-control text-center" style="font-weight: bold; font-size: 20px; color:red;" disabled="disabled" />
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="useLC" onclick="useLC()">
                    <label class="form-check-label" for="useLC">
                        Use Leave Credit?
                    </label>
                </div>
                <div class="form-group" id="LCWrapper" style="display: none">
                    <label>Leave Credit to Use <small>(in hours)</small></label>
                    <input type="text" id="LCHours" class="form-control text-center" value="0" style="font-weight: bold; font-size: 20px; color:red;" />
                </div>
                <div class="form-group">
                    <button onclick="submitToPayroll()" type="button" class="btn btn-primary btn-block">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="viewDTR" data-backdrop="static" style="width:50%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="viewDTR">Edit DTR</span>
        </div>
        <div class="panel-body" id="dtrBody">

        </div>
    </div>
</div>

<div id="editDTR" style="margin: 10% auto;" class="modal fade col-lg-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span>Enter Time to Edit</span>
        </div>
        <div class="panel-body" id="bodyid">
            <div class="control-group">
                <label style="padding:5px" class="control-label pull-left" for="editDate">Date</label>
                <input style="width: 100%;" name="editDate" type="text" value="" data-date-format="yyyy-mm-dd" id="editDate">
            </div><br />
            <div class="control-group">

                <select id="time_option" style="width: 100%;">
                    <option value="time_in">Time In AM</option>
                    <option value="time_out">Time Out AM</option>
                    <option value="time_in_pm">Time In PM</option>
                    <option value="time_out_pm">Time Out PM</option>
                </select>
            </div><br />
            <div class='control-group'>
                <b>Select Time </b>
                <input style="width: 100%;" id="timeEdited" name="timeEdited" type="time" class="form-control">

            </div><br />
            <!-- <div class='control-group'>
                <input id="newTime" name="newTime" type="checkbox" value="1" class="form-check-input">
                <label class="form-check-label">New Date</label>
            </div> -->
        </div>
        <div class="panel-footer clearfix">
            <div class='pull-right'>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                <a href='#' data-dismiss='clickover' onclick='saveTimeData()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
            </div>
        </div>
    </div>
</div>

<div id="leaveReq" style="margin: 10% auto;" class="modal fade col-lg-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-warning" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" onclick="$('.leaveOver').clickover('show')" aria-hidden="true">&times;</button>
            <span>Request for Leave</span>
        </div>
        <div class="panel-body" id="bodyid">
            <div class="control-group">
                <label style="padding:5px" class="control-label pull-left" for="editDate">Date</label>
                <input style="width: 100%;" name="leaveDate" type="text" value="" data-date-format="yyyy-mm-dd" id="leaveDate">
            </div><br />

            <div class="control-group">
                <label style="padding:5px" class="control-label pull-left" for="reason">Reason</label>
                <input style="width: 100%;" name="leaveReason" type="text" value="" id="leaveReason">
            </div><br />

            <div class="control-group">
                <label style="padding:5px" class="control-label pull-left" for="duration">Leave Duration</label>
                <select style="width: 100%;" name="leaveReason" id="leaveDuration">
                    <option value="1">Whole Day</option>
                    <option value="2">Half Day</option>
                </select>
            </div><br />
            <span id="lcmsge" class="text-center" style="display: none;"></span>
        </div>
        <div class="panel-footer clearfix">
            <div class='pull-right'>
                <button data-dismiss='modal' onclick="$('.leaveOver').clickover('show')" class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                <a href='#' data-dismiss='clickover' onclick='saveLeave()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
            </div>
        </div>
    </div>
</div>

<div id="leaveList" style="margin: 10% auto;" class="modal fade col-lg-6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" onclick="$('.leaveOver').clickover('show')" aria-hidden="true">&times;</button>
            <span>Leave Requests</span>
        </div>
        <div class="panel-body" id="tbl_leave">

        </div>
    </div>
</div>

<input type="hidden" id="att_id" />
<input type="hidden" id="rowCol_id" />
<input type="hidden" id="u_rfid" />
<input type="hidden" id="att_st_id" />
<input type="hidden" id="emp_id" value="<?php echo $info->em_id ?>" />
<script type="text/javascript">
    $(document).ready(function() {
        $('td').click(function() {
            alert('test');
        });

        $('#leaveDuration').select2();
        $('#leaveDate').datepicker({
            multidate: true
        });
        $(".leaveOver").clickover({
            placement: 'left',
            html: true
        });
    });

    function useLC() {
        if ($('#useLC').is(':checked')) {
            $('#LCWrapper').show();

            if ($('#LCredits').html() > 0) {
                var totalHoursRendered = $('#totalHoursRendered').val();
                var requiredHours = $('#hoursRequired').val();
                var daysLeaveCredited = $('#leaveDaysCredited').val();
                var leaveCreditsHours = parseFloat(requiredHours) - parseFloat(totalHoursRendered) - parseFloat(daysLeaveCredited);
                var leaveCreditAvailable = $('#LCredits').html();
                if (parseFloat(leaveCreditAvailable) <= leaveCreditsHours) {
                    $('#LCHours').val(leaveCreditAvailable.toFixed(2));

                } else {
                    $('#LCHours').val(leaveCreditsHours.toFixed(2));
                }

                $('#LCredits').html(parseFloat(leaveCreditAvailable) - parseFloat(leaveCreditsHours));
            }

        } else {
            $('#LCHours').val('');
            $('#LCWrapper').hide();
        }
    }

    function print(from, to, id) {
        var url = '<?php echo base_url(); ?>hr/printDTR/' + from + '/' + to + '/' + id;
        window.open(url, '_blank');

    }

    function getEPaySlip(dateFrom, dateTo) {
        var url = "<?php echo base_url() ?>hr/payroll/getEPaySlip"; // the script where you handle the form input.
        var owners_id = document.getElementById("owners_id").value
        $.ajax({
            type: "POST",
            url: url,
            data: "owners_id=" + owners_id + "&employee_id=<?php echo $info->employee_id ?>" + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#TableResult').html(data);
                $('#basicPay').html(numberWithCommas(parseFloat(($('#salary').val()) / 2).toFixed(2)));
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function getDateFrom(dateFrom, dateTo) {
        var url = "<?php echo base_url() ?>hr/searchDtrbyDate"; // the script where you handle the form input.
        var owners_id = document.getElementById("owners_id").value
        $.ajax({
            type: "POST",
            url: url,
            data: "owners_id=" + owners_id + "&employee_id=<?php echo $info->employee_id ?>" + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                document.getElementById('TableResult').innerHTML = data;
                var totalHours = $('#totalHoursRendered').val();
                var requiredHours = $('#hoursRequired').val();
                var minTardy = $('#minutesTardy').val();
                var daysLeaveCredited = $('#leaveDaysCredited').val();
                var dlc = daysLeaveCredited / 8;
                var absent = requiredHours - totalHours - daysLeaveCredited;
                $('#daInHrs').html(absent.toFixed(2));
                $('#totalDaysAbsent').html((absent / 8).toFixed(2));
                $('#totalDaysLeave').html(dlc);
                $('#dlInHrs').html(daysLeaveCredited);
                $('#hoursRendered').html(totalHours);
                $('#totalHoursRequired').html(requiredHours);
                $('#totalMinutesTardy').html(minTardy);


            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function submitToPayroll() {
        var url = "<?php echo base_url() ?>hr/payroll/approvedManHours"; // the script where you handle the form input.
        var em_id = $('#em_id').val();
        var from = $('#dateFrom').val();
        var to = $('#dateTo').val();
        var totalHours = $('#payrollHoursRendered').val();
        var lchours = $('#LCHours').val();
        var leaveCreditAvailable = $('#LCredits').html();
        //   alert(em_id + ' ' + from + ' ' + to + ' ' + totalHours + ' ' + lchours + ' ' + leaveCreditAvailable);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                em_id: em_id,
                from: from,
                to: to,
                mhCat: 1,
                totalHours: totalHours,
                lc_hours: lchours,
                lc_available: leaveCreditAvailable,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                alert(data);
                $('#submitPayroll').modal('hide');
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function editDateFrom(dateFrom, dateTo, owners_id) {
        var url = "<?php echo base_url() ?>hr/searchDTRbyDateForPayroll"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "owners_id=" + owners_id + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#viewDTR').modal('show');
                $('#dtrBody').html(data)

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function editTimeData(att_id, date, rfid, st_id) {

        $('#att_id').val(att_id);
        $('#editDate').val(date);
        $('#u_rfid').val(rfid);
        $('#st_id').val(st_id);
        $('#editDTR').modal('show');
        //alert(att_id);
    }

    function saveTimeData() {
        var date = $('#editDate').val();
        var time = $('#timeEdited').val();
        var att_id = $('#att_id').val();
        var rowCol_id = $('#time_option').val();
        var from = $('#editDate').val();
        var newTime = $('#newTime').val();
        var u_rfid = $('#u_rfid').val();
        var st_id = $('#emp_id').val();

        if ($('#newTime').prop('checked')) {
            newTime = 1;
        } else {
            newTime = 0;
        }

        var url = "<?php echo base_url() . 'hr/editHrTime/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: {
                att_id: att_id,
                time_option: rowCol_id,
                date: date,
                newTime: newTime,
                timeEdit: time,
                rfid: u_rfid,
                st_id: st_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                alert(data);
                $('#editDTR').modal('hide');

                $('#dateFrom').datepicker();
                $('#dateTo').datepicker();
                $('#editDate').datepicker();
                getDateFrom($('#dateFrom').val(), $('#dateTo').val());
            }
        });
    }


    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function() {
        window.prettyPrint && prettyPrint();

        $('#dateFrom').datepicker();
        $('#dateTo').datepicker();
        $('#editDate').datepicker();
        getDateFrom($('#dateFrom').val(), $('#dateTo').val());


        $('#timeEdited').clockpicker({
            placement: 'left',
            donetext: 'Select',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });


    });

    function delDateTime(id, attDate) {
        var userConfirmed = confirm('Are you sure you want to delete the attendance?');

        if (userConfirmed) {
            var url = '<?php echo base_url() . 'hr/deleteAttendance' ?>';

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    att_id: id,
                    date: attDate,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                dataType: 'json',
                success: function(data) {
                    alert(data.msg);

                    $('#dateFrom').datepicker();
                    $('#dateTo').datepicker();
                    $('#editDate').datepicker();
                    getDateFrom($('#dateFrom').val(), $('#dateTo').val());
                }
            })
        } else {
            alert('Delete Action Aborted');
        }

    }

    function saveLeave() {
        var ldate = $('#leaveDate').val();
        var leave_date = ldate.split(',');
        var emp_id = $('#emp_id').val();
        var reason = $('#leaveReason').val();
        var duration = $('#leaveDuration').val();
        var hours = '<?php echo round($totalHoursReq / 60, 2); ?>';
        var hrs = (duration == 1 ? hours : (hours / 2));
        var tHours = leave_date.length * hrs;
        var rem_leave = '<?php echo $remLeave ?>';

        if (ldate == '') {
            $('#lcmsge').show();
            $('#lcmsge').html('<p style="color: red; font-weight: bold">Please Select date of leave!</p>');
        } else {
            if (rem_leave <= 0) {
                $('#lcmsge').show();
                $('#lcmsge').html('<p style="color: red; font-weight: bold">Sorry! You don\'t have any remaining Leave Credits</p>');
                setTimeout(function() {
                    location.reload();
                }, 5000);
            } else if (rem_leave < tHours) {
                $('#lcmsge').show();
                $('#lcmsge').html('<p style="color: red; font-weight: bold">Sorry! You don\'t have enough Leave Credits left</p>');
                setTimeout(function() {
                    location.reload();
                }, 5000);
            } else {
                var url = '<?php echo base_url() . '/hr/payroll/saveLeaveReq' ?>';

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'emp_id=' + emp_id + '&leave_date=' + leave_date + '&reason=' + reason + '&duration=' + duration + '&hours=' + hours + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                    success: function(data) {
                        if (data) {
                            $('#lcmsge').show();
                            $('#lcmsge').html('<p style="color: green; font-weight: bold">Leave Successfully Requested!</p>');
                        } else {
                            $('#lcmsge').show();
                            $('#lcmsge').html('<p style="color: red; font-weight: bold">An Error Occured!</p>');
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    }
                });
            }
        }
    }

    function fetchLeave() {
        var emp_id = '<?php echo $info->employee_id ?>';
        var url = '<?php echo base_url() . 'hr/payroll/getLeaveCredited/' ?>' + emp_id + '/1';

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + emp_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#tbl_leave').html(data);
            }

        })
    }
</script>
<script src="<?php echo base_url(); ?>assets/js/employeeRequest.js"></script>