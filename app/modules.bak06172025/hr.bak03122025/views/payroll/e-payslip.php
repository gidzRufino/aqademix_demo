<div class="col-lg-4"></div>
<div class="col-lg-4">
    <h4 class="text-center">Pay Slip for the Period of <br /> <?php echo date('F d', strtotime($dateFrom)).' - '.date('d, Y', strtotime($dateTo)) ?></h4>
    <table class="table table-striped">
        <tr>
            <th colspan="2" class="text-center">
                <h5>Basic Pay : <span id="basicPay"></span></h5>
            </th>
        </tr>
        <?php 
            $employee = Modules::run('hr/getEmployeeName', $employee_id);
            $getPayrollHours = Modules::run('hr/payroll/getPayrollReport', $pc_code, $employee_id);
            $totalHoursRendered = 0; 
            foreach($getPayrollHours as $ph):
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
            
            $workdays = Modules::run('hr/getNumberOfDaysWork',$startDate, $endDate);
            $expectedHours = $workdays * 8;
            
            if($totalHoursRendered >= $expectedHours):
                $salary = $employee->salary/$over;
            else:
                $hourly = round(($employee->salary/22)/8,0,PHP_ROUND_HALF_UP);
                $salary = $hourly*$totalHoursRendered;
            endif;
            
            $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code, $owners_id);
            $addedAmount = 0;
            $stats = 0;
            $otherDeductions = 0;
            if($charges): // Additional Income
                foreach ($charges as $d):
                    if($d->pi_item_type==1):
                            ?>
                        <tr>
                            <td style="padding-left: 20px;"><?php echo ucwords(strtoupper($d->pi_item_name)) ?></td>
                            <td class="text-right"><?php echo number_format($d->pc_amount,2,'.',',') ?></td>
                        </tr>

                            <?php
                    $addedAmount += $d->pc_amount;
                    endif;
                endforeach;
            ?>
                <tr>
                    <th>Total Gross:</th>
                    <th class="text-right"><?php echo number_format(($salary+$addedAmount),2,'.',',') ?></th>
                </tr>       
                <tr>
                    <th colspan="2">Deductions:</th>
                </tr>       
            <?php            
                foreach ($charges as $d):
                    if($d->pi_is_default == 1):
                            ?>
                        <tr>
                            <td style="padding-left: 20px;"><?php echo ucwords(strtoupper($d->pi_item_name)) ?></td>
                            <td class="text-right"><?php echo number_format($d->pc_amount,2,'.',',') ?></td>
                        </tr>

                            <?php
                    $stats += $d->pc_amount;
                    endif;
                endforeach;
            ?>               
                <tr>
                    <th colspan="2">Other Deductions:</th>
                </tr>       
            <?php    
                foreach ($charges as $d):
                    if($d->pi_item_cat == 2):
                            ?>
                        <tr>
                            <td style="padding-left: 20px;"><?php echo ucwords(strtoupper($d->pi_item_name)) ?></td>
                            <td class="text-right"><?php echo number_format($d->pc_amount,2,'.',',') ?></td>
                        </tr>

                            <?php
                    $otherDeductions += $d->pc_amount;
                    endif;
                endforeach;   
            endif;      
            ?>
                        
                               
                <tr>
                    <th>Total Deductions:</th>
                    <th class="text-right"><?php echo number_format(($stats+$otherDeductions),2,'.',',') ?></th>
                </tr>       
                <tr>
                    <th >Net Pay:</th>
                    <th class="text-right"><?php echo number_format(($salary+$addedAmount)-($stats+$otherDeductions),2,'.',',') ?></th>
                </tr>   
        
        
    </table>
</div>
<div class="col-lg-4"></div>