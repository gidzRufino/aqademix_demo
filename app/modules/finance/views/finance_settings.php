<style>
    /* Header polish */
    .card-header.bg-warning {
        background: linear-gradient(135deg, #ffc107, #ffda6a);
    }

    /* Smooth card hover */
    .card.shadow-sm {
        transition: all 0.2s ease;
    }

    .card.shadow-sm:hover {
        transform: none;
    }

    /* Buttons */
    .btn i {
        font-size: 0.85rem;
    }

    /* Responsive spacing */
    @media (max-width: 768px) {
        .btn {
            font-size: 0.85rem;
            padding: 6px 10px;
        }
    }

    /* Badge style */
    .badge {
        font-weight: 500;
        border-radius: 8px;
    }

    .card,
    .card-body,
    .row,
    .col-12,
    .col-md-6 {
        overflow: visible !important;
    }

    .blur-overlay {
        position: fixed;
        inset: 0;

        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);

        background: rgba(0, 0, 0, 0.25);

        z-index: 1040;

        pointer-events: auto;
        /* ✅ FIX: prevents interference */
    }

    .blur-overlay.active {
        pointer-events: auto;
    }
</style>

<div class="container-fluid py-4">

    <!-- 🔷 HEADER -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center">

            <!-- Title -->
            <div>
                <h4 class="fw-bold mb-1">Finance Settings</h4>
                <small class="text-muted">Manage schedules, fees, and financial plans</small>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2 mt-3 mt-lg-0">

                <button class="btn btn-light border"
                    onclick="document.location='<?php echo ($this->eskwela->getSet()->level_catered == '0' ? base_url('college') : base_url()) ?>'">
                    <i class="fa fa-home me-1"></i> Dashboard
                </button>

                <button class="btn btn-success"
                    onclick="document.location='<?php echo base_url('finance/collection') ?>'">
                    <i class="fa fa-print me-1"></i> Print SOA
                </button>

                <button class="btn btn-light border"
                    onclick="document.location='<?php echo base_url('finance/accounts') ?>'">
                    <i class="fa fa-users me-1"></i> Accounts
                </button>

                <button class="btn btn-light border"
                    onclick="document.location='<?php echo base_url('college/finance/generalSettings') ?>/'+$('#inputCSY').val()">
                    <i class="fa fa-cog me-1"></i> Settings
                </button>

                <!-- School Year -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <i class="fa fa-calendar me-1"></i>
                        SY <?php echo $now . ' - ' . ($nextYear) ?>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <?php foreach ($ro_years = Modules::run('registrar/getROYear') as $ro):
                            $roYears = $ro->ro_years + 1; ?>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo base_url('finance/settings/' . $ro->ro_years) ?>">
                                    SY <?php echo $ro->ro_years . ' - ' . $roYears ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <!-- 🔶 MAIN CONTENT -->
    <div class="card border-0 shadow-sm">

        <!-- Section Header -->
        <div class="card-header bg-gradient bg-warning bg-opacity-75 text-dark d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-semibold">Schedule of Fees</h5>
                <small class="text-dark">Organize fee structures by grade level</small>
            </div>

            <button class="btn btn-danger btn-sm"
                onclick="$('#addPlanToSchedule').modal('show')">
                <i class="fa fa-plus me-1"></i> Add Schedule
            </button>
        </div>


        <!-- Content -->
        <div class="card-body" id="financeCharges">

            <?php foreach ($gradeLevel as $g):
                $plans = Modules::run('finance/getPlanByLevel', $g->grade_id); ?>

                <!-- 🔹 Grade Level Card -->
                <div class="card border-0 shadow-sm mb-4">

                    <!-- Grade Header -->
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">
                            <?php echo $g->level ?>
                        </h6>

                        <span class="badge bg-primary-subtle text-primary">
                            <?php echo $plans->num_rows(); ?> Plans
                        </span>
                    </div>

                    <!-- Plans Grid -->
                    <div class="card-body">
                        <div class="row g-3">

                            <?php if ($plans->num_rows() > 0):
                                foreach ($plans->result() as $p): ?>

                                    <div class="col-12 col-md-6"
                                        id="finance_<?php echo $p->fin_plan_id; ?>">

                                        <?php echo Modules::run(
                                            'finance/financeChargesByPlanView',
                                            $g->grade_id,
                                            0,
                                            $now,
                                            0,
                                            $g->level,
                                            $p->fin_plan_id,
                                            $p->plan_title
                                        ); ?>

                                    </div>

                                <?php endforeach;
                            else: ?>

                                <!-- Empty State -->
                                <div class="col-12 text-center py-4 text-muted">
                                    No plans available for this level.
                                </div>

                            <?php endif; ?>

                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>
    </div>
</div>

<div id="blurOverlay" class="blur-overlay d-none"></div>

<!-- Hidden Inputs -->
<input type="hidden" id="school_year" value="<?php echo $now ?>" />
<input type="hidden" id="grade_level" />
<input type="hidden" id="level" />
<input type="hidden" id="plan_title" />

<!-- Include Bootstrap 5 JS if not already included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php //$this->load->view('financeModals'); 
?>

<script type="text/javascript">
    function editFinItem(desc, amount, charge_id) {
        // alert('hey')
        $('#editFinItem').modal('show');
        $('#fin_desc').html(desc);
        $('#edit_fin_amount').val(amount);
        $('#charge_id').val(charge_id);
    }

    function deleteFinanceCharges() {
        var charge_id = $('#del_charge_id').val();
        var school_year = $('#school_year').val();

        var url = "<?php echo base_url() . 'finance/deleteFinanceCharges' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "charge_id=" + charge_id + '&school_year=' + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data)
                $('#tr_' + charge_id).hide();
                $('#deleteFinCharges').modal('hide');
            }
        });

        return false;
    }

    function editFinanceCharges() {
        var school_year = $('#school_year').val();
        var charge_id = $('#charge_id').val();
        var fin_amount = $('#edit_fin_amount').val();

        var url = "<?php echo base_url() . 'finance/editFinanceCharges' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                school_year: '<?php echo $now ?>',
                charge_id: charge_id,
                fin_amount: fin_amount,
                log: $('#tr_' + charge_id).attr('log_remarks') + ' ' + numberWithCommas(fin_amount) + ' ]',
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                if (data.status) {
                    showTopAlert(data.msg, 'success', 'reload');
                    let pesoFormatter = new Intl.NumberFormat('en-PH', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $('#td_' + charge_id).html(pesoFormatter.format(data.amount));
                    $('#editFinItem').modal('hide');
                } else {
                    alert(data.msg)
                    $('#editFinItem').modal('hide');
                }
            }
        });

        return false;
    }

    function financeWrapper(course_id) {
        var sem = $('#inputSem').val();

        var url = "<?php echo base_url() . 'finance/getFinanceChargesWrapper' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + course_id + '&sem=' + sem + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#financeCharges').html(data);
            }
        });

        return false;
    }

    function setFinanceCharges(grade_level, plan_id, level, plan_title) {
        $('#addFinanceOption').modal('show');
        $('#grade_level').val(grade_level);
        $('#plan_id').val(plan_id);
        $('#level').val(level);
        $('#plan_title').val(plan_title);
    }

    function addFinanceCharges() {
        var sem = $('#inputSem').val();
        var school_year = $('#inputCSY').val()
        var finItem = $('#inputFinItems').val();
        var finAmount = $('#fin_amount').val();
        var gradeLevel = $('#grade_level').val();
        var plan_id = $('#plan_id').val();
        var proceed = 1;

        if (finItem == 0) {
            $('#errMsg').html('Please Select Finance Item')
            $('#fgMsg').show().delay(3000).queue(function(n) {
                $('#fgMsg').hide();
                n();
            });
            proceed = 0;
        } else if (finAmount == '') {
            $('#errMsg').html('Please Enter Amount')
            $('#fgMsg').show().delay(3000).queue(function(n) {
                $('#fgMsg').hide();
                n();
            });
            proceed = 0;
        }

        if (proceed == 1) {
            var url = "<?php echo base_url() . 'finance/addFinanceCharges' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: "finItem=" + finItem + "&gradeLevel=" + gradeLevel + "&plan_id=" + plan_id + "&semester=" + sem + "&finAmount=" + finAmount + "&school_year=" + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    if (!data.status) {
                        $('#errMsg').html(data.msg)
                        $('#fgMsg').show().delay(3000).queue(function(n) {
                            $('#fgMsg').hide();
                            n();
                        });
                    } else {
                        showTopAlert(data.msg, 'success', 'reload');
                        // $('#addFinanceOption').modal('hide');
                        // $.ajax({
                        //     type: 'GET',
                        // url: '<?php //echo base_url('finance/financeChargesByPlanView/') 
                                    ?>' + gradeLevel + '/0/' + school_year + '/0/' + $('#level').val() + '/' + plan_id + '/' + $('#plan_title').val(),
                        //     success: function (data2) {
                        //         $('#finance_'+plan_id).html(data2)
                        //         // $('#addFinanceOption').modal('hide');
                        //     }
                        // })

                    }
                },
                error: function() {
                    alert('Err')
                }
            });

            return false;
        }
    }


    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>