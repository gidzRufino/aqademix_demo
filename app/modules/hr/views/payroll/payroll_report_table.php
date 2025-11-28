<table style="width:100%;" class="table table-bordered table-striped table-hover payrollTable text-center">

    <tr class="head" style="font-weight:bold; border-bottom: 2px solid black;">
        <td style="width:10px;">Avatar</td>
        <td style="width:150px;">Name of Employee</td>
        <td style="width:50px;">Position</td>
        <td class="afterThis">Gross Pay</td>
        <?php
        $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
        $income = Modules::run('hr/payroll/getAdditionalIncome', $pc_code);
        $defaults = Modules::run('hr/payroll/getPayrollDefaults', '0');
        $pdefaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
        $amortizedDeduction = Modules::run('hr/payroll/getAmortizedDeduction', $pc_code);

        if ($income):
            foreach ($income as $additional):
                if ($additional->pi_item_type == 1):
        ?>
                    <td><?php echo $additional->pi_item_name ?></td>
                <?php
                endif;
            endforeach;
        else:
            $income = Modules::run('hr/payroll/getAdditionalIncome', $pc_code - 1);

            foreach ($income as $additional):
                if ($additional->pi_item_type == 1):
                ?>
                    <td><?php echo $additional->pi_item_name ?></td>
                <?php
                endif;
            endforeach;
        endif;
        foreach ($pdefaults as $d) :
            if ($d->pi_is_default != 2) :
                ?>
                <td><?php echo $d->pi_item_name ?></td>

            <?php
            endif;
        endforeach;

        foreach ($defaults as $d) :
            if ($d->pi_is_default != 2) :
            ?>
                <td><?php echo $d->pi_item_name ?></td>

            <?php
            endif;
        endforeach;

        if ($amortizedDeduction):
            foreach ($amortizedDeduction as $ad) :
            ?>
                <td><?php echo $ad->pi_item_name ?></td>

            <?php
            endforeach;
        endif;

        foreach ($charge as $deductions) :
            if ($deductions->is_default != 1 && $deductions->pi_item_cat != 2):
            ?>
                <td><?php echo $deductions->pi_item_name ?></td>
        <?php
            endif;
        endforeach;
        ?>

        <td>Other Deductions</td>
        <td>Total Deductions</td>
        <td>NetPay</td>
        <td></td>
    </tr>
    <?php
    $salaryTotal = 0;
    $sssTotal = 0;
    $phTotal = 0;
    $pagibigTotal = 0;
    $tinTotal = 0;
    $contTotal = 0;
    $netTotal = 0;
    $total = 0;
    $totalOd = 0;
    $totalNet = 0;
    $totalGross = 0;
    $totalNetPay = 0;
    $addOnTotal = 0;
    $statTotal = 0;
    $totalDeductibleTardy = 0;
    $overAllDeductibleTardy = 0;
    $netPay = 0;
    $totalOD = 0;
    $totalStats = 0;
    $td = 0;
    $absent = 0;

    $lrn = 0;
    foreach ($getPayrollReport as $pr):
        $lrn++;
        $employee = Modules::run('hr/getEmployeeName', $pr->pmh_em_id);
        $getPayrollHours = Modules::run('hr/payroll/getPayrollReport', $pc_code, $pr->pmh_em_id);
        $st = date('j', strtotime($startDate));
        $en = date('j', strtotime($endDate));
        $ym = date('Y-m', strtotime($startDate));
        for ($a = $st; $a <= $en; $a++):
            $att = Modules::run('hr/payroll/attendanceCheck', $employee->employee_id, ($ym . '-' . ($a < 10 ? '0' . $a : $a)));
            if ($att->num_rows() > 0):
                $td++;
            endif;
        endfor;

        $leaveDaysCredited = Modules::run('hr/payroll/getLeaveByDates', $startDate, $endDate, $employee->employee_id);
        $dlCredited = 0; // leave days credited
        foreach ($leaveDaysCredited as $ldc):
            if ($ldc->pld_is_approved):
                $dlCredited += $ldc->pld_num_hours;
            endif;
        endforeach;
        $leave = $dlCredited / 8;

        $totalHoursRendered = 0;
        foreach ($getPayrollHours as $ph):
            $totalHoursRendered += $ph->pmh_num_hours;
        endforeach;

        switch ($employee->pay_type):
            case 0:
                $over = 2;
                break;
            case 1:
                $over = 1;
                break;
            case 2:
                $over = 4;
                break;
        endswitch;


        $workdays = Modules::run('hr/getNumberOfDaysWork', $startDate, $endDate);
        $officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $employee->time_group_id);
        //print_r($officialTime);
        $officialTimeInAm = ($officialTime ? $officialTime->ps_from : '08:00:00');
        $officialTimeOutAm = ($officialTime ? $officialTime->ps_to : '12:00:00');
        $totalTimeMorning = round(abs(strtotime($officialTimeInAm) - strtotime($officialTimeOutAm)) / 60, 2);
        //        
        $officialTimeInPm = ($officialTime ? $officialTime->ps_from_pm : '13:00:00');
        $officialTimeOutPm = ($officialTime ? $officialTime->ps_to_pm : '17:00:00');
        $totalTimeAfternoon = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutPm)) / 60, 2);

        $lunchBreak = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutAm)) / 60, 2);
        $totalHoursReq = $totalTimeMorning + $totalTimeAfternoon;
        $totalHoursReq = ($totalHoursReq >= 450 ? 480 : $totalHoursReq);
        $hrs = $totalHoursReq / 60;

        $lc = Modules::run('hr/payroll/getTotalLeaveSpent', $employee->employee_id, 1, $pc_code);

        $th = abs(date('H', mktime(0, $totalHoursReq)));
        $tm = abs(date('i', mktime(0, $totalHoursReq)));
        $tt = round(($tm / 60), 2) + $th;

        $expectedHours = $workdays * $tt;

        $ttime = 0;
        // if ($employee->pay_type):
        //     switch ($employee->pg_id):
        //         case 1:
        //             $basic = $employee->salary;
        //             $salary = $basic;
        //             break;
        //         case 2:
        //             $basic = $employee->salary / 2;
        //             $hourly = ($basic / $workdays) / $hrs;
        //             $daily = $hourly * $hrs;
        //             $salary = $totalHoursRendered * $hourly;
        //             break;
        //     endswitch;
        // else:
        switch ($employee->pg_id):
            case 1: // ---------------Monthly Type ---------------------//
                $basic = $employee->salary;
                $hourly = ($basic / $workdays) / $hrs;
                $daily = $hourly * $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 2: // -------------- Semi Monthly Type
                $basic = $employee->salary / 2;
                $hourly = ($basic / $workdays) / $hrs;
                $daily = $hourly * $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 3: // -------------- Weekly type ---------------------//
                $basic = $employee->salary;
                $daily = $basic / 5;
                $hourly = $daily / $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 4: // ------------ Daily Type ----------------------//
                $hourly = ($employee->salary / $hrs);
                $basic = $employee->salary;
                $daysRendered = $totalHoursRendered / $hrs;
                $salary = $basic * $daysRendered;
                break;
            case 5: // ------------ Hourly type ---------------------//
                $hourly = $employee->salary;
                $salary = $totalHoursRendered * $hourly;
                break;
        endswitch;
        // endif;

        // echo $totalHoursRendered;
        // $expectedHours = $workdays * 8;

        // if ($totalHoursRendered >= $expectedHours):
        //     $salary = $employee->salary / $over;
        // else:
        //     $hourly = round(($employee->salary / 22) / 8, 0, PHP_ROUND_HALF_UP);
        //     $salary = $hourly * $totalHoursRendered;
        // endif;

        // $days = Modules::run('hr/hrdbprocess/getPayrollTimes', $employee->user_id, $startDate, $endDate, $employee->time_group_id);
        // $days = json_decode($days);

        // $totalHourTardy = round($hourly * ($days->undertime / 60), 2, PHP_ROUND_HALF_UP);

        $absent = ($workdays * 8) - $totalHoursRendered - ($leave * 8);

        if ($absent > 0):
            $otherDeduction += ($absent * $hourly);
        else:
            $absInHrs = 0;
        endif;

        // $otherDeduction += $totalHourTardy;

        $ptrans = Modules::run('hr/payroll/checkTransaction', $employee->user_id, $pc_code);
    ?>
        <tr id="tr_<?php echo $employee->uid; ?>">
            <td style="text-align: center"><img class="img-circle" style="width:30px;" src="<?php echo base_url() . 'uploads/' . $employee->avatar ?>" /></td>
            <td class="pointer" onclick="document.location = '<?php echo base_url('hr/viewTeacherInfo/' . base64_encode($employee->employee_id)) ?>'"><?php echo strtoupper($employee->lastname . ', ' . $employee->firstname) ?></td>
            <td><?php echo strtoupper($employee->position) ?></td>
            <td id="<?php echo $employee->user_id ?>_td" td_id="td_<?php echo $employee->uid; ?>_<?php echo $d->pi_item_id ?>" tdvalue="<?php echo $basic ?>" class="afterValue"><?php echo number_format(round($basic, 2), 2, '.', ',') ?></td>
            <?php
            $totalStat = 0;
            $totalNetPayroll = 0;
            $items = 1;
            $item = 1;
            $deduct = array();
            $additionalIncome = 0;
            foreach ($income as $additional):
                if ($additional->pi_item_type == 1):
                    $add = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, $pc_code, $employee->user_id);
                    if (!empty($add->row())):
                        $additionalIncome += $add->row()->pc_amount;
                    else:
                        if ($additional->pi_item_cat == 2):
                            $addB = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, ($pc_code - 1), $employee->user_id);
                            if (!empty($addB->row())):
                                $additionalIncome += $addB->row()->pc_amount;
                                Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $additional->pi_item_id, $additionalIncome, $pc_code, 0);
                            else:
                                $additionalIncome += 0;
                            endif;
                        endif;
                    endif;
            ?>
                    <td><?php echo number_format($additionalIncome, 2) ?></td>
                <?php
                endif;
            endforeach;
            foreach ($pdefaults as $d) : //=====================================================>> Statutory Benefits
                $items++;
                $c = Modules::run('hr/payroll/getPayrollChargesByItem', $d->pi_item_id, $pc_code, $employee->user_id);
                if ($d->pi_is_default != 2) :
                    // if (!empty($c->row())) :
                    //     $amount = round($c->row()->pc_amount, 2);
                    // else :
                    switch ($d->pi_item_id):
                        case 1: //==================================================>> SSS
                            $equivalent = Modules::run('hr/payroll/getSSSTableEquivalent', $employee->salary);
                            $amount = $equivalent;
                            break;
                        case 2: //==================================================>> PhilHealth
                            if ($employee->salary <= 10000) :
                                $amount = ($d != null ? $d->pi_default : 0);
                            else :
                                // $tmpAmount = $employee->salary * 0.01375;
                                $tmpAmount = $employee->salary * 0.025;

                                $amount = ($d->pi_default != 0 ? $d->pi_default : $tmpAmount);
                            endif;
                            break;
                        case 3: //=================================================>> Pag-Ibig
                            $amount = $employee->salary * .02;
                            break;
                        default:
                            $amount = ($d != null ? $d->pi_default : 0);
                            break;
                    endswitch;
                    Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $d->pi_item_id, $amount, $pc_code);
                    // endif;
                ?>
                    <td id="td_<?php echo $employee->user_id; ?>_<?php echo $d->pi_item_id ?>" class="defaults_<?php echo $employee->user_id; ?> tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                        td_value="<?php echo $amount ?>"
                        td_item_id="<?php echo $d->pi_item_id ?>"><?php echo number_format($amount, 2) ?></td>

                <?php
                else :
                    $amount = $c->row()->pc_amount;
                endif;
                $totalStat += $amount;
            endforeach;
            foreach ($defaults as $d) : //==================================>>> FSA Dues
                $items++;
                $c = Modules::run('hr/payroll/getPayrollChargesByItem', $d->pi_item_id, $pc_code, $employee->user_id);
                if ($d->pi_is_default != 2) :
                    if (!empty($c->row())) :
                        $amount = round($c->row()->pc_amount, 2);
                    else :
                        $amount = ($d->pi_default != 0 ? $d->pi_default : 0);
                        Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $d->pi_item_id, $amount, $pc_code);
                    endif;
                ?>
                    <td id="td_<?php echo $employee->user_id; ?>_<?php echo $d->pi_item_id ?>" class="defaults_<?php echo $employee->user_id; ?> tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                        td_value="<?php echo $amount ?>"
                        td_item_id="<?php echo $d->pi_item_id ?>"><?php echo number_format($amount, 2) ?></td>

                <?php
                else :
                    $amount = $c->row()->pc_amount;
                endif;
                $totalStat += $amount;
            endforeach;

            if ($amortizedDeduction): //==========================>>> Coop Loan
                foreach ($amortizedDeduction as $ad) :
                    $cad = Modules::run('hr/payroll/getPayrollChargesByItem', $ad->pi_item_id, $pc_code, $employee->user_id);

                    if (!empty($cad->row())) :
                        $cadAmount = $cad->row()->pc_amount;

                    else :
                        $cad = Modules::run('hr/payroll/getPayrollChargesByItem', $ad->pi_item_id, ($pc_code - 1), $employee->user_id);
                        //print_r($cad->row());
                        if (!empty($cad->row())) :
                            $cadAmount = $cad->row()->pc_amount;
                            if (Modules::run('hr/payroll/updateAmortizationStatus', $employee->employee_id, $ad->pi_item_id, $cadAmount, $pc_code)):
                                Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $ad->pi_item_id, $cadAmount, $pc_code, $cad->row()->pc_amort_id);
                            else:
                                $cadAmount = 0;
                            endif;
                        else:
                            $amortValue = Modules::run('hr/payroll/getAmortValue', $employee->employee_id, $ad->pi_item_id);
                            $dateApplied = strtotime($ad->pa_date_started);

                            if ($pc_code >= $ad->pa_pp_id):
                                $cadAmount = $amortValue->pa_amort_amount;
                                if (Modules::run('hr/payroll/updateAmortizationStatus', $employee->employee_id, $ad->pi_item_id, $cadAmount, $pc_code)):
                                    Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $ad->pi_item_id, $cadAmount, $pc_code, $amortValue->pa_id);
                                else:
                                    $cadAmount = 0;
                                endif;
                            else:
                                $cadAmount = 0;
                            endif;
                        endif;

                    endif;
                ?>
                    <td><?php echo number_format($cadAmount, 2, '.', ',') ?></td>

                    <?php
                    $totalStat += $cadAmount;
                endforeach;
            else:
            // this portion is for automatic deduction of share capital

            endif;

            foreach ($charges as $deductions) :
                $items++;
                if ($deductions->pi_is_default != 1 && $deductions->pi_item_cat != 2):
                    $charge = Modules::run('hr/payroll/getPayrollChargesByItem', $deductions->pc_item_id, $pc_code, $employee->user_id);
                    $amount = ((!empty($charge->row())) ? $charge->row()->pc_amount : 0);

                    if ($charge->row()):
                    ?>
                        <td id="td_<?php echo $employee->user_id; ?>_<?php echo $deductions->pi_item_id ?>" class="tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                            td_value="<?php echo $amount ?>"><?php echo number_format($amount, 2, '.', ',') ?></td>

            <?php
                        if ($charge->row() != null) :
                            if ($charge->row()->pi_item_type == 1) :
                                $addOn += $amount;
                            else :
                                $totalStat += $amount;
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
            $netPayLessDeduction = ($basic + $additionalIncome) - ($otherDeduction);
            $totalNet = (($netPayLessDeduction) - ($totalStat));
            ?>

            <td><?php echo number_format($otherDeduction, 2, '.', ','); ?></td>
            <td><?php echo number_format(($otherDeduction + $totalStat), 2, '.', ',') ?></td>
            <td data-toggle="context" data-target="#extraMenu" onmouseover="$('#pro_id').val('<?php echo $employee->user_id ?>'), $('#recalcPC_code').val('<?php echo $pc_code ?>')" style="<?php echo ($totalNet < 50 ? 'background-color:rgb(217, 83, 79); color:white;' : '') ?>;"><?php echo number_format($totalNet, 2, '.', ',') ?></td>
            <td style="width:25%">
                <div class="btn-group">
                    <button onclick="getDateFrom('<?php echo $startDate ?>', '<?php echo $endDate ?>', '<?php echo $employee->user_id ?>', '<?php echo base64_encode($employee->employee_id) ?>', '<?php echo $hourly ?>')" class="btn btn-xs btn-primary ">View Time Attendance</button>
                    <button onclick="$('#addCharges').modal('show'),
                                        $('#grossPay').html($('#<?php echo $employee->user_id ?>_td').attr('tdvalue'));
                                loadPayrollDeduction('<?php echo $startDate ?>', '<?php echo $endDate ?>', '<?php echo $employee->user_id ?>',
                                        '<?php echo $pc_code ?>', '<?php echo $employee->employee_id ?>', '<?php echo $totalNet; ?>'),
                                        $('#pc_code').val('<?php echo $pc_code ?>'), $('#netPay').html('<?php echo round($totalNet, 2); ?>')"
                        class="btn btn-xs btn-danger " <?php echo ($ptrans ? ($ptrans->ptrans_status) ? "disabled" : "" : ""); ?>>
                        Addition / Deduction
                    </button>
                    <button id="approveBtn_<?php echo $employee->user_id ?>" style="display:<?php echo ($ptrans == null ? '' : 'none') ?>" onclick="approvePayroll('<?php echo $employee->user_id ?>', '<?php echo $totalNet ?>', '<?php echo $pc_code ?>', '<?php echo $employee->user_id ?>')" class="btn btn-xs btn-warning">Approve</button>
                    <!--<button onclick="loanPayment('<?php echo $employee->user_id ?>')" class="btn btn-xs btn-warning">Approve</button>-->
                    <button style="display: <?php echo ($ptrans ? ($ptrans == null ? 'none' : '') : '') ?>" id="releaseBtn_<?php echo $employee->user_id ?>" onclick="releasePayroll('<?php echo $employee->user_id ?>', '<?php echo $totalNet ?>', '<?php echo $pc_code ?>', '<?php echo $employee->user_id ?>')" <?php echo ($ptrans ? ($ptrans->ptrans_status ? 'disabled' : '') : '') ?> class="btn btn-xs <?php echo ($ptrans ? ($ptrans->ptrans_status ? 'btn-success' : 'btn-danger') : '') ?>"><?php echo ($ptrans ? ($ptrans->ptrans_status ? 'Released' : 'Release') : '') ?></button>
                    <button class="btn btn-xs btn-danger" <?php echo ($ptrans ? ($ptrans->ptrans_status) ? "disabled" : "" : ""); ?> onclick="$('#delWarningMsg').modal('show'), $('#emID').val('<?php echo base64_encode($employee->employee_id) ?>'), $('#pcID').val('<?php echo base64_encode($pc_code) ?>'), $('#uID').val('<?php echo base64_encode($employee->user_id) ?>')"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        </tr>
    <?php
        $td = 0;
        $totalNetPay += $netPayLessDeduction;
        $totalGross += $salary;
        $totalOD += $totalStat;
        $otherDeduction = 0;
    endforeach;  //end of Payroll Report
    $totalTardy = 0;
    ?>
    <!--<tr style='border-top-style:double; font-weight: bold;'>
    <td colspan="2">Total</td>
    <td></td>
    <td><?php echo number_format($totalGross, 2, '.', ','); ?></td>
    <?php
    $items = 1;

    $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
    if ($charges):
        foreach ($charges as $d):
            if ($d->pi_item_type == 1):
                $items++;
    ?>
                                               <td class="total_<?php echo $items ?>" ></td>

                <?php
            endif;
        endforeach;
        foreach ($charges as $d):
            if ($d->pi_item_type != 1):
                if ($d->pi_is_default == 1):
                    $items++;
                ?>
                                                       <td class="total_<?php echo $items ?>" ></td>

                    <?php
                endif;
            endif;
        endforeach;
        foreach ($charges as $d):
            if ($d->pi_item_type != 1):
                if ($d->pi_is_default != 1):
                    $items++;
                    ?>
                                                       <td class="total_<?php echo $items ?>" ></td>

                    <?php
                endif;
            endif;
        endforeach;


    else:
        $defaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
        foreach ($defaults as $d):
            if ($d->pi_is_default != 2):
                $items++;
                    ?>
                                               <td></td>

                <?php
            endif;
        endforeach;

    endif;
                ?>
    <td><?php echo number_format($totalTardy, 2, '.', ','); ?></td>
    <td><?php echo number_format($totalOD, 2, '.', ','); ?></td>
    <td><?php echo number_format($totalNetPay, 2, '.', ','); ?></td>
    <td></td>-->
    </tr>
</table>
<input type="hidden" id="charges" value="<?php echo $items; ?>" />
<input type="hidden" id="totalNetIncome" />
<input type="hidden" id="pro_id" />
<input type="hidden" id="recalcPC_code" />


<div id="extraMenu">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer text-danger" onclick="recalculatePayrollCharges($('#pro_id').val(), $('#recalcPC_code').val())"><i class="fa fa-refresh fa-fw"></i>RECALCULATE CHARGES</li>
    </ul>
</div>

<div id="delWarningMsg" style="margin: 10% auto;" class="modal fade col-lg-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span>Are you sure you want to delete the payroll? This action cannot be undone!</span>
        </div>
        <div class="panel-body" id="delMsgBody">

        </div>
        <div class=" panel-footer clearfix">
            <div class='pull-right'>
                <input type="hidden" id="emID" />
                <input type="hidden" id="pcID" />
                <input type="hidden" id="uID" />
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                <a href='#' data-dismiss='clickover' onclick='deletePayroll()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Proceed</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        getTotal();
    });



    function recalculatePayrollCharges(profile_id, code) {
        $.ajax('<?php echo site_url('hr/payroll/recalculatePayrollCharges'); ?>', {
            type: "POST",
            data: {
                pc_code: code,
                pro_id: profile_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                alert(data);
                location.reload();
            }
        });
    }


    function loadPayrollDeduction(dateFrom, dateTo, owners_id, pc_code, employee_id, netPay) {
        var grossPay = $('#' + owners_id + '_td').attr('tdvalue');
        var url = "<?php echo base_url() ?>hr/payroll/loadPayrollDeduction"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "owners_id=" + owners_id + "&grossPay=" + grossPay + "&partialNet=" + netPay + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&pc_code=" + pc_code + "&employee_id=" + employee_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#payrollDeductionBody').html(data)
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function getDateFrom(dateFrom, dateTo, owners_id, emp_id, hourly) {
        var url = "<?php echo base_url() ?>hr/searchDTRbyDateForPayroll"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "owners_id=" + owners_id + '&emp_id=' + emp_id + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + '&hRate=' + hourly + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#viewDTR').modal('show');
                $('#dtrBody').html(data)

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function doEdit(cid) {
        var val = parseFloat($("#" + cid).html());
        var newVal = 0;
        var writtenValue = 0;
        var trVal = $("#" + cid).attr('tr_value');
        var newTrVal = "";
        if ($("#" + cid).attr('td_value') != 0) {
            $("#" + cid).html("<input type='number' class='no-border' style='width:50px;' id='userinput' value='" + val + "'>");
            $("#userinput").focus().select();
            $("#userinput").keydown(function(e) {
                newVal = parseFloat($(this).val());
                writtenValue = numberWithCommas(newVal.toFixed(2));
                newTrVal = trVal.replace(val, newVal);
                if (e.which == 13) {
                    e.preventDefault();
                    $("#" + cid).attr('td_value', newVal);
                    $("#" + cid).attr('tr_value', newTrVal);
                    $("#" + cid).html(writtenValue);
                    getTotal();
                    $('#notificationAlert').show().fadeOut(5000)
                    $('#notificationAlert').html('Successfully Saved!');
                }
            });
            $("#userinput").focusout(function() {
                $("#" + cid).attr('td_value', val);
                $("#" + cid).html(val);

            });


        }

    }

    function saveDefaultDeduction(user_id, pc_code, em_id) {
        $('td.defaults_' + user_id).each(function() {
            if ($(this).attr('td_value') != 0) {
                //alert($(this).attr('td_value'));
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'hr/payroll/addDeduction' ?>',
                    //dataType: 'json',
                    data: {
                        item_id: $(this).attr('td_item_id'),
                        amount: $(this).attr('td_value'),
                        pc_code: pc_code,
                        em_id: em_id,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function(response) {

                    }

                });
            }
        });
    }

    function releasePayroll(em_id, netPay, pc_code, user_id) {
        var url = "<?php echo base_url() . 'hr/payroll/releasePayroll/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                em_id: em_id,
                netPay: netPay,
                pc_code: pc_code,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },

            beforeSend: function() {
                //$('#consolidatedPayroll').html('<b class="text-center">Please Wait while Payroll is generating...</b>')
            },
            success: function(data) {
                $('#releaseBtn_' + user_id).removeClass('btn-danger');
                $('#releaseBtn_' + user_id).addClass('btn-success');
                $('#releaseBtn_' + user_id).attr('disabled', 'disabled');
                $('#releaseBtn_' + user_id).html('Released');

                $('#notificationAlert').show().fadeOut(5000)
                $('#notificationAlert').html('Successfully Saved!');
            }
        });

        return false; // avoid to execute the actual submit of the form
    }

    function approvePayroll(em_id, netPay, pc_code, user_id) {
        var approve = confirm('Do you really want to confirm the payroll of this employee?');

        if (approve) {
            var url = "<?php echo base_url() . 'hr/payroll/approvePayroll/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    em_id: em_id,
                    netPay: netPay,
                    pc_code: pc_code,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },

                beforeSend: function() {
                    //$('#consolidatedPayroll').html('<b class="text-center">Please Wait while Payroll is generating...</b>')
                },
                success: function(data) {
                    //loanPayment(user_id, pc_code, em_id);
                    //saveDefaultDeduction(user_id, pc_code, em_id);
                    $('#deduction_' + user_id).addClass('disabled');
                    $('#approveBtn_' + user_id).html('confirmed');
                    $('#approveBtn_' + user_id).removeClass('btn-warning');
                    $('#approveBtn_' + user_id).addClass('btn-success');

                }
            });

            return false; // avoid to execute the actual submit of the form
        }
    }

    function getTotal() {
        var charges = $('#charges').val();
        var total = 0;
        for (var i = 1; i <= charges; i++) {
            $('.tdValue_' + i).each(function() {
                total += parseFloat($(this).attr('td_value'))
            })

            //			alert(total);
            $('.total_' + i).text(numberWithCommas(Number(total.toFixed(1)).toFixed(2)))

            total = 0;

        }

    }

    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function deletePayroll() {
        var employee_id = $('#emID').val();
        var pc_code = $('#pcID').val();
        var user_id = $('#uID').val();
        var url = '<?php echo base_url() . 'hr/payroll/deletePayrollByEmployee/' ?>' + employee_id + '/' + pc_code + '/' + user_id;

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',

            beforeSend: function() {
                $('#delMsgBody').html('<img class="center-block" src="<?php echo base_url() . 'images/symbols/loading3.gif' ?>" style="width: 100px; height: 60px;" />');
            },

            success: function(data) {
                if (data.status) {
                    $('#delMsgBody').html('<em class="center-block" style="color: green;"> ' + data.msg + '</em>');
                } else {
                    $('#delMsgBody').html('<em class="center-block" style="color: red;"> ' + data.msg + '</em>');
                }

                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }

    function updateOT(val, emp_id, user_id, hRate, att_id, opt) {
        var pc_code = '<?php echo $pc_code ?>';
        var url = '<?php echo base_url() . 'hr/payroll/updateOverTime/' ?>' + emp_id + '/' + att_id + '/' + val + '/' + opt + '/' + pc_code + '/' + user_id + '/' + hRate;

        $('.clickover').popover('hide');
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                $('#otReq-' + att_id).hide();
                switch (data.appr) {
                    case 0:
                        $('#reject-' + att_id).show();
                        $('#btn-' + att_id).hide();
                        $('#approve-' + att_id).hide();
                        break;
                    case 1:
                        $('#reject-' + att_id).hide();
                        $('#btn-' + att_id).hide();
                        $('#approve-' + att_id).show();
                        break;
                    case 2:
                        $('#reject-' + att_id).hide();
                        $('#btn-' + att_id).show();
                        $('#approve-' + att_id).hide();
                        break;
                }
            }
        })
    }
</script>