<input type="hidden" id="dateFrom" value="<?php echo $dateFrom ?>" />
<input type="hidden" id="dateTo" value="<?php echo $dateTo ?>" />
<input type="hidden" id="owners_id" value="<?php echo $owners_id ?>" />
<table style="margin:0; border: 1px solid #DDDDDD;" class="table table-bordered">
    <tr>
        <td width="10%" rowspan="2">
            <h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5>
        </td>
        <td colspan="2">
            <h5>MORNING</h5>
        </td>
        <td colspan="2">
            <h5>AFTERNOON</h5>
        </td>
        <td colspan="2">
            <h5>OVERTIME REQUEST</h5>
        </td>
        <!--<td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5></td>-->
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
        <td style="width:8%">
            <h5>Hours OT</h5>
        </td>
        <td style="width:8%">
            <h5>Action</h5>
        </td>
    </tr>
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

    $totalDayTime = $totalTimeMorning + $totalTimeAfternoon;

    $timeInCompute = 0;
    $timeOutCompute = 0;
    $timeInPMCompute = 0;
    $timeOutPMCompute = 0;
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

        if ($totalRender > 0):
            $under = ($totalHoursReq - $totalRender <= 0 ? 0 : $totalHoursReq - $totalRender);
            $totalRender = $totalRender;
        else:
            $under = 0;
            $totalRender = 0;
        endif;

        if ($row->date != date('Y-m-d')):
            $totalUndertimeTardy = $totalUndertime + $totalUndertimePm;
            $overtime = ($totalUndertimeTardy > 0 ? 0 : ($overtime / 60));
        endif;
        $isOT = Modules::run('hr/payroll/getOverTimeByDate', base64_encode($info->employee_id), base64_encode($row->att_id));

        //============================================= End Overtime ==================================================================================================//

        // $undertimeIn = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderIn, 'in');
        // $undertimePMOut = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderPMOut, 'out');
        // $totalUndertime = $undertimeIn + $undertimePMOut;

    ?>
        <tr>
            <td>
                <h5><?php echo $row->date ?></h5>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_in" att_id="<?php echo $row->att_id ?>" time_option="time_in"><?php echo $time_in ?></h5>

                <div id="editMenu<?php echo $row->att_id ?>-time_in">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_in')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_out" att_id="<?php echo $row->att_id ?>" time_option="time_out"><?php echo $time_out ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_out">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_out')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in_pm">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_in_pm" att_id="<?php echo $row->att_id ?>" time_option="time_in_pm"><?php echo $time_in_pm ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_in_pm">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_in_pm')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>

            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out_pm">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_out_pm" att_id="<?php echo $row->att_id ?>" time_option="time_out_pm"><?php echo $time_out_pm ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_out_pm">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_out_pm')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <td><?php echo ($isOT->num_rows() > 0 ? Modules::run('hr/convertToHoursMins', $overtime) : ''); ?></td>
            <td style="vertical-align: middle" class="text-center" id="td-<?php echo $row->att_id ?>">
                <span id="approve-<?php echo $row->att_id ?>" class="badge badge-success pointer clickover pull-right" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='updateOT(0,<?php echo $info->employee_id ?>, <?php echo $info->uid ?>, <?php echo $hRate ?>, <?php echo $row->att_id ?>, 0)'><i class='fa fa-undo'></i> Revert Action</button>" style="background-color: green; display: none">OT Approved <i class="fa fa-thumbs-up"></i></span>
                <div id="btn-<?php echo $row->att_id ?>" style="display:none;" class="pull-right">
                    <button class="btn btn-sm btn-success" title="Approve?" onclick="updateOT(1, '<?php echo $info->employee_id ?>','<?php echo $info->uid ?>','<?php echo $hRate ?>','<?php echo $row->att_id ?>', 1)"><i class="fa fa-thumbs-up fa-lg"></i></button>
                    <button class="btn btn-sm btn-danger" title="Reject?" onclick="updateOT(0, '<?php echo $info->employee_id ?>','<?php echo $info->uid ?>','<?php echo $hRate ?>','<?php echo $row->att_id ?>', 1)"><i class="fa fa-thumbs-down fa-lg"></i></button>
                </div>
                <span id="reject-<?php echo $row->att_id ?>" class="badge badge-danger pointer clickover pull-right" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='updateOT(0,<?php echo $info->employee_id ?>, <?php echo $info->uid ?>, <?php echo $hRate ?>, <?php echo $row->att_id ?>, 0)'><i class='fa fa-undo'></i> Revert Action</button>" style="background-color: red; display:none">OT Rejected <i class="fa fa-thumbs-down"></i></span>
                <div id="otReq-<?php echo $row->att_id ?>" class="pull-right">
                    <?php
                    if ($isOT->num_rows() > 0):
                        if ($isOT->row()->is_approve == 1):
                    ?>
                            <span class="badge badge-success pointer clickover" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='updateOT(0,<?php echo $info->employee_id ?>, <?php echo $info->uid ?>, <?php echo $hRate ?>, <?php echo $row->att_id ?>, 0)'><i class='fa fa-undo'></i> Revert Action</button>" style="background-color: green;">OT Approved <i class="fa fa-thumbs-up"></i></span>
                            <?php
                        else:
                            if ($isOT->row()->approved_by == ''):
                            ?>
                                <button class="btn btn-sm btn-success" title="Approve?" onclick="updateOT(1, '<?php echo $info->employee_id ?>','<?php echo $info->uid ?>','<?php echo $hRate ?>','<?php echo $row->att_id ?>', 1)"><i class="fa fa-thumbs-up fa-lg"></i></button>
                                <button class="btn btn-sm btn-danger" title="Reject?" onclick="updateOT(0, '<?php echo $info->employee_id ?>','<?php echo $info->uid ?>','<?php echo $hRate ?>','<?php echo $row->att_id ?>', 1)"><i class="fa fa-thumbs-down fa-lg"></i></button>
                            <?php
                            else:
                            ?>
                                <span class="badge badge-danger pointer clickover" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='updateOT(0,<?php echo $info->employee_id ?>, <?php echo $info->uid ?>, <?php echo $hRate ?>, <?php echo $row->att_id ?>, 0)'><i class='fa fa-undo'></i> Revert Action</button>" style="background-color: red;">OT Rejected <i class="fa fa-thumbs-down"></i></span>
                        <?php
                            endif;
                        endif;
                    else: ?>

                    <?php
                    endif; ?>
                </div>
            </td>
            <!--<td width="10%">
                <h5>
                    <?php
                    // if ($timeOutCompute == "" && $timeOutPMCompute != ""):
                    //     $timeOutCompute = 1200;
                    // endif;
                    // if ($timeInPMCompute == "" && $timeOutPMCompute != ""):
                    //     $timeInPMCompute = 1300;
                    // endif;

                    // $HoursAM = $hrdb->getManHours($timeInCompute, $timeOutCompute, $row->date);
                    // $HoursPM = $hrdb->getManHours($timeInPMCompute, $timeOutPMCompute, $row->date);
                    // $totaltimeAM = json_decode($HoursAM);
                    // $totaltimePM = json_decode($HoursPM);

                    // $totalAmH = $totaltimeAM->totalTime;
                    // $totalPmH = $totaltimePM->totalTime;
                    // if ($time_out == "" && $time_out_pm != ""):
                    //     $totalAmH = 4;
                    // endif;


                    // $totalTimeH = $totalAmH + $totalPmH;
                    // $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;

                    // //if to follow strict man hours uncomment this next line;
                    // //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;

                    // //uncomment this next line if you are going to be strict in 8 hour mode;
                    // $totalH = (8 * 60) - $totalUndertime;

                    // echo abs(date('H', mktime(0, $totalH))) . 'h ' . abs(date('i', mktime(0, $totalH))) . 'm';
                    ?>                    
                </h5>
            </td>-->
        </tr>
    <?php
        unset($totalTimeH);
        unset($totalTimeM);
        unset($undertime);
        $timeOutCompute = 0;
        $timeOutPMCompute = 0;
    }
    ?>

    <!--records is taken from controller dtr-->

</table>

<script>
    $(document).ready(function() {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    })
</script>