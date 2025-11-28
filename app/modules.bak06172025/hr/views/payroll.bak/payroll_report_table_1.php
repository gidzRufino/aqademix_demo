<table style="width:100%;" class="table table-bordered table-striped table-hover payrollTable text-center">
    <tr>
        <td class="head text-center" colspan="4"><h6>Employee Details</h6></td>
        <td class="head text-center" colspan="4"><h6>Statutory Benefits</h6></td>
        <td class="head text-center" colspan="2"><h6>Deductions</h6></td>
        <td class="head" colspan="2"><h6>TOTAL</h6></td>
        <td class="head" rowspan="2"><h6>STATUS (e.g. Paid / Unpaid) </h6></td>
        
    </tr>
    <tr style="font-weight:bold; border-bottom: 2px solid black;">
        <td style="width:10px;">Avatar</td>
        <td style="width:150px;">Name of Employee</td>
        <td style="width:50px;">Position</td>
        <td>Basic Pay</td>
        <td>SSS</td>
        <td>PhilHealth</td>
        <td>Pag-Ibig</td>
        <td>W/Tax</td>
        <td style="width:50px;">Tardy / Undertime</td>
        <td>Other Deductions</td>
        <td>Total Deductions</td>
        <td>NetPay</td>
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
    $overAllDeductibleTardy = 0;
    
    
        foreach($getPayrollReport as $pr):
            
            switch ($payType):
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
            
            $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($startDate)), 10)), date('Y', strtotime($startDate)), 'first');
            $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($endDate)), 10)), date('Y', strtotime($startDate)), 'last');
            $firstDayName = date('D',  strtotime('first Day of '.date("F", mktime(0, 0, 0, segment_4, 10)).' '.date('Y', strtotime($startDate))));
            $holiday = Modules::run('calendar/holidayExist', date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
            $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
            
            //calculation of the Basic Pay and the benefits
            $workdays = $hrdb->count_workdays($startDate, $endDate);
            $salary = number_format(($pr->salary), 2, '.', ',');
            
            $expectedHours = $workdays * 8;
            $days = Modules::run('hr/hrdbprocess/getPayrollTimes', $pr->user_id, $startDate, $endDate);
            $days = json_decode($days);
            
            $totalDailySalary = ($pr->salary/30)*$days->present;
            //use this if exact deduction
            //$totalDeductibleTardy = round($pr->salary/$schoolDays/8/60*$undertime, 2);
            
            $totalDeductibleTardy = round($pr->salary/30/8/60*$days->undertime, 2);
            
            $other_deductions = $hrdb->loanDeductionProcess($pr->employee_id);
            $od = json_decode($other_deductions);
            
            $salaryTotal = $salaryTotal + (($pr->salary)/$over);
            $sss = number_format(($pr->SSS)/$over, 2, '.', ',');
            $sssTotal = $sssTotal + $sss;
            $philHealth = number_format(($pr->phil_health)/$over, 2, '.', ',');
            $phTotal = $phTotal + $philHealth;
            $pagibig = number_format(($pr->pag_ibig)/$over, 2, '.', ',');
            $pagibigTotal = $pagibigTotal + $pagibig;
            $tin = number_format(($pr->tin)/$over, 2, '.', ',');
            $tinTotal = $tinTotal + $tin;
            $totalDeductions = (($pr->SSS)/$over)+(($pr->phil_health)/$over)+(($pr->pag_ibig)/$over)+(($pr->tin)/$over)+$totalDeductibleTardy;
            $netpay = ($pr->salary/$over);
      ?>
    <tr>
        <td style="text-align: center"><img class="img-circle"  style="width:30px;" src="<?php echo base_url().'uploads/'.$pr->avatar  ?>" /></td>
        <td><?php echo $pr->firstname.' '.$pr->lastname ?></td>
        <td><?php echo $pr->position ?></td>
        <td><?php echo $salary ?></td>
        <td><?php echo $sss ?></td>
        <td><?php echo $philHealth ?></td>
        <td><?php echo $pagibig ?></td>
        <td><?php echo $tin ?></td>
        <td><?php echo $totalDeductibleTardy; ?></td>
        <td><?php echo number_format($od->creditAmount,2,'.',',') ?></td>
        <td><?php echo number_format($totalDeductions+$od->creditAmount, 2, '.',',') ?></td>
        <td><?php echo number_format(((($totalDailySalary-$totalDeductions)-$od->creditAmount)<0?0:(($totalDailySalary-$totalDeductions)-$od->creditAmount)),2,'.',',') ?></td> 
        <td><?php echo '' ?></td>
    </tr>
    <?php
        
        $total += ($totalDeductions+$od->creditAmount);
        $totalOd += $od->creditAmount;
        $totalNet += ((($totalDailySalary-$totalDeductions)-$od->creditAmount)<0?0:(($totalDailySalary-$totalDeductions)-$od->creditAmount));
        $overAllDeductibleTardy += $totalDeductibleTardy;
      unset($netTotal);
      unset($expectedPerHourRate);
      endforeach;  
    ?>
    <tr style='border-top-style:double; font-weight: bold;'>
        <td colspan="3">Total</td>
        <td><?php echo number_format($salaryTotal, 2, '.',','); ?></td>
        <td><?php echo number_format($sssTotal, 2,'.',','); ?></td>
        <td><?php echo number_format($phTotal,2,'.',','); ?></td>
        <td><?php echo number_format($pagibigTotal,2,'.',','); ?></td>
        <td><?php echo number_format($tinTotal,2,'.',','); ?></td>
        <td><?php echo number_format($overAllDeductibleTardy,2,'.',','); ?></td>
        <td><?php echo number_format($totalOd,2,'.',','); ?></td>
        <td><?php echo number_format($total,2,'.',','); ?></td>
        <td><?php echo number_format($totalNet,2,'.',','); ?></td>
    </tr>
</table>



