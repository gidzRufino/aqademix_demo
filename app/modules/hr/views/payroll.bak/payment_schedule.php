<div class="panel panel-primary">
    <div class="panel-heading">
        <h5>Settings</h5>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>
            Payroll Type:
            <?php 
                switch ($paymentSchedule->monthly):
                    case 0:
                        $payType = 'Bi - Monthly';
                        $firstPayTitle = 'First Cut of Day';
                        $style = '';
                        break;
                    case 1:
                        $payType = 'Monthly';
                        $firstPayTitle = 'PayDay';
                        $style = 'display:none;';
                        break;
                    case 2:
                        $payType = 'Weekly';
                        $firstPayTitle = 'PayDay';
                        $style = 'display:none;';
                        break;
                endswitch;
            ?>
            </dt>
            <dd>
                <span title="double click to edit" id="a_payType" >
                    <?php echo $payType; ?>

                </span>
                <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
                   rel="clickover"  
                 <?php if($this->session->userdata('is_admin')): ?>
                       data-content=" 
                                <div class='col-lg-12 form-group' style='width:230px;'>
                                    <label class='control-label'>Select Payroll Type</label>
                                    <div class='controls' id='AddedSection'>
                                       <select onclick='selectPayType(this.value)' name='payType' id='payType' required>
                                            <option value='2'>Weekly</option>  
                                            <option value='0'>Bi - Monthly</option>  
                                            <option value='1'>Monthly</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class'col-lg-12'>
                                     <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                     <a href='#' data-dismiss='clickover' onclick='savePayType()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                </div> 
                             "
                     <?php endif; ?> ></i>
            </dd>
        </dl>
        
        <dl class="dl-horizontal" id="firstPay_wrapper">
            <dt id="firstPay_title">
            <?php echo $firstPayTitle ?>:
            </dt>
            <dd>
                <span title="double click to edit" id="a_firstPay" >
                    <?php if($paymentSchedule->firstpay!=""):echo $paymentSchedule->firstpay; else: echo "[empty]"; endif; ?>
                    <i onclick="$('#a_firstPay').hide(), $('#firstPay').show(),$('#firstPay').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o pointer "></i>
                </span>
                <input style="display: none; width:300px" type="text" id="firstPay" value="<?php echo $paymentSchedule->firstpay; ?>" 
                   onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('id') ?>','<?php echo base64_encode('profile_employee_paymentschedule')?>',1,'firstpay',this.value,this.id)}"
                   title="press enter to save your edit"
                   onblur="$('#a_firstPay').show(), $('#firstPay').hide()"
                   />
            </dd>
        </dl>
        
        <dl style="<?php echo $style; ?>" class="dl-horizontal" id="secondPay_wrapper">
            <dt>
            Next Cut off Day:
            </dt>
            <dd>
                <span title="double click to edit" id="a_secondPay" >
                    <?php if($paymentSchedule->nextpay!=""):echo $paymentSchedule->nextpay; else: echo "[empty]"; endif; ?>
                    <i onclick="$('#a_secondPay').hide(), $('#secondPay').show(),$('#secondPay').focus()" style="font-size:15px; color:#777;" class="fa fa-pencil-square-o pointer "></i>
                </span>
                <input style="display: none; width:300px" type="text" id="secondPay" value="<?php echo $paymentSchedule->nextpay; ?>" 
                   onkeypress="if (event.keyCode==13){updateProfile('<?php echo base64_encode('id') ?>','<?php echo base64_encode('profile_employee_paymentschedule')?>',1,'nextpay',this.value,this.id)}"
                   title="press enter to save your edit"
                   onblur="$('#a_secondPay').show(), $('#secondPay').hide()"
                   />
                
            </dd>
        </dl>
        
        <hr />
        
        <h4>Time Settings</h4>
        <div class="col-lg-6">
            <table id="timeTable" class="table table-hover">
                <tr>
                    <th>Department</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th></th>
                </tr>
                <?php
                 foreach ($time_settings as $ts):
                     ?>
                <tr>
                    <td><?php echo $ts->ps_department ?></td>
                    <td id="time_in_td_<?php echo $ts->ps_id ?>"><?php  echo date('g:i:s a', strtotime($ts->ps_from)) ?></td>
                    <td id="time_out_td_<?php echo $ts->ps_id ?>"><?php  echo date('g:i:s a', strtotime($ts->ps_to)) ?></td>
                    <td>
                        <i id="timeBtn_<?php echo $ts->ps_id; ?>" class="btn fa fa-pencil-square-o"
                           rel="clickover"  
                    <?php 
                        if($this->session->userdata('is_admin')): ?>
                              data-content=" 
                                       <div class='col-lg-12 form-group' style='width:300px;'>
                                           <label class='control-label'>Time Shift</label>
                                           <div class='controls' id='groupings'>

                                           </div>
                                       </div>
                                       <div class='col-lg-12'>
                                            <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                            <a href='#' data-dismiss='clickover' onclick='' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                       </div> 
                                    "
                       <?php endif; ?>
                     ></i>
                    </td>
                </tr>
                <?php
                 endforeach;
                 ?>
            </table>
        </div>

    </div>
    
</div>

<script type="text/javascript">
       
       var types = 0;
       
       function selectPayType(type)
       {
           if(type==1 || type==2)
               {
                   $('#secondPay_wrapper').hide();
                   $('#firstPay_title').html('Pay Day:');
               }
           if(type==0)
               {
                   $('#firstPay_title').html('First Payday:');
                   $('#secondPay_wrapper').show();
               }
               types = type
       }
       
       function editTime(id, time_in, time_out)
       {
           if($('#timeBtn_'+id).hasClass('saveBtn'))
           {
               $('#timeBtn_'+id).addClass('fa-pencil-square-o');
               $('#timeBtn_'+id).removeClass('saveBtn');
               $('#timeBtn_'+id).removeClass('fa-save'); 
               $('#time_in_td_'+id).removeClass('CellEditing');
               $('#time_in_td_'+id).html($('#time_in_td_'+id+' input').val());
               $('#time_out_td_'+id).removeClass('CellEditing');
               $('#time_out_td_'+id).html($('#time_out_td_'+id+' input').val());
           }else{
               $('#time_in_td_'+id).addClass('CellEditing');
               $('#time_in_td_'+id).html("<input type='text' style='height:30px; text-align:center' value='" + time_in + "' />");
               $('#time_out_td_'+id).addClass('CellEditing');
               $('#time_out_td_'+id).html("<input type='text' style='height:30px; text-align:center' value='" + time_out + "' />");
           
               $('#timeBtn_'+id).addClass('saveBtn');
               $('#timeBtn_'+id).removeClass('fa-pencil-square-o');
               $('#timeBtn_'+id).addClass('fa-save');
           }
           
           
       }
       
       function savePayType()
       {
           var pk = '<?php echo base64_encode('id') ?>';
           var table='<?php echo base64_encode('profile_employee_paymentSchedule')?>';
           var pk_id = 1
           var column = 'monthly'
           var value = types
           var id
           
           updateProfile(pk,table, pk_id, column, value, '')
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
</script>