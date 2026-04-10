<table border="2" style="margin:0; border: 1px solid #DDDDDD;" class="table">
    <tr>
        <td width="10%" rowspan="2">
            <h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5>
        </td>
        <td colspan="2">
            <h5>MORNING</h5>
        </td>
        <td colspan="2">
            <h5>AFTERNOON</h5>
        <td width="5%">
            <h5>UNDERTIME</h5>
        <td>
            <h5>OVERTIME</h5>
        <td width="10%" rowspan="2">
            <h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5>
        </td>
    </tr>
    <tr>
        <td style="width:8%">
            <h5>IN</h5>

        </td>
        <td style="width:8%">
            <h5>OUT</h5>
        </td>
        <td style="width:8%">
            <h5>IN</h5>

        </td>
        <td style="width:8%">
            <h5>OUT</h5>
        </td>
        <td style="width:5%">
        </td>
        <td style="width:8%; text-align: center">
            <?php if ($records): ?>
                <button onclick="$('.overtimeRow').addClass('pointer timeOvr'), $(this).hide(), $('#optBtn').show()" class="btn btn-xs btn-success" id="reqBtn">Request OT</button>
                <div class="btn-group" role="group" id="optBtn" style="display: none;">
                    <button type="button" class="btn btn-success" onclick="$('#optBtn').hide(), $('#reqBtn').show(), saveOT('<?php echo base64_encode($info->employee_id) ?>')" title="Save Overtime"><i class="fa fa-save"></i></button>
                    <button type="button" class="btn btn-danger" onclick="$('#optBtn').hide(), $('#reqBtn').show(), $('#otTime').val(''), $('.overtimeRow').removeClass('highlight pointer timeOvr')" title="Cancel"><i class="fa fa-close"></i></button>
                </div>
            <?php endif; ?>
        </td>
    </tr>
</table>
<table border="2" class='table table-bordered'>
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

        //----------------- Morning -------------------------------------------------------------------
        // if ($timeInCompute != 0): // In AM
        //     $tardyAm = ((strtotime($time_in) - strtotime($officialTimeInAm))) <= 0 ? 0 : (strtotime($time_in) - strtotime($officialTimeInAm)) / 60;
        // else:
        //     $tardyAm = $totalTimeMorning;
        // endif;

        // if ($timeOutCompute != 0):
        //     $undertimeAm = ((strtotime($officialTimeOutAm) - strtotime($time_out))) <= 0 ? 0 : (strtotime($officialTimeOutAm) - strtotime($time_out)) / 60;
        //     $totalUndertime = $tardyAm + $undertimeAm;
        // else:
        //     if ($timeOutCompute == 0):
        //         $totalUndertime = $totalTimeMorning;
        //     else:
        //         $totalUndertime = $tardyAm;
        //     endif;
        // endif;

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

        if ($row->date != date('Y-m-d')):
            $totalUndertimeTardy = $totalUndertime + $totalUndertimePm;
            $overtime = ($totalUndertimeTardy > 0 ? 0 : ($overtime / 60));
        endif;
        $isOT = Modules::run('hr/payroll/getOverTimeByDate', base64_encode($info->employee_id), base64_encode($row->att_id));
    ?>
        <tr>
            <td width="10%">
                <h5><?php echo $row->date ?></h5>

            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_in ?></h5>

            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_out ?></h5>
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_in_pm ?></h5>

            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_out_pm ?></h5>
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo Modules::run('hr/convertToHoursMins', $totalUndertimeTardy) ?></h5>
            </td>
            <?php
            if ($isOT->num_rows() > 0):
            ?>
                <td style="width:8%; text-align: center;">
                    <h5><?php echo Modules::run('hr/convertToHoursMins', $overtime); ?>
                        <?php
                        if ($isOT->row()->is_approve != 0):
                            echo '<i class="fa fa-thumbs-up pull-right" style="color: green" title="OT Approved!!!"></i>';
                        else:
                            if ($isOT->row()->approved_by != ''):
                                echo '<i class="fa fa-thumbs-down pull-right" style="color: red" title="OT Rejected"></i>';
                            else:
                                echo '<i class="fa fa-stopwatch pull-right" style="color: gray" title="OT Pending for approval"></i>';
                            endif;
                        endif;
                        ?>
                    </h5>
                </td>
            <?php
            else:
            ?>
                <td class="overtimeRow" id="<?php echo $row->att_id ?>-<?php echo $overtime ?>" style="width:8%; text-align: center;">
                    <h5><?php echo Modules::run('hr/convertToHoursMins', $overtime); ?></h5>
                </td>
            <?php
            endif;
            ?>
            <!-- <td width="10%" style=" text-align: center;" onmouseover="$('#edit_<?php echo $row->att_id ?>').show()" onmouseout="$('#edit_<?php // echo $row->att_id 
                                                                                                                                                ?>').hide()"> -->
            <td width="10%" style=" text-align: center;">
                <h5 class="pull-left">
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

                </h5>
                <?php if ($this->session->is_superAdmin || $this->session->position == 'Human Resource Department Head' || $this->session->position == 'Human Resource Department Staff' || $this->session->position == 'HRMO Secretary' || $this->session->position == 'Accounting - Admin'): ?>
                    <i onclick="editTimeData('<?php echo $row->att_id ?>','<?php echo $row->date ?>','<?php echo $row->u_rfid ?>','<?php echo $row->att_st_id ?>')" style="margin-top:10px; color: green" id="edit_<?php echo $row->att_id ?>" class="fa fa-edit pull-right pointer"></i>
                    <i onclick="delDateTime('<?php echo $row->att_id ?>','<?php echo $row->date ?>')" style="margin-top:10px; color: red" id="delete_<?php echo $row->att_id ?>" class="fa fa-trash pull-right pointer">&nbsp;</i>
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


</table>

<input type="hidden" id="leaveDaysCredited" value="<?php echo $dlCredited ?>" />
<input type="hidden" id="totalHoursRendered" value="<?php echo round(($totalMin / 60), 2) + $totalHours ?>" />
<input type="hidden" id="hoursRequired" value="<?php echo $hoursRequired ?>" />
<!--<input type="hidden" id="minutesTardy" value="<?php echo abs(date('H', mktime(0, $totalHours))) ?>" />-->
<!-- <input type="hidden" id="minutesTardy" value="<?php // echo date('i', $overAllTardy) 
                                                    ?>" /> -->
<input type="hidden" id="minutesTardy" value="<?php echo date('i', $under) ?>" />
<input type="hidden" id="otTime" />

<style type="text/css">
    .highlight {
        background: greenyellow;
    }
</style>