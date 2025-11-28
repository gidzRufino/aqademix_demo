<?php
   $stngs=Modules::run('main/getSet');
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   
?>

<script type="text/javascript">
 //   $(function(){
 //      $("#sorting").tablesorter({debug: true});
 //   });  
 //   $(document).ready(function(){
	// 	$('#startdate').datepicker();
	// 	$('#enddate').datepicker();
	// });
</script>

<div class="clearfix">
	
	<div class="row">
		<div class="col-md-12">
			<div class="col-xs-4">
				<h4><b>Lists of Transactions</b></h4>
			</div>
			<div class="col-xs-3">
				<!-- <h5 style="margin-bottom: 0px;"><b>Start date</b></h5> -->
	         <input name="startdate" style="color: black; width: 80%;" type="text" data-date-format="mm-dd-yyyy" id="startdate" placeholder="Start Date" required>
	         <button class="btn btn-info" id="scal"  style="font-size: 8px; width: 20%; margin-left: -4px; height: 26px; margin-top: -2px;" onclick="$('#startdate').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button>
			</div>
			<div class="col-xs-3">
				<!-- <h5 style="margin-bottom: 0px;"><b>End date</b></h5> -->
	         <input name="enddate" style="color: black; width: 80%;" type="text" data-date-format="mm-dd-yyyy" id="enddate" placeholder="End Date" required>
	         <button class="btn btn-info" id="ecal"  style="font-size: 8px; width: 20%; margin-left: -4px; height: 26px; margin-top: -2px;" onclick="$('#enddate').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button>
			</div>
			<div class="col-xs-2">
				<button class="btn btn-success" id="searchtrans"  style="font-size: 12px; width: 100%; margin-left: -4px; height: 26px;" type="button">Fetch</button>
			</div>
		</div>
	</div>
	<!-- <?php // if ($this->uri->segment(3)!=''){ ?> -->
	<div class="row">
		<div class="col-md-12">
			<table id="sorting" class="table-condensed table-bordered">
				<tr>
					<th class="text-center">Referrence Number</th>
					<th class="text-center">Transaction Number</th>
					<th class="text-center">Date</th>

					<?php 
						$d_array = array();
						foreach($sitems as $si){
							$slist = $si->item_description;
							$sid = $si->item_id;
							$d_array[$sid] = $sid;

					?>	

					<th class="text-center" id="<?php echo $sid ?>"><?php echo $slist ?></th>	
					
					<?php } ?>
					
				</tr>

					<?php 
						foreach ($strans as $strans) {
							$refNum = $strans->ref_number;
							$transNum = $strans->trans_id;	
							$tdate = $strans->tdate;
							$tcreds = $strans->tcredit;
							if($tcreds!=0){
					?>

				<tr>
					<td class="text-center"><?php echo $refNum ?></td>
					<td class="text-center"><?php  echo $transNum ?></td>
					<td class="text-center"><?php echo $tdate ?></td>

					<?php
							// $item_array = null;
							$item_array = array();
							foreach ($sdetail as $sd) {
								$dtransID = $sd->trans_id;			
								if($transNum==$dtransID){
									$ditem = $sd->item_id;
									$dcredit = $sd->d_credit;
									$item_array[$ditem] = $dcredit;
								}
							}

							foreach ($d_array as $dkey => $dvalue) {
								foreach ($item_array as $ikey => $ivalue) {
									if($dkey==$ikey){
										$d_amount = $ivalue;
										$d_amount = number_format($d_amount, 2,".",",");
										break;
									}else{
										$d_amount = "";
									}
								}
					?>

					<td class="text-center"><?php echo $d_amount ?></td>
					
					<?php
								
							}
						}	}

					?>	

				</tr>
			</table>		
		</div>
	</div>
		<!--	<?php //} ?> -->	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#startdate').datepicker();
		$('#enddate').datepicker();
	});

	$("#searchtrans").click(function(){
		var sdate = document.getElementById('startdate').value;
		var edate = document.getElementById('enddate').value;

		var combine = sdate + '-' + edate;
		document.location = '<?php echo base_url()?>financemanagement/details/' + combine;
		$("#sorting").tablesorter({debug: true});
	});
</script>

