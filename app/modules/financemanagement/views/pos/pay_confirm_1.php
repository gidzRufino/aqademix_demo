<?php 
$neut_not = urldecode($this->uri->segment(5));
?>
<div class="clearfix" style="margin:0px;">
	<div class="col-md-1"></div>
	<div class="col-md-6">
	  	<div class="panel panel-success" style="margin-top: 15px;">
	    	<div class="panel-heading text-center">
	      	<h3 class="panel-title"><b>Transaction Payment Confirmation</b></h3>
	    	</div>
	    	<input type="hidden" name="trans_num" id="trans_num" value="<?php echo base64_encode($tlookup->trans_id) ?>" required>

	    	<?php 
	    		$school_year = $get_accounts->school_year;
	    		if ($school_year = 2014){
	    			$sy_select = 2;
	    		}elseif ($school_year = 2015){
	    			$sy_select = 3;
	    		}elseif ($school_year = 2016){
	    			$sy_select = 4;
	    		}elseif ($school_year = 2017){
	    			$sy_select = 5;
	    		}elseif ($school_year = 2018) {
	    			$sy_select = 6;
	    		}else{
	    			$sy = NULL;
	    		}
	    	?>

	    	<input type="hidden" name="sy_id" id="sy_id" value="<?php echo base64_encode($sy_select) ?>" required>
	    	<div class="panel-body">
	    		<h3 style="color:green;">This transaction was successfully saved!</h3>	
	    		<div class="col-md-12"><b style="color:black;">Transaction Number:</b> &nbsp;<span style="color:#BB0000;"><?php echo $tlookup->trans_id?>&nbsp;<b style="color:black;">OR Number:</b> &nbsp;<span style="color:#BB0000;"><?php echo $tlookup->ref_number?></div>				
	    		<div class="row" style="margin-left:30px;">

         		<?php 

		      		$stud_id = $tlookup->stud_id;
		      		$trans_ref = $tlookup->trans_id;
              $test_account = substr($neut_not, 0, 4);

              if ($test_account=='NEA:') {
                $nea_description = substr($neut_not, 4);
            ?>
              <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $neut_not ?>" required>
             <h5 style="color:black; margin: 0 0 0 0px;"><b>Acount Description:</b> &nbsp;<span style="color:#BB0000;"><?php echo $nea_description; ?></span></h5>
             <h6 style="color:black; margin: 0 0 0 0px;"><b>Account type:</b> &nbsp;<span style="color:#BB0000;">Neutral Account</span> </h6>
             <h6 style="color:black; margin: 0 0 0 0px;"><b>Date:</b> &nbsp;<span style="color:#BB0000;"><?php echo $tlookup->tdate;?></span> </h6>
            <?php

              }else{
         		   
         		?>
            <input type="hidden" name="stud_id" id="stud_id" value="<?php echo base64_encode($tlookup->stud_id) ?>" required>
         		<h5 style="color:black; margin: 0 0 0 0px;"><b>Name:</b> &nbsp;<span style="color:#BB0000;"><?php echo $get_accounts->firstname ." ".$get_accounts->middlename ." ".$get_accounts->lastname;?></span></h5>
					  <h6 style="color:black; margin: 0 0 0 0px;"><b>Student ID:</b> &nbsp;<span style="color:#BB0000;"><?php echo $stud_id?></span> </h6>
					  <h6 style="color:black; margin: 0 0 0 0px;"><b>Grade Level:</b> &nbsp;<span style="color:#BB0000;"><?php echo $get_accounts->level;?></span> </h6>
					  <h6 style="color:black; margin: 0 0 0 0px;"><b>Date:</b> &nbsp;<span style="color:#BB0000;"><?php echo $tlookup->tdate;?></span> </h6>

             <?php 

              }

            ?>

      		</div>
	    		<div class="well well-small" style="margin-top: 10px;">
	            <h4>Transaction Details</h4>
	            
	         	<table class="table table-hover table-bordered table-condensed">
      				<tr>
      					<th style="text-align:center">Description</th>
      					<!-- <th style="text-align:center">Charge</th> -->
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
      					<!-- <td style="text-align:center"><?php echo number_format($tl->d_charge, 2) ?></td> -->
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
      					<!-- <th style="text-align:center"><?php echo number_format($tot_charge, 2) ?></th> -->
      					<th style="text-align:center"><?php echo number_format($tot_credit, 2) ?></th>
      				</tr>
      			</table>
      			<div class="row">
         			<div class="span3 pull-right">
         				<button onclick="dashboard()" type="button" class="btn btn-success btn-small">Back to Dashboard</button>
         				<button onclick="print_or()" type="button" class="btn btn-primary btn-small" style="autofocus:autofocus;"> PRINT to OR</button>
         			</div>
   				</div>
      		</div>
	    	</div>
	   </div>
	</div>
	<div class="col-md-5">
		<div id="d_report" class="panel panel-success" style="display:none; margin-top: 15px;">
		   <div class="panel-heading text-center">
		     <h3 id="report_header" class="text-center panel-title"><b></b></h3>
		   </div>
	    	<div class="panel-body">
	      	<iframe class="" style="display:none; margin-top:10px;" id="report_iframe" width="100%" height="400" src=""></iframe>
	    	</div>
	  	</div>
   </div>
</div>



<script type="text/javascript">
	
	function dashboard()
  {
    document.location = '<?php echo base_url()?>financemanagement/pos/'
  }

  function print_or()
  {
  	var tnumber = document.getElementById('trans_num').value;
  	var stud_id = document.getElementById('stud_id').value;
  	var sy_id = document.getElementById('sy_id').value;
  	var url = '<?php echo base_url() ?>financemanagement/pay_confirm/'+tnumber+'/print/'+stud_id+'/'+sy_id;
  	// document.location = url;
    	$('#loading').removeClass('hide');
    	$('#loading').html('<img src="<?php echo base_url()?>images/loading.gif" style="width:200px" />');
    	document.getElementById('report_header').innerHTML = '<b>OR Printing Preview</b>';
    	document.getElementById('report_iframe').src = url;
    	$('#report_iframe').attr('onload', 'iframeloaded()');
    	document.getElementById('report_iframe').Window.location.reload(true);
    	window.open(url, '_blank');
    	document.title = 'Collection Notice';
  }

  function iframeloaded()
  {
    $('#secretContainer').hide()
    $('#loading').hide();
    $('#d_report').show();
    $('#report_iframe').show();
  }

</script>

