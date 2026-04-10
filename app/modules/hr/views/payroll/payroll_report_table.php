<style>
    /* Position column */
    .payrollTable td.position-col,
    .payrollTable th.position-col {
        white-space: normal !important;
        /* override nowrap */
        word-break: break-word;
        /* wrap long words */
        overflow-wrap: break-word;
        /* ensure very long text wraps */
        max-width: 200px;
        /* optional: control width */
    }

    /* Card wrapper (DO NOT block sticky) */
    .payroll-card {
        border-radius: 14px;
        border: 1px solid #e9ecef;
        background: #fff;
        overflow: visible;
        /* IMPORTANT: allow sticky cells */
    }

    /* Scroll container only */
    .table-responsive {
        overflow-x: auto;
        /* keep horizontal scroll */
        overflow-y: hidden;
        /* enable vertical scroll */
        max-height: 600px;
        /* optional: set a max height to allow vertical scroll */
        position: relative;
    }

    /* Sticky header */
    .payrollTable thead th {
        position: sticky;
        top: 0;
        z-index: 60;
        background: linear-gradient(180deg, #343a40, #212529);
        color: #fff;
    }

    /* Sticky Actions column */
    .payrollTable .action-col {
        position: sticky;
        right: 0;
        width: 110px;
        min-width: 110px;
        background: #fff;
        z-index: 45;
        text-align: center;
    }

    /* Ensure header cell stays above body cells */
    .payrollTable thead .action-col {
        z-index: 70;
        background: linear-gradient(180deg, #343a40, #212529) !important;
        color: #fff !important;
    }

    /* Popover panel */
    .action-popover {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
        padding: 6px;
        display: none;
        z-index: 40;
    }

    .action-popover .btn-group {
        display: flex;
        gap: 4px;
        flex-wrap: nowrap;
    }

    /* Compact buttons */
    .action-btns .btn {
        padding: 2px 6px;
        font-size: 11px;
    }

    .action-toggle {
        border-radius: 50px;
        font-size: 12px;
        padding: 5px 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .payrollTable {
        table-layout: fixed;
        /* enforce fixed layout */
        width: 100%;
        /* stretch to container width */
        min-width: 1800px;
        /* total minimum width */
    }

    /* Other key columns: give min-width */
    .payrollTable th,
    .payrollTable td {
        min-width: 80px;
        /* set reasonable minimum for all other columns */
        white-space: nowrap;
        /* prevent breaking numbers/labels */
    }

    /* Amount badges */
    .amount-pill {
        padding: 6px 10px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 12px;
        display: inline-block;
        min-width: 90px;
        white-space: nowrap;
    }

    .pill-income {
        background: #e7f5ff;
        color: #0b5ed7;
    }

    .pill-deduct {
        background: #fff4e6;
        color: #d9480f;
    }

    .pill-net {
        background: #e6fcf5;
        color: #099268;
    }

    .net-danger {
        background: #dc3545 !important;
        color: #fff !important;
    }

    /* Employee name & position */
    .employee-name {
        font-weight: 600;
        color: #212529;
        font-size: 13px;
    }

    .employee-name:hover {
        color: #0d6efd;
    }

    .position-text {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
        word-wrap: break-word;
    }
</style>
<div class="payroll-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center payrollTable w-100">
            <thead>
                <tr>
                    <th style="min-width:200px;" class="text-start">Employee</th>
                    <th class="position-col fw-semibold text-uppercase small">Position</th>
                    <th class="afterThis">Gross Pay</th>

                    <?php
                    $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
                    $income = Modules::run('hr/payroll/getAdditionalIncome', $pc_code);
                    $defaults = Modules::run('hr/payroll/getPayrollDefaults', '0');
                    $pdefaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
                    $amortizedDeduction = Modules::run('hr/payroll/getAmortizedDeduction', $pc_code);

                    if ($income || Modules::run('hr/payroll/getAdditionalIncome', $pc_code - 1)): ?>
                        <th style="min-width:140px">Additional Income</th>
                        <?php
                    endif;

                    foreach ($pdefaults as $d) :
                        if ($d->pi_is_default != 2) :
                        ?>
                            <th style="min-width:120px"><?php echo $d->pi_item_name ?></th>

                        <?php
                        endif;
                    endforeach;

                    foreach ($defaults as $d) :
                        if ($d->pi_is_default != 2) :
                        ?>
                            <th style="min-width:120px"><?php echo $d->pi_item_name ?></th>

                        <?php
                        endif;
                    endforeach;

                    if ($amortizedDeduction): ?>
                        <th style="min-width:140px">Loans</th>
                        <?php endif;

                    foreach ($charges as $deductions) :
                        if ($deductions->pi_is_default != 1 && $deductions->pi_item_cat != 2):
                        ?>
                            <th style="min-width:120px"><?php echo $deductions->pi_item_name ?></th>
                    <?php
                        endif;
                    endforeach;
                    ?>

                    <th>Other Deductions</th>
                    <th>Total Deductions</th>
                    <th>Net Pay</th>
                    <!-- <th style="min-width:120px;">Options</th> -->
                    <th class="action-col">Actions</th>
                </tr>
            </thead>

            <tbody>
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
                $totalGross = 0;
                $totalDeductions = 0;
                $totalNet = 0;
                $grandTotalDeductions = 0;
                $totalAdditionalIncome = 0;

                $lrn = 0;
                $employeeCount = count($getPayrollReport);
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

                    $absent = ($workdays * 8) - $totalHoursRendered - ($leave * 8);

                    if ($absent > 0):
                        $otherDeduction += ($absent * $hourly);
                    else:
                        $absInHrs = 0;
                    endif;

                    $ptrans = Modules::run('hr/payroll/checkTransaction', $employee->user_id, $pc_code);
                ?>

                    <tr id="tr_<?php echo $employee->uid; ?>">
                        <td class="text-start">
                            <a class="employee-name text-decoration-none"
                                href="<?php echo base_url('hr/viewTeacherInfo/' . base64_encode($employee->employee_id)) ?>">
                                <?php echo strtoupper($employee->lastname . ', ' . $employee->firstname) ?>
                            </a>
                            <div class="position-text">
                                ID: <?php echo $employee->employee_id ?>
                            </div>
                        </td>

                        <td class="fw-semibold text-uppercase small position-col">
                            <?php echo $employee->position ?>
                        </td>

                        <td>
                            <span class="amount-pill pill-income"
                                id="<?php echo $employee->user_id ?>_td"
                                tdvalue="<?php echo $basic ?>">
                                ₱ <?php echo number_format($basic, 2, '.', ',') ?>
                            </span>
                        </td>

                        <?php
                        $totalStat = 0;
                        $totalNetPayroll = 0;
                        $items = 1;
                        $item = 1;
                        $deduct = array();
                        $additionalIncome = 0;
                        $addTotal = 0;
                        $addBreakdown = [];

                        if ($income):
                            foreach ($income as $additional):
                                if ($additional->pi_item_type == 1):
                                    $add = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, $pc_code, $employee->user_id);
                                    if (!empty($add->row())) {
                                        $amount = $add->row()->pc_amount;
                                    } else {
                                        $amount = 0; // skip if no income
                                    }

                                    if ($amount > 0) {
                                        $addBreakdown[] = ['name' => $additional->pi_item_name, 'amount' => $amount];
                                        $addTotal += $amount;
                                    }
                                endif;
                            endforeach;
                        endif;
                        ?>

                        <td>
                            <span class="amount-pill pill-income add-toggle"
                                style="cursor:pointer;"
                                data-employee="<?php echo $employee->user_id ?>"
                                data-breakdown='<?php echo json_encode($addBreakdown) ?>'>
                                ₱ <?php echo number_format($addTotal, 2, '.', ',') ?>
                            </span>
                        </td>
                        <?php

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

                                            $amount = ($d->pi_is_default != 0 ? $d->pi_default : $tmpAmount);
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
                                    td_item_id="<?php echo $d->pi_item_id ?>"><span class="amount-pill pill-income">₱ <?php echo number_format($amount, 2) ?></span></td>

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
                                    $amount = ($d->pi_is_default != 0 ? $d->pi_is_default : 0);
                                    Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $d->pi_item_id, $amount, $pc_code);
                                endif;
                            ?>
                                <td id="td_<?php echo $employee->user_id; ?>_<?php echo $d->pi_item_id ?>" class="defaults_<?php echo $employee->user_id; ?> tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                                    td_value="<?php echo $amount ?>"
                                    td_item_id="<?php echo $d->pi_item_id ?>"><span class="amount-pill pill-deduct">₱ <?php echo number_format($amount, 2) ?></span></td>

                        <?php
                            else :
                                $amount = $c->row()->pc_amount;
                            endif;
                            $totalStat += $amount;
                        endforeach;

                        $loanTotal = 0;
                        $loanBreakdown = [];

                        if ($amortizedDeduction):
                            foreach ($amortizedDeduction as $ad):
                                $cad = Modules::run('hr/payroll/getPayrollChargesByItem', $ad->pi_item_id, $pc_code, $employee->user_id);

                                if (!empty($cad->row())) {
                                    $cadAmount = $cad->row()->pc_amount;
                                } else {
                                    $cad = Modules::run('hr/payroll/getPayrollChargesByItem', $ad->pi_item_id, ($pc_code - 1), $employee->user_id);
                                    if (!empty($cad->row())) {
                                        $cadAmount = $cad->row()->pc_amount;
                                    } else {
                                        $amortValue = Modules::run('hr/payroll/getAmortValue', $employee->employee_id, $ad->pi_item_id);
                                        if ($pc_code >= $ad->pa_pp_id) {
                                            $cadAmount = $amortValue->pa_amort_amount;
                                        } else {
                                            $cadAmount = 0;
                                        }
                                    }
                                }

                                if ($cadAmount > 0) {
                                    $loanBreakdown[] = ['name' => $ad->pi_item_name, 'amount' => $cadAmount];
                                    $loanTotal += $cadAmount;
                                }
                            endforeach;
                        endif;
                        ?>

                        <td>
                            <span class="amount-pill pill-deduct loan-toggle"
                                style="cursor:pointer;"
                                data-employee="<?php echo $employee->user_id ?>"
                                data-breakdown='<?php echo json_encode($loanBreakdown) ?>'>
                                ₱ <?php echo number_format($loanTotal, 2, '.', ',') ?>
                            </span>
                        </td>

                        <?php
                        $totalStat += $loanTotal;

                        foreach ($charges as $deductions) :
                            $items++;
                            if ($deductions->pi_is_default != 1 && $deductions->pi_item_cat != 2):
                                $charge = Modules::run('hr/payroll/getPayrollChargesByItem', $deductions->pc_item_id, $pc_code, $employee->user_id);
                                $amount = ((!empty($charge->row())) ? $charge->row()->pc_amount : 0);

                                if ($charge->row()):
                        ?>
                                    <td id="td_<?php echo $employee->user_id; ?>_<?php echo $deductions->pi_item_id ?>" class="tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                                        td_value="<?php echo $amount ?>"><span class="amount-pill pill-deduct">₱ <?php echo number_format($amount, 2, '.', ',') ?></span></td>

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

                        $netPayLessDeduction = ($basic + $addTotal + $additionalIncome) - ($otherDeduction);
                        $totalNet = (($netPayLessDeduction) - ($totalStat));
                        $rowTotalDeductions = $otherDeduction + $totalStat;
                        ?>

                        <td><span class="amount-pill pill-deduct">₱ <?php echo number_format($otherDeduction, 2, '.', ',') ?></span></td>

                        <td>
                            <span class="amount-pill pill-deduct fw-bold">
                                ₱ <?php echo number_format($rowTotalDeductions, 2, '.', ',') ?>
                            </span>
                        </td>

                        <td>
                            <span class="amount-pill pill-net fw-bold <?php echo ($totalNet < 50 ? 'net-danger' : '') ?>">
                                ₱ <?php echo number_format($totalNet, 2, '.', ',') ?>
                            </span>
                        </td>

                        <td class="action-col">
                            <button class="btn btn-sm btn-outline-secondary action-toggle"
                                onclick="toggleActions('<?php echo $employee->user_id ?>')"><i class="fa fa-ellipsis-h"></i>
                                Actions
                            </button>

                            <!-- Floating Action Buttons -->
                            <div class="action-popover" id="actions_<?php echo $employee->user_id ?>">
                                <div class="btn-group action-btns">
                                    <button onclick="getDateFrom('<?php echo $startDate ?>', '<?php echo $endDate ?>', '<?php echo $employee->user_id ?>', '<?php echo base64_encode($employee->employee_id) ?>', '<?php echo $hourly ?>')" class="btn btn-xs btn-primary">Attendance</button>

                                    <button onclick="$('#addCharges').modal('show'),
                                    $('#grossPay').html($('#<?php echo $employee->user_id ?>_td').attr('tdvalue'));
                                    loadPayrollDeduction('<?php echo $startDate ?>', '<?php echo $endDate ?>', '<?php echo $employee->user_id ?>',
                                    '<?php echo $pc_code ?>', '<?php echo $employee->employee_id ?>', '<?php echo $totalNet; ?>'),
                                    $('#pcCode').val('<?php echo $pc_code ?>'), $('#netPay').html('<?php echo round($totalNet, 2); ?>'), $('#pc_profile_id').val('<?= $employee->user_id ?>')"
                                        class="btn btn-xs btn-danger"
                                        <?php echo ($ptrans ? ($ptrans->ptrans_status) ? "disabled" : "" : ""); ?>>
                                        +/-
                                    </button>

                                    <button id="approveBtn_<?php echo $employee->user_id ?>"
                                        style="display:<?php echo ($ptrans == null ? '' : 'none') ?>"
                                        onclick="approvePayroll('<?php echo $employee->user_id ?>', '<?php echo $totalNet ?>', '<?php echo $pc_code ?>', '<?php echo $employee->user_id ?>')"
                                        class="btn btn-xs btn-warning">Approve</button>

                                    <button style="display: <?php echo ($ptrans ? ($ptrans == null ? 'none' : '') : '') ?>"
                                        id="releaseBtn_<?php echo $employee->user_id ?>"
                                        onclick="releasePayroll('<?php echo $employee->user_id ?>', '<?php echo $totalNet ?>', '<?php echo $pc_code ?>', '<?php echo $employee->user_id ?>')"
                                        <?php echo ($ptrans ? ($ptrans->ptrans_status ? 'disabled' : '') : '') ?>
                                        class="btn btn-xs <?php echo ($ptrans ? ($ptrans->ptrans_status ? 'btn-success' : 'btn-danger') : '') ?>">
                                        <?php echo ($ptrans ? ($ptrans->ptrans_status ? 'Released' : 'Release') : '') ?>
                                    </button>

                                    <button class="btn btn-xs btn-danger"
                                        <?php echo ($ptrans ? ($ptrans->ptrans_status) ? "disabled" : "" : ""); ?>
                                        onclick="$('#delWarningMsg').modal('show'),
                                        $('#emID').val('<?php echo base64_encode($employee->employee_id) ?>'),
                                        $('#pcID').val('<?php echo base64_encode($pc_code) ?>'),
                                        $('#uID').val('<?php echo base64_encode($employee->user_id) ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $td = 0;
                    // $totalNetPay += $netPayLessDeduction;
                    $totalNetPay += $totalNet;
                    // include additional income in overall gross total
                    $totalGross += $basic;
                    $additionalIncome += $addTotal;
                    $totalOD += $totalStat;
                    $grandTotalDeductions += $rowTotalDeductions;
                    $totalAdditionalIncome += $additionalIncome;
                    $otherDeduction = 0;
                endforeach;
                $totalTardy = 0;
                $items = 1;

                // $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
                if ($charges):
                    foreach ($charges as $d):
                        if ($d->pi_item_type == 1):
                            $items++;
                    ?>
                            <!-- <td class="total_<?php echo $items ?>"></td> -->

                            <?php
                        endif;
                    endforeach;
                    foreach ($charges as $d):
                        if ($d->pi_item_type != 1):
                            if ($d->pi_is_default == 1):
                                $items++;
                            ?>
                                <!-- <td class="total_<?php echo $items ?>"></td> -->

                            <?php
                            endif;
                        endif;
                    endforeach;
                    foreach ($charges as $d):
                        if ($d->pi_item_type != 1):
                            if ($d->pi_is_default != 1):
                                $items++;
                            ?>
                                <!-- <td class="total_<?php echo $items ?>"></td> -->

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
                            <!-- <td></td> -->

                <?php
                        endif;
                    endforeach;

                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="charges" value="<?php echo $items; ?>" />
<input type="hidden" id="totalNetIncome" value="<?= $totalNetPay ?>" />
<input type="hidden" id="totalGrossPay" value="<?= $totalGross ?>" />
<input type="hidden" id="totalAdditionalIncome" value="<?= $totalAdditionalIncome ?>" />
<input type="hidden" id="totalDeductions" value="<?= $grandTotalDeductions ?>" />
<input type="hidden" id="totalEmployees" value="<?= $employeeCount ?>" />
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

        // Update summary cards in create.php (if present)
        var gross = parseFloat($('#totalGrossPay').val() || 0);
        var addlIncome = parseFloat($('#totalAdditionalIncome').val() || 0);
        var deductions = parseFloat($('#totalDeductions').val() || 0);
        var net = parseFloat($('#totalNetIncome').val() || 0);
        var employees = parseInt($('#totalEmployees').val() || 0, 10);

        if (!isNaN(gross)) {
            $('#summaryGross').text('₱' + numberWithCommas(gross.toFixed(2)));
        }

        if (!isNaN(addlIncome)) {
            $('#summaryAdditionalIncome').text('₱' + numberWithCommas(addlIncome.toFixed(2)));
        }

        if (!isNaN(deductions)) {
            $('#summaryDeduction').text('₱' + numberWithCommas(deductions.toFixed(2)));
        }

        if (!isNaN(net)) {
            $('#summaryNet').text('₱' + numberWithCommas(net.toFixed(2)));
        }

        if (!isNaN(employees) && employees > 0) {
            $('#summaryEmployees').text(employees);
        }
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
        var baseUrl = '<?php echo base_url() ?>';
        var url = baseUrl + 'hr/payroll/updateOverTime/' +
            emp_id + '/' +
            att_id + '/' +
            val + '/' +
            opt + '/' +
            pc_code + '/' +
            user_id + '/' +
            hRate;

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {

                var container = $('#otReq-' + att_id);
                var html = '';

                switch (data.appr) {

                    // REJECTED
                    case 0:
                        html = `
                    <div class="dropdown d-inline-block text-center">
                        <span class="badge bg-danger dropdown-toggle pointer d-block"
                              data-bs-toggle="dropdown">
                            OT Rejected <i class="fa fa-thumbs-down ms-1"></i>
                        </span>
                        <ul class="dropdown-menu shadow text-center p-0"
                            style="min-width:100%;">
                            <li>
                                <span class="badge bg-warning w-100 py-2 pointer"
                                    onclick="updateOT(0,'${emp_id}','${user_id}','${hRate}','${att_id}',0)">
                                    <i class="fa fa-undo me-2"></i> Revert Action
                                </span>
                            </li>
                        </ul>
                    </div>`;
                        break;

                        // APPROVED
                    case 1:
                        html = `
                    <div class="dropdown d-inline-block text-center">
                        <span class="badge bg-success dropdown-toggle pointer d-block"
                              data-bs-toggle="dropdown">
                            OT Approved <i class="fa fa-thumbs-up ms-1"></i>
                        </span>
                        <ul class="dropdown-menu shadow text-center p-0"
                            style="min-width:100%;">
                            <li>
                                <span class="badge bg-warning w-100 py-2 pointer"
                                    onclick="updateOT(0,'${emp_id}','${user_id}','${hRate}','${att_id}',0)">
                                    <i class="fa fa-undo me-2"></i> Revert Action
                                </span>
                            </li>
                        </ul>
                    </div>`;
                        break;

                        // PENDING
                    case 2:
                        html = `
                    <button class="btn btn-sm btn-success"
                        onclick="updateOT(1,'${emp_id}','${user_id}','${hRate}','${att_id}',1)">
                        <i class="fa fa-thumbs-up"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="updateOT(0,'${emp_id}','${user_id}','${hRate}','${att_id}',1)">
                        <i class="fa fa-thumbs-down"></i>
                    </button>`;
                        break;
                }

                container.html(html);
            }
        });
    }

    function toggleActions(uid) {
        // hide other open popovers
        $('.action-popover').not('#actions_' + uid).fadeOut(150);

        // toggle selected
        $('#actions_' + uid).fadeToggle(150);
    }

    // close when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.action-toggle, .action-popover').length) {
            $('.action-popover').fadeOut(150);
        }
    });
    // Re-enable sticky header after modal closes
    $('.modal').on('hidden.bs.modal', function() {
        // trigger reflow
        $('.payrollTable thead th').each(function() {
            this.style.position = 'sticky';
        });
    });
</script>