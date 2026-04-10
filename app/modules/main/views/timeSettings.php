<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-timepicker.min.css'); ?>" />
<style>
    .time-card {
        position: relative;
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    .time-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .time-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }

    .time-icon {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .edit-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 1rem;
        color: #0d6efd;
        cursor: pointer;
    }

    /* Chevron animation */
    .chevron {
        transition: transform 0.3s ease;
    }

    .collapse-header[aria-expanded="true"] .chevron {
        transform: rotate(180deg);
    }

    .collapse-header {
        cursor: pointer;
        user-select: none;
    }
</style>

<div class="container-fluid py-4">
    <div class="row g-4">

        <!-- Employees -->
        <div class="col-lg-6 col-12">
            <?php $employeeTimeSettings = Modules::run('hr/payroll/getRawTimeShifting'); ?>
            <h5 class="mb-3 text-primary">Employees Time Settings</h5>

            <div class="accordion" id="employeeAccordion">

                <?php
                $departments = [];
                foreach ($employeeTimeSettings as $setTime) {
                    $departments[$setTime->ps_department][] = $setTime;
                }
                ?>

                <?php $i = 0;
                foreach ($departments as $dept => $times): $i++; ?>
                    <div class="accordion-item border-0 mb-2 shadow-sm">

                        <!-- HEADER (FIXED) -->
                        <h2 class="accordion-header" id="heading-<?php echo $i; ?>">
                            <button class="accordion-button <?php echo $i != 1 ? 'collapsed' : ''; ?> fw-semibold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-<?php echo $i; ?>"
                                aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>">

                                <?php echo $dept; ?>
                            </button>
                        </h2>

                        <!-- BODY -->
                        <div id="collapse-<?php echo $i; ?>"
                            class="accordion-collapse collapse <?php echo $i == 1 ? 'show' : ''; ?>"
                            data-bs-parent="#employeeAccordion">

                            <div class="accordion-body p-2">

                                <?php foreach ($times as $setTime): ?>
                                    <div class="card border-0 shadow-sm mb-2 position-relative">

                                        <!-- EDIT ICON -->
                                        <i class="fa fa-pencil-square-o position-absolute top-0 end-0 m-2 text-primary edit-btn"
                                            style="cursor:pointer;"
                                            data-id="<?php echo $setTime->ps_id ?>"
                                            data-type="employee">
                                        </i>

                                        <div class="card-body py-2">
                                            <div class="time-item">
                                                <i class="fa fa-sun time-icon"></i>
                                                <span id="<?php echo $setTime->ps_id ?>_ami">
                                                    <?php echo $setTime->ps_from; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-cloud-sun time-icon"></i>
                                                <span id="<?php echo $setTime->ps_id ?>_amo">
                                                    <?php echo $setTime->ps_to; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-moon time-icon"></i>
                                                <span id="<?php echo $setTime->ps_id ?>_pmi">
                                                    <?php echo $setTime->ps_from_pm; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-cloud-moon time-icon"></i>
                                                <span id="<?php echo $setTime->ps_id ?>_pmo">
                                                    <?php echo $setTime->ps_to_pm; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- Students -->
        <div class="col-lg-6 col-12">
            <?php $timeSet = Modules::run('main/getTimeSettingsPerSection'); ?>
            <h5 class="mb-3 text-success">Students Time Settings</h5>

            <div class="accordion" id="studentAccordion">
                <?php
                $grades = [];
                foreach ($timeSet as $setTime) {
                    $grades[$setTime->level . '-' . $setTime->section][] = $setTime;
                }
                ?>

                <?php $i = 0;
                foreach ($grades as $grade => $times): $i++; ?>
                    <div class="accordion-item border-0 mb-2">
                        <div class="fw-bold p-2 bg-light rounded collapse-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse"
                            data-bs-target="#grade-<?php echo $i; ?>"
                            aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>">

                            <?php echo $grade; ?>
                            <i class="fa fa-chevron-down chevron"></i>
                        </div>

                        <div id="grade-<?php echo $i; ?>"
                            class="accordion-collapse collapse <?php echo $i == 1 ? 'show' : ''; ?>"
                            data-bs-parent="#studentAccordion">

                            <div class="accordion-body p-2">
                                <?php foreach ($times as $setTime): ?>
                                    <div class="card shadow-sm border-0 time-card">
                                        <i class="fa fa-pencil-square-o edit-icon edit-btn"
                                            data-id="<?php echo $setTime->section_id ?>"
                                            data-type="student">
                                        </i>

                                        <div class="card-body">
                                            <div class="time-item">
                                                <i class="fa fa-sun time-icon"></i>
                                                <span id="<?php echo $setTime->section_id ?>_ami">
                                                    <?php echo $setTime->time_in; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-cloud-sun time-icon"></i>
                                                <span id="<?php echo $setTime->section_id ?>_amo">
                                                    <?php echo $setTime->time_out; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-moon time-icon"></i>
                                                <span id="<?php echo $setTime->section_id ?>_pmi">
                                                    <?php echo $setTime->time_in_pm; ?>
                                                </span>
                                            </div>

                                            <div class="time-item">
                                                <i class="fa fa-cloud-moon time-icon"></i>
                                                <span id="<?php echo $setTime->section_id ?>_pmo">
                                                    <?php echo $setTime->time_out_pm; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        // REMOVE old clickover
        $(".clickover").remove();

        // Handle edit click
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            let type = $(this).data('type');

            $('#editTimeModal').modal('show');

            // Show loading
            $('#editTimeContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border"></div>
            </div>
        `);

            // AJAX load (CHANGE URL BASED ON YOUR CONTROLLER)
            $.ajax({
                url: "<?= base_url('main/loadTimeSettings') ?>",
                method: "POST",
                data: {
                    id: id,
                    type: type,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(response) {
                    $('#editTimeContent').html(response);
                },
                error: function() {
                    $('#editTimeContent').html('<div class="text-danger">Failed to load.</div>');
                }
            });
        });

        // Tooltips (optional)
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el))

    });
</script>