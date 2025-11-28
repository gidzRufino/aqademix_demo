<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/OR_series') ?>'">Set OR Series</button>
            <button type="button" class="btn btn-default dropdown-toggle" id="sySettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >SY <?php echo $now.' - '.($nextYear) ?></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $ro_years = Modules::run('registrar/getROYear');
                            
                                foreach ($ro_years as $ro)
                                {   
                                  $roYears = $ro->ro_years+1;
                              
                            ?> 
                <li onclick="document.location='<?php echo base_url('finance/settings/'.$ro->ro_years) ?>'"><a href="#">SY <?php echo $ro->ro_years.' - '.$roYears ?></a></li>
                <?php } ?>
            </ul> 
          </div>
    </h3>
    <div class='col-lg-12'>
        <div class='col-lg-12'>
            <div class='panel panel-warning'>
                <div class='panel-heading clearfix'>
                    <h5 class="pull-left">Schedule of Fees</h5>
                </div>
                <div class='panel-body' id="financeCharges">
                    <?php
                        $finSet = Modules::run('finance/getFinSet', $now);
                        $plans = Modules::run('finance/getPlan');
                        
                        foreach ($gradeLevel as $gl):
                            switch ($finSet->level_catered):
                            case 0:
                                ?>
                                
                                <div class="col-lg-6" id="finance_<?php echo $gl->grade_id;  ?>">
                                    <?php echo Modules::run('finance/financeCharges', $gl->grade_id, 0, $now, 0, $gl->level); ?>
                                </div>
                                <?php 
                            break;    
                            case 1:
                                if($gl->grade_id < 8):
                                ?>
                                <div class="col-lg-6" id="finance_<?php echo $gl->grade_id;  ?>">
                                    <?php echo Modules::run('finance/financeCharges', $gl->grade_id, 0, $now, 0, $gl->level); ?>
                                </div>
                                <?php 
                                endif;
                            break;    
                            case 2:
                                if($gl->dept_id == 3 || $gl->dept_id == 4):
                                ?>
                                
                                <div class="col-lg-6" id="finance_<?php echo $gl->grade_id;  ?>">
                                    <?php echo Modules::run('finance/financeCharges', $gl->grade_id, 0, $now, 0, $gl->level); ?>
                                </div>
                                <?php 
                                endif;
                            break;    
                            endswitch;
                        
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function editFinItem(desc, amount, charge_id)
    {
        $('#editFinItem').modal('show');
        $('#fin_desc').html(desc);
        $('#edit_fin_amount').val(amount);
        $('#charge_id').val(charge_id);
    }
           
    function deleteFinanceCharges()
     {
         var charge_id = $('#del_charge_id').val();
         
        var url = "<?php echo base_url().'finance/deleteFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "charge_id="+charge_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
                   $('#tr_'+charge_id).hide();
                   $('#deleteFinCharges').modal('hide');
               }
             });

        return false; 
     }
           
    function editFinanceCharges()
     {
         var charge_id = $('#charge_id').val();
         var fin_amount = $('#edit_fin_amount').val();
         
        var url = "<?php echo base_url().'finance/editFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data:{
                   school_year: '<?php echo $now ?>',
                   charge_id: charge_id,
                   fin_amount: fin_amount,
                   log: $('#tr_'+charge_id).attr('log_remarks')+' '+numberWithCommas(fin_amount)+' ]',
                   csrf_test_name: $.cookie('csrf_cookie_name')
               },
               success: function(data)
               {
                   if(data.status)
                   {
                       alert(data.msg);
                        $('#td_'+charge_id).html(numberWithCommas(data.amount));
                        $('#editFinItem').modal('hide');
                   }else{
                        alert(data.msg)
                        $('#editFinItem').modal('hide');
                    }
               }
             });

        return false; 
     }
    
    function financeWrapper(course_id)
     {
        var sem = $('#inputSem').val();
         
        var url = "<?php echo base_url().'finance/getFinanceChargesWrapper'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "course_id="+course_id+'&sem='+sem+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#financeCharges').html(data);
               }
             });

        return false; 
   }

    function setFinanceCharges(grade_level)
    {
        $('#addFinanceOption').modal('show');
        $('#grade_level').val(grade_level);
    }
    
    function addFinanceCharges()
     {
         var sem = $('#inputSem').val();
         var school_year = $('#inputCSY').val()
         var finItem = $('#inputFinItems').val();
         var finAmount = $('#fin_amount').val();
         var gradeLevel = $('#grade_level').val();
         
        var url = "<?php echo base_url().'finance/addFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "finItem="+finItem+"&gradeLevel="+gradeLevel+"&semester="+sem+"&finAmount="+finAmount+"&school_year="+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert('Successfully Added');
                   $('#finance_'+gradeLevel).html(data)
               }
             });

        return false; 
     }
     
     
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
     
    

</script>

<?php $this->load->view('financeModals'); 