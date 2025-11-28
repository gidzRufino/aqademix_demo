<div class="panel panel-default col-lg-3 pull-right no-padding">
    <div class="panel-heading">
        <h5>List of Deductions   <i data-toggle="modal" data-target="#od_modal" class="fa fa-plus fa-fw pull-right pointer"></i></h5>
    </div>
    <div class="panel-body">
        <div class="list-group" id="deduction_list">
            <?php foreach ($other_deductions as $od): ?>
            <a onclick="getLoanList('<?php echo $od->odi_id ?>')" class="list-group-item list-group-item-info" href="#">
                <?php echo $od->odi_items ?>
                <span class="badge pull-right"></span>
            </a>
            <?php endforeach; ?>
            
        </div>

    </div>
    
</div>
<div id="ld_result" class="pull-left col-lg-9 no-padding">
    
</div>

<div id="od_modal"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <button onclick="saveDeduction()" style="margin-right:5px" type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-save"></i></button><span id="addEdHisTitle">Add Deductions to List</span>
        </div>
        <div class="panel-body">
             <input class="col-lg-12" type="text" id="deduction_desc" placeholder="Name of Deduction" />
             <input class="col-lg-12" type="text" id="deduction_interest" placeholder="% Interest(if Applicable)" />
        </div>
    </div>
</div>    
    
<div id="loan_modal"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <span  id="dtype_name"></span>
        </div>
        <div class="panel-body">
            <div class="form-group col-lg-12">
              <label class="control-label" >Date / Time Requested:</label>
              <p><b id="date_requested"></b></p>
            </div>
            <div class="form-group col-lg-12">
              <label class="control-label" >Total Amount applying for:</label>
              <input style="margin-bottom:0;" class="form-control"  name="" type="hidden" id="odpType_id" required>
              <p class="text-danger"><b id="loan_amount"></b></p>
            </div>
            <div class="form-group col-lg-12">
              <label class="control-label" >Payment Terms applying for:</label>
              <p class="text-danger" id="odp_terms">
              </p>     
            </div>
            
            <div class="form-group col-lg-12">
              <label class="control-label" >Number of terms:</label>
              <p class="text-danger" id="no_terms">
              </p> 
            </div>
            <div class="form-group col-lg-12">
              <label class="control-label" >Loan Approved:</label>
              <p>
                 <input id="loan_approved" style="margin-right: 10px;" type="radio" name="loan_approved" value="1">Yes &nbsp;&nbsp;&nbsp;<br />
                 <input id="loan_rejected"  style="margin-right: 10px;" type="radio" name="loan_approved" value="0">No
              </p>
            </div>
            <div class="form-group col-lg-12">
              <label class="control-label" >Due Date:</label>
                 <input class="form-control" name="inputDateHired" type="text" value="<?php echo date('Y/m/d');?>" data-date-format="yyyy/mm/dd" id="duedate" >
            </div>
        </div>
        
         <div class="panel-footer clearfix">
            <span onclick="approvedLoan()" class="btn btn-success btn-xs pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-save"></i> Save</span>
            <span style="margin-right:5px"  class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-hidden="true">Cancel</span>
        </div>
        
    </div>
       
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#duedate').datepicker();
    })
    
    var odi_id = 0;
    var em_id;
    var loan_amount;
    
    function saveDeduction()
     {
       var sg = $('#deduction_desc').val()
       var interest = $('#deduction_interest').val()
         
         var url = "<?php echo base_url().'hr/saveDeduction/' ?>"; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: 'value='+sg+'&interest='+interest+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status){
                           alert(data.msg)
                           $('#deduction_list').append('<a class="list-group-item list-group-item-info" href="#">'+sg+'</a>')
                       }else{
                           alert(data.msg)
                       }

                   }
                 });

            return false; 
     }

     function getLoanList(id)
     {
         var url = "<?php echo base_url().'hr/getLoanRequest/' ?>"+id; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   beforeSend: function() {
                        showLoading('ld_result');
                    },
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       
                       $('#ld_result').html(data);
                   }
                 });

            return false; 
     }
     
     function getSingleLoanApproval(user_id, od_id, stats, amount, l_amount)
     {
         
         var url = "<?php echo base_url().'hr/getSingleLoanApp/' ?>"+user_id+'/'+od_id+'/'+stats; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status){
                           alert(data.msg)
                           
                       }else{
                           $('#dtype_name').html(data.item)
                           $('#loan_amount').html(amount+' Php')
                           $('#odp_terms').html(data.terms)
                           $('#date_requested').html(data.trans_date)
                           $('#no_terms').html(data.no_terms+' '+data.terms+' terms.')
                           odi_id = od_id
                           em_id = user_id
                           loan_amount=l_amount
                       }

                   }
                 });

            return false; 
     }
     
     function approvedLoan()
     {
         var approved = document.querySelector('input[name="loan_approved"]:checked').value;
         var dueDate = $('#duedate').val()
          var url = "<?php echo base_url().'hr/approvedLoanApp/' ?>" // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   data: 'amount='+loan_amount+'&approved='+approved+'&user_id='+em_id+'&od_id='+odi_id+'&dueDate='+dueDate+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       
                        alert(data)
                        location.reload()
                   }
                 });

            return false; 
         
     }
</script>