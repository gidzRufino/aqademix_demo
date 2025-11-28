<?php
    // foreach($settings as $set){
    //     $sy = $set->school_year;
    // }
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>

<div class="clearfix">
	<div class="row">
		<div class="col-md-8">
			<h3>Finance Management Report - Expected Collection per Level</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="overflow-x:scroll;overflow-y:scroll; height: 500px;">
			<table class="table table-condensed table-bordered" style="width:98%;">
			<tr>
				<th class="text-center">Grade Level</th>

				<?php 
					foreach ($item_list as $items) {
						$idescription = $items->item_description;
				?>

				<th class="text-center"><?php echo $idescription ?></th>

				<?php
					} // foreach ($item_list as $items) {
				?>
				<th class="text-center">TOTAL</th>
			</tr>

				<?php

					$arrayofitems = array();
					foreach ($account_list as $accounts){
						$lvl = $accounts->grade_id;
						$pln = $accounts->plan_id;
						foreach ($init_list as $init){
							$ilvl = $init->level_id;
							$ipln = $init->plan_id;
							$genpln = 1;
							if (($lvl==$ilvl && $pln==$ipln) || ($lvl==$ilvl && $ipln==$genpln)){
								$iamount = $init->item_amount;
								$iid = $init->item_id;
								$arid = 'g'.$lvl.'i'.$iid;
								$arrayofitems[$arid] += $iamount;
							} // if ($lvl==$ilvl && $pln==$ipln) {
						} // foreach ($init_list as $init) {
					} // foreach ($account_list as $accounts) {

					foreach ($add_charge as $adc) {
						$ac_amount = $adc->d_charge;
						$ac_item = $adc->item_id;
						$ac_level = $adc->grade_id;
						$ac_key = 'g'.$ac_level.'i'.$ac_item;
						$arrayofitems[$ac_key] += $ac_amount;
					}

					$arrayoftotals = array();
					$totalitema = array();
					foreach ($grade_level as $level){
						$gradel = $level->level;
						$gid = $level->grade_id;
				?>

			<tr>
				<td class="text-center"><?php echo $gradel ?></td>

				<?php 

					foreach ($item_list as $ilist) {
						$itemi = $ilist->item_id;
						$itemd = $ilist->item_description;
						$akey = 'g'.$gid.'i'.$itemi;
						$itotamount = $arrayofitems[$akey];
						$ikey = 'i'.$itemi;
						$rkey = 'r'.$gid;
						$arrayoftotals[$ikey] += $itotamount;
						$totalitema[$rkey] += $itotamount;
				?>

				<td class="text-center"><?php echo number_format($itotamount, 2,".", ",") ?></td>

				<?php
					} // foreach ($item_list as $ilist) {
					$gkey = 'r'.$gid;
					$gtotal = $totalitema[$gkey];
				?>
				<th class="text-center"><?php echo number_format($gtotal, 2,".", ",") ?></th>
			</tr>

				<?php
					} // foreach ($grade_level as $level) {
				?>

			<tr>
				<td class="text-center"><b>TOTAL</b></td>

				<?php
					$grand_total = 0;
					foreach ($item_list as $tlist){
						$titem = $tlist->item_id;
						$t_id = 'i'.$titem;
						$tot_item_amount = $arrayoftotals[$t_id];
						$grand_total = $grand_total + $tot_item_amount;
				?>
				
				<th class="text-center" style="color:red;"><?php echo number_format($tot_item_amount, 2,".", ",") ?></th>

				<?php
					} // foreach ($item_list as $tlist){
				?>
				<th class="text-center" style="color:blue;"><?php echo number_format($grand_total, 2,".", ",") ?></th>
			</tr>
			</table>
		</div>
	</div>
</div>

