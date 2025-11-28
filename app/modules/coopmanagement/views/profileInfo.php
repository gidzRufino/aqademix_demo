<div class='col-lg-12'>
    <?php
            $data['basicInfo'] = Modules::run('coopmanagement/getAccountInfoByAccountNumber', $id);
            $data['lrn'] = NULL;
            $this->load->view('basicAccountInfo', $data);
       ?>
</div>
<div class="col-lg-12" id="loanAccountDetails">
    <?php 
        $loanList = Modules::run('coopmanagement/loans/getLoanReleased', $id);
        
        //print_r($loanList)
    ?>
    <table class="table table-striped">
        <tr>
            <th colspan="8" class="info">LIST OF LOANS APPLIED</th>
        </tr>
        <tr>
            <th>#</th>
            <th style="width:20%; text-align: Left;">Loan Reference Number</th>
            <th style="width:10%; text-align: Left;">Loan Type</th>
            <th class="text-right">Principal Amount</th>
            <th class="text-right">Weekly Amortization</th>
            <th class="text-right">Outstanding Balance</th>
            <th class="text-center">Date Applied</th>
        </tr>
        <?php 
        $i=1;
        foreach($loanList as $ll): 
            $balance = Modules::run('coopmanagement/loans/getPersonalLoanBalance',$id, $ll->ld_ref_number);
        
            if($balance>0):
            ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td title="View Details" class="pointer" onclick="document.location='<?php echo base_url('coopmanagement/loans/loanDetails/'. base64_encode($id).'/'. base64_encode($ll->ld_ref_number)) ?>'"><?php echo $ll->ld_ref_number ; ?></td>
            <td title="View Details" class="pointer" onclick="document.location='<?php echo base_url('coopmanagement/loans/loanDetails/'. base64_encode($id).'/'. base64_encode($ll->ld_ref_number)) ?>'"><?php echo $ll->clt_type ; ?></td>
            <td class="text-right">&#8369; <?php echo number_format($ll->ld_principal_amount,2,'.',',') ?></td>
            <td class="text-right">&#8369; <?php echo number_format($ll->ld_weekly_amortization,2,'.',',') ?></td>
            <td class="text-right">&#8369; <?php echo number_format($balance,2,'.',',') ?></td>
            <td class="text-center"><?php echo date('F d, Y', strtotime($ll->ld_loan_date)) ?></td>
        </tr>
        <?php 
            endif;
        endforeach; ?>
        
    </table>
</div>