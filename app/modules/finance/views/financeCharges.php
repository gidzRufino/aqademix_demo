<table class='table table-hover table-striped'>
    <tr>
        <th class="text-center" colspan="5"><?php echo $grade_level.($plan_title!=""?' - '.$plan_title:''); ?>
        
            <div class="btn-group pull-right" role="group" aria-label="">
                <button title="Set Finance Charges" class="btn btn-xs btn-info" onclick="setFinanceCharges('<?php echo $grade_id ?>','<?php echo $plan_id ?>','<?php echo $grade_level ?>', '<?php echo $plan_title ?>')"><i class="fa fa-plus fa-fw"></i></button>
                <button title="Show Details" onclick="showFeeDetails('<?php echo $plan_id ?>')" class="btn btn-xs btn-success"><i id="eye_<?php echo $plan_id ?>" class="fa fa-eye-slash fa-fw"></i></button>
                <button title="Delete Plan" onclick="editFinPlan('<?php echo $plan_id ?>', '<?php echo ($plan_title!=""?' - '.$plan_title:''); ?>')" class="btn btn-xs btn-warning"><i id="rename_<?php echo $plan_id ?>" class="fa fa-edit fa-fw"></i></button>
                <button title="Delete Plan" onclick="deletePlan('<?php echo $plan_id ?>', '<?php echo ($plan_title!=""?' - '.$plan_title:'')?>')"  class="btn btn-xs btn-danger"><i id="delete_<?php echo $plan_id ?>" class="fa fa-trash fa-fw"></i></button>
            </div>
        </th>
    </tr>
    <tbody id="<?php echo $plan_id ?>" isOpen="0" style="display: none;">
        <tr>
            <td style="width:5%;">#</td>
            <td style="width:25%;">Particulars</td>
            <td style="width:20%; text-align: right;">Amount</td>
            <td style="width:20%; text-align: right;">School Year</td>
            <td style="width:20%; text-align: right;">Option</td>
        </tr>
        <?php
        $i=1;
        $total=0;
            foreach ($charges as $c):
             $next = $c->school_year + 1;
         ?>
        <tr log_remarks="Edit A Finance Charge(s):[Description: <?php echo $c->item_description ?>, Amount: from <?php echo number_format($c->amount, 2, '.',',') ?> to" id="tr_<?php echo $c->charge_id ?>">
            <td><?php echo $i++;?></td>
            <td><?php echo $c->item_description ?></td>
            <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
            <td class="text-right"><?php echo $c->school_year.' - '.$next ?></td>
            <td class="text-right">
                <div class="btn-group" role="group" aria-label="">
                    <button title="Edit Item" class="btn btn-xs btn-warning" onclick="editFinItem('<?php echo trim($c->item_description) ?>', '<?php echo $c->amount ?>','<?php echo $c->charge_id ?>')"><i class="fa fa-pencil-square-o fa-fw"></i></button>
                    <button title="Delete Item" class="btn btn-xs btn-danger" onclick="$('#deleteFinCharges').modal('show'), $('#del_charge_id').val('<?php echo $c->charge_id ?>')"><i class="fa fa-trash fa-fw"></i></button>
                </div>
            </td>
        </tr>
        <?php
            $total += $c->amount;
            endforeach;
            if($total!=0):
        ?>
        <tr>
            <th>TOTAL</th>
            <th></th>
            <th class="text-right"><?php echo number_format($total, 2, '.',',') ?></th>
            <th></th>
        </tr>
        <?php endif; ?>
    </tbody>
</table>


<div id="editFinPlan" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Edit <span id="fin_desc"></span>
            <input type="hidden" id="finPlanID" />
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="edit_fin_plan" class="form-control" placeholder="Plan Name" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='saveEditPlan()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px;" >Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<script type="text/javascript">
    
    function editFinPlan(plan_id, plan)
    {
        $('#editFinPlan').modal('show');
        $('#finPlanID').val(plan_id);
        $('#edit_fin_plan').val(plan);
    }
    
    function saveEditPlan()
    {
        var plan_id = $('#finPlanID').val();
        var plan = $('#edit_fin_plan').val();
        
        var url = "<?php echo base_url().'finance/editFinPlan'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "plan_id="+plan_id+"&plan="+plan+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data);
                   location.reload();
               }
             });

        return false; 
    }
    
    function showFeeDetails(id)
    {
        if($('#'+id).attr('isOpen')==1)
        {
            $('#'+id).attr('isOpen',0);
            $('#'+id).hide('slideUp');
            $('#eye_'+id).removeClass('fa-eye');
            $('#eye_'+id).addClass('fa-eye-slash');
        }else{
            
            $('#'+id).attr('isOpen',1);
            $('#'+id).show('slideUp');
            $('#eye_'+id).removeClass('fa-eye-slash');
            $('#eye_'+id).addClass('fa-eye');
        }    
    }
    
    function deletePlan(plan_id, plan)
    {
        var con = confirm('Are you sure you want to delete this Plan? This might be connected to the finance charges under this plan. Please also note that you cannot undo this action.');
        if(con==true){
            var url = "<?php echo base_url().'finance/deletePlan'?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   //dataType:'json',
                   data: "plan_id="+plan_id+"&plan="+plan+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data);
                       location.reload();
                   }
                 });
                       location.reload();

            return false; 
        }
    }
    
</script>