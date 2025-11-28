<script type="text/javascript">
  $(document).ready(function() {
    $("#selectPlan").select2();
  });

</script>

<div class="modal-dialog modal-lg">
  	<div class="modal-content">
    	<div class="modal-header bg-primary">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      	<h4 class="modal-title" id="myModalLabel">Update Finance Account Plan</h4>
    	</div>
  	<div class="modal-body" style="overflow-y:scroll; height:400px;">

	<?php 
		if($splan_desc!=''){ // if plan already existed!
	?>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-danger" style="margin-bottom: 0px;">
			      <div class="panel-heading">
			        <strong>Warning!!! </strong>This account was currently enrolled to <strong><?php echo $splan_desc; ?>&nbsp;payment plan</strong>. Select the desired plan below if you wish to change it.
			      </div>  
			      <div class="panel-body">
			      	<div class="col-md-12">
			      		<table class="table table-condensed table-bordered table-hover">
			      			<thead>
			      				<th class="text-center bg-info">Plan Description</th>
			      				<th class="text-center bg-info">Item</th>
			      				<th class="text-center bg-info">Total Amount</th>
			      				<th class="text-center bg-info">Amount per PF</th>
			      			</thead>

									<?php
			              $planChoice = array();
			              $planPointer = 1;
			              $general_amount = 0;
			              $planandgeneral_amount = 0;
			              $generalMonthly_amount = 0;
			              $planandgeneral_monthlyamount = 0;
			              foreach ($showPlan as $sPlan) {  
			                $addAmount = 0;
			                $addmPayment = 0;             
			                $planExist = 0;
			                $splanID = $sPlan->plan_id;
			                $mPayment = 0; 

			                foreach ($initialLevel as $iLevel) {
			                  
			                  if($iLevel->level_id==$stLevel_id && $iLevel->plan_id==$splanID){
			                    $plan_itemID = $iLevel->item_id;
			                    $planExist = 1;
			                    $planItemAmount = $iLevel->item_amount;
			                    $addAmount = $addAmount + $planItemAmount;
			                    $splan_name = $sPlan->plan_description;
			                    $splan_id = $sPlan->plan_id;
			                    foreach ($showItems as $sItems){
			                      if($sItems->item_id==$plan_itemID){
			                        $planItemDescription = $sItems->item_description;
			                      }
			                    }
			                    if($iLevel->schedule_id==1){
			                      $mPayment = $planItemAmount/9; //monthly payment
			                      $addmPayment = $addmPayment + $mPayment;
			                      $mPayment = number_format($mPayment,2);
			                    }else{
			                      $mPayment = '-';
			                    }
			            ?>

			            <tr>
			            	<td class="text-center"><?php echo $splan_name ?></td>
			            	<td class="text-center"><?php echo $planItemDescription ?></td>
			            	<td class="text-center"><?php echo number_format($planItemAmount, 2) ?></td>
			            	<td class="text-center"><?php echo $mPayment ?></td>
			            </tr>

			            <?php }} if($planExist==1){ ?>

			            <tr>
			            	
			            	<?php if($splan_name=='General'){ 
			                $general_amount = $addAmount;
			                $generalMonthly_amount = $addmPayment;
			              ?>
			            
			              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b>Total General charge add-on for all Plans</b></td>  
			              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?></b></td>
			              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?></b></td>

			              <?php }else{ 
			                $planChoice[$splan_id] = $splan_name; 
			                $planPointer = $planPointer + 1;
			                $planandgeneral_amount = $general_amount + $addAmount;
			                $planandgeneral_monthlyamount = $generalMonthly_amount + $addmPayment;

			              ?>
			            
			              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b> Overall TOTAL for &nbsp;<?php echo $splan_name ?></b>&nbsp;<i><span style="color:#BB0000;">(with General charges)</span></i></td>  
			              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_amount,2)?>)</span></i></td>
			              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_monthlyamount,2)?>)</span></i></td>
			            </tr>
	         
	            <?php }}} ?>

			      		</table>
			      	</div>
			      	<div class="col-md-12">
			      	<form id="saveEditplanform" action="" method="post">
			          	<div class="offset1">
			            	<div class="alert alert-info alert-dismissable" style="padding-bottom:32px;">
			              		<div class="pull-right">
			                		<input type="hidden" name="inputplan_studID" id="inputplan_studID" value="<?php echo $student_id ?>" required>
			                		<input type="hidden" name="input_planAccountID" id="input_planAccountID" value="<?php echo $studentAccountID ?>" required>
			                		<span>
			                  		<select style="width:175px; margin-bottom:15px;" name="inputplanID" tabindex="-1" id="inputplanID" class="span2">
			          	          		<option value="" selected="selected">Select a plan</option>
					                   		 <?php
					                     		foreach($planChoice as $key => $value){
					                        	echo '<option value="'.$key.'">'.$value.'</option>';
					                    		} ?>
			                    			<option value="11" >Full Scholar</option> <!-- full scholar code check db -->
			                  		</select>
			                  		<button id="saveEditPlanBtn" data-toggle="modal" onclick="saveEditPlan()" aria-hidden="true" style="margin-bottom: 10px;" class="btn btn-sm btn-success"><i class="icon-ok icon-white"></i> Save Plan</button>&nbsp;<button data-dismiss="modal" type="button"style="margin-bottom: 10px;" class="btn btn-danger btn-sm"><i class="icon-remove icon-white"></i> Cancel</button>
			                		</span> 
			              		</div>
			            	</div>
			          	</div>
			        	</form>
			        	</div>
			        	<div class="col-md-12">
				        	<div class="alert alert-danger">
				        		<strong>Warning!!! </strong>The administration will be notified if you made changes to this account's plan.
				        	</div>
				      </div>
			      </div> <!-- panel-body -->
		    	</div>
			</div>	
		</div>
		

	<?php
		}else{
	?>		

		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-danger">
          		<strong>Heads Up!</strong> This account was not enrolled to any existing plan. Select the desired plan below and save it.
        		</div>
			</div>		
			<div class="col-md-12">
				<table class="table table-condensed table-bordered">
					<thead>
						<th class="text-center">Plan Description</th>
						<th class="text-center">Item</th>
						<th class="text-center">Total Amount</th>
						<th class="text-center">Monthly</th>
					</thead>

						<?php
	            $planChoice = array();
	            $planPointer = 1;
	            $general_amount = 0;
	            $planandgeneral_amount = 0;
	            $generalMonthly_amount = 0;
	            $planandgeneral_monthlyamount = 0;
	            foreach ($showPlan as $sPlan) {  
	              $addAmount = 0;
	              $addmPayment = 0;             
	              $planExist = 0;
	              $splanID = $sPlan->plan_id;
	              $mPayment = 0; 
	              foreach ($initialLevel as $iLevel) {
	                if($iLevel->level_id==$stLevel_id && $iLevel->plan_id==$splanID && $iLevel->sy_id == $sy_now){
	                  $plan_itemID = $iLevel->item_id;
	                  $planExist = 1;
	                  $planItemAmount = $iLevel->item_amount;
	                  $addAmount = $addAmount + $planItemAmount;
	                  $splan_name = $sPlan->plan_description;
	                  $splan_id = $sPlan->plan_id;
	                  foreach ($showItems as $sItems){
	                    if($sItems->item_id==$plan_itemID){
	                      $planItemDescription = $sItems->item_description;
	                    }
	                  }
	                  if($iLevel->schedule_id==1){
	                    $mPayment = $planItemAmount/9; //monthly payment
	                    $addmPayment = $addmPayment + $mPayment;
	                    $mPayment = number_format($mPayment,2);
	                  }else{
	                    $mPayment = '-';
	                  }
	          ?>

	          <tr>
	          	<td class="text-center"><?php echo $splan_name ?></td>
	          	<td class="text-center"><?php echo $planItemDescription ?></td>
	          	<td class="text-center"><?php echo number_format($planItemAmount, 2) ?></td>
	          	<td class="text-center"><?php echo $mPayment ?></td>
	          </tr>

	          <?php }} if($planExist==1){ ?>

	          <tr>

	          	<?php if($splan_name=='General'){ 
	              $general_amount = $addAmount;
	              $generalMonthly_amount = $addmPayment;
	            ?>
	          
	            <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b>Total General charge add-on for all Plans</b></td>  
	            <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?></b></td>
	            <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?></b></td>

	            <?php }else{ 
	              $planChoice[$splan_id] = $splan_name; 
	              $planPointer = $planPointer + 1;
	              $planandgeneral_amount = $general_amount + $addAmount;
	              $planandgeneral_monthlyamount = $generalMonthly_amount + $addmPayment;

	            ?>
	          
	            <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b> Overall TOTAL for &nbsp;<?php echo $splan_name ?></b>&nbsp;<i><span style="color:#BB0000;">(with General charges)</span></i></td>  
	            <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_amount,2)?>)</span></i></td>
	            <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_monthlyamount,2)?>)</span></i></td>
	            <!-- <td colspan ="2"></td> -->
	          </tr>
	       
	          <?php }}} ?>

				</table>
			</div>
		</div>
		<div class="modal-footer">
	      <div class="row">
	      	<!-- <form id="saveplanform" action="" method="post"> -->
	      		<div class="col-md-12">
	      			<input type="hidden" name="stud_id" id="stud_id" value="<?php echo $student_id ?>" required>
	      			<input type="hidden" name="sy_id" id="sy_id" value="<?php echo $sy_now ?>" required>
	      			<input type="hidden" name="selPlan" id="selPlan"  required>
	      			<span>
	      				<select name="sealPlan" id="sealPlan" tabindex="-1" onclick="testme()" style="width: 175px;">
	      					<option value='#' >Select a plan</option>

	      					<?php
	      						foreach ($planChoice as $key => $value) {

	      					?>

	      					<option value="<?php echo $key ?>"><?php echo $value ?></option>
	      							
	      					<?php } ?>

	      						<option value="11">Full Scholar</option>  <!-- check db for full scholar code -->

	      				</select>&nbsp;
	      				<button id="savePlanBtn"  onclick="savePlan()" data-dismiss="modal" class="btn btn-sm btn-success">Save Plan</button>&nbsp;<button data-dismiss="modal" class="btn btn-danger btn-sm">Cancel</button>
	      			</span>
	      		</div>
	      	<!-- </form> -->
	      </div>
	   </div>

	<?php } ?>
	
		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
	  $("#inputplanID").select2();
	  $("#selectPlan").select2();
	});

	function saveEditPlan()
  {
  
    var eplan_url = "<?php echo base_url().'financemanagement/saveEditPlan' ?>";
    $.ajax({
       type: "POST",
       url: eplan_url,
       // data: $("#saveEditplanform").serialize(), 
       data: $("#saveEditplanform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), 
       success: function(data){location.reload();}
    });
    
    alert("Success!!! The plan was successfully edited. A notification has also been sent to the administration.");  
    
  }

   $("#sealPlan").on('change', function(){
      // alert(this.value);
      document.getElementById('selPlan').value = this.value;
   });

	function savePlan()
	{
	
		var selPlan = document.getElementById('selPlan').value; // document.getElementById("selPlan").value;
		var sy_id = document.getElementById('sy_id').value;
		var stud_id = document.getElementById('stud_id').value;
		// alert('This is the year id: '+sy+' and this is the stud_id:' +st_id+ ' the plan id is: '+selplan);

		if (selPlan!=''){
			var plan_url = "<?php echo base_url().'financemanagement/saveAccountPlan' ?>";
		  	$.ajax({
		     type: "POST",
		     url: plan_url,
		     data: 'selPlan='+selPlan+"&sy_id="+sy_id+"&stud_id="+stud_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), 
		     // data: $("#editItemForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), 
		     success: function(data){location.reload();
		     	alert("Yey!!! Success!!! The account is now enrolled to a payment plan.");  
		     }
		  	});
 			alert('this went through');
		}else{
			alert('Please select plan to continue.');
		}
	}

</script>

<!-- data: 'section_id='+section_id+"&subject_id="+subject_id+"&term="+term+'&csrf_test_name='+$.cookie('csrf_cookie_name'), -->