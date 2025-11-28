<div class="col-lg-12 clearboth" style="background: #ccc;">
    <div class="col-lg-6 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
        <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
            <div class="col-lg-1 col-xs-2 no-padding">
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>

            <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
            <h6 class="text-right" style="color:black;"><?php echo ($this->session->isCollege ? $this->session->details->course : ''); ?></h6>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">  
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
                    $totalCharges = 0;
                    $totalExamFee = 0;
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

                    if ($extraCharges->num_rows() > 0):
                        foreach ($extraCharges->result() as $ec):
                            $totalExtra += $ec->extra_amount;
                        endforeach;
                    endif;

                    $over = Modules::run('college/finance/overPayment', $student->st_id, $student->semester, $student->school_year);

                    $totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $totalLab + $totalExtra);
                    foreach ($charges as $exam):
                        $examFee = ($exam->item_id == 46 ? 'yes' : 0);
                    endforeach;

                    $semester = ($student->semester == 1 ? 3 : ($student->semester - 1));
                    $prev_year = ($student->semester == 1 ? $student->school_year - 1 : $student->school_year);
                    if ($this->session->isOld):
                        $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $prev_year));
                    else:
                        $hasBalance = json_decode(json_encode(array('status' => FALSE)));
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
                                        Modules::run('college/enrollment/updateEnrollmentStatus', base64_encode($student->st_id), 4, $student->semester, $student->school_year);
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

                                    <tr>
                                        <th colspan="2" class="text-danger text-center">
                                            Note: The above school fees may be subject to any of the ff. discounts. Example: ESC Subsidy, Tuition Privileges and Scholarships.
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                else: // This is for Basic Education Department

                    $plan = Modules::run('finance/getPlanByCourse', $student->grade_level_id, 0, $student->st_type, $student->school_year);
                    $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
                    $loadedSubject = Modules::run('registrar/getOvrLoadSub', $student->st_id, $student->semester, $student->school_year);
//            $previousRecord = json_decode(Modules::run('finance/getRunningBalance', base64_encode($student->st_id), ($student->semester==3?$student->school_year:($student->school_year-1)), ($student->semester==3?0:$student->semester)));
//            
//            if($previousRecord->status):
//                $previousBalance = $previousRecord->charges - $previousRecord->payments;
//                $hasBalance = $previousBalance > 0 ? TRUE : FALSE;
//            else:
//                $hasBalance = FALSE;
//            endif;
                    $hasBalance = Modules::run('college/finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);
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
                                        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);
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
                                            <th >TOTAL FEES</th>
                                            <th  class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
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
                                            <th >TOTAL FEES</th>
                                            <th  class="text-right"><?php echo number_format($outstandingBalance, 2, '.', ','); ?></th>
                                        </tr>
                                    <?php
                                    endif;
                                    if ($hasBalance->row()->extra_amount > 0):
                                        $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);

                                        if (empty($remarks)):
                                            Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $student->school_year, 1);
                                        endif;
                                        ?>
                                        <tr class="danger">
                                            <td style="font-size: 20px;">PREVIOUS BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->row()->extra_amount, 2, '.', ',') ?></th>
                                        </tr>

                                        <tr>
                                            <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                            <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->row()->extra_amount + $outstandingBalance, 2, '.', ',') ?></th>
                                        </tr>
                                        <?php
                                    endif;
                                    ?>
                                    <tr>
                                        <th colspan="2" class="text-danger text-center">
                                            Note: The above school fees may be subject to any of the ff. discounts. Example: ESC Subsidy, Tuition Privileges and Scholarships.
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10 col-md-12 col-xs-12">
                        <div class="alert alert-info clearfix">
                            <?php
                            $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);
                            if ($remarks):
                                ?>
                                <p class="text-center" style="font-size: 18px;"><?php echo $remarks->fr_remarks; ?> </p> <br/>
                            <?php else: ?>
                                <p class="text-center">Pay a minimum amount of &#8369; 1,000.00 to the following payment centers: </p> <br/>
                            <?php endif; ?>
                            <p class="text-center">To the following payment centers: </p> <br/>
                            <table class="table table-striped" style="background: white;">
                                <tr>
                                    <th class="text-center" colspan="2">Bank Details</th>
                                </tr>
                                <!--<tr>-->
                                <!--    <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>boc.png" style="height:70px; margin:3px auto;" title="boc" alt="boc" /></td>-->
                                <!--    <td>Branch : Cagayan de Oro - Velez<br />-->
                                <!--        Account Name : Pilgrim Christian College<br />-->
                                <!--        Savings Account #: 024-00-002376-7-->
                                <!--    </td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>dbp.jpg" style="height:60px; margin:3px auto;" title="dbp" alt="dbp" /></td>-->
                                <!--    <td>Branch: Cagayan de Oro Velez <br />-->
                                <!--        Account Name: Pilgrim Christian College<br />-->
                                <!--        Checking Account #: 0810-020228-030-->
                                <!--    </td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>psbank.jpg" style="width:120px; margin:3px auto;" title="psbank" alt="psbank" /></td>-->
                                <!--    <td>Branch: Cagayan de Oro Velez <br />-->
                                <!--        Account Name: Pilgrim Christian College<br />-->
                                <!--        Checking Account #: 100292000198-->
                                <!--    </td>-->
                                <!--</tr>-->
                            </table>
                            <table class="table table-striped" style="background: white;">
                                <tr>
                                    <th class="text-center" colspan="3">Pera Padala Centers</th>
                                </tr>
                                <tr>
                                    <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>palawan.png" style="width:120px; margin:3px auto;" title="palawan" alt="boc" /></td>
                                    <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>cebuana.png" style="height:45px;  margin:3px auto;" title="ml" alt="ml" /></td>
                                    <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>rd.jpg" style="width:90px;  margin:3px auto;" title="rd" alt="rd" /></td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">SEND TO</td>
                                </tr>
                                <tr>
                                    <!--<td colspan="3" class="text-center">-->
                                    <!--    Name: Alfred Yecyec <br />-->
                                    <!--    Address: Pilgrim Christian College, Capistrano-Akut Sts. CDO City<br />-->
                                    <!--    Contact No: 09355707888-->
                                    <!--</td>-->
                                </tr>
                            </table>
                            <table class="table table-striped" style="background: white;">
                                <tr>
                                    <th class="text-center" colspan="2">SEND THROUGH GCASH</th>
                                </tr>
                                <tr>
                                    <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>gcash.png" style="width:50px; margin:3px auto;" title="gcash" alt="gcash" /></td>

                                    <!--<td colspan="2">-->
                                    <!--    Account Name: Fausto S. Abella <br />-->
                                    <!--    Number: 09177173554-->
                                    <!--</td>-->
                                </tr>
                            </table>
                            <p class="text-center"> Upload the payment receipt if payment has been made</p><br />
                            <button onclick="$('#uploadReceipt').modal('show')" class="btn btn-success btn-xs pull-left">Upload Receipt</button>
                            <button onclick="document.location = '<?php echo base_url('entrance') ?>'" class="btn btn-danger btn-xs pull-right">Close</button>
                        </div>
                    </div>
                </div>
            </div> <!--end of modal-body --> 


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
                        <option  value="boc">BANK OF COMMERCE</option>
                        <option  value="dbp">Development Bank of the Philippines</option>
                        <option  value="psb">PSBank</option>
                        <option  value="palawan">Palawan Pera Padala</option>
                        <option  value="cebuana">Cebuana Pera Padala</option>
                        <option  value="rd">RD Pawnshop Money Remitance</option>
                        <option  value="gcash">GCash</option>
                        <option  value="walk_in">Walk In</option>
                    </select><br />    
                    <input type="file" name="userfile" id="userfile"><br>
                    <input class="btn btn-success" type="button" value="Upload File" onclick="uploadFile()"> <br /> <br />
                    <div class="progress" id="progressBarWrapper">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            UPLOADING RECEIPT...
                        </div>
                    </div> 



                </form>
            </div>
        </div>
    </div>
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
            formdata.append('department', '<?php echo $this->session->department ?>');
            formdata.append('school_year', $('#school_year').val());
            formdata.append('semester', $('#semester').val());
            formdata.append('paymentCenter', $('#payment_center').val());
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
            alert(event.target.responseText);
            document.location = '<?php echo base_url('entrance'); ?>';
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