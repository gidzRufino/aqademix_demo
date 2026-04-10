<style>
    .finance-plan {
        position: relative;
        z-index: 1;
    }

    .finance-plan.active-plan {
        position: relative;
        z-index: 2001;
        transform: none !important;
        /* 🔥 important */
    }

    /* ✅ STOP movement when dropdown is open */
    .finance-plan.active-plan:hover {
        transform: none !important;
    }

    .finance-plan .card-header {
        transition: all 0.2s ease;
    }

    .finance-plan .card-header:hover {
        background-color: #f8f9fa;
    }

    .charge-row {
        transition: background-color 0.2s ease;
    }

    .charge-row:hover {
        background-color: #f8f9fa;
    }

    .total-row {
        font-size: 0.95rem;
    }

    /* .plan-body {
        overflow: hidden;
        pointer-events: auto;
        will-change: transform, opacity;
    } */

    /* KEY PART */
    /* dropdown panel */
    .plan-body {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;

        z-index: 2000;

        background: #fff;
        border-radius: 10px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);

        display: none;

        /* ✅ FIX flicker */
        transform: translateZ(0);
        backface-visibility: hidden;
    }
</style>

<div class="card shadow-sm mb-3 finance-plan">

    <!-- Header -->
    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <div class="d-flex flex-column">
            <h6 class="mb-0 fw-semibold">
                <?php echo $grade_level . ($plan_title != "" ? ' - ' . $plan_title : ''); ?>
            </h6>
            <small class="text-muted">Click eye icon to view details</small>
        </div>

        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-primary"
                onclick="setFinanceCharges('<?php echo $grade_id ?>','<?php echo $plan_id ?>','<?php echo $grade_level ?>','<?php echo $plan_title ?>')">
                <i class="fa fa-plus"></i>
            </button>

            <button class="btn btn-outline-success"
                onclick="event.stopPropagation(); togglePlan('<?php echo $plan_id ?>')">
                <i id="eye_<?php echo $plan_id ?>" class="fa fa-eye-slash"></i>
            </button>

            <button class="btn btn-outline-warning"
                onclick="editFinPlan('<?php echo $plan_id ?>','<?php echo ($plan_title != '' ? $plan_title : ''); ?>')">
                <i class="fa fa-edit"></i>
            </button>

            <button class="btn btn-outline-danger"
                onclick="deletePlan('<?php echo $plan_id ?>','<?php echo ($plan_title != '' ? $plan_title : '') ?>')">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>

    <!-- Collapsible Body -->
    <div class="card-body p-0 plan-body" id="<?php echo $plan_id ?>" data-open="0" style="display:none;">

        <!-- 🔍 Search -->
        <div class="p-3 border-bottom bg-light">
            <input type="text" class="form-control form-control-sm"
                placeholder="Search fee..."
                onkeyup="filterCharges(this, '<?php echo $plan_id ?>')">
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Particulars</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">SY</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    foreach ($charges as $c):
                        $next = $c->school_year + 1;
                        $total += $c->amount;
                    ?>

                        <tr class="charge-row"
                            data-desc="<?php echo strtolower($c->item_description) ?>"
                            id="tr_<?php echo $c->charge_id ?>">

                            <td><?php echo $i++; ?></td>

                            <td class="fw-medium">
                                <?php echo $c->item_description ?>
                            </td>

                            <td class="text-end fw-semibold text-success"
                                id="td_<?php echo $c->charge_id ?>">
                                ₱ <?php echo number_format($c->amount, 2) ?>
                            </td>

                            <td class="text-end text-muted">
                                <?php echo $c->school_year . ' - ' . $next ?>
                            </td>

                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-warning"
                                        onclick="editFinItem('<?php echo trim($c->item_description) ?>','<?php echo $c->amount ?>','<?php echo $c->charge_id ?>')">
                                        <i class="fa fa-pen"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"
                                        onclick="$('#deleteFinCharges').modal('show'); $('#del_charge_id').val('<?php echo $c->charge_id ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    <!-- TOTAL -->
                    <tr class="table-light total-row">
                        <th colspan="2">TOTAL</th>
                        <th class="text-end text-primary">
                            ₱ <?php echo number_format($total, 2) ?>
                        </th>
                        <th colspan="2"></th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function editFinPlan(plan_id, plan) {
        $('#editFinPlan').modal('show');
        $('#finPlanID').val(plan_id);
        $('#edit_fin_plan').val(plan);
    }

    function saveEditPlan() {
        var plan_id = $('#finPlanID').val();
        var plan = $('#edit_fin_plan').val();

        var url = "<?php echo base_url() . 'finance/editFinPlan' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "plan_id=" + plan_id + "&plan=" + plan + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                showTopAlert(data, 'success', 'reload')
            }
        });

        return false;
    }

    function showFeeDetails(id) {
        let el = $('#' + id);
        let isOpen = el.attr('data-open');

        if (isOpen == 1) {
            el.attr('data-open', 0);
            el.slideUp(200);
            $('#eye_' + id).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            el.attr('data-open', 1);
            el.slideDown(200);
            $('#eye_' + id).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    function deletePlan(plan_id, plan) {
        var con = confirm('Are you sure you want to delete this Plan? This might be connected to the finance charges under this plan. Please also note that you cannot undo this action.');
        if (con == true) {
            var url = "<?php echo base_url() . 'finance/deletePlan' ?>"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                //dataType:'json',
                data: "plan_id=" + plan_id + "&plan=" + plan + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
            location.reload();

            return false;
        }
    }

    // 🔹 Accordion Toggle (ONLY ONE OPEN)
    let currentPlan = null;

    function togglePlan(id) {
        let el = $('#' + id);
        let parentCard = el.closest('.finance-plan');
        let isOpen = el.attr('data-open') === "1";

        if (isOpen) {
            closePlan();
            return;
        }

        closePlan();

        parentCard.addClass('active-plan');

        $('#blurOverlay')
            .removeClass('d-none')
            .addClass('active');

        el
            .stop(true, true) // ✅ prevent animation queue flicker
            .attr('data-open', 1)
            .fadeIn(120);

        currentPlan = id;

        $('i[id^="eye_"]').removeClass('fa-eye').addClass('fa-eye-slash');
        $('#eye_' + id).removeClass('fa-eye-slash').addClass('fa-eye');
    }

    function closePlan() {
        if (!currentPlan) return;

        let el = $('#' + currentPlan);
        let parentCard = el.closest('.finance-plan');

        el.attr('data-open', 0).fadeOut(120);

        parentCard.removeClass('active-plan');

        $('#blurOverlay')
            .addClass('d-none')
            .removeClass('active');

        $('#eye_' + currentPlan).removeClass('fa-eye').addClass('fa-eye-slash');

        currentPlan = null;
    }

    $('#blurOverlay').on('click', function() {
        closePlan();
    });
    // click outside = close
    // $(document).on('click', function(e) {
    //     if (
    //         currentPlan &&
    //         !$(e.target).closest('.plan-body, .btn-outline-success').length
    //     ) {
    //         closePlan();
    //     }
    // });

    // 🔹 Search Filter
    function filterCharges(input, plan_id) {
        let keyword = $(input).val().toLowerCase();

        $('#' + plan_id + ' .charge-row').each(function() {
            let desc = $(this).data('desc');

            if (desc.includes(keyword)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('.plan-body').on('click', function(e) {
        e.stopPropagation();
    });

    // $(document).on('click', function(e) {
    //     if (!currentPlan) return;

    //     let isInsidePlan = $(e.target).closest('.finance-plan').length;

    //     if (!isInsidePlan) {
    //         closePlan();
    //     }
    // });
</script>