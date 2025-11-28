<dl class="dl-horizontal">
    <dt>
    Salary:
    </dt>
    <dd>
        <span title="double click to edit" id="a_salary" >
            <?php 
            //print_r($basicInfo);
            if($basicInfo->salary!=""):echo $basicInfo->salary; else: echo "[empty]"; endif; ?>
        </span>
        <?php if($this->session->userdata('is_admin')): ?>
            <input style="display: none;" name="salary" type="text" id="salary" value="<?php echo $basicInfo->salary; ?>" placeholder="salary" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','salary',this.value,this.id)}"  >
            <i id="editsalaryBtn" onclick="$('#a_salary').hide(), $('#salary').show(),$('#salary').focus(),$(this).hide(), $('#savesalaryBtn').show(), $('#closesalaryBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="savesalaryBtn" onclick="$('#a_salary').show(), $('#salary').hide(), $('#editsalaryBtn').show(), $('#savesalaryBtn').hide(), $('#closesalaryBtn').hide(), updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','salary',$('#salary').val(),'salary')" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closesalaryBtn" onclick="$('#a_salary').show(), $('#salary').hide(), $('#editsalaryBtn').show(), $('#savesalaryBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
      
       <?php endif; ?> 
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    Salary Type:
    </dt>
    <dd>
        <span title="double click to edit" id="a_sg" >
            <?php if($basicInfo->pst_id!=""):echo $basicInfo->pst_type; else: echo "[empty]"; endif; ?>
        </span>
        <?php if($this->session->userdata('is_admin')): ?>
            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
               rel="clickover"  
                   data-content=" 
                            <div class='form-group' style='width:200px;'>
                                <label class='control-label'>Salary Type</label>
                                <div class='controls' id='AddedSection'>
                                  <select name='salaryGrade' id='salaryGrade' class='pull-left' required>
                                      <option>Select Salary Type</option> 
                                      <?php foreach ($salaryType as $st): ?>
                                            <option id='<?php echo $st->pst_id ?>_sg'value='<?php echo $st->pst_id ?>'><?php echo $st->pst_type ?></option> 
                                      <?php endforeach; ?>
                                  </select>
                                </div>
                            </div>
                            <div class='col-lg-12'>
                                 <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                 <a href='#' data-dismiss='clickover' onclick='saveSG()' style='margin-right:10px;' class='btn btn-xs btn-success  pull-right'>Save</a>
                            </div> 
                         "
                > </i>        
       <?php endif; ?> 
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
        Leave Credits <small class="mute">(in days)</small>:
    </dt>
    <dd>
        <span title="double click to edit" id="a_credits" >
            <?php 
            //print_r($basicInfo);
            if($basicInfo->leave_credits!=0.0):echo $basicInfo->leave_credits; else: echo "[empty]"; endif; ?>
        </span>
        <?php if($this->session->userdata('is_admin')): ?>
            <input style="display: none;" name="credits" type="text" id="credits" value="<?php echo $basicInfo->leave_credits; ?>" placeholder="salary" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','leave_credits',this.value,this.id)}"  >
            <i id="editCreditsBtn" onclick="$('#a_credits').hide(), $('#credits').show(),$('#credits').focus(),$(this).hide(), $('#saveCreditsBtn').show(), $('#closeCreditsBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="saveCreditsBtn" onclick="$('#a_credits').show(), $('#credits').hide(), $('#editCreditsBtn').show(), $('#saveCreditsBtn').hide(), $('#closeCreditsBtn').hide(), updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','leave_credits',$('#credits').val(),'credits')" style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closeCreditsBtn" onclick="$('#a_credits').show(), $('#credits').hide(), $('#editCreditsBtn').show(), $('#saveCreditsBtn').hide(), $(this).hide()" style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>
      
       <?php endif; ?> 
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    SSS:
    </dt>
    <dd>
        <span title="double click to edit" id="a_sss" >
            <?php if($basicInfo->sss!=""):echo $basicInfo->sss; else: echo "[empty]"; endif; ?>
        </span>
            <input onblur="$('#a_sss').show(), $('#sss').hide()" style="display: none;" name="sss" type="text" id="sss" value="<?php echo $basicInfo->sss; ?>" placeholder="sss #" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','sss',this.value,this.id)}"  >
            
             <i onclick="$('#a_sss').hide(), $('#sss').show(),$('#sss').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer"></i> 
             

            <i id="editSSSBtn" onclick="$('#a_sss').hide(), $('#sss').show(),$('#sss').focus(),$(this).hide(), $('#saveSSSBtn').show(), $('#closeSSSBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="saveSSSBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','sss',$('#sss').val(),'sss'), $('#a_sss').show(), $('#incase_relation').hide(), $('#editSSSBtn').show(), $('#saveSSSBtn').hide(), $('#closeSSSBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closeSSSBtn" onclick="$('#a_sss').show(), $('#sss').hide(), $('#editSSSBtn').show(), $('#saveSSSBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

        
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    PhilHealth:
    </dt>
    <dd>
        <span title="double click to edit" id="a_philhealth" >
            <?php if($basicInfo->phil_health!=""):echo $basicInfo->phil_health; else: echo "[empty]"; endif; ?>
            
        </span>
        <input style="display: none;" name="philhealth" type="text" id="philhealth" value="<?php echo $basicInfo->phil_health; ?>" placeholder="phil_health" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','phil_health',this.value,this.id)}"  >
            
        

            <i id="editPhilHealthBtn" onclick="$('#a_philhealth').hide(), $('#philhealth').show(),$('#philhealth').focus(),$(this).hide(), $('#savePhilHealthBtn').show(), $('#closePhilHealthBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="savePhilHealthBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','phil_health',$('#philhealth').val(),'philhealth'), $('#a_philhealth').show(), $('#philhealth').hide(), $('#editPhilHealthBtn').show(), $('#savePhilHealthBtn').hide(), $('#closePhilHealthBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closePhilHealthBtn" onclick="$('#a_philhealth').show(), $('#philhealth').hide(), $('#editPhilHealthBtn').show(), $('#savePhilHealthBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

        
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    Pag-Ibig:
    </dt>
    <dd>
        <span title="double click to edit" id="a_pag_ibig" >
            <?php if($basicInfo->pag_ibig!=""):echo $basicInfo->pag_ibig; else: echo "[empty]"; endif; ?>
        </span>
         <input style="display: none;" name="pag_ibig" type="text" id="pag_ibig" value="<?php echo $basicInfo->pag_ibig; ?>" placeholder="pag_ibig" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','pag_ibig',this.value,this.id)}"  >

            <i id="editPagIbigBtn" onclick="$('#a_pag_ibig').hide(), $('#pag_ibig').show(),$('#pag_ibig').focus(),$(this).hide(), $('#savePagIbigBtn').show(), $('#closePagIbigBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="savePagIbigBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','pag_ibig',$('#pag_ibig').val(),'pag_ibig'), $('#a_pag_ibig').show(), $('#pag_ibig').hide(), $('#editPagIbigBtn').show(), $('#savePagIbigBtn').hide(), $('#closePhilHealthBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closePagIbigBtn" onclick="$('#a_pag_ibig').show(), $('#pag_ibig').hide(), $('#editPagIbigBtn').show(), $('#savePhilHealthBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

        
        
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    TIN:
    </dt>
    <dd>
        <span title="double click to edit" id="a_tin" >
            <?php if($basicInfo->tin!=""):echo $basicInfo->tin; else: echo "[empty]"; endif; ?>
        </span>
        <input style="display: none;" name="tin" type="text" id="tin" value="<?php echo $basicInfo->tin; ?>" placeholder="tin" 
                      onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','tin',this.value,this.id)}"  >
            
            <i id="editTinBtn" onclick="$('#a_tin').hide(), $('#tin').show(),$('#tin').focus(),$(this).hide(), $('#saveTinBtn').show(), $('#closeTinBtn').show()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "></i>   
            <i id="saveTinBtn" onclick="updateProfile('<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee')?>','<?php echo $basicInfo->employee_id ?>','tin',$('#tin').val(),'tin'), $('#a_tin').show(), $('#pag_ibig').hide(), $('#editTinBtn').show(), $('#saveTinBtn').hide(), $('#closeTinBtn').hide() " style="font-size:15px; display: none; " class="fa fa-save clickover pointer"></i>
            <i id="closeTinBtn" onclick="$('#a_tin').show(), $('#tin').hide(), $('#editTinBtn').show(), $('#saveTinBtn').hide(), $(this).hide() " style="font-size:15px; display: none; " class="fa fa-close clickover pointer text-danger"></i>

        
    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    Pay Type:
    </dt>
    <dd>
        <span title="double click to edit" id="a_ptype" >
            <?php echo ($basicInfo->pay_type==0?'Based on Time Attendance':'Fixed Rate') ?>
        </span>
        <?php if($this->session->userdata('is_admin')): ?>
            <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
               rel="clickover"  
                   data-content=" 
                            <div class='form-group' style='width:200px;'>
                                <label class='control-label'>Payroll Type</label>
                                <div class='controls'>
                                  <select name='salaryGrade' id='payType' class='pull-left' required>
                                      <option>Select Payroll Type</option> 
                                      <option value='0'>Based in Time Attendance</option> 
                                      <option value='1'>Fixed Rate</option> 
                                  </select>
                                </div>
                            </div>
                            <div class='col-lg-12'>
                                 <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                 <a href='#' data-dismiss='clickover' onclick='savePtype()' style='margin-right:10px;' class='btn btn-xs btn-success  pull-right'>Save</a>
                            </div> 
                         "
                > </i>        
       <?php endif; ?> 

    </dd>
</dl>
<dl class="dl-horizontal">
    <dt>
    Time Group:
    </dt>
    <dd style="color:black;">
        <span id="shift_groupings">
           <?php  
                $timeShifting = Modules::run('hr/payroll/getTimeShifting', $basicInfo->uid);
                echo date('g:i:s a', strtotime($timeShifting->ps_from)).' - '.date('g:i:s a', strtotime($timeShifting->ps_to_pm))
           ?> 
        </span>
        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
           rel="clickover"  
         <?php 
         $groupings = Modules::run('hr/payroll/getShiftGroupings');
         if($this->session->userdata('is_admin')): ?>
               data-content=" 
                <div class='col-lg-12 form-group' style='width:230px;'>
                    <label class='control-label'>Select Time Groupings</label>
                    <div class='controls' id='groupings'>
                      <select name='inputGroupings' id='inputGroupings' class='pull-left' required>
                          <option>Select Time Groupings</option>  
                          <?php foreach ($groupings as $group): ?>
                          <option value='<?php echo $group->ps_id ?>'><?php echo $group->ps_department ?></option> 
                          <?php endforeach;?>
                      </select>
                    </div>
                </div>
                <div class'col-lg-12'>
                     <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                     <a href='#' data-dismiss='clickover' onclick='saveShiftGroup()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                </div> 
             "
        <?php endif; ?> ></i> 
    </dd>
</dl>
<script type='text/javascript'>
     
    function saveShiftGroup()
    {
        var user_id = '<?php echo $basicInfo->uid ?>';
        $.ajax({
               type: "POST",
               url: '<?php echo base_url().'hr/payroll/saveShiftGroup' ?>',
               dataType: 'json',
               data: {
                    user_id : user_id,
                    groupings: $('#inputGroupings').val(),
                    csrf_test_name : $.cookie('csrf_cookie_name')
                },    
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   $('#st_sex').html(data.msg)

               }
             });
             return false;
    }
    
</script>  