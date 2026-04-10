<?php
$attributes = array('id' => 'fundTransferForm', 'role' => 'form');
echo form_open(base_url() . 'finance/finance_pisd/processFundTransfer', $attributes);
?>
<div class="mb-3">
    <label for="searchTransferBox" class="form-label">
        Transfer To Account
        <small class="text-info d-block">Note: Leave blank if transferring to the same account</small>
    </label>
    <div class="position-relative">
        <input type="text" id="searchTransferBox" class="form-control" placeholder="Search Name Here" onkeyup="searchTransferAccount(this.value)">

        <div id="searchTransferName" class="position-absolute bg-white border rounded w-100 mt-1 d-none" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
            <!-- Dynamic search results will appear here -->
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="transferSchoolYearControl" class="form-label">Select School Year</label>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="btnTransferControl" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $school_year . ' - ' . ($school_year + 1) ?>
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="btnTransferControl">
            <?php
            $ro_years = Modules::run('registrar/getROYear');
            foreach ($ro_years as $ro) {
                $roYears = $ro->ro_years + 1;
            ?>
                <li>
                    <a class="dropdown-item" href="#" onclick="$('#btnTransferControl').text('<?php echo $ro->ro_years . ' - ' . $roYears; ?>'); $('#transferSchoolYearTo').val('<?php echo $ro->ro_years ?>')">
                        <?php echo $ro->ro_years . ' - ' . $roYears; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="mb-3">
    <label for="transferItemTo" class="form-label">Transfer Item To</label>
    <select class="form-select" name="transferItemTo" id="transferItemTo" required>
        <option value="0">Select Item</option>
        <?php
        foreach ($fin_items as $i) {
            $selected = ($i->item_id == $transaction->t_charge_id) ? 'selected' : '';
        ?>
            <option <?php echo $selected ?> value="<?php echo $i->item_id ?>" onclick="$('#transferItemNameTo').val('<?php echo strtoupper($i->item_description); ?>')">
                <?php echo strtoupper($i->item_description); ?>
            </option>
        <?php } ?>
    </select>
</div>

<div class="mb-3">
    <label for="transferedAmount" class="form-label">Transfer Amount</label>
    <input type="text" name="transferedAmount" id="transferedAmount" class="form-control" value="<?php echo $transaction->t_amount ?>" placeholder="Amount" onclick="$(this).val('')">
</div>

<!-- Hidden Inputs -->
<input type="hidden" name="transferItemFrom" id="transferItemFrom" value="<?php echo $transaction->t_charge_id ?>" />
<input type="hidden" name="transferItemNameFrom" id="transferItemNameFrom" value="<?php echo strtoupper($transaction->item_description) ?>" />
<input type="hidden" name="transferItemNameTo" id="transferItemNameTo" value="<?php echo strtoupper($transaction->item_description) ?>" />
<input type="hidden" name="transferPaymentType" id="transferPaymentType" value="<?php echo $transaction->t_type ?>" />
<input type="hidden" name="transferSchoolYear" id="transferSchoolYear" value="<?php echo $school_year ?>" />
<input type="hidden" name="transferSchoolYearTo" id="transferSchoolYearTo" value="<?php echo $school_year ?>" />
<input type="hidden" name="transferSTIDFrom" id="transferSTIDFrom" value="<?php echo $st_id ?>" />
<input type="hidden" name="transferSTID" id="transferSTID" value="<?php echo $st_id ?>" />
<input type="hidden" name="transferRefNumber" id="transferRefNumber" value="<?php echo $transaction->ref_number ?>" />
<input type="hidden" name="transferReceiptType" id="transferReceiptType" value="<?php echo $transaction->t_receipt_type ?>" />
<input type="hidden" name="transferAmountFrom" id="transferAmountFrom" value="<?php echo $transaction->t_amount ?>" />
<input type="hidden" name="transferNameFrom" id="transferNameFrom" value="<?php echo $name ?>" />
<input type="hidden" name="transferNameTo" id="transferNameTo" value="<?php echo $name ?>" />
<input type="hidden" name="transfer_trans_id" id="transfer_trans_id" value="<?php echo $transaction->trans_id ?>" />
</form>

<script>
    function processFundTransfer() {
        var data = $('#fundTransferForm').serialize();
        var url = '<?php echo base_url() . 'finance/finance_pisd/processFundTransfer/' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            beforeSend: function() {
                // Optional: add spinner or disable button
            },
            success: function(response) {
                alert(response);
                location.reload();
            }
        });
        return false;
    }
</script>