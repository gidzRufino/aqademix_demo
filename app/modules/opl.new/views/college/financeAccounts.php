<section class="col-lg-4 col-xs-12 float-left">
    <div class="card card-widget card-danger card-outline">
        <div class="card-header">
            Finance Charges
        </div>
        <div class="card-body">
            <?php
                $student = $this->session->details;
                $totalUnits = 0;
                $totalSubs = 0;
                $totalLab = 0;
                $totalCharges = 0;
                $totalExamFee = 0;
                $totalBalance = 0;
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
                foreach ($extraCharges->result() as $ec):
                    $totalExtra += $ec->extra_amount;
                endforeach;

                $over = Modules::run('college/finance/overPayment', $student->st_id, $student->semester, $student->school_year);

                $totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $totalLab + $totalExtra);
                foreach ($charges as $exam):
                    $examFee = ($exam->item_id == 46 ? 'yes' : 0);
                endforeach;

                $semester = ($student->semester == 1 ? 3 : ($student->semester - 1));
                $school_year = ($semester == 1 ? $student->school_year - 1 : $student->school_year);

                $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $school_year));
            ?>
            <table class="table table-striped table-responsive-sm">
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
                $outstandingBalance = ($totalFees + ($over->row()?$over->row()->extra_amount:0) + $overAllExamFees);
                $totalBalance += $outstandingBalance;
                ?>
                <tr>
                    <th >TOTAL FEES</th>
                    <th  class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                </tr>
                <?php
                if($hasBalance!=""):
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

                <?php 
                     $totalBalance += $hasBalance->rawBalance;
                    endif;
                endif;
                ?>
            </table>
        </div>
    </div>
</section>
<section class="col-lg-8 col-xs-12 float-left">
    <div class="card card-widget card-blue card-outline">
        <div class="card-header">
            Payment / Discount History
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped table-responsive-sm ">
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
                        <td>-</td>
                        <td style="width:20%; text-align: right;"><?php echo number_format($totalBalance,2,'.',',') ?></td>
                    </tr>
                    <?php
                        $transaction = Modules::run('college/finance/getTransactionByRefNumber', $student->st_id, $student->semester, $student->school_year);
                        //print_r($transaction->result());
                        $paymentTotal = 0;
                        $i = 1;
                        if($transaction->num_rows()>0):
                            $balance = 0;
                            foreach ($transaction->result() as $tr):
                                ?>
                                <tr  >
                                    <td style="width:20%;"><?php echo $tr->t_date ?></td>
                                    <?php
                                        if($tr->t_type==2):
                                            $discounts = Modules::run('college/finance/getDiscountsById', $tr->disc_id);
                                            if($discounts->disc_type==0):
                                                if($discounts->disc_item_id==1):
                                                    $discAmount = $tuitionFee * $discounts->disc_amount;
                                                else:
                                                    $discAmount = $tr->subTotal;
                                                endif;
                                            else:
                                                $discAmount = $tr->subTotal;
                                            endif;
                                            
                                            $totalBalance = $totalBalance - $discAmount ;
                                    ?>
                                            <td style="width:30%"></td>
                                            <td style="width:40%;"><?php echo $discounts->schlr_type?></td>
                                            <td style="width:20%; text-align: right;"><?php echo '( '.number_format($discAmount, 2, '.',',').' )'?></td>
                                            <td style="width:20%; text-align: right;"><?php echo number_format(($totalBalance), 2, '.',',')?></td>
                                            <td style="width:20%; text-align: right;"><?php echo $discounts->disc_remarks ?></td>
                                    <?php
                                        else:
                                            $totalBalance = $totalBalance - $tr->t_amount;
                                            $finCategory = Modules::run('college/finance/getFinCategory', $tr->fused_category);
                                           
                                           // print_r($finCategory);
                                    ?>
                                            <td style="width:10%;"><?php echo $tr->ref_number ?></td>
                                            <td style="width:40%;"><?php echo ($tr->fused_category==0?$tr->item_description:$finCategory->fin_category)  ?></td>
                                            <td style="width:20%; text-align: right;"><?php echo number_format($tr->t_amount, 2, '.',',')?></td>
                                            <td style="width:20%; text-align: right;"><?php echo number_format(($totalBalance), 2, '.',',')?></td>
                                            <td style="width:20%; text-align: right;"><?php echo $tr->t_remarks ?></td>
                                    <?php

                                        endif;
                                        $paymentTotal = $totalBalance;
                                    ?>

                                </tr>
                                <?php
                            endforeach;
                        endif;
                    ?>    
                </tbody>
            </table>    
        </div>
    </div>
</section>
<section class="col-lg-12 float-left">
    <div class="card card-widget card-warning card-outline">
        <div class="card-header">
            History of Uploaded and Confirmed Receipts / Deposit Slips
            <button onclick="$('#uploadReceipt').modal('show')" class="float-right btn btn-success btn-xs" >Upload Another Receipt / Deposit Slip </button>
        </div>
        <div class="card-body">
            <?php 
            $directory = 'uploads/'.$this->session->details->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$this->session->details->st_id.DIRECTORY_SEPARATOR.'online_payments';
            $scanFiles = scandir($directory);
            $files = array_diff($scanFiles, array('..', '.'));
            foreach ($files as $file):
            ?>
            <img class="img-responsive pad" style="width: 200px;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="Photo">
            <?php
            endforeach;
            ?>
        </div>
    </div>

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
                <select class="form-control" id="payment_center">
                    <option>Select Payment Center</option>
                    <option  value="boc">BANK OF COMMERCE</option>
                    <option  value="dbp">Development Bank of the Philippines</option>
                    <option  value="psb">PSBank</option>
                    <option  value="palawan">Palawan Pera Padala</option>
                    <option  value="cebuana">Cebuana Pera Padala</option>
                    <option  value="rd">RD Pawnshop Money Remitance</option>
                    <option  value="gcash">GCash</option>
                </select><br />    
                <input type="file" name="userfile" id="userfile"><br>
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
        <button type="button" class="btn btn-primary"  onclick="uploadFile()">Upload</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>    
</section>
<input type="hidden" id="st_id" value="<?php echo base64_encode($this->session->details->st_id) ?>" />
<input type="hidden" id="department" value="<?php echo $this->session->department ?>" />
<input type="hidden" id="school_year" value="<?php echo $this->session->school_year ?>" />
<input type="hidden" id="semester" value="<?php echo $this->session->semester ?>" />

<script type="text/javascript">

    $(document).ready(function () {
        $('#studentDashboard').modal('show');
    });

    function _(el) {
        return document.getElementById(el);
    }

    _("progressBarWrapper").style.display = 'none';

    function uploadFile() {
	var file = document.getElementById("userfile").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('st_id', $('#st_id').val());
        formdata.append('department', $('#department').val());
        formdata.append('school_year', $('#school_year').val());
        formdata.append('semester', $('#semester').val());
        formdata.append('paymentCenter', $('#payment_center').val());
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo base_url() . 'college/enrollment/uploadAnotherPaymentReceipt/' ?>");
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



    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }



</script>


