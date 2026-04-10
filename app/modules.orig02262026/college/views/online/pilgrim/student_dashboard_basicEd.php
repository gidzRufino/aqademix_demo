<?php
$loadedSubject = Modules::run('registrar/getOvrLoadSub', $this->session->details->st_id, $this->session->semester, $this->session->details->school_year);
//echo $this->session->details->status;
if ($this->session->details->status == 4):
    $msg = "Your application for enrollment undergoes an evaluation from the finance department because of past dues, but this will be quick so visit us often";
elseif ($this->session->details->status == 3):
    $msg = "You can now proceed to the next step of the enrollment procedure please click <a class='btn btn-xs btn-info' onclick='getFinDetails()' href='#'>Next</a> to proceed";
elseif ($this->session->details->status == 5):
    $msg = 'Payment made not yet Confirmed by the Finance Department. You may visit Finance office for queries';
elseif ($this->session->details->status == 6):
    if (count($loadedSubject) == 0):
        $msg = 'Please Add Subjects to take';
    else:
        $msg = 'Enrollment Application is being evaluated as of the moment.';
    endif;
elseif ($this->session->details->status == 1 && $this->session->school_year == $this->session->details->school_year && $this->session->semester == $this->session->details->semester):
    $msg = '<h3 style="text-align: center">Congratulations! <br>You are now officialy enrolled</h3><br>';
elseif ($this->session->details->status == 0):
    $msg = 'Your Enrollment Application is subject for Approval within 24 hours.';
else:
    $msg = '';
endif;
//echo $this->session->details->st_id . ' ' . $this->session->semester;
$admissionRemarks = Modules::run('college/enrollment/getAdmissionRemarks', $this->session->details->st_id, $this->session->semester, $this->session->details->school_year);
?>
<div id="studentDashboard" class="modal fade col-lg-6 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <div class="col-lg-1 col-xs-2 no-padding">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
        </div>
        <div class="col-lg-5 col-xs-10">
            <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
            <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
        </div>

        <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->fullname . '!'; ?></h4>
        <h5 class="text-right" style="color:black;"><?php echo $this->session->details->level; ?></h5>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">  
        <div class="modal-body clearfix">
            <div class="col-lg-12">
                <?php
                if (!$this->session->isOld):
                    $this->load->view('../upload_req');
//                            
                    ?>
                    <!--<div class="col-lg-12 col-xs-12">-->

                    <!--    <div class="col-lg-6 col-md-6 col-xs-12"></div>-->
                    <!--    <div class="col-lg-6 col-md-6 col-xs-12">-->
                    <!--        <button id="uploadConfirm" onclick="submitUploadedData(), $(this).remove()" style="width:100%;"-->
                    <!--                class="btn btn-small btn-success visible-xs-block visible-lg-inline-block-->
                    <!--                visible-sm-inline-block visible-md-inline-block">-->
                    <!--            Submit Enrollment Requirements-->
                    <!--        </button>-->
                    <!--    </div>-->
                    <!--    <div class="col-lg-5 col-md-5 col-xs-12"></div>-->

                    <!--</div>-->

                    <?php
                endif;
                ?>
            </div>
            <?php
            // print_r($this->session->userdata());   
            if ($this->session->semester == 3):
                switch (TRUE):
                    case $this->session->semester != $this->session->details->semester:
                        ?>
                        <div class="col-lg-12 col-xs-12">
                            <h4 class="text-center">By clicking the confirm button you agree to enroll this summer for the school year <?php echo $this->session->school_year . ' - ' . ($this->session->school_year + 1) ?></h4>
                            <div class="col-lg-4 col-md-4 col-xs-12"></div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <button onclick="submitEnrollmentData(), $(this).remove()" style="width:100%;"
                                        class="btn btn-small btn-success visible-xs-block visible-lg-inline-block
                                        visible-sm-inline-block visible-md-inline-block">
                                    CONFIRM
                                </button>
                            </div>
                            <div class="col-lg-5 col-md-5 col-xs-12"></div>
                        </div>
                        <?php
                        break;
                    case $this->session->details->status != 0 && $this->session->details->status != 3 && $this->session->details->status != 4:
                        ?>
                        <div style="width: 100%" class="col-lg-12 no-padding">
                            <div class="form-group pull-left">
                                <h4 class="text-left no-margin col-lg-12 col-xs-12 no-padding">Subjects To Take</h4>
                            </div>
                            <div class="form-group pull-right">
                                <button onclick="$('#searchSubject').modal('show')" title="search more subjects" style="margin-left:5px;" class="btn btn-sm btn-info pull-right">Search Subject <i class="fa fa-search-plus"></i></button>

                            </div>
                        </div>
                        <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8 col-xs-12 no-padding">
                                <table id="tableSched" class="table table-stripped table-responsive">
                                    <tr>
                                        <th>Subject</th>
                                        <th style="width: 20%" class="text-center">Action</th>
                                    </tr>
                                    <tbody id="subjectLoadBody">
                                        <?php
                                        if ($this->session->details->status != 0):
                                            foreach ($loadedSubject as $ls):
                                                ?>
                                                <tr id="tr_<?php echo $ls->subject_id ?>" class="trSched" subject_id="' + subject_id + '"  >
                                                    <td><?php echo strtoupper($ls->subject) ?></td>
                                                    <td></td>
                                                </tr>
                                                <?php if ($admissionRemarks): ?>
                                                    <tr>
                                                        <td colspan="2" class="danger text-center">Admission Remarks</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="info text-center"><i class="fa fa-info fa-fw" ></i>&nbsp;&nbsp;<?php echo $admissionRemarks->remarks ?></td>

                                                    </tr>
                                                <?php endif; ?>  
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <?php
                        break;
                endswitch;
                ?>

                <?php
            else: // not Summer
                // print_r($this->session->userdata());
                switch (TRUE):

                    case $this->session->details->school_year != $this->session->school_year:
                    case $this->session->details->school_year != $this->session->school_year && $this->session->details->status == 0:
                        ?>
                        <div class="col-lg-12 col-xs-12">
                            <h4 class="text-center">By clicking the confirm button you agree to enroll in Grade <?php echo $this->session->details->grade_id ?> for the school year <?php echo $this->session->school_year . ' - ' . ($this->session->school_year + 1) ?></h4>
                            <div class="col-lg-4 col-md-4 col-xs-12"></div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <button onclick="submitEnrollmentData(), $(this).remove()" style="width:100%;"
                                        class="btn btn-small btn-success visible-xs-block visible-lg-inline-block
                                        visible-sm-inline-block visible-md-inline-block">
                                    CONFIRM
                                </button>
                            </div>
                            <div class="col-lg-5 col-md-5 col-xs-12"></div>
                        </div>
                        <?php
                        break;
                    case $this->session->details->school_year == $this->session->school_year && $this->session->details->status == 0:
                        if ($this->session->isOld):
                            $gradeLevel = 'Grade ' . $this->session->details->grade_id;
                        elseif ($this->session->details->grade_id >= 2 && $this->session->details->grade_id <= 13):
                            $gradeLevel = 'Grade ' . ($this->session->details->grade_id - 1);


                        else:
                            switch ($this->session->details->grade_id):
                                case 1:
                                    $gradeLevel = 'Kinder 2';
                                    break;
                                case 14:
                                    $gradeLevel = 'Nursery';
                                    break;
                                case 15:
                                    $gradeLevel = 'Kinder 1';
                                    break;
                            endswitch;
                        endif;
//                        echo $this->session->isOld;
//                        if (!$this->session->isOld):
//                            $this->load->view('../upload_req');
//                            
                        ?>
                        <!--                            <div class="col-lg-12 col-xs-12">
                        
                                                        <div class="col-lg-6 col-md-6 col-xs-12"></div>
                                                        <div class="col-lg-6 col-md-6 col-xs-12">
                                                            <button id="uploadConfirm" onclick="submitUploadedData(), $(this).remove()" style="width:100%;"
                                                                    class="btn btn-small btn-success visible-xs-block visible-lg-inline-block
                                                                    visible-sm-inline-block visible-md-inline-block">
                                                                Submit Enrollment Requirements
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-xs-12"></div>
                        
                                                    </div>-->

                        <?php
//                        endif;

                        break;
                    default :
                        if (!$this->session->isOld):
                        //  $this->load->view('upload_req');
                        endif;
                        break;
                endswitch;
            endif;
            ?>
        </div> <!--end of modal-body --> 
        <div class="modal-footer clearfix" style="display: none;" id="confirmGrp">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <button onclick="submitEnrollmentData()" style="margin: 0 auto" class="btn btn-small btn-success btn-block">CONFIRM</button><br />
                <button style="margin: 0 auto" class="btn btn-small btn-danger btn-block">CANCEL</button>
            </div>
        </div>
        <div class="modal-footer clearfix" id="confirmMsgWrapper">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="alert alert-info">
                    <p class="text-center" style="display:<?php echo ($this->session->details->status == 0 && !$this->session->isOld ? '' : 'none') ?>;">
                        Please Upload the enrollment requirements
                    </p>
                    <p id="confirmMsg" class="text-center">
                        <?php echo $msg ?>
                    </p>
                    <button onclick="document.location = '<?php echo base_url('entrance') ?>'" class="btn btn-danger btn-xs">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="base" value="<?php echo base_url(); ?>" />
<input type="hidden" id="studentID" value="<?php echo base64_encode($this->session->details->st_id) ?>" />
<input type="hidden" id="year_level" value="<?php echo $this->session->details->grade_level_id ?>" />
<input type="hidden" id="previous_school_year" value="<?php echo $this->session->school_year ?>" />
<input type="hidden" id="previous_semester" value="<?php echo $this->session->semester ?>" />
<input type="hidden" id="user_id" value="<?php echo $this->session->details->user_id ?>" />

<div id="scheduleModal" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-info" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Please Select Schedule</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; overflow: scroll">  
        <div id="schedBody" class="modal-body clearfix">
        </div>    
    </div>    
</div>

<div id="searchSubject" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-warning" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Search Subject</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
        <input class="form-control" onkeypress="if (event.keyCode == 13) {
                    searchSubjectOffered(this.value)
                }"  name="studentNumber" type="text" id="studentNumber" placeholder="Search Subject Code and press enter" />
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;  box-shadow:3px 3px 5px 6px #ccc; ">  
        <div id="searchBody" class="modal-body clearfix">
        </div>    
    </div>    
</div>

<script type="text/javascript">
    // var _0x3cc6=['#confirmGrp','ready','#units_','modal','subject_id','#scheduleModal','ajax','hidden.bs.modal','stringify','student/accounts','location','.modal:visible','remove','System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently','college/enrollment/searchBasicEdSubject/','#searchBody','body','each','val','select2','#tableSched\x20tr.trSched','csrf_cookie_name','#base','#previous_semester','<td\x20class=\x22text-center\x22>\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20onclick=\x22removeSubject(\x27','#schedBody','#tr_','#confirmMsg','st_id','#totalUnits','append','#previous_school_year','</td>','#studentID','json','#course_id','<tr\x20id=\x22tr_','show','college/enrollment/loadSchedule/','modal-open','#user_id','cookie','POST','\x22\x20\x20>','#schedDetails','#confirmMsgWrapper','#year_level','html','#subjectLoadBody','Please\x20Wait\x20while\x20system\x20is\x20submitting\x20your\x20request...','college/enrollment/getSubjectLoad/','push','<td>','length','log','hide','\x27)\x22\x20title=\x22remove\x20from\x20the\x20list\x22\x20class=\x22btn\x20btn-danger\x20btn-xs\x22><i\x20class=\x22fa\x20fa-trash\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</td>','#searchSubject','#inputSem','attr','\x22\x20class=\x22trSched\x22\x20subject_id=\x22','#btnConfirm','addClass','.modal'];(function(_0x4cec70,_0x3cc6f3){var _0x1ce321=function(_0x249076){while(--_0x249076){_0x4cec70['push'](_0x4cec70['shift']());}};_0x1ce321(++_0x3cc6f3);}(_0x3cc6,0x1a7));var _0x1ce3=function(_0x4cec70,_0x3cc6f3){_0x4cec70=_0x4cec70-0x0;var _0x1ce321=_0x3cc6[_0x4cec70];return _0x1ce321;};$(document)[_0x1ce3('0x1a')](function(){$(_0x1ce3('0x13'))[_0x1ce3('0x2c')]();$('#studentDashboard')[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$(_0x1ce3('0x18'))['on'](_0x1ce3('0x20'),function(_0x1ecda2){if($(_0x1ce3('0x24'))[_0x1ce3('0xe')]){$(_0x1ce3('0x29'))[_0x1ce3('0x17')](_0x1ce3('0x0'));}});});$(function(){var _0x2e071d=0x0;fetchSearchSubject=function(_0x25a345,_0x597026){var _0x5a45ae=0x0;$(_0x1ce3('0x2d'))[_0x1ce3('0x2a')](function(){if($(this)[_0x1ce3('0x14')](_0x1ce3('0x1d'))===_0x25a345){_0x5a45ae++;alert('Sorry\x20this\x20subject\x20already\x20exist');}});if(_0x5a45ae==0x0){$(_0x1ce3('0x9'))[_0x1ce3('0x37')](_0x1ce3('0x3d')+_0x25a345+_0x1ce3('0x15')+_0x25a345+_0x1ce3('0x4')+_0x1ce3('0xd')+_0x597026+_0x1ce3('0x39')+_0x1ce3('0x31')+_0x25a345+_0x1ce3('0x11')+ +'</tr>');}$(_0x1ce3('0x12'))[_0x1ce3('0x1c')]('hide');$(_0x1ce3('0x19'))[_0x1ce3('0x3e')]();};removeSubject=function(_0x4208bd){_0x2e071d-=$(_0x1ce3('0x1b')+_0x4208bd)['html']();$(_0x1ce3('0x36'))[_0x1ce3('0x8')](_0x2e071d);$(_0x1ce3('0x33')+_0x4208bd)[_0x1ce3('0x25')]();};submitEnrollmentData=function(){var _0x200aca=$('#base')[_0x1ce3('0x2b')]();var _0x4db8b6=$(_0x1ce3('0x30'))[_0x1ce3('0x2b')]();var _0x50ce7a=$(_0x1ce3('0x7'))['val']();var _0x3b812f=$(_0x1ce3('0x38'))['val']();var _0x43c5ec=$(_0x1ce3('0x3a'))[_0x1ce3('0x2b')]();var _0x26c7f8=$(_0x1ce3('0x1'))[_0x1ce3('0x2b')]();var _0xf841e0=_0x200aca+'college/enrollment/saveBasicRO/';$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0xf841e0,'data':{'year_level':_0x50ce7a,'school_year':_0x3b812f,'semester':_0x4db8b6,'st_id':_0x43c5ec,'user_id':_0x26c7f8,'csrf_test_name':$['cookie'](_0x1ce3('0x2e'))},'dataType':_0x1ce3('0x3b'),'beforeSend':function(){$(_0x1ce3('0x16'))[_0x1ce3('0x10')]();$(_0x1ce3('0x32'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x256cd3){if(_0x4db8b6==0x3){loadEnrollmentData(_0x256cd3[_0x1ce3('0x35')],_0x256cd3['user_id']);console[_0x1ce3('0xf')](_0x256cd3);}}});return![];};loadEnrollmentData=function(_0x175a16,_0x23fdc2){var _0x4f2bfa=[];$(_0x1ce3('0x2d'))[_0x1ce3('0x2a')](function(){var _0x414852={'sub_id':$(this)[_0x1ce3('0x14')](_0x1ce3('0x1d')),'level_id':$('#year_level')[_0x1ce3('0x2b')](),'st_id':_0x175a16,'is_overload':0x3,'sem':0x3};_0x4f2bfa[_0x1ce3('0xc')](_0x414852);});var _0x1df43e=JSON[_0x1ce3('0x21')](_0x4f2bfa);var _0x66f85a=$(_0x1ce3('0x38'))[_0x1ce3('0x2b')]();var _0x12917d=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0xed50e4=_0x12917d+'college/enrollment/saveBasicLoad';$['ajax']({'type':_0x1ce3('0x3'),'url':_0xed50e4,'data':{'enData':_0x1df43e,'semester':$(_0x1ce3('0x30'))['val'](),'school_year':_0x66f85a,'st_id':_0x175a16,'user_id':_0x23fdc2,'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x19'))[_0x1ce3('0x10')]();$(_0x1ce3('0x6'))[_0x1ce3('0x3e')]();$(_0x1ce3('0x34'))[_0x1ce3('0x8')](_0x1ce3('0xa'));},'success':function(_0x2ab571){$(_0x1ce3('0x34'))[_0x1ce3('0x8')]('You\x20have\x20Successfully\x20Submitted\x20your\x20application\x20for\x20enrollment,\x20We\x20will\x20notify\x20you\x20in\x20the\x20next\x2024\x20to\x2048\x20hours\x20once\x20your\x20subjects\x20are\x20approved.\x20Thank\x20you\x20for\x20using\x20this\x20online\x20system.');$('.action')[_0x1ce3('0x25')]();}});return![];};getSchedule=function(_0x171742){if(_0x171742!=0x0){var _0x48933f=$(_0x1ce3('0x3a'))[_0x1ce3('0x2b')]();var _0x5a124d=$(_0x1ce3('0x3c'))[_0x1ce3('0x2b')]();var _0x8d0786=$(_0x1ce3('0x7'))[_0x1ce3('0x2b')]();var _0x7b4edd=$('#previous_school_year')[_0x1ce3('0x2b')]();var _0x5e3ec9=$(_0x1ce3('0x2f'))['val']();var _0x41806e=_0x5e3ec9+_0x1ce3('0xb')+_0x48933f+'/'+_0x5a124d+'/'+_0x8d0786+'/'+_0x171742+'/'+_0x7b4edd;$[_0x1ce3('0x1f')]({'type':'POST','url':_0x41806e,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x5'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x34a6f0){$(_0x1ce3('0x5'))['html'](_0x34a6f0);if(_0x2e071d!=0x0){$(_0x1ce3('0x19'))['show']();}}});return![];}};searchSubjectOffered=function(_0x44dcf2){var _0xe8cd28=$(_0x1ce3('0x38'))['val']();var _0x127ba7=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0xb1d3ff=_0x127ba7+_0x1ce3('0x27')+_0x44dcf2+'/'+_0xe8cd28;$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0xb1d3ff,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x28'))['html'](_0x1ce3('0x26'));},'success':function(_0x1dbe42){$(_0x1ce3('0x28'))[_0x1ce3('0x8')](_0x1dbe42);}});return![];};});function hasTimeConflict(_0x18ac59,_0x4e9401,_0x166c68,_0x344e7d){var _0x233edf=timestamp(_0x18ac59);var _0x36c42d=timestamp(_0x4e9401);var _0x29adcd=timestamp(_0x166c68);var _0x542130=timestamp(_0x344e7d);if(_0x233edf>=_0x29adcd&&_0x233edf<_0x542130){return!![];}else if(_0x36c42d<_0x542130&&_0x36c42d>_0x542130){return!![];}else if(_0x233edf==_0x29adcd){return!![];}else{return![];}}function getFinDetails(){var _0x2f54b7=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0x4c8001=_0x2f54b7+_0x1ce3('0x22');document[_0x1ce3('0x23')]=_0x4c8001;}function modalControl(_0x391088,_0x2dc8b0){$('#'+_0x391088)[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$('#'+_0x2dc8b0)[_0x1ce3('0x1c')](_0x1ce3('0x10'));}function loadSchedule(_0x34e9be){var _0x189932=$(_0x1ce3('0x13'))['val']();var _0x5a4577=$(_0x1ce3('0x38'))[_0x1ce3('0x2b')]();var _0x12d0da=$(_0x1ce3('0x2f'))[_0x1ce3('0x2b')]();var _0x4573cb=_0x12d0da+_0x1ce3('0x3f')+_0x34e9be+'/'+_0x189932+'/'+_0x5a4577;$[_0x1ce3('0x1f')]({'type':_0x1ce3('0x3'),'url':_0x4573cb,'data':{'csrf_test_name':$[_0x1ce3('0x2')](_0x1ce3('0x2e'))},'beforeSend':function(){$(_0x1ce3('0x32'))[_0x1ce3('0x8')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x2b9c03){$(_0x1ce3('0x1e'))[_0x1ce3('0x1c')](_0x1ce3('0x3e'));$(_0x1ce3('0x32'))[_0x1ce3('0x8')](_0x2b9c03);}});return![];}
    $(document).ready(function () {

        $('#inputSem').select2();
        $('#studentDashboard').modal('show');

        $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
            if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
                $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
            }
        });
        //hasTimeConflict('08:30','10:30','07:30','11:30');    
    });

    $(function () {

        var totalUnits = 0;

        fetchSearchSubject = function (subject_id, subject)
        {
            var exist = 0;
            $('#tableSched tr.trSched').each(function () {
                //alert($(this).attr('id'))
                if ($(this).attr('subject_id') === subject_id)
                {
                    exist++;
                    alert('Sorry this subject already exist');
                }
            });


            if (exist == 0) {
                $('#subjectLoadBody').append(
                        '<tr id="tr_' + subject_id + '" class="trSched" subject_id="' + subject_id + '"  >' +
                        '<td>' + subject + '</td>' +
                        '<td class="text-center"> \n\
                            <button onclick="removeSubject(\'' + subject_id + '\')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>\n\
                        </td>' +
                        +'</tr>'
                        );
            }

            $('#searchSubject').modal('hide');
            $('#confirmGrp').show();

        };


        removeSubject = function (sub_id)
        {
            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);
            $('#tr_' + sub_id).remove();
        };
        submitUploadedData = function ()
        {
            var base = $('#base').val();
            var school_year = $('#previous_school_year').val();
            var st_id = $('#studentID').val();
            var user_id = $('#user_id').val();
            var url = base + 'college/enrollment/submitUploadedData/';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    school_year: school_year,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                beforeSend: function () {
                    $('#uploadConfirm').attr('disabled');
                    $('#uploadConfirm').html('System is processing...Thank you for waiting patiently');
                },
                success: function (data)
                {
                    alert(data);
                    document.location = base + 'entrance';

                }
            });

            return false;
        };
        submitEnrollmentData = function ()
        {
            var base = $('#base').val();
            var semester = $('#previous_semester').val();
            var year_level = $('#year_level').val();
            var school_year = $('#previous_school_year').val();
            var st_id = $('#studentID').val();
            var user_id = $('#user_id').val();

            var url = base + 'college/enrollment/saveBasicRO/'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    year_level: year_level,
                    school_year: school_year,
                    semester: semester,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function () {
                    $('#btnConfirm').hide();
                    $('#schedBody').html('System is processing...Thank you for waiting patiently');
                },
                success: function (data)
                {
                    if (semester === '3')
                    {
                        loadEnrollmentData(data.st_id, data.user_id);
                        console.log(data)
                    } else {
                        $('#confirmMsgWrapper').show();
                        $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    }

                }
            });

            return false;

        };

        loadEnrollmentData = function (st_id, user_id)
        {
            var enrollmentDetails = [];
            $('#tableSched tr.trSched').each(function () {
                var id = {
                    'sub_id': $(this).attr('subject_id'),
                    'level_id': $('#year_level').val(),
                    'st_id': st_id,
                    'is_overload': 3,
                    'sem': 3
                };
                enrollmentDetails.push(id);
            });

            var enrollmentData = JSON.stringify(enrollmentDetails);
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/saveBasicLoad';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    enData: enrollmentData,
                    semester: $('#previous_semester').val(),
                    school_year: school_year,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function () {
                    $('#confirmGrp').hide();
                    $('#confirmMsgWrapper').show();
                    $('#confirmMsg').html('Please Wait while system is submitting your request...');

                },
                success: function (data)
                {
                    $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    $('.action').remove();

                    //alert(data);
                }
            });

            return false;

        }


        getSchedule = function (sem)
        {
            if (sem != 0) {
                var st_id = $('#studentID').val();
                var course_id = $('#course_id').val();
                var year_level = $('#year_level').val();
                var school_year = $('#previous_school_year').val();
                var base = $('#base').val();

                var url = base + 'college/enrollment/getSubjectLoad/' + st_id + '/' + course_id + '/' + year_level + '/' + sem + '/' + school_year; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name'),

                    }, // serializes the form's elements.
                    // dataType:'json',
                    beforeSend: function () {
                        $('#schedDetails').html('System is processing...Thank you for waiting patiently')
                    },
                    success: function (data)
                    {
                        $('#schedDetails').html(data);
                        if (totalUnits != 0) {
                            $('#confirmGrp').show();
                        }
                    }
                });

                return false;
            }

        }



        searchSubjectOffered = function (value)
        {
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/searchBasicEdSubject/' + value + '/' + school_year; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                }, // serializes the form's elements.
                // dataType:'json',
                beforeSend: function () {
                    $('#searchBody').html('System is processing...Thank you for waiting patiently')
                },
                success: function (data)
                {
                    $('#searchBody').html(data);

                }
            });

            return false;

        };



    });

    function hasTimeConflict(timeFrom, timeTo, dbFrom, dbTo)
    {
        var cf = timestamp(timeFrom);
        var ct = timestamp(timeTo);
        var tf = timestamp(dbFrom);
        var tt = timestamp(dbTo);

        if (cf >= tf && cf < tt) {
            //alert('conflict 1');
            return true;
        } else if (ct < tt && ct > tt) {
            //alert('conflict 2');
            return true;

        } else if (cf == tf) {
            //alert('conflict 3');
            return true;
        } else {
            //alert('time is available');
            return false;
        }

    }

    function getFinDetails()
    {
        var base = $('#base').val();
        var url = base + 'student/accounts'; // the script where you handle the form input.
        document.location = url;
    }

    function modalControl(open, close)
    {
        $('#' + open).modal('show');
        $('#' + close).modal('hide');
    }

    function loadSchedule(s_id)
    {
        var semester = $('#inputSem').val();
        var school_year = $('#previous_school_year').val();
        var base = $('#base').val();
        var url = base + 'college/enrollment/loadSchedule/' + s_id + '/' + semester + '/' + school_year; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),

            }, // serializes the form's elements.
            // dataType:'json',
            beforeSend: function () {
                $('#schedBody').html('System is processing...Thank you for waiting patiently')
            },
            success: function (data)
            {
                $('#scheduleModal').modal('show');
                $('#schedBody').html(data);
            }
        });

        return false;

    }

</script>
