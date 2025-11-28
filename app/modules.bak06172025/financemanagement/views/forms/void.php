<?php
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>


<script type="text/javascript">
	
  function look_up()
  {
    var ref_id = document.getElementById("search_trans").value;
    // alert(ref_id);
    var trans_options = 'Lookup Transaction Ref #'
    if (ref_id==trans_options){
    	document.location = '<?php echo base_url()?>financemanagement/void/'   
    }else{
    	document.location = '<?php echo base_url()?>financemanagement/void/'+ref_id   
    }
  }

</script>

<div class="clearfix row" style="margin:0;">
	<div class="panel panel-primary" style="margin-top: 15px;">
		<div class="panel-heading">
			<h3 class="panel-title">Finance Management - Void Transaction</h3>
			<div class="pull-right">
				<button onclick="open_account()" type="button" style="margin-top: -40px;" class="btn btn-info btn-sm">Open Account</button>
			</div>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<div class="col-md-5">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Void Transaction</h3>
						</div>
						<div class="panel-body">
							<div class="control-group pull-left">
				            <label class="control-label" for="lookup_ref">Enter Referrence number to Void</label>
					            
		                	<div class="span3">
		                		<select onclick="look_up()" tabindex="-1" id="search_trans" style="width:225px;" >   
					               <option>Lookup Transaction Ref #</option>
					                  <?php foreach ($transactions as $trans){$id = $trans->trans_id; ?>  
					                <option value="<?php echo base64_encode($id); ?>"><?php echo $id; ?></option>
					                  <?php } ?> 
					            </select>
		                	</div>
		               </div>
		            </div>
					</div>
				</div>
				<div class="col-md-7">

					<?php if($this->uri->segment(3)==''){ ?>

					<div class="alert alert-warning ">
	        			<p style="text-align:Justify;font-size: 14px;"><strong>Warning!!!</strong> Voided transactions can never be retrieved again. A notification will also be sent to the admin regarding this transaction. </p>
	      		</div>

	      		<?php }elseif ($this->uri->segment(3)!=''){  ?>

	      		<div class="trans_show">
	            		<div class="row" style="margin-left:0px;">

	            		<?php 

	            		$stud_id = $tlookup->stud_id;
	            		$trans_ref = $tlookup->trans_id;
	            		foreach ($get_accounts as $ga) {
	            			if($ga->stud_id == $stud_id){ ?>

	            				<h5 style="color:black; margin: 0 0 0 0px;"><b>Name:</b> &nbsp;<span style="color:#BB0000;"><?php echo $ga->firstname ." ".$ga->middlename ." ".$ga->lastname;?></span></h5>
							    <h6 style="color:black; margin: 0 0 0 0px;"><b>Student ID:</b> &nbsp;<span style="color:#BB0000;"><?php echo $ga->st_id;?></span> </h6>
							    <h6 style="color:black; margin: 0 0 0 0px;"><b>Grade Level:</b> &nbsp;<span style="color:#BB0000;"><?php echo $ga->level;?></span> </h6>
							    <h6 style="color:black; margin: 0 0 0 0px;"><b>Transaction Number: </b>&nbsp;<span style="color:#BB0000;"><?php echo $tlookup->trans_id;?></span>&nbsp; <b>Date:</b> &nbsp;<span style="color:#BB0000;"><?php echo $tlookup->tdate;?></span> </h6>

	            			<?php }	            			
	            		} ?>
	            			
	            		</div>
	            		
	            		<div class="">

	            			<div class="well well-small" style="margin-top: 10px;">
	            				<h4>Transaction Details</h4>
	            				<form id="voidform" action="" method="post">
		            			<table class="table table-hover table-bordered table-condensed">
		            				<tr>
		            					<th style="text-align:center">Description</th>
		            					<th style="text-align:center">Charge</th>
		            					<th style="text-align:center">Credit</th>
		            				</tr>

		            			<?php 

		            			$tot_charge = 0;
		            			$tot_credit = 0;
		            			$dc = 0;
		            			$elogtdate = date("F d, Y [g:i:s a]");
		            			$vdetails = '';

		            			foreach($tdetails as $tl){ 

		            				$trans_refs = $tl->trans_id;

		            				if ($trans_refs==$trans_ref){
		            					$dc = $dc + 1;
		            					$dtl_id = $tl->detail_id;
		            			?>	
		            				
		            				<tr>
		            					<td style="text-align:center"><?php echo $tl->item_description ?></td>
		            					<td style="text-align:center"><?php echo number_format($tl->d_charge, 2) ?></td>
		            					<td style="text-align:center"><?php echo number_format($tl->d_credit, 2) ?></td>
		            				</tr>
		            				<input type="hidden" name="detail_id<?php echo $dc ?>" id="detail_id<?php echo $dc ?>" value="<?php echo $dtl_id ?>"required>
		            			<?php 

		            				$tot_charge = $tot_charge + $tl->d_charge;
		            				$tot_credit = $tot_credit + $tl->d_credit;

		            				$vdetails = $vdetails.' '.$dc.'. '.$tl->item_description.' charge: '.$tl->d_charge.' credit: '.$tl->d_credit;  

		            			}} ?>
		            				<tr>
		            					<th style="text-align:right">T O T A L</th>
		            					<th style="text-align:center"><?php echo number_format($tot_charge, 2) ?></th>
		            					<th style="text-align:center"><?php echo number_format($tot_credit, 2) ?></th>
		            				</tr>
		            			</table>

		            				<?php 

		            					$elogremarks = 'VOID Transaction: '.$trans_ref.' Details: '.$vdetails.' total charge: '.$tot_charge.' total credit: '.$tot_credit; 
		            				
		            				?>
		            				
		            				<div class="hiddingLog">
		            					<input type="hidden" name="vtrans_id" id="vtrans_id" value="<?php echo $trans_ref ?>"required>
		            					<input type="hidden" name="last_void" id="last_void" value="<?php echo $dc ?>"required>
									  	<input type="hidden" name="elogdate" id="elogdate" value="<?php echo $elogtdate ?>"required>
									  	<input type="hidden" name="elogaccount" id="elogaccount" value="<?php echo $userid ?>"required>
									  	<input type="hidden" name="elogremarks" id="elogremarks" value="<?php echo $elogremarks ?>"required>
									</div>
		            			</form>
		            			<div class="row">
			            			<div class="span3 pull-right">
			            				<button onclick="cancel_trans()" type="button" class="btn btn-danger btn-small">Cancel</button>
			            				<button onclick="void_trans()" type="button" class="btn btn-primary btn-small"> VOID TRANSACTION</button>
			            			</div>
	            				</div>
		            		</div>
	            		</div>
	            	</div>
	            	<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="confirm_void" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger">
		      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      		<h4 class="modal-title" id="myModalLabel">Confirm Transaction Void</h4>
			</div>
			<div class="modal-body">
				<h4 style="color:red;">Warning!!! Voided transaction can never be retreived again. Do you really want to void this transaction? A notification will be sent to the admin if you continue.</h4>
			</div>
		</div>
	   <div class="modal-footer">
	      <button class="btn btn-danger" id="cancel_void" name="cancel_void" data-dismiss="modal" aria-hidden="true">Cancel</button>
	      <button id="void_now" data-dismiss="modal" class="btn btn-success">Void this transaction</button>
	      <div id="resultSection" class="help-block" ></div>
	   </div>
	</div>
</div>	


<script type="text/javascript">

$(document).ready(function() {
    $("#search_trans").select2();
  });

  function look_up()
  {
    var ref_id = document.getElementById("search_trans").value;
    // alert(ref_id);
    var trans_options = 'Lookup Transaction Ref #'
    if (ref_id==trans_options){
    	document.location = '<?php echo base_url()?>financemanagement/void/'   
    }else{
    	document.location = '<?php echo base_url()?>financemanagement/void/'+ref_id   
    }
  }

  function open_account()
  {
  	document.location = '<?php echo base_url()?>financemanagement/actz/'  
  }

  function void_trans()
  {
  	$("#confirm_void").modal();
  }

  $('#void_now').click(function()
  {
  	var url1 = "<?php echo base_url().'financemanagement/void_transaction' ?>";

  	$.ajax({
       type: "POST",
       url: url1,
       data: $("#voidform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), 
       success: function(data){
       	document.location = '<?php echo base_url()?>financemanagement/void'
       	alert("Void transaction successful.");
       }
    });
  });

</script>