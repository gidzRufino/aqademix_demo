<div class="alert alert-info">
   Hi Please select an option.
   <button data-toggle="modal" data-target="#loan_modal" onclick="getDtype($('#deduction_type').val(), $('#'+$('#deduction_type').val()+'_dtype').html())" class="btn btn-info pull-right btn-xs">Apply</button>
   <select style="margin-right:5px;" id="deduction_type" class="pull-right">
            <option>Select here</option>
       <?php foreach ($deductions as $od): ?>
            <option id="<?php echo $od->odi_id ?>_dtype" value="<?php echo $od->odi_id ?>">
                <?php echo $od->odi_items ?>
            </option>
       <?php endforeach; ?>
   </select>
</div>
<?php 
    if($myLoans->num_rows()> 0):
?>
    <table class="table table-bordered">
        <tr>
            <th class="text-center">Loan Type</th>
            <th class="text-center">Principal Amount</th>
            <th class="text-center">Total Amount</th>
            <th class="text-center">Remaining Amount</th>
            <th class="text-center">Terms</th>
            <th class="text-center">Remaining Terms</th>
            <th class="text-center">Status</th>
        </tr>
        <?php 
            //print_r($loanList);
        foreach ($myLoans->result() as $ll): 
           if($ll->no_terms==0):
               $terms = $ll->odp_terms;
           else:    
               $terms = $ll->no_terms.' '.$ll->odp_terms.' terms';
           endif;
            ?>
        <tr class="text-center">
            <td><?php echo $ll->odi_items;  ?></td>
            <td><?php echo number_format(($ll->od_principal_amount),2,'.',',').' Php';  ?></td>
            <td><?php echo number_format(($ll->charge),2,'.',',').' Php';  ?></td>
            <td><?php echo number_format(($ll->charge-$ll->credit),2,'.',',').' Php';  ?></td>
            <td><?php echo $terms ?></td>
            <td><?php echo $ll->no_terms; ?></td>
            <td><?php if($ll->approved): echo 'Approved'; else: echo 'Pending'; endif; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php
    else:
?>  
    <div  style="margin:0 auto; width:50%;">
        <div class="alert alert-warning">
            <h5 class="text-center"><i class="fa fa-info-circle fa-fw"></i> Currently, you don't have any other deductions.</h5>
        </div>
    </div>

<?php

endif;

?>

<div id="loan_modal"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <span  id="dtype_name"></span>
        </div>
        <div class="panel-body">
            <div class="form-group col-lg-12">
              <label class="control-label" for="inputAddress">Amount applying for:</label>
              <input style="margin-bottom:0;" class="form-control"  name="" type="hidden" id="odpType_id" required>
              <input style="margin-bottom:0;" class="form-control"  name="" type="text" id="loan_amount" placeholder="Amount" required>
            </div>
            <div class="form-group col-lg-12">
              <label class="control-label" for="inputAddress">Payment Terms applying for:</label>
              <select  style="width:230px;"  id="odp_terms">
                        <option>Select here</option>
                   <?php foreach ($payment_terms as $pt): ?>
                        <option id="<?php echo $pt->odp_id ?>_odp" value="<?php echo $pt->odp_id ?>">
                            <?php echo $pt->odp_terms ?>
                        </option>
                   <?php endforeach; ?>
               </select>
            </div>
            
            <div class="form-group col-lg-12">
              <label class="control-label" for="inputAddress">Number of terms:</label>
              <input style="margin-bottom:0;" class="form-control"  name="no_of_terms" type="text" id="no_of_terms" placeholder="No of Terms" required>
            </div>
        </div>
        
         <div class="panel-footer clearfix">
            <span onclick="saveLoan()" class="btn btn-success btn-xs pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-save"></i> Save</span>
            <span style="margin-right:5px"  class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-hidden="true">Cancel</span>
        </div>
        
    </div>
       
</div>
    
<script type="text/javascript">
    
    function getDtype(type_id, type)
    {
        $('#dtype_name').html(type);
        $('#odpType_id').val(type_id);
    }
       
    function saveLoan()
     {
       var item = $('#odpType_id').val();
       var terms = $('#odp_terms').val();
       var no_terms = $('#no_of_terms').val();
       var amount = $('#loan_amount').val();
       var acct = '<?php echo $basicInfo->em_id ?>'
         
         var url = "<?php echo base_url().'hr/saveLoan/' ?>"; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: 'item='+item+'&terms='+terms+'&no_terms='+no_terms+'&em_id='+acct+'&amount='+amount+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status){
                           alert(data.msg)
                           location.reload()
                       }else{
                           alert(data.msg)
                       }

                   }
                 });

            return false; 
     }
</script>