<?php
   $stngs=Modules::run('main/getSet');
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   
?>

<script type="text/javascript">
   $(function(){
      $("#sorting").tablesorter({debug: true});
   });  
 //   $(document).ready(function(){
	// 	$('#startdate').datepicker();
	// 	$('#enddate').datepicker();
	// });
</script>

<div class="clearfix">
	
	<div class="row" style="margin-top: 15px;">
		<div class="col-md-12">
			<div class="col-xs-4">
				<h3 style="margin-top: 0px;"><b>Lists of Transactions</b></h3>
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
				<button class="btn btn-success" id="searchtrans"  style="font-size: 12px; width: 100%; margin-left: -4px;" type="button"><b>Fetch</b></button>
			</div>
		</div>
	</div>
	<!-- <?php // if ($this->uri->segment(3)!=''){ ?> -->
	<div class="row">
		<div class="col-md-12" style="overflow-x:scroll;overflow-y:scroll; height: 500px;">
			<table id="sorting" class="table table-condensed table-bordered">
				<tr class="bg-primary">
					<th class="text-center">Referrence Number</th>
					<th class="text-center">Transaction Number</th>
					<th class="text-center">Date</th>

					<?php 
						$d_array = array();
						$tot_item = array();
						$itemcount = 0;
						foreach($sitems as $si){
							$slist = $si->item_description;
							$sid = $si->item_id;
							$d_array[$sid] = $sid;
							$tot_item[$sid] = 0;
							$itemcount++;
					?>	

					<th class="text-center" id="<?php echo $sid ?>"><?php echo $slist ?></th>	
					
					<?php } ?>
					<th class="text-center">Remarks</th>
				</tr>

					<?php 
						$transCount = 0;
						foreach ($strans as $strans) {
							$refNum = $strans->ref_number;
							$transNum = $strans->trans_id;	
							$tdate = $strans->tdate;
							$tcreds = $strans->tcredit;
							$tremarks = $strans->tremarks;
							$sstud_id = $strans->stud_id;
							if($tcreds!=0 && $refNum!='0000'){
							$transCount++;
					?>

				<tr>
					<td class="text-center"><?php echo $refNum ?></td>
					<td class="text-center"><a href="<?php echo base_url('financemanagement/s8347h/'.base64_encode($sstud_id)) ?>"><?php  echo $transNum ?></a></td>
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
										$tot_item[$dkey] += $ivalue;
										$d_amount = number_format($d_amount, 2,".",",");
										$skey = $dkey;
										break;
									}else{
										$d_amount = "";
									}
								}
					?>

					<td class="text-center" id="<?php echo $refNum.'-'.$dkey ?>"><?php echo $d_amount ?></td>
					
					<?php
						}	
					?>	

					<td class="text-center"><?php echo $tremarks ?></td>

					<?php }} ?>
					
				</tr>
				
				<?php 
					$fsdate = $this->uri->segment(3);
					$st = substr($fsdate,0,10);
    				$fn = substr($fsdate,11,21);
    				if($transCount>=10){
				?>
				
				<tr class="bg-primary">
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

					<th class="text-center">GRAND TOTAL</th>

					<?php } 
					if($transCount>=1){
					?>
					
				</tr>	
				<tr class="bg-primary">
					<th colspan="3" class="text-right" style="color:yellow;">TOTAL from <?php echo $st ?> to <?php echo $fn ?></th>
				
				<?php 
					$item_total = 0;
					foreach ($d_array as $dkey => $dvalue) {
						$item_total = $item_total + $tot_item[$dkey];
				?>
					
					<th class="text-center"><?php echo number_format($tot_item[$dkey], 2,".",",") ?></th>

				<?php
					}
				?>

					<th class="text-center"><?php echo number_format($item_total, 2,".",",") ?></th>
				</tr>

				<?php 
					}else if($transCount==0){
						$colnums = $itemcount + 4;
				?>

				<tr class="bg-danger">
					<th colspan="<?php echo $colnums ?>" class="text-center">Sorry, no transaction found. Please select transaction date range and try again. </th>
				</tr>

				<?php
					}
				?>

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

