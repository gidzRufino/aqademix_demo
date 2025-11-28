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
    <button title="Use this button if the student withdraw from enrollment" onclick="removeEnrollmentDetails('<?php echo base64_encode($student->admission_id) ?>','<?php echo $student->school_year ?>')" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash fa-2x"></i></button>
    <h3 style="margin:3px 0;"><span id="name" style="color:#BB0000;"><?php echo ucwords(strtolower($student->firstname . ' ' . $student->lastname)) . ' ( ' . $student->st_id . ' )' ?></span></h3>
    <h4 style="color:black; margin:3px 0;"><?php echo strtoupper($student->course).' - '.$year_level?><span id="a_section"></span> </h4>
    <input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
    <input type="hidden" id="user_id" value="<?php echo base64_encode($student->user_id) ?>" />
    <input type="hidden" id="school_year" value="<?php echo $student->school_year ?>" />
    <input type="hidden" id="semester" value="<?php echo $student->semester ?>" />
    <input type="hidden" id="adm_id" value="<?php echo $student->admission_id ?>" />

</div>
<div class="col-lg-12 no-padding">
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
        
            if($count > 0) :
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
                            <?php if(!$ls->is_final): ?>
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
        <?php if ($this->session->userdata('position_id') == 1 || 
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
                        <button class="btn btn-small btn-warning pull-left" style="margin-left:10px;" onclick="$('#sendSMSDetails').modal('show'), $('#mobileNo').val('<?php echo  base64_encode($student->cd_mobile) ?>')">Send SMS</button>
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
                            <button class="btn btn-small btn-warning pull-left" style="margin-left:10px;" onclick="$('#sendSMSDetails').modal('show'), $('#mobileNo').val('<?php echo  base64_encode($student->cd_mobile) ?>')">Send SMS</button>
                        </td>
                    </tr>
        <?php
                endif;
            ?>
    </table>
    <?php
        if($count > 0):
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
    <?php   endif; 
          endif;
    if($this->session->userdata('position_id') == 1 || 
            $this->session->position == "IBDE Department Head" ||
            $this->session->position == "Accounting Staff" ||
            $this->session->position == "Cashier"): 
            if ($count == $aprv && $count >0): //SUBJECTS ALREADY APPROVED
                $totalUnits = 0;
                $totalSubs = 0;
                $totalLab = 0;
                $totalCharges=0;
                $totalExamFee=0;
                foreach ($loadedSubject as $sl):
                    $totalSubs++;
                    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
                    if ($sl->sub_lab_fee_id != 0):
                        $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                        $totalLab += $itemCharge->default_value;
                    endif;    
                endforeach;

                $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
                $tuition = Modules::run('college/finance/getChargesByCategory',1, $student->semester, $student->school_year, $plan->fin_plan_id );
                $specialClass = Modules::run('college/finance/getExtraChargesByCategory',5, $student->semester, $student->school_year, $student->user_id );
                $charges = Modules::run('college/finance/financeChargesByPlan',$student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id );

                foreach ($charges as $c):
                    $next = $c->school_year + 1;
                    if($c->item_id!=46):
                        $totalCharges += ($c->item_id<=1 || $c->item_id<=2?0:$c->amount); 
                    endif;
                    $totalExamFee += ($c->item_id<=1 || $c->item_id<=2?0:($c->item_id==46?($c->amount):0)); 
                endforeach;
                $totalExtra = 0;
                $extraCharges = Modules::run('college/finance/getExtraFinanceCharges',$student->user_id, $student->semester, $student->school_year);
                
                if($extraCharges->num_rows()>0):
                    foreach ($extraCharges->result() as $ec):
                        $totalExtra += $ec->extra_amount;
                    endforeach;
                endif;  

                $over = Modules::run('college/finance/overPayment',$student->st_id, $student->semester, $student->school_year);

                $totalFees = (($tuition->row()->amount*$totalUnits)+$totalCharges+$totalLab+$totalExtra);
                foreach ($charges as $exam):
                    $examFee = ($exam->item_id==46?'yes':0);
                endforeach;

                $semester = ($student->semester==1?3:($student->semester-1));
                $prev_year = ($student->semester==1?$student->school_year-1:$student->school_year);

                $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $prev_year));

        ?>
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-xs-12 ">
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
                                    <td><?php echo 'TUITION ('.$totalUnits.' UNITS @ '.(number_format($tuition->row()->amount,2,'.',',')).')' ?></td>
                                    <th class="text-right"><?php echo number_format($tuition->row()->amount*$totalUnits,2,'.',',') ?></th>
                                </tr>
                                <tr>
                                    <td>OTHER FEES</td>
                                    <th class="text-right"><?php echo number_format($totalCharges,2,'.',',') ?></th>
                                </tr>
                                <tr>
                                    <td>EXAM FEES</td>
                                    <th class="text-right"><?php echo number_format(($totalExamFee*$totalSubs),2,'.',',') ?></th>
                                </tr>
                                <?php 
                                    if($totalLab!=0): ?>
                                <tr>
                                    <td>LABORATORY FEES</td>
                                    <th class="text-right"><?php echo number_format($totalLab,2,'.',',') ?></th>
                                </tr>
                                <?php endif; 
                                    $overAllExamFees = $totalExamFee*$totalSubs;
                                    $outstandingBalance = ($totalFees + ($over->row()?$over->row()->extra_amount:0)+$overAllExamFees);
                                ?>
                                <tr>
                                    <th >TOTAL FEES</th>
                                    <th  class="text-right"><?php echo number_format($outstandingBalance,2,'.',','); ?></th>
                                </tr>
                                <?php if($hasBalance->status): 
                                    $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);
                                    
                                    if(empty($remarks)):
                                        Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $student->school_year);
                                    endif;
                                ?>
                                <tr class="danger">
                                    <td style="font-size: 20px;">PREVIOUS BALANCE</td>
                                    <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance,2,'.',',') ?></th>
                                </tr>

                                <tr>
                                    <td style="font-size: 20px;">OUTSTANDING BALANCE</td>
                                    <th style="font-size: 20px;" class="text-right"><?php echo number_format($hasBalance->rawBalance+$outstandingBalance,2,'.',',') ?></th>
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
                                                $scanFiles = scandir($directory);
                                                $files = array_diff($scanFiles, array('..', '.'));
                                                foreach ($files as $file):
                                                ?>
                                                    <img class="img-responsive myImg" style="width: 200px;" src="<?php echo base_url($directory.'/'.$file) ?>"  alt="<?php echo $file ?>">
                                                
                                                <?php
                                                endforeach;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if($this->session->userdata('position_id') == 1 || $this->session->position == "Cashier" || 
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
                <div class="alert alert-info">
                    <h3 class="text-center">NO FINANCE RECORD YET, <br /> STUDENT UNDER SUBJECT LOAD EVALUATION</h3>
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
//    var _0x5e69=['html','#adm_id','POST','college/enrollment/removeEnrollmentDetails/','remove','college/enrollment/sendFinanceRemarks/','reload','#base_url','removeClass','show','#tr_','status','GET','#st_id','[data-toggle=\x22popover\x22]','#loadMsg','#loadingModal','#totalLect_taken','ready','Are\x20you\x20sure\x20you\x20want\x20to\x20remove\x20this\x20Student?','val','Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?','#semester','cookie','click','#school_year','csrf_test_name=','modal','csrf_cookie_name','#btnApprove','#totalUnits','hide','ajax','#base','#confirmPayment','btn-primary','popover','#td_units_','college/enrollment/removeSubject/','json','PAYMENT\x20CONFIRMED','msg','college/enrollment/sendAdmissionRemarks/','#remarkDetails','#user_id','college/enrollment/monitor'];(function(_0x3a3183,_0x5e6994){var _0x16cfb1=function(_0x49d16e){while(--_0x49d16e){_0x3a3183['push'](_0x3a3183['shift']());}};_0x16cfb1(++_0x5e6994);}(_0x5e69,0x158));var _0x16cf=function(_0x3a3183,_0x5e6994){_0x3a3183=_0x3a3183-0x0;var _0x16cfb1=_0x5e69[_0x3a3183];return _0x16cfb1;};$(document)[_0x16cf('0x2a')](function(){var _0x233dc7=$(_0x16cf('0x1f'))[_0x16cf('0x2c')]();if($(_0x16cf('0x29'))[_0x16cf('0x18')]()==0x0){$('#tr_total_taken')[_0x16cf('0x9')]();};$(_0x16cf('0x26'))[_0x16cf('0xe')]({'html':!![]});popoverhide=function(){$(_0x16cf('0x26'))[_0x16cf('0xe')](_0x16cf('0x9'));};$(_0x16cf('0xc'))['click'](function(){var _0x42d7a9=confirm(_0x16cf('0x2d'));if(_0x42d7a9==!![]){var _0x4c9793=_0x233dc7+'college/enrollment/confirmPayment/';$[_0x16cf('0xa')]({'type':_0x16cf('0x1a'),'url':_0x4c9793,'dataType':_0x16cf('0x11'),'data':{'st_id':$('#st_id')[_0x16cf('0x2c')](),'user_id':$(_0x16cf('0x16'))['val'](),'semester':$(_0x16cf('0x0'))['val'](),'school_year':$(_0x16cf('0x3'))[_0x16cf('0x2c')](),'csrf_test_name':$[_0x16cf('0x1')](_0x16cf('0x6'))},'beforeSend':function(){$(_0x16cf('0xc'))[_0x16cf('0x18')]('System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...');},'success':function(_0x35cd14){$(_0x16cf('0xc'))[_0x16cf('0x18')](_0x16cf('0x12'));$(_0x16cf('0xc'))[_0x16cf('0x20')](_0x16cf('0xd'));$(_0x16cf('0xc'))['addClass']('btn-success');alert(_0x35cd14[_0x16cf('0x13')]);location[_0x16cf('0x1e')]();}});return![];}});sendPaymentReminder=function(_0x2a7eee){var _0x4eb233=_0x233dc7+'college/enrollment/sendPaymentReminder/'+_0x2a7eee;$[_0x16cf('0xa')]({'type':'GET','url':_0x4eb233,'data':_0x16cf('0x4')+$[_0x16cf('0x1')](_0x16cf('0x6')),'success':function(_0x29e95c){alert(_0x29e95c);location[_0x16cf('0x1e')]();}});return![];};$(_0x16cf('0x7'))[_0x16cf('0x2')](function(){var _0x30936e=_0x233dc7+'college/subjectmanagement/approveLoad/'+$(_0x16cf('0x19'))['val']()+'/'+$(_0x16cf('0x16'))[_0x16cf('0x2c')]();$[_0x16cf('0xa')]({'type':'GET','url':_0x30936e,'dataType':'json','data':_0x16cf('0x4')+$[_0x16cf('0x1')]('csrf_cookie_name'),'success':function(_0xb2b73c){alert(_0xb2b73c[_0x16cf('0x13')]);location[_0x16cf('0x1e')]();}});return![];});$('#onlineBtnApprove')[_0x16cf('0x2')](function(){var _0x4a554c=_0x233dc7+'college/subjectmanagement/approveLoadOnline/'+$(_0x16cf('0x19'))['val']()+'/'+$(_0x16cf('0x16'))[_0x16cf('0x2c')]()+'/'+$(_0x16cf('0x3'))['val']()+'/'+$(_0x16cf('0x0'))[_0x16cf('0x2c')]();$[_0x16cf('0xa')]({'type':_0x16cf('0x24'),'url':_0x4a554c,'dataType':_0x16cf('0x11'),'data':_0x16cf('0x4')+$[_0x16cf('0x1')]('csrf_cookie_name'),'beforeSend':function(){$(_0x16cf('0x28'))[_0x16cf('0x5')](_0x16cf('0x21'));},'success':function(_0x555595){$('#loadingModal')[_0x16cf('0x5')](_0x16cf('0x9'));alert(_0x555595['msg']);location[_0x16cf('0x1e')]();}});return![];});var _0x233dc7=$('#base_url')[_0x16cf('0x2c')]();sendAdmissionRemark=function(){var _0x3deaa3=$(_0x16cf('0x25'))[_0x16cf('0x2c')]();var _0x584b09=$('#admissionRemarkDetails')[_0x16cf('0x2c')]();var _0x75b130=$(_0x16cf('0x3'))[_0x16cf('0x2c')]();var _0x397747=$(_0x16cf('0x0'))[_0x16cf('0x2c')]();var _0x14546f=_0x233dc7+_0x16cf('0x14');$[_0x16cf('0xa')]({'type':'POST','url':_0x14546f,'data':{'csrf_test_name':$[_0x16cf('0x1')](_0x16cf('0x6')),'st_id':_0x3deaa3,'semester':_0x397747,'school_year':_0x75b130,'remarks':_0x584b09},'success':function(_0x182b56){alert(_0x182b56);location['reload']();}});return![];};sendRemarks=function(){var _0x3f7979=$('#st_id')[_0x16cf('0x2c')]();var _0xdcb10e=$(_0x16cf('0x15'))[_0x16cf('0x2c')]();var _0x27b587=$(_0x16cf('0x3'))['val']();var _0x5a0d46=$(_0x16cf('0x0'))[_0x16cf('0x2c')]();var _0x31b469=$(_0x16cf('0x19'))[_0x16cf('0x2c')]();var _0x2ec58b=_0x233dc7+_0x16cf('0x1d');$[_0x16cf('0xa')]({'type':_0x16cf('0x1a'),'url':_0x2ec58b,'data':{'csrf_test_name':$[_0x16cf('0x1')](_0x16cf('0x6')),'st_id':_0x3f7979,'semester':_0x5a0d46,'school_year':_0x27b587,'remarks':_0xdcb10e,'adm_id':_0x31b469},'success':function(_0xb58350){alert(_0xb58350);location[_0x16cf('0x1e')]();}});return![];};removeSubject=function(_0x4e7fec){var _0x36baae=$(_0x16cf('0x16'))[_0x16cf('0x2c')]();var _0x4cdac1=parseInt($('#totalUnits')[_0x16cf('0x18')]());_0x4cdac1-=parseInt($(_0x16cf('0xf')+_0x4e7fec)['html']());$(_0x16cf('0x8'))[_0x16cf('0x18')](_0x4cdac1);var _0x346efd=_0x233dc7+_0x16cf('0x10');$[_0x16cf('0xa')]({'type':_0x16cf('0x1a'),'url':_0x346efd,'dataType':_0x16cf('0x11'),'data':{'csrf_test_name':$[_0x16cf('0x1')](_0x16cf('0x6')),'user_id':_0x36baae,'subject_id':_0x4e7fec,'school_year':$(_0x16cf('0x3'))[_0x16cf('0x2c')]()},'success':function(_0x30e36b){if(_0x30e36b[_0x16cf('0x23')]==!![]){$(_0x16cf('0x22')+_0x4e7fec)[_0x16cf('0x1c')]();}alert(_0x30e36b[_0x16cf('0x13')]);}});return![];};});function removeEnrollmentDetails(_0x4ea3f3,_0x49d8a6){var _0x4c8174=$(_0x16cf('0xb'))[_0x16cf('0x2c')]();var _0x4914f0=_0x4c8174+_0x16cf('0x1b');var _0x1ad2f8=confirm(_0x16cf('0x2b'));if(_0x1ad2f8==!![]){$[_0x16cf('0xa')]({'type':_0x16cf('0x1a'),'url':_0x4914f0,'data':{'adm_id':_0x4ea3f3,'school_year':_0x49d8a6,'csrf_test_name':$[_0x16cf('0x1')](_0x16cf('0x6'))},'beforeSend':function(){$(_0x16cf('0x27'))[_0x16cf('0x21')]();$('#loadMsg\x20td')['html']('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x214597){alert(_0x214597);document['location']=_0x4c8174+_0x16cf('0x17');}});return![];}}

$(document).ready(function(){
        
        var base = $('#base_url').val();
        
        if($('#totalLect_taken').html()==0)
        {
            $('#tr_total_taken').hide()
        };
        
        $('[data-toggle="popover"]').popover({
            html: true
        });

        popoverhide = function(){
            $('[data-toggle="popover"]').popover('hide');
        };
        
        $('#confirmPayment').click(function(){
            
            var con = confirm('Are you sure to confirm the payment?');
            if(con==true)
            {
                var url = base+'college/enrollment/confirmPayment/'; // the script where you handle the form input.

                $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: {
                       st_id            : $('#st_id').val(),
                       user_id          : $('#user_id').val(),
                       semester         : $('#semester').val(),
                       school_year      : $('#school_year').val(),
                       csrf_test_name   : $.cookie('csrf_cookie_name')
                   }, // serializes the form's elements.
                   beforeSend: function(){
                       $('#confirmPayment').html("System is confirming payment now...Please Wait...");
                   },      
                   success: function(data)
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
        
        sendPaymentReminder = function(mobile)
        { 
            
            var url = base+"college/enrollment/sendPaymentReminder/"+mobile; // the script where you handle the form input.

            $.ajax({
               type: "GET",
               url: url,
               //dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               { 
                   alert(data);
                   location.reload();
                  
               }
             });

            return false; 
            
        };
        
        $('#btnApprove').click(function(){
            var url = base+"college/subjectmanagement/approveLoad/"+$('#adm_id').val()+'/'+$('#user_id').val(); // the script where you handle the form input.

            $.ajax({
               type: "GET",
               url: url,
               dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               { 
                   alert(data.msg);
                   location.reload();
                  
               }
             });

            return false; 
        });
        
        $('#onlineBtnApprove').click(function(){
            
            var url = base+'college/subjectmanagement/approveLoadOnline/'+$('#adm_id').val()+'/'+$('#user_id').val()+'/'+$('#school_year').val()+'/'+$('#semester').val(); // the script where you handle the form input.
            $.ajax({
               type: "GET",
               url: url,
               dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               beforeSend: function(){
                   $('#loadingModal').modal('show');
               },
               success: function(data)
               {
                   $('#loadingModal').modal('hide');
                   alert(data.msg);
                   location.reload();
                   
               }
             });

            return false; 
        });
        
        
        var base = $('#base_url').val();
        
        sendAdmissionRemark = function()
        {   
            var st_id = $('#st_id').val();
            var remarks = $('#admissionRemarkDetails').val();
            var school_year = $('#school_year').val();
            var semester = $('#semester').val();
            var url = base+'college/enrollment/sendAdmissionRemarks/'; // the script where you handle the form input.
            $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: {
                   csrf_test_name   : $.cookie('csrf_cookie_name'),
                   st_id            : st_id,
                   semester         : semester,
                   school_year      : school_year,
                   remarks          : remarks
               
                }, // serializes the form's elements.
               success: function(data)
               {
                    alert(data);
                    location.reload();
               }
             });

            return false; 
            
        };
        
        sendRemarks = function()
        {   
            var st_id = $('#st_id').val();
            var remarks = $('#remarkDetails').val();
            var school_year = $('#school_year').val();
            var semester = $('#semester').val();
            var adm_id  = $('#adm_id').val();
            var url = base+'college/enrollment/sendFinanceRemarks/'; // the script where you handle the form input.
            $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: {
                   csrf_test_name   : $.cookie('csrf_cookie_name'),
                   st_id            : st_id,
                   semester         : semester,
                   school_year      : school_year,
                   remarks          : remarks,
                   adm_id           : adm_id
               
                }, // serializes the form's elements.
               success: function(data)
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
            totalUnits -= parseInt($('#td_units_'+sub_id).html());
            $('#totalUnits').html(totalUnits);
            
            var url = base+'college/enrollment/removeSubject/'; // the script where you handle the form input.
            $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: {
                   csrf_test_name   : $.cookie('csrf_cookie_name'),
                   user_id          : st_id,
                   subject_id       : sub_id,
                   school_year      : $('#school_year').val()
               
                }, // serializes the form's elements.
               success: function(data)
               {
                    if(data.status == true){
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
        var url = base+'college/enrollment/removeEnrollmentDetails/'; // the script where you handle the form input.
        var con = confirm('Are you sure you want to remove this Student?');
        if(con==true){
        
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    adm_id : adm_id,
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
                    document.location = base+'college/enrollment/monitor';
                }
            });

            return false;
        }    
    }
</script>