<?php
$totalAmort = ($loanDetails->ld_terms * 4) * $loanDetails->ld_weekly_amortization;

$cbu = ($loanDetails->ld_loan_type == 1 ? 50 + $loanDetails->ld_clpp : 0);
//print_r($loanDetails)
?>
<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Loan Details
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('coopmanagement/loans/application') ?>'">Loan Application</button>
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('coopmanagement/loans/pending') ?>'">Pending Loan Approval</button>
        </div>
    </h3>
</div>
<div class="col-lg-12">
    <?php if ($id != NULL): ?>
        <div class='col-lg-12'  id="AccountBody">
            <?php
            $data['basicInfo'] = Modules::run('coopmanagement/getAccountInfoByAccountNumber', $id);
            $this->load->view('../basicAccountInfo', $data);
            ?>
        </div>

        <div class="col-lg-12">
            <?php if ($loanDetails->ld_status == 0): ?>
                <div class="col-lg-12">
                    <button onclick="deleteLoanApplication('<?php echo $loanDetails->ld_ref_number; ?>')" title="Delete Loan Application" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash fa-2x"></i></button>
                </div>
            <?php endif; ?>
            <div class="well col-lg-4" id="loanDetails"  style='height:300px;' >
                <h3 class="text-center no-margin"><?php echo $loanDetails->clt_type ?> Details</h3>
                <hr class="col-lg-12 no-margin" />
                <div class="form-group form-horizontal col-lg-6">
                    <label class="control-label" for="Height">Principal Amount</label>
                    <input  style="font-weight: bold; font-size:22px; color: red;" class="form-control" value="&#8369; <?php echo number_format($loanDetails->ld_principal_amount, 2, '.', ',') ?>"  name="loanAmount" type="text" id="loanAmount" placeholder="Loan Amount" disabled>
                </div>
                <div class="form-group form-horizontal col-lg-6">
                    <label class="control-label" for="Height">Interest</label>
                    <input  style="font-weight: bold; font-size:22px; color: red;" class="form-control" name="idisplay" value="&#8369; <?php echo number_format($loanDetails->ld_interest, 2, '.', ',') ?>" type="text" placeholder="" disabled>
                    <input  class="form-control" name="interest" value="<?php echo '' ?>" type="hidden" id="interest" placeholder="" disabled>
                </div>
                <hr class="col-lg-12 no-padding no-margin" />
                <div class="form-group form-horizontal col-lg-6">
                    <label class="control-label" for="Height">Loan Terms</label>
                    <input  style="font-weight: bold; font-size:22px; color: red;" class="form-control" name="loanTerm" type="text" id="loanTerm" value="<?php echo $loanDetails->ld_terms ?> month(s)" placeholder="No of Months" disabled>
                </div>
                <div class="form-group form-horizontal col-lg-6">
                    <label class="control-label" for="Height">Total Loan Amortization</label>
                    <input style="font-weight: bold; font-size:22px; color: red;" value="&#8369; <?php echo number_format($totalAmort, 2, '.', ',') ?>"  class="form-control" name="loanAmortization" type="text" id="loanAmortization" disabled>
                </div>
                <div class="form-group form-horizontal col-lg-6">
                    <label class="control-label" for="Height">Net Proceed</label>
                    <input style="font-weight: bold; font-size:22px; color: red;" value="&#8369; <?php echo number_format(($loanDetails->ld_principal_amount - ($loanDetails->ld_principal_amount*$loanDetails->ld_service_fee + $cbu)), 2, '.', ',') ?>"  class="form-control" name="loanAmortization" type="text" id="loanAmortization" disabled>
                </div>
                <hr class="col-lg-12 no-padding no-margin" />
                <div class="form-group form-horizontal col-lg-12">
                </div>
            </div>
            <div class="well col-lg-8" id="loanAmortization" style='height:300px; overflow-y: scroll'>
                <h3 class="no-margin text-center">Amortization Schedule</h3>
                <table id="amortTable" class="table table-striped" style="background: white;">
                    <tr>
                        <td>#</td>
                        <td class="text-center">Date</td>
                        <td class="text-right">Principal</td>
                        <td class="text-right">Interest</td>
                        <td class="text-right">Amortization</td>
                        <td class="text-right">Payment</td>
                        <td class="text-right">Balance</td>
                        <td class="text-right">Status</td>
                    </tr>
                    <?php
                    $i = 1;
                    $amortization = 0;
                    foreach ($amortTable as $amort):
                        $principalPerWeek = $loanDetails->ld_principal_amount / ($loanDetails->ld_terms * 4);
                        $interestPerWeek = ($loanDetails->ld_principal_amount * $loanDetails->clt_interest) * ($loanDetails->ld_terms) / ($loanDetails->ld_terms * 4);
                        $weeklyAmortization = $principalPerWeek + $interestPerWeek;
                        //$amortization = $balance_due - $weeklyAmortization;
                        $payment = Modules::run('coopmanagement/loans/getLoanAmortStatus', $amort->lad_id);
                        ?>
                        <tr id="tr_<?php echo $amort->lad_id ?>" class="<?php echo $payment->lad_status ? 'success' : '' ?>">
                            <td><?php echo $i++; ?></td>
                            <td class="text-center"><?php echo date('F d, Y', strtotime($amort->lad_date)) ?></td>
                            <td class="text-right">&#8369; <?php echo number_format($principalPerWeek, 2, '.', ',') ?></td>
                            <td class="text-right">&#8369; <?php echo number_format($interestPerWeek, 2, '.', ',') ?></td>
                            <td class="text-right">&#8369; <?php echo number_format($weeklyAmortization, 2, '.', ',') ?></td>
                            <td class="text-right">&#8369; <?php echo number_format(($payment->lad_status ? $weeklyAmortization : 0), 2, '.', ',') ?></td>
                            <td class="text-right">&#8369; <?php echo number_format($amort->lad_balance, 2, '.', ',') ?></td>
                            <td id="<?php echo $amort->lad_id ?>_status" 
                                ondblclick="$('#addPaymentOveride').modal('show'),
                                                $('#lad_id').val('<?php echo $amort->lad_id ?>'),
                                                $('#profile_id').val($('#account_number').attr('profile_id')),
                                                $('#accountNumber').val($('#account_number').attr('detail')),
                                                $('#loanReferenceNumber').val('<?php echo $loanDetails->ld_ref_number ?>')
                                " 
                                class="pointer text-right"><?php echo $payment->lad_status ? 'Paid' : 'Unpaid' ?></td>
                        </tr>

                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<hr class="col-lg-12 no-margin" /><br />
<div class="col-lg-12">

</div>
<hr class="col-lg-12 no-margin" /><br />
<h3 class="text-center">Approved By :</h3>
<?php
$reviewPerson = Modules::run('coopmanagement/personToReview');
$r = 1;
foreach ($reviewPerson as $rp):
    if (base64_decode($this->session->user_id) == $rp->cad_profile_id):
        ?>
        <div class="col-lg-4">
            <img id="signID" class="img-square img-responsive <?php echo ($loanDetails->ld_status != 0 ? '' : 'hide') ?>" style="width:100%; height: 200px; position: absolute; z-index: 1; top:-50px" src="<?php
            if ($rp->cad_profile_id != ""):echo base_url() . 'uploads/sign/' . $rp->cad_profile_id . '.png';
            else:echo base_url() . 'uploads/noImage.png';
            endif;
            ?>" />
            <br /><br /><br />
            <hr style="border-color: black; padding-top: 10px;" class="col-lg-12 no-margin" />
            <h4 class="clearfix">
                <?php echo strtoupper($rp->firstname . ' ' . $rp->lastname); ?>
                <?php
                if ($loanDetails->ld_status == 1):
                    ?>
                    <button class="btn btn-danger btn-xs pull-right" onclick="disApproveLoan('<?php echo $rp->cad_profile_id ?>', '<?php echo $loanDetails->ld_ref_number ?>')" ><i class="fa fa-thumbs-down"></i></button>
                <?php elseif ($loanDetails->ld_status == 0): ?>    
                    <button style="margin-right:5px;" class="btn btn-success btn-xs pull-right" onclick="approveLoan('<?php echo $rp->cad_profile_id ?>', '<?php echo $loanDetails->ld_ref_number ?>', '<?php echo $loanDetails->ld_loan_type ?>', '<?php echo $loanDetails->ld_account_num ?>', '<?php echo $data['basicInfo']->cad_profile_id ?>')"><i class="fa fa-thumbs-up"></i></button>
                    <?php
                endif;
                ?>
            </h4>
            <h4><small><?php echo strtoupper($rp->position); ?></small></h4>
        </div>

        <script type="text/javascript">
            function approveLoan(user_id, refNumber, loanType, accountNumber, cad_id)
            {
                var url = '<?php echo base_url() . 'coopmanagement/loans/approvedLoan' ?>';
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: url,
                    data: {
                        user_id: user_id,
                        ref_number: refNumber,
                        loanType: loanType,
                        accountNumber: accountNumber,
                        cad_id: cad_id,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data)
                    {
                        if (data.status)
                        {
                            $('#signID').removeClass('hide');
                        }
                        alert(data.msg);
                        location.reload();
                    }
                });

                return false;
            }
            function disApproveLoan(id, refNumber)
            {
                var url = '<?php echo base_url() . 'coopmanagement/loans/disApprovedLoan' ?>';
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: url,
                    data: {
                        user_id: id,
                        ref_number: refNumber,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data)
                    {
                        if (data.status)
                        {
                            $('#signID').removeClass('hide');
                        }
                        alert(data.msg);
                        location.reload();
                    }
                });

                return false;
            }
        </script> 
        <?php
    else:
        ?>

        <div class="col-lg-4">
            <img id="signID" class="img-square img-responsive <?php echo ($loanDetails->ld_status != 0 ? '' : 'hide') ?>" style="width:100%; height: 200px; position: absolute; z-index: 1; top:-50px" src="<?php
         if ($rp->cad_profile_id != ""):echo base_url() . 'uploads/sign/' . $rp->cad_profile_id . '.png';
         else:echo base_url() . 'uploads/noImage.png';
         endif;
         ?>" />
            <br /><br /><br />
            <hr style="border-color: black; padding-top: 10px;" class="col-lg-12 no-margin" />
            <h4 class="clearfix">
        <?php echo strtoupper($rp->firstname . ' ' . $rp->lastname); ?>
            </h4>
            <h4><small><?php echo strtoupper($rp->position); ?></small></h4>
        </div>

    <?php
    endif;
endforeach;
?>

<div id="addPaymentOveride" class="modal fade" style="width:30%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h6 class="panel-header no-margin col-lg-6">Payment Overide</h6>
            <button class="btn btn-danger btn-xs panel-header pull-right no-margin" data-dismiss="modal"><i class="fa fa-close"></i></button>
        </div>
        <div class="panel-body">
            <div class="input-group col-lg-12">
                <input id="amount" class="form-control" type="text" placeholder="Enter Amount Paid" />

                <input type="hidden" id="lad_id" />
                <input type="hidden" id="profile_id" />
                <input type="hidden" id="accountNumber" />
                <input type="hidden" id="loanReferenceNumber" />
                <input type="hidden" value="<?php echo date('Y-m-d') ?>" id="transDate" />
                <input type="hidden" id="lrnv" value="<?php echo Modules::run('coopmanagement/loadReferenceNumber') ?>" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button class="pull-right btn btn-success" onclick="loanPayment()">Add</button>
        </div>

    </div>
</div>

<script type="text/javascript">
    function overidePayment(id)
    {

        var url = '<?php echo base_url() . 'coopmanagement/loans/overidePayment' ?>';
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: url,
            data: {
                lad_id: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (data)
            {
                alert(data)
                $('#' + id + '_status').html('Paid');
                $('#tr_' + id).addClass('success');
                location.reload();

            }
        });

        return false;
    }

    function deleteLoanApplication(ref_number)
    {
        var deleteApplication = confirm('Are you sure you want to delete this application? Please note that you cannot undo the process');
        if (deleteApplication == true)
        {
            var url = '<?php echo base_url() . 'coopmanagement/loans/deleteLoanApplication' ?>';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    ref_number: ref_number,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    alert(data);
                    document.location = '<?php echo base_url('coopmanagement/loans'); ?>';
                }
            });

            return false;
        }

    }

    function loanPayment()
    {
        var lad_id = $('#lad_id').val();
        var amount = $('#amount').val();
        var detail = '3_' + amount + '_LP-' + $('#lrnv').val();
        var details = [];
        details.push(detail);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'coopmanagement/saveTransaction' ?>',
            //dataType: 'json',
            data: {
                items: JSON.stringify(details),
                profile_id: $('#profile_id').val(),
                accountNumber: $('#accountNumber').val(),
                or_num: '',
                loanReferenceNumber: $('#loanReferenceNumber').val(),
                transDate: $('#transDate').val(),
                payType: 0,
                cheque: '',
                bank: 0,
                t_remarks: '',
                is_overide: 1,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                overidePayment(lad_id);
            }

        });
    }
</script> 


