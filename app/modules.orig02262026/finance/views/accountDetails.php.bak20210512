<?php
$student = Modules::run('finance/getBasicStudent', base64_decode($st_id), $school_year, $semester);


$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0,$student->st_type, $student->school_year);
$charges = Modules::run('finance/financeChargesByPlan',0, $student->school_year, 0, $plan->fin_plan_id, $student->semester );
$addCharge = Modules::run('college/finance/financeChargesByPlan',NULL, $student->school_year, $student->semester  );

Modules::run('finance/setFinanceAccount', $student->user_id, $student->school_year, $student->grade_id, $student->semester,$student->st_type);

$financeAccount = Modules::run('finance/getFinanceAccount', $student->st_id);

?>

<div class="well col-lg-12" id="profBody">
    <div class="col-lg-2">
        <?php
        $user_id = $student->user_id;
        ?>
        <div>
            <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php if($student->avatar!=""):echo base_url().'uploads/'.$student->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
        </div>
    </div>
    <div class="col-lg-6">
        <h2 style="margin:3px 0;">
            <span id="name" style="color:#BB0000;"><?php echo $student->firstname." ". $student->lastname ?></span></h2>
        <h4 style="color:black; margin:3px 0;"><?php echo $student->level; ?> - <span id="a_section"><?php echo $student->section; ?></span></h4>
        <h3 style="color:black; margin:3px 0;">
            <small>
                <a title="double click to edit" id="a_user_id"  style="color:#BB0000;">
                     <?php echo $student->st_id ?>
                 </a>
            </small>
        </h3>
        <div id='student_type' class='control-group' style='width:230px;'>
            <div class='controls'>
              <select onclick="setStudentType(this.value)" name='inputStudentType' style='width:230px;' id='inputStudentType' class='pull-left controls' required>
                    <option >Select Student Type</option>
                    <?php
                        $plan_type = Modules::run('finance/getPlanType', $now);
                        foreach($plan_type as $pt):
                    ?>
                        <option <?php echo ($student->st_type==$pt->fin_type_id?'selected':'') ?> value="<?php echo $pt->fin_type_id ?>"><?php echo $pt->fin_plan_type ?></option>
                    <?php endforeach; ?>
              </select>
            </div>
        </div>
        
    </div>
    <input type="hidden" id="st_id" value="<?php echo $student->st_id ?>" /> 
    <input type="hidden" id="grade_id" />
    <input type="hidden" id="finPlan_id" value="<?php echo $plan->fin_plan_id ?>" />
    <input type="hidden" id="admission_id" value="<?php echo $student->admission_id ?>" />
    <input type="hidden" id="currentYear" value="<?php echo $school_year?>" />
    <div class="btn-group-vertical pull-right">
        <a href="<?php echo base_url('finance/printPermit/' . $this->uri->segment(3)) ?>" target="_blank" class="btn btn-default btn-xs">Print Exam Permit</a>
    </div>
</div>
<div style="margin-top: 10px;" class="col-lg-12 no-padding">
        <div class="col-lg-5">
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
                                        <button title="Set Finance Charges" class="btn btn-xs btn-info" onclick="setExtraFinanceCharges('<?php echo $student->grade_id ?>')"><i class="fa fa-plus fa-fw"></i></button>
                                        <!--<button title="Print Finance Charges" class="btn btn-xs btn-success" onclick="printFinanceCharges($('#selectCourse').val(), '<?php echo $student->year_level ?>')"><i class="fa fa-print fa-fw"></i></button>-->
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
                            $i=1;
                            $total=0;
                            $amount=0;
                            foreach ($charges as $c):
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
                           endforeach;
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
        </div>
        <div class="col-lg-7">
            <div class='panel panel-success'>
                <div class='panel-heading clearfix'>
                    <h5 class="pull-left">Payment/Discount History 
                    </h5>
                    <a href="<?php echo base_url('finance/printSOA/' . $this->uri->segment(3).'/').$school_year.'/'.$student->semester ?>" target="_blank" class="pull-right btn btn-danger" id="btnPrint"><i class="fa fa-print fa-2x"></i></a>
                    <button onclick="$('#cashRegister').modal('show')" class="pull-right btn btn-warning" id="btnPOS"><i class="fa fa-money fa-2x"></i></button>
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

    <div class="col-lg-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                Online Deposit Slips / Receipts
            </div>
            <div class="panel-body clearfix">
            <?php 
                $directory = 'uploads/'.$student->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->st_id.DIRECTORY_SEPARATOR.'online_payments';
                $scanFiles = scandir($directory);
                $files = array_diff($scanFiles, array('..', '.'));
                foreach ($files as $file):
                    $remarks = Modules::run('finance/getPaymentRemarksByFile', $file, $student->school_year);
                ?>
                <div class="col-lg-2">
                    <img class="img-responsive myImg" remarks="<?php echo $remarks->opr_remarks ?>" style="width: 200px; float: left;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="<?php echo $file ?>">
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
                  <option value="">Apply Discount</option> 
                    <?php 
                           foreach ($fin_items as $i)
                             {   
                       ?>                        
                            <option value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php }?>
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
                           foreach ($ro_years as $ro)
                             {   
                               $next = ($ro->ro_years+1);
                       ?>                        
                            <option <?php echo ($ro->ro_years==$this->session->school_year?'selected':'') ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$next; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" id="extraSem" value="<?php echo $semester ?>" />
        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addExtraFinanceCharges()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
        
    </div>
        
</div>

<div id="addItemModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item    
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Item</label>
                <input  type="text" id="fin_item" class="form-control" placeholder="Item" />
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
                    <?php 
                           foreach ($fin_items as $i)
                             {   
                       ?>                        
                            <option value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php }?>
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
            </div>
            <div class="form-group">
                <label>School Year</label> <br />
                <select style="width:100%;"  name="inputDiscountedCSY" id="inputDiscountedCSY" required>
                  <option value="0">Select School Year</option> 
                    <?php 
                           foreach ($ro_years as $ro)
                             {   
                               $next = ($ro->ro_years+1);
                       ?>                        
                            <option value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$next; ?></option>
                    <?php }?>
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

<!--<div id="cashRegister" class="modal fade" style="width:70%; margin:30px auto; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-red">
        <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>CASH Register
            
            <div class="form-group pull-right">
                <select style="color: black;" tabindex="-1" id="inputTrType" name="inputTrType"  class="col-lg-12">
                   <option onclick="$('#chequeWrapper').hide()" value="0">Cash</option>
                   <option onclick="$('#chequeWrapper').show()" value="1">Cheque</option>
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
                               foreach ($getBanks as $b)
                                 {   
                           ?>                        
                                <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                        <?php }?>
                    </select>
                    <button onclick="$('#addBank').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                </div>
                <div class="form-group">
                    <label>Cheque #</label>
                    <input type="text" style="width: 200px; color: black" placeholder="" id="inputCheque" />
                </div>
            </div>
            <input type="hidden" id="charge_id" />
        </div>
         <div class="panel-body">
             <div class="col-lg-8">
                 <div class="bg-info clearfix">
                     <div class="form-group col-lg-4">
                        <label>OR #</label>
                        <input type="text" id="refNumber" value="<?php echo ($financeSettings->print_receipts?$series->or_current+1:'') ?>" <?php echo ($finSettings->print_receipts?'readonly':'')?> class="form-control"  placeholder="OR Number" />
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
                <div class="well col-lg-12 no-padding">
                    <table class="table table-striped">
                        <tr>
                            <th>Item Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="itemBody">
                            
                        </tbody>
                    </table>
                </div>    
             </div>
             
            <div class="col-lg-4 text-center no-padding">
                <div class="panel panel-default">
                    <div class="panel-body bg-primary text-center">
                        <button type="button" onclick="$('#addCashItemModal').modal('show')" class="btn btn-info" id="add_items" style="width: 100%; height: 40px;"><i class="fa fa-plus fa-lg fa-fw"></i><b>Add Items</b></button>
                        <h4>T O T A L</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: red; width: 100%;" name="pttAmount" id="pttAmount" disabled>
                        <h4>Amount Tendered</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: green; width: 100%;" name="ptAmountTendered" id="ptAmountTendered" onblur="cash_change()" required>
                        <h4>C H A N G E</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: blue; width: 100%;" name="ptChange" id="ptChange" disabled>
                        <div class="row">
                            <div class="col-xs-12 col-md-12" style="margin-top: 20px;">
                                <button type="button" class="btn btn-success" id="paynow" onclick="$('#confirmPayment').modal('show') " style="width: 100%; height: 60px;"><i class="fa fa-thumbs-up fa-lg fa-fw"></i><b>PAY NOW!!!</b></button>
                                <button data-dismiss="modal" type="button" class="btn btn-danger" id="cancel_trans" style="width: 100%; height: 40px; margin-top: 10px;"><b><i class="fa fa-times fa-lg fa-fw"></i>C A N C E L</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
         </div>
     </div>
</div>-->

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
                               foreach ($getBanks as $b)
                                 {   
                           ?>                        
                                <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                        <?php }?>
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
                        <input type="text" id="refNumber" value="<?php echo ($financeSettings->print_receipts?($series?$series->or_current:0)+1:'') ?>"  class="form-control"  placeholder="OR Number" />
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
                <div class="well col-lg-12 no-padding">
                    <div id="ro_section" class="pull-right">
                        
                    </div>
                    <div id="cashRegisterWrapper">
                        <?php 
                        
                        $settings = Modules::run('main/getSet');
                        $cashReg['plan_id'] = $plan->fin_plan_id;
                        $cashReg['user_id'] = $user_id;
                        $cashReg['st_id']    = $student->st_id;
                        $cashReg['student']    = $student;
                        $cashReg['school_year'] = $school_year;
                        $cashReg['semester'] = $student->semester;
                        $cashReg['charges'] = $charges;
                        
                        if(file_exists(APPPATH.'modules/finance/views/'. strtolower($settings->short_name).'_cashRegister.php')):
                            $this->load->view(strtolower($settings->short_name).'_cashRegister', $cashReg);
                        else:
                            $this->load->view('cashRegister', $cashReg);
                        endif;
                        
                        ?>
                    </div>    
                </div>    
             </div>
         </div>
     </div>
</div>
<div id="confirmPayment"  style="width:35%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to confirm the payment of this student?.
            </h3>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='modal' id="confirmBtn" onclick='saveTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>YES</a>
            
            <?php if($finSettings->print_receipts):?>
                <div class="pull-left" >
                    <input type="checkbox" checked="checked" id="printOR" /> PRINT Official Receipt
                </div>
            
            <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<div id="editFinTransaction"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Edit Finance Transaction
            </h4>
        </div>
        <div class="panel-body" id="editTransBody">
                
           

        </div>
        <div class="panel-footer">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveEditTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>Save Edit</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>
<div id="refundTransaction"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Process a Refund
            </h4>
        </div>
        <div class="panel-body" id="refundTransBody">
                
           

        </div>
        <div class="panel-footer">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveRefundTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>Refund</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
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
                           foreach ($fin_items as $i)
                             {   
                       ?>                        
                            <option id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php }?>
                </select>   
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="edit_fin_amount" class="form-control"  placeholder="Amount" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addToItems()' style='color: white' class='btn btn-xs btn-success pull-right'>Add</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px; ">Cancel</button> &nbsp;&nbsp;
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

<div id="deleteFinExtra"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to void this finance charges, make sure you know what you are doing
                ? Please note also that you can't undo this action.
            </h3>
        </div>
        <div class="panel-body">
                <input type="hidden" id="delete_trans_id" />
                <input type="hidden" id="delete_item_id" />
                <input type="hidden" id="delete_trans_type" />
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='deleteFinanceExtraCharge()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>

<div id="otherMenu">
    <?php 
      $pos = $this->session->userdata('position_id');
      if ($pos!=40) {
    ?>
    <ul class="dropdown-menu" role="menu">
        <li onclick="$('#transferFinTransaction').modal('show'), prepareFundTransfer()" class="pointer text-danger"><a  class="pointer text-danger" href="#">  <i class="fa fa-send fa-fw"></i>TRANSFER FUNDS</a></li>
        <li onclick="$('#refundTransaction').modal('show'), loadRefundTransaction()"><a  class="pointer text-danger" href="#"> <i class="fa fa-reply fa-fw"></i>REFUND</a></li>
        <li onclick="$('#editFinTransaction').modal('show'), loadFinanceTransaction()"><a  class="pointer text-danger" href="#"> <i class="fa fa-edit fa-fw"></i>EDIT TRANSACTION</a></li>
        <li onclick="$('#deleteFinTransaction').modal('show')" class="pointer text-danger"><a  class="pointer text-danger" href="#"> <i class="fa fa-trash fa-fw"></i>VOID TRANSACTION</a></li>
    </ul>
    <?php
      }else{
    ?>
    <ul class="dropdown-menu" role="menu">
        <li class="pointer text-danger"><a  class="pointer text-danger" href="#">  <i class="fa fa-times fa-fw"></i>You are not allowed to access the options. Please contact your finance head.</a></li>
    </ul>
    <?php
      }
    ?>
</div>
<div id="extraMenu">
    <ul class="dropdown-menu" role="menu">
        <li onclick="$('#deleteFinExtra').modal('show')" class="pointer text-danger"><i class="fa fa-trash fa-fw"></i>DELETE EXTRA CHARGE</li>
    </ul>
</div>       

<script type="text/javascript">
    
    var itemDescID = "";
    var Amount = 0;
    var itemId = "";
    var printUrl = "";
    window.setTimeout(function () {
        selectSection('<?php echo $student->grade_id+1 ?>'); 
        $('#inputFinItems').select2();
        $('#cashFinItems').select2();
        $('#inputDiscountedItems').select2();
        $('#transactionDate').datepicker({
            orientation: "left"
        });
        $('#inputFinItems').click(function(){
            if($(this).val()=="")
            {
                $('#addFinanceOption').modal('hide');
                $('#addDiscount').modal('show');
                $('#inputDiscountCategory').select2();
            }
            
        });
    }, 500);
    
    function setStudentType()
    {
        var st_type = $('#inputStudentType').val();
        var admission_id = $('#admission_id').val();
        var user_id = '<?php echo $user_id ?>';
        var school_year = $('#currentYear').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/setStudentType' ?>',
            //dataType: 'json',
            data: {
                school_year : school_year,
                st_type: st_type,
                admission_id: admission_id,
                user_id: user_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
        
    }
    
    
    function rollOver(st_id, level_id)
    {
        $('#cashRegisterRO').modal('show');
        selectSection(level_id);
        
    }
    
   function searchTransferAccount(value)
  {
      var school_year = $('#transferSchoolYear').val()
      var url = '<?php echo base_url().'finance/finance_pisd/searchFundTransferAccount/' ?>'+value+'/'+school_year;
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
    
    
    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   
                   $('#inputSection').html(data);
               }
             });

        return false;
    }
    
    
    function addToItems()
    {
        
        var itemAmount = $("#edit_fin_amount").val();
        Amount = parseFloat(Amount) + parseFloat(itemAmount);
        $('#itemBody').append('<tr tr_val="'+itemId+'_'+itemAmount+'" id="'+itemId+'"><td>'+itemDescID+'</td><td>'+itemAmount+'</td><td><button onclick="$(\'#'+itemId+'\').hide(), deductAmount('+itemAmount+')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td></tr>');
        $('#pttAmount').val(Amount)
        
        $("#edit_fin_amount").val('') ;
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
    
    function deleteFinanceExtraCharge()
    {
        var trans_id = $('#delete_trans_id').val();
        var st_id = '<?php echo $user_id ?>';
        var sem = 0;
        var sy = $('#inputSchoolYear').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/deleteFinanceExtraCharge' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                sem: sem,
                school_year:sy,
                trans_id:trans_id,
                delete_remarks: $('#trExtra_'+trans_id).attr('delete_remarks'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }
    
    function deleteFinanceTransaction()
    {
        var trans_id = $('#delete_trans_id').val();
        var trans_type = $('#delete_trans_type').val();
        var st_id = $('#st_id').val();
        var sem = '<?php echo $student->semester ?>';
        var sy = $('#inputSchoolYear').val();
        var item_id = $('#delete_item_id').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/deleteTransaction' ?>',
            //dataType: 'json',
            data: {
                st_id: st_id,
                sem: sem,
                school_year:sy,
                trans_id:trans_id,
                trans_type:trans_type,
                item_id: item_id,
                delete_remarks: $('#td_trans_'+trans_id).attr('delete_remarks'),
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
        var sem = '<?php echo $semester ?>';
        var sy = $('#inputSchoolYear').val();
        var transDate = $('#transactionDate').val();
        var transType = $('#inputTrType').val();
        if(transType==1){
            var chequeNumber = $('#inputCheque').val();
            var bank = $('#chequeBank').val();
        }else{
            chequeNumber = 0;
            bank = 0;
        }    
        
        var data = [];
        $('#itemBody tr').each(function(){
            if($(this).attr('tr_val')!="")
            {
                data.push($(this).attr('tr_val'));
            }
        });
        
       // alert(data);
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveTransaction' ?>',
            //dataType: 'json',
            data: {
                items: JSON.stringify(data),
                or_num: or_num,
                st_id: st_id,
                sem: sem,
                school_year:sy,
                transDate:transDate,
                transType:transType,
                chequeNumber:chequeNumber,
                bank: bank,
                receipt: $('#inputReceipt').val(),
                t_remarks: $('#transRemark').val(),
                csrf_test_name: $.cookie('csrf_cookie_name'),
                isEnrolled: ($('#printRegForm').is(':checked')?0:1),
                admission_id: '<?php echo $student->admission_id ?>'
                },
            success: function (response) {
                //alert(response);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'finance/updateOR/' ?>'+or_num,
                    //dataType: 'json',
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (response) {
                        //alert(response)
                    }

                });
                
                <?php if(file_exists(APPPATH.'modules/reports/views/'. strtolower($settings->short_name).'_registration_form.php')): ?>
                if($('#printRegForm').is(':checked')){
                    var url = "<?php echo base_url('reports/printRegistrationForm/').base64_encode($student->st_id)?>/"+sy;
                    window.open(url, '_blank');
                }
                <?php endif; ?>
                
                <?php if($finSettings->print_receipts):?>
                    if($('#printOR').is(':checked')){
                        var printUrl = '<?php echo base_url('finance/printOR/'.base64_encode($student->st_id).'/')?>'+or_num+'/'+(transType==0?'Cash':'Cheque')+'/'+$('#ptAmountTendered').val()+'/'+sy;
                        window.open(printUrl, '_blank');   
                        $('#printURL').val(printUrl);
                        $('#confirmCloseCashRegistrar').modal('show')
                    }
                <?php endif; ?>
                
                location.reload();
                
                 
            }

        });
    }
    
             
    function saveRefundTransaction()
    {
        var trans_id = $('#refund_trans_id').val();
        var item_id = $('#refundFinItems').val();
        var ref_number = $('#refundRefNumber').val();
        var editTransDate = $('#refundTransactionDate').val();
        var transAmount = $('#refundTransAmount').val();
        var origAmount = $('#refundOrigAmount').val();
        var receipt = $('#refundEditReceipt').val();
        var sy = $('#inputSchoolYear').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveRefundTransaction' ?>',
            //dataType: 'json',
            data: {
                origAmount      : origAmount,
                school_year     : sy,
                item_id         : item_id,
                trans_id        : trans_id,
                ref_number      : ref_number,
                trans_date      : editTransDate,
                amount          : transAmount,
                receipt         : receipt,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }
             
    function saveEditTransaction()
    {
        var trans_id = $('#edit_trans_id').val();
        var item_id = $('#editFinItems').val();
        var ref_number = $('#editRefNumber').val();
        var editTransDate = $('#editTransactionDate').val();
        var transAmount = $('#editTransAmount').val();
        var receipt = $('#inputEditReceipt').val();
        var sy = $('#inputSchoolYear').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveEditTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year     : sy,
                item_id         : item_id,
                trans_id        : trans_id,
                ref_number      : ref_number,
                trans_date      : editTransDate,
                amount          : transAmount,
                receipt         : receipt,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }
    
    $(document).ready(function(){
        
        shortcut.add("Ctrl+1",function() {
            location.reload();
        });
        shortcut.add("PageDown",function() {
            $('#confirmPayment').modal('show')
        });
        shortcut.add("Insert",function() {
            window.setTimeout(function () { 
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });
        
        $('#inputStudentType').select2();
        
    });
    
    function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function() {
                    return (false);
                };
                window.onhelp = function() {
                    return (false);
                };
            }
            evt.returnValue = false;
            evt.keyCode = 0;
            window.status = msg;
            evt.preventDefault();
            evt.stopPropagation();
            //alert(msg);
        }

        window.status = "Done";

    }


    if (window.document.addEventListener) {
        window.document.addEventListener("keydown", avoidInvalidKeyStorkes, false);
    } else {
        window.document.attachEvent("onkeydown", avoidInvalidKeyStorkes);
        document.captureEvents(Event.KEYDOWN);
    }
    
    $('#reprintUrl').click(function(){
        window.open($('#printURL').val(), '_blank');  
    })
    
    function saveAccount(user_id)
    {
        var account = $('#account').val();
        var url = '<?php echo base_url().'finance/updateAccount'?>';

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "user_id="+user_id+'&account='+account+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   location.reload();
               }
             });

        return false; 
    }
    
    function calculateItem(item_id)
    {
         itemId = item_id;
         var totalUnits = $('#totalUnits').val();
         var plan_id = $('#finPlan_id').val();
         var sem = $('#currentSemester').val();
         var sy = $('#inputSchoolYear').val();
         var st_id = $('#st_id').val();
        var url = '<?php echo base_url().'finance/calculateItem'?>';

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "item_id="+item_id+'&plan_id='+plan_id+'&sem='+sem+'&school_year='+sy+'&st_id='+st_id+'&totalUnits='+totalUnits+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#edit_fin_amount').attr('placeholder', data.totalPayment);
                   itemDescID = $('#'+item_id+'_desc').html();
               }
             });

        return false; 
    }
    
    
    function applyDiscount()
     {
         var sem = $('#inputDiscountedSem').val();
         var school_year = $('#inputDiscountedCSY').val()
         var discountType = $('#inputDiscountedType').val();
         var finItem = $('#inputDiscountedItems').val();
         var finAmount = $('#discount_amount').val();
         var st_id = $('#st_id').val();
         var remarks = $('#inputDiscountedRemarks').val();
         var finYear = $('#year_level').val();
         var admission_id = $('#admission_id').val();
         var plan_id = $('#finPlan_id').val();
        var discountCategory = $('#inputDiscountCategory').val();
         
        var url = "<?php echo base_url().'finance/applyDiscounts'?>"; // the script where you handle the form input.

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
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
               success: function(data)
               {
                    //alert(data)
                    alert('Discount Successfully Added');
                    location.reload();
                  
               }
             });

        return false; 
     }
    
    function addExtraFinanceCharges()
     {
         var school_year = $('#inputCSY').val()
         var finItem = $('#inputFinItems').val();
         var finAmount = $('#fin_amount').val();
         var st_id = $('#st_id').val();
         var user_id = '<?php echo $user_id ?>';
         var admission_id = $('#admission_id').val();
         var finYear = $('#year_level').val();
         var plan_id = $('#finPlan_id').val();
         var semester = $('#extraSem').val();
         
        var url = "<?php echo base_url().'finance/addExtraFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "finItem="+finItem+"&st_id="+st_id+"&user_id="+user_id+"&plan_id="+plan_id+"&admission_id="+admission_id+"&year_level="+finYear+"&semester="+semester+"&finAmount="+finAmount+"&school_year="+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   location.reload();
                  
               }
             });

        return false; 
     }
     
                
    function prepareFundTransfer()
    {
        var school_year = $('#inputSchoolYear').val();
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();
        var st_id = $('#st_id').val();
        var name = '<?php echo strtoupper($student->firstname." ". $student->lastname) ?>';
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/finance_pisd/prepareFundTransfer' ?>',
            //dataType: 'json',
            data: {
                st_id           : st_id,
                name            : name,
                school_year     : school_year,
                trans_id        : trans_id,
                item_id         : item_id,
                trans_type      : trans_type,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#fundTransferBody').html(response);
            }

        });
    } 
                
    function loadRefundTransaction()
    {
        var school_year = $('#inputSchoolYear').val();
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/loadRefundTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year     : school_year,
                trans_id        : trans_id,
                item_id         : item_id,
                trans_type      : trans_type,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#refundTransBody').html(response);
                
            }

        });
    } 
                
    function loadFinanceTransaction()
    {
        var school_year = $('#inputSchoolYear').val();
        var trans_id = $('#delete_trans_id').val();
        var item_id = $('#delete_trans_item_id').val();
        var trans_type = $('#delete_trans_type').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/loadFinanceTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year     : school_year,
                trans_id        : trans_id,
                item_id         : item_id,
                trans_type      : trans_type,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#editTransBody').html(response);
                $('#editTransactionDate').datepicker();
            }

        });
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
   

    </script>