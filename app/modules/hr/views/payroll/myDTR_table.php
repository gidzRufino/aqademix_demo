<!-- <div class="card shadow-sm border-0"> -->
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
            //print_r($officialTime);
            // $officialTimeInAm = $officialTime->ps_from;
            // $officialTimeOutAm = $officialTime->ps_to;
            $totalTimeMorning = round(abs(strtotime($officialTimeInAm) - strtotime($officialTimeOutAm)) / 60, 2);
            //        

            $officialTimeInPm = ($officialTime ? $officialTime->ps_from_pm : '13:00:00');
            $officialTimeOutPm = ($officialTime ? $officialTime->ps_to_pm : '17:00:00');
            // $officialTimeInPm = $officialTime->ps_from_pm;
            // $officialTimeOutPm = $officialTime->ps_to_pm;
            $totalTimeAfternoon = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutPm)) / 60, 2);

            $lunchBreak = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutAm)) / 60, 2);
            $totalHoursReq = $totalTimeMorning + $totalTimeAfternoon;
            $totalHoursReq = ($totalHoursReq >= 450 ? 480 : $totalHoursReq);

            foreach ($records as $row) {
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
                // echo abs(date('H:i', mktime(0, $totalHoursReq))) . 'h ' . abs(date('i', mktime(0, $totalHoursReq))) . 'm';

                //echo $totalUndertimePm+$tardyPm;
                // $totalUndertimeTardy = ($tardyAm + $undertimeAm)+($tardyPm+$undertimePm);

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
                        <td class="overtimeRow fw-semibold" id="<?php echo $row->att_id ?>-<?php echo $overtime ?>" style="width:8%; text-align: center;">
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


                        // echo abs(date('H:i', mktime(0, $totalH))) . 'h ' . abs(date('i', mktime(0, $totalH))) . 'm';
                        echo abs(date('H:i', mktime(0, $totalRender))) . 'h ' . abs(date('i', mktime(0, $totalRender))) . 'm';
                        // echo $totalHoursReq . ' ' . $totalRender;
                        // $totalHours += abs(date('H', mktime(0, $totalH)));
                        // $totalMin += date('i', mktime(0, $totalH));
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
<!-- </div> -->

<style type="text/css">
    .highlight {
        background: greenyellow;
    }
</style>