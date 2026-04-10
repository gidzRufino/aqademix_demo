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
    if ($this->session->userdata('position_id') == 1 ||
            $this->session->position == "IBDE Department Head" ||
            $this->session->position == "Accounting Staff" ||
            $this->session->position == "Cashier"):
        $totalCharges = 0;
        $totalExamFee = 0;
        $totalLab = 0;
        if ($student->status): //SUBJECTS ALREADY APPROVED
            $plan = Modules::run('finance/getPlanByCourse', $student->grade_level_id, 0, $student->st_type, $student->school_year);
            $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
            
            $previousRecord = json_decode(Modules::run('finance/getRunningBalance', base64_encode($student->st_id), ($student->semester==3?$student->school_year:($student->school_year-1)), ($student->semester==3?0:$student->semester)));
            $previousBalance = $previousRecord->charges - $previousRecord->payments;
            $hasBalance = $previousBalance > 0 ? TRUE : FALSE;
            
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
                            <?php if($hasBalance): 
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
                <h3 class="text-center">NO FINANCE RECORD YET, <br /> STUDENT UNDER EVALUATION</h3>
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
   //var _0x5e4f=['location','[data-toggle=\x22popover\x22]','PAYMENT\x20CONFIRMED','college/enrollment/confirmPayment/','html','Are\x20you\x20sure\x20to\x20confirm\x20the\x20payment?','addClass','removeClass','college/subjectmanagement/approveLoad/','#user_id','csrf_cookie_name','System\x20is\x20confirming\x20payment\x20now...Please\x20Wait...','#loadingModal','college/enrollment/sendFinanceRemarks/1','show','#loadMsg\x20td','Are\x20you\x20sure\x20you\x20want\x20to\x20approve\x20this\x20application\x20for\x20enrollment?','#loadMsg','#base','#base_url','msg','college/enrollment/removeSubject/','#semester','val','btn-primary','remove','popover','status','hide','#school_year','ajax','cookie','Are\x20you\x20sure\x20you\x20want\x20to\x20remove\x20this\x20Student?','#btnApprove','college/enrollment/removeEnrollmentDetails/','college/enrollment/approveBasicEdOnline/','#st_id','#admissionRemarkDetails','modal','#tr_total_taken','btn-success','college/enrollment/sendAdmissionRemarks/1','click','GET','reload','#adm_id','#td_units_','#confirmPayment','json','POST','#remarkDetails'];(function(_0x14bd38,_0x5e4f27){var _0x1de276=function(_0x56101e){while(--_0x56101e){_0x14bd38['push'](_0x14bd38['shift']());}};_0x1de276(++_0x5e4f27);}(_0x5e4f,0xbb));var _0x1de2=function(_0x14bd38,_0x5e4f27){_0x14bd38=_0x14bd38-0x0;var _0x1de276=_0x5e4f[_0x14bd38];return _0x1de276;};$(document)['ready'](function(){var _0x8f458b=$(_0x1de2('0x24'))['val']();if($('#totalLect_taken')[_0x1de2('0x15')]()==0x0){$(_0x1de2('0x5'))['hide']();};$(_0x1de2('0x12'))[_0x1de2('0x2b')]({'html':!![]});popoverhide=function(){$(_0x1de2('0x12'))[_0x1de2('0x2b')](_0x1de2('0x2d'));};$(_0x1de2('0xd'))[_0x1de2('0x8')](function(){var _0x436ae5=confirm(_0x1de2('0x16'));if(_0x436ae5==!![]){var _0x326e21=_0x8f458b+_0x1de2('0x14');$['ajax']({'type':_0x1de2('0xf'),'url':_0x326e21,'dataType':_0x1de2('0xe'),'data':{'st_id':$(_0x1de2('0x2'))[_0x1de2('0x28')](),'user_id':$(_0x1de2('0x1a'))[_0x1de2('0x28')](),'semester':$(_0x1de2('0x27'))[_0x1de2('0x28')](),'school_year':$(_0x1de2('0x2e'))[_0x1de2('0x28')](),'csrf_test_name':$[_0x1de2('0x30')]('csrf_cookie_name')},'beforeSend':function(){$(_0x1de2('0xd'))[_0x1de2('0x15')](_0x1de2('0x1c'));},'success':function(_0x4ee453){$('#confirmPayment')['html'](_0x1de2('0x13'));$(_0x1de2('0xd'))[_0x1de2('0x18')](_0x1de2('0x29'));$(_0x1de2('0xd'))[_0x1de2('0x17')](_0x1de2('0x6'));alert(_0x4ee453['msg']);location[_0x1de2('0xa')]();}});return![];}});$(_0x1de2('0x32'))[_0x1de2('0x8')](function(){var _0x32c0ca=_0x8f458b+_0x1de2('0x19')+$(_0x1de2('0xb'))[_0x1de2('0x28')]()+'/'+$('#user_id')[_0x1de2('0x28')]();$[_0x1de2('0x2f')]({'type':_0x1de2('0x9'),'url':_0x32c0ca,'dataType':_0x1de2('0xe'),'data':'csrf_test_name='+$[_0x1de2('0x30')](_0x1de2('0x1b')),'success':function(_0x321a25){alert(_0x321a25[_0x1de2('0x25')]);location[_0x1de2('0xa')]();}});return![];});$('#onlineBtnApprove')[_0x1de2('0x8')](function(){var _0x208b14=confirm(_0x1de2('0x21'));if(_0x208b14==!![]){var _0x21713a=_0x8f458b+_0x1de2('0x1')+$(_0x1de2('0xb'))[_0x1de2('0x28')]()+'/'+$(_0x1de2('0x1a'))['val']()+'/'+$(_0x1de2('0x2e'))[_0x1de2('0x28')]()+'/'+$(_0x1de2('0x27'))[_0x1de2('0x28')]();$['ajax']({'type':_0x1de2('0x9'),'url':_0x21713a,'dataType':_0x1de2('0xe'),'data':'csrf_test_name='+$[_0x1de2('0x30')](_0x1de2('0x1b')),'beforeSend':function(){$(_0x1de2('0x1d'))[_0x1de2('0x4')](_0x1de2('0x1f'));},'success':function(_0x646579){$(_0x1de2('0x1d'))[_0x1de2('0x4')](_0x1de2('0x2d'));alert(_0x646579['msg']);location[_0x1de2('0xa')]();}});return![];}});var _0x8f458b=$('#base_url')['val']();sendAdmissionRemark=function(){var _0x4167db=$(_0x1de2('0x2'))[_0x1de2('0x28')]();var _0x55163a=$(_0x1de2('0x3'))['val']();var _0x59845e=$(_0x1de2('0x2e'))['val']();var _0x17a734=$(_0x1de2('0x27'))[_0x1de2('0x28')]();var _0x40e032=_0x8f458b+_0x1de2('0x7');$[_0x1de2('0x2f')]({'type':_0x1de2('0xf'),'url':_0x40e032,'data':{'csrf_test_name':$[_0x1de2('0x30')]('csrf_cookie_name'),'st_id':_0x4167db,'semester':_0x17a734,'school_year':_0x59845e,'remarks':_0x55163a},'success':function(_0x225c04){alert(_0x225c04);location[_0x1de2('0xa')]();}});return![];};sendRemarks=function(){var _0x1c2449=$('#st_id')['val']();var _0x100426=$(_0x1de2('0x10'))['val']();var _0x4e156f=$(_0x1de2('0x2e'))['val']();var _0x4f7470=$('#semester')[_0x1de2('0x28')]();var _0x431c98=$(_0x1de2('0xb'))[_0x1de2('0x28')]();var _0x4581b0=_0x8f458b+_0x1de2('0x1e');$[_0x1de2('0x2f')]({'type':'POST','url':_0x4581b0,'data':{'csrf_test_name':$['cookie'](_0x1de2('0x1b')),'st_id':_0x1c2449,'semester':_0x4f7470,'school_year':_0x4e156f,'remarks':_0x100426,'adm_id':_0x431c98},'success':function(_0x52d60e){alert(_0x52d60e);location[_0x1de2('0xa')]();}});return![];};removeSubject=function(_0x2614a6){var _0x329cfc=$(_0x1de2('0x1a'))[_0x1de2('0x28')]();var _0x39a959=parseInt($('#totalUnits')[_0x1de2('0x15')]());_0x39a959-=parseInt($(_0x1de2('0xc')+_0x2614a6)['html']());$('#totalUnits')[_0x1de2('0x15')](_0x39a959);var _0x261b8e=_0x8f458b+_0x1de2('0x26');$['ajax']({'type':_0x1de2('0xf'),'url':_0x261b8e,'dataType':_0x1de2('0xe'),'data':{'csrf_test_name':$[_0x1de2('0x30')](_0x1de2('0x1b')),'user_id':_0x329cfc,'subject_id':_0x2614a6,'school_year':$(_0x1de2('0x2e'))[_0x1de2('0x28')]()},'success':function(_0x204ec0){if(_0x204ec0[_0x1de2('0x2c')]==!![]){$('#tr_'+_0x2614a6)[_0x1de2('0x2a')]();}alert(_0x204ec0[_0x1de2('0x25')]);}});return![];};});function removeEnrollmentDetails(_0x1646dd,_0xdcbb12){var _0x291c15=$(_0x1de2('0x23'))['val']();var _0x1ca67d=_0x291c15+_0x1de2('0x0');var _0x4a01d2=confirm(_0x1de2('0x31'));if(_0x4a01d2==!![]){$[_0x1de2('0x2f')]({'type':_0x1de2('0xf'),'url':_0x1ca67d,'data':{'adm_id':_0x1646dd,'school_year':_0xdcbb12,'csrf_test_name':$[_0x1de2('0x30')](_0x1de2('0x1b'))},'beforeSend':function(){$(_0x1de2('0x22'))[_0x1de2('0x1f')]();$(_0x1de2('0x20'))[_0x1de2('0x15')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x527559){alert(_0x527559);document[_0x1de2('0x11')]=_0x291c15+'college/enrollment/monitor';}});return![];}}
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

        $('#confirmPayment').click(function () {

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