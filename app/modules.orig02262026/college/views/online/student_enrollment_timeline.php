<?php
$student = Modules::run('college/enrollment/getStudentsInfo', $this->session->details->st_id, $this->session->details->semester, $this->session->school_year);
$currentStatus = isset($student->status) ? $student->status : 0;
$settings = Modules::run('main/getSet');
?>
<div class="col-lg-10 col-xs-12" style="margin:10px auto; float: none !important">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <div class="col-lg-1 col-xs-2 no-padding">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:50px; background: white; margin:0 auto;" />
        </div>
        <div class="col-lg-5 col-xs-10">
            <h1 class="text-left no-margin" style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
            <h6 class="text-left" style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
        </div>
        <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->fullname . '!'; ?></h4>
        <h5 class="text-right" style="color:black;"><?php echo ($student ? $student->level : $this->session->details->level); ?></h5>
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 20px;">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center" style="margin-bottom: 30px;">
                    <i class="fa fa-calendar-check-o"></i> My Enrollment Timeline
                </h3>
            </div>
        </div>

        <?php if ($student): ?>
            <?php
            // Determine status information
            $statusLabel = '';
            $statusColor = '';
            $statusDescription = '';

            switch ($currentStatus):
                case 0:
                    $statusLabel = 'Registration';
                    $statusColor = 'default';
                    $statusDescription = 'Your enrollment application has been submitted and is pending approval.';
                    break;
                case 3:
                    $statusLabel = 'For Payment';
                    $statusColor = 'warning';
                    $statusDescription = 'Please proceed with payment. You can pay at the school cashier or any accredited payment center.';
                    break;
                case 4:
                    $statusLabel = 'Payment Evaluation';
                    $statusColor = 'danger';
                    $statusDescription = 'Your payment receipt is being evaluated by the finance department.';
                    break;
                case 5:
                    $statusLabel = 'Payment Confirmation';
                    $statusColor = 'info';
                    $statusDescription = 'Your payment has been received. Please wait for confirmation.';
                    break;
                case 6:
                    $statusLabel = 'For Evaluation';
                    $statusColor = 'primary';
                    $statusDescription = 'Your payment has been confirmed. Your enrollment is being evaluated by the registrar.';
                    break;
                case 1:
                    $statusLabel = 'Officially Enrolled';
                    $statusColor = 'success';
                    $statusDescription = 'Congratulations! You are now officially enrolled.';
                    break;
                default:
                    $statusLabel = 'Unknown Status';
                    $statusColor = 'secondary';
                    $statusDescription = 'Please contact the registrar for assistance.';
                    break;
            endswitch;

            // Determine which stages are completed
            $registrationComplete = ($currentStatus >= 0);
            $paymentComplete = ($currentStatus >= 3 || $currentStatus == 1);
            $confirmationComplete = ($currentStatus >= 5 || $currentStatus == 1);
            $enrolledComplete = ($currentStatus == 1);

            // Student information
            $studentName = strtoupper($student->firstname . ' ' . $student->lastname);
            $studentLevel = isset($student->level) ? $student->level : 'N/A';
            $dateAdmitted = 'N/A';
            if (isset($student->date_admitted) && $student->date_admitted != NULL && $student->date_admitted != '0000-00-00'):
                $dateAdmitted = date('F d, Y', strtotime($student->date_admitted));
            endif;
            ?>

            <!-- Current Status Card -->
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-12">
                    <div class="panel panel-<?php echo $statusColor ?>">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-info-circle"></i> Current Enrollment Status
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 style="margin-top: 0;">
                                        <span class="label label-<?php echo $statusColor ?> label-lg">
                                            <?php echo $statusLabel ?>
                                        </span>
                                    </h3>
                                    <p class="lead"><?php echo $statusDescription ?></p>
                                    <p><strong>Student:</strong> <?php echo $studentName ?></p>
                                    <p><strong>Level/Course:</strong> <?php echo $studentLevel ?></p>
                                    <p><strong>Date Submitted:</strong> <?php echo $dateAdmitted ?></p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="status-icon-large">
                                        <?php if ($currentStatus == 1): ?>
                                            <i class="fa fa-check-circle" style="font-size: 80px; color: #5cb85c;"></i>
                                        <?php elseif ($currentStatus >= 6): ?>
                                            <i class="fa fa-hourglass-half" style="font-size: 80px; color: #337ab7;"></i>
                                        <?php elseif ($currentStatus >= 5): ?>
                                            <i class="fa fa-check-circle" style="font-size: 80px; color: #5bc0de;"></i>
                                        <?php elseif ($currentStatus >= 3): ?>
                                            <i class="fa fa-money" style="font-size: 80px; color: #f0ad4e;"></i>
                                        <?php else: ?>
                                            <i class="fa fa-user" style="font-size: 80px; color: #777;"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollment Timeline -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-list-ol"></i> Enrollment Progress
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="student-enrollment-timeline">
                                <!-- Registration Stage -->
                                <div class="timeline-step-wrapper">
                                    <div class="timeline-step <?php echo $registrationComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 0) ? 'active' : '' ?>">
                                        <div class="timeline-step-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="timeline-step-content">
                                            <h5>1. Registration</h5>
                                            <p>Application Submitted</p>
                                            <?php if ($registrationComplete): ?>
                                                <small class="text-success">
                                                    <i class="fa fa-check"></i> Completed
                                                    <?php if ($dateAdmitted != 'N/A'): ?>
                                                        on <?php echo $dateAdmitted ?>
                                                    <?php endif; ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">Pending</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Stage -->
                                <div class="timeline-step-wrapper">
                                    <div class="timeline-step <?php echo $paymentComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 3 || $currentStatus == 4) ? 'active' : '' ?>">
                                        <div class="timeline-step-icon">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="timeline-step-content">
                                            <h5>2. Payment</h5>
                                            <p>Make Payment</p>
                                            <?php if ($paymentComplete): ?>
                                                <small class="text-success">
                                                    <i class="fa fa-check"></i>
                                                    <?php if ($currentStatus == 3): ?>
                                                        Payment Required
                                                    <?php elseif ($currentStatus == 4): ?>
                                                        Payment Under Review
                                                    <?php else: ?>
                                                        Payment Completed
                                                    <?php endif; ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">Not Started</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirmation Stage -->
                                <div class="timeline-step-wrapper">
                                    <div class="timeline-step <?php echo $confirmationComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 5 || $currentStatus == 6) ? 'active' : '' ?>">
                                        <div class="timeline-step-icon">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                        <div class="timeline-step-content">
                                            <h5>3. Confirmation</h5>
                                            <p>Payment Verified</p>
                                            <?php if ($confirmationComplete): ?>
                                                <small class="text-success">
                                                    <i class="fa fa-check"></i>
                                                    <?php if ($currentStatus == 5): ?>
                                                        Waiting for Confirmation
                                                    <?php elseif ($currentStatus == 6): ?>
                                                        Payment Confirmed
                                                    <?php else: ?>
                                                        Confirmed
                                                    <?php endif; ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">Pending</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Officially Enrolled Stage -->
                                <div class="timeline-step-wrapper">
                                    <div class="timeline-step <?php echo $enrolledComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 1) ? 'active' : '' ?>">
                                        <div class="timeline-step-icon">
                                            <i class="fa fa-award"></i>
                                        </div>
                                        <div class="timeline-step-content">
                                            <h5>4. Officially Enrolled</h5>
                                            <p>Enrollment Complete</p>
                                            <?php if ($enrolledComplete): ?>
                                                <small class="text-success">
                                                    <i class="fa fa-check"></i> Congratulations! You are officially enrolled.
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">Pending</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-12 text-center">
                    <?php if ($currentStatus == 3): ?>
                        <a onclick="$('#onlinePayment').modal('show')" class="btn btn-warning btn-lg">
                            <i class="fa fa-money"></i> Proceed to Payment
                        </a>
                    <?php elseif ($currentStatus == 0): ?>
                        <button onclick="location.reload()" class="btn btn-primary btn-lg">
                            <i class="fa fa-refresh"></i> Refresh Status
                        </button>
                    <?php elseif ($currentStatus >= 5 && $currentStatus != 1): ?>
                        <p class="text-info">
                            <i class="fa fa-info-circle"></i> Please wait for the registrar's evaluation. You will be notified once your enrollment is approved.
                        </p>
                    <?php elseif ($currentStatus == 1):
                        $this->session->set_userdata('isEnrolled', 1);
                    ?>
                        <a href="<?php echo base_url('opl/student') ?>" class="btn btn-success btn-lg">
                            <i class="fa fa-graduation-cap"></i> Go to Student Portal
                        </a>
                    <?php endif; ?>
                    <!-- <a href="<?php // echo base_url('college/enrollment') 
                                    ?>" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                    </a> -->
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i> No enrollment record found. Please contact the registrar for assistance.
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="onlinePayment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <div style="display:flex; align-items:center; gap:10px; width:100%;">
                    <span><i class="fa fa-money"></i> Payment Online</span>
                    <small class="hidden-xs" style="opacity:.9; margin-left:auto;">Secure and convenient options to settle your fees</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body clearfix">
                <div style="width: 100%" class="col-lg-12 no-padding">
                    <div class="form-group pull-left">
                        <h4 class="text-left no-margin col-lg-12 col-xs-12 no-padding">FINANCE OBLIGATION</h4>
                    </div>

                </div>
                <?php

                $student = $this->session->details;
                if ($this->session->department == 5):
                    $totalUnits = 0;
                    $totalSubs = 0;
                    $totalLab = 0;
                    $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $student->semester, $student->school_year);
                    foreach ($loadedSubject as $sl):
                        $totalSubs++;
                        $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
                        if ($sl->sub_lab_fee_id != 0):
                            $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                            $totalLab += $itemCharge->default_value;
                        endif;
                    endforeach;

                    $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
                    $tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);
                    $specialClass = Modules::run('college/finance/getExtraChargesByCategory', 5, $student->semester, $student->school_year, $student->u_id);
                    $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id);

                    foreach ($charges as $c):
                        $next = $c->school_year + 1;
                        if ($c->item_id != 46):
                            $totalCharges += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : $c->amount);
                        endif;
                        $totalExamFee += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : ($c->item_id == 46 ? ($c->amount) : 0));
                    endforeach;
                    $totalExtra = 0;
                    $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->u_id, $student->semester, $student->school_year);
                    if ($showPayment):
                        if ($extraCharges->num_rows() > 0):
                            foreach ($extraCharges->result() as $ec):
                                $totalExtra += $ec->extra_amount;
                            endforeach;
                        endif;

                    endif;

                    $over = Modules::run('college/finance/overPayment', $student->uid, $student->semester, $student->school_year);

                    $totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $totalLab + $totalExtra);
                    foreach ($charges as $exam):
                        $examFee = ($exam->item_id == 46 ? 'yes' : 0);
                    endforeach;

                    $semester = ($student->semester == 1 ? 3 : ($student->semester - 1));
                    $school_year = ($semester == 1 ? $student->school_year - 1 : $student->school_year);

                    $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $school_year));
                ?>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 ">
                        <div class="panel panel-warning">
                            <div class="panel-heading clearfix">
                                Finance Details
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-responsive">
                                    <tr>
                                        <th>Particulars</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo 'TUITION (' . $totalUnits . ' UNITS @ ' . (number_format($tuition->row()->amount, 2, '.', ',')) . ')' ?></td>
                                        <th class="text-right"><?php echo number_format($tuition->row()->amount * $totalUnits, 2, '.', ',') ?></th>
                                    </tr>
                                    <tr>
                                        <td>OTHER FEES</td>
                                        <th class="text-right"><?php echo number_format($totalCharges, 2, '.', ',') ?></th>
                                    </tr>
                                    <tr>
                                        <td>EXAM FEES</td>
                                        <th class="text-right"><?php echo number_format(($totalExamFee * $totalSubs), 2, '.', ',') ?></th>
                                    </tr>
                                    <?php if ($totalLab != 0): ?>
                                        <tr>
                                            <td>LABORATORY FEES</td>
                                            <th class="text-right"><?php echo number_format($totalLab, 2, '.', ',') ?></th>
                                        </tr>
                                    <?php
                                    endif;
                                    $overAllExamFees = $totalExamFee * $totalSubs;
                                    $outstandingBalance = ($totalFees + $over->row()->extra_amount + $overAllExamFees);
                                    ?>
                                    <tr>
                                        <th>TOTAL FEES</th>
                                        <th class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                                    </tr>
                                    <?php
                                    if ($hasBalance->status):
                                        Modules::run('college/enrollment/updateEnrollmentStatus', base64_encode($student->st_id), 4, $student->semester, $school_year);
                                    ?>
                                        <tr class="danger">
                                            <td style="font-size: 20px;">PREVIOUS BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance, 2, '.', ',') ?></th>
                                        </tr>

                                        <tr>
                                            <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance + $outstandingBalance, 2, '.', ',') ?></th>
                                        </tr>

                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php else: // This is for Basic Education Department

                    $plan = Modules::run('finance/getPlanByCourse', $student->grade_level_id, 0, $student->st_type, $student->school_year);
                    $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
                    $loadedSubject = Modules::run('registrar/getOvrLoadSub', $student->st_id, $student->semester, $student->school_year);
                    $previousRecord = json_decode(Modules::run('finance/getRunningBalance', base64_encode($student->st_id), ($student->semester == 3 ? $student->school_year : ($student->school_year - 1)), ($student->semester == 3 ? 0 : $student->semester)));
                    if ($previousRecord->status):
                        $previousBalance = $previousRecord->charges - $previousRecord->payments;
                        $hasBalance = $previousBalance > 0 ? TRUE : FALSE;
                    else:
                        $hasBalance = FALSE;
                    endif;
                ?>


                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 ">
                        <div class="panel panel-warning">
                            <div class="panel-heading clearfix">
                                Finance Details
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-responsive">
                                    <tr>
                                        <th>Particulars</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    $outstandingBalance = 0;
                                    $amount = 0;
                                    $fusedCharges = 0;
                                    $tuition = 0;
                                    if ($student->semester != 3):
                                        foreach ($charges as $c):
                                            if ($c->is_fused):
                                                $chargeAmount = $c->amount;
                                                $fusedCharges += $chargeAmount;
                                            else:
                                                if ($c->item_id == 3):
                                                    $tuition = $c->amount;
                                                endif;
                                            endif;
                                        endforeach;
                                        $totalExtra = 0;
                                        $extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);
                                        $books = 0;
                                        $totalPayments = 0;
                                        if ($extraCharges->num_rows() > 0):
                                            foreach ($extraCharges->result() as $ec):
                                                if ($ec->extra_item_id == 78):
                                                    $books += $ec->extra_amount;
                                                else:
                                                    $totalExtra += $ec->extra_amount;
                                                endif;
                                            endforeach;
                                        endif;
                                        $outstandingBalance = $fusedCharges + $totalExtra + $tuition + $books;
                                    ?>
                                        <tr>
                                            <td>TUITION FEE</td>
                                            <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($tuition, 2, '.', ',') ?></td>
                                        </tr>
                                        <?php if ($fusedCharges > 0): ?>
                                            <tr>
                                                <td>OTHER FEES</td>
                                                <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($fusedCharges + $totalExtra, 2, '.', ',') ?></td>
                                            </tr>
                                            <?php
                                        else:

                                            foreach ($charges as $c):
                                                if ($c->item_id != 3):
                                                    $amount = $c->amount;
                                            ?>
                                                    <tr>
                                                        <td><?php echo strtoupper($c->item_description) ?></td>
                                                        <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.', ',') ?></td>
                                                    </tr>


                                            <?php

                                                    $outstandingBalance += $amount;
                                                endif;
                                            endforeach;
                                        endif;
                                        if ($books != 0):
                                            ?>
                                            <tr>
                                                <td>TEXTBOOKS</td>
                                                <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($books, 2, '.', ',') ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>TOTAL FEES</th>
                                            <th class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                                        </tr>
                                        <?php

                                    else:
                                        foreach ($charges as $c):
                                            if ($c->fin_cat_id == 1 && $student->semester == 3):
                                                $amount = $c->amount * $count;
                                            else:
                                                $amount = $c->amount;
                                            endif;
                                            $outstandingBalance += $amount;
                                        ?>
                                            <tr>
                                                <td><?php echo $c->item_description ?></td>
                                                <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.', ',') ?></td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>
                                        <tr>
                                            <th>TOTAL FEES</th>
                                            <th class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                                        </tr>
                                    <?php

                                    endif;
                                    if ($hasBalance):
                                        $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);

                                        if (empty($remarks)):
                                            Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $student->school_year, 1);
                                        endif;
                                    ?>
                                        <tr class="danger">
                                            <td style="font-size: 20px;">PREVIOUS BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($previousBalance, 2, '.', ',') ?></th>
                                        </tr>

                                        <tr>
                                            <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($previousBalance + $outstandingBalance, 2, '.', ',') ?></th>
                                        </tr>
                                    <?php
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Quick Summary -->
                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:10px; margin-bottom:10px;">
                    <div class="panel panel-default" style="border-left:4px solid #5cb85c;">
                        <div class="panel-body clearfix">
                            <div class="col-xs-12 col-sm-6">
                                <p class="no-margin"><strong>Student:</strong> <?php echo isset($student->firstname) ? $student->firstname . ' ' . $student->lastname : $student->st_id; ?></p>
                                <p class="no-margin"><strong>School Year <?= ($student->semester == 3 ? '/ Term' : '') ?>:</strong> <?php echo $student->school_year . ' - ' . ($student->school_year + 1); ?><?php echo ($student->semester == 3 ? ' / Summer' : ''); ?></p>
                            </div>
                            <div class="col-xs-12 col-sm-6 text-right">
                                <div style="font-size:13px; color:#888;">Total Amount Due</div>
                                <div style="font-size:26px; font-weight:bold; line-height:1;">
                                    <?php echo number_format(isset($outstandingBalance) ? $outstandingBalance : 0, 2, '.', ','); ?>
                                </div>
                                <?php
                                $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);
                                if ($remarks):
                                ?>
                                    <div style="font-size:12px; color:#777;"><?php echo $remarks->fr_remarks; ?></div>
                                <?php else: ?>
                                    <div style="font-size:12px; color:#777;">You may pay any amount. Minimum suggested: <strong>&#8369; 1,000.00</strong></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10 col-md-12 col-xs-12">
                        <div class="alert alert-info clearfix">

                            <p class="text-center">To the following payment centers:</p> <br />
                            <table class="table table-striped" style="background: white; color: #000080">
                                <tr>
                                    <th class="text-center" colspan="2">Bank Details</th>
                                </tr>
                                <?php if (count($paymentCenter) > 0):
                                    foreach ($paymentCenter as $pc):
                                ?>
                                        <tr>
                                            <td class="text-center"><img src="<?php echo base_url('images/banks/' . $pc->pc_logo) ?>" style="height:60px; margin:3px auto;" title="<?= $pc->pc_name ?>" alt="<?= $pc->pc_name ?>" /></td>
                                            <td>Branch: <?= $pc->pc_branch ?> <br />
                                                Account Name: <?= $pc->pc_account_name ?><br />
                                                Account #:
                                                <span style="display:inline-block; min-width: 160px;">
                                                    <input type="text" readonly value="<?= $pc->pc_account_number ?>" style="border:none; background:transparent; padding:0; width:auto;" id="acct_<?= md5($pc->pc_account_number) ?>" aria-label="Account Number">
                                                </span>
                                                <button type="button" class="btn btn-xs btn-default" onclick="copyToClipboard('acct_<?= md5($pc->pc_account_number) ?>')" title="Copy account number">
                                                    <i class="fa fa-clipboard"></i> Copy
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                else: ?>

                                <?php endif; ?>
                            </table>
                            <p class="text-center"> Upload the payment receipt if payment has been made</p><br />
                            <button onclick="$('#uploadReceipt').modal('show')" class="btn btn-success btn-xs pull-left"><i class="fa fa-upload"></i> Upload Receipt</button>
                            <button type="button" class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
<input type="hidden" id="user_id" value="<?php echo base64_encode($student->user_id) ?>" />
<input type="hidden" id="school_year" value="<?php echo $student->school_year ?>" />
<input type="hidden" id="semester" value="<?php echo $student->semester ?>" />
<input type="hidden" id="adm_id" value="<?php echo $student->admission_id ?>" />
<div id="uploadReceipt" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-success" style="border-radius:15px 15px 0 0; ">
        Upload Payment Receipt
        <button class="btn btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px; border:1px solid #ccc; padding: 5px 10px 10px; overflow-y: scroll">
        <div class="modal-body">
            <form id="upload_form" enctype="multipart/form-data" method="post">
                <select class="form-control" id="payment_center">
                    <option>Select Payment Center</option>
                    <?php
                    // $pads = Modules::run('college/enrollment/getPadala');
                    foreach ($paymentCenter as $p):
                    ?>
                        <option value="<?php echo $p->pc_short_name; ?>"><?php echo $p->pc_name; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
                <br />
                <input type="file" name="userfile" id="userfile"><br>
                <input class="btn btn-success" type="button" value="Upload File" onclick="uploadFile()"> <br /> <br />
                <div class="progress" id="progressBarWrapper" style="display: none;">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        UPLOADING RECEIPT...
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>

<style type="text/css">
    /* Smooth fade and scale-in animation for modal */
    .modal.fade .modal-dialog {
        transform: scale(0.95);
        transition: transform 0.3s ease-out;
    }

    .modal.fade.show .modal-dialog {
        transform: scale(1);
    }

    /* Section spacing */
    .modal-body .mb-3 {
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed #e9ecef;
    }

    /* Premium background blur */
    .modal-backdrop.show {
        backdrop-filter: blur(6px);
        background-color: rgba(131, 123, 123, 0.4) !important;
    }

    /* Subtle hover for copy buttons */
    .btn.btn-default.btn-xs:hover {
        background: #f5f5f5;
    }

    .student-enrollment-timeline {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        padding: 40px 0;
        margin: 20px 0;
    }

    .student-enrollment-timeline::before {
        content: '';
        position: absolute;
        top: 60px;
        left: 10%;
        right: 10%;
        height: 4px;
        background: #e0e0e0;
        z-index: 0;
    }

    .timeline-step-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    .timeline-step {
        text-align: center;
        max-width: 200px;
    }

    .timeline-step-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 15px;
        border: 5px solid #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .timeline-step.completed .timeline-step-icon {
        background: #5cb85c;
        color: #fff;
        border-color: #5cb85c;
    }

    .timeline-step.active .timeline-step-icon {
        background: #f0ad4e;
        color: #fff;
        border-color: #f0ad4e;
        animation: pulse 2s infinite;
        transform: scale(1.1);
    }

    .timeline-step.active.completed .timeline-step-icon {
        background: #5cb85c;
        border-color: #5cb85c;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(240, 173, 78, 0.7);
        }

        70% {
            box-shadow: 0 0 0 15px rgba(240, 173, 78, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(240, 173, 78, 0);
        }
    }

    .timeline-step-content h5 {
        margin: 10px 0 5px;
        font-weight: bold;
        color: #333;
    }

    .timeline-step.completed .timeline-step-content h5 {
        color: #5cb85c;
    }

    .timeline-step.active .timeline-step-content h5 {
        color: #f0ad4e;
        font-weight: bold;
    }

    .timeline-step-content p {
        color: #666;
        margin-bottom: 5px;
    }

    .label-lg {
        font-size: 18px;
        padding: 10px 20px;
    }

    .status-icon-large {
        padding: 20px;
    }

    /* Progress line between completed steps */
    .student-enrollment-timeline .timeline-step-wrapper:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 60px;
        left: 50%;
        width: 100%;
        height: 4px;
        background: transparent;
        z-index: 0;
    }

    .student-enrollment-timeline .timeline-step-wrapper:not(:last-child).completed::after {
        background: #5cb85c;
    }

    @media (max-width: 768px) {
        .student-enrollment-timeline {
            flex-direction: column;
            align-items: center;
        }

        .student-enrollment-timeline::before {
            display: none;
        }

        .timeline-step-wrapper {
            width: 100%;
            margin-bottom: 30px;
        }

        .timeline-step {
            max-width: 100%;
        }
    }
</style>


<script type="text/javascript">
    function progressHandler(event) {

        $('#progressBarWrapper').show();

    }

    function completeHandler(event) {
        // _("status").innerHTML = event.target.responseText;
        $("#progressBarWrapper").hide();
        alert(event.target.responseText);
        document.location = '<?php echo base_url('entrance'); ?>';
    }

    function copyToClipboard(elementId) {
        try {
            var el = document.getElementById(elementId);
            if (!el) return;
            el.select();
            el.setSelectionRange(0, 99999);
            document.execCommand('copy');
            // brief visual feedback
            var originalBorder = el.style.borderBottom;
            el.style.borderBottom = '2px solid #5cb85c';
            setTimeout(function() {
                el.style.borderBottom = originalBorder;
            }, 800);
        } catch (e) {
            console.warn('Copy failed', e);
        }
    }
</script>