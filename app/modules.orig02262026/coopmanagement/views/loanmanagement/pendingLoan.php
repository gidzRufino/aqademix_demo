<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Pending Loan Application
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/application') ?>'">Loan Application</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/forDisbursement') ?>'">Loans for Disbursement</button>
          </div>
    </h3>
</div>
<div class="col-lg-12">
    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th style="width:25%; text-align: Left;">Name</th>
            <th style="width:10%; text-align: Left;">Loan Type</th>
            <th class="text-right">Principal Amount</th>
            <th class="text-right">Interest</th>
            <th class="text-center">Date Applied</th>
            <th class="text-center">Status</th>
        </tr>
        
        <?php 
        $i=0;
        //print_r($pendingLoans);
        foreach($pendingLoans as $pl): $i++; ?>
        <tr class="pointer" onclick="document.location='<?php echo base_url('coopmanagement/loans/loanDetails/').base64_encode($pl->ld_account_num).'/'.base64_encode($pl->ld_ref_number) ?>'">
            <th><?php echo $i; ?>.</th>
            <td style="width:25%; text-align: left;"><?php echo strtoupper($pl->lastname.', '.$pl->firstname) ?></td>
            <td style="width:10%; text-align: left;"><?php echo strtoupper($pl->clt_type) ?></td>
            <td style="width:15%;" class="text-right">&#8369; <?php echo number_format($pl->ld_principal_amount,2,'.',',') ?></td>
            <td style="width:15%;" class="text-right">&#8369; <?php echo number_format($pl->ld_interest,2,'.',',') ?></td>
            <td class="text-center"><?php echo date('F d, Y', strtotime($pl->ld_loan_date)) ?></td>
            <td class="text-center "><span class="label label-warning"><?php echo ($pl->ld_status==0?'Pending':($pl->ld_status==1?'Approved':'Pending')) ?></span></td>
        </tr>
        
        <?php endforeach; ?>
    </table>
</div>