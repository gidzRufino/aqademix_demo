<div class="card shadow-sm border-0">
    <div class="card-body p-3">

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width:100%;">

                <thead class="table-light text-uppercase small">
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Item Description</th>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                        <th class="text-end">Charge</th>
                        <th class="text-end">Payments</th>
                        <th class="text-end">Balance</th>
                        <th class="text-end" style="width: 140px;">Amount</th>
                    </tr>
                </thead>

                <tbody id="itemBody">
                    <?php
                    $chargeAmount   = 0;
                    $totalDiscount  = 0;
                    $totalCharges   = 0;
                    $totalPayments = 0;

                    if ($charges != 0):
                        foreach ($charges as $c):

                            $discount = Modules::run('finance/billing/getTransactionByCategory', $student->st_id, 0, $student->school_year, $c->category_id, 2);
                            $totalDiscount += $discount->amount;

                            $totalCharges += $c->amount;

                            $payments = Modules::run('finance/getTransactionByItem', $student->st_id, NULL, $school_year, $c->item_id);

                            $tfdiscount = Modules::run('finance/billing/getTransactionByCategory', $student->st_id, 0, $student->school_year, $c->category_id, 2);
                            $tfdiscounts = $tfdiscount->amount;

                            $chargeAmount = $c->amount - $tfdiscounts;

                            foreach ($payments->result() as $p):
                                $totalPayments += $p->t_amount;
                            endforeach;

                            if ($c->item_id == 1):
                                $totalPaymentwDiscount = $totalPayments + $tfdiscounts;
                                $totalBalance = max(0, $chargeAmount - $totalPaymentwDiscount);
                            else:
                                $totalBalance = $chargeAmount - $totalPayments;
                            endif;
                    ?>

                            <tr id="trp_<?php echo $c->item_id ?>"
                                class="<?php echo ($totalBalance <= 0 ? 'table-success opacity-75' : '') ?>">
                                <td class="text-center">
                                    <input
                                        td_id="<?php echo $c->item_id ?>"
                                        class="form-check-input"
                                        type="checkbox"
                                        <?php echo ($totalBalance <= 0 ? 'disabled checked title="Already fully paid"' : '') ?>>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark d-flex justify-content-between align-items-center">
                                        <span><?php echo strtoupper($c->item_description) ?></span>

                                        <?php
                                        if ($totalBalance <= 0) {
                                            echo '<span class="badge bg-success">Paid</span>';
                                        } elseif ($totalPayments > 0) {
                                            echo '<span class="badge bg-warning text-dark">Partial</span>';
                                        } else {
                                            echo '<span class="badge bg-danger">Unpaid</span>';
                                        }
                                        ?>
                                    </div>
                                </td>

                                <!-- FROM -->
                                <td class="text-center">
                                    <select class="form-select form-select-sm d-none"
                                        name="sfrom<?php echo $c->item_id ?>"
                                        id="sfrom<?php echo $c->item_id ?>">
                                        <option>From</option>
                                        <?php
                                        $months = ["Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.", "Jul.", "Aug.", "Sept.", "Oct.", "Nov.", "Dec"];
                                        foreach ($months as $month): ?>
                                            <option value="<?= $month ?>"><?= $month ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <!-- TO -->
                                <td class="text-center">
                                    <select class="form-select form-select-sm d-none"
                                        name="sto<?php echo $c->item_id ?>"
                                        id="sto<?php echo $c->item_id ?>">
                                        <option>To</option>
                                        <?php foreach ($months as $month): ?>
                                            <option value="<?= $month ?>"><?= $month ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <!-- NUMBERS -->
                                <td class="text-end fw-semibold text-primary"
                                    id="charges_<?php echo $c->item_id ?>"
                                    tdCharges="<?php echo $chargeAmount ?>">
                                    <?php echo number_format($chargeAmount, 2) ?>
                                </td>

                                <td class="text-end text-success"
                                    id="payments_<?php echo $c->item_id ?>"
                                    tdPayment="<?php echo $totalPayments ?>">
                                    <?php echo number_format($totalPayments, 2) ?>
                                </td>

                                <td class="text-end fw-bold text-danger">
                                    <?php echo number_format($totalBalance, 2) ?>
                                </td>

                                <td id="due_<?php echo $c->item_id ?>"
                                    class="text-end editable_<?php echo $c->item_id ?>"
                                    tdValue="0"></td>
                            </tr>

                            <?php
                            $totalPayments = 0;
                            $totalBalance = 0;
                        endforeach;
                        $extraC = Modules::run('finance/finance_pisd/getExtraFinanceCharges', $student->st_id, 0, $student->school_year);
                        if ($extraC->num_rows() > 0):
                            foreach ($extraC->result() as $exc):
                                $incharges = Modules::run('finance/finance_pisd/inCharges', $exc->item_id, $plan->fin_plan_id);
                                if (!$incharges):
                                    $mxPayments = Modules::run('finance/finance_pisd/getTransactionByItemId', $student->st_id, NULL, $student->school_year, $exc->item_id);
                                    foreach ($mxPayments->result() as $mxp):
                                        $totalMxpayments += $mxp->t_amount;
                                    endforeach;
                                    $totalMxBalance = $exc->amount - $totalMxpayments;
                                    // 100 - 30 = 70
                                    echo $totalMxpayments;
                                    if ($totalMxBalance > 0):
                            ?>
                                        <tr id="trp_<?php echo $exc->item_id ?>"
                                            class="table-light border-start border-3 border-warning">

                                            <!-- CHECKBOX -->
                                            <td class="text-center">
                                                <input
                                                    td_id="<?php echo $exc->item_id ?>"
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    <?php echo ($totalMxBalance <= 0 ? 'disabled checked title="Already fully paid"' : '') ?>>
                                            </td>

                                            <!-- DESCRIPTION -->
                                            <td>
                                                <div class="fw-semibold text-dark d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fa fa-plus-circle text-warning me-1"></i>
                                                        <?php echo strtoupper($exc->item_description) ?>
                                                    </span>

                                                    <?php
                                                    if ($totalMxBalance <= 0) {
                                                        echo '<span class="badge bg-success">Paid</span>';
                                                    } elseif ($totalMxpayments > 0) {
                                                        echo '<span class="badge bg-warning text-dark">Partial</span>';
                                                    } else {
                                                        echo '<span class="badge bg-danger">Unpaid</span>';
                                                    }
                                                    ?>

                                                    <span class="badge bg-warning text-dark ms-2">Extra</span>
                                                </div>
                                            </td>

                                            <!-- FROM -->
                                            <td class="text-center">
                                                <select class="form-select form-select-sm d-none"
                                                    name="sfrom<?php echo $exc->item_id ?>"
                                                    id="sfrom<?php echo $exc->item_id ?>">
                                                    <option>From</option>
                                                    <?php foreach ($months as $month): ?>
                                                        <option value="<?= $month ?>"><?= $month ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>

                                            <!-- TO -->
                                            <td class="text-center">
                                                <select class="form-select form-select-sm d-none"
                                                    name="sto<?php echo $exc->item_id ?>"
                                                    id="sto<?php echo $exc->item_id ?>">
                                                    <option>To</option>
                                                    <?php foreach ($months as $month): ?>
                                                        <option value="<?= $month ?>"><?= $month ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>

                                            <!-- CHARGES -->
                                            <td class="text-end fw-semibold text-primary"
                                                id="charges_<?php echo $exc->item_id ?>"
                                                tdCharges="<?php echo $exc->amount ?>">
                                                <?php echo number_format($exc->amount, 2) ?>
                                            </td>

                                            <!-- PAYMENTS -->
                                            <td class="text-end text-success"
                                                id="payments_<?php echo $exc->item_id ?>"
                                                tdPayment="<?php echo $totalMxpayments ?>">
                                                <?php echo number_format($totalMxpayments, 2) ?>
                                            </td>

                                            <!-- BALANCE -->
                                            <td class="text-end fw-bold text-danger">
                                                <?php echo number_format($totalMxBalance, 2) ?>
                                            </td>

                                            <!-- AMOUNT INPUT -->
                                            <td id="due_<?php echo $exc->item_id ?>"
                                                class="text-end editable_<?php echo $exc->item_id ?>"
                                                tdValue="0"></td>

                                        </tr>
                    <?php
                                    endif;
                                    $totalMxpayments = 0;
                                endif;

                            endforeach;
                        endif;
                    else:
                        echo '<tr><td colspan="8" class="text-center text-danger fw-bold py-4">NO FEES SET</td></tr>';
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if ($charges != 0): ?>
    <div class="card mt-3 shadow-sm border-0">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">TOTAL</label>
                    <input class="form-control text-center fw-bold text-danger fs-4"
                        name="pttAmount" id="pttAmount" value="0" disabled>
                </div>

                <div class="col-md-3">
                    <label class="form-label">AMOUNT TENDERED</label>
                    <input class="form-control text-center fw-bold text-success fs-4"
                        name="ptAmountTendered" id="ptAmountTendered"
                        onblur="cash_change()" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">CHANGE</label>
                    <input class="form-control text-center fw-bold text-primary fs-4"
                        name="ptChange" id="ptChange" disabled>
                </div>

                <div class="col-md-3 d-grid gap-2">
                    <button type="button" class="btn btn-success btn-lg" id="paynow">
                        <i class="fa fa-check-circle me-1"></i> Pay Now
                    </button>

                    <button type="button" class="btn btn-outline-danger"
                        onclick="$('#pttAmount').val(0)">
                        <i class="fa fa-times me-1"></i> Clear
                    </button>
                </div>

            </div>

        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    var total = 0;

    $(function() {
        $("#refNumber").keyup(function() {
            //Reference the Button.
            var btnSubmit = $("#paynow");
            //Verify the TextBox value.
            if ($(this).val().trim() != "") {
                btnSubmit.attr("onclick", "$('#confirmPayment').modal('show')");
            }
        });
    });

    $('#paynow').click(function() {
        var btnSubmit = $("#paynow");
        if ($('#refNumber').val() == '') {
            alert("Empty OR Number. Enter a value for OR Number");
        }
    });


    $(function() {

        $('.form-check-input').click(function() {
            if ($(this).is(':disabled')) {
                return false;
            }

            if ($(this).is(':checked')) {
                var id = $(this).attr('td_id');
                if (id == 1 || id == 10) {
                    var sfromid = '#sfrom' + id;
                    var stoid = '#sto' + id;
                    $(sfromid).removeClass('d-none');
                    $(stoid).removeClass('d-none');
                }
                var OriginalContent = $('.editable_' + id).attr('tdValue');
                $('.editable_' + id).addClass("cellEditing");
                $('.editable_' + id).html(`
                    <input 
                        type="number"
                        class="form-control form-control-sm text-end w-100"
                        style="height:100%; box-sizing:border-box;"
                        placeholder="0.00"
                    />
                `);
                $('.editable_' + id).children().first().focus();
                $('.editable_' + id).children().first().keypress(function(e) {
                    if (e.which == 13) {
                        console.log($('.editable_' + id).attr('tdValue'));
                        var newContent = $(this).val();
                        var charges = $('#charges_' + id).attr('tdCharges');
                        var totalPayment = $('#payments_' + id).attr('tdPayment');
                        if ((charges - totalPayment) > 0) {
                            var xx = charges - totalPayment;
                            var round_xx = xx.toFixed(2);
                            //                            alert(round_xx + ' ' + parseFloat(newContent) + ' ' + (round_xx >= parseInt(newContent)) + ' ' + charges + ' ' + totalPayment)
                            if (round_xx >= parseFloat(newContent)) {
                                calculate(newContent, 'add')
                                $('.editable_' + id).attr('tdValue', newContent);
                                $('#trp_' + id).attr('tr_val', id + '_' + newContent)

                                $(this).parent().html(numberWithCommas(parseFloat(newContent).toFixed(2)));
                                $(this).parent().removeClass("cellEditing");

                            } else {
                                alert('Excess payment! Please check the remaining balance.');
                            }
                        } else {
                            alert('Already paid the full');
                            $(this).parent().html('');
                            $(this).parent().removeClass("cellEditing");
                            $('.form-check-input').prop('checked', false);

                        }

                    }
                });

            } else {
                var id = $(this).attr('td_id');
                var OriginalContent = $('.editable_' + id).attr('tdValue');
                if (id == 1 || id == 10) {
                    var sfromid = '#sfrom' + id;
                    var stoid = '#sto' + id;
                    $(sfromid).addClass('d-none');
                    $(stoid).addClass('d-none');
                }
                calculate(OriginalContent, 'minus');
                $('.editable_' + id).attr('tdValue', 0)
                $('.editable_' + id).html('');
                $('#trp_' + id).attr('tr_val', '');

            }

        });


        function calculate(value, option) {
            if (option == 'add') {
                total = parseFloat(total) + parseFloat(value);
            } else {
                total = parseFloat(total) - parseFloat(value);

            }
            $('#pttAmount').val(numberWithCommas(total.toFixed(2)));
        }
    })


    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }

        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<style id="s9l2k1">
    #itemBody tr.active-row {
        background: rgba(13, 110, 253, 0.08);
        transition: 0.2s ease;
    }

    #itemBody tr:hover {
        background: rgba(0, 0, 0, 0.03);
    }

    [class^="editable_"] input {
        border-radius: 0;
        border: none;
        box-shadow: none;
    }

    .editable_1,
    .editable_2,
    [class^="editable_"] {
        padding: 0.25rem !important;
    }

    #itemBody td {
        white-space: nowrap;
    }

    #itemBody td:last-child {
        width: 140px;
    }
</style>