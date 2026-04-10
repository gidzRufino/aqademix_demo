<?php

$plan = Modules::run('finance/getPlanByCourse', $this->session->details->grade_level_id, 0, $this->session->details->st_type, $this->session->details->school_year);
$charges = ($plan->fin_plan_id != '' ? Modules::run('finance/financeChargesByPlan', 0, $this->session->details->school_year, 0, $plan->fin_plan_id, $this->session->details->semester) : 0);
$loadedSubject = Modules::run('registrar/getOvrLoadSub', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
$student = Modules::run('college/enrollment/getStudentsInfo', $this->session->details->st_id, $this->session->details->semester, $this->session->school_year);
if ($this->session->details->status == 4):
    $msg = "Your application for enrollment undergoes an evaluation from the finance department because of past dues, but this will be quick so visit us often;";
elseif ($this->session->details->status == 3):
    $msg = "You can now proceed to the final steps of the enrollment procedure please click <a class='btn btn-xs btn-info' onclick='getFinDetails()' href='#'>Next</a> to proceed";
else:
    $msg = '';
endif;

$next_lvl = ($this->session->details->grade_level_id == 14 ? 1 : ($this->session->details->grade_level_id == 13 ? 13 : ($this->session->details->grade_level_id + 1)));
$receipt = Modules::run('college/enrollment/getUploadedReceipt', $student->st_id, $student->semester, $student->school_year);


$admissionRemarks = Modules::run('college/enrollment/getAdmissionRemarks', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
?>
<div id="studentDashboard" class="modal fade col-lg-6 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <?php //print_r($this->session->details)
        ?>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">
        <div class="modal-body clearfix">
            <!-- modal-body -->
            <div class="container">
                <ul class="timeline">
                    <?php if (!$student): ?>
                        <li id="registration">
                            <div class="timeline-icon pull-center">
                                <a href="javascript:;" style="color:rgb(58, 34, 165); border: 1px solid rgb(58, 34, 165); font-size: 20px;" title="Personal Information"><i class="fa fa-user" style="padding-top: 5px;"></i></a>
                            </div>
                            <div class="timeline-body">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <span>Click the Confirm button to proceed with enrollment for the next school year.</span>
                                        <br />
                                        <button class="btn btn-warning pull-right" onclick="" style="margin: 5px;">Abort</button>
                                        <button onclick='enrollStudent()' class="btn btn-success pull-right" style="margin: 5px;">CONFIRM </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li id="registration">
                            <div class="timeline-icon pull-center">
                                <a href="javascript:;" style="color:rgb(58, 34, 165); border: 1px solid rgb(58, 34, 165); font-size: 20px;" title="Personal Information"><i class="fa fa-user" style="padding-top: 5px;"></i></a>
                            </div>
                            <div class="timeline-body">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading clearfix">
                                                Student's Information
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <b>Personal Info</b><br />
                                                    <hr style="margin: 3px 0">
                                                    <div class="col-md-12">
                                                        <span><b>Name:</b> <?php echo strtoupper($student->firstname . " " . $student->lastname) ?></span><br />
                                                        <span><b>Address:</b> <?php echo strtoupper($student->street . ', ' . $student->barangay . ' ' . $student->mun_city . ', ' . $student->province . ', ' . $student->zip_code); ?></span><br />
                                                        <span><b>Contact #:</b> <?php echo $student->cd_mobile ?></span><br />
                                                        <span><b>Gender :</b> <?php echo $student->sex ?></span><br />
                                                        <span><b>Birthdate :</b> <?php echo date('F m, Y', strtotime($student->temp_bdate)) ?></span><br /><br />
                                                    </div>
                                                    <b>Family Info</b><br />
                                                    <hr style="margin: 3px 0">
                                                    <div class="col-md-6 col-xs-12">
                                                        <span><b>Father's Name:</b> <?php echo strtoupper($student->f_firstname . " " . $student->f_lastname) ?></span><br />
                                                        <span><b>Occupation:</b> <?php echo strtoupper($student->occupation) ?></span><br />
                                                        <span><b>Contact #:</b> <?php echo $student->f_mobile ?></span><br />
                                                    </div>
                                                    <div class="col-md-6 col-xs-12">
                                                        <span><b>Mother's Name:</b> <?php echo strtoupper($student->m_firstname . " " . $student->m_lastname) ?></span><br />
                                                        <span><b>Occupation:</b> <?php echo strtoupper($student->occupation) ?></span><br />
                                                        <span><b>Contact #:</b> <?php echo $student->m_mobile ?></span><br /><br />
                                                    </div>
                                                    <b>Emergency Contact Information</b><br />
                                                    <hr style="margin: 3px 0">
                                                    <div class="col-md-12">
                                                        <span><b>Name:</b> <?php echo strtoupper($student->ice_name) ?></span><br />
                                                        <span><b>Contact #:</b> <?php echo strtoupper($student->ice_contact) ?></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="payment-time">
                            <div class="timeline-icon pull-center">
                                <a href="javascript:;" style="color:rgb(172, 36, 36); border: 1px solid rgb(172, 36, 36); font-size: 13px;" title="Payment"><i class="fa fa-lg fa-money" style="padding-top: 10px;"></i></a>
                            </div>
                            <div class="timeline-body">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="pull-left">Finance Details</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-12">
                                                        <table class="table table-hover table-striped table-bordered">
                                                            <tr>
                                                                <th style="width:10%; ">#</th>
                                                                <th style="width:50%;">Particulars</th>
                                                                <th style="width:25%; text-align: right;">Amount</th>
                                                            </tr>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                $total = 0;
                                                                $amount = 0;
                                                                foreach ($charges as $c):
                                                                    $next = $c->school_year + 1;
                                                                ?>
                                                                    <tr id="tr_<?php echo $c->charge_id ?>">
                                                                        <td><?php echo $i++; ?></td>
                                                                        <td><?php echo $c->item_description ?></td>
                                                                        <td id="td_<?php echo $c->charge_id ?>" class="text-right">
                                                                            <?php echo number_format($c->amount, 2, '.', ',') ?></td>
                                                                    </tr>
                                                                    <?php
                                                                    $total += $c->amount;
                                                                    if ($c->item_id == 254839):
                                                                        $pf = $total - $c->amount;
                                                                    endif;
                                                                endforeach;

                                                                if ($total != 0):
                                                                    ?>
                                                                    <tr style="background:yellow;">
                                                                        <th colspan="2">TOTAL</th>
                                                                        <th class="text-right"><?php echo number_format($total, 2, '.', ',') ?></th>
                                                                    </tr>
                                                                    <tr class="wopta">
                                                                        <td colspan="2" id="interest_fee"></td>
                                                                        <td id="interest" style="text-align: right;"></td>
                                                                    </tr>
                                                                    <tr class="wopta">
                                                                        <th colspan="2" id="fee_total">TOTAL FEES</th>
                                                                        <th id="total_payables" style="text-align: right;"></th>
                                                                    </tr>
                                                                    <input type="hidden" id="tf" value="<?php echo $pf ?>" />
                                                                <?php endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <a onclick="$('#paymentCenter').modal('show')" class="pointer"><i class="fa fa-eye"></i> Click to view Details of Accredited Payment Centers</a>
                                                    </div>
                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="row wopta">
                                                            <div class="col-md-12" style="padding-top: 10px;">
                                                                <div class="panel panel-primary">
                                                                    <div class="panel-body" style="background-color: #d9edf7;">
                                                                        <div class="row">
                                                                            <div class="col-md-9">
                                                                                <span>[(TOTAL - PTA Fee) + Interest Fee]</span>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <span id="withoutPTA" class="pull-right"></span>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <span id="payment_option"></span>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <span id="monthly_payment" class="pull-right"></span>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <span>Down Payment</span>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <span class="down_payment pull-right"></span>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <span id="monthlyCalc"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // echo $student->orUpload . ' ' . $student->status . ' ->>> ' . ($student->orUpload != 1) . ' ' . ($student->status <= 3) . ' >>> ' . ($student->orUpload != 1 && $student->status <= 3);
                                                        if ($student->orUpload != 1 && $student->status <= 3):
                                                        ?>
                                                            <div class="panel panel-green" id="dp_phrase">
                                                                <div class="panel-body" style="background-color:rgb(106, 218, 134);">
                                                                    <div class="col-md-12" id="toPay">

                                                                    </div>
                                                                    <div class="col-md-12 col-xs-12" style="padding: 10px;" id="receiptUpload">
                                                                        <p class="text-center"> <i>Note: Please upload the payment receipt if the payment was made through an accredited payment center.</i></p><br />
                                                                        <button onclick="$('#uploadReceipt').modal('show')" class="btn btn-primary btn-lg pull-right"><i class="fa fa-upload"></i> Upload Receipt</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        else:
                                                            if ($receipt->num_rows() > 0):
                                                                foreach ($receipt->result() as $r):
                                                                    if ($r->is_or == 0 && $r->is_enrollment): ?>
                                                                        <div class="container mt-5">
                                                                            <div class="img-container">
                                                                                <img src="<?php echo base_url($r->opr_img_link) ?>" alt="Image" class="img-fluid" id="img-<?php echo $r->opr_id ?>">
                                                                                <div style="position: absolute; top: 40%; left: 30%; border: thin solid gray; border-radius: 25px; padding: 15px">
                                                                                    <?php if ($student->status <= 5 && $student->status != 1): ?>
                                                                                        <i class="fa fa-trash fa-lg pointer img-button" style="margin-left: 10px;" title="Delete Uploaded Receipt?" onmouseover="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'blur(3px)'})" onmouseout="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'none'})" onclick="$('#link').val('<?php echo base64_encode($r->opr_img_link) ?>'), $('#idImg').val('<?php echo $r->opr_id ?>'), $('#deleteConfirm').modal('show')"></i>
                                                                                    <?php endif ?>
                                                                                    <i class="fa fa-search fa-lg pointer img-button" title="View Receipt" onmouseover="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'blur(3px)'})" onmouseout="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'none'})" onclick="$('#viewImg').modal('show'), $('#imgThumbnail').attr('src', '<?php echo base_url($r->opr_img_link) ?>')"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br />
                                                        <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endif; ?>
                                                        <input type="hidden" id="imgSelected" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="payment-confirmation">
                            <div class="timeline-icon pull-center">
                                <a href="javascript:;" style="color:rgb(99, 147, 189); border: 1px solid rgb(99, 147, 189); font-size: 13px;" title="Payment Confirmation"><i class="fa fa-lg fa-credit-card" style="padding-top: 10px;"></i></a>
                            </div>
                            <div class="timeline-body">
                                <div class="panel panel-info">
                                    <div class="panel-heading clearfix">
                                        Payment Confirmation
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12" id="paymentConfirmed"></div>
                                            <div class="col-md-6 col-xs-12">
                                                <?php
                                                if ($receipt->num_rows() > 0):
                                                    foreach ($receipt->result() as $r):
                                                        if ($r->is_or == 1 && $r->is_enrollment && ($student->status >= 6 || $student->status == 1)): ?>
                                                            <div class="container mt-5">
                                                                <span class="text-center">Official Receipt</span><br><br>
                                                                <div class="img-container">
                                                                    <img src="<?php echo base_url($r->opr_img_link) ?>" alt="Image" class="img-fluid" id="img-<?php echo $r->opr_id ?>">
                                                                    <div style="position: absolute; top: 40%; left: 40%; border: thin solid gray; border-radius: 25px; padding: 15px">
                                                                        <i class="fa fa-search fa-lg pointer img-button" title="View Receipt" onmouseover="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'blur(3px)'})" onmouseout="$('#img-<?php echo $r->opr_id ?>').css({'filter': 'none'})" onclick="$('#viewImg').modal('show'), $('#imgThumbnail').attr('src', '<?php echo base_url($r->opr_img_link) ?>')"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br />
                                                <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="officialy-enrolled">
                            <div class="timeline-icon pull-center">
                                <a href="javascript:;" style="color: green; border: 1px solid green; font-size: 15px;" title="Officially Enrolled"><i class="fa fa-lg fa-award" style="padding-top: 9px;"></i></a>
                            </div>
                            <div class="timeline-body">
                                <div class="panel panel-success">
                                    <div class="panel-heading clearfix">
                                        Officially Enrolled
                                    </div>
                                    <div class="panel-body">
                                        <h3 style="color: green; text-align: center">Congratulations! You are now Officially Enrolled!</h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div> <!--end of modal-body -->
        <div class="modal-footer clearfix" style="display: none;" id="confirmGrp">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <button onclick="submitEnrollmentData()" style="margin: 0 auto" class="btn btn-small btn-success btn-block">CONFIRM</button><br />
                <button style="margin: 0 auto" class="btn btn-small btn-danger btn-block">CANCEL</button>
            </div>
        </div>
        <!-- <div class="modal-footer clearfix" style="display:<?php echo ($this->session->details->status == 0 ? 'none' : '') ?>;" id="confirmMsgWrapper">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="alert alert-info">
                    <p id="confirmMsg" class="text-center">
                        <?php echo $msg ?>
                    </p>
                    <button onclick="document.location='<?php echo base_url('enrollment') ?>'" class="btn btn-danger btn-xs">Close</button>
                </div>
            </div>
        </div> -->
    </div>
</div>

<div id="uploadReceipt" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-success" style="border-radius:15px 15px 0 0; ">
        Upload Payment Receipt
        <button class="btn btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px; border:1px solid #ccc; padding: 5px 10px 10px; overflow-y: scroll">
        <div class="modal-body">
            <form id="upload_form" enctype="multipart/form-data" method="post">
                <!-- <select class="form-control" id="payment_center">
                        <option>Select Payment Center</option> -->
                <?php
                // $pads = Modules::run('college/enrollment/getPadala');
                // foreach ($pads as $p):
                ?>
                <!-- <option value="<?php // echo $p->pc_short_name; 
                                    ?>"><?php // echo $p->pc_name; 
                                        ?></option> -->
                <?php
                // endforeach;
                ?>
                <!-- </select> -->
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

<div id="paymentCenter" class="modal fade col-lg-4 col-xs-10" style="margin:60px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-success" style="border-radius:15px 15px 0 0; ">
        Details of Accredited Payment Centers
        <button class="btn btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px; border:1px solid #ccc; padding: 5px 10px 10px; overflow-y: scroll">
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th colspan="2">Bank Name</th>
                    <th>Account Name</th>
                    <th>Account #</th>
                    <th>Contact #</th>
                </tr>
                <?php
                $pads = Modules::run('college/enrollment/getPadala', 1);
                foreach ($pads as $p):
                ?>
                    <tr>
                        <td><img pc-id="<?php echo $p->pc_id; ?>" pc-name="<?php echo $p->pc_name; ?>" pc-sn="<?php echo $p->pc_short_name; ?>" pc-type="<?php echo $p->pc_type; ?>" pc-acc-name="<?php echo $p->pc_account_name; ?>" pc-acc-no="<?php echo $p->pc_account_number; ?>" pc-branch="<?php echo $p->pc_branch; ?>" pc-contact="<?php echo $p->pc_contact_no; ?>" pc-status="<?php echo $p->pc_status; ?>" pc-logo="<?php echo ($p->pc_logo != null) ? $p->pc_logo : 'Select Logo'; ?>" class='pc_class' style="cursor: pointer; width: 50px; height: 50px;" onclick="showEditPadalaModal(this)" class="img img-thumbnail" src="<?php echo base_url() . 'images/banks/' . $p->pc_logo ?>" /></td>
                        <td><span><?php echo $p->pc_name; ?></span></td>
                        <td><?php echo $p->pc_account_name; ?></td>
                        <td><?php echo ($p->pc_type != 3) ? $p->pc_account_number : $p->pc_account_name; ?></td>
                        <td><?php echo $p->pc_contact_no; ?></td>
                    </tr>
                <?php
                endforeach;
                ?>
            </table>
        </div>
    </div>
</div>

<div id="viewImg" class="modal fade" style="margin:60px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body clearfix alert-success" style="border:green thick solid; border-radius: 25px">
        <button class="btn btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
        <img src="" id="imgThumbnail" style="width: 100%; height: 100%">
    </div>
</div>

<div id="deleteConfirm" class="modal fade col-lg-3 col-xs-8" style="margin:60px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body clearfix alert-danger" style="border:#ff5b57 thick solid; border-radius: 25px">
        <span class="text-center">Are you sure you want to delete the uploaded receipt?</span><br><br>
        <div class="pull-right" style="display: inline-block;">
            <button class="btn btn-success btn-sm" onclick="deleteOR()" data-dismiss="modal">Confirm</button>
            <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
            <input type="hidden" id="link" />
            <input type="hidden" id="idImg" />
        </div>
    </div>
</div>

<div id="alertModal" class="modal fade col-lg-3 col-xs-8" style="margin:60px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="alertBody" class="modal-body clearfix">
        <span id="alertMsg" class="text-center"></span><br><br>
        <div class="pull-right" style="display: inline-block;">
            <button class="btn btn-success btn-sm" onclick="location.reload()" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<input type="hidden" id="base" value="<?php echo base_url(); ?>" />
<input type="hidden" id="studentID" value="<?php echo base64_encode($this->session->details->st_id) ?>" />
<input type="hidden" id="year_level" value="<?php echo $this->session->details->grade_level_id ?>" />
<input type="hidden" id="previous_school_year" value="<?php echo $this->session->school_year ?>" />
<input type="hidden" id="previous_semester" value="<?php echo $this->session->semester ?>" />
<input type="hidden" id="user_id" value="<?php echo $this->session->details->user_id ?>" />

<div id="scheduleModal" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-info" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Please Select Schedule</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; overflow: scroll">
        <div id="schedBody" class="modal-body clearfix">
        </div>
    </div>
</div>

<div id="searchSubject" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-warning" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Search Subject</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
        <input class="form-control" onkeypress="if (event.keyCode == 13) {
                    searchSubjectOffered(this.value)
                }" name="studentNumber" type="text" id="studentNumber" placeholder="Search Subject Code and press enter" />
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;  box-shadow:3px 3px 5px 6px #ccc; ">
        <div id="searchBody" class="modal-body clearfix">
        </div>
    </div>
</div>

<script type="text/javascript">
    // var _0x3cc6=['#confirmGrp','ready','#units_','modal','subject_id','#scheduleModal','ajax','hidden.bs.modal','stringify','student/accounts','location','.modal:visible','remove','System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently','college/enrollment/searchBasicEdSubject/','#searchBody','body','each','val','select2','#tableSched\x20tr.trSched','csrf_cookie_name','#base','#previous_semester','<td\x20class=\x22text-center\x22>\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20onclick=\x22removeSubject(\x27','#schedBody','#tr_','#confirmMsg','st_id','#totalUnits','append','#previous_school_year','</td>','#studentID','json','#course_id','<tr\x20id=\x22tr_','show','college/enrollment/loadSchedule/','modal-open','#user_id','cookie','POST','\x22\x20\x20>','#schedDetails','#confirmMsgWrapper','#year_level','html','#subjectLoadBody','Please\x20Wait\x20while\x20system\x20is\x20submitting\x20your\x20request...','college/enrollment/getSubjectLoad/','push','<td>','length','log','hide','\x27)\x22\x20title=\x22remove\x20from\x20the\x20list\x22\x20class=\x22btn\x20btn-danger\x20btn-xs\x22><i\x20class=\x22fa\x20fa-trash\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</td>','#searchSubject','#inputSem','attr','\x22\x20class=\x22trSched\x22\x20subject_id=\x22','#btnConfirm','addClass','.modal'];(function(_0x4cec70,_0x3cc6f3){var _0x1ce321=function(_0x249076){while(--_0x249076){_0x4cec70['push'](_0x4cec70['shift']());}};_0x1ce321(++_0x3cc6f3);}(_0x3cc6,0x1a7));var _0x1ce3=function(_0x4cec70,_0x3cc6f3){_0x4cec70=_0x4cec70-0x0;var _0x1ce321=_0x3cc6[_0x4cec70];return _0x1ce321;};$(document)[_0x1ce3('0x1a')](function(){$(_0x1ce3('0x13'))[_0x1ce3('0x2c')]();$('#studentDashboard')[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$(_0x1ce3('0x18'))['on'](_0x1ce3('0x20'),function(_0x1ecda2){if($(_0x1ce3('0x24'))[_0x1ce3('0xe')]){$(_0x1ce3('0x29'))[_0x1ce3('0x17')](_0x1ce3('0x0'));}});});$(function(){var _0x2e071d=0x0;fetchSearchSubject=function(_0x25a345,_0x597026){var _0x5a45ae=0x0;$(_0x1ce3('0x2d'))[_0x1ce3('0x2a')](function(){if($(this)[_0x1ce3('0x14')](_0x1ce3('0x1d'))===_0x25a345){_0x5a45ae++;alert('Sorry\x20this\x20subject\x20already\x20exist');}});if(_0x5a45ae==0x0){$(_0x1ce3('0x9'))[_0x1ce3('0x37')](_0x1ce3('0x3d')+_0x25a345+_0x1ce3('0x15')+_0x25a345+_0x1ce3('0x4')+_0x1ce3('0xd')+_0x597026+_0x1ce3('0x39')+_0x1ce3('0x31')+_0x25a345+_0x1ce3('0x11')+ +'</tr>');}$(_0x1ce3('0x12'))[_0x1ce3('0x1c')]('hide');$(_0x1ce3('0x19'))[_0x1ce3('0x3e')]();};removeSubject=function(_0x4208bd){_0x2e071d-=$(_0x1ce3('0x1b')+_0x4208bd)['html']();$(_0x1ce3('0x36'))[_0x1ce3('0x8')](_0x2e071d);$(_0x1ce3('0x33')+_0x4208bd)[_0x1ce3('0x25')]();};submitEnrollmentData=function(){var _0x200aca=$('#base')[_0x1ce3('0x2b')]();var _0x4db8b6=$(_0x1ce3('0x30'))[_0x1ce3('0x2b')]();var _0x50ce7a=$(_0x1ce3('0x7'))['val']();var _0x3b812f=$(_0x1ce3('0x38'))['val']();var _0x43c5ec=$(_0x1ce3('0x3a'))[_0x1ce3('0x2b')]();var _0x26c7f8=$(_0x1ce3('0x1'))[_0x1ce3('0x2b')]();var _0xf841e0=_0x200aca+'college/enrollment/saveBasicRO/';$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0xf841e0,'data':{'year_level':_0x50ce7a,'school_year':_0x3b812f,'semester':_0x4db8b6,'st_id':_0x43c5ec,'user_id':_0x26c7f8,'csrf_test_name':$['cookie'](_0x1ce3('0x2e'))},'dataType':_0x1ce3('0x3b'),'beforeSend':function(){$(_0x1ce3('0x16'))[_0x1ce3('0x10')]();$(_0x1ce3('0x32'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x256cd3){if(_0x4db8b6==0x3){loadEnrollmentData(_0x256cd3[_0x1ce3('0x35')],_0x256cd3['user_id']);console[_0x1ce3('0xf')](_0x256cd3);}}});return![];};loadEnrollmentData=function(_0x175a16,_0x23fdc2){var _0x4f2bfa=[];$(_0x1ce3('0x2d'))[_0x1ce3('0x2a')](function(){var _0x414852={'sub_id':$(this)[_0x1ce3('0x14')](_0x1ce3('0x1d')),'level_id':$('#year_level')[_0x1ce3('0x2b')](),'st_id':_0x175a16,'is_overload':0x3,'sem':0x3};_0x4f2bfa[_0x1ce3('0xc')](_0x414852);});var _0x1df43e=JSON[_0x1ce3('0x21')](_0x4f2bfa);var _0x66f85a=$(_0x1ce3('0x38'))[_0x1ce3('0x2b')]();var _0x12917d=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0xed50e4=_0x12917d+'college/enrollment/saveBasicLoad';$['ajax']({'type':_0x1ce3('0x3'),'url':_0xed50e4,'data':{'enData':_0x1df43e,'semester':$(_0x1ce3('0x30'))['val'](),'school_year':_0x66f85a,'st_id':_0x175a16,'user_id':_0x23fdc2,'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x19'))[_0x1ce3('0x10')]();$(_0x1ce3('0x6'))[_0x1ce3('0x3e')]();$(_0x1ce3('0x34'))[_0x1ce3('0x8')](_0x1ce3('0xa'));},'success':function(_0x2ab571){$(_0x1ce3('0x34'))[_0x1ce3('0x8')]('You\x20have\x20Successfully\x20Submitted\x20your\x20application\x20for\x20enrollment,\x20We\x20will\x20notify\x20you\x20in\x20the\x20next\x2024\x20to\x2048\x20hours\x20once\x20your\x20subjects\x20are\x20approved.\x20Thank\x20you\x20for\x20using\x20this\x20online\x20system.');$('.action')[_0x1ce3('0x25')]();}});return![];};getSchedule=function(_0x171742){if(_0x171742!=0x0){var _0x48933f=$(_0x1ce3('0x3a'))[_0x1ce3('0x2b')]();var _0x5a124d=$(_0x1ce3('0x3c'))[_0x1ce3('0x2b')]();var _0x8d0786=$(_0x1ce3('0x7'))[_0x1ce3('0x2b')]();var _0x7b4edd=$('#previous_school_year')[_0x1ce3('0x2b')]();var _0x5e3ec9=$(_0x1ce3('0x2f'))['val']();var _0x41806e=_0x5e3ec9+_0x1ce3('0xb')+_0x48933f+'/'+_0x5a124d+'/'+_0x8d0786+'/'+_0x171742+'/'+_0x7b4edd;$[_0x1ce3('0x1f')]({'type':'POST','url':_0x41806e,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x5'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x34a6f0){$(_0x1ce3('0x5'))['html'](_0x34a6f0);if(_0x2e071d!=0x0){$(_0x1ce3('0x19'))['show']();}}});return![];}};searchSubjectOffered=function(_0x44dcf2){var _0xe8cd28=$(_0x1ce3('0x38'))['val']();var _0x127ba7=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0xb1d3ff=_0x127ba7+_0x1ce3('0x27')+_0x44dcf2+'/'+_0xe8cd28;$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0xb1d3ff,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x28'))['html'](_0x1ce3('0x26'));},'success':function(_0x1dbe42){$(_0x1ce3('0x28'))[_0x1ce3('0x8')](_0x1dbe42);}});return![];};});function hasTimeConflict(_0x18ac59,_0x4e9401,_0x166c68,_0x344e7d){var _0x233edf=timestamp(_0x18ac59);var _0x36c42d=timestamp(_0x4e9401);var _0x29adcd=timestamp(_0x166c68);var _0x542130=timestamp(_0x344e7d);if(_0x233edf>=_0x29adcd&&_0x233edf<_0x542130){return!![];}else if(_0x36c42d<_0x542130&&_0x36c42d>_0x542130){return!![];}else if(_0x233edf==_0x29adcd){return!![];}else{return![];}}function getFinDetails(){var _0x2f54b7=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0x4c8001=_0x2f54b7+_0x1ce3('0x22');document[_0x1ce3('0x23')]=_0x4c8001;}function modalControl(_0x391088,_0x2dc8b0){$('#'+_0x391088)[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$('#'+_0x2dc8b0)[_0x1ce3('0x1c')](_0x1ce3('0x10'));}function loadSchedule(_0x34e9be){var _0x189932=$(_0x1ce3('0x13'))['val']();var _0x5a4577=$(_0x1ce3('0x38'))[_0x1ce3('0x2b')]();var _0x12d0da=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0x4573cb=_0x12d0da+_0x1ce3('0x3f')+_0x34e9be+'/'+_0x189932+'/'+_0x5a4577;$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0x4573cb,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x32'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x2b9c03){$(_0x1ce3('0x1e'))[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$(_0x1ce3('0x32'))[_0x1ce3('0x8')](_0x2b9c03);}});return![];}
    $(document).ready(function() {
        $('#inputStudentTermsOfPayment').select2();
        $('#inputSem').select2();
        $('#studentDashboard').modal('show');

        $('.modal').on("hidden.bs.modal", function(e) { //fire on closing modal box
            if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
                $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
            }
        });
        //hasTimeConflict('08:30','10:30','07:30','11:30');
        var top = '<?php echo $student->st_top ?>';
        var status = '<?php echo $student->status ?>';
        // getCalculation($('#inputStudentTermsOfPayment').val());
        getCalculation(top);

        showHideLI(status);

        (top == 0 ? $('.wopta').hide() : $('.wopta').show());
        $('html,body').animate({
            scrollTop: document.body.scrollHeight
        }, "fast");
    });

    function scrollToBottom() {
        window.scrollTo(0, document.body.scrollHeight);
    }
    history.scrollRestoration = "manual";
    window.onload = scrollToBottom;

    function showHideLI(status) {
        switch (status) {
            case '0':
                $('#registration').show();
                $('#payment-time').hide();
                $('#payment-confirmation').hide();
                $('#officialy-enrolled').hide();
                break;
            case '3':
                $('#registration').show();
                $('#payment-time').show();
                $('#payment-confirmation').hide();
                $('#officialy-enrolled').hide();
                break;
            case '5':
                $('#registration').show();
                $('#payment-time').show();
                $('#payment-confirmation').show();
                $('#paymentConfirmed').html('<p>Thank you for your payment. Please wait for confirmation.</p>');
                $('#officialy-enrolled').hide();
                break;
            case '6':
                $('#registration').show();
                $('#payment-time').show();
                $('#payment-confirmation').show();
                $('#paymentConfirmed').html(
                    '<p style="color:rgb(99, 147, 189); margin: 15%; text-align: center; font-size: 25px">Payment Confirmed! Please wait for the registrar\'s evaluation! </p>' +
                    '<p style="color:rgb(26, 202, 20); text-align: center;">Reminder: You may request a hard copy of the original receipt from the cashier\'s office. Thank you!</p>'
                );
                $('#officialy-enrolled').hide();
                break;
            case '1':
                $('#registration').show();
                $('#payment-time').show();
                $('#payment-confirmation').show();
                $('#paymentConfirmed').html(
                    '<p style="color:rgb(99, 147, 189); margin: 15%; text-align: center; font-size: 25px">Payment Confirmed! Please wait for the registrar\'s evaluation! </p>' +
                    '<p style="color:rgb(26, 202, 20); text-align: center;">Reminder: You may request a hard copy of the original receipt from the cashier\'s office. Thank you!</p>'
                );
                $('#officialy-enrolled').show();
        }
    }

    $(function() {

        var totalUnits = 0;

        fetchSearchSubject = function(subject_id, subject) {
            var exist = 0;
            $('#tableSched tr.trSched').each(function() {
                //alert($(this).attr('id'))
                if ($(this).attr('subject_id') === subject_id) {
                    exist++;
                    alert('Sorry this subject already exist');
                }
            });


            if (exist == 0) {
                $('#subjectLoadBody').append(
                    '<tr id="tr_' + subject_id + '" class="trSched" subject_id="' + subject_id + '"  >' +
                    '<td>' + subject + '</td>' +
                    '<td class="text-center"> \n\
                            <button onclick="removeSubject(\'' + subject_id + '\')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>\n\
                        </td>' +
                    +'</tr>'
                );
            }

            $('#searchSubject').modal('hide');
            $('#confirmGrp').show();

        };


        removeSubject = function(sub_id) {
            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);
            $('#tr_' + sub_id).remove();
        };

        submitEnrollmentData = function() {
            var base = $('#base').val();
            var semester = $('#previous_semester').val();
            var year_level = $('#year_level').val();
            var school_year = $('#previous_school_year').val();
            var st_id = $('#studentID').val();
            var user_id = $('#user_id').val();

            var url = base + 'college/enrollment/saveBasicRO/'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    year_level: year_level,
                    school_year: school_year,
                    semester: semester,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function() {
                    $('#btnConfirm').hide();
                    $('#schedBody').html('System is processing...Thank you for waiting patiently');
                },
                success: function(data) {
                    if (semester === '3') {
                        loadEnrollmentData(data.st_id, data.user_id);
                        console.log(data)
                    } else {
                        $('#confirmMsgWrapper').show();
                        $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    }

                }
            });

            return false;

        };

        loadEnrollmentData = function(st_id, user_id) {
            var enrollmentDetails = [];
            $('#tableSched tr.trSched').each(function() {
                var id = {
                    'sub_id': $(this).attr('subject_id'),
                    'level_id': $('#year_level').val(),
                    'st_id': st_id,
                    'is_overload': 3,
                    'sem': 3
                };
                enrollmentDetails.push(id);
            });

            var enrollmentData = JSON.stringify(enrollmentDetails);
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/saveBasicLoad';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    enData: enrollmentData,
                    semester: $('#previous_semester').val(),
                    school_year: school_year,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function() {
                    $('#confirmGrp').hide();
                    $('#confirmMsgWrapper').show();
                    $('#confirmMsg').html('Please Wait while system is submitting your request...');

                },
                success: function(data) {
                    $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    $('.action').remove();

                    //alert(data);
                }
            });

            return false;

        }


        getSchedule = function(sem) {
            if (sem != 0) {
                var st_id = $('#studentID').val();
                var course_id = $('#course_id').val();
                var year_level = $('#year_level').val();
                var school_year = $('#previous_school_year').val();
                var base = $('#base').val();

                var url = base + 'college/enrollment/getSubjectLoad/' + st_id + '/' + course_id + '/' + year_level + '/' + sem + '/' + school_year; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name'),

                    }, // serializes the form's elements.
                    // dataType:'json',
                    beforeSend: function() {
                        $('#schedDetails').html('System is processing...Thank you for waiting patiently')
                    },
                    success: function(data) {
                        $('#schedDetails').html(data);
                        if (totalUnits != 0) {
                            $('#confirmGrp').show();
                        }
                    }
                });

                return false;
            }

        }



        searchSubjectOffered = function(value) {
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/searchBasicEdSubject/' + value + '/' + school_year; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                }, // serializes the form's elements.
                // dataType:'json',
                beforeSend: function() {
                    $('#searchBody').html('System is processing...Thank you for waiting patiently')
                },
                success: function(data) {
                    $('#searchBody').html(data);

                }
            });

            return false;

        };



    });

    function hasTimeConflict(timeFrom, timeTo, dbFrom, dbTo) {
        var cf = timestamp(timeFrom);
        var ct = timestamp(timeTo);
        var tf = timestamp(dbFrom);
        var tt = timestamp(dbTo);

        if (cf >= tf && cf < tt) {
            //alert('conflict 1');
            return true;
        } else if (ct < tt && ct > tt) {
            //alert('conflict 2');
            return true;

        } else if (cf == tf) {
            //alert('conflict 3');
            return true;
        } else {
            //alert('time is available');
            return false;
        }

    }

    function getFinDetails() {
        var base = $('#base').val();
        var url = base + 'student/accounts'; // the script where you handle the form input.
        document.location = url;
    }

    function modalControl(open, close) {
        $('#' + open).modal('show');
        $('#' + close).modal('hide');
    }

    function loadSchedule(s_id) {
        var semester = $('#inputSem').val();
        var school_year = $('#previous_school_year').val();
        var base = $('#base').val();
        var url = base + 'college/enrollment/loadSchedule/' + s_id + '/' + semester + '/' + school_year; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),

            }, // serializes the form's elements.
            // dataType:'json',
            beforeSend: function() {
                $('#schedBody').html('System is processing...Thank you for waiting patiently')
            },
            success: function(data) {
                $('#scheduleModal').modal('show');
                $('#schedBody').html(data);
            }
        });

        return false;

    }

    function setStudentType(val, opt, opt2) {
        var fee = $('#tf').val();
        var sem = '<?php echo $this->session->details->semester ?>';
        var admission_id = '<?php echo $this->session->details->admission_id ?>';
        var user_id = '<?php echo $this->session->details->user_id ?>';
        var school_year = '<?php echo $this->session->details->school_year ?>';
        var dept = '<?php echo $student->deptCode ?>';
        var interest = 0;
        var tp = 0
        var po = '';
        var dp = 0;
        var monthly = 0;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/setStudentType' ?>',
            //dataType: 'json',
            data: {
                opt: opt,
                school_year: school_year,
                st_type: val,
                admission_id: admission_id,
                user_id: user_id,
                fee: fee,
                sem: sem,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                getCalculation(val);
            }

        });
    }

    function getCalculation(val) {
        var fee = $('#tf').val();
        var dept = '<?php echo $student->deptCode ?>';
        var interest = 1;
        var tp = 0
        var po = '';
        var dp = 0;
        var monthly = 0;
        var gain = '';
        var nom = 0; // Number of months to pay

        switch (val) {
            case '1':
                interest = parseInt(fee) * 0.12;
                po = 'MONTHLY Payment';
                gain = 'Interest: [ ( TOTAL - PTA Fee ) x 12% ]';
                nom = 9;
                if (dept == 11) {
                    dp = (2500).toFixed(2);
                    monthly = (((parseFloat(fee) + parseFloat(interest)) - dp) / 9).toFixed(2);
                } else {
                    dp = ((parseFloat(fee) + parseFloat(interest)) / 10).toFixed(2);
                    monthly = dp;
                }
                $('#dp_phrase').show();
                $('#toPay').html('The terms of payment selected requires a downpayment amounting <b class="down_payment"></b>. Please pay to the school cashier or any accredited payment center')
                $('#receiptUpload').show();
                $('#noDP').hide();
                break;
            case '2':
                interest = parseInt(fee) * 0.08;
                po = 'QUARTERLY Payment';
                gain = 'Interest: [ ( TOTAL - PTA Fee ) x 8% ]';
                nom = 3;
                if (dept == 11) {
                    dp = (4500).toFixed(2);
                    monthly = (((parseFloat(fee) + parseFloat(interest)) - dp) / 3).toFixed(2);
                } else {
                    dp = ((parseFloat(fee) + parseFloat(interest)) / 4).toFixed(2);
                    monthly = dp;
                }
                $('#dp_phrase').show();
                $('#toPay').html('The terms of payment selected requires a downpayment amounting <b class="down_payment"></b>. Please pay to the school cashier or any accredited payment center')
                $('#receiptUpload').show();
                $('#noDP').hide();
                break;
            case '3':
                interest = parseInt(fee) * 0.04;
                po = 'Semi Annual Payment';
                gain = 'Interest: [ ( TOTAL - PTA Fee ) x 4% ]';
                dp = (0).toFixed(2);
                monthly = ((parseFloat(fee) + parseFloat(interest)) / 2).toFixed(2);
                nom = 2;
                $('#dp_phrase').show();
                $('#toPay').html('Please pay the amount of <b>P' + parseFloat(monthly).toFixed(2).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b> to the school cashier or any accredited payment center')
                $('#receiptUpload').show();
                $('#noDP').show();
                break;
            case '0':
                interest = 0;
                dp = (0).toFixed(2);
                monthly = (0).toFixed(2);
                $('#dp_phrase').show();
                po = 'Cash Payment';
                $('#toPay').html('Please pay the amount of <b>P' + (parseFloat(fee) + parseFloat(500)).toFixed(2).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b> to the school cashier or any accredited payment center')
                $('#receiptUpload').show();
                $('#noDP').show();
                break;
        }

        tp = (parseFloat(fee) + parseFloat(interest) + parseFloat(500)).toFixed(2);
        // $(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        if (val == 0) {
            $('#total_payables').text('');
            $('#fee_total').hide();
            $('#interest').text('');
            $('.wopta').hide();
        } else {
            $('#fee_total').show();
            $('#total_payables').text((tp).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#interest').text((interest).toFixed(2).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('.wopta').show();
        }

        $('.down_payment').text(dp.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#payment_option').text(po);
        $('#monthly_payment').text(monthly.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#interest_fee').text(gain);
        $('#withoutPTA').text((parseFloat(tp) - parseFloat(500)).toFixed(2).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#monthlyCalc').text(dp.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' (DP) + ' + monthly.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' (' + nom + ') = ' + (parseFloat(tp) - parseFloat(500)).toFixed(2).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        // fee_total
    }

    function uploadFile() {
        var file = document.getElementById("userfile").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('st_id', '<?php echo base64_encode($this->session->details->st_id) ?>');
        formdata.append('department', '<?php echo $this->session->department ?>');
        formdata.append('school_year', '<?php echo $this->session->school_year ?>');
        formdata.append('semester', $('#semester').val());
        formdata.append('paymentCenter', $('#payment_center').val());
        formdata.append('isEnrollment', '<?php echo $this->session->isEnrollment ?>');
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo base_url() . 'college/enrollment/uploadPaymentReceipt/' ?>");
        ajax.send(formdata);
    }

    function progressHandler(event) {
        $('#progressBarWrapper').show();
    }


    function completeHandler(event) {
        // _("status").innerHTML = event.target.responseText;
        $("#progressBarWrapper").hide();
        $('#alertModal').modal('show');
        $('#alertBody').addClass('alert-success');
        $('#alertBody').css({
            'border': 'green thick solid',
            'border-radius': '25px'
        });
        $('#alertMsg').text(event.target.responseText);
        // alert(event.target.responseText);
        // location.reload();
        // document.location = '<?php // echo base_url('enrollment'); 
                                ?>';
    }

    function errorHandler(event) {
        // _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event) {
        //  _("status").innerHTML = "Upload Aborted";
    }

    function enrollStudent() {
        var grade_id = '<?php echo $next_lvl ?>';
        var section_id = '';
        var st_id = '<?php echo $this->session->details->st_id ?>';
        var strand_id = '<?php echo $this->session->details->str_id ?>';
        var prev_sy = '<?php echo $this->session->details->school_year ?>';
        var semester = 0;
        var url = '<?php echo base_url() . 'registrar/saveOnlineRO/' ?>';

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "grade_id=" + grade_id + '&section_id=' + section_id + '&st_id=' + st_id + '&strand_id=' + strand_id + '&school_year=' + prev_sy + '&sem=' + semester + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data.remarks);
                location.reload()
                //console.log(data)
            }
        });
    }

    function deleteOR() {
        var link = $('#link').val();
        var id = $('#idImg').val();
        var st_id = $('#studentID').val();
        var sy = $('#previous_school_year').val();
        var url = '<?php echo base_url() . 'college/enrollment/deleteOR' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'id=' + id + '&link=' + link + '&st_id=' + st_id + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function(data) {
                if (data) {
                    //  style="border:#ff5b57 thick solid; border-radius: 25px"
                    if (data.status == true) {
                        $('#alertModal').modal('show');
                        $('#alertBody').addClass('alert-success');
                        $('#alertBody').css({
                            'border': 'green thick solid',
                            'border-radius': '25px'
                        });
                        $('#alertMsg').text(data.msg);
                    } else {
                        $('#alertModal').modal('show');
                        $('#alertBody').addClass('alert-danger');
                        $('#alertBody').css({
                            'border': '#ff5b57 thick solid',
                            'border-radius': '25px'
                        });
                        $('#alertMsg').text(data.msg);
                    }
                } else {
                    alert('An Error Occured');
                }
            }
        })
    }
</script>

<style type="text/css">
    .timeline {
        list-style-type: none;
        margin: 0;
        padding: 0;
        position: relative
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 5px;
        bottom: 5px;
        width: 5px;
        background: rgb(206, 208, 211);
        left: 0%;
        margin-left: -2.5px
    }

    .timeline>li {
        position: relative;
        min-height: 50px;
        padding: 20px 0
    }

    .timeline .timeline-time {
        position: absolute;
        left: 0;
        width: 18%;
        text-align: right;
        top: 30px
    }

    .timeline .timeline-time .date,
    .timeline .timeline-time .time {
        display: block;
        font-weight: 600
    }

    .timeline .timeline-time .date {
        line-height: 16px;
        font-size: 12px
    }

    .timeline .timeline-time .time {
        line-height: 24px;
        font-size: 20px;
        color: #242a30
    }

    .timeline .timeline-icon {
        left: -5%;
        position: absolute;
        width: 10%;
        text-align: center;
        top: 40px
    }

    .timeline .timeline-icon a {
        text-decoration: none;
        width: 35px;
        height: 35px;
        display: inline-block;
        border-radius: 20px;
        background: #d9e0e7;
        line-height: 10px;
        color: #fff;
        font-size: 14px;
        /* border: 1px solid #2d353c; */
        transition: border-color .2s linear
    }


    .timeline .timeline-body {
        margin-left: 3%;
        margin-right: 23%;
        /* background: #deeaee; */
        position: relative;
        padding: 20px 25px;
        border-radius: 6px;
        /* border-left: 5px solid rgb(206, 208, 211); */
        /* border-bottom: 1px solid rgb(206, 208, 211); */
    }

    @media screen and (max-width: 800px) {
        .timeline .timeline-body {
            margin-right: 0%;
        }
    }

    .timeline .timeline-body:before {
        content: '';
        display: block;
        position: absolute;
        border: 10px solid transparent;
        border-right-color: #deeaee;
        left: -20px;
        top: 20px;
        border: 1px solid #2d353c;
    }

    .timeline .timeline-body>div+div {
        margin-top: 15px
    }

    .timeline .timeline-body>div+div:last-child {
        margin-bottom: -20px;
        padding-bottom: 20px;
        border-radius: 0 0 6px 6px
    }

    .timeline-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e7eb;
        line-height: 30px
    }

    .timeline-header .userimage {
        float: left;
        width: 34px;
        height: 34px;
        border-radius: 40px;
        overflow: hidden;
        margin: -2px 10px -2px 0
    }

    .timeline-header .username {
        font-size: 16px;
        font-weight: 600
    }

    .timeline-header .username,
    .timeline-header .username a {
        color: #2d353c
    }

    .timeline img {
        max-width: 100%;
        display: block
    }

    .timeline-content {
        letter-spacing: .25px;
        line-height: 18px;
        font-size: 13px
    }

    .timeline-content:after,
    .timeline-content:before {
        content: '';
        display: table;
        clear: both
    }

    .timeline-title {
        margin-top: 0
    }

    .timeline-footer {
        background: #fff;
        border-top: 1px solid #e2e7ec;
        padding-top: 15px
    }

    .timeline-footer a:not(.btn) {
        color: #575d63
    }

    .timeline-footer a:not(.btn):focus,
    .timeline-footer a:not(.btn):hover {
        color: #2d353c
    }

    .timeline-likes {
        color: #6d767f;
        font-weight: 600;
        font-size: 12px
    }

    .timeline-likes .stats-right {
        float: right
    }

    .timeline-likes .stats-total {
        display: inline-block;
        line-height: 20px
    }

    .timeline-likes .stats-icon {
        float: left;
        margin-right: 5px;
        font-size: 9px
    }

    .timeline-likes .stats-icon+.stats-icon {
        margin-left: -2px
    }

    .timeline-likes .stats-text {
        line-height: 20px
    }

    .timeline-likes .stats-text+.stats-text {
        margin-left: 15px
    }

    .timeline-comment-box {
        background: #f2f3f4;
        margin-left: -25px;
        margin-right: -25px;
        padding: 20px 25px
    }

    .timeline-comment-box .user {
        float: left;
        width: 34px;
        height: 34px;
        overflow: hidden;
        border-radius: 30px
    }

    .timeline-comment-box .user img {
        max-width: 100%;
        max-height: 100%
    }

    .timeline-comment-box .user+.input {
        margin-left: 44px
    }

    .lead {
        margin-bottom: 20px;
        font-size: 21px;
        font-weight: 300;
        line-height: 1.4;
    }

    .text-danger,
    .text-red {
        color: #ff5b57 !important;
    }

    .img-container {
        position: relative;
        display: inline-block;
        max-width: 300px;
    }

    .img-button {
        /* position: absolute;
        top: 40%;
        left: 40%; */
        color: gray;
        border-radius: 60%;
        transition: transform .2s;
        padding: 10px;
        border: 1px solid gray;
    }

    .img-button:hover {
        -ms-transform: scale(1.5);
        /* IE 9 */
        -webkit-transform: scale(1.5);
        /* Safari 3-8 */
        transform: scale(1.5);
        color: red;
        border: 1px solid red;
    }
</style>