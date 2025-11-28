<?php
   $sy_used = $set_sy->value;
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>

<div class="clearfix row" style="margin:0;">
	<div id="editPlanModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<input type="hidden" name="sy_used" id="sy_used" value="<?php echo base64_encode($sy_used) ?>"required>
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header bg-primary">
	        <button type="button" class="close cancelbtn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Edit Payment Item</h4>
	      </div>

			<?php 
				foreach($editInitResult as $eiResult){
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
	        <form class="form-horizontal" id="editItemForm" name="editItemForm">
				<div class="control-group">			
	  			<label class="control-label" for="input">Item Description</label>
	  			<div class="controls">
	      		<span><select id="edititSelItem" name="edititSelItem" tabindex="-1" style="width: 100%;">   
	       			<option value="<?php echo $ei_item_id; ?>"><?php echo $ei_item ?></option>
	          	<?php foreach ($showItems as $initLev){ ?>  
	       			<option value="<?php echo $initLev->item_id; ?>"><?php echo $initLev->item_description; ?></option>
	          	<?php } ?> 
	    			</select></span>
	    		</div>
	  		</div>
	  		<div class="control-group">
	  			<label class="control-label" for="input">Payment Plan</label>
	  			<div class="controls">
			      <select id="edititPlan" name="edititPlan" tabindex="-1" style="width: 100%;">   
			      	<option value="<?php echo $ei_plan_id ?>"><?php echo $ei_plan ?></option>
			          <?php foreach ($showPlan as $sPlan){ ?>  
			      	<option value="<?php echo $sPlan->plan_id; ?>"><?php echo $sPlan->plan_description ?></option>
			          <?php } ?> 
			    	</select>
	    		</div>
	  		</div>
			  <div class="control-group">
			  	<label class="control-label" for="input">Enter Amount in PhP</label>
			  	<div class="controls">
			  		<input type="text" onblur="amountEntered()" style="width: 100%;" name="edititAmount" id="edititAmount" placeholder="<?php echo $ei_amount ?>" required>
			  	</div>
			  </div>
			  <div class="control-group">
			  	<label class="control-label" for="input">Implementation Frequency </label>
			    <div class="controls">
			      <select id="editSched" name="editSched" tabindex="-1" style="width: 100%;">   
			      	<option value="<?php echo $ei_freq_id ?>"><?php echo $ei_freq ?></option>
			          <?php foreach ($sfrequency as $sfreq){ ?>  
			      	<option value="<?php echo $sfreq->schedule_id; ?>"><?php echo $sfreq->schedule_description ?></option>
			              <?php } ?> 
		        </select>
		      </div>  
			  </div>
			  <div class="control-group">
			  	<label class="control-label" for="input">Select School Year</label>
			    <div class="controls">
			      <select name="editSY" id="editSY" tabindex="-1"  style="width: 100%;">   
			        <option value="<?php echo $ei_sy_id ?>"><?php echo $ei_sy ?></option>
			              <?php foreach ($school_year as $sy){ ?>  
			        <option value="<?php echo $sy->sy_id; ?>"><?php echo $sy->school_year ?></option>
			              <?php } ?> 	
			      </select>
			    </div>
			  </div>
			  	<input type="hidden" name="editImpDate"  style="width: 100%;" data-date-format="mm-dd-yy" id="editImpDate" required>
			  <div class="hidding">
			  	<input type="hidden" name="edititID" id="edititID" value="<?php echo $ei_init_id ?>"required>
			  	<input type="hidden" name="edititChCr" id="edititChCr" value="0" required>
			  	<input type="hidden" name="editLvl" id="editLvl" value="<?php echo $ei_level_id ?>" required>
			  	<input type="hidden" name="editLvln" id="editLvln" value="<?php echo $ei_level ?>" required>
			  </div>
			  <div class="hiddingLog">
				  <input type="hidden" name="elogdate" id="elogdate" value="<?php echo $elogtdate ?>"required>
				  <input type="hidden" name="elogaccount" id="elogaccount" value="<?php echo $userid ?>"required>
				  <input type="hidden" name="elogremarks" id="elogremarks" value="<?php echo $elogremarks ?>"required>
			  </div>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button id="saveEditItem" class="btn btn-success btn-sm"><i class="fa fa-save fa-fw"> </i> Save Changes</button>
		    <button id="cancelbtn" class="btn btn-danger btn-sm cancelbtn"><i class="fa fa-close fa-fw"> </i> Cancel</button>	
	      </div>
	    </div>
	  </div>
	  <?php } ?>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function()
{
	$('#edititSelItem').select2();
	$('#edititPlan').select2();
	$('#editSched').select2();
	$('#editSY').select2();
	$('#editPlanModal').modal('show')
	
});

function goback()
{
   var sy_ = document.getElementById('sy_used').value;
	document.location = '<?php echo base_url() ?>financemanagement/config/'+sy_;	
}

$('.cancelbtn').click(function()
{
   var sy_ = document.getElementById('sy_used').value;
	document.location = '<?php echo base_url() ?>financemanagement/config/'+sy_;
});

$('#saveEditItem').click(function()
{

	var eAmount = document.getElementById('edititAmount').value;
	var epAmount = document.getElementById('edititAmount').placeholder;
	var eiDate = document.getElementById('editImpDate').value;
	var epiDate = document.getElementById('editImpDate').placeholder;

	if(eAmount==''){
		document.getElementById('edititAmount').value = epAmount;
	}
	if(eiDate==''){
		document.getElementById('editImpDate').value = epiDate;
	}

	var xItem = document.getElementById('edititSelItem');
	var xPlan = document.getElementById('edititPlan');
	var xAmount = document.getElementById('edititAmount').value; 
	var xSched = document.getElementById('editSched');
	var xSY = document.getElementById('editSY');
	var xImp = document.getElementById('editImpDate').value;
	var yLvl = document.getElementById('editLvln').value;
	var yRemarks = document.getElementById('elogremarks').value;
   var sy_ = document.getElementById('sy_used').value;

	xItem = xItem.options[xItem.selectedIndex].text; // selected value displayed
	xPlan = xPlan.options[xPlan.selectedIndex].text;
	xSched = xSched.options[xSched.selectedIndex].text;
	xSY = xSY.options[xSY.selectedIndex].text;

	var xRemarks = 'Edited Payment Item from ['+yRemarks+'] to [Lvl:'+yLvl+', Pl:'+xPlan+', It:'+xItem+', Amt:'+xAmount+', Fq:'+xSched+', SY:'+xSY+', ImD:'+xImp;
	document.getElementById('elogremarks').value = xRemarks;

	var epURL = "<?php echo base_url().'financemanagement/saveEditItemPlan' ?>";
	$.ajax({
     type: "POST",
     url: epURL,
     data: $("#editItemForm").serialize(), 
     success: function(data){}
  }); 
   alert("Success!!! The item was successfully edited. A log regarding this transaction was also created and was sent to the administration for their referrence.");
   document.location = '<?php echo base_url() ?>financemanagement/config/'+sy_; 
});
// data: $("#saveTransaction").serialize(), 
//       success: function(data){location.reload();}
// [year default] = <?php echo base_url() ?>financemanagement/config/2 

</script>