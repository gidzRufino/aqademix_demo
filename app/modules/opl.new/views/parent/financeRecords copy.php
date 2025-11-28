<?php
$children = explode(',', $child_links);
switch (count($children)):
    case 1:
        $width = '25%';
        $col = 'col-lg-12';
        break;
    case 2:
        $width = '50%';
        $col = 'col-lg-6';
        break;
    case 3:
        $width = '75%';
        $col = 'col-lg-4';
        break;
    default:
        $width = '100%';
        $col = 'col-lg-3';
        break;
endswitch;
print_r($child);
?>
<style>
    /* Highlight active panel */
    .active-panel {
        border: 2px solid #4e73df !important;
        box-shadow: 0 0 12px rgba(78, 115, 223, 0.6) !important;
        transition: all 0.3s ease-in-out;
    }

    /* Active panel body background */
    .active-panel .panel-body {
        background: linear-gradient(135deg, #f8faff 0%, #e6ecff 100%);
        animation: fadeIn 0.5s ease-in-out;
        border-radius: 0 0 6px 6px;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">
    <div class="panel-group" id="studentAccordion"><!-- accordion wrapper -->

        <?php foreach ($children as $ch):
            if ($ch != ''):
                $isEnrolled = Modules::run('registrar/isEnrolled', $ch, $this->session->school_year);
                $school_year = $isEnrolled ? $this->session->userdata('school_year') : $this->session->userdata('school_year') - 1;
                $childDepartment = Modules::run('registrar/getStudentDepartment', $ch, $school_year);

                if ($childDepartment == 'basic'):
                    $student = Modules::run('registrar/getSingleStudent', $ch, $school_year);
                    $collapseId = 'details-' . $student->st_id;
        ?>

                    <!-- Student Panel -->
                    <div class="panel panel-default" style="border-radius:8px; overflow:hidden; margin-bottom:20px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">

                        <!-- Header -->
                        <div class="panel-heading" style="background: linear-gradient(135deg,#4e73df 0%,#224abe 100%); color:#fff;">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?php echo ($student->avatar != "") ? base_url() . 'uploads/' . $student->avatar : base_url() . 'uploads/noImage.png'; ?>"
                                        class="img-circle" style="width:70px; height:70px; border:3px solid #fff; object-fit:cover;">
                                </div>
                                <div class="media-body" style="padding-left:10px;">
                                    <h4 class="media-heading" style="margin:0; font-weight:bold;">
                                        <?php echo strtoupper($student->firstname . " " . $student->lastname) ?>
                                    </h4>
                                    <small>
                                        <?php echo $student->level ?> - <?php echo $student->section ?> |
                                        ID: <?php echo $student->st_id ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Toggle Button -->
                        <div class="panel-footer text-right">
                            <button class="btn btn-xs btn-primary toggle-btn"
                                data-toggle="collapse"
                                data-target="#<?php echo $collapseId; ?>"
                                data-parent="#studentAccordion"
                                aria-expanded="false"
                                aria-controls="<?php echo $collapseId; ?>">
                                <i class="fa fa-chevron-down"></i> <span>View Details</span>
                            </button>
                        </div>

                        <!-- Collapsible Body -->
                        <div id="<?php echo $collapseId; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php
                                $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);

                                $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
                                $addCharge = Modules::run('college/finance/financeChargesByPlan', NULL, $student->school_year, $student->semester);

                                $financeAccount = Modules::run('finance/getFinanceAccount', $student->st_id);
                                $i = 1;
                                $total = 0;
                                $amount = 0;
                                foreach ($charges as $c):
                                    if (!$c->is_fused):
                                        $next = $c->school_year + 1;
                                        $total += $c->amount;
                                    else:
                                        $fusedCharges += $c->amount;
                                    endif;
                                endforeach;
                                $total += $fusedCharges;

                                $totalExtra = 0;
                                $extraCharges = Modules::run('finance/getExtraFinanceCharges', $user_id, $student->semester, $student->school_year);
                                if ($extraCharges->num_rows() > 0):
                                    foreach ($extraCharges->result() as $ec):
                                        $totalExtra += $ec->extra_amount;
                                    endforeach;
                                    $total = $total + $totalExtra;
                                endif;
                                ?>
                                <!-- Finance Summary -->
                                <h5><i class="fa fa-money text-success"></i> Finance Summary</h5>
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        <td><strong>Plan:</strong></td>
                                        <td><?php echo $plan->plan_title; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Charges:</strong></td>
                                        <td>₱<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Balance:</strong></td>
                                        <td class="text-danger">₱<?php echo number_format($balance, 2); ?></td>
                                    </tr>
                                </table>

                                <!-- Payment History -->
                                <h5><i class="fa fa-list text-info"></i> Payment History</h5>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>OR #</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);

                                        $paymentTotal = 0;
                                        $i = 1;
                                        if ($transaction->num_rows() > 0):
                                            $balance = 0;
                                            foreach ($transaction->result() as $tr):
                                                if ($tr->t_type != 3):
                                        ?>
                                                    <tr>
                                                        <td><?php echo date('M d, Y', strtotime($tr->t_date)); ?></td>
                                                        <td><?php echo $tr->ref_number; ?></td>
                                                        <td>₱<?php echo number_format($tr->t_amount, 2); ?></td>
                                                        <?php
                                                        $total = $total - $tr->t_amount;
                                                        if ($tr->t_type == 2):
                                                            $discounts = Modules::run('finance/getDiscountsById', $tr->disc_id);
                                                        else:

                                                        endif;
                                                        ?>
                                                    </tr>
                                            <?php
                                                endif;
                                            endforeach;
                                        else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No payments recorded</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.collapse -->
                    </div><!-- /.panel -->

        <?php endif;
            endif;
        endforeach; ?>

    </div><!-- /.panel-group -->
</div>

<!-- Accordion Script -->
<script>
    $('.toggle-btn').on('click', function() {
        var $btn = $(this);
        var $icon = $btn.find('i');
        var $text = $btn.find('span');
        var target = $($btn.data('target'));
        var $panel = $btn.closest('.panel');

        // If already open -> collapse it
        if (target.hasClass('in')) {
            target.collapse('hide');
            return;
        }

        // Otherwise, let Bootstrap handle collapse
        target.on('shown.bs.collapse', function() {
            // reset others
            $('#studentAccordion .panel').removeClass('active-panel');
            $('#studentAccordion .toggle-btn')
                .removeClass('btn-danger')
                .addClass('btn-primary');
            $('#studentAccordion .btn i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $('#studentAccordion .btn span').text('View Details');

            // update current
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $text.text('Hide Details');
            $btn.removeClass('btn-primary').addClass('btn-danger');
            $panel.addClass('active-panel');

            // smooth scroll → center the opened panel
            var winHeight = $(window).height();
            var panelTop = $panel.offset().top;
            var panelHeight = $panel.outerHeight();
            var scrollPos = panelTop - (winHeight / 2) + (panelHeight / 2);

            $('html, body').animate({
                scrollTop: scrollPos
            }, 600, 'swing');
        });

        target.on('hidden.bs.collapse', function() {
            $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $text.text('View Details');
            $btn.removeClass('btn-danger').addClass('btn-primary');
            $panel.removeClass('active-panel');
        });
    });
</script>