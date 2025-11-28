<?php
$hrdb = Modules::load('hr/hrdbprocess/');
$leaveSpent = Modules::run('hr/payroll/getTotalLeaveSpent',$basicInfo->employee_id);
//print_r($basicInfo);
?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:5px;" class="page-header text-center">Teacher's Information</h3>
    </div>

    <!-- /.col-lg-12 -->
</div>
<div class="well col-lg-12">
    <input type="hidden" id="empUserID" value="<?php echo $basicInfo->uid ?>" />
    <div class="col-lg-2">
                 <div onclick="imgSignUpload(this.id)" id="photo">
            <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
            </div>
    </div>
    <div class="col-lg-6">
        <h2 style="color:black; margin:3px 0;">
            <span id="name">
            <?php echo $basicInfo->firstname.' '.$basicInfo->lastname?></span> 
            <small>
                <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer"
                   rel="clickover" 
                   data-content=" 
                         <?php 
                            $data['st_id'] = $basicInfo->uid;
                            $data['firstname'] = $basicInfo->firstname;
                            $data['middlename'] = $basicInfo->middlename;
                            $data['lastname'] = $basicInfo->lastname;
                            $this->load->view('basicInfo', $data) 

                         ?>
                         " 
                   ></i>
            </small>
        </h2>
        <h3 style="color:black; margin:3px 0;">
            <span  style="color:#BB0000;" id="grade">
            <?php echo $basicInfo->position ?> </span> 
                <?php if($this->session->userdata('is_admin')): ?>
                    <small>
                        <i style="font-size:15px;" class="fa fa-pencil-square-o clickover pointer  "
                           rel="clickover" 
                           data-content=" 
                                    <?php 
                                    $level['position'] = Modules::run('hr/getDepartment');
                                    $level['user_id'] = $basicInfo->user_id;
                                    $this->load->view('positions', $level) 
                                     ?>
                                     "   
                               ></i>
                    </small>
                    
                <?php endif; ?>
        </h3>
        <h3 style="color:black; margin:3px 0;">
            <small>
                <span>
                    <?php echo $basicInfo->employee_id ?>
                    <input type="hidden" id="em_id" value="<?php echo $basicInfo->employee_id ?>" />
                </span>
            </small>
         </h3>
    </div>
    <div class="col-lg-4 no-padding no-margin pull-right panel panel-primary">
        <div class="panel-heading" style="height:160px;">
            <table style="font-size: 20px;">
                <tr style="border:none;">
                    <th style="padding:0 5px 2px 0; float: right;">Hours Required : </th>
                    <th style="padding:0 5px 2px 0;"><span id="totalHoursRequired"></span></th>
                </tr>
                <tr>
                    <th style="padding:0 5px 2px 0; float: right;">Hours Rendered : </th>
                    <th style="padding:0 5px 2px 0;"><span id="hoursRendered"></span> </th>
                </tr>
                <tr>
                    <th style="padding:0 5px 2px 0; float: right;">Minutes Tardy : </th>
                    <th style="padding:0 5px 2px 0;"><span id="totalMinutesTardy"></span> </th>
                </tr>
                <tr>
                    <th style="padding:5px; float: right;">Leave Credits : </th>
                    <th style="padding:5px;"><span id="LCredits"><?php echo ($basicInfo->leave_credits*8)-$leaveSpent->totalLeaveSpent ?></span> hrs</th>
                </tr>
            </table>
        </div>
    </div>    
    <div id="uploadSignature"  style="width:20%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-primary" style='width:100%;'>
            <div class="panel-heading clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6>Upload Signature</h6>

            </div>
            <div class="panel-body">

                <form action="<?php echo base_url().'main/do_upload' ?>" enctype="multipart/form-data" method="post" id="submitSign"> 
                        <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
                        <br /><br />

                        <input type="hidden" name="picture_option" value="sign" />
                        <input type="hidden" name="id" value="<?php echo $basicInfo->uid?>" />
                        <input type="hidden" name="location" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" />

                        <input type="submit" value="upload" id="submitSign" class="btn-info"/>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="profile_tab">
        <li onclick="$('#acadADD').hide()" class="active"><a href="#PersonalInfo">Personal Information</a></li>
        <li><a onclick="$('#acadADD').show()" href="#academicInformation">Academic Information</a></li>
        <li><a onclick="$('#acadADD').hide()" href="#statutory">Salary / Benefits</a></li>
        <li><a onclick="$('#acadADD').hide()" href="#dtr">Daily Time Record</a></li>
        <li><a onclick="$('#acadADD').hide()" href="#od_info">Loans / Deductions</a></li>
        <li class="pull-right pointer"><a onclick="imgSignUpload(this.id)" id="sign" >Upload Signature</a></li>
        <button data-toggle="modal" data-target="#addEdHis" id="acadADD" style="margin-top:10px; display: none;" class="btn btn-xs btn-success pull-right"><i class="fa fa-plus-circle"></i> ADD</button>
      </ul>
    <div class="tab-content col-lg-12">
        <div style="padding-top: 15px;" class="tab-pane active" id="PersonalInfo">
                <div class="col-lg-6 pull-right">
                    <img class="img-square img-responsive pull-right" style="width:150px; border:5px solid #fff" src="<?php if($basicInfo->uid!=""):echo base_url().'uploads/sign/'.$basicInfo->uid.'.png';else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                </div>
            <div class="col-lg-6">
                <dl class="dl-horizontal"style="cursor: pointer; color:black;">
                    <dt>
                    Address:
                    </dt>
                    <dd >
                        <span id="address_span"><?php echo $basicInfo->street.', '.$basicInfo->barangay.' '.$basicInfo->mun_city.', '. $basicInfo->province.', '. $basicInfo->zip_code; ?></span>
                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
                           rel="clickover"  id="addClick"
                           data-content="<?php
                        $data['cities'] =Modules::run('main/getCities');   
                        $data['address_id'] = $basicInfo->address_id;
                        $data['st_id'] = $basicInfo->employee_id;
                        $data['street'] = $basicInfo->street;
                        $data['barangay'] = $basicInfo->barangay;
                        $data['city'] = $basicInfo->city_id;
                        $data['province'] = $basicInfo->province;
                        $data['pid'] = $basicInfo->province_id;
                        $data['zip_code'] = $basicInfo->zip_code;
                        $data['user_id'] = $basicInfo->user_id;
                        $this->load->view('addressInfo', $data) 

                         ?>
                         ">
                        </i>
                        
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                    Telephone No:
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_telephone" >
                            <?php if($basicInfo->cd_phone!="" && $basicInfo->cd_phone!='0'):echo $basicInfo->cd_phone; else: echo "[empty]"; endif; ?>
                        </span>
                        
                        <input style="display: none; width:300px" type="text" id="telephone" value="<?php echo $basicInfo->cd_phone; ?>" 
                           onkeypress="if (event.keyCode==13){}"
                           title="press enter to save your edit"
                           />
                            <i id="editTelephoneBtn" onclick="$('#a_telephone').hide(), $('#telephone').show(),$('#telephone').focus(),$(this).hide(), $('#saveTelephoneBtn').show(), $('#closeTelephoneBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                            <i id="saveTelephoneBtn" onclick="saveMobile('<?php echo $basicInfo->uid ?>',$('#telephone').val(), 'phone'), $('#a_telephone').show(), $('#telephone').hide(), $('#editTelephoneBtn').show(), $('#saveTelephoneBtn').hide(), $('#closeTelephoneBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                            <i id="closeTelephoneBtn" onclick="$('#a_telephone').show(), $('#telephone').hide(), $('#editTelephoneBtn').show(), $('#saveTelephoneBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                    Mobile No:
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mobile" >
                            <?php if($basicInfo->cd_mobile!=""):echo $basicInfo->cd_mobile; else: echo "[empty]"; endif; ?>
                        </span>
                        <input style="display: none; width:300px" type="text" id="mobile" value="<?php echo $basicInfo->cd_mobile; ?>" 
                           onkeypress="if (event.keyCode==13){saveMobile('<?php echo $basicInfo->uid ?>',$('#mobile').val(), 'mobile')}"
                           title="press enter to save your edit"
                           />
                        <i id="editContactBtn" onclick="$('#a_mobile').hide(), $('#mobile').show(),$('#mobile').focus(),$(this).hide(), $('#saveContactBtn').show(), $('#closeContactBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                        <i id="saveContactBtn" onclick="saveMobile('<?php echo $basicInfo->uid ?>',$('#mobile').val(), 'mobile'), $('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $('#closeContactBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeContactBtn" onclick="$('#a_mobile').show(), $('#mobile').hide(), $('#editContactBtn').show(), $('#saveContactBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                    Email:
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_email" >
                            <?php if($basicInfo->cd_email!=""):echo $basicInfo->cd_email; else: echo "[empty]"; endif; ?>
                            
                        </span>
                        <input style="display: none; width:300px" type="text" id="email" value="<?php echo $basicInfo->cd_email; ?>" 
                           
                           />
                        <i id="editEmailBtn" onclick="$('#a_email').hide(), $('#email').show(),$('#email').focus(),$(this).hide(), $('#saveEmailBtn').show(), $('#closeEmailBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                        <i id="saveEmailBtn" onclick="saveMobile('<?php echo $basicInfo->uid ?>',$('#email').val(), 'email'), $('#a_email').show(), $('#email').hide(), $('#editEmailBtn').show(), $('#saveEmailBtn').hide(), $('#closeEmailBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeEmailBtn" onclick="$('#a_email').show(), $('#email').hide(), $('#editEmailBtn').show(), $('#saveEmailBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
            
                <dl class="dl-horizontal">
                    <dt>
                    Gender: 
                    </dt>
                    <dd style="color:black;">
                        <span id="st_sex">
                           <?php echo $basicInfo->sex; ?> 
                        </span>
                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
                           rel="clickover"  
                         <?php if($this->session->userdata('is_admin')): ?>
                               data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px;'>
                                            <label class='control-label'>Gender</label>
                                            <div class='controls' id='AddedSection'>
                                              <select name='inputGender' id='inputGender' class='pull-left' required>
                                                  <option>Select Gender</option>  
                                                  <option value='Male'>Male</option>  
                                                  <option value='Female'>Female</option>  
                                              </select>
                                            </div>
                                        </div>
                                        <div class'col-lg-12'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='saveGender()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                        </div> 
                                     "
                             <?php endif; ?> ></i> 
                    </dd>
                </dl>
            
                <dl class="dl-horizontal">
                    <dt>
                        Birthdate: 
                    </dt>
                    <dd>
                        <span onclick="$('#bdate').datepicker()" title="double click to edit" id="a_bdate" ondblclick="$('#a_bdate').hide(), $('#bdate').show(),$('#bdate').focus()">
                            <?php echo $basicInfo->temp_bdate; ?>
                        </span> 
                        <input style="display: none;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="bdate" value="<?php echo $basicInfo->temp_bdate; ?>" placeholder="Date of Birth" 
                            onkeypress="if (event.keyCode==13){editBdate(this.value,'<?php echo $basicInfo->uid ?>')}"   

                               required>
                    <i id="editBdateBtn" onclick="$('#bdate').datepicker(), $('#a_bdate').hide(), $('#bdate').show(),$('#bdate').focus(), $('#closeBdateBtn').show(),$('#saveBdateBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                    <i id="saveBdateBtn" onclick="editBdate($('#bdate').val(),'<?php echo $basicInfo->uid ?>'), $('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $('#closeBdateBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBdateBtn" onclick="$('#a_bdate').show(), $('#bdate').hide(), $('#editBdateBtn').show(), $('#saveBdateBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>                    </dd>
                </dl>
            
                <dl class="dl-horizontal">
                    <dt>
                        Blood Type:
                    </dt>
                    <dd>
                        <span  id="a_blood_type"  >
                            <?php echo $basicInfo->blood_type ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="blood_type" value="<?php echo $basicInfo->blood_type ?>" 
                           onkeypress="if (event.keyCode==13){}"
                           title="press enter to save your edit"
                           />
                    <i id="editBtypeBtn" onclick="$('#a_blood_type').hide(), $('#blood_type').show(),$('#blood_type').focus(), $('#closeBtypeBtn').show(),$('#saveBtypeBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                    <i id="saveBtypeBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $basicInfo->uid ?>,'blood_type',$('#blood_type').val(),'blood_type'),$('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeBtypeBtn" onclick="$('#a_blood_type').show(), $('#blood_type').hide(), $('#editBtypeBtn').show(), $('#saveBtypeBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Height:
                    </dt>
                    <dd>
                        <span  id="a_height"  >
                            <?php echo $basicInfo->height ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="height" value="<?php echo $basicInfo->height ?>" 
                           onkeypress="if (event.keyCode==13){}"
                           title="press enter to save your edit"
                           />
                    <i id="editHeightBtn" onclick="$('#a_height').hide(), $('#height').show(),$('#blood_type').focus(), $('#closeHeightBtn').show(),$('#saveHeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                    <i id="saveHeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $basicInfo->uid ?>,'height',$('#height').val(),'height'),$('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $('#closeHeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeHeightBtn" onclick="$('#a_height').show(), $('#height').hide(), $('#editHeightBtn').show(), $('#saveHeightBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Weight:
                    </dt>
                    <dd>
                        <span  id="a_weight"  >
                            <?php echo $basicInfo->weight ?>
                        </span> 
                    <input style="display: none; width:250px" type="text" id="weight" value="<?php echo $basicInfo->weight ?>" 
                           onkeypress=""
                           />
                    <i id="editWeightBtn" onclick="$('#a_weight').hide(), $('#weight').show(),$('#blood_type').focus(), $('#closeWeightBtn').show(),$('#saveWeightBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                    <i id="saveWeightBtn" onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile_medical')?>',<?php echo $basicInfo->uid ?>,'weight',$('#weight').val(),'weight'),$('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $('#closeWeightBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                    <i id="closeWeightBtn" onclick="$('#a_weight').show(), $('#weight').hide(), $('#editWeightBtn').show(), $('#saveWeightBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-12">
                <hr style="margin:3px 0;" />
                    <h5 >In Case of Emergency:</h5>
                <hr style="margin:3px 0 15px;" />
            </div>
            <div class="col-lg-12">
                <dl class="dl-horizontal">
                    <dt>
                        Name: 
                    </dt>
                    <dd>
                        <span id="a_incase_name">
                            <?php echo $basicInfo->incase_name; ?>

                        </span> 
                        <input 
                               style="display: none;" id="incase_name" 
                               value="<?php echo $basicInfo->incase_name; ?>" 
                               placeholder="Name" 
                               onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_name',this.value,this.id)}" >

                        <i id="editInCaseNameBtn" onclick="$('#a_incase_name').hide(), $('#incase_name').show(),$('#incase_name').focus(), $('#closeInCaseNameBtn').show(),$('#saveInCaseNameBtn').show(), $(this).hide()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                        <i id="saveInCaseNameBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_name',$('#incase_name').val(),'incase_name'),$('#a_incase_name').show(), $('#incase_name').hide(), $('#editInCaseNameBtn').show(), $('#saveInCaseNameBtn').hide(), $('#closeInCaseNameBtn').hide()" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeInCaseNameBtn" onclick="$('#a_incase_name').show(), $('#incase_name').hide(), $('#editInCaseNameBtn').show(), $('#saveInCaseNameBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact: 
                    </dt>
                    <dd>
                        <span onclick="$('#bdate').datepicker()" title="double click to edit" id="a_incase_contact">
                            <?php echo $basicInfo->incase_contact; ?>
                        </span> 
                        <input id="incase_contact" style="display: none;" name="incase_contact" type="text" value="<?php echo $basicInfo->incase_contact; ?>" placeholder="Contact Number" 
                            onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_contact',this.value,this.id)}"  >


                        <i id="editInCaseConBtn" onclick="$('#a_incase_contact').hide(), $('#incase_contact').show(),$('#incase_contact').focus(),$(this).hide(), $('#saveInCaseConBtn').show(), $('#closeInCaseConBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                        <i id="saveInCaseConBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_contact',$('#incase_contact').val(),'incase_contact'), $('#a_incase_contact').show(), $('#incase_contact').hide(), $('#editInCaseConBtn').show(), $('#saveInCaseConBtn').hide(), $('#closeInCaseConBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeInCaseConBtn" onclick="$('#a_incase_contact').show(), $('#incase_contact').hide(), $('#editInCaseConBtn').show(), $('#saveInCaseConBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Relation: 
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_incase_relation">
                            <?php echo $basicInfo->incase_relation; ?>
                        </span> 
                        <input  style="display: none;" name="incase_name" type="text" id="incase_relation" value="<?php echo $basicInfo->incase_relation; ?>" placeholder="Relation" 
                          onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_relation',this.value,this.id)}"  >


                        <i id="editInCaseRelBtn" onclick="$('#a_incase_relation').hide(), $('#incase_relation').show(),$('#incase_relation').focus(),$(this).hide(), $('#saveInCaseRelBtn').show(), $('#closeInCaseRelBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
                        <i id="saveInCaseRelBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','incase_relation',$('#incase_relation').val(),'incase_relation'), $('#a_incase_relation').show(), $('#incase_relation').hide(), $('#editInCaseRelBtn').show(), $('#saveInCaseRelBtn').hide(), $('#closeInCaseRelBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
                        <i id="closeInCaseRelBtn" onclick="$('#a_incase_relation').show(), $('#incase_relation').hide(), $('#editInCaseRelBtn').show(), $('#saveInCaseRelBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

                    </dd>
                </dl>
            </div>
        </div>
        <div style="padding-top: 15px;" class="tab-pane" id="academicInformation">
            <?php
                $data['basicInfo'] = $basicInfo;
                $data['edHis'] = $edHis;
                $this->load->view('academicInformation', $data ); 
            ?>
        </div>
        <div style="padding-top: 15px;" class="tab-pane" id="statutory">
            <?php
                $data['salaryType'] = Modules::run('hr/getSalaryType');
                $data['basicInfo'] = $basicInfo;
                $this->load->view('statutoryInformation', $data ); 
            ?>
        </div>
        <div style="padding-top: 15px;" class="tab-pane" id="od_info">
            <?php
                $data['basicInfo'] = $basicInfo;
                $data['deductions'] = Modules::run('hr/payroll/getOD_list');
                $data['paymentTerms'] = Modules::run('hr/payroll/getPaymentTerms');
                $data['myLoans'] = Modules::run('hr/payroll/loanAmortization', $basicInfo->employee_id, 0);
                //$this->load->view('loans_deductions', $data ); 
            ?>
        </div>
        <div style="padding-top: 15px;" class="tab-pane" id="dtr">
            <?php echo Modules::run('hr/dtr', $this->uri->segment(3)); ?>
        </div>
        
    </div>
</div>
<?php $this->load->view('registrar/imgCrop') ?>
<?php
    $minmaj = Modules::run('hr/minMajSub');
    $data['basicInfo'] = $basicInfo;
    $data['edHis'] = $edHis;
    $this->load->view('addEdHis_modal', $data ); 
    
?>


<script type="text/javascript">
    $(document).ready(function() {
        $(".clickover").clickover({
                placement: 'right',
                html: true
              });
        $('#submitSign').click(function(){
            $('#uploadSign').submit();  
        }) 
       
        $("#major").select2({tags:[
                <?php
                foreach ($minmaj as $mm):
                    echo '\''.$mm->maj_min.'\''.',';
                endforeach;
                ?>
            ],
         closeOnSelect: true,
         maximumSelectionSize: 1
        });
        $("#minor").select2({tags:[
                <?php
                foreach ($minmaj as $mm):
                    echo '\''.$mm->maj_min.'\''.',';
                endforeach;
                ?>
            ],
         closeOnSelect: true,
         maximumSelectionSize: 1
        });
    });
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
      
      
    function saveMobile(user_id, mobile_no, column)
    {
        var url = "<?php echo base_url().'hr/saveContacts/'?>";
          $.ajax({
               type: "POST",
               url: url,
               data: 'user_id='+user_id+'&mobile_no='+mobile_no+'&column='+'cd_'+column+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#a_'+column).html(mobile_no)
                   alert('Successfully Updated '+data);
               }
          })
    }  
      
    function deleteEducBac(id)
    {
        var rsure=confirm("Are you Sure You Want to delete this information from the list? Warning: You can't undo this action");
        if (rsure==true){
            var url = "<?php echo base_url().'hr/deleteEducBak/'?>"+id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: ''+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType: 'json',
                   success: function(data)
                   {
                      alert(data);
                      location.reload()
                   }
                 });

            return false;
        }else{
            location.reload();
        }
    }
    
     
    function saveMinMaj(value, id, majmin)
    {
        var url = "<?php echo base_url().'hr/saveMinMaj/'?>";
          $.ajax({
               type: "POST",
               url: url,
               data: 'id='+id+'&value='+value+'&maj_min='+majmin+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   alert(data)
                   $('#major_wrapper').addClass('hide')
                   $('#a_major').show();
               }
          
            });
            return false;
    }
    
    function getProvince(value)
      {
          var url = "<?php echo base_url().'main/getProvince/'?>"+value;
          $.ajax({
                       type: "GET",
                       url: url,
                       dataType:'json',
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                       success: function(data)
                       {
                           $('#inputProvince').val(data.name)
                           $('#inputPID').val(data.id)
                       }
          })
      }
    
    function editId_number(idNum, id)
    {
        var editedIdNum = $('#input_'+id).val();
        var url = "<?php echo base_url().'hr/editIdNumber/'?>"
        $.ajax({
                   type: "POST",
                   url: url,
                   data: "origIdNumber="+idNum+"&editedIdNumber="+editedIdNum+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       //$('#Pos').show();
                        $('#a_'+id).html(data)
                        $('#a_'+id).show()
                        $('#input_'+id).hide()
                   }
                 });

       return false; 
    }
    
    function getPosition(){
          var department_id = document.getElementById("editDepartment").value;
             var url = "<?php echo base_url().'hr/getPosition/'?>"+department_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "dept_id="+department_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       //$('#Pos').show();
                        document.getElementById("inputPosition").innerHTML=data
                   }
                 });

            return false; 
      }
     
    function saveDepartment()
    {
        var pk_id = '<?php echo $basicInfo->uid; ?>';
        var value = $('#inputPosition').val();
        var dept = $('#editDepartment').val()
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+pk_id+'&csrf_test_name='+$.cookie('csrf_cookie_name')+'&column=position_id&value='+value+'&tbl=<?php echo base64_encode('esk_profile_employee') ?>&pk=<?php echo base64_encode('user_id') ?>', // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   updateAccountProfile(dept)

               }
             });

        return false; // avoid to execute the actual submit of the form.
    }
    function updateAccountProfile(dept=NULL)
    {
        var pk_id = '<?php echo $basicInfo->uid; ?>';
        var value = dept
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+pk_id+'&column=account_type&value='+value+'&tbl=<?php echo base64_encode('esk_profile') ?>&pk=<?php echo base64_encode('user_id') ?>'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   updateAccounts(dept);

               }
             });

        return false; // avoid to execute the actual submit of the form.
    }
     
     
    function updateAccounts(dept=NULL)
    {
        var pk_id = '<?php echo $basicInfo->employee_id; ?>';
        var value = dept
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+pk_id+'&column=utype&value='+value+'&tbl=<?php echo base64_encode('esk_user_accounts') ?>&pk=<?php echo base64_encode('u_id') ?>'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                  // location.reload();

               }
             });

        return false; // avoid to execute the actual submit of the form.
    }
     
     
    function updateProfile(pk,table, pk_id, column, value, id)
    {
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+pk_id+'&column='+column+'&value='+value+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#a_'+id).show()
                   $('#'+id).hide()
                   $('#a_'+id).html(data.msg)

               }
             });

        return false; // avoid to execute the actual submit of the form.
    }
    
    function editBasicInfo()
    {
        var url = "<?php echo base_url().'hr/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'lastname='+$('#lastname').val()+'&firstname='+$('#firstname').val()+'&middlename='+$('#middlename').val()+'&rowid='+$('#rowid').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   
                   $('#name').html(data);
               }
             });

        return false;
    }
    
    function editAddressInfo()
    {
        var url = "<?php echo base_url().'registrar/editAddressInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'street='+$('#street').val()+'&barangay='+$('#barangay').val()+'&city='+$('#city').val()+'&province=' +$('#inputPID').val()+'&address_id='+$('#address_id').val()+'&zip_code='+$('#zip_code').val()+'&user_id='+$('#empUserID').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   
                   $location.reload();
               }
             });

        return false;
    }
    
    function editEmployeeInfo()
    {
        var st_id = $('#st_id').val();
        var url = "<?php echo base_url().'hr/editEmployeeInfo/' ?>"+st_id; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'sss='+$('#editSSS').val()+'&philHealth='+$('#editPhilHealth').val()+'&pag_ibig='+$('#editPag_ibig').val()+'&tin='+$('#editTIN').val(), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   location.reload();
                   //$('#address_span').html(data);
               }
             });

        return false;
    }
    
    function editAcademicInfo()
    {
        var course_id = $('#courseId').val();
        var school_id = $('#collegeId').val();
        var t_id = $('#t_id').val();
        var url = "<?php echo base_url().'hr/editAcademicInfo/' ?>"
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'course_id='+course_id+'&school_id='+school_id+'&t_id='+t_id, // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   location.reload();
                   //$('#address_span').html(data);
               }
             });

        return false;
        
    }
    
    function editBdate(cal_id, owner)
    {
        var url = "<?php echo base_url().'calendar/editBdate/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'bDate='+cal_id+'&owner='+owner+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#a_bdate').show()
                   $('#bdate').hide()
                   $('#a_bdate').html(cal_id)

               }
             });

        return false;
    }
    
    function savePtype()
    {
        var url = "<?php echo base_url().'hr/savePtype/' ?>"; // the script where you handle the form input.
        var payType = $('#payType').val()
        var id = $('#em_id').val()
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'em_id='+id+'&payroll_type='+payType+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   

               }
             });

        return false;
    }
    
    function saveSG()
    {
        var url = "<?php echo base_url().'hr/saveSG/' ?>"; // the script where you handle the form input.
        var salary = $('#salaryGrade').val()
        var id = $('#em_id').val()
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'em_id='+id+'&salary_grade='+salary+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#a_sg').html($('#'+salary+'_sg').html())
                   

               }
             });

        return false;
    }
    
    function searchCourse(value)
      {
          var url = "<?php echo base_url().'hr/searchCourse/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#courseSearch').hide();
              $('#course_id').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#courseSearch').show();
                       $('#courseSearch').html(data);
                   }
                 });

            return false;  
          }
            
      } 
      
      function searchSchool(value)
      {
          var url = "<?php echo base_url().'hr/searchCollege/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#collegeSearch').hide();
              $('#collegeId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#collegeSearch').show();
                       $('#collegeSearch').html(data);
                   }
                 });

            return false;  
          }
            
      }     
      
       function saveGender()
    {
        var url = "<?php echo base_url().'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $basicInfo->uid ?>'
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'id='+st_id+'&column=sex&value='+$('#inputGender').val()+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#st_sex').html(data.msg)

               }
             });
             return false;
    }
    /*
    $(document).ready(function(){
        $('#imgCrop').click(function(){
          $('#picture_option').val($(this).data('id'));
          $('#imgUpload').modal('show');
        })
      })
    */
    function imgSignUpload(id){
        $('#stdUID').val($('#empUserID').val());
        $('#picture_option').val(id);
        $('#imgUpload').modal('show');
    }

</script>
