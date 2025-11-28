<table id="prTableDetails" style="width:100%;" class="table table-bordered table-striped table-hover payrollTable text-center">
    <tr>
        <td class="head text-center" colspan="4"><h6>Employee Details</h6></td>
        <td class="head text-center" colspan="4"><h6>Statutory Benefits</h6></td>
        <td class="head text-center" colspan="2"><h6>Deductions</h6></td>
        <td class="head" colspan="2"><h6>TOTAL</h6></td>
        <td class="head" colspan="2"><h6>ACTION</h6></td>
        <td class="head" rowspan="2"><h6>STATUS (e.g. Paid / Unpaid) </h6></td>
        
    </tr>
    <tr style="font-weight:bold; border-bottom: 2px solid black;">
        <td style="width:10px;">Avatar</td>
        <td style="width:150px;">Name of Employees</td>
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
        <td><button onclick="approvedAll()" class="btn btn-xs btn-info ">Approve All</button></td>
        <td><button onclick="releasedAll()"class="btn btn-xs btn-info releasedBtn disabled">Release All</button></td>
    </tr>
    <?php
    $salaryTotal = 0;
    $sssTotal = 0;
    $phTotal = 0;
    $pagibigTotal = 0;
    $tinTotal = 0;
    $contTotal = 0;
    $netTotal = 0;
    
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
            
            //calculation of the Basic Pay and the benefits
            $workdays = $hrdb->count_workdays($startDate, $endDate);
            
            $other_deductions = $hrdb->loanDeductionProcess($pr->employee_id);
            $od = json_decode($other_deductions);
            
            
            $salary = number_format(($pr->salary)/$over, 2, '.', ',');
            $salaryTotal = $salaryTotal + (($pr->salary)/$over);
            $sss = number_format(($pr->SSS)/$over, 2, '.', ',');
            $sssTotal = $sssTotal + $sss;
            $philHealth = number_format(($pr->phil_health)/$over, 2, '.', ',');
            $phTotal = $phTotal + $philHealth;
            $pagibig = number_format(($pr->pag_ibig)/$over, 2, '.', ',');
            $pagibigTotal = $pagibigTotal + $pagibig;
            $tin = number_format(($pr->tin)/$over, 2, '.', ',');
            $tinTotal = $tinTotal + $tin;
            $totalDeductions = (($pr->SSS)/$over)+(($pr->phil_health)/$over)+(($pr->pag_ibig)/$over)+(($pr->tin)/$over);
            $netpay = ($pr->salary/$over);
            $pr_trans = Modules::run('hr/getPayrollTrans', $pr->employee_id, $startDate, $endDate );
            if($pr_trans->p_approved):
                $approved = 'btn-success';
                $lbl_approved = 'Approved';
                $btn_released = '';
            else:
                $approved = 'btn-danger';
                $lbl_approved = 'Approve';
                $btn_released = 'disabled';
            endif;
      ?>
    <tr class="hasData">
        <td style="text-align: center"><img class="img-circle"  style="width:30px;" src="<?php echo base_url().'uploads/'.$pr->avatar  ?>" /></td>
        <td class="em_id hide"><?php echo $pr->employee_id ?></td>
        <td class="sg_id hide"><?php echo $pr->salary_grade ?></td>
        <td class="od_id hide"><?php echo $od->od_id ?></td>
        <td><?php echo $pr->firstname.' '.$pr->lastname ?></td>
        <td><?php echo $pr->position ?></td>
        <td class="salary" value="<?php echo (($pr->salary)/$over) ?>"><?php echo $salary ?></td>
        <td><?php echo $sss ?></td>
        <td><?php echo $philHealth ?></td>
        <td><?php echo $pagibig ?></td>
        <td><?php echo $tin ?></td>
        <td><?php echo $workdays ?></td>
        <td class="od_amount" value="<?php echo $od->creditAmount ?>"><?php echo number_format($od->creditAmount,2,'.',',') ?></td>
        <td><?php echo number_format($totalDeductions+$od->creditAmount, 2, '.',',') ?></td>
        <td><?php echo number_format((($netpay-$totalDeductions)-$od->creditAmount),2,'.',',') ?></td> 
        <td><button id="<?php echo $pr->employee_id ?>_apBtn" onclick="approvedPR('<?php echo $pr->employee_id ?>')" class="btn btn-xs <?php echo $approved ?> approved"><?php echo $lbl_approved ?></button></td>
        <td><button id="<?php echo $pr->employee_id ?>_relBtn" class="btn btn-xs btn-danger released <?php echo $btn_released ?>">Release</button></td>
        <td><?php echo '' ?></td>
    </tr>
    <?php
        
        
        $total += ($totalDeductions+$od->creditAmount);
        $totalOd += $od->creditAmount;
        $totalNet += ($netpay-$totalDeductions)-$od->creditAmount;
      unset($netTotal);
      endforeach;  
    ?>
    <tr style='border-top-style:double; font-weight: bold;'>
        <td colspan="3">Total</td>
        <td><?php echo number_format($salaryTotal, 2, '.',','); ?></td>
        <td><?php echo number_format($sssTotal, 2,'.',','); ?></td>
        <td><?php echo number_format($phTotal,2,'.',','); ?></td>
        <td><?php echo number_format($pagibigTotal,2,'.',','); ?></td>
        <td><?php echo number_format($tinTotal,2,'.',','); ?></td>
        <td><?php echo ''; ?></td>
        <td><?php echo number_format($totalOd,2,'.',','); ?></td>
        <td><?php echo number_format($total,2,'.',','); ?></td>
        <td><?php echo number_format($totalNet,2,'.',','); ?></td>
    </tr>
</table>



