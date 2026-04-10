<input type="hidden" id="dateFrom" value="<?php echo $dateFrom ?>" />
<input type="hidden" id="dateTo" value="<?php echo $dateTo ?>" />
<input type="hidden" id="owners_id" value="<?php echo $owners_id ?>" />
<div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">
            <i class="fa fa-calendar me-2"></i> Daily Time Record
        </h6>
        <small class="opacity-75">Editable Timesheet</small>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0 text-center">
                <thead class="table-success text-dark sticky-top">
                    <tr class="align-middle">
                        <th rowspan="2" style="min-width:110px;">DATE</th>
                        <th colspan="2">MORNING</th>
                        <th colspan="2">AFTERNOON</th>
                        <th colspan="2">OVERTIME REQUEST</th>
                    </tr>
                    <tr class="small text-uppercase">
                        <th style="width:90px;">IN</th>
                        <th style="width:90px;">OUT</th>
                        <th style="width:90px;">IN</th>
                        <th style="width:90px;">OUT</th>
                        <th style="width:110px;">Hours OT</th>
                        <th style="width:140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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

                    $totalDayTime = $totalTimeMorning + $totalTimeAfternoon;

                    $timeInCompute = 0;
                    $timeOutCompute = 0;
                    $timeInPMCompute = 0;
                    $timeOutPMCompute = 0;
                    $totalUndertimeTardy = 0;
                    $totalUndertime = 0;
                    $overtime = 0;
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

                        //================================================ Overtime Count ===============================================================================================//

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

                        //============================================= End Overtime ==================================================================================================//

                        // $undertimeIn = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderIn, 'in');
                        // $undertimePMOut = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderPMOut, 'out');
                        // $totalUndertime = $undertimeIn + $undertimePMOut;

                    ?>
                        <tr>
                            <td class="fw-semibold text-nowrap">
                                <?php echo $row->date ?>
                            </td>

                            <!-- AM IN -->
                            <td class="time-cell" data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in">
                                <div class="fw-bold text-primary time_input"
                                    id="<?php echo $row->att_id ?>-time_in"
                                    att_id="<?php echo $row->att_id ?>"
                                    time_option="time_in">
                                    <?php echo $time_in ?>
                                </div>
                            </td>

                            <!-- AM OUT -->
                            <td class="time-cell" data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out">
                                <div class="fw-bold text-primary time_input"
                                    id="<?php echo $row->att_id ?>-time_out"
                                    att_id="<?php echo $row->att_id ?>"
                                    time_option="time_out">
                                    <?php echo $time_out ?>
                                </div>
                            </td>

                            <!-- PM IN -->
                            <td class="time-cell" data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in_pm">
                                <div class="fw-bold text-primary time_input"
                                    id="<?php echo $row->att_id ?>-time_in_pm"
                                    att_id="<?php echo $row->att_id ?>"
                                    time_option="time_in_pm">
                                    <?php echo $time_in_pm ?>
                                </div>
                            </td>

                            <!-- PM OUT -->
                            <td class="time-cell" data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out_pm">
                                <div class="fw-bold text-primary time_input"
                                    id="<?php echo $row->att_id ?>-time_out_pm"
                                    att_id="<?php echo $row->att_id ?>"
                                    time_option="time_out_pm">
                                    <?php echo $time_out_pm ?>
                                </div>
                            </td>

                            <!-- OT HOURS -->
                            <td class="fw-semibold text-success">
                                <?php echo Modules::run('hr/convertToHoursMins', $overtime); ?>
                            </td>

                            <!-- ACTION -->
                            <td class="text-nowrap" id="td-<?php echo $row->att_id ?>">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    <div id="otReq-<?php echo $row->att_id ?>">

                                        <?php if ($isOT->num_rows() > 0): ?>
                                            <?php
                                            $otRow = $isOT->row();
                                            $empId  = $info->employee_id;
                                            $uid    = $info->uid;
                                            $rate   = $hRate;
                                            $attId  = $row->att_id;
                                            ?>

                                            <?php if ($otRow->is_approve == 1): ?>

                                                <!-- APPROVED -->
                                                <div class="dropdown d-inline-block text-center position-relative approve-<?php echo $attId ?>">
                                                    <span class="badge bg-success dropdown-toggle pointer d-block"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        role="button">
                                                        OT Approved <i class="fa fa-thumbs-up ms-1"></i>
                                                    </span>

                                                    <ul class="dropdown-menu shadow text-center p-0"
                                                        style="z-index:1080; min-width:100%;">
                                                        <li>
                                                            <span class="badge bg-warning w-100 py-2 pointer"
                                                                onclick="updateOT(0,'<?php echo $empId ?>','<?php echo $uid ?>','<?php echo $rate ?>','<?php echo $attId ?>',0)">
                                                                <i class="fa fa-undo me-2"></i> Revert Action
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>

                                            <?php elseif ($otRow->approved_by == ''): ?>

                                                <!-- PENDING (SHOW BUTTONS) -->
                                                <button class="btn btn-sm btn-success"
                                                    title="Approve?"
                                                    onclick="updateOT(1,'<?php echo $empId ?>','<?php echo $uid ?>','<?php echo $rate ?>','<?php echo $attId ?>',1)">
                                                    <i class="fa fa-thumbs-up"></i>
                                                </button>

                                                <button class="btn btn-sm btn-outline-danger"
                                                    title="Reject?"
                                                    onclick="updateOT(0,'<?php echo $empId ?>','<?php echo $uid ?>','<?php echo $rate ?>','<?php echo $attId ?>',1)">
                                                    <i class="fa fa-thumbs-down"></i>
                                                </button>

                                            <?php else: ?>

                                                <!-- REJECTED -->
                                                <div class="dropdown d-inline-block text-center position-relative reject-<?php echo $attId ?>">
                                                    <span class="badge bg-danger dropdown-toggle pointer d-block"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        role="button">
                                                        OT Rejected <i class="fa fa-thumbs-down ms-1"></i>
                                                    </span>

                                                    <ul class="dropdown-menu shadow text-center p-0"
                                                        style="z-index:1080; min-width:100%;">
                                                        <li>
                                                            <span class="badge bg-warning w-100 py-2 pointer"
                                                                onclick="updateOT(0,'<?php echo $empId ?>','<?php echo $uid ?>','<?php echo $rate ?>','<?php echo $attId ?>',0)">
                                                                <i class="fa fa-undo me-2"></i> Revert Action
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>

                                            <?php endif; ?>

                                        <?php endif; ?>

                                    </div>

                                </div>
                            </td>
                        </tr>
                    <?php
                        unset($totalTimeH);
                        unset($totalTimeM);
                        unset($undertime);
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
                    ?>

                    <!--records is taken from controller dtr-->

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    })

    document.querySelectorAll('[rel="clickover"]').forEach(el => {
        new bootstrap.Popover(el, {
            html: true,
            placement: 'left',
            trigger: 'focus'
        });
    });

    document.getElementById('viewDTR').addEventListener('shown.bs.modal', function() {
        document.querySelectorAll('#viewDTR [data-bs-toggle="popover"]').forEach(el => {
            new bootstrap.Popover(el, {
                html: true,
                sanitize: false, // allow button HTML
                container: 'body', // prevents clipping inside modal
                trigger: 'focus'
            });
        });
    });
</script>