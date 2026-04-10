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
?>
<div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">

    <?php
    foreach ($children as $ch):
        if ($ch != ''):
            $isEnrolled = Modules::run('registrar/isEnrolled', $ch, $this->session->school_year);
            if (!$isEnrolled):
                $school_year = $this->session->userdata('school_year') - 1;
            else:
                $school_year = $this->session->userdata('school_year');
            endif;
            $childDepartment = Modules::run('registrar/getStudentDepartment', $ch, $school_year);
            if ($childDepartment == 'basic'):
                $student = Modules::run('registrar/getSingleStudent', $ch, $school_year);
                $adviser = Modules::run('academic/getAdvisory', NULL, $school_year, $student->section_id);
    ?>

                <div class="card" style="padding: 5px">
                    <div class="card-header bg-gradient-lightblue card-collapse">
                        <div class="row">
                            <div class="col-md-2">
                                <img class="img-circle img-responsive" style="width: 50px; border: 1px; margin: 10px"
                                    src="<?php
                                            if ($student->avatar != ""):
                                                echo base_url() . 'uploads/' . $student->avatar;
                                            else:
                                                echo base_url() . 'uploads/noImage.png';
                                            endif;
                                            ?>">
                            </div>
                            <div class="col-md-9">
                                <span id="name" class="pull-right" style="color:#FFF;"><?php echo strtoupper($student->firstname . " " . $student->lastname) ?></span><br>
                                <span><?php echo $student->level ?> - <?php echo $student->section ?></span><br>
                                <span><?php echo $student->st_id ?></span>
                            </div>
                            <div class="col-md-1 pointer">
                                <span class="clickable"><i class="fa fa-4x fa-angle-down"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <?php
                                $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);

                                $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
                                $addCharge = Modules::run('college/finance/financeChargesByPlan', NULL, $student->school_year, $student->semester);

                                $financeAccount = Modules::run('finance/getFinanceAccount', $student->st_id);
                                ?>
                                <div class='card card-warning'>
                                    <div class='card-header clearfix'>
                                        <h5 class="pull-left">Finance Details</h5>
                                    </div>
                                    <div class='card-body'>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%;">#</th>
                                                    <th style="width:50%;">Particulars</th>
                                                    <th style="width:40%; text-align: right;">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="finChargesBody">
                                                <?php
                                                $i = 1;
                                                $total = 0;
                                                $amount = 0;
                                                foreach ($charges as $c):
                                                    if (!$c->is_fused):
                                                        $next = $c->school_year + 1;
                                                        if ($student->grade_id == 12 || $student->grade_id == 13):
                                                            if ($student->st_type != 2):
                                                ?>
                                                                <tr id="tr_<?php echo $c->charge_id ?>">
                                                                    <td><?php echo $i++; ?></td>
                                                                    <td><?php echo $c->item_description ?></td>
                                                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.', ',') ?></td>
                                                                </tr>

                                                                <?php
                                                                $total += $c->amount;
                                                            else:
                                                                if ($c->item_description != 'Tuition Fee' && $c->item_description != 'Misc Fee'):
                                                                ?>

                                                                    <tr id="tr_<?php echo $c->charge_id ?>">
                                                                        <td><?php echo $i++; ?></td>
                                                                        <td><?php echo $c->item_description ?></td>
                                                                        <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.', ',') ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $total += $c->amount;
                                                                endif;
                                                            endif;
                                                        else:
                                                            ?>
                                                            <tr id="tr_<?php echo $c->charge_id ?>">
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo $c->item_description ?></td>
                                                                <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.', ',') ?></td>
                                                            </tr>

                                                    <?php
                                                            $total += $c->amount;
                                                        endif;
                                                    else:
                                                        $fusedCharges += $c->amount;

                                                    endif;
                                                endforeach;
                                                $total += $fusedCharges;
                                                if ($fusedCharges != 0):
                                                    ?>
                                                    <tr id="fused">
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo 'OTHER FEES' ?></td>
                                                        <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($fusedCharges, 2, '.', ',') ?></td>
                                                    </tr>
                                                    <?php
                                                endif;
                                                $totalExtra = 0;
                                                $extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->u_id, $student->semester, $student->school_year);
                                                if ($extraCharges->num_rows() > 0):
                                                    foreach ($extraCharges->result() as $ec):
                                                        if ($ec->pcs > 1):
                                                            $perPcs = $ec->amount / $ec->pcs;
                                                            $multiple = '     ( ' . $ec->pcs . 'pcs x ' . number_format($perPcs, 2, '.', ',') . ' )';
                                                        else:
                                                            $multiple = '';
                                                        endif;
                                                    ?>
                                                        <tr data-toggle="context" data-target="#extraMenu" onmouseover="$('#delete_trans_id').val('<?php echo $ec->extra_id ?>')" style="background: #0ff !important;" id="trExtra_<?php echo $ec->extra_id ?>"
                                                            delete_remarks="Extra Charges for <?php echo $ec->item_description ?> voided: [Amount :<?php echo number_format($ec->extra_amount, 2, '.', ',') ?>]">
                                                            <td style="background: #0ff !important;"><?php echo $i++; ?></td>
                                                            <td style="background: #0ff !important;"><?php echo $ec->item_description ?><span class="pull-right"><?php echo $multiple ?></td>
                                                            <td style="background: #0ff !important;" id="td_<?php echo $ec->extra_id ?>" class="text-right"><?php echo number_format($ec->extra_amount, 2, '.', ',') ?></td>
                                                        </tr>
                                                    <?php
                                                        $totalExtra += $ec->extra_amount;
                                                    endforeach;
                                                    $total = $total + $totalExtra;
                                                endif;

                                                if ($total != 0):
                                                    ?>
                                                    <tr style="background:yellow;">
                                                        <th colspan="2">TOTAL</th>
                                                        <th class="text-right"><?php echo number_format($total, 2, '.', ',') ?></th>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class='card card-success'>
                                    <div class='card-header clearfix'>
                                        <h5>Payment/Discount History</h5>
                                    </div>
                                    <div class='card-body'>
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <th style="width:10%;">Date</th>
                                                <th style="width:10%;">OR #</th>
                                                <th style="width:30%;">Particulars</th>
                                                <th style="width:20%; text-align: right;">Payment/Discounts</th>
                                                <th style="width:20%; text-align: right;">Balance</th>
                                                <th style="width:20%; text-align: right;">Remarks</th>
                                            </tr>
                                            <tbody id="finTransBody">
                                                <tr>
                                                    <td></td>
                                                    <td>-</td>
                                                    <td>Total Charge</td>
                                                    <td colspan="2"></td>
                                                    <td style="width:20%; text-align: right;"><?php echo number_format($total, 2, '.', ',') ?></td>
                                                </tr>
                                                <?php
                                                $transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);

                                                $paymentTotal = 0;
                                                $i = 1;
                                                if ($transaction->num_rows() > 0):
                                                    $balance = 0;
                                                    foreach ($transaction->result() as $tr):
                                                        if ($tr->t_type != 3):
                                                            $i++;
                                                ?>
                                                            <tr data-toggle="context" data-target="#otherMenu" onmouseover="$('#delete_trans_type').val('<?php echo $tr->t_type ?>'), $('#delete_trans_id').val('<?php echo $tr->trans_id ?>'), $('#delete_item_id').val('<?php echo $tr->t_charge_id ?>')">
                                                                <td style="width:20%;"><?php echo $tr->t_date ?></td>
                                                                <?php
                                                                $total = $total - $tr->t_amount;
                                                                if ($tr->t_type == 2):
                                                                    $discounts = Modules::run('finance/getDiscountsById', $tr->disc_id);
                                                                    if ($discounts->disc_type == 0):

                                                                    else:

                                                                    endif;
                                                                ?>
                                                                    <td id="td_trans_<?php echo $tr->trans_id ?>"
                                                                        delete_remarks="[ Discount type: <?php echo $tr->item_description . ' - ' . $discounts->disc_remarks ?>, Amount:<?php echo number_format($tr->t_amount, 2, '.', ',') ?>]"

                                                                        style="width:30%"></td>
                                                                    <td style="width:40%;"><?php echo $discounts->schlr_type ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo '( ' . number_format($tr->t_amount, 2, '.', ',') . ' )' ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format(($total), 2, '.', ',') ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo $discounts->disc_remarks ?></td>
                                                                <?php
                                                                else:
                                                                ?>
                                                                    <td id="td_trans_<?php echo $tr->trans_id ?>"
                                                                        delete_remarks="Payment Transaction voided: [Amount :<?php echo number_format($tr->t_amount, 2, '.', ',') ?>, Date: <?php echo date('F d, Y', strtotime($tr->t_date)) ?>]" style="width:10%;"><?php echo $tr->ref_number ?></td>
                                                                    <td style="width:40%;"><?php echo ($tr->fused_category == 0 ? $tr->item_description : $tr->fin_category) ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format($tr->t_amount, 2, '.', ',') ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format(($total), 2, '.', ',') ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo $tr->t_remarks ?></td>
                                                                <?php
                                                                endif;
                                                                $paymentTotal = $total;
                                                                ?>

                                                            </tr>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                    if ($paymentTotal != 0):
                                                        ?>
                                                        <tr style="background:yellow;">
                                                            <th style="background:yellow;" colspan="2">Running Balance</th>
                                                            <th style="background:yellow;"></th>
                                                            <th style="background:yellow;"></th>
                                                            <th style="background:yellow;" class="text-right"><?php echo number_format($paymentTotal, 2, '.', ',') ?></th>

                                                        </tr>
                                                <?php
                                                    endif;
                                                endif;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        History of Uploaded and Confirmed Receipts / Deposit Slips
                                        <button onclick="$('#uploadReceipt').modal('show')" class="float-right btn btn-success btn-xs">Upload Another Receipt / Deposit Slip </button>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th style="width: 20%;">Image</th>
                                                <th style="width: 30%;">Remarks</th>
                                                <th style="width: 20%;">Date Uploaded</th>
                                                <th style="width: 5%;">Action</th>
                                            </tr>
                                            <?php
                                            $directory = 'uploads/' . $this->session->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $ch . DIRECTORY_SEPARATOR . 'online_payments';
                                            $scanFiles = scandir($directory);
                                            $files = array_diff($scanFiles, array('..', '.'));
                                            //echo $directory.'<br />';

                                            foreach ($files as $file):
                                                $or = Modules::run('finance/getPaymentRemarksByFile', $file, $this->session->school_year);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img class="img-responsive pad pointer text-center" style="display: block; margin: auto; width: 30%; height: 30%" src="<?php echo base_url($directory . '/' . $file) ?>" alt="Photo">
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <?php echo $or->opr_remarks ?>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <?php echo $or->opr_date; ?>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <button class="btn btn-sm imgDel" id="<?php echo $or->opr_id ?>" link="<?php echo base64_encode($or->opr_img_link) ?>" style="color:tomato"><i class="fa fa-lg fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                            //     endif;
                                            // endforeach;
                                            $paymentCenters = Modules::run('opl/p/getPadalaCenters', $this->session->school_year);
                                            //print_r($paymentCenters);
                                            ?>
                                        </table>
                                        <span id="errTr"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        Original Receipt Copy
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            Image Receipt
                                                        </td>
                                                        <td>
                                                            Remarks
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $directory = 'uploads/' . $this->session->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $ch . DIRECTORY_SEPARATOR . 'original_receipts';
                                                    $scanFiles = scandir($directory);
                                                    $files = array_diff($scanFiles, array('..', '.'));
                                                    //echo $directory.'<br />';

                                                    foreach ($files as $file):
                                                        $remarks = Modules::run('finance/getPaymentRemarksByFile', $file, $student->school_year);
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <img class="img-responsive pad pointer" style="width: 200px;" src="<?php echo base_url($directory . '/' . $file) ?>" alt="Photo">
                                                            </td>
                                                            <td>
                                                                <?php echo $remarks->opr_remarks ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                                <?php
                                                $paymentCenters = Modules::run('opl/p/getPadalaCenters', $this->session->school_year);
                                                //print_r($paymentCenters);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            endif;
        endif;
    endforeach;
    ?>
</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 100%; height: 100%">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview" style="width: 100%; height: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDelOR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="border: thin solid red;">
        <div class="modal-content">
            <div class="modal-header alert alert-danger" style="background-color: lightred;">
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <span class="text-center" id="delMsg">Are you sure you want to delete the uploaded receipt?</span>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="imgID" />
                <input type="hidden" id="imgLink" />
                <button type="button" onclick="delReceipt()" class="btn btn-danger btn-ok">Delete</button>
                <button type="button" id="delConfirm" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<section class="col-lg-12 float-left">
    <div class="modal fade in" id="uploadReceipt">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h6 class="modal-title float-left">Upload Another Receipt</h6>
                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="upload_form" enctype="multipart/form-data" method="post">
                        <laebl class="form-label">Select Account</laebl>
                        <select class="form-control" id="st_acc" onchange="$('#st_id').val(this.value)">
                            <option value="0">Select Account</option>
                            <?php
                            $all_acc = [];
                            foreach ($children as $acc):
                                if ($acc != ''):
                                    $student = Modules::run('registrar/getSingleStudent', $acc, $school_year);
                                    echo '<option value="' . base64_encode($acc) . '">' . strtoupper($student->firstname . " " . $student->lastname) . '</option>';
                                    $all_acc[] = base64_encode($acc);
                                endif;
                            endforeach;
                            ?>
                            <option value="<?php echo implode(',', $all_acc) ?>">All Account</option>
                        </select>
                        <label class="form-label">Payment Center</label>
                        <select class="form-control" id="payment_center">
                            <option>Select Payment Center</option>
                            <?php foreach ($paymentCenters as $pc): ?>
                                <option value="<?php echo $pc->pc_id ?>"><?php echo $pc->pc_name ?></option>
                            <?php endforeach; ?>
                        </select><br />
                        <input type="file" name="userfile" id="userfile"><br>
                        <label class="form-label">Payment Remarks</label>
                        <textarea class="form-control" id="paymentRemarks"></textarea>
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
</section>
<section class="col-lg-12 float-left">

</section>

<input type="hidden" id="school_year" value="<?php echo $this->session->school_year ?>" />
<input type="hidden" id="st_id" value="0" />

<script type="text/javascript">
    $(".pad").on("click", function() {
        $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });

    $('.imgDel').on('click', function() {
        var img_id = $(this).attr('id');
        var link = $(this).attr('link');
        $('#imgID').val(img_id);
        $('#imgLink').val(link);
        $('#confirmDelOR').modal('show');
    })

    $(document).ready(function() {
        // $('#inputSY').select2();
        $(".nav-tabs a").click(function() {
            $(this).tab('show');
        });

        $('#profile_tab a').click(function(e) {
            e.preventDefault()
            $(this).tab('show')
        });
    });

    $(document).on('click', '.card-header span.clickable', function(e) {
        var $this = $(this);

        if (!$this.hasClass('card-collapse')) {
            $this.parents('.card').find('.card-body').slideUp();
            $this.addClass('card-collapse');
            $this.find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $this.parents('.card').find('.card-body').slideDown();
            $this.removeClass('card-collapse');
            $this.find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });

    function viewDetails(id) {
        var url = "<?php echo base_url() . 'finance/loadAccountDetails/' ?>" + id;

        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#financeData').html(data)
            }
        });

        return false;
    }


    //UPloading of Receipts
    function _(el) {
        return document.getElementById(el);
    }

    _("progressBarWrapper").style.display = 'none';

    function uploadFile() {
        var stid = $('#st_id').val();
        if (stid == 0) {
            alert('Please Select Account');
        } else {
            var n = stid.split(',');
            for (i = 0; i < n.length; i++) {
                var file = document.getElementById("userfile").files[0];
                // alert(file.name+" | "+file.size+" | "+file.type);
                var formdata = new FormData();
                formdata.append("userfile", file);
                formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
                formdata.append('st_id', n[i]);
                formdata.append('payment_remarks', $('#paymentRemarks').val());
                formdata.append('department', $('#department').val());
                formdata.append('school_year', $('#school_year').val());
                formdata.append('semester', 0);
                formdata.append('paymentCenter', $('#payment_center').val());
                formdata.append('is_or', 0);
                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", "<?php echo base_url() . 'opl/p/uploadPaymentReceipt/' ?>");
                ajax.send(formdata);
            }
        }
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

    function delReceipt() {
        var id = $('#imgID').val();
        var link = $('#imgLink').val();
        var url = '<?php echo base_url() . 'finance/deleteReceipt/' ?>' + id + '/' + link;

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#delMsg').html('<img src="<?php echo base_url('assets/img/loading.gif') ?>" style="width: 20px; height: 20px" /> Please wait . . . ')
                setTimeout(function() {
                    if (data == 'Receipt Successfuly Deleted') {
                        $('#delMsg').html('<i class="fa fa-check-circle fa-lg text-success"></i> ' + data);
                    } else {
                        $('#delMsg').html('<i class="fa fa-exclamation-triangle fa-lg text-danger"></i> ' + data);
                    }
                }, 3000);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }
</script>