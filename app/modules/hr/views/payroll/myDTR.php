<?php
$payDay = date('d');
$year   = date('Y');
$month  = date('m');
$lastDay = date('t'); // automatically handles Feb & leap years

if ($payDay > 15) {
    $from = "$year-$month-16";
    $to   = "$year-$month-$lastDay";
} else {
    $from = "$year-$month-01";
    $to   = "$year-$month-15";
}

$leaveSpent = Modules::run('hr/payroll/getTotalLeaveSpent', $info->employee_id);
$daysLCredited = Modules::run('hr/payroll/getLeaveCredited', $info->employee_id, null);
// echo ($info->leave_credits * 8) - $leaveSpent->totalLeaveSpent;
$remLeave = ($info->leave_credits * 8) - $leaveSpent->totalLeaveSpent - $daysLCredited->leaveCredited;
?>
<div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">

                    <!-- Date Filters -->
                    <div class="col-lg-9">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <label class="form-label mb-0 small text-muted">Date From</label>
                                <input name="dateFrom" type="date" value="<?php echo $from; ?>"
                                    class="form-control form-control-sm"
                                    data-date-format="yyyy-mm-dd" id="dateFrom">
                                <input type="hidden" name="owners_id" value="<?php echo $info->uid ?>" id="owners_id" />
                            </div>

                            <div class="col-auto">
                                <label class="form-label mb-0 small text-muted">Date To</label>
                                <input name="dateTo" type="date" value="<?php echo $to; ?>"
                                    class="form-control form-control-sm"
                                    data-date-format="yyyy-mm-dd" id="dateTo">
                            </div>

                            <div class="col-auto pt-4">
                                <button onclick="getDateFrom(document.getElementById('dateFrom').value, document.getElementById('dateTo').value), $('#dtrBtns').show()"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-search me-1"></i> Search
                                </button>

                                <button onclick="getEPaySlip(document.getElementById('dateFrom').value, document.getElementById('dateTo').value), $('#dtrBtns').hide()"
                                    class="btn btn-warning btn-sm ms-1">
                                    <i class="fa fa-file-invoice me-1"></i> Load e-Payslip
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Icons -->
                    <div class="col-lg-3 text-lg-end" id="dtrBtns">
                        <div class="d-inline-flex gap-3 align-items-center">

                            <?php if ($info->uid == $this->session->user_id): ?>
                                <i class="fa fa-calendar fa-lg text-warning pointer leaveOver"
                                    rel="clickover"
                                    title="Leave Options"
                                    data-content="
                                    <ul class='list-group'>
                                        <li class='list-group-item pointer' onclick='$(&quot;#leaveList&quot;).modal(&quot;show&quot;), $(&quot;.leaveOver&quot;).clickover(&quot;hide&quot;), fetchLeave()'>
                                            <i class='fa fa-eye'></i> View Leave Requests
                                        </li>
                                        <li class='list-group-item pointer' onclick='$(&quot;#leaveReq&quot;).modal(&quot;show&quot;), $(&quot;.leaveOver&quot;).clickover(&quot;hide&quot;)'>
                                            <i class='fa fa-plus'></i> Request for Leave
                                        </li>
                                    </ul>">
                                </i>
                            <?php endif; ?>

                            <i class="fa fa-paper-plane fa-lg text-success pointer"
                                title="Submit to Payroll"
                                id="submitBtn"
                                onclick="$('#submitPayroll').modal('show'), $('#payrollHoursRendered').val($('#totalHoursRendered').val())">
                            </i>

                            <i class="fa fa-print fa-lg pointer"
                                title="Print"
                                id="print"
                                onclick="print(document.getElementById('dateFrom').value, document.getElementById('dateTo').value, '<?php echo $this->uri->segment(3) ?>')">
                            </i>

                            <?php if ($this->session->is_superAdmin || $this->session->position == 'Human Resource Department Head' || $this->session->position == 'Human Resource Department Staff' || $this->session->position == 'HRMO Secretary' || $this->session->position == 'Accounting - Admin'): ?>
                                <i class="fa fa-plus fa-lg pointer"
                                    title="Add Manual Time"
                                    id="addHours"
                                    onclick="editTimeData('','','<?php echo $info->rfid ?>','<?php echo $info->employee_id ?>')">
                                </i>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0" id="TableResult">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" style="width:10%">DATE</th>
                                <th colspan="2">MORNING</th>
                                <th colspan="2">AFTERNOON</th>
                                <th rowspan="2" style="width:8%">UNDERTIME</th>
                                <th rowspan="2" style="width:10%">
                                    OVERTIME
                                    <?php if ($records): ?>
                                        <div class="mt-1">
                                            <button onclick="$('.overtimeRow').addClass('pointer timeOvr'), $(this).hide(), $('#optBtn').show()"
                                                class="btn btn-sm btn-success" id="reqBtn">
                                                <i class="fa fa-clock me-1"></i> Request OT
                                            </button>

                                            <div class="btn-group" role="group" id="optBtn" style="display:none;">
                                                <button type="button" class="btn btn-success"
                                                    onclick="$('#optBtn').hide(), $('#reqBtn').show(), saveOT('<?php echo base64_encode($info->employee_id) ?>')"
                                                    title="Save Overtime">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="$('#optBtn').hide(), $('#reqBtn').show(), $('#otTime').val(''), $('.overtimeRow').removeClass('highlight pointer timeOvr')"
                                                    title="Cancel">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </th>
                                <th rowspan="2" style="width:12%">Daily<br>Total</th>
                            </tr>
                            <tr>
                                <th style="width:8%">IN</th>
                                <th style="width:8%">OUT</th>
                                <th style="width:8%">IN</th>
                                <th style="width:8%">OUT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $timeInCompute = 0;
                            $timeOutCompute = 0;
                            $timeInPMCompute = 0;
                            $timeOutPMCompute = 0;
                            $totalUndertimeTardy = 0;
                            $totalUndertime = 0;
                            $overtime = 0;
                            $otID = 1;

                            $totalMin = 0;
                            $totalHours = 0;
                            $under = 0;


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

                            foreach ($records as $row) {
                                $overtime = 0;
                                $undertimeAm = 0;
                                $undertimePM = 0;
                                $totalUndertime = 0;
                                $totalUndertimePm = 0;
                                $totalUndertimeTardy = 0;

                                if ($row->time_in != "") {
                                    if (mb_strlen($row->time_in) <= 3):
                                        $time_in = date("g:i a", strtotime("0" . $row->time_in));
                                        $forUnderIn = date("g:i:s", strtotime("0" . $row->time_in));
                                    else:
                                        $time_in = date("g:i a", strtotime($row->time_in));
                                        $forUnderIn = date("g:i:s", strtotime($row->time_in));
                                    endif;

                                    $timeInCompute = $row->time_in;
                                } else {
                                    $time_in = "";
                                    $forUnderIn = "";
                                }

                                if ($row->time_out != "") {
                                    if (mb_strlen($row->time_out) <= 3):
                                        $time_out = date("g:i a", strtotime('0' . $row->time_out));
                                    else:
                                        $time_out = date("g:i a", strtotime($row->time_out));
                                    endif;
                                    $timeOutCompute = $row->time_out;
                                } else {
                                    $time_out = "";
                                }

                                if ($row->time_in_pm != "") {
                                    $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                                    $timeInPMCompute = $row->time_in_pm;
                                } else {
                                    $time_in_pm = "";
                                }
                                if ($row->time_out_pm != "") {
                                    $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                                    $timeOutPMCompute = $row->time_out_pm;
                                    $forUnderPMOut = date("g:i:s", strtotime($row->time_out_pm));
                                } else {
                                    $time_out_pm = "";
                                    $forUnderPMOut = "";
                                }

                                if ($timeInCompute != 0): // In AM
                                    $tardyAm = ((strtotime($time_in) - strtotime($officialTimeInAm))) <= 0 ? 0 : (strtotime($time_in) - strtotime($officialTimeInAm)) / 60;
                                else:
                                    $tardyAm = $totalTimeMorning;
                                endif;

                                if ($timeOutCompute != 0):
                                    if (strtotime($time_out) < strtotime($officialTimeInAm)):
                                        if ($timeOutPMCompute == 0):
                                            $totalUndertime = $totalTimeMorning;
                                        else:
                                            $totalUndertime = 0;
                                        endif;
                                    else:
                                        $undertimeAm = ((strtotime($officialTimeOutAm) - strtotime($time_out))) <= 0 ? 0 : (strtotime($officialTimeOutAm) - strtotime($time_out)) / 60;
                                        $totalUndertime = $tardyAm + $undertimeAm;
                                    endif;
                                elseif ($timeOutPMCompute != 0):
                                    $totalUndertime = $tardyAm;
                                else:
                                    $totalUndertime = $totalTimeMorning;
                                endif;

                                //---------------- Afternoon --------------------------------------------------------///

                                if ($timeInPMCompute != 0):
                                    if ($timeInCompute != 0):
                                        $tardyPm = 0;
                                    else:
                                        $tardyPm = ((strtotime($time_in_pm) - strtotime($officialTimeInPm))) <= 0 ? 0 : (strtotime($time_in_pm) - strtotime($officialTimeInPm)) / 60;
                                    endif;
                                elseif ($timeOutPMCompute != 0):
                                    $tardyPm = 0;
                                else:
                                    $tardyPm = $totalTimeAfternoon;
                                endif;

                                if ($timeOutPMCompute != 0):
                                    $undertimePM =  (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) <= 0 ? 0 : (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) / 60;
                                    $totalUndertimePm = $undertimePM + $tardyPm;
                                elseif ($timeInPMCompute != 0):
                                    $totalUndertimePm = $totalTimeAfternoon;
                                else:
                                    $totalUndertimePm = $tardyPm;
                                endif;

                                $totalRender = 0;
                                if ($timeInCompute != 0):
                                    if ($timeOutPMCompute != 0):
                                        if ($tardyAm == 0):
                                            if ($undertimePM == 0):
                                                $totalRender = ((strtotime($officialTimeOutPm) - strtotime($officialTimeInAm)) / 60) - $lunchBreak;
                                                if (strtotime($time_out_pm) > strtotime($officialTimeOutPm)):
                                                    $overtime = strtotime($time_out_pm) - strtotime($officialTimeOutPm);
                                                endif;
                                            else:
                                                $totalRender = ((strtotime($time_out_pm) - strtotime($officialTimeInAm)) / 60) - $lunchBreak;
                                            endif;
                                        else:
                                            if ($undertimePM == 0):
                                                $totalRender = ((strtotime($officialTimeOutPm) - strtotime($time_in)) / 60) - $tardyAm - $lunchBreak;
                                                if (strtotime($time_out_pm) > strtotime($officialTimeOutPm)):
                                                    $overtime = strtotime($time_out_pm) - strtotime($officialTimeOutPm);
                                                endif;
                                            else:
                                                $totalRender = ((strtotime($time_out_pm) - strtotime($time_in)) / 60) - $tardyAm - $lunchBreak;
                                            endif;
                                        endif;
                                    elseif ($timeOutCompute != 0):
                                        if ($tardyAm == 0):
                                            if ($undertimeAm == 0):
                                                $totalRender = ((strtotime($officialTimeOutAm) - strtotime($officialTimeInAm)) / 60);
                                            else:
                                                $totalRender = ((strtotime($time_out) - strtotime($officialTimeInAm)) / 60);
                                            endif;
                                        else:
                                            if ($undertimeAm == 0):
                                                $totalRender = ((strtotime($officialTimeOutAm) - strtotime($time_in)) / 60);
                                            else:
                                                $totalRender = ((strtotime($time_out) - strtotime($time_in)) / 60);
                                            endif;
                                        endif;
                                    else:
                                        $totalRender = 0;
                                    endif;
                                elseif ($timeInPMCompute != 0):
                                    if ($timeOutPMCompute != 0):
                                        if ($tardyPm == 0):
                                            if ($undertimePM == 0):
                                                $totalRender = ((strtotime($officialTimeOutPm) - strtotime($officialTimeInPm)) / 60);
                                            else:
                                                $totalRender = ((strtotime($time_out_pm) - strtotime($officialTimeInPm)) / 60);
                                            endif;
                                        else:
                                            if ($undertimePM == 0):
                                                $totalRender = ((strtotime($officialTimeOutPm) - strtotime($time_in_pm)) / 60);
                                            else:
                                                $totalRender = ((strtotime($time_out_pm) - strtotime($time_in_pm)) / 60);
                                            endif;
                                        endif;
                                    else:
                                        $totalRender = 0;
                                    endif;
                                endif;

                                $totalRender = ($totalRender >= 450 ? 480 : $totalRender);

                                if ($totalRender > 0):
                                    $under = ($totalHoursReq - $totalRender <= 0 ? 0 : $totalHoursReq - $totalRender);
                                    $totalRender = $totalRender;
                                else:
                                    $under = 0;
                                    $totalRender = 0;
                                endif;

                                $totalUndertimeTardy = $totalUndertime + $totalUndertimePm;
                                $overtime = ($totalUndertimeTardy > 0 ? 0 : ($overtime / 60));
                                $isOT = Modules::run('hr/payroll/getOverTimeByDate', base64_encode($info->employee_id), base64_encode($row->att_id));
                            ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo $row->date ?></td>

                                    <td><?php echo $time_in ?></td>
                                    <td><?php echo $time_out ?></td>
                                    <td><?php echo $time_in_pm ?></td>
                                    <td><?php echo $time_out_pm ?></td>

                                    <td class="text-danger fw-semibold">
                                        <?php echo Modules::run('hr/convertToHoursMins', $totalUndertimeTardy) ?>
                                    </td>

                                    <?php if ($isOT->num_rows() > 0): ?>
                                        <td class="fw-semibold">
                                            <?php echo Modules::run('hr/convertToHoursMins', $overtime); ?>
                                            <?php
                                            if ($isOT->row()->is_approve != 0):
                                                echo '<i class="fa fa-thumbs-up text-success ms-2" title="OT Approved"></i>';
                                            else:
                                                if ($isOT->row()->approved_by != ''):
                                                    echo '<i class="fa fa-thumbs-down text-danger ms-2" title="OT Rejected"></i>';
                                                else:
                                                    echo '<i class="fa fa-stopwatch text-secondary ms-2" title="Pending Approval"></i>';
                                                endif;
                                            endif;
                                            ?>
                                        </td>
                                    <?php else: ?>
                                        <td class="overtimeRow fw-semibold" id="<?php echo $row->att_id ?>-<?php echo $overtime ?>">
                                            <?php echo Modules::run('hr/convertToHoursMins', $overtime); ?>
                                        </td>
                                    <?php endif; ?>

                                    <td class="fw-bold text-primary position-relative">
                                        <?php
                                        $HoursAM = $hrdb->getManHours($time_in, $time_out, $row->date);
                                        $HoursPM = $hrdb->getManHours($time_in_pm, $time_out_pm, $row->date);
                                        $totaltimeAM = json_decode($HoursAM);
                                        $totaltimePM = json_decode($HoursPM);

                                        $totalAmH = $totaltimeAM->totalTime;
                                        $totalPmH = $totaltimePM->totalTime;
                                        if ($time_out == 0 && $time_out_pm != 0):
                                            $totalAmH = 4;
                                        endif;


                                        $totalTimeH = $totalAmH + $totalPmH;
                                        $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;

                                        //if to follow strict man hours uncomment this next line;
                                        //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;

                                        //uncomment this next line if you are going to be strict in 8 hour mode;

                                        if ($row->date != date('Y-m-d')):
                                            $totalH = (8 * 60) - $totalUndertimeTardy;
                                        else:
                                            $totalH = 0;
                                        endif;

                                        echo abs(date('H:i', mktime(0, $totalRender))) . 'h ' . abs(date('i', mktime(0, $totalRender))) . 'm';

                                        $renderTime = 0;

                                        if ($totalRender > $totalHoursReq):
                                            $renderTime = $totalHoursReq;
                                        else:
                                            $renderTime = $totalRender;
                                        endif;

                                        $totalHours += abs(date('H', mktime(0, $renderTime)));
                                        $totalMin += date('i', mktime(0, $renderTime));
                                        $overAllTardy += $totalUndertimeTardy;
                                        ?>

                                        <?php if ($this->session->is_superAdmin || $this->session->position == 'Human Resource Department Head' || $this->session->position == 'Human Resource Department Staff' || $this->session->position == 'HRMO Secretary' || $this->session->position == 'Accounting - Admin'): ?>
                                            <div class="position-absolute top-50 end-0 translate-middle-y d-flex gap-2 pe-2">
                                                <i onclick="editTimeData('<?php echo $row->att_id ?>','<?php echo $row->date ?>','<?php echo $row->u_rfid ?>','<?php echo $row->att_st_id ?>')"
                                                    class="fa fa-edit text-success pointer" title="Edit"></i>

                                                <i onclick="delDateTime('<?php echo $row->att_id ?>','<?php echo $row->date ?>')"
                                                    class="fa fa-trash text-danger pointer" title="Delete"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                                unset($totalTimeH);
                                unset($totalTimeM);
                                unset($undertimeAm);
                                unset($undertimePM);
                                unset($totalUndertime);
                                unset($totalUndertimePm);
                                unset($totalUndertimeTardy);
                                $timeInCompute = 0;
                                $timeInPMCompute = 0;
                                $timeOutCompute = 0;
                                $timeOutPMCompute = 0;
                            }
                            $th = abs(date('H', mktime(0, $totalHoursReq)));
                            $tm = abs(date('i', mktime(0, $totalHoursReq)));
                            $tt = round(($tm / 60), 2) + $th;
                            $hoursRequired = (Modules::run('hr/getNumberOfDaysWork', $dateFrom, $dateTo)) * $tt;
                            $leaveDaysCredited = Modules::run('hr/payroll/getLeaveByDates', $dateFrom, $dateTo, $info->employee_id);

                            $dlCredited = 0; // leave days credited
                            foreach ($leaveDaysCredited as $ldc):
                                if ($ldc->pld_is_approved):
                                    $dlCredited += $ldc->pld_num_hours;
                                endif;
                            endforeach;

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="main_content">

</div>
<input type="hidden" id="setAction" />


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
                // $('#editDate').datepicker();
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

        // $('#dateFrom').datepicker();
        $('#dateTo').datepicker();
        // $('#editDate').datepicker();
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