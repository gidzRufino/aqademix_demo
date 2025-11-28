<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="well well-sm" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-success" onclick="lendabook()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-road fa-2x"></i><br/>
						 	<h4>Lend a Book</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<!-- <button type="button" class="btn btn-warning" onclick="golend()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-star fa-2x"></i><br/>
						 	<h4>Book Status</h4>
						</div>
					</button> -->
				</div>
				<div class="col-md-4">
					<!-- <button type="button" class="btn btn-success" onclick="golend()" style="text-align:center">
						<div class="col-md-12">cb162dcd
						 	<i class="fa fa-road fa-2x"></i><br/>
						 	<h4>Lend a Book</h4>
						</div>
					</button> -->
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
				<h4>Activate a Library Account</h4>				
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-10 col-md-offset-2">
						<span><b>Select Account from </b>
							<select id="dept_slct" onclick="getAccount()" style="width: 175px;">
								<option>Select Department</option>
								<option value="1">Students</option>
								<option value="2">Faculty and Staff</option>
								<option value="3">Parents</option>
								<option value="4">Visitors</option>
							</select>
						</span>
					</div>	
				</div>
				<div class="row" style="height:10px;">
					
				</div>
				<div id="stud_div" class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<b>Hello!!!</b> Please select <b style="color:red;">STUDENT</b> name from the dropdown box at the right.
									<button type="button" class="btn btn-success btn-xs pull-right checkit" id="add_account_s" style="margin-left: 5px; margin-right: 5px;"><i class="fa fa-plus fa-fw"></i></button>
				              <select class="pull-right" onclick="getStudent()" tabindex="-1" id="searchStudents" style="width: 225px; margin-top: -3px;">
				                <option>Search Name</option>
				                  <?php foreach ($students->result() as $st) { $id = $st->user_id; ?>
				                <option value="<?php echo base64_encode($id); ?>"><?php echo $st->lastname.',&nbsp;'.$st->firstname; ?></option>
				                  <?php } ?>
				              </select>
							</div>
						</div>
					</div>
				</div>
				<div id="fs_div" class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<b>Hello!!!</b> Please select <b style="color:red;">FACULTY/STAFF</b> name from the dropdown box at the right.
								<button type="button" class="btn btn-success btn-xs pull-right checkit" id="add_account_fns" style="margin-left: 5px; margin-right: 5px;"><i class="fa fa-plus fa-fw"></i></button>
			              <select class="pull-right" onclick="getfns()" tabindex="-1" id="searchfns" style="width: 225px; margin-top: -3px;">
			                <option>Search Name</option>
			                  <?php foreach ($fns as $fns) { $id = $fns->user_id; ?>
			                <option value="<?php echo base64_encode($id); ?>"><?php echo $fns->lastname.',&nbsp;'.$fns->firstname; ?></option>
			                  <?php } ?>
			              </select>
							</div>
						</div>
					</div>
				</div>
				<div id="parent_div" class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<b>Hello!!!</b> Please select <b style="color:red;">PARENT</b> name from the dropdown box at the right.
								<button type="button" class="btn btn-success btn-xs pull-right checkit" id="add_account_p" style="margin-left: 5px; margin-right: 5px;"><i class="fa fa-plus fa-fw"></i></button>
			              <select class="pull-right" onclick="getParent()" tabindex="-1" id="searchparent" style="width: 225px; margin-top: -3px;">
			                <option>Search Name</option>
			                  <?php foreach ($search_parent as $sp) { $id = $sp->user_id; ?>
			                <option value="<?php echo base64_encode($id); ?>"><?php echo $sp->lastname.',&nbsp;'.$sp->firstname; ?></option>
			                  <?php } ?>
			              </select>
							</div>
						</div>
					</div>
				</div>
				<div id="vis_div" class="row">
					<div class="col-md-12">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="boo">Sorry!!! Visitors are not allowed to borrow any books from this library. </h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">

				<?php
					$eu_count = 0;
					foreach ($display_users as $du) {
						$eu_id = $du->eu_user_id;
						$eu_count++;
				?>

				<input class="hidden" type="hidden" name="var<?php echo $eu_count?>" id="var<?php echo $eu_count ?>" value="<?php echo base64_encode($eu_id) ?>">
				
				<?php
					}
				?>

				<input class="hidden" type="hidden" id="countvar" value="<?php echo $eu_count ?>"></input>

				<div id="hidden_form" class="hidden">	
					<form id="saveAccount" action="" method="post">
						<input type="hidden" name="u_id" id="u_id" value="none" required>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
    $("#dept_slct").select2();
    $("#searchStudents").select2();
    $("#searchfns").select2();
    $("#searchparent").select2();

    $("#stud_div").css('display', 'none');
    $("#fs_div").css('display', 'none');
    $("#parent_div").css('display', 'none');
    $("#vis_div").css('display', 'none');
   });
	


	function getAccount()
	{
		var dept = document.getElementById('dept_slct').value;
		if (dept==1){
			$("#stud_div").css('display', 'block');
		   $("#fs_div").css('display', 'none');
		   $("#parent_div").css('display', 'none');
		   $("#vis_div").css('display', 'none');
		}else if(dept==2){
			$("#stud_div").css('display', 'none');
    		$("#fs_div").css('display', 'block');	
    		$("#parent_div").css('display', 'none');
    		$("#vis_div").css('display', 'none');
		}else if(dept==3){
			$("#stud_div").css('display', 'none');
    		$("#fs_div").css('display', 'none');
    		$("#parent_div").css('display', 'block');
    		$("#vis_div").css('display', 'none');
		}else if(dept==4){
			$("#stud_div").css('display', 'none');
    		$("#fs_div").css('display', 'none');
    		$("#parent_div").css('display', 'none');
    		$("#vis_div").css('display', 'block');
		}
	}

	$(".checkit").click(function(){

		var btn = this;
		var btn_id = btn.id;

		if (btn_id=='add_account_s') {
			var uid = document.getElementById('searchStudents').value;
		}else if (btn_id=='add_account_fns') {
			var uid = document.getElementById('searchfns').value;
		}else if (btn_id=='add_account_p') {
			var uid = document.getElementById('searchparent').value;
		}
		
		var countz = document.getElementById('countvar').value;
		var indicate_exist = 0;
		for (dcounter = 1; dcounter <= countz; dcounter++) {
			var temp = 'var'+dcounter;
			var temp_uid = document.getElementById(temp).value;
			
			if (temp_uid==uid){
				indicate_exist = 1;				
			}else{
				// do something...
			}
		}
		
		if (indicate_exist != 0){
			alert('This account was already active. No need to activate.');
		}else{
			document.getElementById('u_id').value = uid;
			var url1 = '<?php echo base_url() ?>librarymodule/save_account';
			$.ajax({
				type: "POST",
				url: url1,
				data: $("#saveAccount").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
				success: function(data){
					alert('Account Succesfully Activated!!!');
					document.location = '<?php echo base_url() ?>librarymodule/new_account';
				}
			});
		}
	});

	function dashboard()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}

	function lendabook()
	{
		document.location = '<?php echo base_url()?>librarymodule/lend';
	}

</script>