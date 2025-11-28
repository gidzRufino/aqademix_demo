<div class="panel panel-primary">
    <div class="panel-heading">
        <h5>Settings</h5>
    </div>
    <div class="panel-body">
        
        <h4>Time Shifting Management</h4>
        <div class="col-lg-6">
            <table id="timeTable" class="table table-hover">
                <tr>
                    <th>Groupings</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th></th>
                </tr>
                <?php
                 foreach ($time_settings as $ts):
                     ?>
                <tr>
                    <td><?php echo $ts->ps_department ?></td>
                    <td id="time_in_td_<?php echo $ts->grp_id ?>"><?php  echo date('g:i:s a', strtotime($ts->ps_from)) ?></td>
                    <td id="time_out_td_<?php echo $ts->grp_id ?>"><?php  echo date('g:i:s a', strtotime($ts->ps_to_pm)) ?></td>
                    <td>
                        <i id="timeBtn_<?php echo $ts->grp_id; ?>" class="btn fa fa-pencil-square-o"
                           rel="clickover"  
         <?php 
         $groupings = Modules::run('hr/payroll/getPayrollShift');
         if($this->session->userdata('is_admin')): ?>
               data-content=" 
                        <div class='col-lg-12 form-group' style='width:300px;'>
                            <label class='control-label'>Time Shift</label>
                            <div class='controls' id='groupings'>
                              <select name='inputShiftings' id='inputShiftings' class='pull-left' style='width:200px;' required>
                                  <option>Select Time Shift</option>  
                                  <?php foreach ($groupings as $group): ?>
                                  <option id='shift_<?php echo $group->ps_id ?>' ps_from='<?php  echo date('g:i:s a', strtotime($group->ps_from)) ?>'  ps_to='<?php  echo date('g:i:s a', strtotime($group->ps_to)) ?>' value='<?php echo $group->ps_id ?>'><?php echo $group->ps_department.' | '. date('g:i:s a', strtotime($group->ps_from)).' - '.date('g:i:s a', strtotime($group->ps_to)) ?></option> 
                                  <?php endforeach;?>
                              </select>
                              <input type='hidden' id='group_' value='<?php echo $ts->grp_id ?>' />
                            </div>
                        </div>
                        <div class='col-lg-12'>
                             <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                             <a href='#' data-dismiss='clickover' onclick='saveShifts(<?php echo $ts->grp_id ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
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
       
       function saveShifts(group_id)
       {
           var inputShiftings  = $('#inputShiftings').val();
           var ps_from = $('#shift_'+inputShiftings).attr('ps_from');
           var ps_to = $('#shift_'+inputShiftings).attr('ps_to');
           
           var url = "<?php echo base_url().'hr/payroll/saveShifts/' ?>"; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data:{
                        shift_id : inputShiftings,
                        group_id : group_id,
                        csrf_test_name : $.cookie('csrf_cookie_name')
                    },
                   success: function(data)
                   {
                        $('#time_in_td_'+group_id).html(ps_from);
                        $('#time_out_td_'+group_id).html(ps_to);
                        $('#time_in_td_'+data.group_id).html(data.ps_from);
                        $('#time_out_td_'+data.group_id).html(data.ps_to);
                   }
                 });
           return false;
       }
       
       var types = 0;
       
       
       
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
</script>