<?php
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>

<div class="clearfix row" style="margin:0;">
	<div id="delPlanModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-primary">
	        <button type="button" class="close" onclick="delClose()" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Delete Payment Item</h4>
	      </div>

   		<?php 
			foreach($delInitResult as $eiResult){
				$ei_item = $eiResult->item_description;
				$ei_item_id = $eiResult->item_id;
				$ei_plan = $eiResult->plan_description;
				$ei_plan_id = $eiResult->plan_id;
				$ei_amount = $eiResult->item_amount;
				$ei_freq = $eiResult->schedule_description;
				$ei_freq_id = $eiResult->schedule_id;
				$ei_sy = $eiResult->school_year;
				$ei_sy_id = $eiResult->sy_id;
				$ei_date = $eiResult->implement_date;
				$ei_level_id = $eiResult->level_id;
				$ei_level = $eiResult->level;
				$ei_init_id = $eiResult->init_id;
				
				$elogtdate = date("F d, Y [g:i:s a]");
				$elogremarks = 'Lvl:'.$ei_level.', Pl:'.$ei_plan.', It:'.$ei_item.', Amt:'.$ei_amount.', Fq:'.$ei_freq.', SY:'.$ei_sy.', ImD:'.$ei_date;
		?>

	      <div class="modal-body">
	        <form class="form-horizontal" id="delItemForm" name="delItemForm">
				<div class="row">			
					<div class="col-md-7 col-md-offset-1">
						<h3>Payment item details</h3>
					</div>
				</div>
				<div class="row">			
					<div class="col-md-5 col-md-offset-1">
			  			<label for="input"><b>Grade level: </b> <?php echo $ei_level ?></label>
			  		</div>
			  	</div>
				<div class="row">			
					<div class="col-md-7 col-md-offset-1">
	  					<label for="input" >Item Description:  <?php echo $ei_item ?></label>
	  				</div>
	  			</div>
	  			<div class="row">			
					<div class="col-md-5 col-md-offset-1">
	  					<label for="input">Payment Plan: <?php echo $ei_plan ?></label>
	    			</div>
		  		</div>
		  		<div class="row">			
					<div class="col-md-5 col-md-offset-1">
			  			<label for="input">Amount: PhP <?php echo $ei_amount ?></label>
			  		</div>
		  		</div>
		  		<div class="row">			
					<div class="col-md-5 col-md-offset-1">
			  			<label for="input">Frequency:  <?php echo $ei_freq ?> </label>
				  	</div>
		  		</div>
		  		<div class="row">			
					<div class="col-md-5 col-md-offset-1">
			  			<label for="input">School Year:  <?php echo $ei_sy ?></label>
			  		</div>
	  			</div>
	  			<!-- <div class="row">			
					<div class="col-md-5 col-md-offset-1">
			  			<label for="input">Implementation Date:  <?php echo $ei_date ?></label>
				  	</div>
				</div> -->
				<div class="hidding">
				  	<input type="hidden" name="delitID" id="delitID" value="<?php echo $ei_init_id ?>"required>
				  	<input type="hidden" name="delitChCr" id="delitChCr" value="0" required>
				  	<input type="hidden" name="delLvl" id="delLvl" value="<?php echo $ei_level_id ?>" required>
				</div>
			    <div class="hiddingLog">
			    	<input type="hidden" name="elogdate" id="elogdate" value="<?php echo $elogtdate ?>"required>
			  		<input type="hidden" name="elogaccount" id="elogaccount" value="<?php echo $userid ?>"required>
			  		<input type="hidden" name="elogremarks" id="elogremarks" value="<?php echo $elogremarks ?>"required>
			  	</div>
			</form>

			<?php } ?>
			
	      </div>
	      <div class="row">
		      <div class="alert alert-danger alert-dismissable">
				<h4>Warning!!!</h4><span>Please consider the risk of data loss and computation inconsistencies connected to this payment item. Once deleted, it can never be recovered again.</span><br /> <strong>Do you still want to continue?</strong>
			  </div>
		  </div>`
	      <div class="modal-footer">
	        <button id="delItembtn" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"> </i> Yes! Delete this!</button>
  			<button id="cancelbtn" onclick="delClose()" class="btn btn-inverse btn-sm"><i class="fa fa-close fa-fw"> </i> Cancel</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>


<script type="text/javascript">

$(document).ready(function()
{
	$('#delitSelItem').select2();
	$('#delitPlan').select2();
	$('#delSched').select2();
	$('#delSY').select2();
	$('#delPlanModal').modal('show')
	
});

function delClose()
{
	document.location = '<?php echo base_url() ?>financemanagement/config/2'
}

$('#delItembtn').click(function()
{

	var yLvl = document.getElementById('delLvl').value;
	var yRemarks = document.getElementById('elogremarks').value;

	var xRemarks = 'Deleted Payment Item ['+yRemarks+']';
	document.getElementById('elogremarks').value = xRemarks;

	var epURL = "<?php echo base_url().'financemanagement/delItemPlan' ?>";
	$.ajax({
     type: "POST",
     url: epURL,
     data: $("#delItemForm").serialize(), 
     success: function(data){
     	alert("Done!!! The payment item was successfully deleted. A log regarding this transaction was also created and was sent to the administration for their referrence."); 
    document.location = '<?php echo base_url() ?>financemanagement/config/2'; 
     }
  });
});

// [shool year] = /financemanagement/config/2

</script>