<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo ($this->eskwela->getSet()->level_catered=='0'?base_url('college'):base_url()) ?>'">Dashboard</button>
            <button type="button" class="btn btn-success" onclick="document.location='<?php echo base_url('finance/collection') ?>'">Print SOA</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/generalSettings') ?>/'+$('#inputCSY').val()">General Settings</button>
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
                    <h5 class="pull-left col-lg-12">Schedule of Fees
                        <button onclick="$('#addPlanToSchedule').modal('show')" class="btn btn-danger btn-sm pull-right">ADD Schedule of Fees</button>
                    </h5>
                </div>
                <div class='panel-body' id="financeCharges">
                    <?php
                        foreach ($gradeLevel as $g):
                            $plans = Modules::run('finance/getPlanByLevel', $g->grade_id);
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <?php echo $g->level ?>
                                </div>
                                <div class="panel-body">
                                    <?php if ($plans->num_rows() > 0):
                                            foreach($plans->result() as $p): ?>
                                                <div class="col-lg-6" id="finance_<?php echo $p->fin_plan_id;  ?>">
                                                    <?php echo Modules::run('finance/financeChargesByPlanView', $g->grade_id, 0, $now, 0, $g->level, $p->fin_plan_id, $p->plan_title); ?>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        // $finSet = Modules::run('finance/getFinSet', $now);
                        // $plans = Modules::run('finance/getPlan');
                        
                        // foreach ($plans as $p):
                        //    ?>
                                 <!-- <div class="col-lg-6" id="finance_<?php //echo $p->fin_plan_id;  ?>">
                                     <?php // echo Modules::run('finance/financeChargesByPlanView', $p->grade_id, 0, $now, 0, $p->level, $p->fin_plan_id, $p->plan_title); ?>
                                 </div> -->
                                 <?php 
                        // endforeach;
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="school_year" value="<?php echo $now ?>" />
<input type="hidden" id="grade_level" />
<input type="hidden" id="level" />
<input type="hidden" id="plan_title" />

<script type="text/javascript">

    function editFinItem(desc, amount, charge_id)
    {
       // alert('hey')
        $('#editFinItem').modal('show');
        $('#fin_desc').html(desc);
        $('#edit_fin_amount').val(amount);
        $('#charge_id').val(charge_id);
    }
           
    function deleteFinanceCharges()
     {
         var charge_id = $('#del_charge_id').val();
         var school_year = $('#school_year').val();
         
        var url = "<?php echo base_url().'finance/deleteFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "charge_id="+charge_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
         var school_year = $('#school_year').val();
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

    function setFinanceCharges(grade_level, plan_id, level, plan_title)
    {
        $('#addFinanceOption').modal('show');
        $('#grade_level').val(grade_level);
        $('#plan_id').val(plan_id);
        $('#level').val(level);
        $('#plan_title').val(plan_title);
    }
    
    function addFinanceCharges()
     {
         var sem = $('#inputSem').val();
         var school_year = $('#inputCSY').val()
         var finItem = $('#inputFinItems').val();
         var finAmount = $('#fin_amount').val();
         var gradeLevel = $('#grade_level').val();
         var plan_id = $('#plan_id').val();
         var proceed = 1;

         if (finItem == 0) {
            $('#errMsg').html('Please Select Finance Item')
            $('#fgMsg').show().delay(3000).queue(function (n) {
				$('#fgMsg').hide();
				n();
			});
            proceed = 0;
         } else if (finAmount == '') {
            $('#errMsg').html('Please Enter Amount')
            $('#fgMsg').show().delay(3000).queue(function (n) {
				$('#fgMsg').hide();
				n();
			});
            proceed = 0;
         }

         if (proceed == 1) {
            var url = "<?php echo base_url().'finance/addFinanceCharges'?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                dataType:'json',
                data: "finItem="+finItem+"&gradeLevel="+gradeLevel+"&plan_id="+plan_id+"&semester="+sem+"&finAmount="+finAmount+"&school_year="+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data)
                {
                    if(!data.status) {
                        $('#errMsg').html(data.msg)
                        $('#fgMsg').show().delay(3000).queue(function (n) {
                            $('#fgMsg').hide();
                            n();
                        });
                    } else {
                        alert(data.msg);
                        location.reload();
                        // $('#addFinanceOption').modal('hide');
                        // $.ajax({
                        //     type: 'GET',
                            // url: '<?php //echo base_url('finance/financeChargesByPlanView/') ?>' + gradeLevel + '/0/' + school_year + '/0/' + $('#level').val() + '/' + plan_id + '/' + $('#plan_title').val(),
                        //     success: function (data2) {
                        //         $('#finance_'+plan_id).html(data2)
                        //         // $('#addFinanceOption').modal('hide');
                        //     }
                        // })
                        
                    }
                },
                error: function () {
                    alert('Err')
                }
                });

            return false; 
         }
     }
     
     
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
     
    

</script>

<?php $this->load->view('financeModals'); 