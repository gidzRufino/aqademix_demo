<?php
$loadedSubject = Modules::run('registrar/getOvrLoadSub', $student->st_id, $student->semester, $student->school_year);
?>
<div class="well col-lg-12" id="profBody">
    <button title="Use this button if the student withdraw from enrollment" onclick="removeEnrollmentDetails('<?php echo base64_encode($student->admission_id) ?>', '<?php echo $student->school_year ?>')" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash fa-2x"></i></button>
    <h3 style="margin:3px 0;"><span id="name" style="color:#BB0000;"><?php echo ucwords(strtolower($student->firstname . ' ' . $student->lastname)) . ' ( ' . $student->st_id . ' )' ?></span></h3>
    <h4 style="color:black; margin:3px 0;"><?php echo strtoupper($student->level) ?><span id="a_section"></span> </h4>
    <input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
    <input type="hidden" id="user_id" value="<?php echo base64_encode($student->user_id) ?>" />
    <input type="hidden" id="school_year" value="<?php echo $student->school_year ?>" />
    <input type="hidden" id="semester" value="<?php echo $student->semester ?>" />
    <input type="hidden" id="adm_id" value="<?php echo $student->admission_id ?>" />

</div>
<div class="col-lg-12 no-padding">
    <button class="btn btn-xs btn-warning pull-right" style="margin-left:10px;" onclick="$('#sendSMSDetails').modal('show'), $('#mobileNo').val('<?php echo  base64_encode($student->ice_contact) ?>')">Send SMS</button>
    <?php if($student->semester==3): ?>
    <table class="table table-striped table-bordered table-responsive" id="">
        <tr>
            <th colspan="5" class="text-center">SUBJECTS TAKEN</th>
        </tr>
        <tr>
            <th>Subject</th>
            <?php if (!$student->status): ?>
                <th class="text-center" style="width:20%;">Action</th>
              <?php endif; ?>
        </tr>
        <tbody id="subjectLoadBody">
            <?php
            $count = count($loadedSubject);
            foreach ($loadedSubject as $ls):
                $isOnline = ($student->enrolled_online ? TRUE : FALSE);
                ?>
                <tr class="trSched"
                    id="tr_<?php echo $ls->subject_id ?>">
                    <td><?php echo $ls->subject ?></td>

                    <?php if (!$student->status): ?>
                        <td class="text-center">
                            <button onclick="removeSubject('<?php echo $ls->subject_id ?>')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>

                        </td>
                    <?php endif; ?>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
        <?php
        if ($this->session->userdata('position_id') == 1 ||
                $this->session->position == 'Registrar' ||
                $this->session->position == 'School Administrator' ||
                $this->session->position == 'Makabayan Coordinator'):
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
                                <?php if (!$student->status): ?>
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
        <?php endif; ?>
    </table>
    <?php
    else:
    if($student->status==0):
            ?>
        <div class="col-lg-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-xs-12"></div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <button id="onlineBtnApprove" class="btn btn-warning pull-right">Approve Online Application ?</button>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12"></div>
        </div>
            <?php
        endif;
    endif;
    
        if($student->is_old==0):
    ?>
            <div class="col-lg-12" style="margin: 10px;">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        New Student Enrollment Requirements
                    </div>
                    <div class="panel-body">
                        <?php 
                                $directory = 'uploads/'.$student->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->st_id.DIRECTORY_SEPARATOR.'files';
                               // echo $directory;
                                $scanFiles = scandir($directory);
                                $files = array_diff($scanFiles, array('..', '.'));
                                foreach ($files as $file):
                                ?>
                            <div class="col-lg-4">
                                    <button onclick="deleteEnrollmentFile('<?php echo $directory.'/'.$file ?>')" class="btn btn-xs btn-danger pull-right">x</button>
                                    <img class="img-responsive myImg" style="width: 200px;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="<?php echo $file ?>">
                            </div>         
                                <?php
                                endforeach;
                            ?>     
                    </div>
                </div>
            </div>        
    <?php endif; 
    if ($this->session->userdata('position_id') == 1 ||
            $this->session->position == "IBDE Department Head" ||
            $this->session->position == "Accounting Staff" ||
            $this->session->position == 'School Administrator' ||
            $this->session->position == "Cashier"):
        $totalCharges = 0;
        $totalExamFee = 0;
        $totalLab = 0;
        $fusedCharges = 0;
        if ($student->status): //SUBJECTS ALREADY APPROVED
            $plan = Modules::run('finance/getPlanByCourse', $student->grade_level_id, 0, $student->st_type, $student->school_year);
            $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
            
            $previousRecord = json_decode(Modules::run('finance/getRunningBalance', base64_encode($student->st_id), ($student->semester==3?$student->school_year:($student->school_year-1)), ($student->semester==3?0:$student->semester)));
            if($previousRecord->status):
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
                        <button class="btn btn-xs btn-primary pull-right" onclick="$('#sendRemarksModal').modal('show')">Send Remarks</button>
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
                            if($student->semester!=3): //if summer
                                foreach ($charges as $c):
                                    if($c->is_fused):
                                        $chargeAmount = $c->amount;
                                        $fusedCharges += $chargeAmount;
                                    else:
                                        if($c->item_id==3):
                                            $tuition = $c->amount;
                                        endif;
                                    endif;
                                endforeach;
                                $totalExtra = 0;
                                $extraCharges = Modules::run('finance/getExtraFinanceCharges',$student->user_id, $student->semester, $student->school_year);
                                $books = 0;
                                $totalPayments = 0;
                                if($extraCharges->num_rows()>0):
                                    foreach ($extraCharges->result() as $ec): 
                                        if($ec->extra_item_id==78):
                                                $books += $ec->extra_amount;
                                        else: 
                                            $totalExtra += $ec->extra_amount;
                                        endif;
                                    endforeach;
                                endif;
                                $outstandingBalance = $fusedCharges+$totalExtra+$tuition+$books;
                                ?>
                                <tr>
                                    <td>TUITION FEE</td>
                                    <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($tuition, 2, '.',',') ?></td>
                                </tr>
                                <?php if($fusedCharges > 0): ?>
                                <tr>
                                    <td>OTHER FEES</td>
                                    <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($fusedCharges+$totalExtra, 2, '.',',') ?></td>
                                </tr>
                                <?php
                            else: 
                                    
                                foreach ($charges as $c):
                                    if($c->item_id!=3):
                                        $amount = $c->amount;
                                    ?>
                                <tr>
                                    <td><?php echo strtoupper($c->item_description) ?></td>
                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.',',') ?></td>
                                </tr>
                                
                                
                                <?php
                                
                                    $outstandingBalance += $amount;
                                    endif;
                                endforeach;
                                endif; 
                                if($books!=0):
                                ?>
                                <tr>
                                    <td>TEXTBOOKS</td>
                                    <td id="td_<?php echo 3 ?>" class="text-right"><?php echo number_format($books, 2, '.',',') ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th >TOTAL FEES</th>
                                    <th  class="text-right"><?php echo number_format($outstandingBalance,2,'.',','); ?></th>
                                </tr>
                                <?php
                            else:
                                
                                foreach ($charges as $c):
                                    if($c->fin_cat_id==1 && $student->semester==3):
                                        $amount = $c->amount * $count;
                                    else:
                                        $amount = $c->amount;
                                    endif;
                                    $outstandingBalance += $amount;
                                    ?>
                                <tr>
                                    <td><?php echo $c->item_description ?></td>
                                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.',',') ?></td>
                                </tr>

                                    <?php
                                endforeach;
                                ?>
                                <tr>
                                    <th >TOTAL FEES</th>
                                    <th  class="text-right"><?php echo number_format($outstandingBalance,2,'.',','); ?></th>
                                </tr>
                                <?php
                                
                            endif; 
                            if($hasBalance): 
                                    $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);
                                    
                                    if(empty($remarks)):
                                        Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $student->school_year, 1);
                                    endif;
                                ?>
                                <tr class="danger">
                                    <td style="font-size: 20px;">PREVIOUS BALANCE</td>
                                    <th style="font-size: 20px;" class="text-right"><?php echo number_format($previousBalance,2,'.',',') ?></th>
                                </tr>

                                <tr>
                                    <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                    <th style="font-size: 20px;" class="text-right"><?php echo number_format($previousBalance+$outstandingBalance,2,'.',',') ?></th>
                                </tr>
                                    <?php
                                if($remarks): ?>
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
                                if($paymentReceipt->row()):
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
                                                $directory = 'uploads/'.$student->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->st_id.DIRECTORY_SEPARATOR.'online_payments';
                                               // echo $directory;
                                                $scanFiles = scandir($directory);
                                                $files = array_diff($scanFiles, array('..', '.'));
                                                foreach ($files as $file):
                                                ?>
                                                    <img class="img-responsive myImg" style="width: 200px;" src="<?php echo base_url($directory.'/'.$file) ?>" alt="<?php echo $file ?>">
                                                
                                                <?php
                                                endforeach;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if($this->session->userdata('position_id') == 1 || $this->session->position == "Cashier" || 
                                        $this->session->position == 'School Administrator' ||
                                    $this->session->position == "Accounting Staff"): ?>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <?php if($paymentReceipt->row()->opr_is_confirm): ?>
                                            <button class="btn btn-xs btn-block btn-success" disabled>PAYMENT CONFIRMED</button>
                                            <?php else: ?>
                                                <button id="confirmPayment" class="btn btn-xs btn-block btn-primary">CONFIRM PAYMENT</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; 
                                    endif; 
                                    ?>    
                        </table>
                    </div>
                </div>
            </div>
            <?php
        else:
            ?>    
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info">
                    <h3 class="text-center">NO FINANCE RECORD YET, <br /> STUDENT UNDER EVALUATION</h3>
                </div>
            </div>
        <?php
        endif;
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
                <textarea class="textarea form-control text-left" id="smsDetails">
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
  // var _0x3ea8=['json','#tr_total_taken','PAYMENT\x20CONFIRMED','#base_url','#base','csrf_test_name=','location','disabled','#loadMsg\x20td','btn-primary','hide','msg','ajax','#onlineBtnApprove','show','college/enrollment/monitor','college/enrollment/sendFinanceRemarks/1','status','Are\x20you\x20sure\x20you\x20want\x20to\x20approve\x20this\x20application\x20for\x20enrollment?','#confirmPayment','reload','csrf_cookie_name','#loadMsg','popover','btn-success','#semester','ready','POST','college/subjectmanagement/approveLoad/','#remarkDetails','#user_id','System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently','modal','html','#loadingModal','#admissionRemarkDetails','#tr_','GET','college/enrollment/approveBasicEdOnline/','#totalUnits','[data-toggle=\x22popover\x22]','click','#adm_id','#btnApprove','#totalLect_taken','val','Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?','addClass','cookie','college/enrollment/removeEnrollmentDetails/','Are\x20you\x20sure\x20you\x20want\x20to\x20remove\x20this\x20Student?','#st_id','#school_year','remove'];(function(_0x3d6fe6,_0x3ea869){var _0x35fe19=function(_0x3b71a6){while(--_0x3b71a6){_0x3d6fe6['push'](_0x3d6fe6['shift']());}};_0x35fe19(++_0x3ea869);}(_0x3ea8,0x166));var _0x35fe=function(_0x3d6fe6,_0x3ea869){_0x3d6fe6=_0x3d6fe6-0x0;var _0x35fe19=_0x3ea8[_0x3d6fe6];return _0x35fe19;};$(document)[_0x35fe('0x2e')](function(){var _0x4a9d3b=$(_0x35fe('0x17'))[_0x35fe('0xb')]();if($(_0x35fe('0xa'))[_0x35fe('0x35')]()==0x0){$(_0x35fe('0x15'))['hide']();};$(_0x35fe('0x6'))['popover']({'html':!![]});popoverhide=function(){$(_0x35fe('0x6'))[_0x35fe('0x2b')](_0x35fe('0x1e'));};$(_0x35fe('0x27'))['click'](function(){var _0x4248db=confirm(_0x35fe('0xc'));if(_0x4248db==!![]){var _0x334885=_0x4a9d3b+'college/enrollment/confirmPayment/1';$['ajax']({'type':'POST','url':_0x334885,'dataType':_0x35fe('0x14'),'data':{'st_id':$(_0x35fe('0x11'))[_0x35fe('0xb')](),'user_id':$(_0x35fe('0x32'))[_0x35fe('0xb')](),'semester':$('#semester')[_0x35fe('0xb')](),'school_year':$('#school_year')[_0x35fe('0xb')](),'csrf_test_name':$[_0x35fe('0xe')](_0x35fe('0x29'))},'beforeSend':function(){$(_0x35fe('0x27'))[_0x35fe('0x35')]('System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...');$('#confirmPayment')[_0x35fe('0xd')](_0x35fe('0x1b'));},'success':function(_0x325670){$(_0x35fe('0x27'))[_0x35fe('0x35')](_0x35fe('0x16'));$('#confirmPayment')['removeClass'](_0x35fe('0x1d'));$(_0x35fe('0x27'))['addClass'](_0x35fe('0x2c'));alert(_0x325670['msg']);location[_0x35fe('0x28')]();}});return![];}});$(_0x35fe('0x9'))['click'](function(){var _0x5e78c2=_0x4a9d3b+_0x35fe('0x30')+$('#adm_id')['val']()+'/'+$(_0x35fe('0x32'))[_0x35fe('0xb')]();$[_0x35fe('0x20')]({'type':'GET','url':_0x5e78c2,'dataType':_0x35fe('0x14'),'data':_0x35fe('0x19')+$[_0x35fe('0xe')](_0x35fe('0x29')),'success':function(_0x21d6f4){alert(_0x21d6f4[_0x35fe('0x1f')]);location[_0x35fe('0x28')]();}});return![];});$(_0x35fe('0x21'))[_0x35fe('0x7')](function(){var _0x5a8379=confirm(_0x35fe('0x26'));if(_0x5a8379==!![]){var _0x21decb=_0x4a9d3b+_0x35fe('0x4')+$(_0x35fe('0x8'))[_0x35fe('0xb')]()+'/'+$(_0x35fe('0x32'))[_0x35fe('0xb')]()+'/'+$(_0x35fe('0x12'))[_0x35fe('0xb')]()+'/'+$(_0x35fe('0x2d'))[_0x35fe('0xb')]();$[_0x35fe('0x20')]({'type':_0x35fe('0x3'),'url':_0x21decb,'dataType':_0x35fe('0x14'),'data':'csrf_test_name='+$[_0x35fe('0xe')](_0x35fe('0x29')),'beforeSend':function(){$(_0x35fe('0x0'))[_0x35fe('0x34')](_0x35fe('0x22'));},'success':function(_0x468405){$(_0x35fe('0x0'))[_0x35fe('0x34')](_0x35fe('0x1e'));alert(_0x468405[_0x35fe('0x1f')]);location[_0x35fe('0x28')]();}});return![];}});var _0x4a9d3b=$('#base_url')[_0x35fe('0xb')]();sendAdmissionRemark=function(){var _0x2c28e7=$('#st_id')[_0x35fe('0xb')]();var _0x431b7c=$(_0x35fe('0x1'))[_0x35fe('0xb')]();var _0x511b7f=$(_0x35fe('0x12'))[_0x35fe('0xb')]();var _0x12cecb=$(_0x35fe('0x2d'))[_0x35fe('0xb')]();var _0x5c294e=_0x4a9d3b+'college/enrollment/sendAdmissionRemarks/1';$['ajax']({'type':_0x35fe('0x2f'),'url':_0x5c294e,'data':{'csrf_test_name':$[_0x35fe('0xe')](_0x35fe('0x29')),'st_id':_0x2c28e7,'semester':_0x12cecb,'school_year':_0x511b7f,'remarks':_0x431b7c},'success':function(_0xab32d1){alert(_0xab32d1);location[_0x35fe('0x28')]();}});return![];};sendRemarks=function(){var _0x3008fb=$(_0x35fe('0x11'))['val']();var _0x539b6d=$(_0x35fe('0x31'))[_0x35fe('0xb')]();var _0x463939=$('#school_year')['val']();var _0x2f146b=$(_0x35fe('0x2d'))[_0x35fe('0xb')]();var _0x41766f=$(_0x35fe('0x8'))[_0x35fe('0xb')]();var _0x574d76=_0x4a9d3b+_0x35fe('0x24');$[_0x35fe('0x20')]({'type':'POST','url':_0x574d76,'data':{'csrf_test_name':$[_0x35fe('0xe')](_0x35fe('0x29')),'st_id':_0x3008fb,'semester':_0x2f146b,'school_year':_0x463939,'remarks':_0x539b6d,'adm_id':_0x41766f},'success':function(_0x8f9b07){alert(_0x8f9b07);location[_0x35fe('0x28')]();}});return![];};removeSubject=function(_0x4556bd){var _0x4216c8=$(_0x35fe('0x32'))['val']();var _0x5ba507=parseInt($(_0x35fe('0x5'))[_0x35fe('0x35')]());_0x5ba507-=parseInt($('#td_units_'+_0x4556bd)['html']());$('#totalUnits')[_0x35fe('0x35')](_0x5ba507);var _0x4e1dfd=_0x4a9d3b+'college/enrollment/removeSubject/';$[_0x35fe('0x20')]({'type':_0x35fe('0x2f'),'url':_0x4e1dfd,'dataType':_0x35fe('0x14'),'data':{'csrf_test_name':$[_0x35fe('0xe')](_0x35fe('0x29')),'user_id':_0x4216c8,'subject_id':_0x4556bd,'school_year':$(_0x35fe('0x12'))[_0x35fe('0xb')]()},'success':function(_0x47f7df){if(_0x47f7df[_0x35fe('0x25')]==!![]){$(_0x35fe('0x2')+_0x4556bd)[_0x35fe('0x13')]();}alert(_0x47f7df[_0x35fe('0x1f')]);}});return![];};});function removeEnrollmentDetails(_0x30b9ca,_0x5f10f7){var _0xf4f167=$(_0x35fe('0x18'))[_0x35fe('0xb')]();var _0xe40197=_0xf4f167+_0x35fe('0xf');var _0x4b0cf2=confirm(_0x35fe('0x10'));if(_0x4b0cf2==!![]){$[_0x35fe('0x20')]({'type':_0x35fe('0x2f'),'url':_0xe40197,'data':{'adm_id':_0x30b9ca,'school_year':_0x5f10f7,'csrf_test_name':$[_0x35fe('0xe')](_0x35fe('0x29'))},'beforeSend':function(){$(_0x35fe('0x2a'))['show']();$(_0x35fe('0x1c'))['html'](_0x35fe('0x33'));},'success':function(_0x508a83){alert(_0x508a83);document[_0x35fe('0x1a')]=_0xf4f167+_0x35fe('0x23');}});return![];}}
  $(document).ready(function () {

        var base = $('#base_url').val();

        if ($('#totalLect_taken').html() == 0)
        {
            $('#tr_total_taken').hide()
        }
        ;

        $('[data-toggle="popover"]').popover({
            html: true
        });

        popoverhide = function () {
            $('[data-toggle="popover"]').popover('hide');
        };
        
        deleteEnrollmentFile = function(link)
        {  
            var con = confirm('Are you sure you want to delete this file?');
        
            if (con == true)
            {
                var url = base + 'college/enrollment/deleteEnrollmentFile';
                 $.ajax({
                    type: "POST",
                    url: url,
                   // dataType: 'json',
                    data: {
                        link: link,
                        user_id: $('#user_id').val(),
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    }, // serializes the form's elements.
                    success: function (data)
                    {
                        alert(data);
                        location.reload();

                    }
                });

                return false;
            }
            
        };

        $('#confirmPayment').click(function () 
        {
            
//             $('#confirmPaymentBody').load();
//             window.open(base+'finance/accounts','popup','width=500,height=600'); 
//             return false;
            
            
            var con = confirm('Are you sure to confirm the payment?');
            if (con == true)
            {
                var url = base + 'college/enrollment/confirmPayment/1'; // the script where you handle the form input.

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: {
                        st_id: $('#st_id').val(),
                        user_id: $('#user_id').val(),
                        semester: $('#semester').val(),
                        school_year: $('#school_year').val(),
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    }, // serializes the form's elements.
                    beforeSend: function () {
                        $('#confirmPayment').html("System is confirming payment now...Please Wait...");
                        $('#confirmPayment').addClass('disabled');
                    },
                    success: function (data)
                    {
                        $('#confirmPayment').html("PAYMENT CONFIRMED");
                        $('#confirmPayment').removeClass('btn-primary');
                        $('#confirmPayment').addClass('btn-success');
                        alert(data.msg);
                        location.reload();

                    }
                });

                return false;
            }

        });

        $('#btnApprove').click(function () {
            var url = base + "college/subjectmanagement/approveLoad/" + $('#adm_id').val() + '/' + $('#user_id').val(); // the script where you handle the form input.

            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function (data)
                {
                    alert(data.msg);
                    location.reload();

                }
            });

            return false;
        });

        $('#onlineBtnApprove').click(function () {

            var con = confirm('Are you sure you want to approve this application for enrollment?');

            if (con == true) {
                var url = base + 'college/enrollment/approveBasicEdOnline/' + $('#adm_id').val() + '/' + $('#user_id').val() + '/' + $('#school_year').val() + '/' + $('#semester').val(); // the script where you handle the form input.
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    beforeSend: function () {
                        $('#loadingModal').modal('show');
                    },
                    success: function (data)
                    {
                        $('#loadingModal').modal('hide');
                        alert(data.msg);
                        location.reload();

                    }
                });

                return false;
            }
        });


        var base = $('#base_url').val();

        sendAdmissionRemark = function ()
        {
            var st_id = $('#st_id').val();
            var remarks = $('#admissionRemarkDetails').val();
            var school_year = $('#school_year').val();
            var semester = $('#semester').val();
            var url = base + 'college/enrollment/sendAdmissionRemarks/1'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType:'json',
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                    st_id: st_id,
                    semester: semester,
                    school_year: school_year,
                    remarks: remarks

                }, // serializes the form's elements.
                success: function (data)
                {
                    alert(data);
                    location.reload();
                }
            });

            return false;

        };
        
        sendSMS = function()
        { 
            var mobile = $('#mobileNo').val();
            var url = base+"college/enrollment/sendSMS/"+mobile; // the script where you handle the form input.
            var msg = $('#smsDetails').val();
            $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 'msg='+msg+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               beforeSend: function(){
                   $('#loadingModal').modal('show');
               },
               success: function(data)
               {
                   $('#loadingModal').modal('hide');
                   alert(data);
                   location.reload();
                   
               }
             });

            return false; 
            
        };
        sendRemarks = function ()
        {
            var st_id = $('#st_id').val();
            var remarks = $('#remarkDetails').val();
            var school_year = $('#school_year').val();
            var semester = $('#semester').val();
            var adm_id = $('#adm_id').val();
            var url = base + 'college/enrollment/sendFinanceRemarks/1'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType:'json',
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                    st_id: st_id,
                    semester: semester,
                    school_year: school_year,
                    remarks: remarks,
                    adm_id: adm_id

                }, // serializes the form's elements.
                success: function (data)
                {
                    alert(data);
                    location.reload();
                }
            });

            return false;

        };

        removeSubject = function (sub_id)
        {
            var st_id = $('#user_id').val();
            var totalUnits = parseInt($('#totalUnits').html());
            totalUnits -= parseInt($('#td_units_' + sub_id).html());
            $('#totalUnits').html(totalUnits);

            var url = base + 'college/enrollment/removeSubject/'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                    user_id: st_id,
                    subject_id: sub_id,
                    school_year: $('#school_year').val()

                }, // serializes the form's elements.
                success: function (data)
                {
                    if (data.status == true) {
                        $('#tr_' + sub_id).remove();
                    }

                    alert(data.msg);
                }
            });

            return false;
        };
    });


    function removeEnrollmentDetails(adm_id, school_year)
    {
        var base = $('#base').val();
        var url = base + 'college/enrollment/removeEnrollmentDetails/'; // the script where you handle the form input.
        var con = confirm('Are you sure you want to remove this Student?');
        if (con == true) {

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    adm_id: adm_id,
                    school_year: school_year,
                    csrf_test_name: $.cookie('csrf_cookie_name')

                }, // serializes the form's elements.
                // dataType:'json',
                beforeSend: function () {
                    $('#loadMsg').show();
                    $('#loadMsg td').html('System is processing...Thank you for waiting patiently')
                },
                success: function (data)
                {
                    alert(data)
                    document.location = base + 'college/enrollment/monitor';
                }
            });

            return false;
        }
    }

</script>