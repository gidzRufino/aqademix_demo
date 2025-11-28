<div class="col-lg-12">
    <div class="control-group defaultDeductions" id="defaultDeductions">
		<?php
		 $charges = Modules::run('hr/payroll/getPayrollCharges', $pc_code, $owners_id);
		 foreach ($charges as $i):

			 ?>
	 		<label id="<?php echo $i->pi_item_id ?>_label" class="control-label" for="firstRow"><?php echo $i->pi_item_name ?></label>
	 		<input onkeyup="calculateGross()" item_type="<?php echo $i->pi_item_type ?>" item_id="<?php echo $i->pi_item_id; ?>" amort_value="<?php echo $i->pc_amort_id; ?>" class="form-control text-center" type="text" value="<?php echo $i->pc_amount; ?>" id="input_<?php echo $i->pi_item_id; ?>" />
			 <?php
		 endforeach;
		?>
    </div>
</div>



<script type="text/javascript">
	function calculateGross() {
		var grossPay = parseFloat($("#grossPay").html());
                
                $('#defaultDeductions input').each(function () {
                    var pc_amount = parseFloat($(this).val());
                    var item_type = $(this).attr('item_type');
                    
                    if(item_type =='1')
                    {
                        grossPay += pc_amount;
                        
                    }else{
                        grossPay -= pc_amount;
                    }
                });
				
		$("#netPay").html(grossPay.toFixed(2));
	}
	function addDeduction()
	{
            $('#defaultDeductions input').each(function () {
                var pc_profile_id = '<?php echo $owners_id ?>';
                var pc_code = '<?php echo $pc_code; ?>';
                var pc_item_id = $(this).attr('item_id');
                var pc_amount = $(this).val();
                var amort_id = $(this).attr('amort_value'); 
                var em_id   = '<?php echo $employee_id ?>'
                
                var url = '<?php echo base_url('hr/payroll/updateDeduction/'); ?>';  
		$.ajax({
			type: 'POST',
			url: url,
			data: {
                            pc_profile_id   : pc_profile_id,
                            pc_code         : pc_code,
                            pc_item_id      : pc_item_id,
                            pc_amount       : pc_amount,
                            amort_id        : amort_id,
                            em_id           : em_id,
                            csrf_test_name : $.cookie('csrf_cookie_name')
                        },
			success: function (data) {
                            location.reload();
			}
		});
            });
            

	}
        
    function addItem() {

        var item_id = $('#payrollItems').val();
        var item_name = $('#'+item_id).html();
        var item_type = $('#'+item_id).attr('item_type');
        var item_cat  = $('#'+item_id).attr('item_cat');
        
        if($('#input_'+item_id).length)
        {
            alert('Sorry, Item already exist');
        }else{
            $('#defaultDeductions').append(
                    '<label id="'+item_id+'_label" class="control-label" for="firstRow">'+item_name+'</label>'
                   +'<input onkeyup="calculateGross()" item_type="'+item_type+'" name="'+item_name+'" item_id="'+item_id+'" amort_value="0" class="form-control text-center" type="text" value="" id="input_'+item_id+'" />'
                );
        }   
        
        $('#AddPayrollItem').modal('hide');
    }
</script>    