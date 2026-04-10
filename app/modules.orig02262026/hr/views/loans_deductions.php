<?php
if ($this->session->is_superAdmin || $this->session->position == "Payroll Clerk" || $this->session->position == 'Accounting - Admin'):
?>
    <div class="alert alert-info col-lg-12">
        Hi Please select an option.
        <div class="col-lg-6 pull-right">
            <button data-toggle="modal" data-target="#loan_modal" class="no-margin btn btn-info pull-right btn-xs">ADD in Deduction</button>
            <select style="margin-right:5px;" id="deduction_type" class="pull-right">
                <option>Select Deduction Type here</option>
                <?php foreach ($deductions as $od): ?>
                    <option value="<?php echo $od->pi_item_id ?>">
                        <?php echo $od->pi_item_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php
endif;
if ($myLoans):
?>
    <table class="table table-bordered">
        <tr>
            <th class="text-center">Loan Type</th>
            <th class="text-center">Principal Amount</th>
            <th class="text-center">Amortization</th>
            <th class="text-center">Remaining Amount</th>
            <th class="text-center">Status</th>
        </tr>
        <?php
        //print_r($loanList);
        foreach ($myLoans as $ll):
            $myPayments = Modules::run('hr/payroll/getPaymentByAmortID', $ll->pa_id);
        ?>
            <tr class="text-center">
                <td><?php echo $ll->pi_item_name;  ?></td>
                <td><?php echo number_format(($ll->pa_total_amount), 2, '.', ',');  ?></td>
                <td><?php echo number_format(($ll->pa_amort_amount), 2, '.', ',');  ?></td>
                <td><?php echo number_format(($ll->pa_total_amount - $myPayments->totalAmount), 2, '.', ',');  ?></td>
                <td><?php if ($ll->pa_status): echo 'Paid';
                    else: echo 'On Going Payment';
                    endif; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
else:
?>
    <div style="margin:0 auto; width:50%;">
        <div class="alert alert-warning">
            <h5 class="text-center"><i class="fa fa-info-circle fa-fw"></i> Currently, there are no other deductions.</h5>
        </div>
    </div>

<?php

endif;

?>

<div id="loan_modal" style="width:25%; margin: 0 auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <span id="dtype_name"></span>
        </div>
        <div class="panel-body">
            <div class="form-group col-lg-12">
                <label class="control-label" for="inputAddress">Total Amount:</label>
                <input style="margin-bottom:0;" class="form-control" name="" type="text" id="loan_amount" placeholder="Amount" required>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="inputAddress">Payment Terms applying for:</label>
                <select style="width:230px;" id="odp_terms">
                    <option>Select here</option>
                    <?php foreach ($paymentTerms as $pt): ?>
                        <option id="<?php echo $pt->odp_id ?>_odp" value="<?php echo $pt->odp_id ?>">
                            <?php echo $pt->odp_terms ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-lg-12">
                <label class="control-label" for="inputAddress">Number of Payments:</label>
                <input style="margin-bottom:0;" onkeyup="calculatePaymentPerTerm(this.value)" class="form-control" name="no_of_payments" type="text" id="no_of_payments" placeholder="No of Payments" required>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="inputAddress">Date Applied:</label>
                <input style="margin-bottom:0;" class="form-control" name="dateApplied" type="text" data-date-format="yyyy-mm-dd" id="dateApplied" value="<?php echo date('Y-m-d') ?>" required>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="inputAddress">To pay in every payment term applied for :</label><br />
                <label class="control-label" for="inputAddress"><span id="paymentPerTerm" class="text-danger"></span></label>
            </div>

        </div>

        <div class="panel-footer clearfix">
            <span onclick="saveLoan()" class="btn btn-success btn-xs pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-save"></i> Save</span>
            <span style="margin-right:5px" class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-hidden="true">Cancel</span>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dateApplied').datepicker();
    });

    function calculatePaymentPerTerm(term) {
        var amount = $('#loan_amount').val();
        var paymentPerTerm = (parseFloat(amount) / parseFloat(term)).toFixed(2);
        $('#paymentPerTerm').html(paymentPerTerm);
    }

    function getDtype(type_id, type) {
        $('#dtype_name').html(type);
        $('#odpType_id').val(type_id);
    }

    function saveLoan() {
        var item = $('#deduction_type').val();
        var terms = $('#odp_terms').val();
        var no_of_payments = $('#no_of_payments').val();
        var payment_per_term = $('#paymentPerTerm').html();
        var amount = $('#loan_amount').val();
        var acct = '<?php echo $basicInfo->em_id ?>';
        var dateApplied = $('#dateApplied').val();

        var url = "<?php echo base_url() . 'hr/payroll/saveAmortization/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'item=' + item + '&terms=' + terms + '&applied_date=' + dateApplied + '&no_of_payments=' + no_of_payments + '&payment_per_term=' + payment_per_term + '&em_id=' + acct + '&amount=' + amount + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (data.status) {
                    alert(data.msg)
                    location.reload()
                } else {
                    alert(data.msg)
                }

            }
        });

        return false;
    }
</script>