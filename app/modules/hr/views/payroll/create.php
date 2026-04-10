<style>
    .summary-card {
        border: none;
        border-radius: 16px;
        transition: all 0.25s ease;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .summary-card.primary::before {
        background: linear-gradient(90deg, #0d6efd, #4dabf7);
    }

    .summary-card.warning::before {
        background: linear-gradient(90deg, #ffc107, #ffda6a);
    }

    .summary-card.danger::before {
        background: linear-gradient(90deg, #dc3545, #ff6b81);
    }

    .summary-card.success::before {
        background: linear-gradient(90deg, #198754, #51cf66);
    }

    .summary-card.info::before {
        background: linear-gradient(90deg, #0dcaf0, #66d9ff);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .icon-wrapper {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 20px;
    }

    .bg-soft-primary {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .bg-soft-warning {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .bg-soft-danger {
        background: rgba(220, 53, 69, 0.12);
        color: #dc3545;
    }

    .bg-soft-success {
        background: rgba(25, 135, 84, 0.12);
        color: #198754;
    }

    .bg-soft-info {
        background: rgba(13, 202, 240, 0.12);
        color: #0dcaf0;
    }

    .summary-label {
        font-size: 13px;
        color: #6c757d;
        letter-spacing: .5px;
    }

    .summary-value {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    @media (max-width: 576px) {
        .summary-value {
            font-size: 18px;
        }
    }
</style>

<div class="container-fluid py-3">

    <!-- HEADER TOOLBAR -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h3 class="mb-0 fw-bold">Payroll System</h3>
                <small class="text-muted">Generate payroll, manage periods, and review employee compensation</small>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#createPay">
                    <i class="fa fa-calendar-plus me-1"></i> Set Payroll Period
                </button>

                <button class="btn btn-outline-secondary"
                    onclick="document.location='<?php echo base_url('hr/payroll/settings') ?>'">
                    <i class="fa fa-cog me-1"></i> Settings
                </button>

                <button class="btn btn-outline-dark" onclick="printPayroll()">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </div>

        <!-- PAYROLL SUMMARY CARDS -->
        <div class="row g-4 px-3 py-2">

            <!-- Gross Pay -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl">
                <div class="card summary-card primary shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-soft-primary">
                            <i class="fa fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <div class="summary-label">Total Gross Pay</div>
                            <p class="summary-value" id="summaryGross">₱0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Income -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl">
                <div class="card summary-card warning shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-soft-warning">
                            <i class="fa fa-plus-circle"></i>
                        </div>
                        <div>
                            <div class="summary-label">Total Additional Income</div>
                            <p class="summary-value" id="summaryAdditionalIncome">₱0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deductions -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl">
                <div class="card summary-card danger shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-soft-danger">
                            <i class="fa fa-minus-circle"></i>
                        </div>
                        <div>
                            <div class="summary-label">Total Deductions</div>
                            <p class="summary-value" id="summaryDeduction">₱0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Net Pay -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl">
                <div class="card summary-card success shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-soft-success">
                            <i class="fa fa-wallet"></i>
                        </div>
                        <div>
                            <div class="summary-label">Total Net Pay</div>
                            <p class="summary-value" id="summaryNet">₱0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employees -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl">
                <div class="card summary-card info shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-soft-info">
                            <i class="fa fa-users"></i>
                        </div>
                        <div>
                            <div class="summary-label">Total Employees</div>
                            <p class="summary-value" id="summaryEmployees">0</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FILTER / PERIOD SELECTION -->
        <div class="row g-3 align-items-end mb-4 ms-4">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <label class="form-label fw-semibold">Payroll Period</label>
                <select onchange="generatePayroll(this.value)" id="payPeriod" name="payPeriod"
                    class="form-select shadow-sm">
                    <option>Select Payroll Period</option>
                    <?php foreach ($payrollPeriod as $pp): ?>
                        <option id="option_<?php echo $pp->per_id ?>"
                            from="<?php echo $pp->per_from ?>"
                            to="<?php echo $pp->per_to ?>"
                            value="<?php echo $pp->per_id ?>"
                            <?php echo ($pc_code == $pp->per_id) ? 'selected' : ''; ?> <?= $this->uri->segment(4) == $pp->per_id ? 'selected' : '' ?>>
                            <?php echo date('F d, Y', strtotime($pp->per_from)) . ' - ' . date('F d, Y', strtotime($pp->per_to)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <span id="notificationAlert" class="alert alert-success py-2 px-3 small d-none"></span>
            </div>
        </div>

        <!-- PAYROLL REPORT -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-0 fw-semibold">Consolidated Payroll Report</h5>
                    <small class="text-muted">Overview of employee payroll within selected period</small>
                </div>

                <div class="text-muted small">
                    <i class="fa fa-info-circle me-1"></i>
                    Select a payroll period to generate report
                </div>
            </div>

            <div class="card-body" id="consolidatedPayroll">
                <?php if ($pc_code != NULL):
                    echo Modules::run('hr/payroll/generatePayrollReport', $pc_code, $startDate, $endDate);
                endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- OT Requests Modal -->
<div id="otRequest" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-primary">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Overtime Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name of Employee</th>
                            <th class="text-center">Date</th>
                            <th class="text-center"># of Hours OT</th>
                            <th class="text-center">Details</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($pc_code != NULL):
                            $ot = Modules::run('hr/payroll/getOverTimeReq', $startDate, $endDate);
                            foreach ($ot as $o): ?>
                                <tr>
                                    <td><?php echo $o[0]; ?></td>
                                    <td class="text-center"><?php echo $o[2]; ?></td>
                                    <td class="text-center"><?php echo Modules::run('hr/convertToHoursMins', $o[3]); ?></td>
                                    <td><?php echo $o[4]; ?></td>
                                    <td><?php echo $o[5]; ?></td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="att_id" />
<input type="hidden" id="rowCol_id" />

<script type="text/javascript">
    $(document).ready(function() {
        $('#payPeriod').select2();
        $('#fromDate').datepicker({
            orientation: "left"
        });
        $('#toDate').datepicker({
            orientation: "left"
        });

        $('#item').click(function() {
            var item = $(this).val();
            var value = 0;
            var netPay = $('#totalNetIncome').val();

            switch (item) {
                case '2':
                    value = parseFloat(netPay) * parseFloat(.01375);
                    break;
                case '3':
                    value = parseFloat(netPay) * parseFloat(.02);
                    break
            }
            //  alert(netPay)
            $('#amount').val(value.toFixed(2));
        })
    });

    function printPayroll() {
        var pc_code = $('#payPeriod').val();
        var fromdate = $('#option_' + pc_code).attr('from');
        var todate = $('#option_' + pc_code).attr('to');
        var url = '<?php echo base_url('hr/payroll/printPayroll/') ?>' + fromdate + '/' + todate + '/' + pc_code;

        window.open(url, '_blank');
    }

    function editTimeData(att_id, rowCol_id) {

        $('#att_id').val(att_id);
        $('#rowCol_id').val(rowCol_id);
        $('#editDTR').modal('show')
        //alert(att_id);
    }

    function saveTimeData() {
        var pc_code = $('#payPeriod').val();
        var fromdate = $('#option_' + pc_code).attr('from');
        var todate = $('#option_' + pc_code).attr('to');
        var owners_id = $('#owners_id').val();
        var att_id = $('#att_id').val();
        var rowCol_id = $('#rowCol_id').val();

        var hour = $('#hr').val();
        var min = $('#min').val();

        var url = "<?php echo base_url() . 'hr/editHrTime/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: 'att_id=' + att_id + '&hour=' + hour + '&min=' + min + '&time_option=' + rowCol_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {

                $('#editDTR').modal('hide')
                getDateFrom(fromdate, todate, owners_id)
            }
        });
    }

    function animateValue(id, start, end, duration, isCurrency = true) {
        let obj = document.getElementById(id);
        let startTime = null;

        function animation(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const value = progress * (end - start) + start;

            if (isCurrency) {
                obj.innerHTML = "₱" + value.toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                obj.innerHTML = Math.floor(value).toLocaleString();
            }

            if (progress < 1) {
                requestAnimationFrame(animation);
            }
        }

        requestAnimationFrame(animation);
    }

    document.addEventListener("DOMContentLoaded", function() {

        animateValue("summaryGross", 0, <?php echo $totalGross; ?>, 1200, true);
        animateValue("summaryAdditionalIncome", 0, <?php echo $totalAdditional; ?>, 1200, true);
        animateValue("summaryDeduction", 0, <?php echo $totalDeduction; ?>, 1200, true);
        animateValue("summaryNet", 0, <?php echo $totalNet; ?>, 1200, true);
        animateValue("summaryEmployees", 0, <?php echo $totalEmployees; ?>, 1200, false);

    });
</script>