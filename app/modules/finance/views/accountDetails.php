<style>
    /* Subtle hover effect */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.2s ease-in-out;
    }

    /* Soft gradient cards */
    .card-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: #fff;
    }

    .card-gradient-success {
        background: linear-gradient(135deg, #1cc88a, #13855c);
        color: #fff;
    }

    .card-gradient-danger {
        background: linear-gradient(135deg, #e74a3b, #b02a1f);
        color: #fff;
    }

    /* Glass feel */
    .card-soft {
        backdrop-filter: blur(6px);
        background: rgba(255, 255, 255, 0.9);
    }

    /* Sticky header */
    .table-sticky thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f8f9fa;
    }

    /* Scrollable table */
    .table-container {
        max-height: 350px;
        overflow-y: auto;
    }

    /* Hover */
    .table-hover tbody tr:hover {
        background-color: #f5f7fa;
    }

    /* Progress bar height */
    .progress {
        height: 8px;
        border-radius: 10px;
    }

    .dropdown-menu {
        font-size: 13px;
    }

    .dropdown-item {
        padding: 8px 14px;
        transition: 0.2s;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
    }

    .modal-content {
        animation: fadeInUp 0.2s ease;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(10px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    #paymentTable tr {
        transition: background-color 0.4s ease;
    }

    .highlight-row {
        background-color: rgb(70, 156, 217) !important;
        /* soft yellow */
        /* transition: background-color 0.4s ease; */
    }

    @keyframes flashHighlight {
        0% {
            background-color: #ffe69c;
        }

        50% {
            background-color: #fff3cd;
        }

        100% {
            background-color: transparent;
        }
    }

    /* OPTION CARDS */
    .finance-option-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background: #fff;
        transition: all 0.2s ease;
    }

    .finance-option-card:hover {
        border-color: #198754;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .finance-option-card.active {
        border-color: #198754;
        background: rgba(25, 135, 84, 0.05);
    }

    /* KEEP YOUR EXISTING */
    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
        border-color: #198754;
    }

    .btn-success {
        transition: all 0.2s ease;
    }

    .btn-success:hover {
        transform: translateY(-1px);
    }

    /* FLOATING MENU FIX */
    .finance-option-menu {
        position: absolute;
        top: 55px;
        right: 0;
        width: 200px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        padding: 8px 0;
        z-index: 9999;
        /* 🔥 VERY IMPORTANT */
        display: none;
        /* use display instead of d-none */
    }

    /* MENU ITEMS */
    .finance-option-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .finance-option-item:hover {
        background: #f8f9fa;
    }

    /* ICON BUTTON HOVER */
    #financeActionBtn {
        transition: all 0.2s ease;
    }

    #financeActionBtn:hover {
        transform: scale(1.05);
    }

    /* ANIMATION */
    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* KEEP YOUR EXISTING */
    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
        border-color: #198754;
    }

    #extraMenu {
        display: none;
        min-width: 220px;
        border-radius: 0.5rem;
        transform: translateY(-4px);
        margin: 0 !important;
        /* 👈 prevent extra spacing */
    }

    .pointer {
        cursor: pointer;
    }
</style>

<?php
// $student = Modules::run('finance/getBasicStudent', base64_decode($st_id), $school_year, $semester);

$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);

// $charges = ($plan->fin_plan_id != ''
//     ? Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester)
//     : 0);

Modules::run('finance/setFinanceAccount', $student->user_id, $student->school_year, $student->grade_id, $student->semester, $student->st_type);

// ================= TOTAL CHARGES =================
$totalCharges = 0;

if ($charges != 0):
    foreach ($charges as $c):
        $totalCharges += $c->amount;
    endforeach;
endif;

// ================= TOTAL PAID =================
$totalPaid = 0;
$transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);
$extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->st_id, $student->semester, $student->school_year);

if ($transaction->num_rows() > 0):
    foreach ($transaction->result() as $tr):
        if ($tr->t_type != 3):
            $totalPaid += $tr->t_amount;
        endif;
    endforeach;
endif;

?>

<div class="container-fluid">

    <style>
        .card:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>

    <!-- 🔷 PROFILE -->
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

            <?php
            $avatar = ($student->avatar != '' && file_exists('uploads/' . $student->avatar))
                ? base_url('uploads/' . $student->avatar)
                : base_url('images/avatar/' . ($student->sex == 'Female' ? 'female.png' : 'male.png'));
            ?>

            <img src="<?= $avatar ?>" class="rounded-circle border"
                style="width:110px;height:110px;object-fit:cover;">

            <div class="flex-grow-1 text-center text-md-start">
                <h4 class="fw-bold mb-1"><?= $student->firstname . " " . $student->lastname ?></h4>
                <div class="text-muted"><?= $student->level ?> • <?= $student->section ?></div>
                <div class="text-primary fw-semibold">ID: <?= $student->st_id ?></div>

                <div class="mt-2" style="max-width:250px;">
                    <select onchange="setStudentType(this.value)" class="form-select form-select-sm">
                        <?php foreach (Modules::run('finance/getPlanByGrade', $student->grade_id, $school_year) as $pt): ?>
                            <option <?= ($student->st_type == $pt->fin_type_id ? 'selected' : '') ?>
                                value="<?= $pt->fin_type_id ?>">
                                <?= $pt->fin_plan_type ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <a href="<?= base_url('finance/printPermit/' . $this->uri->segment(3)) ?>"
                target="_blank"
                class="btn btn-outline-primary btn-sm">
                Print Permit
            </a>

        </div>
    </div>
    <input type="hidden" id="finPlan_id" value="<?php echo $plan->fin_plan_id ?>" />

    <!-- 🔷 SUMMARY + CHARGES (MERGED ROW) -->
    <div class="row g-4 mb-4">

        <!-- 🔹 LEFT: FINANCE CHARGES -->
        <div class="col-lg-8">

            <div class="card card-soft border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                <!-- HEADER -->
                <div class="card-header bg-white border-0 py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>
                            <h6 class="mb-0 fw-bold">Finance Charges</h6>
                            <small class="text-muted">Breakdown of student charges</small>
                        </div>

                        <!-- OPTION SELECTOR -->
                        <div class="d-flex justify-content-end mb-3">

                            <div class="dropdown text-end mb-3">

                                <!-- ICON BUTTON -->
                                <button class="btn btn-sm btn-success rounded-circle shadow-sm"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="width:40px; height:40px;">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <!-- DROPDOWN MENU -->
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                            href="#"
                                            onclick="openFinanceModal('charge')">
                                            <i class="fa fa-plus-circle text-success"></i>
                                            Add Charge
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                            href="#"
                                            onclick="openFinanceModal('discount')">
                                            <i class="fa fa-tag text-warning"></i>
                                            Add Discount
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="text-muted small" style="width:60px;">#</th>
                                <th class="text-muted small">Particular</th>
                                <th class="text-end text-muted small">Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            if ($charges != 0):
                                foreach ($charges as $c):
                            ?>
                                    <tr>
                                        <td class="fw-semibold text-muted"><?= $i++ ?></td>

                                        <td class="fw-medium">
                                            <?= $c->item_description ?>
                                        </td>

                                        <td class="text-end fw-bold">
                                            ₱ <?= number_format($c->amount, 2) ?>
                                        </td>
                                    </tr>

                                    <?php endforeach;

                                $totalExtra = 0;

                                if ($extraCharges->num_rows() > 0):
                                    foreach ($extraCharges->result() as $ec):
                                    ?>
                                        <tr
                                            class="table-warning align-middle position-relative"
                                            onclick="showExtraMenu(this, <?= $ec->extra_id ?>)"
                                            id="trExtra_<?= $ec->extra_id ?>"
                                            delete_remarks="Extra Charges for <?= $ec->item_description ?> voided: [Amount :<?= number_format($ec->extra_amount, 2, '.', ',') ?>]">

                                            <td class="fw-semibold text-muted">
                                                <?= $i++; ?>
                                            </td>

                                            <td class="fw-medium">
                                                <i class="fa fa-plus-circle text-warning me-1"></i>
                                                <?= $ec->item_description ?>
                                                <span class="badge bg-warning text-dark ms-2">Extra</span>
                                            </td>

                                            <td class="text-end fw-bold text-dark" id="td_<?= $ec->extra_id ?>">
                                                ₱ <?= number_format($ec->extra_amount, 2, '.', ',') ?>
                                            </td>
                                        </tr>
                                <?php
                                        $totalExtra += $ec->extra_amount;
                                    endforeach;

                                    $totalCharges = $totalCharges + $totalExtra;
                                endif;

                            else:
                                ?>

                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="text-muted">
                                            <div style="font-size: 2.2rem;">💳</div>
                                            <div class="fw-semibold mt-2">No charges yet</div>
                                            <small>Add a new charge to begin</small>
                                        </div>
                                    </td>
                                </tr>

                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

        <!-- 🔹 RIGHT: SUMMARY -->
        <div class="col-lg-4">

            <div class="d-flex flex-column gap-3 h-100">

                <!-- TOTAL CHARGES -->
                <div class="card card-gradient-primary border-0 shadow rounded-4">
                    <div class="card-body py-3 px-4">
                        <small class="opacity-75">Total Charges</small>
                        <h5 class="fw-bold mb-0 mt-1">
                            ₱ <?= number_format($totalCharges, 2) ?>
                        </h5>
                    </div>
                </div>

                <!-- TOTAL PAID -->
                <div class="card card-gradient-success border-0 shadow rounded-4">
                    <div class="card-body py-3 px-4">
                        <small class="opacity-75">Total Paid</small>
                        <h5 class="fw-bold mb-0 mt-1">
                            ₱ <?= number_format($totalPaid, 2) ?>
                        </h5>
                    </div>
                </div>
                <?php
                $remainingBalance = $totalCharges - $totalPaid; ?>
                <!-- REMAINING -->
                <div class="card 
                <?= ($remainingBalance > 0 ? 'card-gradient-danger' : 'card-gradient-success') ?> 
                border-0 shadow rounded-4">

                    <div class="card-body py-3 px-4">
                        <small class="opacity-75">Remaining Balance</small>

                        <h5 class="fw-bold mb-1 mt-1">
                            ₱ <?= number_format($remainingBalance, 2) ?>
                        </h5>

                        <small class="fw-semibold">
                            <?= ($remainingBalance > 0 ? 'Unpaid Balance' : 'Fully Settled') ?>
                        </small>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <!-- 🔷 PAYMENTS -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">

        <!-- 🔹 HEADER -->
        <div class="card-header bg-white border-0 py-3 px-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <!-- LEFT -->
                <div class="d-flex align-items-center gap-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#paymentHistoryCollapse"
                    style="cursor:pointer;">
                    <span class="fw-bold">Payments & History</span>
                    <span class="text-muted small" id="collapseIcon">▼</span>
                </div>

                <!-- RIGHT -->
                <div class="d-flex gap-2">
                    <button class="btn btn-warning btn-sm rounded-pill px-3"
                        onclick="$('#cashRegister').modal('show')">
                        Pay
                    </button>

                    <a href="<?= base_url('finance/printSOA/' . $this->uri->segment(3) . '/' . $school_year . '/' . $student->semester . '/null/' . $student->grade_id) ?>"
                        target="_blank"
                        class="btn btn-danger btn-sm rounded-pill px-3">
                        Print SOA
                    </a>
                </div>

            </div>

            <!-- 🔍 SEARCH -->
            <div class="mt-3">
                <input type="text" id="paymentSearch" class="form-control form-control-sm rounded-pill"
                    placeholder="Search transactions...">
            </div>

            <!-- 📊 PROGRESS -->
            <?php
            $progress = ($totalCharges > 0) ? ($totalPaid / $totalCharges) * 100 : 0;
            ?>
            <div class="mt-3">
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Payment Progress</span>
                    <span><?= number_format($progress, 1) ?>%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-success"
                        style="width: <?= $progress ?>%"></div>
                </div>
            </div>

        </div>

        <!-- 🔽 COLLAPSIBLE -->
        <div id="paymentHistoryCollapse" class="collapse show">

            <div class="table-container">
                <table class="table table-hover align-middle mb-0 table-sticky" id="paymentTable" style="table-layout: fixed; width: 100%;">

                    <thead>
                        <tr>
                            <th class="small text-muted">Date</th>
                            <th class="small text-muted">OR #</th>
                            <th class="small text-muted">Particular</th>
                            <th class="text-end small text-muted">Amount</th>
                            <th class="text-end small text-muted">Balance</th>
                            <th class="small text-muted">Remarks</th>
                            <th class="small text-muted">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- TOTAL -->
                        <tr class="bg-light">
                            <td></td>
                            <td>-</td>
                            <td class="fw-semibold">Total Charge</td>
                            <td>-</td>
                            <td class="text-end fw-bold">
                                ₱ <?= number_format($totalCharges, 2) ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php
                        $running = $totalCharges;
                        if ($transaction->num_rows() > 0):
                            foreach ($transaction->result() as $tr):
                                if ($tr->t_type != 3):
                                    $running -= $tr->t_amount;

                                    $balanceClass = ($running > 0) ? 'text-danger' : 'text-success';
                        ?>
                                    <tr id="transaction-<?= $tr->trans_id ?>" onmouseover="$('#delete_trans_type').val('<?php echo $tr->t_type ?>'), $('#delete_trans_id').val('<?php echo $tr->trans_id ?>'), $('#delete_item_id').val('<?php echo $tr->t_charge_id ?>')">
                                        <td><?= $tr->t_date ?></td>

                                        <?php if ($tr->t_type == 2):
                                            $discounts = Modules::run('finance/getDiscountsById', $tr->disc_id);
                                        ?>
                                            <td class="fw-medium"><?= $tr->ref_number ?></td>

                                            <td><?= $tr->item_description ?></td>

                                            <td class="text-end fw-semibold text-success">
                                                ₱ <?= number_format($tr->t_amount, 2) ?>
                                            </td>

                                            <td class="text-end fw-bold <?= $balanceClass ?>">
                                                ₱ <?= number_format($running, 2) ?>
                                            </td>

                                            <td class="text-muted small"><?= $tr->t_remarks ?></td>
                                            <td class="text-center">
                                                <div class="dropdown">

                                                    <button class="btn btn-sm btn-light rounded-circle"
                                                        data-bs-toggle="dropdown"
                                                        onclick="setActiveTransaction(<?= $tr->trans_id ?>)">
                                                        ⋮
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openEditTransaction(this)">
                                                                ✏️ Edit
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                                href="#"
                                                                onclick="openDeleteTransaction()">
                                                                🗑️ Void
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openTransfer()">
                                                                🔁 Transfer
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openRefund()">
                                                                💸 Refund
                                                            </a>
                                                        </li>

                                                    </ul>

                                                </div>
                                            </td>
                                        <?php else: ?>
                                            <td class="fw-medium"><?= $tr->ref_number ?></td>

                                            <td><?= $tr->item_description ?></td>

                                            <td class="text-end fw-semibold text-success">
                                                ₱ <?= number_format($tr->t_amount, 2) ?>
                                            </td>

                                            <td class="text-end fw-bold <?= $balanceClass ?>">
                                                ₱ <?= number_format($running, 2) ?>
                                            </td>

                                            <td class="text-muted small"><?= $tr->t_remarks ?></td>
                                            <td class="text-center">
                                                <div class="dropdown">

                                                    <button class="btn btn-sm btn-light rounded-circle"
                                                        data-bs-toggle="dropdown"
                                                        onclick="setActiveTransaction(<?= $tr->trans_id ?>)">
                                                        ⋮
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openEditTransaction(this)">
                                                                ✏️ Edit
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                                href="#"
                                                                onclick="openDeleteTransaction()">
                                                                🗑️ Void
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openTransfer()">
                                                                🔁 Transfer
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#"
                                                                onclick="openRefund()">
                                                                💸 Refund
                                                            </a>
                                                        </li>

                                                    </ul>

                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                        <?php if ($transaction->num_rows() == 0): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div style="font-size:2rem;">📄</div>
                                    <div>No payment records yet</div>
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </div>

    </div>


    <!-- 🖼️ ONLINE PAYMENTS -->
    <div class="card border-0 shadow-sm rounded-4 mt-3">
        <div class="card-header fw-semibold">Online Deposit Slips</div>

        <div class="card-body">
            <div class="row g-3">
                <?php
                $directory = 'uploads/' . $student->school_year . '/students/' . $student->st_id . '/online_payments';
                if (is_dir($directory)):
                    foreach (array_diff(scandir($directory), ['.', '..']) as $file):
                ?>
                        <div class="col-6 col-md-4 col-lg-2">
                            <img src="<?= base_url($directory . '/' . $file) ?>"
                                class="img-fluid rounded border"
                                style="height:120px;object-fit:cover;">
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>


    <!-- 🧾 PARENT RECEIPTS -->
    <div class="card border-0 shadow-sm rounded-4 mt-3">

        <div class="card-header d-flex justify-content-between">
            <span class="fw-semibold">Parent Receipts</span>
            <button class="btn btn-primary btn-sm"
                onclick="$('#uploadReceipt').modal('show')">
                Upload
            </button>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <?php
                $directory = 'uploads/' . $student->school_year . '/students/' . $student->st_id . '/original_receipts';
                if (is_dir($directory)):
                    foreach (array_diff(scandir($directory), ['.', '..']) as $file):
                ?>
                        <div class="col-6 col-md-4 col-lg-2">
                            <img src="<?= base_url($directory . '/' . $file) ?>"
                                class="img-fluid rounded border"
                                style="height:120px;object-fit:cover;">
                        </div>
                <?php endforeach;
                endif; ?>

            </div>
        </div>

    </div>

</div>
<div class="modal fade in" id="uploadReceipt">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h6 class="modal-title float-left">Upload Original Receipt</h6>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="upload_form" enctype="multipart/form-data" method="post">
                    <input type="file" name="userfile" id="userfile"><br>
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" id="paymentRemarks"></textarea>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="isEnrollment">
                        <label class="form-check-label">Enrollment Payment Receipt</label>
                    </div>
                    <div class="progress" id="progressBarWrapper">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            UPLOADING RECEIPT...
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="addItemModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Item</label>
                <input type="text" id="fin_item" class="form-control" placeholder="Item" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a href='#' data-dismiss='modal' onclick='addItems()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="addCashItemModal" class="modal fade" style="width:15%; margin:50px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Finance Item</label> <br />
                <select style="width:90%;" name="cashFinItems" id="cashFinItems" required onclick="calculateItem(this.value)">
                    <option value="0">Select Item</option>
                    <?php
                    foreach ($fin_items as $i) {
                    ?>
                        <option id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="edit_fin_amount" class="form-control" placeholder="Amount" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a href='#' data-dismiss='modal' onclick='addToItems()' style='color: white' class='btn btn-xs btn-success pull-right'>Add</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px; ">Cancel</button> &nbsp;&nbsp;
        </div>
    </div>
</div>





<div id="otherMenu">
    <?php
    $pos = $this->session->userdata('position_id');
    if ($pos != 40) {
    ?>
        <ul class="dropdown-menu" role="menu">
            <li onclick="$('#transferFinTransaction').modal('show'), prepareFundTransfer()" class="pointer text-danger"><a class="pointer text-danger" href="#"> <i class="fa fa-send fa-fw"></i>TRANSFER FUNDS</a></li>
            <li onclick="$('#refundTransaction').modal('show'), loadRefundTransaction()"><a class="pointer text-danger" href="#"> <i class="fa fa-reply fa-fw"></i>REFUND</a></li>
            <li onclick="$('#editFinTransaction').modal('show'), loadFinanceTransaction()"><a class="pointer text-danger" href="#"> <i class="fa fa-edit fa-fw"></i>EDIT TRANSACTION</a></li>
            <li onclick="$('#deleteFinTransaction').modal('show')" class="pointer text-danger"><a class="pointer text-danger" href="#"> <i class="fa fa-trash fa-fw"></i>VOID TRANSACTION</a></li>
        </ul>
    <?php
    } else {
    ?>
        <ul class="dropdown-menu" role="menu">
            <li class="pointer text-danger"><a class="pointer text-danger" href="#"> <i class="fa fa-times fa-fw"></i>You are not allowed to access the options. Please contact your finance head.</a></li>
        </ul>
    <?php
    }
    ?>
</div>
<div id="extraMenu" class="dropdown-menu shadow-sm border-0">
    <li class="dropdown-item text-danger pointer"
        onclick="openDeleteExtraModal()">
        <i class="fa fa-trash me-2"></i> DELETE EXTRA CHARGE
    </li>
</div>

<script type="text/javascript">
    var itemDescID = "";
    var Amount = 0;
    var itemId = "";
    var printUrl = "";

    let activeExtraId = null;

    function showExtraMenu(row, extraId) {
        activeExtraId = extraId;
        $('#delete_trans_id').val(extraId);

        const menu = $('#extraMenu')[0];
        const rect = row.getBoundingClientRect();

        // account for scroll position
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const scrollLeft = window.scrollX || document.documentElement.scrollLeft;

        menu.style.display = 'block';
        menu.style.position = 'absolute';
        menu.style.top = (rect.bottom + scrollTop - 275) + 'px'; // 👈 tight under row
        menu.style.left = (rect.left + scrollLeft) + 'px';
        menu.style.zIndex = 1050;
    }

    // Hide when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('#extraMenu, tr').length) {
            $('#extraMenu').hide();
        }
    });

    function openDeleteExtraModal() {
        $('#extraMenu').hide();
        $('#deleteFinExtra').modal('show');
    }

    function openFinanceModal(type) {
        if (type === 'charge') {
            // Open Add Charge modal
            var chargeModal = new bootstrap.Modal(document.getElementById('addFinanceOption'));
            chargeModal.show();
        } else if (type === 'discount') {
            // Open Add Discount modal
            var discountModal = new bootstrap.Modal(document.getElementById('addDiscount'));
            discountModal.show();

            // Initialize select2 if needed
            if ($.fn.select2) {
                $('#inputDiscountedItems, #inputDiscountCategory').select2();
            }
        }
    }

    function setStudentType() {
        var st_type = $('#inputStudentType').val();
        var admission_id = $('#admission_id').val();
        var user_id = '<?php echo $user_id ?>';
        var school_year = $('#currentYear').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/setStudentType' ?>',
            //dataType: 'json',
            data: {
                school_year: school_year,
                st_type: st_type,
                admission_id: admission_id,
                user_id: user_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                location.reload();
            }

        });

    }


    function rollOver(st_id, level_id) {
        $('#cashRegisterRO').modal('show');
        selectSection(level_id);

    }

    function searchTransferAccount(value) {
        var school_year = $('#transferSchoolYear').val()
        var url = '<?php echo base_url() . 'search/searchAccForFundTransfer/' ?>' + value + '/' + school_year;

        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                console.log(data);
                $('#searchTransferName').removeClass('d-none');
                $('#searchTransferName').html(data);
            }
        });

        return false;
    }


    function selectSection(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {

                $('#inputSection').html(data);
            }
        });

        return false;
    }


    function addToItems() {

        var itemAmount = $("#edit_fin_amount").val();
        Amount = parseFloat(Amount) + parseFloat(itemAmount);
        $('#itemBody').append('<tr tr_val="' + itemId + '_' + itemAmount + '" id="' + itemId + '"><td>' + itemDescID + '</td><td>' + itemAmount + '</td><td><button onclick="$(\'#' + itemId + '\').hide(), deductAmount(' + itemAmount + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td></tr>');
        $('#pttAmount').val(Amount)

        $("#edit_fin_amount").val('');
    }

    function deductAmount(itemAmount) {
        Amount = parseFloat(Amount) - parseFloat(itemAmount);
        $('#pttAmount').val(Amount)
    }

    function cash_change() {
        let total = parseFloat($('#pttAmount').val().replace(/,/g, '')) || 0;
        let tendered = parseFloat($('#ptAmountTendered').val().replace(/,/g, '')) || 0;

        let change = tendered - total;

        $('#ptChange').val(
            change >= 0 ? numberWithCommas(change.toFixed(2)) : '0.00'
        );
    }

    function deleteFinanceExtraCharge() {
        var trans_id = $('#delete_trans_id').val();
        var st_id = '<?php echo $user_id ?>';
        var sem = 0;
        var sy = $('#inputSchoolYear').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/deleteFinanceExtraCharge' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                sem: sem,
                school_year: sy,
                trans_id: trans_id,
                delete_remarks: $('#trExtra_' + trans_id).attr('delete_remarks'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                location.reload();
            }

        });
    }

    function deleteFinanceTransaction() {
        var trans_id = $('#delete_trans_id').val();
        var trans_type = $('#delete_trans_type').val();
        var st_id = $('#st_id').val();
        var sem = '<?php echo $student->semester ?>';
        var sy = $('#inputSchoolYear').val();
        var item_id = $('#delete_item_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/deleteTransaction' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                sem: sem,
                school_year: sy,
                trans_id: trans_id,
                trans_type: trans_type,
                item_id: item_id,
                delete_remarks: $('#td_trans_' + trans_id).attr('delete_remarks'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                showTopAlert(response, 'success', 'reload');
            }

        });
    }


    function saveTransaction() {
        var or_num = $('#refNumber').val();
        var st_id = '<?= $student->st_id ?>';
        var sem = '<?php echo $semester ?>';
        var sy = $('#inputSchoolYear').val();
        var transDate = $('#transactionDate').val();
        var transType = $('#inputTrType').val();

        if (transType == 1) {
            var chequeNumber = $('#inputCheque').val();
            var bank = $('#chequeBank').val();
        } else {
            chequeNumber = 0;
            bank = 0;
        }

        var data = [];
        $('#itemBody tr').each(function() {
            if ($(this).attr('tr_val') != "") {
                data.push($(this).attr('tr_val'));
            }
        });

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveTransaction' ?>',
            //dataType: 'json',
            data: {
                items: JSON.stringify(data),
                or_num: or_num,
                st_id: st_id,
                sem: sem,
                school_year: sy,
                transDate: transDate,
                transType: transType,
                chequeNumber: chequeNumber,
                bank: bank,
                receipt: $('#inputReceipt').val(),
                t_remarks: $('#transRemark').val(),
                csrf_test_name: $.cookie('csrf_cookie_name'),
                isEnrolled: ($('#printRegForm').is(':checked') ? 0 : 1),
                admission_id: '<?php echo $student->admission_id ?>'
            },
            success: function(response) {
                //alert(response);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'finance/updateOR/' ?>' + or_num,
                    //dataType: 'json',
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function(response) {
                        showTopAlert('Payment Successfuly Posted!', 'success', 'reload');
                    }

                });

                <?php if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_registration_form.php')): ?>
                    if ($('#printRegForm').is(':checked')) {
                        var url = "<?php echo base_url('reports/printRegistrationForm/') . base64_encode($student->st_id) ?>/" + sy;
                        window.open(url, '_blank');
                    }
                <?php endif; ?>

                <?php if ($finSettings->print_receipts): ?>
                    if ($('#printOR').is(':checked')) {
                        var printUrl = '<?php echo base_url('finance/printOR/' . base64_encode($student->st_id) . '/') ?>' + or_num + '/' + (transType == 0 ? 'Cash' : 'Cheque') + '/' + $('#ptAmountTendered').val() + '/' + sy;
                        window.open(printUrl, '_blank');
                        $('#printURL').val(printUrl);
                        $('#confirmCloseCashRegistrar').modal('show')
                    }
                <?php endif; ?>

                // location.reload();


            }

        });
    }


    function saveRefundTransaction() {
        var trans_id = $('#refund_trans_id').val();
        var item_id = $('#refundFinItems').val();
        var ref_number = $('#refundRefNumber').val();
        var editTransDate = $('#refundTransactionDate').val();
        var transAmount = $('#refundTransAmount').val();
        var origAmount = $('#refundOrigAmount').val();
        var receipt = $('#refundEditReceipt').val();
        var sy = $('#inputSchoolYear').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveRefundTransaction' ?>',
            //dataType: 'json',
            data: {
                origAmount: origAmount,
                school_year: sy,
                item_id: item_id,
                trans_id: trans_id,
                ref_number: ref_number,
                trans_date: editTransDate,
                amount: transAmount,
                receipt: receipt,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                location.reload();
            }

        });
    }

    let lastEditedTransactionId = null;

    function saveEditTransaction() {
        const id = $('#edit_trans_id').val();
        lastEditedTransactionId = id; // ✅ store globally

        var trans_id = $('#edit_trans_id').val();
        var item_id = $('#editFinItems').val();
        var ref_number = $('#editRefNumber').val();
        var editTransDate = $('#editTransactionDate').val();
        var transAmount = $('#editTransAmount').val();
        var receipt = $('#inputEditReceipt').val();
        var remarks = $('#editRemarks').val();
        var sy = $('#inputSchoolYear').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveEditTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year: sy,
                item_id: item_id,
                trans_id: trans_id,
                ref_number: ref_number,
                trans_date: editTransDate,
                amount: transAmount,
                receipt: receipt,
                remarks: remarks,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                // showTopAlert(response, 'success', 'reload');
                // close modal
                $('#editFinTransaction').modal('hide');

                // ✅ SINGLE reload + highlight AFTER render
                $('#AccountBody').load(location.href + ' #AccountBody>*', function() {

                    $('#transaction-' + id).addClass('highlight-row');
                    // highlightRow(lastEditedTransactionId);
                    // lastEditedTransactionId = null;

                });
            }

        });
    }

    $(document).ready(function() {

        shortcut.add("Ctrl+1", function() {
            location.reload();
        });
        shortcut.add("PageDown", function() {
            $('#confirmPayment').modal('show')
        });
        shortcut.add("Insert", function() {
            window.setTimeout(function() {
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });

        $('#inputStudentType').select2();

    });

    function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function() {
                    return (false);
                };
                window.onhelp = function() {
                    return (false);
                };
            }
            evt.returnValue = false;
            evt.keyCode = 0;
            window.status = msg;
            evt.preventDefault();
            evt.stopPropagation();
            //alert(msg);
        }

        window.status = "Done";

    }


    if (window.document.addEventListener) {
        window.document.addEventListener("keydown", avoidInvalidKeyStorkes, false);
    } else {
        window.document.attachEvent("onkeydown", avoidInvalidKeyStorkes);
        document.captureEvents(Event.KEYDOWN);
    }

    $('#reprintUrl').click(function() {
        window.open($('#printURL').val(), '_blank');
    })

    function saveAccount(user_id) {
        var account = $('#account').val();
        var url = '<?php echo base_url() . 'finance/updateAccount' ?>';

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "user_id=" + user_id + '&account=' + account + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload();
            }
        });

        return false;
    }

    function calculateItem(item_id) {
        itemId = item_id;
        var totalUnits = $('#totalUnits').val();
        var plan_id = $('#finPlan_id').val();
        var sem = $('#currentSemester').val();
        var sy = $('#inputSchoolYear').val();
        var st_id = $('#st_id').val();
        var url = '<?php echo base_url() . 'finance/calculateItem' ?>';

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "item_id=" + item_id + '&plan_id=' + plan_id + '&sem=' + sem + '&school_year=' + sy + '&st_id=' + st_id + '&totalUnits=' + totalUnits + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#edit_fin_amount').attr('placeholder', data.totalPayment);
                itemDescID = $('#' + item_id + '_desc').html();
            }
        });

        return false;
    }


    function applyDiscount() {
        var sem = $('#inputDiscountedSem').val();
        var school_year = $('#inputDiscountedCSY').val()
        var discountType = $('#inputDiscountedType').val();
        var finItem = $('#inputDiscountedItems').val();
        var finAmount = $('#discount_amount').val();
        var st_id = '<?= $student->st_id ?>';
        var remarks = $('#inputDiscountedRemarks').val();
        var finYear = $('#year_level').val();
        var admission_id = $('#admission_id').val();
        var plan_id = '<?= $plan->fin_plan_id ?>';
        var discountCategory = $('#inputDiscountCategory').val();
        alert(finItem + ' ' + plan_id)

        var url = "<?php echo base_url() . 'finance/applyDiscounts' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: {
                finItem: finItem,
                st_id: st_id,
                plan_id: plan_id,
                remarks: remarks,
                admission_id: admission_id,
                discount_type: discountType,
                discountCategory: discountCategory,
                year_level: finYear,
                semester: sem,
                finAmount: finAmount,
                school_year: school_year,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                //alert(data)
                alert('Discount Successfully Added');
                location.reload();

            }
        });

        return false;
    }

    function addExtraFinanceCharges() {

        if ($('#inputFinItems').val() == '' || $('#fin_amount').val() == '') {
            alert('Please complete all required fields.');
            return;
        }

        var school_year = $('#inputCSY').val()
        var finItem = $('#inputFinItems').val();
        var finAmount = $('#fin_amount').val();
        var st_id = '<?= $student->st_id ?>';
        var user_id = '<?php echo $user_id ?>';
        var admission_id = $('#admission_id').val();
        var finYear = $('#year_level').val();
        var plan_id = $('#finPlan_id').val();
        var semester = $('#extraSem').val();

        var url = "<?php echo base_url() . 'finance/addExtraFinanceCharges' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "finItem=" + finItem + "&st_id=" + st_id + "&user_id=" + user_id + "&plan_id=" + plan_id + "&admission_id=" + admission_id + "&year_level=" + finYear + "&semester=" + semester + "&finAmount=" + finAmount + "&school_year=" + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload();

            }
        });

        return false;
    }


    function prepareFundTransfer(trans_id) {
        var school_year = $('#inputSchoolYear').val();
        // var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();
        var st_id = $('#st_id').val();
        var name = '<?php echo strtoupper($student->firstname . " " . $student->lastname) ?>';

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/finance_pisd/prepareFundTransfer' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                name: name,
                school_year: school_year,
                trans_id: trans_id,
                item_id: item_id,
                trans_type: trans_type,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                $('#fundTransferBody').html(response);
            }

        });
    }

    function loadRefundTransaction() {
        var school_year = $('#inputSchoolYear').val();
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/loadRefundTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year: school_year,
                trans_id: trans_id,
                item_id: item_id,
                trans_type: trans_type,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                $('#refundTransBody').html(response);

            }

        });
    }

    function loadFinanceTransaction() {
        var school_year = $('#inputSchoolYear').val();
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/loadFinanceTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year: school_year,
                trans_id: trans_id,
                item_id: item_id,
                trans_type: trans_type,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                $('#editTransBody').html(response);
                // $('#editTransactionDate').datepicker();
            },
            error: function() {
                alert('error')
            }

        });
    }

    function setExtraFinanceCharges(course_id, year_level) {
        $('#addFinanceOption').modal('show');
        $('#course_id').val(course_id);
        $('#year_level').val(year_level);
    }

    function number2string(sNumber) {
        //Seperates the components of the number
        var n = sNumber.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    }

    function string2number(svariable) {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }

    function _(el) {
        return document.getElementById(el);
    }

    _("progressBarWrapper").style.display = 'none';

    function uploadFile() {
        var isEnrollment = ($('#isEnrollment').is(':checked') ? 1 : 0);

        var file = document.getElementById("userfile").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('st_id', '<?php echo base64_encode($student->st_id) ?>');
        formdata.append('payment_remarks', $('#paymentRemarks').val());
        formdata.append('is_enrollment', isEnrollment);
        formdata.append('school_year', $('#currentYear').val());
        formdata.append('semester', 0);
        formdata.append('paymentCenter', '');
        formdata.append('is_or', 1);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo base_url() . 'opl/p/uploadPaymentReceipt/' ?>");
        ajax.send(formdata);
    }

    function progressHandler(event) {

        $('#progressBarWrapper').show();

    }

    function completeHandler(event) {
        // _("status").innerHTML = event.target.responseText;
        $("#progressBarWrapper").hide();
        alert(event.target.responseText);
        location.reload();
    }

    function errorHandler(event) {
        // _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event) {
        //  _("status").innerHTML = "Upload Aborted";
    }

    function delReceipt(id, link) {
        if (confirm('Are you sure you want to delete this receipt?')) {
            var url = '<?php echo base_url() . 'finance/deleteReceipt/' ?>' + id + '/' + link;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        } else {
            alert('Operation Canceled');
        }
    }

    // 🔽 Collapse icon toggle
    const collapseEl = document.getElementById('paymentHistoryCollapse');
    const icon = document.getElementById('collapseIcon');

    collapseEl.addEventListener('show.bs.collapse', () => icon.innerHTML = '▲');
    collapseEl.addEventListener('hide.bs.collapse', () => icon.innerHTML = '▼');

    // 🔍 Search filter
    document.getElementById('paymentSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#paymentTable tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

    let activeTransactionId = null;

    function setActiveTransaction(id) {
        activeTransactionId = id;
    }

    // 🔹 ACTION HANDLERS
    function openEditTransaction() {
        $('#editFinTransaction').modal('show');
        loadFinanceTransaction(activeTransactionId);
    }

    function openDeleteTransaction() {
        $('#deleteFinTransaction').modal('show');
        $('#delete_trans_id').val(activeTransactionId);
    }

    function openTransfer() {
        $('#transferFinTransaction').modal('show');
        prepareFundTransfer(activeTransactionId);
    }

    function openRefund() {
        $('#refundTransaction').modal('show');
        loadRefundTransaction(activeTransactionId);
    }

    document.getElementById('editTransAmount').addEventListener('input', function(e) {
        let value = this.value.replace(/,/g, '');
        if (!isNaN(value) && value !== '') {
            this.value = parseFloat(value).toLocaleString('en-PH');
        }
    });

    function highlightRow(id) {

        let row = $('#transaction-' + id);
        console.log(row);

        if (!row.length) {
            console.warn('Row not found:', id);
            return;
        }

        // add highlight
        row.addClass('highlight-row');

        // remove after 3 seconds
        // setTimeout(() => {
        //     row.removeClass('highlight-row');
        // }, 3000);
    }
</script>