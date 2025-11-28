<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="well well-sm" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-primary" onclick="new_account()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-user fa-2x"></i><br/>
						 	<h4>New Account</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					
				</div>
				<div class="col-md-2">
					
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-success" onclick="golend()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-road fa-2x"></i><br/>
						 	<h4>Lend an Item</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-default" onclick="dashboard()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-tasks fa-2x"></i><br/>
						 	<h4>Dashboard</h4>
						</div>
					</button>
				</div>
			</div>
		</div> <!-- <div class="well"> -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>List of Accounts</h4>
				<select class="pull-right" onclick="geteuaccount()" tabindex="-1" id="searcheua" style="width: 225px; margin-top: -30px;">
             	<option>Search Name</option>
               	<?php foreach ($eu_accounts as $eua) { $id = $eua->eu_user_id; ?>
             	<option value="<?php echo base64_encode($id); ?>"><?php echo $eua->lastname.',&nbsp;'.$eua->firstname; ?></option>
               	<?php } ?>
           	</select>				
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<!-- <div class="" style="overflow-y:scroll; height: 400px;"> -->
							<table id="inv_table" class="tablesorter table ">
								<!-- <thead style="background:#E6EEEE;"> -->
									<tr>
										<th class="bg-primary" style="text-align:center;">Name</th>
										<th class="bg-primary" style="text-align:center;">Status</th>
										<th class="bg-primary" style="text-align:center;">Designation</th>
										<th class="bg-primary" style="text-align:center;">Items borrowed</th>
										<th class="bg-primary" style="text-align:center;">Outstanding Items</th>
										<th class="bg-primary" style="text-align:center;">hours spent</th>
										<th class="bg-primary" style="text-align:center;">remarks</th>
									</tr>
								<!-- </thead> -->
             				
             				<?php
             					if(count($eu_accounts)>0){
             					foreach ($eu_accounts as $ea) {
             						$fname = $ea->firstname;
             						$lname = $ea->lastname;
             						$eu_id = $ea->eu_user_id;
             						$full_name = $lname.', '.$fname;
             						$act_type = $ea->account_type;

             						if ($act_type=='5') {
             							$eu_designation = 'Student';
             						}elseif ($act_type=='4') {
             							$eu_designation = 'Parent';
             						}else{
             							$eu_designation = 'Faculty / Staff';
             						}
             				?>
             				<tr class="info">
             					<td style="text-align:center;"><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($eu_id))?>"><?php echo $full_name ?></a></td>
             					<td style="text-align:center;"><?php echo $ea->eu_status ?></td>
             					<td style="text-align:center;"><?php echo $eu_designation ?></td>
             					<td style="text-align:center;"><?php echo $ea->eu_borrows ?></td>
             					<td style="text-align:center;"><?php echo $ea->eu_return_count ?></td>
             					<td style="text-align:center;"><?php echo round($ea->eu_tot_time/60,2) ?></td>
             					<td style="text-align:center;"><?php echo $ea->eu_remarks ?></td>
             				</tr>
             				<?php

             					}}else{
             				?>
             				<tr></tr>
             				<?php 
             					}  // foreach $eu_accounts
             				?>
                  			<!-- <tr></tr> -->
							</table>
						<!-- </div> -->
					</div>	
				</div>
			</div>
			<div class="panel-footer">
				
			</div>
		</div>
		<div id="new_entry" style="display:none">
			
		 <?php 
		 	$data['bk_author'] = $bk_author;
		   $this->load->view('forms/new_entry', $data); 
		 ?>    

		</div>
	</div>
</div>

<div id="add_bk_dewey_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <?php 
      $data['bk_dewey'] = $bk_dewey;
      $data['bk_display_dewey'] = $bk_display_dewey;
      $data['bk_dewey_category'] = $bk_dewey_category;
      $this->load->view('forms/bk_dewey', $data); 
    ?>    

</div>

<script type="text/javascript">

	$(document).ready(function() {
    $("#searcheua").select2();
   });
	
	function dashboard()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}

	function new_account()
	{
		document.location = '<?php echo base_url()?>librarymodule/new_account';
	}

	function geteuaccount()
	{
		var euid = document.getElementById('searcheua').value;

		document.location = '<?php echo base_url()?>librarymodule/show_account/'+euid;
	}

	function golend()
	{
		document.location = '<?php echo base_url()?>librarymodule/lend';
	}

</script>