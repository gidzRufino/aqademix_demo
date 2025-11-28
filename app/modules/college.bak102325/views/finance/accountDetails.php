<?php
$semester = Modules::run('main/getSemester');

if ($sem == NULL):
    $sem = $semester;
endif;
$student = Modules::run('college/getSingleStudent', base64_decode($st_id), ($school_year != NULL ? $school_year : $this->session->userdata('school_year')), $sem);

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

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $sem, $student->school_year);

$totalUnits = 0;
$totalSubs = 0;
foreach ($loadedSubject as $sl):
    $totalSubs++;
    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
endforeach;

$plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
$charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $sem, $plan->fin_plan_id);

$tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);

$addCharge = Modules::run('college/finance/financeChargesByPlan', NULL, $student->school_year, $sem);

$promisoryRequest = Modules::run('college/finance/getPromisoryRequest', $student->uid, $sem);
?>

<div class="well col-lg-12" id="profBody">
    <div class="col-lg-2">
        <?php if ($this->session->userdata('position_id') != 4): ?>
        <?php
        endif;
        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;
        ?>
        <div>
            <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php if ($student->avatar != ""):echo base_url() . 'uploads/' . $student->avatar;
        else:echo base_url() . 'uploads/noImage.png';
        endif; ?>" />
        </div>
    </div>
    <div class="col-lg-6">
        <h2 style="margin:3px 0;">
            <span id="name" style="color:#BB0000;"><?php echo $student->firstname . " " . $student->lastname ?></span>

        </h2>
        <h4 style="color:black; margin:3px 0;"><?php echo $student->course; ?> - <span id="a_section"><?php echo $year_level; ?></span>
        </h4>
        <h3 style="color:black; margin:3px 0;">
            <small>
                <a title="double click to edit" id="a_user_id"  style="color:#BB0000;">
<?php echo $student->uid ?>
                </a>
            </small>

        </h3>
    </div>
    <input type="hidden" id="st_id" value="<?php echo $student->uid ?>" /> 
    <input type="hidden" id="course_id" />
    <input type="hidden" id="year_level" />
    <input type="hidden" id="finPlan_id" value="<?php echo $plan->fin_plan_id ?>" />
    <input type="hidden" id="user_id" value="<?php echo $user_id ?>" />
    <input type="hidden" id="admission_id" value="<?php echo $student->admission_id ?>" />
    <input type="hidden" id="currentSemester" value="<?php echo $sem ?>" />
    <input type="hidden" id="currentYear" value="<?php echo $student->school_year ?>" />
    <input type="hidden" id="totalUnits" value="<?php echo $totalUnits ?>" />
    <div class="btn-group-vertical pull-right">
        <button type="button" class="btn btn-default btn-xs" onclick="viewSL('<?php echo $student->admission_id ?>', '<?php echo $sem ?>')">View Study Load</button>
        <a href="<?php echo base_url('college/finance/printPermit/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)) ?>" target="_blank" class="btn btn-default btn-xs">Print Exam Permit</a>
        <a href="<?php echo base_url('college/finance/printClearance/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)) ?>" target="_blank" class="btn btn-default btn-xs">Print Clearance</a>
    </div>
</div>
<div class="col-lg-12">
    <div class="btn-group pull-right" role="group" aria-label="">

        <button type="button" class="btn btn-default" onclick="$('#promisoryNoteRequest').modal('show')">Promisory Note Request</button>
        <?php if($promisoryRequest->row()): ?>
            <button type="button" class="btn btn-default <?php echo ($promisoryRequest->num_rows() > 0 ? '' : 'disabled'); ?> <?php echo ($promisoryRequest->num_rows() > 0 ? ($promisoryRequest->row()->fr_approved ? 'btn-success' : 'btn-danger') : 'btn-default') ?>" onclick="$('#viewPromisoryNoteRequest').modal('show')" >
                View Request <span class="badge"><?php echo ($promisoryRequest->row()->fr_approved ? '' : ($promisoryRequest->num_rows() > 0 ? $promisoryRequest->num_rows() : '')); ?></span>
            </button>
        <?php endif; ?>
    </div>

    <div id="viewPromisoryNoteRequest" class="modal fade" style="width:25%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Promisory Note Request  
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Details</label>
                    <textarea disabled="disabled" class="textarea form-control">
                <?php echo $promisoryRequest->row()->fr_remarks; ?>
                    </textarea>
                </div>
                <?php
                if ($promisoryRequest->num_rows() > 0 && $promisoryRequest->row()->fr_approved):
                    ?>
                    <div class="form-group">
                        <label>Amount Allowed : <strong><?php echo $promisoryRequest->row()->fr_allowable_amount ?></strong> </label>

                    </div>
                    <?php
                else:
                    ?>

                    <div class="form-group">
                        <label>Amount Allowed </label>
                        <input type="text" id="request_amount" class="form-control" onclick="$(this).val('')" placeholder="Amount" />
                        <input type="hidden" id="request_id" value="<?php echo $promisoryRequest->row()->fr_id ?>" />
                    </div>
                <?php
                endif;
                ?>
            </div>
            <?php
            if ($this->session->userdata('dept_id') == 1 || $this->session->userdata('dept_id') == 2):
                ?>
                <div class="panel-footer clearfix">
                    <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'  onclick='promisoryAction(2)'>Reject</button>
                    <a href='#'data-dismiss='modal' onclick='promisoryAction(1)' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Approve</a>&nbsp;&nbsp;
                </div>

                <?php
            endif;
            ?>
        </div>
    </div>

</div>
<div style="margin-top: 10px;" class="col-lg-12 no-padding">
    <div class="col-lg-4">
        <div class='panel panel-warning'>
            <div class='panel-heading clearfix'>
                <h5 class="pull-left">Finance Details</h5>
            </div>
            <div class='panel-body'>
                <table class="table table-hover table-striped">
                    <tr>
                        <th class="text-center" colspan="2"></th>
                        <th>
                            <div class="btn-group pull-right" role="group" aria-label="">
                                <button title="Set Finance Charges" class="btn btn-xs btn-info" onclick="setExtraFinanceCharges($('#selectCourse').val(), '<?php echo $student->year_level ?>')"><i class="fa fa-plus fa-fw"></i></button>

                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th style="width:10%;">#</th>
                        <th style="width:50%;">Particulars</th>
                        <th style="width:40%; text-align: right;">Amount</th>
                    </tr>
                    <tbody id="finChargesBody">
                        <?php
                        $i = 1;
                        $total = 0;
                        $amount = 0;
                        $tuitionFee = (($tuition->row()->amount * $totalUnits));
                        $totalCharges=0;
                        ?>

                        <tr id="tr_1">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo 'TUITION ' . $totalUnits . ' UNITS @ ' . (number_format($tuition->row()->amount, 2, '.', ',')) ?></td>
                            <td id="td_1" class="text-right"><?php echo number_format($tuitionFee, 2, '.', ',') ?></td>
                        </tr>
                        <?php
                        //print_r($charges);
                        foreach ($charges as $c):
                            $next = $c->school_year + 1;
                            $amount = ($c->item_id == 1 || $c->item_id == 2 ? 0 : ($c->item_id == 46 ? ($c->amount * $totalSubs) : $c->amount)); // this works in exam fee
                            if ($c->item_id == 1 || $c->item_id == 2):
                            else:
                                ?>
                                <tr id="tr_<?php echo $c->charge_id ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $c->item_description . ($c->item_id == 1 || $c->item_id == 2 ? ' ( ' . $totalUnits . ' units )' : '') ?></td>
                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endif;
                            if($c->item_id==46):
                                $examFee = $c->amount * $totalSubs; 
                            endif;
                            $totalCharges += $amount;
                            $otherFeesLessExamFee = $totalCharges - $examFee;
                        endforeach;
                        $totalExtra = 0;
                        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $user_id, $sem, $student->school_year);
                        ?>

                        <tr style="background:yellow;">
                            <th>TOTAL Charges</th>
                            <th></th>
                            <th class="text-right" id="otherFees" otherFees="<?php echo $otherFeesLessExamFee ?>"><?php echo number_format($totalCharges, 2, '.', ',') ?></th>
                            <th></th>
                        </tr>
                        <?php
                        $totalLab = 0;
                        foreach ($loadedSubject as $sl):
                            if ($sl->sub_lab_fee_id != 0):
                                $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                                $totalLab += $itemCharge->default_value;
                                ?>
                                <tr style="background: #0ff" id="trLab_<?php echo $sl->sub_lab_fee_id ?>" >
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $itemCharge->item_description ?></td>
                                    <td id="td_<?php echo $sl->sub_lab_fee_id ?>" class="text-right"><?php echo number_format($itemCharge->default_value, 2, '.', ',') ?></td>
                                </tr>
                                <?php
                                
                            endif;
                        endforeach;
                        if($totalLab!=0):
                        ?>
                        <tr style="background:yellow;">
                            <th>TOTAL Lab Charges</th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($totalLab, 2, '.', ',') ?></th>
                            <th></th>
                        </tr>   
                        <?php    
                        endif;
                        if ($extraCharges->num_rows() > 0):
                            foreach ($extraCharges->result() as $ec):
                                ?>
                                <tr style="background: #0ff" id="trExtra_<?php echo $ec->extra_id ?>" 
                                    delete_remarks="[ Extra Charges : <?php echo $ec->item_description ?>, Amount:<?php echo number_format($ec->extra_amount, 2, '.', ',') ?>]"
                                    data-toggle="context" 
                                    data-target="#deleteExtraCharges" 
                                    onmouseover="$('#delete_extra_id').val('<?php echo $ec->extra_id ?>')">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $ec->item_description ?></td>
                                    <td id="td_<?php echo $ec->extra_id ?>" class="text-right"><?php echo number_format($ec->extra_amount, 2, '.', ',') ?></td>
                                </tr>
                                <?php
                                $totalExtra += $ec->extra_amount;
                            endforeach;
                        endif;
                        $total = $totalCharges + $tuitionFee + $totalExtra + $totalLab;
                        ?>
                        <tr style="background:yellow;">
                            <th>TOTAL Extra Charges</th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($totalExtra, 2, '.', ',') ?></th>
                            <th></th>
                        </tr>
                        <tr style="background:yellow;">
                            <th>TOTAL Tuition</th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tuitionFee, 2, '.', ',') ?></th>
                            <th></th>
                        </tr>
                        <tr style="background:yellow;">
                            <th>OVER ALL TOTAL</th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($total, 2, '.', ',') ?></th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class='panel panel-success'>
            <div class='panel-heading clearfix'>
                <h5 class="pull-left">Payment/Discount History
                </h5>
                <a  title="Print Statement of Account" href="<?php echo base_url('college/finance/printSOA/' . $this->uri->segment(4) . '/' . $this->uri->segment(5).'/0/'.$this->uri->segment(6)) ?>" target="_blank" class="pull-right btn btn-danger" id="btnPrint"><i class="fa fa-print fa-2x"></i></a>
                <button title="Cash Register" style="margin-right: 5px;" onclick="$('#cashRegister').modal('show')" class="pull-right btn btn-warning" id="btnPOS"><i class="fa fa-money fa-2x"></i></button>
                <button onclick="$('#loadPreviousBalance').modal('show')" title="Load Previous Balance" style="margin-right: 5px; display: none;" class="pull-right btn btn-info" id="btnBalance"><i class="fa fa-refresh fa-2x"></i></button>

            </div>
            <div class='panel-body'>
                <div style="margin:0" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix pointer">
                            <div class="col-lg-2">Date</div>
                            <div class="col-lg-1">OR #</div>
                            <div class="col-lg-3">Particulars</div>
                            <div class="col-lg-2">Payment/Discounts</div>
                            <div class="col-lg-2"><span class="pull-right">Balance</span></div>
                            <div class="col-lg-2"><span class="pull-right">Remarks</span></div> 
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix pointer">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-3">TOTAL CHARGE</div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-2 no-padding">
                                <span class="pull-right" style="font-weight:bold; font-size:18px"><?php echo number_format($total, 2, '.', ',') ?></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 no-padding"></div>
                    <?php
                    $discount = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 2);
                    //print_r($discount->row());
                    if ($discount->row()):
                        $dtransaction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 2);
                        //print_r($transaction->result());
                        $paymentTotal = 0;
                        $i = 1;
                        if ($dtransaction->num_rows() > 0):
                            $balance = 0;
                            foreach ($dtransaction->result() as $tr):
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
                                    $total = round($total,2) - round($discAmount,2);
                                    $i++;
                                echo Modules::run('college/finance/getDiscountHistory', $tr, $total, $student, 2, $discAmount);

                            endforeach;
                        else:

                        endif;
                    endif;

                    $transaction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year);
                    //print_r($transaction->result());
                    $paymentTotal = 0;
                    $i = 1;
                    if ($transaction->num_rows() > 0):
                        $balance = 0;
                        foreach ($transaction->result() as $tr):
                            
                            $i++;
                            $total = $total - $tr->subTotal;
                            echo Modules::run('college/finance/getPaymentHistory', $tr, $total, $student, 0);

                        endforeach;
                    else:

                    endif;
                    
                    $online = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 4);
                    //print_r($transaction->result());
                    $paymentTotal = 0;
                    $i = 1;
                    if ($online->num_rows() > 0):
                        $balance = 0;
                        foreach ($online->result() as $tr):
                            
                            $i++;
                            $total = $total - $tr->subTotal;
                            echo Modules::run('college/finance/getPaymentHistory', $tr, $total, $student, 0);

                        endforeach;
                    else:

                    endif;

                    $excess = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 5);
                    //print_r($transaction->result());
                    $paymentTotal = 0;
                    $i = 1;
                    if ($excess->num_rows() > 0):
                        $balance = 0;
                        foreach ($excess->result() as $tr):
                            
                            $i++;
                            $total = $total - $tr->subTotal;
                            echo Modules::run('college/finance/getPaymentHistory', $tr, $total, $student, 0);

                        endforeach;
                    else:

                    endif;
                    
                    $payrollDeduction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 6);
                    //print_r($transaction->result());
                    $paymentTotal = 0;
                    $i = 1;
                    if ($payrollDeduction->num_rows() > 0):
                        $balance = 0;
                        foreach ($payrollDeduction->result() as $tr):
                            
                            $i++;
                            $total = $total - $tr->subTotal;
                            echo Modules::run('college/finance/getPaymentHistory', $tr, $total, $student, 0);

                        endforeach;
                    else:

                    endif;
                    
                    $forwardedBalance = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 7);
                    //print_r($transaction->result());
                    $paymentTotal = 0;
                    $i = 1;
                    if ($forwardedBalance->num_rows() > 0):
                        $balance = 0;
                        foreach ($forwardedBalance->result() as $tr):
                            
                            $i++;
                            $total = $total - $tr->subTotal;
                            echo Modules::run('college/finance/getPaymentHistory', $tr, $total, $student, 0);

                        endforeach;
                    else:

                    endif;
                    ?>
                    <div style="margin:0" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-danger">
                            <div class="panel-heading clearfix pointer">
                                <div class="col-lg-3"><b>OUTSTANDING BALANCE</b></div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-2 no-padding"><span class="pull-right"></span></div>
                                <div class="col-lg-2 no-padding"><span class="pull-right" style="font-weight:bold; font-size:18px"><?php echo number_format($total, 2, '.', ',') ?></span></div>
                                <div class="col-lg-2"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                Deposit Slips / Receipts
            </div>
            <div class="panel-body clearfix">
            <?php 
                $directory = 'UPLOADSa/'.$student->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->st_id.DIRECTORY_SEPARATOR.'online_payments';
                $scanFiles = scandir($directory);
                $files = array_diff($scanFiles, array('..', '.'));
                foreach ($files as $file):
                ?>
                <div class="col-lg-2">
                    <img class="img-responsive myImg" style="width: 200px; float: left;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="<?php echo $file ?>"><br />
                    <span><?php echo $file ?></span>
                    
                </div>
                <?php
                endforeach;
            ?>
            </div>
        </div>
    </div>


    <div id="addFinanceOption" class="modal fade" style="width:20%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-green">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Extra Charges
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Finance Item</label> <br />
                    <select style="width:90%;"  name="inputFinItems" id="inputFinItems" required>
                        <option>Select Item</option> 
                        <option value="0">Apply Discount</option> 
                        <?php
                        foreach ($fin_items as $i) {
                            ?>                        
                            <option value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                        <?php } ?>
                    </select>
                    <button onclick="$('#addItemModal').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" id="fin_amount" class="form-control" onclick="$(this).val('')" placeholder="Amount" />
                </div>
                <div class="form-group">
                    <label>School Year</label> <br />
                    <select style="width:100%;"  name="inputCSY" id="inputCSY" required>
                        <option value="0">Select School Year</option> 
                        <?php
                        foreach ($ro_years as $ro) {
                            $next = ($ro->ro_years + 1);
                            ?>                        
                            <option <?php echo ($ro->ro_years==$this->session->school_year?'selected':'') ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years . ' - ' . $next; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Semester</label>
                    <select tabindex="-1" id="inputSem" name="inputSem"  class="col-lg-12">
                        <option>Select Semester</option>
                        <option <?php echo ($sem==1?'selected':'') ?> value="1">First Semester</option>
                        <option <?php echo ($sem==2?'selected':'') ?> value="2">Second Semester</option>
                        <option <?php echo ($sem==3?'selected':'') ?> value="3">Summer</option>

                    </select>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='addExtraFinanceCharges()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>

    </div>

    <div id="promisoryNoteRequest" class="modal fade" style="width:25%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Request for Promisory Note   
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea id="promisoryRemarks" class="textarea form-control">
                    
                    </textarea>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='requestPromisory()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>
        </div>
    </div>


    <div id="addItemModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item    s
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Item</label>
                    <input type="text" id="fin_item" class="form-control" placeholder="Item" />
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='addItems()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>
        </div>
    </div>



    <div id="addDiscount" class="modal fade" style="width:20%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Apply Discounts
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Finance Item</label> <br />
                    <select style="width:90%;"  name="inputDiscountedItems" id="inputDiscountedItems" required>
                        <option>Select Item</option> 
                        <option value="0">General</option> 
                        <option value="1000">Other Fees</option> 
                        <?php
                        foreach ($fin_items as $i) {
                            ?>                        
                            <option value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                        <?php } ?>
                    </select>
                    <button onclick="$('#addItemModal').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                </div>
                <div class="form-group">
                    <label class="control-label">Discount Type</label>
                    <select tabindex="-1" id="inputDiscountedType" name="inputDiscountedType"  class="col-lg-12">
                        <option value="0">Percent</option>
                        <option value="1">Amount</option>

                    </select>
                </div>
                <div class="form-group">
                    <label>Value</label>
                    <input type="text" id="discount_amount" class="form-control" onclick="$(this).val('')" placeholder="Amount" />
                </div>
                <div class="form-group">
                    <label>Discount Category</label> <br />
                    <select style="width:90%;"  name="inputDiscountCategory" id="inputDiscountCategory" required>
                        <option>Select Type</option>  
                        <?php
                        foreach ($discountType as $dt) {
                            ?>                        
                            <option value="<?php echo $dt->schlr_id; ?>"><?php echo $dt->schlr_type; ?></option>
                        <?php } ?>
                    </select>
                <button onclick="$('#addDiscCatModal').modal('show'), $('#addDiscount').modal('hide')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                </div>
                <div class="form-group">
                    <label>School Year</label> <br />
                    <select style="width:100%;"  name="inputDiscountedCSY" id="inputDiscountedCSY" required>
                        <option value="0">Select School Year</option> 
<?php
foreach ($ro_years as $ro) {
    $next = ($ro->ro_years + 1);
    ?>                        
                            <option value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years . ' - ' . $next; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Semester</label>
                    <select tabindex="-1" id="inputDiscountedSem" name="inputSem"  class="col-lg-12">
                        <option>Select Semester</option>
                        <option value="1">First Semester</option>
                        <option value="2">Second Semester</option>
                        <option value="3">Summer</option>

                    </select>
                </div>
                <div class="form-group">
                    <label>Remarks</label>
                    <input type="text" id="inputDiscountedRemarks" class="form-control" onclick="$(this).val('')" placeholder="Remarks" />
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='applyDiscount()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>

    </div>
    
    <div id="addDiscCatModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Discount Category
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Discount Category</label>
                    <input type="text" id="disc_cat" class="form-control" placeholder="Category" />
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='addDiscCat()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div id="cashRegister" class="modal fade" style="width:70%; margin:30px auto; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-red">
            <div class="panel-heading clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>CASH Register

                <div class="form-group pull-right">
                    <select style="color: black;" tabindex="-1" id="inputTrType" name="inputTrType"  class="col-lg-12">
                        <option onclick="$('#chequeWrapper').hide()" value="0">Cash</option>
                        <option onclick="$('#chequeWrapper').show()" value="1">Cheque</option>
                        <option onclick="$('#chequeWrapper').show()"  value="4">Online Payment</option>
                        <option onclick="$('#chequeWrapper').hide()"  value="5">Other Payment</option>
                        <option onclick="$('#chequeWrapper').hide()"  value="6">Payroll Deduction</option>
                    </select>
                </div>

                <div class="form-group pull-right">
                    <select style="color: black;" tabindex="-1" id="inputReceipt" name="inputReceipt"  class="col-lg-12">
                        <option value="0">Official Receipt</option>
                        <option value="1">Acknowledgment Receipt</option>
                        <option value="2">Temporary Receipt</option>

                    </select>
                </div><br /><br />
                <div id="chequeWrapper" class="form-group pull-right" style="display:none;">

                    <div class="form-group">
                        <label>Bank</label>
                        <select style="width:75%; color: black;"  name="chequeBank" id="chequeBank" required>
                            <option value="0">Select Bank</option> 
                        <?php
                        foreach ($getBanks as $b) {
                            ?>                        
                                <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                            <?php } ?>
                        </select>
                        <button onclick="$('#addBank').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                    </div>
                    <div class="form-group">
                        <label>Cheque # / Online Transaction #</label>
                        <input type="text" style="width: 200px; color: black" placeholder="" id="inputCheque" />
                    </div>
                </div>

                <input type="hidden" id="charge_id" />
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="bg-info clearfix">
                        <div class="form-group col-lg-4">
                            <label>OR #</label>
                            <input type="text" id="refNumber" value="<?php echo ($FinSettings->print_receipts?$series->or_current+1:'') ?>" class="form-control" onclick="this.placeholder = $(this).val(), $(this).val('')" placeholder="OR Number" />
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="control-label" for="input">Transaction Date</label>
                            <input class="form-control" name="transactionDate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="transactionDate" placeholder="" required>

                        </div> 
                        <div class="form-group col-lg-4">
                            <label>Remarks</label>
                            <input type="text" id="transRemark" class="form-control"  placeholder="Remarks" />
                        </div>
                    </div>
                    <div id="cashRegisterWrapper">
                        <?php
                            $cashReg['plan_id'] = $plan->fin_plan_id;
                            $cashReg['loadedSubject'] = $loadedSubject;
                            $cashReg['totalSubs'] = $totalSubs;
                            $cashReg['user_id'] = $user_id;
                            $cashReg['st_id'] = $student->uid;
                            $cashReg['student'] = $student;
                            $cashReg['school_year'] = $school_year;
                            $cashReg['year_level'] = $student->year_level;
                            $cashReg['sem'] = $sem;
                            $cashReg['totalUnits'] = $totalUnits;
                            
                            $this->load->view('finance/cashRegister', $cashReg)
                        ?>
                    </div>    
                </div>
            </div>
        </div>
    </div>


    <div id="confirmPayment"  style="width:35%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-green" style='width:100%;'>
            <div class="panel-heading">
                <h3>
                    <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to confirm the payment of this student?
                </h3>
            </div>
            <div class="panel-body">
                <div style='margin:5px 0;'>
                    <button data-dismiss='modal' class='btn btn-xs btn-warning pull-right'>Cancel</button>&nbsp;&nbsp;
                    <a href='#' data-dismiss='modal' id="confirmBtn" onclick='saveTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>YES</a>
<?php if (!$student->isEnrolled): ?>
                        <div class="pull-left" >
                            <input type="checkbox" id="printRegForm" /> Enrolled Officially ?
                        </div><br /><br />
                    <?php endif; ?>    
                    <?php if ($FinSettings->print_receipts): ?>
                        <div class="pull-left" >
                            <input type="checkbox" checked="checked" id="printOR" /> PRINT Official Receipt
                        </div>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>    

    <div id="addCashItemModal" class="modal fade" style="width:15%; margin:50px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item 
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Finance Item</label> <br />
                    <select style="width:90%;"  name="cashFinItems" id="cashFinItems" required onclick="calculateItem(this.value)">
                        <option value="0">Select Item</option> 
<?php
foreach ($fin_items as $i) {
    ?>                        
                            <option id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                        <?php } ?>
                    </select>   
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input onkeypress="if(event.keyCode == 13){addToItems()}" type="text" id="edit_fin_amount" class="form-control"  placeholder="Amount" />
                </div>
            </div>
            <div class="panel-footer clearfix">
                <a href='#'data-dismiss='modal' onclick='addToItems()' style='color: white' class='btn btn-xs btn-success pull-right'>Add</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px; ">Cancel</button> &nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div id="editFinTransaction"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-yellow" style='width:100%;'>
            <div class="panel-heading">
                <h3>
                    <i class="fa fa-info-circle fa-fw"></i>Edit Finance Transaction
                </h3>
            </div>
            <div class="panel-body" id="editTransBody">

                <input type="hidden" id="delete_trans_id" />
                <input type="hidden" id="delete_item_id" />
                <input type="hidden" id="delete_trans_type" />


            </div>
            <div class="panel-footer">
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveEditTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>Save Edit</a>
                <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>
        </div>
    </div>


    <div id="deleteFinTransaction"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-red" style='width:100%;'>
            <div class="panel-heading">
                <h3>
                    <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to void this finance transaction, make sure you know what you are doing
                    ? Please note also that you can't undo this action.
                </h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="delete_trans_id" />
                <input type="hidden" id="delete_item_id" />
                <input type="hidden" id="delete_trans_type" />
                <div style='margin:5px 0;'>
                    <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='deleteFinanceTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
                    <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
                </div>

            </div>
        </div>
    </div>

    <div id="deleteExtraChargesModal"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-red" style='width:100%;'>
            <div class="panel-heading">
                <h3>
                    <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to delete this extra charges, make sure you know what you are doing
                    ? Please note also that you can't undo this action.
                </h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="delete_extra_id" />
                <div style='margin:5px 0;'>
                    <a href='#'  data-dismiss='modal' onclick='deleteExtraCharges()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
                    <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
                </div>

            </div>
        </div>
    </div>

    <div id="viewStudyLoad"  style="width:50%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="panel panel-default" style='width:100%;'>
            <button type="button" class="btn btn-xs pull-right btn-danger" style="margin-top:5px; margin-right:5px " data-dismiss="modal" aria-label="Close">
                <i class="fa fa-close"></i>
            </button>
            <div class="panel-heading">
                Study Load Details
            </div>
            <div id="SLBody" class="panel-body">

            </div>

        </div>
    </div>
</div>


<div id="transferFinTransaction"  style="margin: 50px auto;"  class="modal fade col-lg-5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Transfer Funds to Other Item / Account
            </h4>
        </div>
        <div class="panel-body" id="fundTransferBody">
            
        </div>
        <div class="panel-footer">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='processFundTransfer()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>PROCESS FUND TRANSFER</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="otherMenu">
    <ul class="dropdown-menu" role="menu">
        <li onclick="$('#transferFinTransaction').modal('show'), prepareFundTransfer()" class="pointer text-danger"><i class="fa fa-send fa-fw"></i>TRANSFER FUNDS</li>
        <li onclick="$('#editFinTransaction').modal('show'), loadFinanceTransaction()" class="pointer text-danger"><i class="fa fa-edit fa-fw"></i>EDIT TRANSACTION</li>
        <li onclick="$('#deleteFinTransaction').modal('show')" class="pointer text-danger"><i class="fa fa-trash fa-fw"></i>VOID TRANSACTION</li>
    </ul>
</div>

<div id="deleteExtraCharges">
    <ul class="dropdown-menu" role="menu">
        <li onclick="$('#deleteExtraChargesModal').modal('show')" class="pointer text-danger"><i class="fa fa-trash fa-fw"></i>Delete Extra Charges</li>
    </ul>
</div>


<div style="margin: 50px auto 0;" class="modal col-lg-3" id="loadPreviousBalance" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="previousBalanceBody" class="alert alert-danger clearfix text-center" style="margin-bottom: 0; padding: 3px;">
        <p>This student has a previous balance of <strong id="balanceAmount"></strong>. Do you want to charge this amount?</p>
        <input type="hidden" id="rawBalanceAmount" />
        <button class="btn btn-success btn-sm" onclick="loadPreviousBalance()">Yes</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
    </div>
</div>


<style type="text/css">
    .error {
        color: red;
        margin-left: 5px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function(){
       // checkPreviousBalance('<?php echo $st_id ?>','<?php echo ($school_year != NULL ? $school_year : $this->session->userdata('school_year')) ?>', '<?php echo $sem ?>');
    });
          
    function checkPreviousBalance(st_id, school_year, sem)
    {
        if(sem == 1)
        {
            school_year = parseInt(school_year) - 1;
        }
        
        sem = sem - 1;
        
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'college/finance/getBalance/' ?>'+st_id+'/'+sem+'/'+school_year,
            dataType: 'json',
            success: function (response) {
                if(response.status)
                {
                    $('#btnBalance').show();
                    $('#balanceAmount').html(response.balance);
                    $('#rawBalanceAmount').val(response.rawBalance);
                }
                
                
                console.log(response);
            }

        });
    }
    
    
    var itemDescID = "";
    var Amount = 0;
    var itemId = "";
    window.setTimeout(function () {
        $('#inputFinItems').select2();
        $('#cashFinItems').select2();
        $('#inputDiscountedItems').select2();
        $('#transactionDate').datepicker({
            orientation: "left"
        });
        $('#inputFinItems').click(function () {
            if ($(this).val() == 0)
            {
                $('#addFinanceOption').modal('hide');
                $('#addDiscount').modal('show');
                $('#inputDiscountCategory').select2();
            }

        });
    }, 500);
    
    
    
    function loadPreviousBalance()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/loadPreviousBalance/' ?>',
           // dataType: 'json',
            data: {
                user_id         : '<?php echo $user_id ?>',
                st_id           : '<?php echo $st_id ?>',
                school_year     : '<?php echo ($school_year != NULL ? $school_year : $this->session->userdata('school_year')) ?>',
                semester        : '<?php echo $sem ?>',
                balance         : $('#rawBalanceAmount').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
                
            }

        });
    }

    function payNow() {
        var ornum = $('#refNumber').val();
        if (ornum == '') {
            $('#refNumber').after('<span class="error">OR Number is required</span>');
        } else {
            $('#confirmPayment').modal('show');
        }
    }
           
    function prepareFundTransfer()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/prepareFundTransfer' ?>',
            //dataType: 'json',
            data: {
                st_id           : $('#st_id').val(),
                name            : '<?php echo $student->firstname . " " . $student->lastname ?>',
                school_year     : $('#currentYear').val(),
                semester        : $('#inputSem').val(),
                trans_id        : $('#delete_trans_id').val(),
                item_id         : $('#delete_trans_item_id').val(),
                trans_type      : $('#delete_trans_type').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#fundTransferBody').html(response);
            }

        });
    }
    
      
    function searchTransferAccount(value)
    {
        var school_year = $('#transferSchoolYear').val()
        var url = '<?php echo base_url().'college/finance/searchFundTransferAccount/' ?>'+value+'/'+school_year;
          $.ajax({
             type: "GET",
             url: url,
             data: "id="+value, // serializes the form's elements.
             success: function(data)
             {
                   $('#searchTransferName').show();
                   $('#searchTransferName').html(data);
             }
           });

      return false;
    }

    function saveEditTransaction()
    {
        var trans_id = $('#edit_trans_id').val();
        var ref_number = $('#editRefNumber').val();
        var editTransDate = $('#editTransactionDate').val();
        var transAmount = $('#editTransAmount').val();
        var receipt = $('#inputEditReceipt').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/saveEditTransaction' ?>',
            //dataType: 'json',
            data: {
                trans_id: trans_id,
                ref_number: ref_number,
                trans_date: editTransDate,
                amount: transAmount,
                receipt: receipt,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }

    function loadFinanceTransaction()
    {
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/loadFinanceTransaction' ?>',
            //dataType: 'json',
            data: {
                trans_id: trans_id,
                item_id: item_id,
                trans_type: trans_type,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#editTransBody').html(response);
                $('#editTransactionDate').datepicker();
            }

        });
    }


    function printPermit(adm_id)
    {
        var url = "<?php echo base_url('college/finance/printPermit/') ?>" + adm_id
        window.open(url, '_blank');
    }
    

    function viewSL(adm_id, sem)
    {

        var url = "<?php echo base_url() . 'college/subjectmanagement/getStudyLoad/' ?>" + adm_id + '/' + sem; // the script where you handle the form input.

        $.ajax({
            type: "GET",
            url: url,
            //dataType:'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#viewStudyLoad').modal('show')
                $('#SLBody').html(data)
            }
        });

        return false;
    }

    function promisoryAction(action)
    {
        var prom_id = $('#request_id').val()
        var amount = $('#request_amount').val();


        var url = "<?php echo base_url() . 'college/finance/approvePromisory' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "amount=" + amount + "&prom_id=" + prom_id + "&action=" + action + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data);
            }
        });

        return false;
    }


    function requestPromisory()
    {
        var sem = $('#inputSem').val();
        var st_id = $('#st_id').val();
        var remarks = $('#promisoryRemarks').val();

        var url = "<?php echo base_url() . 'college/finance/requestPromisory' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "remarks=" + remarks + "&st_id=" + st_id + "&semester=" + sem + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data);
            }
        });

        return false;
    }

    function addToItems()
    {

        var itemAmount = $("#edit_fin_amount").val();
        Amount = parseFloat(Amount) + parseFloat(itemAmount);
        $('#itemBody').append('<tr tr_val="' + itemId + '_' + itemAmount + '" id="' + itemId + '"><td>' + itemDescID + '</td><td>' + itemAmount + '</td><td><button onclick="$(\'#' + itemId + '\').hide(), deductAmount(' + itemAmount + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td></tr>');
        $('#pttAmount').val(Amount)

        $("#edit_fin_amount").val('');
    }

    function deductAmount(itemAmount)
    {
        Amount = parseFloat(Amount) - parseFloat(itemAmount);
        $('#pttAmount').val(Amount)
    }

    function cash_change()
    {
        var item_amount = document.getElementById("pttAmount").value;
        if (item_amount != '') {
            var con_amount = string2number(item_amount);
        } else {
            var con_amount = 0;
        }
        var tend_amount = document.getElementById('ptAmountTendered').value;
        var con_tendered = string2number(tend_amount);

        calc_change = con_tendered - con_amount;
        tot_change = number2string(calc_change);
        document.getElementById('ptChange').value = tot_change;

    }

    function deleteFinanceTransaction()
    {
        var trans_id = $('#delete_trans_id').val();
        var trans_type = $('#delete_trans_type').val();
        var st_id = $('#st_id').val();
        var sem = 0;
        var sy = $('#currentYear').val();
        var item_id = $('#delete_item_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/deleteTransaction' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                sem: sem,
                school_year: sy,
                trans_id: trans_id,
                trans_type: trans_type,
                item_id: item_id,
                delete_remarks: $('#td_trans_' + trans_id).attr('delete_remarks'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }

    function deleteExtraCharges()
    {
        var trans_id = $('#delete_extra_id').val();
        var st_id = $('#st_id').val();
        var sy = $('#currentYear').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/deleteExtraCharges' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                school_year: sy,
                trans_id: trans_id,
                delete_remarks: $('#trExtra_' + trans_id).attr('delete_remarks'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }

    function saveTransaction()
    {
        var or_num = $('#refNumber').val();
        var st_id = $('#st_id').val();
        var sem = $('#currentSemester').val();
        var sy = $('#currentYear').val();
        var transDate = $('#transactionDate').val();
        var transType = $('#inputTrType').val();
        if (transType == 1 || transType == 4) {
            var chequeNumber = $('#inputCheque').val();
            var bank = $('#chequeBank').val();
        } else {
            chequeNumber = 0;
            bank = 0;
        }

        var data = [];
        $('#itemBody tr').each(function () {
            if ($(this).attr('tr_val') != "")
            {
                data.push($(this).attr('tr_val'));
            }
        });

        // alert(data);

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/saveTransaction' ?>',
            //dataType: 'json',
            data: {
                items: JSON.stringify(data),
                or_num: or_num,
                st_id: st_id,
                sem: sem,
                school_year: sy,
                transDate: transDate,
                transType: transType,
                chequeNumber: chequeNumber,
                bank: bank,
                receipt: $('#inputReceipt').val(),
                t_remarks: $('#transRemark').val(),
                csrf_test_name: $.cookie('csrf_cookie_name'),
                isEnrolled: ($('#printRegForm').is(':checked') ? 0 : 1),
                admission_id: '<?php echo $student->admission_id ?>',
            },
            success: function (response) {
                //alert(response);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'college/finance/updateOR/' ?>' + or_num,
                    //dataType: 'json',
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (response) {
                        //alert(response)
                    }
                
                });

                    <?php if ($FinSettings->print_receipts): ?>
                                        if ($('#printOR').is(':checked')) {
                var printUrl = '<?php echo base_url('college/finance/printOR/' . base64_encode($student->uid) . '/') ?>' + or_num + '/' + (transType == 0 ? 'Cash' : 'Cheque') + '/' + $('#ptAmountTendered').val() + '/' + sy + '/' + sem;
                window.open(printUrl, '_blank');
                $('#printURL').val(printUrl);
                                            $('#CloseCashRegistrar').modal('show')
                                        }
                    <?php endif; ?>

                location.reload();


            }

        });
    }


    function calculateItem(item_id)
    {
        itemId = item_id;
        var totalUnits = $('#totalUnits').val();
        var plan_id = $('#finPlan_id').val();
        var sem = $('#currentSemester').val();
        var sy = $('#currentYear').val();
        var st_id = $('#st_id').val();
        var url = '<?php echo base_url() . 'college/finance/calculateItem' ?>';

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "item_id=" + item_id + '&plan_id=' + plan_id + '&sem=' + sem + '&school_year=' + sy + '&st_id=' + st_id + '&totalUnits=' + totalUnits + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#edit_fin_amount').attr('placeholder', data.totalPayment);
                itemDescID = $('#' + item_id + '_desc').html();
            }
        });

        return false;
    }


    function applyDiscount()
    {
        var sem = $('#inputDiscountedSem').val();
        var school_year = $('#inputDiscountedCSY').val();
        var otherFees = $('#otherFees').attr('otherFees');
        var discountType = $('#inputDiscountedType').val();
        var finItem = $('#inputDiscountedItems').val();
        var finAmount = $('#discount_amount').val();
        var st_id = $('#st_id').val();
        var remarks = $('#inputDiscountedRemarks').val();
        var finYear = $('#year_level').val();
        var admission_id = $('#admission_id').val();
        var plan_id = $('#finPlan_id').val();
        var discountCategory = $('#inputDiscountCategory').val();

        var url = "<?php echo base_url() . 'college/finance/applyDiscounts' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data:{
                finItem         : finItem,
                st_id           : st_id,
                plan_id         : plan_id,
                remarks         : remarks,
                admission_id    : admission_id,
                discount_type   : discountType,
                discountCategory: discountCategory,
                year_level      : finYear,
                semester        : sem,
                finAmount       : finAmount,
                school_year     : school_year,
                otherFees       : otherFees,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            
            success: function (data)
            {

                alert(data);
                location.reload();

            }
        });

        return false;
    }

    function addExtraFinanceCharges()
    {
        var sem = $('#inputSem').val();
        var school_year = $('#inputCSY').val()
        var finItem = $('#inputFinItems').val();
        var finAmount = $('#fin_amount').val();
        var st_id = $('#st_id').val();
         var user_id = '<?php echo $user_id ?>';
        var admission_id = $('#admission_id').val();
        var finYear = $('#year_level').val();
        var plan_id = $('#finPlan_id').val();

        var url = "<?php echo base_url() . 'college/finance/addExtraFinanceCharges' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "finItem=" + finItem + "&st_id=" + st_id +"&user_id="+user_id+ "&plan_id=" + plan_id + "&admission_id=" + admission_id + "&year_level=" + finYear + "&semester=" + sem + "&finAmount=" + finAmount + "&school_year=" + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                window.setTimeout(function () {
                    $('#finChargesBody').html(data)
                }, 500);
                alert('Successfully Added');
                location.reload();

            }
        });

        return false;
    }

    function setExtraFinanceCharges(course_id, year_level)
    {
        $('#addFinanceOption').modal('show');
        $('#course_id').val(course_id);
        $('#year_level').val(year_level);
    }

    function number2string(sNumber)
    {
        //Seperates the components of the number
        var n = sNumber.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    }

    function string2number(svariable)
    {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }


    function search(value)
    {

        var sy = $('#inputSY').val();
        var url = '<?php echo base_url() . 'search/searchStudentAccounts/' ?>' + value + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#searchName').show();
                $('#searchName').html(data);
            }
        });

        return false;
    }
</script>