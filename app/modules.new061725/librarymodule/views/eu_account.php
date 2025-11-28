<?php 
$userid = $this->session->userdata('username');
$luri = $this->uri->segment(4);
?>
<script type="text/javascript">
   $(function(){
   	$("#tsort").tablesorter({debug: true});
   });  
</script>


<input type="hidden" id="check_uri" value="<?php echo $luri ?>" required>
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
					<button type="button" class="btn btn-info" onclick="search_accounts()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-group fa-2x"></i><br/>
						 	<h4>Search Existing Account</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<input type="hidden" name="eu_id" id="eu_id" value="<?php echo $this->uri->segment(3); ?>" required>
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
		</div> 
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Account Information</b>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">

						<?php 

							$act_type = $account_info->account_type;

	 						if ($act_type=='5') {
	 							$eu_designation = 'Student';
	 						}elseif ($act_type=='4') {
	 							$eu_designation = 'Parent';
	 						}else{
	 							$eu_designation = 'Faculty / Staff';
	 						}

	 						if ($eu_designation == 'Faculty / Staff' || $eu_designation == 'Parent'){

	 					?>

	 					<img alt="image not available." src="<?php echo base_url()?>uploads/noImage.png" style="left: 25px; height:85px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  />
	 					
	 					<?php }else{ ?>

						<img  class="pull-right" alt="<?php echo $account_info->lastname.", ".$account_info->firstname; ?> image not available." src="<?php echo base_url()?>uploads/<?php echo $account_info->avatar;?>" style="left: 25px; margin-right: 10px; height:120px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3); margin:right;" />

	 					<?php } ?>
					
					</div>
					<div class="col-md-6">
						<h3><b>Name: </b><b style="color:red;"><?php echo $account_info->lastname.', '.$account_info->firstname;  ?></b></h3>
						<h4>Designation: <b style="color:blue;"><?php echo $eu_designation ?></b></h4>
						<h4>Status: <b style="color:brown;">"<?php echo $account_info->eu_status?>"</b>
							<a href="#" onclick="change_plan()" style="margin-left: 0px; color: black; font-size: 14px;">
			                   	<span class="fa-stack fa-xs">
			                     	<i class="fa fa-square fa-stack-2x"></i>
			                     	<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
			                   	</span>
		                 	</a>
						</h4>
					</div>
					<div class="col-md-3" style="margin-top: 25px;">
						<span><b># of items borrowed</b>&nbsp;&nbsp;<b style="color: green;"><?php echo $account_info->eu_borrows ?></b> </span><br />
						<span><b># of hours spent</b>&nbsp;&nbsp;<b style="color: green;"><?php echo round($account_info->eu_tot_time/60, 2) ?> hrs</b> </span><br />
						<span><b># of outstanding items</b>&nbsp;&nbsp;<b style="color: red;"><?php echo $account_info->eu_return_count ?></b> </span><br />
						<button type="button" class="btn btn-success btn-sm" id="lend_now" style="margin: 10px 5px 0 0;"><i class="fa fa-book fa-fw"></i>&nbsp; Lend an item&nbsp;&nbsp;  </button>
						<!-- <button type="button" class="btn btn-danger btn-sm" id="return_now" style="margin: 10px 5px 0 0;"><i class="fa fa-reply fa-fw"></i>&nbsp; Return&nbsp;&nbsp;  </button> -->
					</div>
				</div> <!-- row -->
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<div class="panel-info panel">
							<div class="panel-heading">
								<div class="btn-group btn-group-justified">
				               <div class="btn-group">
				               	<button type="button" class="btn btn-info" data-toggle="tab" data-target="#itemsh"><b>Items History</b></button>
				               </div>
				               <div class="btn-group">
				               	<button type="button" class="btn btn-info" data-toggle="tab" data-target="#entrancer"><b>Entrance Records</b></button>
				               </div>
				            </div>
							</div>
							<div class="panel-body">
								<div class="tab-content">
	                			<div class="tab-pane active" id="itemsh">
	                				<div class="row">
											<div class="col-md-12">
												<table id="tsort" class="tablesorter table table-condensed table-bordered">
													<!-- <tr>
														<th colspan="8" style="text-align: center; font-size: 18px;">Account History</th>
													</tr> -->
													<thead class="bg-primary">
														<tr>
														<th style="text-align: center;">Item ID</th>
														<th style="text-align: center;">Item Description</th>
														<th style="text-align: center;">Status</th>
														<th style="text-align: center;">Date Out</th>
														<th style="text-align: center;">Due Date</th>
														<th style="text-align: center;">Date Returned</th>
														<th style="text-align: center;">Remarks</th>
														<th style="text-align: center;">Action</th>
														</tr>
													</thead>

													<?php 
														$count_items = 0;
														if(count($account_history)>0){
														if(is_array($account_history)){
														foreach ($account_history as $hk) {
															$count_items++;
															$dnow = date('Y-m-d');
													?>

													<tr>
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($hk->tr_bk_id)) ?>"><?php echo $hk->tr_bk_id ?></td>
														<td style="text-align: center;"><a href="<?php echo base_url('librarymodule/books/'.base64_encode($hk->gb_id)) ?>"><?php echo $hk->gb_title ?><input type="hidden" name="gb_title<?php echo $count_items ?>" id="gb_title<?php echo $count_items ?>" value="<?php echo $hk->gb_title ?>" required><input type="hidden" name="gb_author<?php echo $count_items ?>" id="gb_author<?php echo $count_items ?>" value="<?php echo $hk->gb_author ?>" required></td>
														<td style="text-align: center;"><?php echo $hk->st_status ?></td>
														<td style="text-align: center;"><?php echo $hk->tr_date ?></td>
														<?php if ($hk->tr_due_date<=$dnow){ ?>
														<th style="text-align: center;color:red;"><?php echo $hk->tr_due_date ?><input type="hidden" name="due_date<?php echo $count_items ?>" id="due_date<?php echo $count_items ?>" value="<?php echo $hk->tr_due_date ?>" required></th>
														<?php }else{?>
														<td style="text-align: center;"><?php echo $hk->tr_due_date ?><input type="hidden" name="due_date<?php echo $count_items ?>" id="due_date<?php echo $count_items ?>" value="<?php echo $hk->tr_due_date ?>" required></td>
														<?php } ?>
														<td style="text-align: center;"><?php echo $hk->tr_ret_date ?></td>
														<td style="text-align: center;"><?php echo $hk->tr_remarks ?></td>
													
													<?php
														if ($hk->tr_ret_date===""||$hk->tr_ret_date===null){
													?>

														<td style="text-align: center;"><button type="button" class="btn btn-danger btn-xs tr_item" id="ret<?php echo $count_items ?>" style="margin: 10px 5px 0 0;"><i class="fa fa-reply fa-fw"></i></button><input type="hidden" name="retid<?php echo $count_items ?>" id="retid<?php echo $count_items ?>" value="<?php echo $hk->tr_id ?>" required><input type="hidden" name="itm<?php echo $count_items ?>" id="itm<?php echo $count_items ?>" value="<?php echo $hk->tr_bk_id ?>" required></td>

													<?php } ?>
							
													</tr>

													<?php }}}else{ ?>
													
													<tr></tr>
													<?php

													}

													?>
														
												</table>						
											</div>
										</div>
			                	</div>
	                			<div class="tab-pane" id="entrancer">
	                				<div class="row">
	                					<div class="col-md-12">
	                						<table id="tsort" class="tablesorter table table-condensed table-bordered">
	                							<thead class="bg-primary">
		                							<tr>
		                								<th style="text-align: center;">Date</th>
		                								<th style="text-align: center;">Checked IN</th>
		                								<th style="text-align: center;">Checked OUT</th>
		                								<th style="text-align: center;">Total (minutes)</th>
		                							</tr>
	                							</thead>

	                							<?php 
	                								if(is_array($account_visits)){
	                								foreach ($account_visits as $av) {
	                							?>
	                							<tr>
	                								<td style="text-align: center;"><?php echo $av->en_date_in ?></td>
	                								<td style="text-align: center;"><?php echo $av->en_time_in ?></td>
	                								<td style="text-align: center;"><?php echo $av->en_time_out ?></td>
	                								<td style="text-align: center;"><?php echo $av->en_time_total ?></td>
	                							</tr>
	                							<?php
	                								}}
	                							?>
	                						</table>
	                					</div>
	                				</div>
	                			</div>
	                		</div>
							</div>
						</div>
					</div>
				</div>					
			</div>
		</div>
	</div>
</div>

<!-- f -->

	<form id="return_tx" action="" method="post">
		<input type="hidden" name="tr_id" id="tr_id" required>
		<input type="hidden" name="tr_ret_date" id="tr_ret_date" required>
		<input type="hidden" name="tr_flag" id="tr_flag" value="1" required>
		<input type="hidden" name="tr_remarks" id="tr_remarks" required>
		<input type="hidden" name="tr_bk_id" id="tr_bk_id" required>
		<input type="hidden" name="bk_st_id" id="bk_st_id" required>
		<input type="hidden" name="eu_id" id="eu_id" value="<?php echo $account_info->eu_user_id; ?>" required>
		<input type="hidden" name="tr_staff_id" id="tr_staff_id" value="<?php echo $userid ?>" required>

		<?php
			$tr_count = $account_info->eu_return_count;
			$tr_borrow_count = $account_info->eu_borrows;
			$eu_borrows = $tr_borrow_count + 1;       // counts borrows
			$tr_return_count = $tr_count - 1;         // less returns
			$tr_lend_count = $tr_count + 1;           // adds lends
		?>

		<input type="hidden" name="eu_return_count" id="eu_return_count" value="<?php echo $tr_return_count ?>" required>
		<input type="hidden" name="eu_lend_count" id="eu_lend_count" value="<?php echo $tr_lend_count ?>" required>
		<input type="hidden" name="eu_borrows" id="eu_borrows" value="<?php echo $eu_borrows ?>" required>
		<input type="hidden" name="tr_st_id" id="tr_st_id" value="1" required>
		<input type="hidden" name="tr_date" id="tr_date" value="<?php echo date("Y-m-d") ?>" required>
		<input type="hidden" name="bk_st_date" id="bk_st_date" value="<?php echo date("m/d/y") ?>"required>
		<input type="hidden" name="tr_hour" id="tr_hour" required>
		<input type="hidden" name="tr_eu_id" id="tr_eu_id" value="<?php echo base64_encode($account_info->eu_user_id) ?>" required>
		<input type="hidden" name="tr_due_date" id="tr_due_date" required>
	</form>

<!-- f (end) -->

<!-- modals -->

<div id="return_item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  	<div class="modal-content">
	    	<div class="modal-header bg-primary">
	      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	      	<h4 class="modal-title" id="myModalLabel">Library Transaction</h4>
	    	</div>
	  		<!-- <div class="modal-body" style="overflow-y:scroll; height:400px;"> -->
	    	<div class="modal-body">
				<div class="row">
		        	<!-- <div class="col-md-1"></div> -->
		        	<div class="col-md-12">
		        		<div class="well well-sm" style="margin: 10px 0px">
		               <h4><b>Item Title:</b>&nbsp;&nbsp;<b id="item_title" style="color:red;"></b></h4>
		               <h5><b>Author:</b>&nbsp;&nbsp;<b id="item_author" style="color:green;"></b></h5>
		               <h5><b>Due Date:</b>&nbsp;&nbsp;<b id="due_date" style="color:green;"></b></h5>
		            </div>
	         </div>
	      </div>	    	
	      <div class="row" style="margin-top:20px;">
	        	<div class="col-md-1"></div>
	        	<div class="col-md-6">
               <h5 style="margin-bottom: 0px;"><b>Transaction Description</b></h5>
               <select id="tr_status" style="width:100%;">
               	<option value="2">Return item</option>
               	<option value="7">Damaged item (for repair)</option>
               	<option value="8">Damaged item (for disposal)</option>
               	<option value="9">Lost item</option>
               </select>
            </div>
         </div>
	      <div class="row">
	        	<div class="col-md-1"></div>
	        	<div class="col-md-6">
               <h5 style="margin-bottom: 0px;"><b>Transaction Date</b></h5>
               <input name="trans_date" style="color: black; width: 80%;" type="text" data-date-format="yyyy-mm-dd" id="trans_date" value="<?php echo date("Y-m-d") ?>" required>
               <button class="btn btn-default" id="calend"  style="font-size: 8px; width: 20%; margin-left: -4px; height: 26px; margin-top: -2px;" onclick="$('#trans_date').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button>
            </div>
         </div>
         <div class="row">
         	<div class="col-md-1"></div>
            <div class="col-xs-9">
               <h5 style="margin-bottom: 0px;"><b>Remarks</b></h5>
               <input class="text-center" style="color: black; width: 100%;" name="trans_remarks" id="trans_remarks"  required>
	        	</div>
	      </div>
	      <div class="row" style="margin-top:20px;">
	      	<div class="col-md-1"></div>
	      	<div class="col-md-10">
	      		<span>Transaction Date is the date when the item is returned. Providing a transaction remarks will help you track this transaction for future reference. Check all the details before submitting. Once submitted, it cannot be undone.</span>
	      	</div>
	      </div>
	    </div>
	  	<div class="modal-footer">
	  		<span>
	  			<button type="button" class="btn btn-success btn-mini" id="yes_submit"><b><i class="fa fa-check fa-fw"></i>Submit</b></button>
	  			<button type="button" class="btn btn-danger btn-mini" data-dismiss="modal"><b><i class="fa fa-times fa-fw"></i>Cancel</b></button>
	      </span>
	    </div>	
		</div>
	</div>
</div>	

<div id="lend_item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  	<div class="modal-content">
	    	<div class="modal-header bg-primary">
	      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	      	<h4 class="modal-title" id="myModalLabel">Library Transaction - Lend an item</h4>
	    	</div>
	    	<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="books">Search Items</h4>
								<select class="pull-right" id="searchbook" name="searchbook" tabindex="-1" style="width: 70%; margin-top: -30px;">
									<option>Item Properties</option>

										<?php foreach ($bk_lib_general as $blg) { 
											if($blg->bk_st_id!=1 && $blg->bk_st_id!=5 && $blg->bk_st_id!=6 && $blg->bk_st_id!=7 && $blg->bk_st_id!=8){
										?>
									
									<option value="<?php echo $blg->bk_id ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->gb_author.' | Vol.'.$blg->gb_volume.' | Dewey: '.$blg->gb_dw.' | ID: '. $blg->bk_id ?></option>
									
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
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<i>* Select an item to be borrowed and set the desired return date. </i>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span>
		  			<button type="button" class="btn btn-success btn-mini" onclick="lend_book()" id="lend_now"><b><i class="fa fa-book fa-fw"></i>Lend Now</b></button>
		  			<button type="button" class="btn btn-danger btn-mini" data-dismiss="modal"><b><i class="fa fa-times fa-fw"></i>Cancel</b></button>
		      </span>
			</div>
		</div>
	</div>
	<div class="hidden">
		
	</div>
</div>



<!-- modals (end) -->

<script type="text/javascript">
	$(document).ready(function() {
		
		$('#trans_date').datepicker();
		$("#tr_status").select2();
		$("#searchbook").select2();
		$('#retdate').datepicker();
		var check_uri = document.getElementById('check_uri').value;
		if (check_uri=='lend'){
			$("#lend_item").modal(); 
		}
	});

	$(".tr_item").click(function()
	{
		var btn = this;
      var btn_id = btn.id;
      var get_id = btn_id.slice(3);
      var trans_id = 'retid' + get_id;
      var itm_id = 'itm' + get_id;
      var itm_title = 'gb_title' + get_id;
      var ddate = 'due_date' + get_id; 
      var itm_author = 'gb_author' + get_id;
		document.getElementById('tr_id').value = document.getElementById(trans_id).value;
		document.getElementById('tr_bk_id').value = document.getElementById(itm_id).value;
		document.getElementById('item_title').innerHTML = document.getElementById(itm_title).value;
		document.getElementById('item_author').innerHTML = document.getElementById(itm_author).value;
		document.getElementById('due_date').innerHTML = document.getElementById(ddate).value;
		$("#return_item").modal();
	});

	$("#lend_now").click(function() 
	{
   	$("#lend_item").modal(); 
   });


	$("#yes_submit").click(function()
		{
			var tdate = document.getElementById('trans_date').value;
			var trem = document.getElementById('trans_remarks').value;
			if (tdate==""){
				alert("Please provide transaction date before you continue.")
			}else{
				document.getElementById('tr_ret_date').value = tdate;
				document.getElementById('bk_st_id').value = document.getElementById('tr_status').value;
				var tr = document.getElementById('tr_status').value;
				var tremark = document.getElementById('trans_remarks').value;
				if (tr=='2'){
					tr_stat = '[Returned] ' + tremark;
				}else if(tr=='7'){
					tr_stat = '[Returned Damaged - for repair] ' + tremark;
				}else if(tr=='8'){
					tr_stat = '[Returned Damaged - for disposal] ' + tremark;
				}else if(tr=='9'){
					tr_stat = '[Lost] ' + tremark;
				}

				document.getElementById('tr_remarks').value = tr_stat;
				var usr = document.getElementById('eu_id').value;
				var url = "<?php echo base_url().'librarymodule/return_item' ?>";
	        	$.ajax({
            	type: "POST",
            	url: url,
            	data: $("#return_tx").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            	success: function (data) {
                	// document.location = '<?php echo base_url() ?>librarymodule/show_account/' + usr;
                	alert('Transaction Succesfully submitted.');
                	location.reload();
            	}
        		});
	     	}
		});

	function lend_book()
	{
		document.getElementById('tr_bk_id').value = document.getElementById('searchbook').value;
		document.getElementById('tr_due_date').value = document.getElementById('retdate').value;
		document.getElementById('tr_hour').value = document.getElementById('rethour').value;
		var test1 = document.getElementById('searchbook').value;
		// var test2 = document.getElementById('searchaccount').value;
		var test3 = document.getElementById('retdate').value;

		if(test3=='' || test3==null || test3=='Return Date'){
			alert('Please enter return date to complete the transaction.')
		}else{				
			if (test1=='' || test1==null || test1=='Search Name') {
				alert('Please select book to complete the transaction.');
			}else{	
				var url1 = "<?php echo base_url() . 'librarymodule/record_lend' ?>"; 
			   $.ajax({
			      type: "POST",
			      url: url1,
			      data: $("#return_tx").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
			      success: function (data) {
		            alert('Transaction Succesfully submitted.');
		            // document.location = '<?php echo base_url() ?>librarymodule/lend';
			         location.reload();
		        		}
			   });
			}
		}
	}
	

	function new_account()
	{
		document.location = '<?php echo base_url()?>librarymodule/new_account';
	}

	function search_accounts()
	{
		document.location = '<?php echo base_url() ?>librarymodule/accounts';
	}

	function dashboard()
	{
		document.location = '<?php echo base_url() ?>librarymodule';
	}

</script>