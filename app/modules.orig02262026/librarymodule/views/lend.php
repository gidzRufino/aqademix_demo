<?php 
	$userid = $this->session->userdata('username');
?>

<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="well well-sm" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-info" onclick="new_account()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-user fa-2x"></i><br/>
						 	<h4>New Account</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					
				</div>
				<div class="col-md-2">
					<!-- <button type="button" class="btn btn-warning" onclick="golend()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-star fa-2x"></i><br/>
						 	<h4>Book Status</h4>
						</div>
					</button> -->
				</div>
				<div class="col-md-2">
					<!-- <button type="button" class="btn btn-success" onclick="golend()" style="text-align:center">
						<div class="col-md-12">
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
				<h4>Lend an Item</h4>				
			</div>
			<div class="panel-body">
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-7 col-md-offset-1">
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="search">Search Borrower</h4>
										<select class="pull-right" tabindex="-1" onclick="get_account()" id="searchaccount" style="width: 50%; margin-top: -30px;">
						             	<option>Search Name</option>
						               	<?php foreach ($eu_accounts as $eua) { $id = $eua->user_id; ?>
						             	<option value="<?php echo base64_encode($id); ?>"><?php echo $eua->lastname.',&nbsp;'.$eua->firstname.' [ '.$eua->rfid.' ]' ?></option>
						               	<?php } ?>
						           	</select>
						         </div>
								</div>
							</div>	
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="books">Search Item</h4>
										<select class="pull-right" id="searchbook" name="searchbook" tabindex="-1" style="width: 70%; margin-top: -30px;">
											<option>Item Properties</option>

												<?php foreach ($bk_lib_general as $blg) { 
													if($blg->bk_st_id!=1 && $blg->bk_st_id!=5 && $blg->bk_st_id!=6 && $blg->bk_st_id!=7 && $blg->bk_st_id!=8){
												?>
											
											<option value="<?php echo $blg->bk_id ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->gb_author.' | #'.$blg->bk_serial_num.' | '. $blg->bk_id ?></option>
											
												<?php }} ?>

										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="tdate">Return Date</h4>
	                           <!-- <button class="btn btn-default pull-right" id="calend"  style="font-size: 8px; width: 10%; margin-left: -4px; height: 26px;" onclick="$('#retdate').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button> -->
	                           <div class="pull-right col-md-4">
	                           	<input class="pull-right" type="text" style="margin-top: -30px;" name="rethour" id="rethour" placeholder="<?php echo date("H:i") ?>"required>	
	                           </div>
	                           <div class="pull-right col-md-4">
	                           	<input class="pull-right" name="retdate" style="color: black; margin-top: -30px; " type="text" data-date-format="yyyy-mm-dd" id="retdate" placeholder="Return Date" required>	
	                           </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hidden">
				<form id="saveTransaction" action="" method="post">
					<input type="hidden" name="tr_st_id" id="tr_st_id" value="1" required>
					<input type="hidden" name="tr_bk_id" id="tr_bk_id" required>
					<input type="hidden" name="tr_date" id="tr_date" value="<?php echo date("Y-m-d") ?>" required>
					<input type="hidden" name="bk_st_date" id="bk_st_date" value="<?php echo date("m/d/y") ?>"required>
					<input type="hidden" name="tr_hour" id="tr_hour" required>
					<input type="hidden" name="tr_staff_id" id="tr_staff_id" value="<?php echo $userid ?>" required>
					<input type="hidden" name="tr_eu_id" id="tr_eu_id" required>
					<input type="hidden" name="tr_due_date" id="tr_due_date" required>
					<input type="hidden" name="tr_remarks" id="tr_remarks" required>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		$("#searchaccount").select2();
		$("#searchbook").select2();
		$('#retdate').datepicker();
   });

	function new_account()
	{
		document.location = '<?php echo base_url()?>librarymodule/new_account';
	}

	function lend_book()
	{
		document.getElementById('tr_eu_id').value = document.getElementById('searchaccount').value;
		document.getElementById('tr_bk_id').value = document.getElementById('searchbook').value;
		document.getElementById('tr_due_date').value = document.getElementById('retdate').value;
		document.getElementById('tr_hour').value = document.getElementById('rethour').value;
		var test1 = document.getElementById('searchbook').value;
		var test2 = document.getElementById('searchaccount').value;
		var test3 = document.getElementById('retdate').value;

		if(test3=='' || test3==null || test3=='Return Date'){
			alert('Please enter return date to complete the transaction.')
		}else{				
			if (test1=='' || test1==null || test1=='Search Name') {
				alert('Please select book to complete the transaction.');
			}else{
				if (test2=='' || test2==null || test1=='Book Properties') {
					alert('Please select account name to complete the transaction.');
				}else{
					var url1 = "<?php echo base_url() . 'librarymodule/record_lend' ?>"; 
				   $.ajax({
				      type: "POST",
				      url: url1,
				      data: $("#saveTransaction").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
				      success: function (data) {
			            alert('Transaction Succesfully submitted.');
			            document.location = '<?php echo base_url() ?>librarymodule/lend';
				            // location.reload();
			        		}
				   });
				}
			}
		}
	}

	function get_account()
	{
		var euid = document.getElementById('searchaccount').value;

		document.location = '<?php echo base_url()?>librarymodule/show_account/'+euid+'/lend';
	}

	function dashboard()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}

</script>