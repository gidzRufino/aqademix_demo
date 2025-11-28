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
    default :
        $width = '100%';
        $col = 'col-lg-3';
        break;
endswitch;
?>
<div class="col-lg-12">
        <?php
        foreach ($children as $child):
            $isEnrolled = Modules::run('registrar/isEnrolled', $child, $this->session->school_year);
            if (!$isEnrolled):
                $school_year = $this->session->userdata('school_year') - 1;
            else:
                $school_year = $this->session->userdata('school_year');
            endif;

            $childDepartment = Modules::run('registrar/getStudentDepartment', $child, $school_year);

            if ($childDepartment == 'basic'):
                $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                $adviser = Modules::run('academic/getAdvisory', NULL, $school_year, $student->section_id);
                ?>
        <div class="<?php echo $col; ?> float-left">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user ">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username"><?php echo strtoupper($student->firstname . ' ' . $student->lastname) ?></h3>
                    <h5 class="widget-user-desc"><?php echo $student->level ?> - <?php echo $student->section ?></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
                </div>
                <div class="card-body">
                    <?php
                    
                        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0,$student->st_type, $student->school_year);

                        $charges = Modules::run('finance/financeChargesByPlan',0, $student->school_year, 0, $plan->fin_plan_id, $student->semester );
                        $addCharge = Modules::run('college/finance/financeChargesByPlan',NULL, $student->school_year, $student->semester  );
         
                        $financeAccount = Modules::run('finance/getFinanceAccount', $student->st_id);
                    ?>
                    <div class='panel panel-warning'>
                        <div class='panel-heading clearfix'>
                            <h5 class="pull-left">Finance Details</h5>
                        </div>
                        <div class='panel-body'>
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
                                    $i=1;
                                    $total=0;
                                    $amount=0;
                                    foreach ($charges as $c):
                                        if(!$c->is_fused):
                                            $next = $c->school_year + 1;
                                            if($student->grade_id==12 || $student->grade_id==13):
                                                if($student->st_type !=2):
                                                ?>
                                                <tr id="tr_<?php echo $c->charge_id ?>">
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $c->item_description ?></td>
                                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
                                                </tr>

                                                <?php
                                                    $total += $c->amount;
                                                else:
                                                    if($c->item_description!='Tuition Fee' && $c->item_description!='Misc Fee'):    
                                                     ?>

                                                        <tr id="tr_<?php echo $c->charge_id ?>">
                                                            <td><?php echo $i++;?></td>
                                                            <td><?php echo $c->item_description ?></td>
                                                            <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
                                                        </tr>
                                                    <?php
                                                    $total += $c->amount;
                                                    endif;
                                                endif;
                                            else:
                                                ?>
                                                <tr id="tr_<?php echo $c->charge_id ?>">
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $c->item_description ?></td>
                                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
                                                </tr>

                                                <?php

                                                    $total += $c->amount;
                                            endif;  
                                        else:
                                            $fusedCharges += $c->amount;
                                            
                                        endif;
                                   endforeach;
                                            $total += $fusedCharges;
                                        ?>
                                        <tr id="fused">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo 'OTHER FEES' ?></td>
                                            <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($fusedCharges, 2, '.',',') ?></td>
                                        </tr>    
                                        <?php
                                        $totalExtra = 0;
                                        $extraCharges = Modules::run('finance/getExtraFinanceCharges',$user_id, $student->semester, $student->school_year);
                                        if($extraCharges->num_rows()>0):
                                            foreach ($extraCharges->result() as $ec):
                                            ?>
                                                <tr data-toggle="context" data-target="#extraMenu" onmouseover="$('#delete_trans_id').val('<?php echo $ec->extra_id ?>')" style="background: #0ff !important;" id="trExtra_<?php echo $ec->extra_id ?>"
                                                    delete_remarks="Extra Charges for <?php echo $ec->item_description?> voided: [Amount :<?php echo number_format($ec->extra_amount, 2, '.',',') ?>]">
                                                    <td style="background: #0ff !important;"><?php echo $i++;?></td>
                                                    <td style="background: #0ff !important;"><?php echo $ec->item_description?></td>
                                                    <td style="background: #0ff !important;" id="td_<?php echo $ec->extra_id ?>" class="text-right"><?php echo number_format($ec->extra_amount, 2, '.',',') ?></td>
                                                </tr>
                                            <?php
                                            $totalExtra += $ec->extra_amount;
                                            endforeach;
                                            $total = $total + $totalExtra;
                                        endif;

                                        if($total!=0):
                                    ?>
                                    <tr style="background:yellow;">
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th class="text-right"><?php echo number_format($total, 2, '.',',') ?></th>
                                        <th></th>
                                    </tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class='panel panel-success' style="margin-top:20px;">
                            <div class='panel-heading clearfix'>
                                <h5 class="pull-left">Payment/Discount History</h5>
                            </div>
                            <div class='panel-body'>
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
                                                <td>-</td>
                                                <td style="width:20%; text-align: right;"><?php echo number_format($total,2,'.',',') ?></td>
                                            </tr>
                                            <?php
                                            $transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);

                                            $paymentTotal = 0;
                                            $i = 1;
                                            if($transaction->num_rows()>0):
                                                $balance = 0;
                                                foreach ($transaction->result() as $tr):
                                                    if($tr->t_type!=3):
                                                    $i++;
                                                        ?>
                                                        <tr data-toggle="context" data-target="#otherMenu" onmouseover="$('#delete_trans_type').val('<?php echo $tr->t_type ?>'),$('#delete_trans_id').val('<?php echo $tr->trans_id ?>'), $('#delete_item_id').val('<?php echo $tr->t_charge_id ?>')" >
                                                            <td style="width:20%;"><?php echo $tr->t_date ?></td>
                                                            <?php
                                                                    $total = $total - $tr->t_amount ;
                                                                if($tr->t_type==2):
                                                                    $discounts = Modules::run('finance/getDiscountsById', $tr->disc_id);
                                                                    if($discounts->disc_type==0):

                                                                    else:    

                                                                    endif;
                                                            ?>
                                                                    <td id="td_trans_<?php echo $tr->trans_id ?>" 
                                                                        delete_remarks="[ Discount type: <?php echo $tr->item_description.' - '.$discounts->disc_remarks ?>, Amount:<?php echo number_format($tr->t_amount, 2, '.',',')?>]"

                                                                        style="width:30%"></td>
                                                                    <td style="width:40%;"><?php echo $discounts->schlr_type?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo '( '.number_format($tr->t_amount, 2, '.',',').' )'?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format(($total), 2, '.',',')?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo $discounts->disc_remarks ?></td>
                                                            <?php
                                                                else:
                                                            ?>
                                                                    <td id="td_trans_<?php echo $tr->trans_id ?>" 
                                                                        delete_remarks="Payment Transaction voided: [Amount :<?php echo number_format($tr->t_amount, 2, '.',',') ?>, Date: <?php echo date('F d, Y', strtotime($tr->t_date)) ?>]" style="width:10%;"><?php echo $tr->ref_number ?></td>
                                                                    <td style="width:40%;"><?php echo ($tr->fused_category==0?$tr->item_description:$tr->fin_category)  ?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format($tr->t_amount, 2, '.',',')?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo number_format(($total), 2, '.',',')?></td>
                                                                    <td style="width:20%; text-align: right;"><?php echo $tr->t_remarks ?></td>
                                                            <?php

                                                                endif;
                                                                $paymentTotal = $total;
                                                            ?>

                                                        </tr>
                                                        <?php
                                                    endif;    
                                                endforeach;
                                                if($paymentTotal!=0):
                                            ?>
                                            <tr style="background:yellow;">
                                                <th style="background:yellow;" colspan="2">Running Balance</th>
                                                <th style="background:yellow;"></th>
                                                <th  style="background:yellow;"></th>
                                                <th  style="background:yellow;" class="text-right"><?php echo number_format($paymentTotal, 2, '.',',') ?></th>

                                            </tr>
                                            <?php endif;
                                            endif;
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <?php
            endif;
        endforeach;
        ?>
</div>

<section class="col-lg-12 float-left">
    <div class="card card-widget card-warning card-outline">
        <div class="card-header">
            History of Uploaded and Confirmed Receipts / Deposit Slips
            <button onclick="$('#uploadReceipt').modal('show')" class="float-right btn btn-success btn-xs" >Upload Another Receipt / Deposit Slip </button>
        </div>
        <div class="card-body">
            <?php 
            foreach ($children as $child):
                $directory = 'uploads/'.$this->session->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$child.DIRECTORY_SEPARATOR.'online_payments';
                $scanFiles = scandir($directory);
                $files = array_diff($scanFiles, array('..', '.'));
                    //echo $directory.'<br />';
                
                foreach ($files as $file):
                ?>
                <img class="img-responsive pad" style="width: 200px;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="Photo">
                <?php
                endforeach;
            endforeach; 
            $paymentCenters = Modules::run('opl/p/getPadalaCenters', $this->session->school_year);
            //print_r($paymentCenters);
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
                <label class="form-label">Payment Center</label>
                <select class="form-control" id="payment_center">
                    <option>Select Payment Center</option>
                    <?php  
                        
                    foreach($paymentCenters as $pc): ?>
                    <option  value="<?php echo $pc->pc_id ?>"><?php echo $pc->pc_name ?></option>
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
        <button type="button" class="btn btn-primary"  onclick="uploadFile()">Upload</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>    
</section>
<input type="hidden" id="school_year" value="<?php echo $this->session->school_year?>" />
<input type="hidden" id="st_id" value="<?php echo base64_encode($child)?>" />

<script type="text/javascript">
    $(document).ready(function () {
        // $('#inputSY').select2();

    });


    function viewDetails(id)
    {
        var url = "<?php echo base_url() . 'finance/loadAccountDetails/' ?>" + id;

        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
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
	var file = document.getElementById("userfile").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('st_id', $('#st_id').val());
        formdata.append('payment_remarks', $('#paymentRemarks').val());
        formdata.append('department', $('#department').val());
        formdata.append('school_year', $('#school_year').val());
        formdata.append('semester', 0);
        formdata.append('paymentCenter', $('#payment_center').val());
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


</script>