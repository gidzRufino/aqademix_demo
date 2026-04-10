<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header bg-primary">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Account Plan Details</h4>
    </div>
  	<div class="modal-body" style="overflow-y:scroll; height:400px;">

		<?php 
			if($splan_desc!=''){ // if plan already existed!
		?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-info">
	          <strong>Heads Up!</strong> Listed below are the payables assigned to this account's plan.
	        </div>
				</div>		
				<div class="col-md-12">
					<table class="table table-condensed table-bordered">
						<thead>
							<th class="text-center">Plan Description</th>
							<th class="text-center">Item Description</th>
							<th class="text-center">Total Amount</th>
							<th class="text-center">Payment Frequency (PF)</th>
							<th class="text-center">Amount per PF</th>
						</thead>

			    <?php 
	          $student_planID = $finance_plan->plan_id;
	          $splan = $finance_plan->plan_description;
	          $general_planID = 1;
	          $addAmount = 0;
	          $addmPayment = 0;             
	          $mPayment = 0; 
	          if ($stPlan_id!=null && $stPlan_id!=11){
	          foreach ($initialLevel as $iLevel) {
	            if($iLevel->level_id==$stLevel_id && $iLevel->sy_id==$sy_now && ($iLevel->plan_id==$student_planID || $iLevel->plan_id==$general_planID)){
	              $plan_itemID = $iLevel->item_id;
	              $planItemAmount = $iLevel->item_amount;
	              $splanItemAmount = number_format($planItemAmount,2);
	              $addAmount = $addAmount + $planItemAmount;
	              $splan_name = $iLevel->plan_description;
	              $splan_schedule = $iLevel->schedule_description;
	              $splan_item_description = $iLevel->item_description;
	              if($iLevel->schedule_id==1){
	                $mPayment = $planItemAmount/9; //monthly payment
	                $addmPayment = $addmPayment + $mPayment;
	                $mPayment = number_format($mPayment,2);
	              }elseif($iLevel->schedule_id==2){
	                $mPayment = $planItemAmount/4; //quarter payment
	                $addmPayment = $addmPayment + $mPayment;
	                $mPayment = number_format($mPayment,2);
	              }else{
	                $mPayment = $planItemAmount;
	                $mPayment = number_format($mPayment,2);
	              } 
	        ?>

	          <tr>
	            <td style="text-align:center"><?php echo $splan_name ?></td>
	            <td style="text-align:center"><?php echo $splan_item_description ?></td>
	            <td style="text-align:center"><?php echo $splanItemAmount ?></td>
	            <td style="text-align:center"><?php echo $splan_schedule ?></td>
	            <td style="text-align:center"><?php echo $mPayment ?></td>  <!-- /month, /quarter, on enrolment -->
	          </tr>

	              <?php } } } ?>

					</table>
				</div>
			</div>
			</div>
  	<div class="modal-footer">
  		<span>
        <button type="button" data-dismiss="modal" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i> close</button>
      </span>
    </div>

		<?php
			}else{  // if no plan existed yet!
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
                if($iLevel->level_id==$stLevel_id && $iLevel->sy_id==$sy_now && $iLevel->plan_id==$splanID){
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
		</div>
  	<div class="modal-footer">
      <div class="row">
      	<form id="saveplanform" action="" method="post">
      		<div class="col-md-12">
      			<input type="hidden" name="stud_id" id="stud_id" value="<?php echo $student_id ?>" required>
      			<span>
      				<select name="selectPlan" id="selectPlan" style="width: 175px;">
      					<option value"" selected="selected">Select a plan</option>

      					<?php
      						foreach ($planChoice as $key => $value) {
      							echo '<option value="'.$key.'">'.$value.'</option>';
      							# code...
      					}?>

      						<option value="11">Full Scholar</option>  <!-- check db for full scholar code -->

      				</select>&nbsp;
      				<button id="savePlanBtn" data-toggle="modal" onclick="savePlan()" aria-hidden="true" class="btn btn-sm btn-success">Save Plan</button>&nbsp;<button data-dismiss="modal" class="btn btn-danger btn-sm">Cancel</button>
      			</span>
      		</div>
      	</form>
      </div>
    </div>

		<?php
			}
		?>

  </div>
</div>


<script type="text/javascript">
  
$(document).ready(function() {
  $("#selectPlan").select2();
});

function savePlan()
{
  var plan_url = "<?php echo base_url().'financemanagement/saveAccountPlan' ?>";
  $.ajax({
     type: "POST",
     url: plan_url,
     data: $("#saveplanform").serialize(), 
     success: function(data){location.reload();}
  });
  
  alert("Success!!! The account is now enrolled to a payment plan.");  

}

 </script>