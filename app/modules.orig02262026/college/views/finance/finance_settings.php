<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/generalSettings') ?>/'+$('#inputCSY').val()">General Settings</button>
            <button type="button" class="btn btn-default dropdown-toggle" id="sySettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >SY <?php echo $now.' - '.($nextYear) ?></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php for($ro = 2018; $ro <= date('Y'); $ro++){
                                  $roYears = $ro+1;
                              
                            ?> 
                <li onclick="document.location='<?php echo base_url('college/finance/settings/'.$ro) ?>', $('#inputCSY').val('<?php echo $ro ?>')"><a href="#">SY <?php echo $ro.' - '.$roYears ?></a></li>
                <?php } ?>
            </ul>
            <input type="hidden" id="inputCSY" value="<?php echo $now ?>" name="inputCSY" />
          </div>
    </h3>
    <div class='col-lg-12'>
        <div class='col-lg-12'>
            <div class='panel panel-warning'>
                <div class='panel-heading clearfix'>
                    <h5 class="pull-left">First Semester Schedule of Fees
                    </h5>
                    <div class="pull-right">
                        <select id="selectCourse" style="width: 300px;" onclick="financeWrapper(this.value)">
                            <option>Select Course</option>
                            <?php foreach ($course as $c): ?>
                            <option <?php echo ($c->course_id==$course_id?'Selected':'') ?> value="<?php echo $c->course_id ?>"><?php echo strtoupper($c->course); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button title="Forward Fees to Next Semester" onclick="forwardFees($('#inputSem').val(), $('#inputCSY').val())" class="btn btn-xs btn-warning"><i class="fa fa-paper-plane"></i></button>
                    </div>
                    
                <div class="form-group pull-right">
                        <select onclick="getCollegeStudentsBySemester(this.value)" tabindex="-1" id="inputSem" style="width:200px; font-size: 15px;" class=" ">
                            
                            <?php
                                $sem = ($sems==NULL?Modules::run('main/getSemester'):$sems);
                                switch ($sem):
                                    case 1:
                                        $first = 'Selected';
                                        $second='';
                                        $third='';
                                    break;
                                    case 2:
                                        $first = '';
                                        $second='selected';
                                        $third='';
                                    break;
                                    case 3:
                                        $first = '';
                                        $second='';
                                        $third='Selected';
                                    break;
                                endswitch;
                            ?>
                            <option <?php echo $first ?> value="1">First</option>
                            <option <?php echo $second ?> value="2">Second</option>
                            <option <?php echo $third ?> value="3">Summer</option>
                        </select>
                 </div>
                </div>
                <div class='panel-body' id="financeCharges">
                   <?php echo Modules::run('college/finance/getFinanceChargesWrapper', $course_id, $sems, $now) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#selectCourse').select2();
    })

    function editFinItem(desc, amount, charge_id)
    {
        $('#editFinItem').modal('show');
        $('#fin_desc').html(desc);
        $('#edit_fin_amount').val(amount);
        $('#charge_id').val(charge_id);
    }
           
    function forwardFees(sem, SY)
    {
         
        var url = "<?php echo base_url().'college/finance/forwardFees'?>"; // the script where you handle the form input.

        var check = confirm('Are you sure you want to forward the fees for the next semester? Make sure you know what you are doing.');
        
        if(check==true)
        {
            $.ajax({
                   type: "POST",
                   url: url,
                   //dataType:'json',
                    beforeSend: function() {
                         showLoading('financeCharges');
                    },
                   data: "semester="+sem+'&school_year='+SY+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data);
                       location.reload();
                   }
                 });

            return false; 
       }
    }
           
    function deleteFinanceCharges()
     {
         var charge_id = $('#del_charge_id').val();
         var school_year = $('#inputCSY').val();
         
        var url = "<?php echo base_url().'college/finance/deleteFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "charge_id="+charge_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data);
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
         var sem = $('#inputSem').val();
         var school_year = $('#inputCSY').val();
         
        var url = "<?php echo base_url().'college/finance/editFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "charge_id="+charge_id+'&semester='+sem+'&school_year='+school_year+'&fin_amount='+fin_amount+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
         
        var url = "<?php echo base_url().'college/finance/settings/'?>"+$('#inputCSY').val()+'/'+course_id+'/'+sem; // the script where you handle the form input.
        document.location = url;
//        $.ajax({
//               type: "POST",
//               url: url,
//               data: "course_id="+course_id+'&sem='+sem+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
//               success: function(data)
//               {
//                   $('#financeCharges').html(data);
//               }
//             });
//
//        return false; 
   }

    function setFinanceCharges(course_id, year_level)
    {
        $('#addFinanceOption').modal('show');
        $('#course_id').val(course_id);
        $('#year_level').val(year_level);
    }
    
    function addFinanceCharges()
     {
         var sem = $('#inputSem').val();
         var school_year = $('#inputCSY').val();
         var finItem = $('#inputFinItems').val();
         var finAmount = $('#fin_amount').val();
         var finCourse = $('#course_id').val();
         var finYear = $('#year_level').val();
         
        var url = "<?php echo base_url().'college/finance/addFinanceCharges'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "finItem="+finItem+"&course_id="+finCourse+"&year_level="+finYear+"&semester="+sem+"&finAmount="+finAmount+"&school_year="+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert('Successfully Added');
                   $('#finance_'+finYear).html(data)
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