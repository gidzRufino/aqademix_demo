<?php
$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $student->semester, $student->school_year);
//print_r($loadedSubject);
switch ($student->year_level):
    case 1:
        $year_level = 'First Year';
        break;
    case 2:
        $year_level = 'Second Year';
        break;
    case 3:
        $year_level = 'Third Year';
        break;
    case 4:
        $year_level = 'Fourth Year';
        break;
    case 5:
        $year_level = 'Fifth Year';
        break;
endswitch;
?>
<div class="well col-lg-12" id="profBody">
    <button title="Use this button if the student withdraw from enrollment" onclick="removeEnrollmentDetails('<?php echo base64_encode($student->admission_id) ?>', '<?php echo $student->school_year ?>')" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash fa-2x"></i></button>
    <button type="button" title="Click me if you want to skip enrollment" st-name="<?php echo ucwords(strtolower($student->firstname . ' ' . $student->lastname)); ?>" st-id="<?php echo base64_encode($student->st_id); ?>" onclick="readySkip(this)" class="btn btn-warning btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-forward fa-2x"></i></button>
    <h3 style="margin:3px 0;"><span id="name" style="color:#BB0000;"><?php echo ucwords(strtolower($student->firstname . ' ' . $student->lastname)) . ' ( ' . $student->st_id . ' )' ?></span></h3>
    <h4 style="color:black; margin:3px 0;"><?php echo strtoupper($student->course) . ' - ' . $year_level ?><span id="a_section"></span> </h4>
    <input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
    <input type="hidden" id="user_id" value="<?php echo base64_encode($student->user_id) ?>" />
    <input type="hidden" id="school_year" value="<?php echo $student->school_year ?>" />
    <input type="hidden" id="semester" value="<?php echo $student->semester ?>" />
    <input type="hidden" id="adm_id" value="<?php echo $student->admission_id ?>" />

</div>
<div class="modal fade" id="skipEnrollment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h1><i class="fa fa-exclamation text-danger"></i></h1>
                <h4>You are about to skip <span id="stName"></span> from the enrollment procedure.</h4>
                <h5>Do you really want to enroll this student officially?</h5>
                <small>Note: This process cannot be undone!</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="skipBtn" onclick="skipEnrollment(this)">Proceed</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 no-padding">
    <?php
    $payment = Modules::run('college/finance/getPayments', $student->school_year, $student->semester, base64_encode($student->st_id));
        ?>
        <table class="table table-striped table-bordered table-responsive" id="">
            <tr>
                <th colspan="5" class="text-center">LOADED SUBJECTS</th>
            </tr>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th class="text-center">Day / Time</th>
                <th class="text-center">Instructor</th>
                <th class="text-center">Units</th>
            </tr>
            <?php
            $count = count($loadedSubject);

            if ($count > 0) :
                ?>
                <tbody id="subjectLoadBody">
                    <?php
                    $totalUnits = 0;
                    $aprv = 0;
                    foreach ($loadedSubject as $ls):
                        $units = ($ls->sub_code == "NSTP 11" || $ls->sub_code == "NSTP 12" || $ls->sub_code == "NSTP 1" || $ls->sub_code == "NSTP 2" ? 3 : $ls->s_lect_unit + $ls->s_lab_unit);
                        $totalUnits += $units;
                        $aprv += $ls->is_final;
                        $isOnline = ($student->enrolled_online ? TRUE : FALSE);
                        ?>
                        <tr class="trSched"
                            id="tr_<?php echo $ls->s_id ?>">
                            <td><?php echo $ls->sub_code ?></td>
                            <td><?php echo $ls->s_desc_title ?></td>
                            <td class="text-center">
                                <?php
                                $scheds = Modules::run('college/schedule/getSchedulePerSection', $ls->sec_id, $student->semester, $student->school_year);
                                $sched = json_decode($scheds);
                                echo ($sched->count > 0 ? $sched->time . ' [ ' . $sched->day . ' ]' : 'TBA');
                                ?>
                            </td>
                            <td class="text-center">
                                <?php echo strtoupper($sched->instructor); ?>
                            </td>
                            <td id="td_units_<?php echo $ls->s_id ?>" class="text-center">
                                <?php echo $units ?>
                            </td>
                            <?php if (!$ls->is_final): ?>
                                <td>
                                    <button onclick="removeSubject('<?php echo $ls->s_id ?>')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>

                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="4"></td>
                        <td  class="text-center text-strong" id="totalUnits"><?php echo $totalUnits ?></td>
                    </tr>
                </tbody>
                <?php
                if ($this->session->userdata('position_id') == 1 ||
                        $this->session->position == 'Registrar' ||
                        $this->session->position == 'Dean' ||
                        $this->session->position == 'Dean Secretary' ||
                        $this->session->position == 'Quality Assurance Director'):
                    ?>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <button class="pull-left btn btn-small btn-primary"
                                        data-container="body" data-toggle="popover" data-placement="bottom"  title="write a remark" 
                                        data-content="
                                        <div class='overpop'>
                                        <div class='form-group'>
                                        <textarea style='width:200px; height:100px;' class='textarea form-control text-left' id='admissionRemarkDetails'>

                                        </textarea><br />
                                        <button onclick='sendAdmissionRemark()' class='pull-right btn btn-xs btn-success'>SEND</button>
                                        </div>

                                        </div>"
                                        >Send Remarks</button>
                                <button class="btn btn-small btn-warning pull-left" style="margin-left:10px;" onclick="$('#sendSMSDetails').modal('show'), $('#mobileNo').val('<?php echo base64_encode($student->cd_mobile) ?>')">Send SMS</button>
                                <?php if ($count != $aprv): ?>
                                    <?php if (!$isOnline): ?>
                                        <button id="btnApprove" class="btn btn-warning pull-right">Approve ?</button>
                                    <?php else: ?>
                                        <button id="onlineBtnApprove" class="btn btn-warning pull-right">Approve Online Application ?</button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button style="margin-right:10px;" class="btn btn-success pull-right disabled">Study Load Already Approved</button>

                                <?php endif; ?>
                            </td>
                        </tr>
                    </tfoot>

                    <?php
                endif;
            else:
                ?>
                <tr>
                    <th style="vertical-align: middle;" colspan="5" class="text-center danger text-danger"><i class="fa fa-info-circle fa-2x fa-fw"></i> Student did not load any subject, Please notify the student</th>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-small btn-warning pull-left" style="margin-left:10px;" onclick="$('#sendSMSDetails').modal('show'), $('#mobileNo').val('<?php echo base64_encode($student->cd_mobile) ?>')">Send SMS</button>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </table>
        <?php
    if ($payment <= 0):
        ?>
        <div class="alert alert-info">
            <h4 class="text-center"><i class="fa fa-info-circle fa-fw"></i> Student hasn't made any payment yet.</h4>
        </div>
    <?php
    endif;
    if ($count > 0):
        if ($student->is_old == 0):
            ?>
            <div class="col-lg-12" style="margin: 10px;">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        New Student Enrollment Requirements
                    </div>
                    <div class="panel-body">
                        <?php
                        $directory = 'uploads/' . $student->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $student->st_id . DIRECTORY_SEPARATOR . 'files';
                        // echo $directory;
                        $scanFiles = scandir($directory);
                        $files = array_diff($scanFiles, array('..', '.'));
                        foreach ($files as $file):
                            ?>
                            <div class="col-lg-4">
                                <button onclick="deleteEnrollmentFile('<?php echo $directory . '/' . $file ?>')" class="btn btn-xs btn-danger pull-right">x</button>
                                <img class="img-responsive myImg" style="width: 200px;" src="<?php echo base_url($directory . '/' . $file) ?>" alt="<?php echo $file ?>">
                            </div>         
                            <?php
                        endforeach;
                        ?>     
                    </div>
                </div>
            </div>        
            <?php
        endif;
    endif;
    if ($this->session->userdata('position_id') == 1 ||
            $this->session->position == "IBDE Department Head" ||
            $this->session->position == "Accounting Staff" ||
            $this->session->position == "Cashier"):
        //if ($count == $aprv && $count >0): //SUBJECTS ALREADY APPROVED
        $totalUnits = 0;
        $totalSubs = 0;
        $totalLab = 0;
        $totalCharges = 0;
        $totalExamFee = 0;
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
        $specialClass = Modules::run('college/finance/getExtraChargesByCategory', 5, $student->semester, $student->school_year, $student->user_id);
        $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id);

        foreach ($charges as $c):
            $next = $c->school_year + 1;
            if ($c->item_id != 46):
                $totalCharges += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : $c->amount);
            endif;
            $totalExamFee += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : ($c->item_id == 46 ? ($c->amount) : 0));
        endforeach;
        $totalExtra = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);

        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
            if($ec->extra_item_id != 268236):
                $totalExtra += $ec->extra_amount;
            endif;
            endforeach;
        endif;

        $over = Modules::run('college/finance/overPayment', $student->st_id, $student->semester, $student->school_year);

        $totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $totalLab + $totalExtra);
        foreach ($charges as $exam):
            $examFee = ($exam->item_id == 46 ? 'yes' : 0);
        endforeach;

        $semester = ($student->semester == 1 ? 3 : ($student->semester - 1));
//        $prev_year = ($student->semester == 1 ? $student->school_year - 1 : $student->school_year);
        if ($student->is_old):
            switch ($student->semester):
                case 1:
                    $p_sy = $student->school_year - 1;
                    $p_sem = 3;
                    break;
                case 2:
                    $p_sy = $student->school_year;
                    $p_sem = 1;
                    break;
                case 3:
                    $p_sy = $student->school_year;
                    $p_sem = 2;
                    break;
            endswitch;
            $result = Modules::run('college/enrollment/isPreviouslyEnrolled', $student->st_id, $p_sy, $p_sem);
            $hasBalance = json_decode(Modules::run('college/finance/getPrevBal', $student->st_id, $result->semester, $result->school_year, $student->semester, $student->school_year));
        else:
            $hasBalance = json_decode(json_encode(array('status' => FALSE)));
        endif;
        //$hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $prev_year));
        ?>
        <div class="col-lg-2"></div>
        <div class="col-lg-9 col-xs-12 ">
            <div class="panel panel-warning">
                <div class="panel-heading clearfix">
                    Finance Details
                    <button class="btn btn-xs btn-success pull-right" onclick="sendPaymentReminder('<?php echo base64_encode($student->cd_mobile) ?>'), $(this).addClass('disabled'), $(this).html('Sending...')">Send Reminder</button>
                    <button class="btn btn-xs btn-primary pull-right" style='margin-right:5px;' onclick="$('#sendRemarksModal').modal('show')">Send Remarks</button>
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
                        $outstandingBalance = ($totalFees + ($over->row() ? $over->row()->extra_amount : 0) + $overAllExamFees);
                        ?>
                        <tr>
                            <th >TOTAL FEES</th>
                            <th  class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                        </tr>
                        <?php
                        if ($hasBalance->status):
                            $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);

                            if (empty($remarks)):
                                Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $student->school_year);
                            endif;
                            ?>
                            <tr class="danger">
                                <td style="font-size: 20px;">PREVIOUS BALANCE <h5><?php echo $hasBalance->msg; ?></h5></td>
                                <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance, 2, '.', ',') ?></th>
                            </tr>

                            <tr>
                                <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance + $outstandingBalance, 2, '.', ',') ?></th>
                            </tr>
                            <?php if ($remarks): ?>
                                <tr>
                                    <td colspan="2" class="text-center">Remarks Sent to Student:</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center"><?php echo $remarks->fr_remarks ?></td>
                                </tr>
                                <?php
                            endif;
                        endif;
                        $paymentReceipt = Modules::run('college/enrollment/getUploadedReceipt', $student->st_id, $student->semester, $student->school_year);

                        if ($paymentReceipt->row()):
                            ?>
                            <tr>
                                <td colspan="2" class="text-center"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">Payment Receipt - <?php echo $paymentReceipt->row()->opr_paycenter; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <?php
                                    $directory = 'UPLOADSa/' . $student->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $student->st_id . DIRECTORY_SEPARATOR . 'online_payments';
                                    $scanFiles = scandir($directory);
                                    $files = array_diff($scanFiles, array('..', '.'));
                                    foreach ($files as $file):
                                        ?>
                                        <img class="img-responsive myImg" style="width: 200px;" src="<?php echo base_url($directory . '/' . $file) ?>"  alt="<?php echo $file ?>">

                                        <?php
                                    endforeach;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            if ($this->session->userdata('position_id') == 1 || $this->session->position == "Cashier" ||
                                    $this->session->position == "Accounting Staff"):
                                ?>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <?php if ($paymentReceipt->row()->opr_is_confirm): ?>
                                            <button class="btn btn-xs btn-block btn-success" disabled>PAYMENT CONFIRMED</button>
                                        <?php else: ?>
                                            <button id="confirmPayment" class="btn btn-xs btn-block btn-primary">CONFIRM PAYMENT</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endif;
                        ?>     
                    </table>
                </div>
            </div>
        </div>
        <?php
        // else:
        ?>    
        <!--                <div class="alert alert-info">
                            <h3 class="text-center">NO FINANCE RECORD YET, <br /> STUDENT UNDER SUBJECT LOAD EVALUATION</h3>
                        </div>-->
        <?php
        // endif; 
        ?>
    <?php endif; ?>
</div>


<div id="sendRemarksModal" class="modal fade col-lg-3 col-xs-12" style="margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Finance Remarks 
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Remark Details</label>
                <textarea class="textarea form-control text-left" id="remarkDetails">

                </textarea>
            </div>

        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='sendRemarks()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Send</a>
        </div>

    </div>
</div>

<div id="sendSMSDetails" class="modal fade col-lg-3 col-xs-12" style="margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Send SMS 
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Message Details</label>
                <textarea class="textarea form-control text-left " id="smsDetails">
Hi <?php echo ucwords(strtolower($student->firstname)) ?>
                </textarea>
            </div>
            <input type="hidden" id="mobileNo" value="" />

        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='sendSMS()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Send</a>
        </div>

    </div>
</div>

<input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
<input type='hidden' id="remarkController" />
<script type="text/javascript">
    var _0x49bd = ['popover', 'cookie', '#totalLect_taken', 'Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?', 'addClass', 'POST', 'csrf_cookie_name', '#st_id', 'System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently', '[data-toggle=\x22popover\x22]', '#btnApprove', 'modal', 'msg=', '#totalUnits', 'html', 'btn-primary', '#tr_total_taken', 'json', 'status', '#adm_id', '#base_url', 'college/enrollment/sendPaymentReminder/', 'show', 'college/enrollment/confirmPayment/', 'college/enrollment/removeEnrollmentDetails/', '#school_year', 'ready', '#remarkDetails', '#loadMsg\x20td', 'removeClass', '#smsDetails', 'college/enrollment/sendFinanceRemarks/', 'click', 'Are\x20you\x20sure\x20you\x20want\x20to\x20remove\x20this\x20Student?', 'remove', 'college/enrollment/sendSMS/', '#user_id', '#onlineBtnApprove', 'college/subjectmanagement/approveLoad/', 'reload', 'btn-success', 'PAYMENT\x20CONFIRMED', '#base', '&csrf_test_name=', 'msg', 'csrf_test_name=', '#semester', 'val', '#loadMsg', 'college/enrollment/removeSubject/', '#admissionRemarkDetails', 'hide', '#tr_', 'college/enrollment/monitor', '#mobileNo', 'location', '#loadingModal', 'System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...', '#confirmPayment', 'college/enrollment/sendAdmissionRemarks/', 'GET', 'ajax'];
    (function (_0x22a672, _0x49bd7a) {
        var _0x52a29d = function (_0x122cfe) {
            while (--_0x122cfe) {
                _0x22a672['push'](_0x22a672['shift']());
            }
        };
        _0x52a29d(++_0x49bd7a);
    }(_0x49bd, 0xf5));
    var _0x52a2 = function (_0x22a672, _0x49bd7a) {
        _0x22a672 = _0x22a672 - 0x0;
        var _0x52a29d = _0x49bd[_0x22a672];
        return _0x52a29d;
    };
    $(document)[_0x52a2('0x1d')](function () {
        var _0x4af337 = $(_0x52a2('0x17'))[_0x52a2('0x32')]();
        if ($(_0x52a2('0x5'))['html']() == 0x0) {
            $(_0x52a2('0x13'))[_0x52a2('0x36')]();
        }
        ;
        $(_0x52a2('0xc'))['popover']({'html': !![]});
        popoverhide = function () {
            $(_0x52a2('0xc'))[_0x52a2('0x3')](_0x52a2('0x36'));
        };
        $(_0x52a2('0x3d'))['click'](function () {
            var _0x104066 = confirm(_0x52a2('0x6'));
            if (_0x104066 == !![]) {
                var _0x1c2738 = _0x4af337 + _0x52a2('0x1a');
                $[_0x52a2('0x2')]({'type': 'POST', 'url': _0x1c2738, 'dataType': 'json', 'data': {'st_id': $(_0x52a2('0xa'))[_0x52a2('0x32')](), 'user_id': $('#user_id')[_0x52a2('0x32')](), 'semester': $(_0x52a2('0x31'))[_0x52a2('0x32')](), 'school_year': $(_0x52a2('0x1c'))[_0x52a2('0x32')](), 'csrf_test_name': $['cookie'](_0x52a2('0x9'))}, 'beforeSend': function () {
                        $(_0x52a2('0x3d'))[_0x52a2('0x11')](_0x52a2('0x3c'));
                    }, 'success': function (_0x48bd25) {
                        $(_0x52a2('0x3d'))[_0x52a2('0x11')](_0x52a2('0x2c'));
                        $(_0x52a2('0x3d'))[_0x52a2('0x20')](_0x52a2('0x12'));
                        $(_0x52a2('0x3d'))[_0x52a2('0x7')](_0x52a2('0x2b'));
                        alert(_0x48bd25[_0x52a2('0x2f')]);
                        location['reload']();
                    }});
                return![];
            }
        });
        sendSMS = function () {
            var _0xae876 = $(_0x52a2('0x39'))['val']();
            var _0x2afb39 = _0x4af337 + _0x52a2('0x26') + _0xae876;
            var _0x4293ea = $(_0x52a2('0x21'))[_0x52a2('0x32')]();
            $[_0x52a2('0x2')]({'type': _0x52a2('0x8'), 'url': _0x2afb39, 'data': _0x52a2('0xf') + _0x4293ea + _0x52a2('0x2e') + $[_0x52a2('0x4')](_0x52a2('0x9')), 'beforeSend': function () {
                    $(_0x52a2('0x3b'))[_0x52a2('0xe')](_0x52a2('0x19'));
                }, 'success': function (_0x524fff) {
                    $(_0x52a2('0x3b'))['modal']('hide');
                    alert(_0x524fff);
                    location[_0x52a2('0x2a')]();
                }});
            return![];
        };
        sendPaymentReminder = function (_0x37ea41) {
            var _0x5f3007 = _0x4af337 + _0x52a2('0x18') + _0x37ea41;
            $[_0x52a2('0x2')]({'type': _0x52a2('0x1'), 'url': _0x5f3007, 'data': 'csrf_test_name=' + $[_0x52a2('0x4')]('csrf_cookie_name'), 'success': function (_0x51db3d) {
                    alert(_0x51db3d);
                    location[_0x52a2('0x2a')]();
                }});
            return![];
        };
        $(_0x52a2('0xd'))[_0x52a2('0x23')](function () {
            var _0x13a5b0 = _0x4af337 + _0x52a2('0x29') + $(_0x52a2('0x16'))['val']() + '/' + $(_0x52a2('0x27'))[_0x52a2('0x32')]();
            $[_0x52a2('0x2')]({'type': _0x52a2('0x1'), 'url': _0x13a5b0, 'dataType': _0x52a2('0x14'), 'data': _0x52a2('0x30') + $[_0x52a2('0x4')](_0x52a2('0x9')), 'success': function (_0x45ea15) {
                    alert(_0x45ea15[_0x52a2('0x2f')]);
                    location['reload']();
                }});
            return![];
        });
        $(_0x52a2('0x28'))[_0x52a2('0x23')](function () {
            var _0x115c54 = _0x4af337 + 'college/subjectmanagement/approveLoadOnline/' + $(_0x52a2('0x16'))[_0x52a2('0x32')]() + '/' + $(_0x52a2('0x27'))[_0x52a2('0x32')]() + '/' + $(_0x52a2('0x1c'))[_0x52a2('0x32')]() + '/' + $(_0x52a2('0x31'))[_0x52a2('0x32')]();
            $[_0x52a2('0x2')]({'type': 'GET', 'url': _0x115c54, 'dataType': _0x52a2('0x14'), 'data': _0x52a2('0x30') + $['cookie'](_0x52a2('0x9')), 'beforeSend': function () {
                    $(_0x52a2('0x3b'))[_0x52a2('0xe')](_0x52a2('0x19'));
                }, 'success': function (_0x36cbc8) {
                    $(_0x52a2('0x3b'))[_0x52a2('0xe')](_0x52a2('0x36'));
                    alert(_0x36cbc8[_0x52a2('0x2f')]);
                    location[_0x52a2('0x2a')]();
                }});
            return![];
        });
        var _0x4af337 = $(_0x52a2('0x17'))[_0x52a2('0x32')]();
        sendAdmissionRemark = function () {
            var _0x900432 = $(_0x52a2('0xa'))['val']();
            var _0x555ffe = $(_0x52a2('0x35'))['val']();
            var _0x42122e = $(_0x52a2('0x1c'))['val']();
            var _0x2963c5 = $('#semester')['val']();
            var _0x2d1976 = _0x4af337 + _0x52a2('0x0');
            $[_0x52a2('0x2')]({'type': 'POST', 'url': _0x2d1976, 'data': {'csrf_test_name': $[_0x52a2('0x4')](_0x52a2('0x9')), 'st_id': _0x900432, 'semester': _0x2963c5, 'school_year': _0x42122e, 'remarks': _0x555ffe}, 'success': function (_0x434336) {
                    alert(_0x434336);
                    location[_0x52a2('0x2a')]();
                }});
            return![];
        };
        sendRemarks = function () {
            var _0x5e9b9d = $(_0x52a2('0xa'))[_0x52a2('0x32')]();
            var _0x5d9dc5 = $(_0x52a2('0x1e'))[_0x52a2('0x32')]();
            var _0x41387c = $(_0x52a2('0x1c'))['val']();
            var _0x51cbc1 = $(_0x52a2('0x31'))[_0x52a2('0x32')]();
            var _0x3a1fd8 = $(_0x52a2('0x16'))[_0x52a2('0x32')]();
            var _0x300dc7 = _0x4af337 + _0x52a2('0x22');
            $[_0x52a2('0x2')]({'type': _0x52a2('0x8'), 'url': _0x300dc7, 'data': {'csrf_test_name': $[_0x52a2('0x4')](_0x52a2('0x9')), 'st_id': _0x5e9b9d, 'semester': _0x51cbc1, 'school_year': _0x41387c, 'remarks': _0x5d9dc5, 'adm_id': _0x3a1fd8}, 'success': function (_0x4b6563) {
                    alert(_0x4b6563);
                    location['reload']();
                }});
            return![];
        };
        removeSubject = function (_0x381251) {
            var _0x47b5d3 = $(_0x52a2('0x27'))[_0x52a2('0x32')]();
            var _0x47147f = parseInt($(_0x52a2('0x10'))[_0x52a2('0x11')]());
            _0x47147f -= parseInt($('#td_units_' + _0x381251)[_0x52a2('0x11')]());
            $(_0x52a2('0x10'))[_0x52a2('0x11')](_0x47147f);
            var _0x276a39 = _0x4af337 + _0x52a2('0x34');
            $[_0x52a2('0x2')]({'type': _0x52a2('0x8'), 'url': _0x276a39, 'dataType': _0x52a2('0x14'), 'data': {'csrf_test_name': $['cookie']('csrf_cookie_name'), 'user_id': _0x47b5d3, 'subject_id': _0x381251, 'school_year': $(_0x52a2('0x1c'))[_0x52a2('0x32')]()}, 'success': function (_0x3d4be5) {
                    if (_0x3d4be5[_0x52a2('0x15')] == !![]) {
                        $(_0x52a2('0x37') + _0x381251)[_0x52a2('0x25')]();
                    }
                    alert(_0x3d4be5[_0x52a2('0x2f')]);
                }});
            return![];
        };
    });
    function removeEnrollmentDetails(_0x2c97d3, _0x1465c7) {
        var _0x52c63b = $(_0x52a2('0x2d'))[_0x52a2('0x32')]();
        var _0x4bf6bc = _0x52c63b + _0x52a2('0x1b');
        var _0x2a3c75 = confirm(_0x52a2('0x24'));
        if (_0x2a3c75 == !![]) {
            $[_0x52a2('0x2')]({'type': _0x52a2('0x8'), 'url': _0x4bf6bc, 'data': {'adm_id': _0x2c97d3, 'school_year': _0x1465c7, 'csrf_test_name': $[_0x52a2('0x4')]('csrf_cookie_name')}, 'beforeSend': function () {
                    $(_0x52a2('0x33'))['show']();
                    $(_0x52a2('0x1f'))['html'](_0x52a2('0xb'));
                }, 'success': function (_0x1c52bd) {
                    alert(_0x1c52bd);
                    document[_0x52a2('0x3a')] = _0x52c63b + _0x52a2('0x38');
                }});
            return![];
        }
    }


    function readySkip(btn) {
        var st_id = $(btn).attr('st-id'),
                st_name = $(btn).attr('st-name'),
                modal = $("#skipEnrollment");
        console.info(st_name);
        modal.find("#stName").html(st_name);
        modal.find("#skipBtn").attr('st-id', st_id);
        modal.modal();
    }

    function skipEnrollment(btn) {
        var u_id = $('#user_id').val(),
                sy = $('#school_year').val(),
                st_id = $(btn).attr('st-id'),
                base = $("#base").val(),
                sem = $('#semester').val(),
                url = base + "college/enrollment/skipEnrollment";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                opt: 0,
                semester: sem,
                school_year: sy,
                user_id: u_id,
                stid: st_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            beforeSend: function ()
            {
                $('#loadingModal').modal('show');
            },
            success: function (data) {
                alert(data.msg);
                location.reload();
            }
        });
    }

//    function skipEnrollment(btn) {
//        var st_id = $(btn).attr('st-id'),
//                base = $("#base").val(),
//                url = base + "college/enrollment/skipEnrollment/1";
//        var sy = '<?php // echo $student->school_year        ?>';
////        alert(st_id + ' ' + sy);
//        $.ajax({
//            url: url,
//            type: "POST",
//            dataType: "JSON",
//            data: {
//                stid: st_id,
//                school_year: sy,
//                csrf_test_name: $.cookie('csrf_cookie_name')
//            },
//            beforeSend: function ()
//            {
//                $('#loadingModal').modal('show');
//            },
//            success: function (data) {
//                alert(data.msg);
//                location.reload();
//            }
//        });
//    }
</script>