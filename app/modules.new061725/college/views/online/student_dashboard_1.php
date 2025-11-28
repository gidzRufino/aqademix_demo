<?php
switch ($this->session->details->year_level):
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
<div id="studentDashboard" class="modal fade col-lg-6 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <div class="col-lg-1 col-xs-2 no-padding">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
        </div>
        <div class="col-lg-5 col-xs-10">
            <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
            <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
        </div>
        <?php
        print_r($this->session->userdata());
        ?>

        <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
        <h6 class="text-right" style="color:black;"><?php echo $this->session->details->course.'<br />'.$year_level; ?></h6>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">  
        <div class="modal-body clearfix">
            <div style="width: 100%" class="col-lg-12 no-padding">
                <div class="form-group pull-left">
                    <h4 class="text-left no-margin col-lg-12 col-xs-12 no-padding">Subjects Offered <small>As reflected in the prospectus</small></h4>
                </div>
                <div class="form-group pull-right">
                    <button onclick="$('#searchSubject').modal('show')" title="search more subjects" style="margin-left:5px;" class="btn btn-xs btn-info pull-right"><i style="font-size: 20px" class="fa fa-search-plus"></i></button>
                    <select onclick="getSchedule(this.value)" tabindex="-1" id="inputSem" style="width:200px; font-size: 15px;" class=" ">
                        <option value="0">Please Select Semester</option>
                      <option value="1">First</option>
                        <!--  <option value="2">Second</option>
                        <option value="3">Summer</option>-->
                    </select>
                </div>
            </div>
            <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">

            </div>
        </div> <!--end of modal-body --> 
        <div class="modal-footer clearfix" style="display: none;" id="confirmGrp">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <button onclick="submitEnrollmentData()" style="margin: 0 auto" class="btn btn-small btn-success btn-block">CONFIRM</button><br />
                <button style="margin: 0 auto" class="btn btn-small btn-danger btn-block">CANCEL</button>
            </div>
        </div>
        <div class="modal-footer clearfix" style="display: none;" id="confirmMsgWrapper">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="alert alert-info">
                    <p id="confirmMsg" class="text-center"></p>
                    <button onclick="document.location='<?php  echo base_url('entrance') ?>'" class="btn btn-danger btn-xs">Close</button>
                </div>
            </div>
        </div>

    </div>
    
</div>     
</div>
<input type="hidden" id="base" value="<?php echo base_url(); ?>" />
<input type="hidden" id="studentID" value="<?php echo base64_encode($this->session->details->st_id) ?>" />
<input type="hidden" id="course_id" value="<?php echo $this->session->course_id ?>" />
<input type="hidden" id="year_level" value="<?php echo $this->session->details->year_level ?>" />
<input type="hidden" id="previous_school_year" value="<?php echo $this->session->details->school_year ?>" />
<input type="hidden" id="previous_semester" value="<?php echo $this->session->details->semester ?>" />
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
var _0x5e9d=['hide','student/accounts','#searchBody','attr','#confirmMsgWrapper','show','#schedDetails','#studentDashboard','sub_id','college/enrollment/loadSchedule/','college/enrollment/searchSubject/','</tr>','tr_','time_from','#btnConfirm','cookie','#user_id','#subjectLoadBody','each','remove','#totalUnits','POST','log','\x20td.hasValue','sub_code','\x22\x20class=\x22trSched\x22\x20sub_code=\x22','<td\x20class=\x22hasValue\x22\x20id=\x22units_','ajax','\x27)\x22\x20title=\x22clear\x20schedule\x22\x20class=\x22btn\x20btn-warning\x20btn-xs\x22><i\x20class=\x22fa\x20fa-minus\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20onclick=\x22removeSubject(\x27','\x27)\x22\x20title=\x22search\x20for\x20schedule\x22\x20class=\x22btn\x20btn-success\x20btn-xs\x22><i\x20class=\x22fa\x20fa-search\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20onclick=\x22clearSchedule(\x27','#year_level','modal-open','length','append','val','You\x20have\x20Successfully\x20Submitted\x20your\x20application\x20for\x20enrollment,\x20We\x20will\x20notify\x20you\x20in\x20the\x20next\x2024\x20to\x2048\x20hours\x20once\x20your\x20study\x20load\x20is\x20approved.\x20Thank\x20you\x20for\x20using\x20this\x20online\x20system.','<td>','\x27)\x22\x20title=\x22remove\x20from\x20the\x20list\x22\x20class=\x22btn\x20btn-danger\x20btn-xs\x22><i\x20class=\x22fa\x20fa-trash\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</td>','#tableSched\x20tr.trSched','Sorry\x20this\x20subject\x20already\x20exist','#studentID','#confirmMsg','admission_id','location','#daytime_','.modal','alert\x20alert-danger','#inputSem','<td\x20class=\x22hasValue\x22\x20id=\x22daytime_','core/saveLoadedSubjects','modal','#base','#units_','System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently','.action','#searchSubject','#previous_school_year','ready','#confirmGrp','html','csrf_cookie_name','time_to','</td>','stringify','sec_id','addClass','#course_id','day','\x22\x20>','<td\x20class=\x22text-center\x22>\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20onclick=\x22loadSchedule(\x27','#tr_','#schedBody'];(function(_0x1f939a,_0x5e9d8b){var _0x8b2118=function(_0x404a4b){while(--_0x404a4b){_0x1f939a['push'](_0x1f939a['shift']());}};_0x8b2118(++_0x5e9d8b);}(_0x5e9d,0xe8));var _0x8b21=function(_0x1f939a,_0x5e9d8b){_0x1f939a=_0x1f939a-0x0;var _0x8b2118=_0x5e9d[_0x1f939a];return _0x8b2118;};$(document)[_0x8b21('0x29')](function(){$('#inputSem')['select2']();$(_0x8b21('0x3f'))[_0x8b21('0x22')]('show');$(_0x8b21('0x1d'))['on']('hidden.bs.modal',function(_0x149067){if($('.modal:visible')[_0x8b21('0x10')]){$('body')[_0x8b21('0x31')](_0x8b21('0xf'));}});});$(function(){var _0x4739c0=0x0;fetchSearchSubject=function(_0x152f6a,_0x3cb648,_0x52daa8,_0x5de8c2,_0x33dac6,_0x5b1d5b,_0x406162,_0xaac63f,_0x23cc3d){var _0x1a96f4=0x0;$(_0x8b21('0x16'))[_0x8b21('0x2')](function(){if($(this)[_0x8b21('0x3b')](_0x8b21('0x8'))===_0x152f6a){_0x1a96f4++;alert(_0x8b21('0x17'));}});if(_0x1a96f4==0x0){$(_0x8b21('0x1'))[_0x8b21('0x11')]('<tr\x20id=\x22tr_'+_0x5b1d5b+_0x8b21('0x9')+_0x152f6a+_0x8b21('0x34')+_0x8b21('0x14')+_0x152f6a+_0x8b21('0x2e')+_0x8b21('0xa')+_0x5b1d5b+'\x22>'+_0x5de8c2+_0x8b21('0x2e')+_0x8b21('0x20')+_0x5b1d5b+'\x22>'+_0x33dac6+_0x8b21('0x2e')+'<td\x20class=\x22hasValue\x22\x20id=\x22instructor_'+_0x5b1d5b+'\x22>'+_0x3cb648+_0x8b21('0x2e')+_0x8b21('0x35')+_0x152f6a+_0x8b21('0xd')+_0x5b1d5b+_0x8b21('0xc')+_0x5b1d5b+_0x8b21('0x15')+ +_0x8b21('0x43'));fetchSchedule(_0x152f6a,_0x3cb648,_0x52daa8,_0x5de8c2,_0x33dac6,_0x5b1d5b,_0x406162,_0xaac63f,_0x23cc3d);}$(_0x8b21('0x27'))['modal'](_0x8b21('0x38'));};fetchSchedule=function(_0x1bf6e7,_0x60573,_0x53f0de,_0x11d284,_0x4a9cd8,_0x520342,_0x117046,_0x59cb3f,_0x5123c4){var _0x1c0462=0x0;$('#tableSched\x20tr.trSched')[_0x8b21('0x2')](function(){var _0x1acbca=$(this)[_0x8b21('0x3b')](_0x8b21('0x33'));var _0x53f39c=$(this)['attr'](_0x8b21('0x45'));var _0x358f0f=$(this)[_0x8b21('0x3b')](_0x8b21('0x2d'));if($(this)['attr']('id')!==_0x8b21('0x44')+_0x520342){if(_0x1acbca===_0x5123c4){if(hasTimeConflict(_0x117046,_0x59cb3f,_0x53f39c,_0x358f0f)){$(this)[_0x8b21('0x31')](_0x8b21('0x1e'));_0x1c0462++;}}}});plotSched(_0x1bf6e7,_0x60573,_0x53f0de,_0x11d284,_0x4a9cd8,_0x520342,_0x117046,_0x59cb3f,_0x5123c4,_0x1c0462);};plotSched=function(_0x5adb34,_0x4620c8,_0x19ad9f,_0x1e8ef8,_0x584e30,_0x59207d,_0x410b1a,_0x540bc9,_0x5964bc,_0x473048){if(_0x473048==0x0){$(_0x8b21('0x24')+_0x59207d)[_0x8b21('0x2b')](_0x1e8ef8);$(_0x8b21('0x1c')+_0x59207d)[_0x8b21('0x2b')](_0x584e30);$('#instructor_'+_0x59207d)[_0x8b21('0x2b')](_0x4620c8);_0x4739c0+=parseInt(_0x1e8ef8);$(_0x8b21('0x4'))[_0x8b21('0x2b')](_0x4739c0);$(_0x8b21('0x36')+_0x59207d)[_0x8b21('0x3b')](_0x8b21('0x30'),_0x19ad9f);$(_0x8b21('0x36')+_0x59207d)[_0x8b21('0x3b')](_0x8b21('0x45'),_0x410b1a);$(_0x8b21('0x36')+_0x59207d)['attr']('time_to',_0x540bc9);$(_0x8b21('0x36')+_0x59207d)['attr'](_0x8b21('0x33'),_0x5964bc);$('#tr_'+_0x59207d)['attr'](_0x8b21('0x8'),_0x5adb34);$('#tr_'+_0x59207d)[_0x8b21('0x3b')](_0x8b21('0x40'),_0x59207d);if(_0x4739c0!=0x0){$(_0x8b21('0x2a'))[_0x8b21('0x3d')]();}}};removeSubject=function(_0x109f1f){_0x4739c0-=$(_0x8b21('0x24')+_0x109f1f)[_0x8b21('0x2b')]();$(_0x8b21('0x4'))['html'](_0x4739c0);$(_0x8b21('0x36')+_0x109f1f)[_0x8b21('0x3')]();};clearSchedule=function(_0x20e67f){_0x4739c0-=$(_0x8b21('0x24')+_0x20e67f)[_0x8b21('0x2b')]();$(_0x8b21('0x4'))[_0x8b21('0x2b')](_0x4739c0);$(_0x8b21('0x36')+_0x20e67f+_0x8b21('0x7'))[_0x8b21('0x2')](function(){$(this)[_0x8b21('0x2b')]('');});$(_0x8b21('0x36')+_0x20e67f)[_0x8b21('0x3b')](_0x8b21('0x30'),'');$('#tr_'+_0x20e67f)[_0x8b21('0x3b')]('time_from','');$(_0x8b21('0x36')+_0x20e67f)[_0x8b21('0x3b')](_0x8b21('0x2d'),'');$(_0x8b21('0x36')+_0x20e67f)[_0x8b21('0x3b')](_0x8b21('0x33'),'');};submitEnrollmentData=function(){var _0x2e8ef8=$(_0x8b21('0x23'))['val']();var _0x2aa216=$(_0x8b21('0x1f'))[_0x8b21('0x12')]();var _0x28d06c=$(_0x8b21('0x32'))[_0x8b21('0x12')]();var _0x289358=$(_0x8b21('0xe'))[_0x8b21('0x12')]();var _0x77d96b=$('#previous_school_year')['val']();var _0x51d636=$(_0x8b21('0x18'))[_0x8b21('0x12')]();var _0x29041c=$(_0x8b21('0x0'))[_0x8b21('0x12')]();var _0x275824=_0x2e8ef8+'college/enrollment/saveCollegeRO/';$[_0x8b21('0xb')]({'type':_0x8b21('0x5'),'url':_0x275824,'data':{'semester':_0x2aa216,'course_id':_0x28d06c,'year_level':_0x289358,'school_year':_0x77d96b,'st_id':_0x51d636,'user_id':_0x29041c,'csrf_test_name':$[_0x8b21('0x47')](_0x8b21('0x2c'))},'dataType':'json','beforeSend':function(){$(_0x8b21('0x46'))[_0x8b21('0x38')]();$('#schedBody')[_0x8b21('0x2b')](_0x8b21('0x25'));},'success':function(_0x3228ea){loadEnrollmentData(_0x3228ea[_0x8b21('0x1a')],_0x51d636,_0x29041c);console[_0x8b21('0x6')](_0x3228ea);}});return![];};loadEnrollmentData=function(_0x5ee1b9=0x0,_0x1cfdbf,_0x398795){var _0xdf6e2a=[];$(_0x8b21('0x16'))[_0x8b21('0x2')](function(){var _0x28c391={'cl_sub_id':$(this)[_0x8b21('0x3b')](_0x8b21('0x40')),'cl_section':$(this)[_0x8b21('0x3b')](_0x8b21('0x30')),'cl_user_id':$(_0x8b21('0x0'))[_0x8b21('0x12')](),'cl_adm_id':_0x5ee1b9};_0xdf6e2a['push'](_0x28c391);});var _0x5b8b8e=JSON[_0x8b21('0x2f')](_0xdf6e2a);var _0x225fbf=$(_0x8b21('0x28'))[_0x8b21('0x12')]();var _0x521f1b=$('#inputSem')[_0x8b21('0x12')]();var _0x5af0a2=$(_0x8b21('0x23'))[_0x8b21('0x12')]();var _0x2e772a=_0x5af0a2+_0x8b21('0x21');$[_0x8b21('0xb')]({'type':_0x8b21('0x5'),'url':_0x2e772a,'data':{'enData':_0x5b8b8e,'semester':_0x521f1b,'school_year':_0x225fbf,'st_id':_0x1cfdbf,'user_id':_0x398795,'csrf_test_name':$[_0x8b21('0x47')](_0x8b21('0x2c'))},'beforeSend':function(){$(_0x8b21('0x2a'))[_0x8b21('0x38')]();$(_0x8b21('0x3c'))[_0x8b21('0x3d')]();$(_0x8b21('0x19'))[_0x8b21('0x2b')]('Please\x20Wait\x20while\x20system\x20is\x20submitting\x20your\x20request...');},'success':function(_0x5e4bf0){$(_0x8b21('0x19'))[_0x8b21('0x2b')](_0x8b21('0x13'));$(_0x8b21('0x26'))[_0x8b21('0x3')]();}});return![];};getSchedule=function(_0x229235){if(_0x229235!=0x0){var _0xa6d76f=$(_0x8b21('0x18'))[_0x8b21('0x12')]();var _0x55435e=$(_0x8b21('0x32'))[_0x8b21('0x12')]();var _0x13054a=$(_0x8b21('0xe'))[_0x8b21('0x12')]();var _0x1fb28b=$(_0x8b21('0x28'))[_0x8b21('0x12')]();var _0x8641d9=$(_0x8b21('0x23'))[_0x8b21('0x12')]();var _0x3a8210=_0x8641d9+'college/enrollment/getSubjectLoad/'+_0xa6d76f+'/'+_0x55435e+'/'+_0x13054a+'/'+_0x229235+'/'+_0x1fb28b;$['ajax']({'type':_0x8b21('0x5'),'url':_0x3a8210,'data':{'csrf_test_name':$[_0x8b21('0x47')](_0x8b21('0x2c'))},'beforeSend':function(){$(_0x8b21('0x3e'))[_0x8b21('0x2b')](_0x8b21('0x25'));},'success':function(_0x3c77d3){$(_0x8b21('0x3e'))[_0x8b21('0x2b')](_0x3c77d3);if(_0x4739c0!=0x0){$(_0x8b21('0x2a'))[_0x8b21('0x3d')]();}}});return![];}};searchSubjectOffered=function(_0x32ff63){var _0x432d99=$('#inputSem')[_0x8b21('0x12')]();var _0x360591=$(_0x8b21('0x28'))[_0x8b21('0x12')]();var _0x52cc09=$('#base')[_0x8b21('0x12')]();var _0x3dccb2=_0x52cc09+_0x8b21('0x42')+_0x32ff63+'/'+_0x432d99+'/'+_0x360591;$[_0x8b21('0xb')]({'type':_0x8b21('0x5'),'url':_0x3dccb2,'data':{'csrf_test_name':$[_0x8b21('0x47')](_0x8b21('0x2c'))},'beforeSend':function(){$(_0x8b21('0x3a'))[_0x8b21('0x2b')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x43a7a9){$(_0x8b21('0x3a'))[_0x8b21('0x2b')](_0x43a7a9);}});return![];};});function hasTimeConflict(_0x2b4c42,_0x3dd39e,_0xbc0175,_0x39736e){var _0xd19fd8=timestamp(_0x2b4c42);var _0x2b591d=timestamp(_0x3dd39e);var _0x1297eb=timestamp(_0xbc0175);var _0x36ae58=timestamp(_0x39736e);if(_0xd19fd8>=_0x1297eb&&_0xd19fd8<_0x36ae58){return!![];}else if(_0x2b591d<_0x36ae58&&_0x2b591d>_0x36ae58){return!![];}else if(_0xd19fd8==_0x1297eb){return!![];}else{return![];}}function getFinDetails(){var _0x52cb70=$(_0x8b21('0x23'))[_0x8b21('0x12')]();var _0x4950b4=_0x52cb70+_0x8b21('0x39');document[_0x8b21('0x1b')]=_0x4950b4;}function modalControl(_0x470523,_0x40a596){$('#'+_0x470523)[_0x8b21('0x22')](_0x8b21('0x3d'));$('#'+_0x40a596)[_0x8b21('0x22')](_0x8b21('0x38'));}function loadSchedule(_0x13ad34){var _0x265d28=$('#inputSem')[_0x8b21('0x12')]();var _0x467a23=$('#previous_school_year')[_0x8b21('0x12')]();var _0x18fec9=$(_0x8b21('0x23'))[_0x8b21('0x12')]();var _0xd55067=_0x18fec9+_0x8b21('0x41')+_0x13ad34+'/'+_0x265d28+'/'+_0x467a23;$[_0x8b21('0xb')]({'type':_0x8b21('0x5'),'url':_0xd55067,'data':{'csrf_test_name':$[_0x8b21('0x47')](_0x8b21('0x2c'))},'beforeSend':function(){$(_0x8b21('0x37'))[_0x8b21('0x2b')]('System\x20is\x20processing...Thank\x20you\x20for\x20waiting\x20patiently');},'success':function(_0x33344a){$('#scheduleModal')[_0x8b21('0x22')](_0x8b21('0x3d'));$(_0x8b21('0x37'))[_0x8b21('0x2b')](_0x33344a);}});return![];}
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

        fetchSearchSubject = function (sub_code, tchr, sec_id, units, timeDay, sub_id, timeFrom, timeTo, day)
        {
            var exist = 0;
            $('#tableSched tr.trSched').each(function () {
                //alert($(this).attr('id'))
                if ($(this).attr('sub_code') === sub_code)
                {
                    exist++;
                    alert('Sorry this subject already exist');
                }
            });


            if (exist == 0) {
                $('#subjectLoadBody').append(
                        '<tr id="tr_' + sub_id + '" class="trSched" sub_code="' + sub_code + '" >' +
                        '<td>' + sub_code + '</td>' +
                        '<td class="hasValue" id="units_' + sub_id + '">' + units + '</td>' +
                        '<td class="hasValue" id="daytime_' + sub_id + '">' + timeDay + '</td>' +
                        '<td class="hasValue" id="instructor_' + sub_id + '">' + tchr + '</td>' +
                        '<td class="text-center"> \n\
                                    <button onclick="loadSchedule(\'' + sub_code + '\')" title="search for schedule" class="btn btn-success btn-xs"><i class="fa fa-search"></i></button>\n\
                                    <button onclick="clearSchedule(\'' + sub_id + '\')" title="clear schedule" class="btn btn-warning btn-xs"><i class="fa fa-minus"></i></button>\n\
                                    <button onclick="removeSubject(\'' + sub_id + '\')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>\n\
                                </td>' +
                        +'</tr>'
                        );
                fetchSchedule(sub_code, tchr, sec_id, units, timeDay, sub_id, timeFrom, timeTo, day);
            }

            $('#searchSubject').modal('hide');

        };


        fetchSchedule = function (sub_code, tchr, sec_id, units, timeDay, sub_id, timeFrom, timeTo, day)
        {
            var condition = 0;
            $('#tableSched tr.trSched').each(function () {
                var dbDay = $(this).attr('day');
                var dbTimeFrom = $(this).attr('time_from');
                var dbTimeTo = $(this).attr('time_to');

                if ($(this).attr('id') !== 'tr_' + sub_id) {
                    //alert($(this).attr('id'))
                    if (dbDay === day) {
                        if (hasTimeConflict(timeFrom, timeTo, dbTimeFrom, dbTimeTo)) {
                            //alert('Sorry, You cannot add this schedule due to conflict');
                            $(this).addClass('alert alert-danger');
                            condition++;
                        }
                    }

                }
            });
            plotSched(sub_code, tchr, sec_id, units, timeDay, sub_id, timeFrom, timeTo, day, condition);


        };

        plotSched = function (sub_code, tchr, sec_id, units, timeDay, sub_id, timeFrom, timeTo, day, condition)
        {
            if (condition == 0) {
                $('#units_' + sub_id).html(units);
                $('#daytime_' + sub_id).html(timeDay);
                $('#instructor_' + sub_id).html(tchr);

                totalUnits += parseInt(units);
                $('#totalUnits').html(totalUnits)

                $('#tr_' + sub_id).attr('sec_id', sec_id);
                $('#tr_' + sub_id).attr('time_from', timeFrom);
                $('#tr_' + sub_id).attr('time_to', timeTo);
                $('#tr_' + sub_id).attr('day', day);
                $('#tr_' + sub_id).attr('sub_code', sub_code);
                $('#tr_' + sub_id).attr('sub_id', sub_id);

                if (totalUnits != 0) {
                    $('#confirmGrp').show();
                }
            }
        };


        removeSubject = function (sub_id)
        {
            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);
            $('#tr_' + sub_id).remove();
        };


        clearSchedule = function (sub_id)
        {

            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);

            $('#tr_' + sub_id + ' td.hasValue').each(function () {
                $(this).html('');
            });

            $('#tr_' + sub_id).attr('sec_id', '');
            $('#tr_' + sub_id).attr('time_from', '');
            $('#tr_' + sub_id).attr('time_to', '');
            $('#tr_' + sub_id).attr('day', '');
        };


        submitEnrollmentData = function ()
        {
            var base = $('#base').val();

            var currentSem = $('#inputSem').val();
            var course_id = $('#course_id').val();
            var year_level = $('#year_level').val();
            var school_year = $('#previous_school_year').val();
            var st_id = $('#studentID').val();
            var user_id = $('#user_id').val();

            var url = base + 'college/enrollment/saveCollegeRO/'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    semester: currentSem,
                    course_id: course_id,
                    year_level: year_level,
                    school_year: school_year,
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
                    if(data.status==true){
                        loadEnrollmentData(data.admission_id, st_id, user_id);
                        console.log(data);
                    }else{
                        alert(data.msg)
                    }
                }
            });

            return false;

        };

        loadEnrollmentData = function (adm_id=0, st_id, user_id)
        {
            var enrollmentDetails = [];
            $('#tableSched tr.trSched').each(function () {
                var id = {
                    'cl_sub_id'         : $(this).attr('sub_id'),
                    'cl_section'        : $(this).attr('sec_id'),
                    'cl_user_id'        : $('#user_id').val(),
                    'cl_adm_id'         : adm_id
                };
                enrollmentDetails.push(id);
            });
            
            var enrollmentData = JSON.stringify(enrollmentDetails);
            var school_year = $('#previous_school_year').val();
            var semester    = $('#inputSem').val();
            var base = $('#base').val();
            var url = base+'core/saveLoadedSubjects';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    enData          : enrollmentData,
                    semester        : semester,
                    school_year     : school_year,
                    st_id           : st_id,
                    user_id         : user_id,
                    csrf_test_name  : $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function () {
                    $('#confirmGrp').hide();
                    $('#confirmMsgWrapper').show();
                    $('#confirmMsg').html('Please Wait while system is submitting your request...');
                    
                },
                success: function (data)
                {
                    $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your study load is approved. Thank you for using this online system.');
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
                
                var url = base+'college/enrollment/getSubjectLoad/' + st_id + '/' + course_id + '/' + year_level + '/' + sem + '/' + school_year; // the script where you handle the form input.
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
            var semester = $('#inputSem').val();
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/searchSubject/' + value + '/' + semester + '/' + school_year; // the script where you handle the form input.
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
        var url = base+ 'student/accounts'; // the script where you handle the form input.
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
        var url = base+ 'college/enrollment/loadSchedule/' + s_id + '/' + semester + '/'+school_year; // the script where you handle the form input.
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
