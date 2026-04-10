<?php
    $paymentSchedule = Modules::run('hr/hrdbprocess/getPaymentSchedule', 1);
    switch ($paymentSchedule->monthly):
        case 0:
            $payType = 'Bi - Monthly';
            $id = 0;
            break;
        case 1:
            $payType = 'Monthly';
            $id = 1;
            break;
        case 2:
            $payType = 'Weekly';
            $id = 2;
            break;
    endswitch;
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 5px;">Payroll Report : <?php echo $payType ?>
        <div class="pull-right" style="font-size: 15px;">
               <input name="startDate" type="text" data-date-format="yyyy-mm-dd" id="startDate" placeholder="Select Start Date" required>
               <input name="endDate" type="text" data-date-format="yyyy-mm-dd" id="endDate" placeholder="Select End Date" required>
               <button onclick="generatePayroll('<?php echo $id ?>')" id="generatePayroll" class="btn btn-success btn-xs">Generate Payroll</button>
               <button data-toggle="modal" data-target="#max_Payroll" onclick="maximizePayroll('<?php echo $id ?>')" id="generatePayroll" class="btn btn-success btn-xs"><i class="fa fa-external-link-square"></i></button>
               
        </div>
        
        </h3>
    </div>
</div>
<div class="col-lg-12 no-padding" id="payrollDetails">

</div>

<div id="max_Payroll"  style="width:95%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <button style="margin-right:10px;" type="button" class="btn btn-warning btn-xs pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x fa-print"></i></button>
            Payroll Report Details
        </div>
        <div id="pr_details" class="panel-body">
            
        </div>
    </div>
</div>  

<script type="text/javascript">

      $(document).ready(function() {
          $('#startDate').datepicker();
          $('#endDate').datepicker();
      });
      
    
    function generatePayroll(pType)
    {
        var url = "<?php echo base_url().'hr/generatePayrollReport/' ?>"+pType; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
           data: 'startDate='+$('#startDate').val()+'&endDate='+$('#endDate').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
               $('#payrollDetails').html(data);
           }
         });

        return false; // avoid to execute the actual submit of the form
    }
    
    function maximizePayroll(pType)
    {
        var url = "<?php echo base_url().'hr/generatePayrollReportDetails/' ?>"+pType; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
           data: 'startDate='+$('#startDate').val()+'&endDate='+$('#endDate').val(), // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
               $('#pr_details').html(data);
           }
         });

        return false; // avoid to execute the actual submit of the form.
    }
    
    function approvedPR(id)
    {
        $('#'+id+'_apBtn').removeClass('btn-danger');
        $('#'+id+'_apBtn').addClass('btn-success');
        $('#'+id+'_apBtn').html('Approved');
        $('#'+id+'_relBtn').removeClass('disabled');
    }
    
    function approvedAll()
    {
        
        var data = new Array();
        var em_id
        var od_id
        var sg_id
        var basic_pay
        var od_amount
        $('#prTableDetails .hasData').each(function(){
            $(this).find("td.em_id").each(function(){
                em_id = $(this).html()
            })
            $(this).find("td.salary").each(function(){
                basic_pay = $(this).attr('value')
            })
            $(this).find("td.od_amount").each(function(){
                od_amount = $(this).attr('value')
            })
            $(this).find("td.od_id").each(function(){
                od_id = $(this).html()
            })
            $(this).find("td.sg_id").each(function(){
                sg_id = $(this).html()
            })
            
            if(basic_pay!=0){
                savePR_transaction(em_id, od_id, sg_id, od_amount);
                $('#'+em_id+'_apBtn').removeClass('btn-danger');
                $('#'+em_id+'_apBtn').addClass('btn-success');
                $('#'+em_id+'_apBtn').html('Approved');
                $('#'+em_id+'_relBtn').removeClass('disabled');
            }
            //
        })
        
        //alert(i)
    }
    
    function savePR_transaction(em_id, od_id, sg_id, od_amount)
    {
        var url = "<?php echo base_url().'hr/savePR_transaction/' ?>"; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
           data: 'credit_amount='+od_amount+'&em_id='+em_id+'&od_id='+od_id+'&sg_id='+sg_id+'&approved=1&startDate='+$('#startDate').val()+'&endDate='+$('#endDate').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
           }
         });
    }
    
    function releasedAll()
    {
        $('.released').removeClass('btn-danger');
        $('.released').addClass('btn-success');
        $('.released').html('Released');
    }
    
</script>