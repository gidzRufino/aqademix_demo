<table style="width:100%;" class="table table-bordered table-striped table-hover payrollTable text-center">

    <tr class="head" style="font-weight:bold; border-bottom: 2px solid black;">
        <td style="width:10px;">Avatar</td>
        <td style="width:150px;">Name of Employee</td>
        <td style="width:50px;">Position</td>
        <td class="afterThis">Gross Pay</td>
		<?php
		 $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
                 if($charges):
                    foreach ($charges as $d):
                        if($d->pi_item_type==1):
                            if ($d->pi_is_default != 2):
                                    ?>
                                   <td ><?php echo $d->pi_item_name ?></td>

                                    <?php
                            endif;
                        endif;
                    endforeach;
                    foreach ($charges as $d):
                        if($d->pi_item_type!=1):
                            if ($d->pi_is_default != 2):
                                    $defaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
                                    foreach ($defaults as $de):
                                        if($de->pi_item_id != $d->pc_item_id):
                                         ?>
                                                   <td ><?php echo $de->pi_item_name ?></td>

                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                   <td ><?php echo $d->pi_item_name ?></td>

                                    <?php
                            endif;
                        endif;
                    endforeach;
                     
                 else:    
                    $defaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
                    foreach ($defaults as $d):
                            if ($d->pi_is_default != 2):
                                    ?>
                                   <td ><?php echo $d->pi_item_name ?></td>

                                    <?php
                            endif;
                    endforeach;
                    
                 endif;
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

	 $lrn = 0;
	 foreach ($getPayrollReport as $pr):
            $lrn++;
            $employee = Modules::run('hr/getEmployeeName', $pr->pmh_em_id);
            $getPayrollHours = Modules::run('hr/payroll/getPayrollReport', $pc_code, $pr->pmh_em_id);
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
         ?>
            <tr id="tr_<?php echo $employee->uid; ?>">
                <td style="text-align: center"><img class="img-circle"  style="width:30px;" src="<?php echo base_url().'uploads/'.$employee->avatar  ?>" /></td>
                <td><?php echo strtoupper($employee->lastname.', '.$employee->firstname) ?></td>
                <td><?php echo strtoupper($employee->position) ?></td>
                <td id="<?php echo $employee->uid ?>_td" td_id="td_<?php echo $employee->uid; ?>_<?php echo $d->pi_item_id ?>" tdvalue="<?php echo $salary ?>" class="afterValue"><?php echo number_format($salary, 2, '.', ',') ?></td>
                <?php
                $totalStat = 0;
                $totalNetPayroll = 0;
                $items = 1;
                $item = 1;
                $addedAmount = 0;
                if($charges):
                    $items++;
                    foreach ($charges as $d):
                        $c = Modules::run('hr/payroll/getPayrollChargesByItem', $d->pi_item_id, $pc_code, $employee->uid);
                        if($d->pi_item_type==1):
                            if (!empty($c->row())) :
                                $addedAmount = round($c->row()->pc_amount, 2);
                            endif;
                            ?>
                            <td id="td_<?php echo $employee->uid; ?>_<?php echo $d->pi_item_id ?>" class="defaults_<?php echo $employee->uid; ?> tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                                td_value="<?php echo $addedAmount ?>"
                                td_item_id="<?php echo $d->pi_item_id ?>"
                                                               ><?php echo number_format($addedAmount, 2) ?></td>

                                <?php
                        endif;
                    endforeach;
                    $items = 0;
                endif;
		$defaults = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
		
                $deduct = array();
                if(!$defaults):
                    $defaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
                endif;
                foreach ($defaults as $d) :
                    $items++;
                    
                    $c = Modules::run('hr/payroll/getPayrollChargesByItem', $d->pi_item_id, $pc_code, $employee->uid);
                    if ($d->pi_is_default != 2) :
                        if($d->pi_item_type!=1):
                            if (!empty($c->row())) :
                                $amount = round($c->row()->pc_amount, 2);
                            else :
                                switch ($d->pi_item_id) :
                                    case 1: // SSS
                                        echo $employee->salary;
                                        $equivalent = Modules::run('hr/payroll/getSSSTableEquivalent', $employee->salary);
                                        $amount = $equivalent;
                                        //echo $amount;
                                    break;
                                    case 2: // PhilHealth
                                        $calculatedGross += $salary;
                                        if ($calculatedGross<=10000) :
                                            $amount = ($d != null ? $d->pi_default : 0);
                                        else :
                                            $tmpAmount = $calculatedGross * 0.01375;
                                            $tmpDef = ($d != null ? $d->pi_default : 0)*3;
                                            $amount = $tmpAmount - $tmpDef;
                                        endif;
                                        break;
                                    default:
                                        $amount = ($d != null ? $d->pi_default : 0);
                                        break;
                                endswitch;
                                    Modules::run('hr/payroll/setPayrollCharges', $employee->uid, $d->pi_item_id, $amount, $pc_code);
                            endif;
                                ?>
                            <td id="td_<?php echo $employee->uid; ?>_<?php echo $d->pi_item_id ?>" class="defaults_<?php echo $employee->uid; ?> tdValue_<?php echo $items ?> tdDefaults_<?php echo $d->pi_item_id ?>"
                                td_value="<?php echo $amount ?>"
                                td_item_id="<?php echo $d->pi_item_id ?>"
                                                               ><?php echo number_format($amount, 2) ?></td>

                                <?php
                        endif;        
                    else :
                            $amount = $c->row()->pc_amount;
                    endif;
                        $totalStat += $amount;
                endforeach;
                $netPayLessDeduction = ($salary+$addedAmount) - ($totalStat);
		?>
                        
                    <td><?php echo $totalDeductibleTardy; ?></td>
                    <td><?php echo number_format(($totalStat), 2, '.', ',') ?></td>
                    <td style="<?php echo ($netPayLessDeduction < 50 ? 'background-color:rgb(217, 83, 79); color:white;' : '') ?>;"><?php echo number_format($netPayLessDeduction, 2, '.', ',') ?></td>
                    <td style="width:25%">
                            <?php $ptrans = Modules::run('hr/payroll/checkTransaction', $employee->employee_id, $pc_code); 
                                   //print_r($ptrans);
                            ?>
                        <div class="btn-group">
                            <button id="deduction_<?php echo $employee->uid ?>" onclick="$('#addCharges').modal('show'),
                                             $('#grossPay').html('<?php echo $salary ?>')
                                             loadPayrollDeduction('<?php echo $startDate ?>', '<?php echo $endDate ?>', '<?php echo $employee->uid ?>',
                                                                  '<?php echo $pc_code ?>', '<?php echo $pr->pmh_em_id ?>', '<?php echo $netPayLessDeduction; ?>'),
                                                       $('#pc_code').val('<?php echo $pc_code ?>'), $('#netPay').html('<?php echo round($netPayLessDeduction, 2); ?>')" 
                                   class="btn btn-xs btn-danger " <?php echo ($ptrans->ptrans_status) ? "disabled"  : "";  ?>>
                               Addition / Deduction
                            </button>
                            <button id="approveBtn_<?php echo $employee->uid ?>" 
                                    onclick="approvePayroll('<?php echo $pr->pmh_em_id ?>', '<?php echo $netPayLessDeduction ?>', '<?php echo $pc_code ?>', '<?php echo $employee->uid ?>')" 
                                    class="btn btn-xs <?php echo ($ptrans->ptrans_status) ? "btn-success disabled"  : "btn-warning";  ?>">
                            <?php echo ($ptrans->ptrans_status) ? "Confirmed"  : "Confirm";  ?>
                            </button>

                        </div>
                    </td> 
            </tr>
         <?php
            
            $totalNetPay += $netPayLessDeduction;
            $totalGross += $salary;
            $totalOD += $totalStat;
	 endforeach;  //end of Payroll Report
         $totalTardy = 0;
	?>
	<tr style='border-top-style:double; font-weight: bold;'>
		<td colspan="2">Total</td>
		<td></td>
		<td><?php echo number_format($totalGross, 2, '.', ','); ?></td>
		<?php
		 $charges = Modules::run('hr/payroll/getPayrollCharges', $pc_code);
		 $totalNetPayroll = (($totalGross + $addOnTotal) - ($totalOD));
                 $items = 0;
		 foreach ($defaults as $d):
			 $items++;
			 $amount = ($d != NULL ? $d->pi_default : 0);
			 if ($d->pi_is_default != 2):
				 ?>
		 		<td class="total_<?php echo $items?>" ></td>

				 <?php
				 $totalStats += $amount;
			 endif;
		 endforeach;
		?>
		<td><?php echo number_format($totalTardy, 2, '.', ','); ?></td>
		<td><?php echo number_format($totalOD, 2, '.', ','); ?></td>
		<td><?php echo number_format($totalNetPay, 2, '.', ','); ?></td>
		<td></td>
	</tr>
</table>
<input type="hidden" id="charges" value="<?php echo $items; ?>" />
<input type="hidden" id="totalNetIncome" />
<script type="text/javascript">

	$(document).ready(function () {
		getTotal();
	});

	function loadPayrollDeduction(dateFrom, dateTo, owners_id, pc_code, employee_id, netPay)
	{
		var grossPay = $('#' + owners_id + '_td').attr('tdvalue');
		var url = "<?php echo base_url() ?>hr/payroll/loadPayrollDeduction"; // the script where you handle the form input.
		$.ajax({
			type: "POST",
			url: url,
			data: "owners_id=" + owners_id + "&grossPay=" + grossPay + "&partialNet=" + netPay + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&pc_code=" + pc_code + "&employee_id=" + employee_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
			success: function (data)
			{
				$('#payrollDeductionBody').html(data)
			}
		});

		return false; // avoid to execute the actual submit of the form.
	}

	function getDateFrom(dateFrom, dateTo, owners_id)
	{
		var url = "<?php echo base_url() ?>hr/searchDTRbyDateForPayroll"; // the script where you handle the form input.
		$.ajax({
			type: "POST",
			url: url,
			data: "owners_id=" + owners_id + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
			success: function (data)
			{
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
			$("#userinput").keydown(function (e) {
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
			$("#userinput").focusout(function () {
				$("#" + cid).attr('td_value', val);
				$("#" + cid).html(val);

			});


		}

	}

	function saveDefaultDeduction(user_id, pc_code, em_id)
	{
		$('td.defaults_' + user_id).each(function () {
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
					success: function (response) {

					}

				});
			}
		});
	}
	function releasePayroll(em_id, netPay, pc_code, user_id)
	{
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

			beforeSend: function () {
				//$('#consolidatedPayroll').html('<b class="text-center">Please Wait while Payroll is generating...</b>')
			},
			success: function (data)
			{
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

	function approvePayroll(em_id, netPay, pc_code, user_id)
	{
            var approve = confirm('Do you really want to confirm the payroll of this employee?');
            
            if(approve)
            {
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

			beforeSend: function () {
				//$('#consolidatedPayroll').html('<b class="text-center">Please Wait while Payroll is generating...</b>')
			},
			success: function (data)
			{
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

	function getTotal()
	{
		var charges = $('#charges').val();
		var total = 0;
		for (var i = 1; i <= charges; i++)
		{
			$('.tdValue_' + i).each(function () {
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
</script>

