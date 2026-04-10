<!-- <script type="text/javascript">
	$(document).ready(function(){
		$(".table").tablesorter({debug: true});
	});
</script> -->


<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<!-- <div class="page-header" style="margin-top: 15px;"> -->
			<h1>Library Module <small>Dashboard</small></h1>					
		<!-- </div>  -->

		<!-- <div class="row" style="margin-bottom: 10px;">
			<div class="col-md-8 col-md-offset-2">
				<div class="input-group">
					<div class="col-md-9">	
						<select id="ebk_property" name="ebk_property" tabindex="-1" style="width:400px;">
							<option style="width:400px;">Search Item</option>
								<?php foreach ($bk_lib_general as $blg) { ?>
							<option style="width:400px;" value="<?php echo base64_encode($blg->gb_id) ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->au_name.' | Vol.'.$blg->gb_volume.' | Dewey: ['.$blg->dwc_cat_id.'] '.$blg->dwc_description ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="col-md-3">x
						<button class="btn btn-primary btn-sm" id="display_now" type="button">Display Item Now!</button> 
					</div>
				</div>
			</div>
		</div>		 -->		

		<div class="well" style="margin-bottom: 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-primary" onclick="gobooks()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-book fa-5x"></i><br/>
						 	<h4>Items</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-info" onclick="goaccounts()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-group fa-5x"></i><br/>
						 	<h4>Accounts</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-success" onclick="golend()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-road fa-5x"></i><br/>
						 	<h4>Lend</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-warning" onclick="goreport()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-archive fa-5x"></i><br/>
						 	<h4>Reports</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-default" onclick="gosettings()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-cogs fa-5x"></i><br/>
						 	<h4>Settings</h4>
						</div>
					</button>
				</div>
			</div>
		</div> <!-- <div class="well"> -->

		<?php 
			$bcount = 0;
			foreach ($borrowed_items as $bor) {
				$bcount++;
			}
			$ecount = 0;
			foreach ($entrance as $ent) {
				if (!$ent->en_time_out) {
					$ecount++;
				}
			}

		?>

		<div class="row" style="margin-top: 15px;">
			<div class="col-md-12">
				<!-- <div class="panel-default panel">
					<div class="panel-heading"> -->
						<div class="col-md-9 well well-sm">
							<!-- <div class="input-group"> -->
								<div class="col-md-10">	
									<select id="ebk_property" name="ebk_property" tabindex="-1" style="width:100%;">
										<option style="width:400px;">Quick Search </option>
											<?php foreach ($bk_lib_general as $blg) { ?>
										<option style="width:400px;" value="<?php echo base64_encode($blg->gb_id) ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->au_name.'| Vol: '.$blg->gb_volume.' | Desc:'.$blg->gb_remarks.' | DWC:'.$blg->gb_dw  ?></option>
											<?php } ?>
									</select>
								</div>
								<div class="col-md-2">
									<button class="btn btn-primary btn-sm" id="display_now" type="button">Display Item Now!</button> 
									 
								</div>
							<!-- </div> -->
						</div>
						<div class="col-md-2 col-md-offset-1 well well-sm">
									<button class="btn btn-success btn-sm" style="width: 100%;" id="live_search" type="button">Go Live Search <i class="fa fa-search"></i></button>
								</div>
					<!-- </div>
				</div> -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel-default panel">
					<div class="panel-heading">
						<ul class="nav nav-pills nav-justified">
							<li role="presentation"  data-toggle="tab" data-target="#borrowed" class="active"><a href="#"><b>Borrowed Items </b><span class="badge badge-light"><?php echo $bcount ?></span></a></li>
							<li role="presentation"  data-toggle="tab" data-target="#entrance"> <a href="#"><b>Library Users </b><span class="badge badge-primary"><?php echo $ecount ?></span></a></li>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
	                		<div class="tab-pane active" id="borrowed">
	                			<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="text-center"><b>Current Borrowed Items</b></h4>
										<ul class="nav nav-pills nav-justified">
											<li role="presentation"  data-toggle="tab" data-target="#all" class="active"><a href="#all">All</a></li>
											<li role="presentation"  data-toggle="tab" data-target="#ps"><a href="#home">Pre-School</a></li>
											<li role="presentation" data-toggle="tab" data-target="#sg"><a href="#pis">Grade School</a></li>
											<li role="presentation" data-toggle="tab" data-target="#hs"><a href="#hs">High School</a></li>
											<li role="presentation" data-toggle="tab" data-target="#fs"><a href="#fs">Faculty / Staff</a></li>
										</ul>
									</div>
									<div class="panel-body" style="overflow-y:scroll;height:300px;">
										
										<div class="tab-content" style="padding-top: 10px;">
											<div class="tab-pane active" id="all">
												<table id="allin" class="table tablesorter table-bordered ">
													<thead>
													<tr class="info" style="height:10px;">
														<th class="text-center">Title</th>
														<th class="text-center">Borrower</th>
														<th class="text-center">Lend Date</th>
														<th class="text-center">Due Date</th>
														<!-- <th>Remarks</th> -->
													</tr>
													</thead>

													<?php 
														foreach ($borrowed_items as $bi) {
															// $dnow = date('m-d-Y');
															$dnow = date('Ymd');
													?>

													<tr>
														<!-- <td style="text-align: center;"><?php echo $bi->gb_title ?></td> -->
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bi->bk_id).'/'.base64_encode($bi->gb_id)) ?>"><?php echo $bi->gb_title ?>
														<td><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($bi->tr_eu_id)) ?>"><?php echo $bi->lastname.', '.$bi->firstname ?></a></td>
														<td><?php echo $bi->tr_date ?></td>

													<?php 
														$duedate = $bi->tr_due_date;
														$ydue = substr($duedate, 0,4);
														$mdue = substr($duedate, 5,2);
														$ddue = substr($duedate, 8,2);
														$ddate = $ydue.''.$mdue.''.$ddue;
														$check = $ddate.' <= '.$dnow;
														if($ddate<=$dnow){ ?>

														<td style="color:red"><b><?php echo $bi->tr_due_date ?></b></td>

													<?php }else{ ?> 
													
														<td><?php echo $bi->tr_due_date ?></td>

													<?php } ?>

														
													</tr>

													<?php
														}
													?>

												</table>
											</div>
											<div class="tab-pane" id="ps">
												<table class="table table-bordered table-responsive tablesorter">
													<thead>
													<tr class="info" style="height:10px;">
														<th class="text-center">Title</th>
														<th class="text-center">Borrower</th>
														<th class="text-center">Lend Date</th>
														<th class="text-center">Due Date</th>
														<!-- <th>Remarks</th> -->
													</tr>
													</thead>
													<?php 
														foreach ($borrowed_items as $bi) {
															// $dnow = date('m-d-Y');
															if ($bi->grade_level_id < 2 || $bi->grade_level_id > 13 ) {
																# code...
															
															$dnow = date('Ymd');
													?>

													<tr>
														<!-- <td style="text-align: center;"><?php echo $bi->gb_title ?></td> -->
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bi->bk_id).'/'.base64_encode($bi->gb_id)) ?>"><?php echo $bi->gb_title ?>
														<td><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($bi->tr_eu_id)) ?>"><?php echo $bi->lastname.', '.$bi->firstname ?></a></td>
														<td><?php echo $bi->tr_date ?></td>

													<?php 
														$duedate = $bi->tr_due_date;
														$ydue = substr($duedate, 0,4);
														$mdue = substr($duedate, 5,2);
														$ddue = substr($duedate, 8,2);
														$ddate = $ydue.''.$mdue.''.$ddue;
														$check = $ddate.' <= '.$dnow;
														if($ddate<=$dnow){ ?>

														<td style="color:red"><b><?php echo $bi->tr_due_date ?></b></td>

													<?php }else{ ?> 
													
														<td><?php echo $bi->tr_due_date ?></td>

													<?php } ?>

														
													</tr>

													<?php
														} }
													?>
												</table>
											</div>
											<div class="tab-pane" id="fs">
												<table class="table table-bordered table-responsive tablesorter">
													<thead>
													<tr class="info" style="height:10px;">
														<th class="text-center">Title</th>
														<th class="text-center">Borrower</th>
														<th class="text-center">Lend Date</th>
														<th class="text-center">Due Date</th>
														<!-- <th>Remarks</th> -->
													</tr>
													</thead>
													<?php 
														foreach ($borrowed_items as $bi) {
															// $dnow = date('m-d-Y');
															if ($bi->account_type != 5 ) {
																# code...
															
															$dnow = date('Ymd');
													?>

													<tr>
														<!-- <td style="text-align: center;"><?php echo $bi->gb_title ?></td> -->
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bi->bk_id).'/'.base64_encode($bi->gb_id)) ?>"><?php echo $bi->gb_title ?>
														<td><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($bi->tr_eu_id)) ?>"><?php echo $bi->lastname.', '.$bi->firstname ?></a></td>
														<td><?php echo $bi->tr_date ?></td>

													<?php 
														$duedate = $bi->tr_due_date;
														$ydue = substr($duedate, 0,4);
														$mdue = substr($duedate, 5,2);
														$ddue = substr($duedate, 8,2);
														$ddate = $ydue.''.$mdue.''.$ddue;
														$check = $ddate.' <= '.$dnow;
														if($ddate<=$dnow){ ?>

														<td style="color:red"><b><?php echo $bi->tr_due_date ?></b></td>

													<?php }else{ ?> 
													
														<td><?php echo $bi->tr_due_date ?></td>

													<?php } ?>

														
													</tr>

													<?php
														} }
													?>
												</table>
											</div>
											<div class="tab-pane" id="hs">
												<table class="table table-bordered table-responsive tablesorter">
													<thead>
													<tr class="info" style="height:10px;">
														<th class="text-center">Title</th>
														<th class="text-center">Borrower</th>
														<th class="text-center">Lend Date</th>
														<th class="text-center">Due Date</th>
														<!-- <th>Remarks</th> -->
													</tr>
													</thead>
													<?php 
														foreach ($borrowed_items as $bi) {
															// $dnow = date('m-d-Y');
															if ($bi->grade_level_id > 7 && $bi->grade_level_id < 14 ) {
																# code...
															
															$dnow = date('Ymd');
													?>

													<tr>
														<!-- <td style="text-align: center;"><?php echo $bi->gb_title ?></td> -->
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bi->bk_id).'/'.base64_encode($bi->gb_id)) ?>"><?php echo $bi->gb_title ?>
														<td><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($bi->tr_eu_id)) ?>"><?php echo $bi->lastname.', '.$bi->firstname ?></a></td>
														<td><?php echo $bi->tr_date ?></td>

													<?php 
														$duedate = $bi->tr_due_date;
														$ydue = substr($duedate, 0,4);
														$mdue = substr($duedate, 5,2);
														$ddue = substr($duedate, 8,2);
														$ddate = $ydue.''.$mdue.''.$ddue;
														$check = $ddate.' <= '.$dnow;
														if($ddate<=$dnow){ ?>

														<td style="color:red"><b><?php echo $bi->tr_due_date ?></b></td>

													<?php }else{ ?> 
													
														<td><?php echo $bi->tr_due_date ?></td>

													<?php } ?>

														
													</tr>

													<?php
														} }
													?>
												</table>
											</div>
											<div class="tab-pane" id="sg">
												<table class="table table-bordered table-responsive tablesorter">
													<thead>
													<tr class="info" style="height:10px;">
														<th class="text-center">Title</th>
														<th class="text-center">Borrower</th>
														<th class="text-center">Lend Date</th>
														<th class="text-center">Due Date</th>
														<!-- <th>Remarks</th> -->
													</tr>
													</thead>
													<?php 
														foreach ($borrowed_items as $bi) {
															// $dnow = date('m-d-Y');
															if ($bi->grade_level_id > 1 && $bi->grade_level_id < 8 ) {
																# code...
															
															$dnow = date('Ymd');
													?>

													<tr>
														<!-- <td style="text-align: center;"><?php echo $bi->gb_title ?></td> -->
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bi->bk_id).'/'.base64_encode($bi->gb_id)) ?>"><?php echo $bi->gb_title ?>
														<td><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($bi->tr_eu_id)) ?>"><?php echo $bi->lastname.', '.$bi->firstname ?></a></td>
														<td><?php echo $bi->tr_date ?></td>

													<?php 
														$duedate = $bi->tr_due_date;
														$ydue = substr($duedate, 0,4);
														$mdue = substr($duedate, 5,2);
														$ddue = substr($duedate, 8,2);
														$ddate = $ydue.''.$mdue.''.$ddue;
														$check = $ddate.' <= '.$dnow;
														if($ddate<=$dnow){ ?>

														<td style="color:red"><b><?php echo $bi->tr_due_date ?></b></td>

													<?php }else{ ?> 
													
														<td><?php echo $bi->tr_due_date ?></td>

													<?php } ?>

														
													</tr>

													<?php
														} }
													?>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="entrance">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<b>Library Users</b>
										<b class="pull-right" onclick="refresh()"><i class="fa fa-refresh"></i></b>
									</div>
									<div class="panel-body" style="overflow-y:scroll; height:300px;">
										<table class="table table-bordered">
											<tr class="info">
												<th class="text-center">Name</th>
												<th class="text-center">Time-In</th>
												<th class="text-center">Time-Out</th>
												<th class="text-center">Grade/Level</th>
											</tr>

											<?php 
												foreach ($entrance as $ent) {
											?>

											<tr>
												
												<td class="text-center"><?php echo $ent->lastname.','.$ent->firstname ?></td>
												<td class="text-center"><?php echo $ent->en_time_in ?></td>
												
												<?php if($ent->en_time_out!="" || $ent->en_time_out!=null){ ?>

												<td class="text-center"><?php echo $ent->en_time_out ?></td>

												<?php }else{	?>							

												<td class="text-center" style="color:green;">STILL IN</td>
												
												<?php } ?>

												<td class="text-center" ><?php echo $ent->level ?></td>
											</tr>

											<?php } ?>

										</table>
									</div>
								</div>
							</div>




			<div class="col-md-6">
				
			</div>
			<div class="col-md-6">
					
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#ebk_property").select2();
		$(".table").tablesorter({debug: true});
		// $("#allin").DataTable();
	});

	// $("#b1").click(function(){
	// 	var el1 = document.getElementById("b1");
	// 	el1.classList.toggle("btn-default");
	// 	var el2 = document.getElementById("b2");
	// 	el2.classList.toggle("btn-primary");
	// });
	// $("#b2").click(function(){
	// 	var el1 = document.getElementById("b2");
	// 	el1.classList.toggle("btn-default");
	// 	var el2 = document.getElementById("b1");
	// 	el2.classList.toggle("btn-primary");
	// });

	$("#display_now").click(function(){
	
		var iid = document.getElementById('ebk_property').value;
		if(iid!=""||iid!="Quick Search"||iid!=null){
			document.location = '<?php echo base_url()?>librarymodule/books/'+ iid;
		}else{
			alert("Please select an item to be displayed and try again.");
		}
	});

	$("#live_search").click(function(){
	
		document.location = '<?php echo base_url()?>librarymodule/search';
	});

	function refresh()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}
	
	function gobooks()
	{
		document.location = '<?php echo base_url()?>librarymodule/books';
	}

	function goaccounts()
	{
		document.location = '<?php echo base_url()?>librarymodule/accounts';
	}

	function golend()
	{
		document.location = '<?php echo base_url()?>librarymodule/lend';
	}

	function goreport()
	{
		document.location = '<?php echo base_url()?>librarymodule/report';
	}

	function gosettings()
	{
		document.location = '<?php echo base_url()?>librarymodule/settings';
	}


	
</script>