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
 var _0x4247=['ajax','college/enrollment/sendAdmissionRemarks/1','#td_units_','college/enrollment/confirmPayment/1','reload','college/enrollment/sendFinanceRemarks/1','#user_id','GET','val','cookie','Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?','#confirmPayment','college/enrollment/approveBasicEdOnline/','#totalUnits','#tr_total_taken','college/enrollment/deleteEnrollmentFile','#st_id','ready','location','#btnApprove','popover','[data-toggle=\x22popover\x22]','#totalLect_taken','#adm_id','college/subjectmanagement/approveLoad/','json','msg','modal','System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently','Are\x20you\x20sure\x20you\x20want\x20to\x20approve\x20this\x20application\x20for\x20enrollment?','#smsDetails','Are\x20you\x20sure\x20you\x20want\x20to\x20delete\x20this\x20file?','html','#admissionRemarkDetails','POST','csrf_cookie_name','college/enrollment/monitor','#mobileNo','click','#loadingModal','#onlineBtnApprove','#remarkDetails','btn-primary','#tr_','college/enrollment/removeEnrollmentDetails/','#semester','#school_year','Are\x20you\x20sure\x20you\x20want\x20to\x20remove\x20this\x20Student?','hide','college/enrollment/sendSMS/','btn-success','System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...','msg=','#base_url','csrf_test_name=','addClass','#base','show','removeClass'];(function(_0x15ccae,_0x424790){var _0x382217=function(_0x932ca4){while(--_0x932ca4){_0x15ccae['push'](_0x15ccae['shift']());}};_0x382217(++_0x424790);}(_0x4247,0xbf));var _0x3822=function(_0x15ccae,_0x424790){_0x15ccae=_0x15ccae-0x0;var _0x382217=_0x4247[_0x15ccae];return _0x382217;};$(document)[_0x3822('0x3')](function(){var _0x5903be=$(_0x3822('0x27'))['val']();if($(_0x3822('0x8'))[_0x3822('0x12')]()==0x0){$(_0x3822('0x0'))[_0x3822('0x22')]();};$(_0x3822('0x7'))[_0x3822('0x6')]({'html':!![]});popoverhide=function(){$(_0x3822('0x7'))[_0x3822('0x6')](_0x3822('0x22'));};deleteEnrollmentFile=function(_0x4f7737){var _0x5b3ea8=confirm(_0x3822('0x11'));if(_0x5b3ea8==!![]){var _0x47c9ff=_0x5903be+_0x3822('0x1');$[_0x3822('0x2d')]({'type':'POST','url':_0x47c9ff,'data':{'link':_0x4f7737,'user_id':$('#user_id')[_0x3822('0x35')](),'csrf_test_name':$[_0x3822('0x36')]('csrf_cookie_name')},'success':function(_0x2f7383){alert(_0x2f7383);location['reload']();}});return![];}};$(_0x3822('0x38'))[_0x3822('0x18')](function(){var _0x57cc75=confirm(_0x3822('0x37'));if(_0x57cc75==!![]){var _0x4b0daf=_0x5903be+_0x3822('0x30');$[_0x3822('0x2d')]({'type':_0x3822('0x14'),'url':_0x4b0daf,'dataType':'json','data':{'st_id':$('#st_id')[_0x3822('0x35')](),'user_id':$('#user_id')['val'](),'semester':$(_0x3822('0x1f'))['val'](),'school_year':$(_0x3822('0x20'))['val'](),'csrf_test_name':$[_0x3822('0x36')](_0x3822('0x15'))},'beforeSend':function(){$(_0x3822('0x38'))[_0x3822('0x12')](_0x3822('0x25'));$(_0x3822('0x38'))[_0x3822('0x29')]('disabled');},'success':function(_0x1f03cc){$('#confirmPayment')[_0x3822('0x12')]('PAYMENT\x20CONFIRMED');$('#confirmPayment')[_0x3822('0x2c')](_0x3822('0x1c'));$(_0x3822('0x38'))[_0x3822('0x29')](_0x3822('0x24'));alert(_0x1f03cc[_0x3822('0xc')]);location[_0x3822('0x31')]();}});return![];}});$(_0x3822('0x5'))[_0x3822('0x18')](function(){var _0x4a9c9e=_0x5903be+_0x3822('0xa')+$(_0x3822('0x9'))[_0x3822('0x35')]()+'/'+$(_0x3822('0x33'))['val']();$[_0x3822('0x2d')]({'type':_0x3822('0x34'),'url':_0x4a9c9e,'dataType':'json','data':_0x3822('0x28')+$[_0x3822('0x36')]('csrf_cookie_name'),'success':function(_0x2b2e9b){alert(_0x2b2e9b[_0x3822('0xc')]);location[_0x3822('0x31')]();}});return![];});$(_0x3822('0x1a'))[_0x3822('0x18')](function(){var _0x1becd0=confirm(_0x3822('0xf'));if(_0x1becd0==!![]){var _0x361c0d=_0x5903be+_0x3822('0x39')+$(_0x3822('0x9'))[_0x3822('0x35')]()+'/'+$(_0x3822('0x33'))['val']()+'/'+$(_0x3822('0x20'))[_0x3822('0x35')]()+'/'+$(_0x3822('0x1f'))[_0x3822('0x35')]();$['ajax']({'type':_0x3822('0x34'),'url':_0x361c0d,'dataType':_0x3822('0xb'),'data':_0x3822('0x28')+$[_0x3822('0x36')](_0x3822('0x15')),'beforeSend':function(){$(_0x3822('0x19'))[_0x3822('0xd')](_0x3822('0x2b'));},'success':function(_0x25aa64){$(_0x3822('0x19'))[_0x3822('0xd')](_0x3822('0x22'));alert(_0x25aa64[_0x3822('0xc')]);location[_0x3822('0x31')]();}});return![];}});var _0x5903be=$('#base_url')[_0x3822('0x35')]();sendAdmissionRemark=function(){var _0x39e7ec=$(_0x3822('0x2'))[_0x3822('0x35')]();var _0x1a708c=$(_0x3822('0x13'))[_0x3822('0x35')]();var _0x4bc94a=$('#school_year')[_0x3822('0x35')]();var _0x26b86a=$(_0x3822('0x1f'))[_0x3822('0x35')]();var _0x21fc82=_0x5903be+_0x3822('0x2e');$['ajax']({'type':_0x3822('0x14'),'url':_0x21fc82,'data':{'csrf_test_name':$[_0x3822('0x36')]('csrf_cookie_name'),'st_id':_0x39e7ec,'semester':_0x26b86a,'school_year':_0x4bc94a,'remarks':_0x1a708c},'success':function(_0x52fa83){alert(_0x52fa83);location[_0x3822('0x31')]();}});return![];};sendSMS=function(){var _0x4e77bf=$(_0x3822('0x17'))[_0x3822('0x35')]();var _0x177768=_0x5903be+_0x3822('0x23')+_0x4e77bf;var _0x22aaab=$(_0x3822('0x10'))[_0x3822('0x35')]();$[_0x3822('0x2d')]({'type':_0x3822('0x14'),'url':_0x177768,'data':_0x3822('0x26')+_0x22aaab+'&csrf_test_name='+$[_0x3822('0x36')](_0x3822('0x15')),'beforeSend':function(){$(_0x3822('0x19'))[_0x3822('0xd')]('show');},'success':function(_0x4a2d00){$(_0x3822('0x19'))[_0x3822('0xd')](_0x3822('0x22'));alert(_0x4a2d00);location[_0x3822('0x31')]();}});return![];};sendRemarks=function(){var _0x5ac03f=$('#st_id')[_0x3822('0x35')]();var _0xcd45af=$(_0x3822('0x1b'))[_0x3822('0x35')]();var _0x12620b=$(_0x3822('0x20'))[_0x3822('0x35')]();var _0x3e5a8b=$(_0x3822('0x1f'))[_0x3822('0x35')]();var _0x55b42e=$(_0x3822('0x9'))[_0x3822('0x35')]();var _0x2d0679=_0x5903be+_0x3822('0x32');$[_0x3822('0x2d')]({'type':_0x3822('0x14'),'url':_0x2d0679,'data':{'csrf_test_name':$[_0x3822('0x36')]('csrf_cookie_name'),'st_id':_0x5ac03f,'semester':_0x3e5a8b,'school_year':_0x12620b,'remarks':_0xcd45af,'adm_id':_0x55b42e},'success':function(_0x37ef71){alert(_0x37ef71);location[_0x3822('0x31')]();}});return![];};removeSubject=function(_0x43edc1){var _0x119664=$(_0x3822('0x33'))['val']();var _0x51d73e=parseInt($(_0x3822('0x3a'))[_0x3822('0x12')]());_0x51d73e-=parseInt($(_0x3822('0x2f')+_0x43edc1)['html']());$(_0x3822('0x3a'))['html'](_0x51d73e);var _0x171363=_0x5903be+'college/enrollment/removeSubject/';$['ajax']({'type':_0x3822('0x14'),'url':_0x171363,'dataType':_0x3822('0xb'),'data':{'csrf_test_name':$[_0x3822('0x36')](_0x3822('0x15')),'user_id':_0x119664,'subject_id':_0x43edc1,'school_year':$(_0x3822('0x20'))[_0x3822('0x35')]()},'success':function(_0x211623){if(_0x211623['status']==!![]){$(_0x3822('0x1d')+_0x43edc1)['remove']();}alert(_0x211623['msg']);}});return![];};});function removeEnrollmentDetails(_0x1865e6,_0x4d7984){var _0x3c61c0=$(_0x3822('0x2a'))['val']();var _0x5182e9=_0x3c61c0+_0x3822('0x1e');var _0x38d132=confirm(_0x3822('0x21'));if(_0x38d132==!![]){$[_0x3822('0x2d')]({'type':_0x3822('0x14'),'url':_0x5182e9,'data':{'adm_id':_0x1865e6,'school_year':_0x4d7984,'csrf_test_name':$[_0x3822('0x36')](_0x3822('0x15'))},'beforeSend':function(){$('#loadMsg')[_0x3822('0x2b')]();$('#loadMsg\x20td')[_0x3822('0x12')](_0x3822('0xe'));},'success':function(_0x3b2751){alert(_0x3b2751);document[_0x3822('0x4')]=_0x3c61c0+_0x3822('0x16');}});return![];}}
</script>