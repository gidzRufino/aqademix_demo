<?php
$pk = 'user_id';
$table='stg_profile_employee';
$pk_id = $user_id;
$column = 'pg_id';

?>
<input type="hidden" id="pk_id" value="<?php echo $pk_id; ?>" />
<div class="modules">
    <hr>
    <h5>Payroll Information 
    <a id="<?php  ?>_a" class="help-inline pull-right" 
              rel="clickover" 
              data-content=" 
                   <div style='width:100%;'>
                   <h6>Add Payroll Info</h6>
                   <select id='salaryGrade'>
                   <?php 
                   foreach($salaryGrade as $sg){
                   ?>
                   <option value='<?php echo $sg->sg ?>'><?php echo $sg->salary ?></option>
                   <?php } ?>
                   </select>
                   <input type='hidden' id='pg_id' />
                   <div style='margin:5px 0;'>
                   <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                   <a href='#' data-dismiss='clickover' onclick='saveSG()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                   </div>
                    "   
              class="btn" data-toggle="modal" href="#">Add</a>
    </h5>
   <hr>
   
   <div class="payrollDetails">
       <?php if($payrollInfo->pg_id!=0){ ?>
            <h6 style="color:black; margin:3px 0;">Basic Pay: &nbsp;<span style="color:#BB0000;"><?php echo number_format($payrollInfo->salary, 2, '.', ','); ?></span> </h6>
            <br />
            <hr/>
            <h5>Statutory Benefits:</h5>
            <hr/>
            <div class="row">
                <div class="span3 pull-left">
                    <h6 style="color:black; margin:3px 0;">SSS: &nbsp;<span style="color:#BB0000;"><?php echo number_format($payrollInfo->SSS, 2, '.', ','); ?></span> </h6>
                    <h6 style="color:black; margin:3px 0;">Philhealth: &nbsp;<span style="color:#BB0000;"><?php echo number_format($payrollInfo->phil_health, 2, '.', ','); ?></span> </h6> 
                </div>
                <div class="span2">
                    <h6 style="color:black; margin:3px 0;">Pag-Ibig: &nbsp;<span style="color:#BB0000;"><?php echo number_format($payrollInfo->pag_ibig, 2, '.', ','); ?></span> </h6>
                    <h6 style="color:black; margin:3px 0;">TIN: &nbsp;<span style="color:#BB0000;"><?php echo number_format($payrollInfo->tin, 2, '.', ','); ?></span> </h6>
                </div>
                

            </div>
                           
       <?php }else{ ?>
            <h6 class="text-center" >( Sorry, No payroll info Added Yet )</h6>
       <?php } ?>
   </div>
    
</div>
<script type="text/javascript">
    function saveSG()
    {
        var value = document.getElementById('salaryGrade').value;
        var url = "<?php echo base_url().'hr/editPayrollInfo/' ?>"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'id='+$('#pk_id').val()+'&column=pg_id'+'&value='+value+'&tbl=stg_profile_employee'+'&pk=user_id', // serializes the form's elements.
           success: function(data)
           {
               location.reload();
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    }
    
</script>
