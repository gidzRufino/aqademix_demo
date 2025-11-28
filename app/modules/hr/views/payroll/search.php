<?php
    $grossPayment = 0;
    foreach ($employees as $emp):
        
            $daysDetails = Modules::run('hr/payroll/getManHours', $emp->employee_id, $pp_id, 1);
            $grossPayment += $daysDetails->pmh_amount;
        ?>  
        <tr id="<?php echo $emp->employee_id ?>">
            <td class="text-left"><?php echo strtoupper($emp->lastname.', '.$emp->firstname); ?></td>
            <td class="text-center" id="<?php echo $emp->employee_id.'_1' ?>" formula="basic*hours" ondblclick="doEdit(this.id,'<?php echo $emp->employee_id ?>','<?php echo 1 ?>','<?php echo $emp->salary ?>')"><?php echo $daysDetails->pmh_num_hours ?></td>
            <td salaryAmount="<?php echo $daysDetails->pmh_amount ?>" id="<?php echo $emp->employee_id.'_1' ?>_amount" class="salary text-center"><?php echo number_format($daysDetails->pmh_amount,2,'.',',') ?></td>
            <?php 
            foreach ($manHoursCat as $pmc):
                $manHours = Modules::run('hr/payroll/getManHourTypeByCat', $pmc->pmc_id);
                foreach ($manHours as $pmt):
                    $hourDetails = Modules::run('hr/payroll/getManHours', $emp->employee_id, $pp_id, $pmt->pmt_id);
                    $grossPayment += $hourDetails->pmh_amount;
                    ?>
                        <td id="<?php echo $emp->employee_id.'_'.$pmt->pmt_id ?>" formula="<?php echo $pmt->pmt_calc_formula ?>" ondblclick="doEdit(this.id,'<?php echo $emp->employee_id ?>','<?php echo $pmt->pmt_id ?>','<?php echo $emp->salary ?>')"  class="<?php echo $pmc->class ?> text-center"><?php echo $hourDetails->pmh_num_hours ?></td>
                        <td salaryAmount="<?php echo $hourDetails->pmh_amount ?>"id="<?php echo $emp->employee_id.'_'.$pmt->pmt_id ?>_amount" class="salary <?php echo $pmc->class ?> text-center"><?php echo number_format($hourDetails->pmh_amount,2,'.',',') ?></td>
                    <?php
                endforeach;    
            endforeach;
            ?>
                        <td grossPayment="<?php echo $grossPayment; ?>" id="<?php echo $emp->employee_id ?>_grossPayment" style="vertical-align: middle; width:10%; text-align: center;"><?php echo number_format($grossPayment,2,'.',',') ?></td> 
        </tr>
        <?php
        $grossPayment = 0;
    endforeach;