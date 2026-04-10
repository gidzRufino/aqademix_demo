<div class="container-fluid">

    <div class="row g-3">

        <!-- 🔹 FINANCE ITEM -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Finance Item</label>
            <select name="editFinItems" id="editFinItems" class="form-select" required>
                <option value="0">Select Item</option>

                <?php foreach ($fin_items as $i):
                    $selected = ($i->item_id == $transaction->t_charge_id) ? 'selected' : '';
                ?>
                    <option <?= $selected ?> value="<?= $i->item_id ?>">
                        <?= strtoupper($i->item_description) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- 🔹 REFERENCE NUMBER -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Reference #</label>
            <input type="text"
                id="editRefNumber"
                class="form-control"
                value="<?= $transaction->ref_number ?>"
                placeholder="Enter OR Number">
        </div>

        <!-- 🔹 RECEIPT TYPE -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Receipt Type</label>

            <?php
            $or = $transaction->t_receipt_type == 0 ? 'selected' : '';
            $ar = $transaction->t_receipt_type == 1 ? 'selected' : '';
            $tr = $transaction->t_receipt_type == 2 ? 'selected' : '';
            ?>

            <select id="inputEditReceipt" class="form-select">
                <option <?= $or ?> value="0">Official Receipt</option>
                <option <?= $ar ?> value="1">Acknowledgment Receipt</option>
                <option <?= $tr ?> value="2">Temporary Receipt</option>
            </select>
        </div>

        <!-- 🔹 TRANSACTION DATE -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Transaction Date</label>
            <input type="date"
                id="editTransactionDate"
                class="form-control"
                value="<?= $transaction->t_date ?>"
                required>
        </div>

        <!-- 🔹 AMOUNT -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Amount</label>
            <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="text"
                    id="editTransAmount"
                    class="form-control fw-semibold"
                    value="<?= $transaction->t_amount ?>"
                    placeholder="Enter amount">
            </div>
        </div>

        <!-- 🔹 REMARKS -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Remarks</label>
            <textarea
                id="editRemarks"
                class="form-control"
                rows="2"
                placeholder="Optional remarks..."><?= htmlspecialchars($transaction->t_remarks) ?></textarea>
            <small class="text-muted">Add notes or description (optional)</small>
        </div>

    </div>

    <!-- HIDDEN -->
    <input type="hidden" id="edit_trans_id" value="<?= $transaction->trans_id ?>" />

</div>
<script>
    const remarks = document.getElementById('editRemarks');
    remarks.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
</script>