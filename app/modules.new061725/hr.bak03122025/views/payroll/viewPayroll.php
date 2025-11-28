<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">View Payroll
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="$('#createPay').modal('show')">Set Payroll Period</button>
            <button type="button" class="btn btn-default" onclick="$('#amTransaction').modal('show')">View Payroll</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll/settings') ?>'">Payroll Settings</button>
          </div>
    </h3>
</div>
<div class="col-lg-12">
    <div class="form-group pull-right">
        <select onclick="generatePayroll(this.value)" tabindex="-1" id="payPeriod" name="payPeriod" style="width:300px;">
            <option>Select Payroll Period</option>
           <?php foreach($payrollPeriod as $pp): ?>
                <option id="option_<?php echo $pp->per_id ?>" from="<?php echo $pp->per_from ?>" to="<?php echo $pp->per_to ?>" value="<?php echo $pp->per_id ?>"><?php echo date('F d, Y', strtotime($pp->per_from)).' - '.date('F d, Y', strtotime($pp->per_to)); ?></option>
           <?php endforeach; ?>

       </select>
    </div>
</div>
<div class="col-lg-12">
    <table style="width:100%;" class="table table-bordered table-striped table-hover payrollTable text-center">
    <tr>
        <td class="head text-center" colspan="4"><h6>Employee Details</h6></td>
        <td class="head text-center" colspan="4"><h6>Statutory Benefits</h6></td>
        <td class="head text-center" colspan="2"><h6>Deductions</h6></td>
        <td class="head"><h6>TOTAL</h6></td>
        <td class="head" rowspan="2"><h6>STATUS (e.g. Paid / Unpaid) </h6></td>
        
    </tr>
    <tr style="font-weight:bold; border-bottom: 2px solid black;">
        <td style="width:10px;">Avatar</td>
        <td style="width:150px;">Name of Employee</td>
        <td style="width:50px;">Position</td>
        <td>Basic Pay</td>
        <?php foreach($defaultDeductions as $deductions): 
            
            ?>
            <td ><?php echo $deductions->pi_item_name ?></td>
            
        <?php 
        endforeach; ?>
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
            
            switch ($paymentSchedule->monthly):
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
//            $firstDayName = date('D',  strtotime('first Day of '.date("F", mktime(0, 0, 0, segment_4, 10)).' '.date('Y', strtotime($startDate))));
            $holiday = Modules::run('calendar/holidayExist', date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
            $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
            
            //calculation of the Basic Pay and the benefits
            $workdays = $hrdb->count_workdays($startDate, $endDate);
            $salary = number_format(($pr->salary), 2, '.', ',');
            $expectedHours = $workdays * 8;
            $day = Modules::run('hr/hrdbprocess/getPayrollTimes', $pr->user_id, $startDate, $endDate);
            $d = json_decode($day);
            
            //use this if exact deduction
            //$totalDeductibleTardy = round($pr->salary/$schoolDays/8/60*$undertime, 2);
            
            $totalDeductibleTardy = round($pr->salary/30/8/60*$d->undertime, 2);
            $netpay = ($pr->salary/$over);
            ?>
    <tr onclick="$('#addCharges').modal('show'), $('#em_id').val('<?php echo $pr->employee_id ?>'), $('#item_pc_code').val('<?php echo $pc_code ?>')">
        <td style="text-align: center"><img class="img-circle"  style="width:30px;" src="<?php echo base_url().'uploads/'.$pr->avatar  ?>" /></td>
        <td><?php echo $pr->firstname.' '.$pr->lastname ?></td>
        <td><?php echo $pr->position ?></td>
        <td><?php echo $salary ?></td>
        <?php 
        $totalStat= 0;
        foreach($defaultDeductions as $deductions): 
                $statBen = Modules::run('hr/payroll/getStatBen', $pr->pg_id, $deductions->pi_item_id);
                if($statBen!=NULL):
                    if($statBen->stat_ded_sched>=$startD && $statBen->stat_ded_sched <=$endD):
                        $statAmount = $statBen->stat_amount;
                    else:
                        $statAmount = 0;
                    endif;
                else:
                    $statAmount = 0;
                endif;
                ?>
                <td ><?php echo $statAmount?></td>

            <?php 
            Modules::run('hr/payroll/setPayrollCharges',$pr->employee_id, $deductions->pi_item_id, $statAmount, $pc_code) ;
            $totalStat += $statAmount;
        endforeach; ?>
        <td><?php echo $totalDeductibleTardy; ?></td>
        <td><?php echo $totalDeductibleTardy+$totalStat ?></td>
        <td><?php echo number_format(($netpay-($totalDeductibleTardy+$totalStat)), 2, '.', ',') ?></td>
        <td></td> 
    </tr>
    <?php
        
      unset($totalStat);
      unset($expectedPerHourRate);
      endforeach;  
    ?>
</table>

</div>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#payPeriod').select2();
        $('#fromDate').datepicker({
            orientation: "left"
        });
        $('#toDate').datepicker({
            orientation: "left"
        });
        
    });
    
        
    
</script>


