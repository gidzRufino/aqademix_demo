<table class="table table-bordered">
    <tr>
        <th></th>
        <th>Employee ID</th>
        <th>Employee</th>
        <th>Loan Type</th>
        <th>Principal Amount</th>
        <th>Total Amount</th>
        <th>Terms</th>
        <th>No. of Terms</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php 
        //print_r($loanList);
    foreach ($loanList as $ll): 
        $interestPerMonth = $ll->interest/12;
        switch ($ll->od_item_id):
            case 1:
                break;
            case 2:
                $interest = round(($interestPerMonth*$ll->no_terms)/100,2);
                $finalAmount = $ll->od_principal_amount+($ll->od_principal_amount*$interest);
                $credit_amount = $finalAmount;
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                $credit_amount = $ll->od_principal_amount;
                break;
        endswitch;
        ?>
    
    <tr class="text-center">
        <td style="width:20px;"><img class="img-circle"  style="width:30px;" src="<?php echo base_url().'uploads/'.$ll->avatar  ?>" /></td>
        <td style="width:25px;"><?php echo $ll->employee_id  ?></td>
        <td><?php echo strtoupper($ll->lastname.', '.$ll->firstname);  ?></td>
        <td><?php echo $ll->odi_items;  ?></td>
        <td><?php echo number_format($ll->od_principal_amount,2,'.',',');  ?></td>
        <td><?php echo number_format($credit_amount,2,'.',',');  ?></td>
        <td><?php echo $ll->odp_terms; ?></td>
        <td style="width:15px;"><?php echo $ll->no_terms; ?></td>
        <td style="width:15px;"><?php if($ll->approved): echo 'Approved'; else: echo 'Pending'; endif; ?></td>
        <td><a onclick="getSingleLoanApproval('<?php echo $ll->employee_id  ?>', <?php echo $ll->od_id  ?>, 0, '<?php echo number_format($ll->od_principal_amount,2,'.',',');  ?>', <?php echo $credit_amount  ?>)" data-toggle="modal" data-target="#loan_modal" href="#">View Details</a></td>
    </tr>
    <?php endforeach; ?>
</table>