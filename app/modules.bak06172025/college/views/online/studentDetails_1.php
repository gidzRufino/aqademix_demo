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
        <tbody id="subjectLoadBody">
            <?php
            $count = count($loadedSubject);
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
        <?php endif; ?>
    </table>
    <?php if($this->session->userdata('position_id') == 1 || 
            $this->session->position == "IBDE Department Head" ||
            $this->session->position == "Accounting Staff" ||
            $this->session->position == "Cashier"): 
            if ($count == $aprv): //SUBJECTS ALREADY APPROVED
                $totalUnits = 0;
                $totalSubs = 0;
                $totalLab = 0;
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
                $specialClass = Modules::run('college/finance/getExtraChargesByCategory',5, $student->semester, $student->school_year, $student->u_id );
                $charges = Modules::run('college/finance/financeChargesByPlan',$student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id );

                foreach ($charges as $c):
                    $next = $c->school_year + 1;
                    if($c->item_id!=46):
                        $totalCharges += ($c->item_id<=1 || $c->item_id<=2?0:$c->amount); 
                    endif;
                    $totalExamFee += ($c->item_id<=1 || $c->item_id<=2?0:($c->item_id==46?($c->amount):0)); 
                endforeach;
                $totalExtra = 0;
                $extraCharges = Modules::run('college/finance/getExtraFinanceCharges',$student->u_id, $student->semester, $student->school_year);
                if($showPayment):
                    if($extraCharges->num_rows()>0):
                        foreach ($extraCharges->result() as $ec):
                            $totalExtra += $ec->extra_amount;
                        endforeach;
                    endif;

                endif;    

                $over = Modules::run('college/finance/overPayment',$student->uid, $student->semester, $student->school_year);

                $totalFees = (($tuition->row()->amount*$totalUnits)+$totalCharges+$totalLab+$totalExtra);
                foreach ($charges as $exam):
                    $examFee = ($exam->item_id==46?'yes':0);
                endforeach;

                $semester = ($student->semester==1?3:($student->semester-1));
                $school_year = ($semester==1?$student->school_year-1:$student->school_year);

                $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $school_year));

        ?>
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-xs-12 ">
                    <div class="panel panel-warning">
                        <div class="panel-heading clearfix">
                            Finance Details
                            <button class="btn btn-xs btn-success pull-right" onclick="sendPaymentReminder('<?php echo base64_encode($student->cd_mobile) ?>', $(this)), $(this).attr('disabled'), $(this).html('Sending...')">Send Reminder</button>
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
                                    $outstandingBalance = ($totalFees + $over->row()->extra_amount+$overAllExamFees);
                                ?>
                                <tr>
                                    <th >TOTAL FEES</th>
                                    <th  class="text-right"><?php echo number_format($outstandingBalance,2,'.',','); ?></th>
                                </tr>
                                <?php if($hasBalance->status): 
                                    $remarks = Modules::run('college/enrollment/getFinanceRemarks', $student->st_id, $student->semester, $student->school_year);
                                    
                                    if(empty($remarks)):
                                        Modules::run('college/enrollment/updateEnrollmentStatus', $student->st_id, 4, $student->semester, $school_year);
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
                                endif;
                                if($remarks): ?>
                                        <tr>
                                            <td colspan="2" class="text-center">Remarks Sent to Student:</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center"><?php echo $remarks->fr_remarks ?></td>
                                        </tr>
                                        <?php
                                endif;
                                $paymentReceipt = Modules::run('college/enrollment/getUploadedReceipt', $student->st_id, $student->semester, $school_year);
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
                                            <img src="<?php echo $paymentReceipt->row()->opr_img_link ?>" style="width:75%; margin:3px auto;" title="receiptLink" alt="receiptLink" />
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

<input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
<input type='hidden' id="remarkController" />
<script type="text/javascript">
    //var _0x3c61=['college/subjectmanagement/approveLoadOnline/','college/enrollment/confirmPayment/','college/subjectmanagement/approveLoad/','#st_id','json','GET','val','college/enrollment/removeSubject/','html','modal','#base_url','#onlineBtnApprove','hide','addClass','PAYMENT\x20CONFIRMED','#confirmPayment','ready','POST','msg','#loadingModal','#tr_total_taken','click','System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...','remove','#remarkDetails','cookie','Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?','csrf_test_name=','#adm_id','reload','#tr_','#school_year','show','#user_id','ajax','removeClass','csrf_cookie_name','#totalUnits','college/enrollment/sendFinanceRemarks/','#semester','#totalLect_taken','status','btn-success'];(function(_0x494ffc,_0x3c6132){var _0x3add32=function(_0x529b18){while(--_0x529b18){_0x494ffc['push'](_0x494ffc['shift']());}};_0x3add32(++_0x3c6132);}(_0x3c61,0x198));var _0x3add=function(_0x494ffc,_0x3c6132){_0x494ffc=_0x494ffc-0x0;var _0x3add32=_0x3c61[_0x494ffc];return _0x3add32;};$(document)[_0x3add('0x26')](function(){var _0x1381cd=$(_0x3add('0x20'))[_0x3add('0x1c')]();if($(_0x3add('0x13'))[_0x3add('0x1e')]()==0x0){$(_0x3add('0x2a'))[_0x3add('0x22')]();};$(_0x3add('0x25'))[_0x3add('0x0')](function(){var _0x49062b=confirm(_0x3add('0x5'));if(_0x49062b==!![]){var _0x348a0d=_0x1381cd+_0x3add('0x17');$[_0x3add('0xd')]({'type':_0x3add('0x27'),'url':_0x348a0d,'dataType':_0x3add('0x1a'),'data':{'st_id':$(_0x3add('0x19'))[_0x3add('0x1c')](),'user_id':$(_0x3add('0xc'))[_0x3add('0x1c')](),'semester':$(_0x3add('0x12'))['val'](),'school_year':$(_0x3add('0xa'))[_0x3add('0x1c')](),'csrf_test_name':$[_0x3add('0x4')](_0x3add('0xf'))},'beforeSend':function(){$(_0x3add('0x25'))[_0x3add('0x1e')](_0x3add('0x1'));},'success':function(_0x4c68ee){$(_0x3add('0x25'))['html'](_0x3add('0x24'));$('#confirmPayment')[_0x3add('0xe')]('btn-primary');$(_0x3add('0x25'))[_0x3add('0x23')](_0x3add('0x15'));alert(_0x4c68ee[_0x3add('0x28')]);location[_0x3add('0x8')]();}});return![];}});$('#btnApprove')['click'](function(){var _0x274fa9=_0x1381cd+_0x3add('0x18')+$('#adm_id')[_0x3add('0x1c')]()+'/'+$(_0x3add('0xc'))[_0x3add('0x1c')]();$['ajax']({'type':_0x3add('0x1b'),'url':_0x274fa9,'dataType':'json','data':_0x3add('0x6')+$[_0x3add('0x4')](_0x3add('0xf')),'success':function(_0x133420){alert(_0x133420[_0x3add('0x28')]);location['reload']();}});return![];});$(_0x3add('0x21'))[_0x3add('0x0')](function(){var _0x1b22b7=_0x1381cd+_0x3add('0x16')+$('#adm_id')[_0x3add('0x1c')]()+'/'+$('#user_id')[_0x3add('0x1c')]()+'/'+$('#school_year')[_0x3add('0x1c')]()+'/'+$(_0x3add('0x12'))['val']();$[_0x3add('0xd')]({'type':_0x3add('0x1b'),'url':_0x1b22b7,'dataType':_0x3add('0x1a'),'data':_0x3add('0x6')+$['cookie'](_0x3add('0xf')),'beforeSend':function(){$('#loadingModal')[_0x3add('0x1f')](_0x3add('0xb'));},'success':function(_0x414630){$(_0x3add('0x29'))[_0x3add('0x1f')](_0x3add('0x22'));alert(_0x414630[_0x3add('0x28')]);location[_0x3add('0x8')]();}});return![];});var _0x1381cd=$(_0x3add('0x20'))[_0x3add('0x1c')]();sendRemarks=function(){var _0x3877ea=$(_0x3add('0x19'))['val']();var _0x41aac6=$(_0x3add('0x3'))[_0x3add('0x1c')]();var _0x55ed96=$(_0x3add('0xa'))[_0x3add('0x1c')]();var _0x72312d=$(_0x3add('0x12'))['val']();var _0x229ff5=$(_0x3add('0x7'))[_0x3add('0x1c')]();var _0x14d004=_0x1381cd+_0x3add('0x11');$[_0x3add('0xd')]({'type':_0x3add('0x27'),'url':_0x14d004,'data':{'csrf_test_name':$[_0x3add('0x4')](_0x3add('0xf')),'st_id':_0x3877ea,'semester':_0x72312d,'school_year':_0x55ed96,'remarks':_0x41aac6,'adm_id':_0x229ff5},'success':function(_0x1fec2d){alert(_0x1fec2d);location[_0x3add('0x8')]();}});return![];};removeSubject=function(_0x41c7cf){var _0x5c4f39=$(_0x3add('0xc'))['val']();var _0x35da65=parseInt($('#totalUnits')[_0x3add('0x1e')]());_0x35da65-=parseInt($('#td_units_'+_0x41c7cf)[_0x3add('0x1e')]());$(_0x3add('0x10'))['html'](_0x35da65);var _0x14ee97=_0x1381cd+_0x3add('0x1d');$[_0x3add('0xd')]({'type':'POST','url':_0x14ee97,'dataType':_0x3add('0x1a'),'data':{'csrf_test_name':$[_0x3add('0x4')](_0x3add('0xf')),'user_id':_0x5c4f39,'subject_id':_0x41c7cf,'school_year':$(_0x3add('0xa'))['val']()},'success':function(_0x3dbe8e){if(_0x3dbe8e[_0x3add('0x14')]==!![]){$(_0x3add('0x9')+_0x41c7cf)[_0x3add('0x2')]();}alert(_0x3dbe8e['msg']);}});return![];};});
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
            
        }
        
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