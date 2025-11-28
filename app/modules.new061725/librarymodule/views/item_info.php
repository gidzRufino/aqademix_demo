<script type="text/javascript">
   $(function(){
   	$("#tsort").tablesorter({debug: true});
   });  
</script>
<style type="text/css">
	p{
		margin:0 0 0 0;
		font-size: 15px;
	}
	span{
		color: teal;
	}
	.xtra{
		margin: 10px 0px;
	}
	.text-left{
		margin-left: -20px;
	}
</style>
<?php
	$ext1 = $this->uri->segment(3);
	$ext2 = $this->uri->segment(4);
?>

<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="well well-sm" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-primary" onclick="newbook()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-file-text-o fa-2x"></i><br/>
						 	<h4>New Item</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-info" onclick="showinventory()" style="text-align:center">
						<div class="col-md-12">
						 	<i class="fa fa-clipboard fa-2x"></i><br/>
						 	<h4>Item List</h4>
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
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<b>Item Information</b>
						<button type="button" class="btn btn-primary btn-xs pull-right" id="edit_sitem" style="margin-right: 5px;" data-toggle="modal" data-placement="left" title="Click to edit this item information." ><i class="fa fa-pencil fa-fw"></i>&nbsp;Edit</button>
						<button type="button" class="btn btn-primary btn-xs pull-right" id="edit_bitem" style="margin-right: 5px;" data-toggle="modal" data-placement="left" title="Click to edit batch item information." ><i class="fa fa-sitemap fa-fw"></i>&nbsp;Batch Edit</button>
					</div>
					<div class="panel-body">
						<div class="row">
			  				<div class="col-md-8">
			  					<div class="col-md-4">			  						
	  								<div rel="clickover" 
										data-content='<?php $gb_id = $item_info->gb_id; echo Modules::run('librarymodule/cover_upload', $gb_id) ?>'
										class="clickover">
										<img class="img-responsive" style="width: 100%; border:1px solid gray;" src="<?php if($item_info->gb_pic!=""):echo base_url().'uploads/'.$item_info->gb_pic;else:echo base_url().'images/booki.png'; endif;  ?>" />
					                </div>
					                <div class="text-center" style="padding: 5px; border:1px solid gray; margin: 5px;">
					                	<b style="font-size: 18px;">Item Status</b>
					                	<b style="font-size: 18px; color: teal;"><?php echo $item_info->st_status ?></b>
				  					
					            	</div>
			  					</div>
			  					<div class="col-md-8">
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Title</b></div>
			  							<div class="col-md-8 text-left"><a href="<?php echo base_url('librarymodule/books/'.base64_encode($item_info->gb_id)) ?>"><b><span><?php echo $item_info->gb_title ?></span></b></a></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Sub Title</b></div>
			  							<div class="col-md-8 text-left"><span><?php echo $item_info->gb_sub_title ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Author</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_author): echo $item_info->gb_author; else: echo 'No Information'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Other Author(s)</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_co_author): echo $item_info->gb_co_author; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Publisher</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->pub_publication): echo $item_info->pub_publication; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Copyright Year</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->bk_copyright_yr): echo '<i class="fa fa-copyright"></i> '.$item_info->bk_copyright_yr; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Dewey Decimal</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_dw): echo $item_info->gb_dw; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Topical Terms</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_topical_terms): echo $item_info->gb_topical_terms; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Content Description and Remarks</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_remarks): echo $item_info->gb_remarks; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  					</div>
			  				</div>
			  				<div class="col-md-4">
			  					<div class="row">
		  							<div class="col-md-4 text-right"><b>Item ID</b></div>
		  							<div class="col-md-8 text-left"><b><span><?php echo $item_info->bk_id ?></span></b></div>
		  						</div>
		  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Call #</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->bk_call_number): echo $item_info->bk_call_number; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>ISBN</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->bk_isbn): echo $item_info->bk_isbn; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Serial #</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->bk_serial_num): echo $item_info->bk_serial_num; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Volume</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->gb_volume): echo $item_info->gb_volume; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Edition</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->bk_edition): echo $item_info->bk_edition; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Location</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($item_info->sh_number): echo $item_info->sh_number; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  				</div>
			  			</div>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<b>Item History</b>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<table id="tsort" class="tablesorter table table-condensed table-bordered">
								<thead style="background:#E6EEEE;">
								<tr class="bg-primary">
									<th class="text-center">Status</th>
									<th class="text-center">User</th>
									<th class="text-center">Date Out</th>
									<th class="text-center">Due Date</th>
									<th class="text-center">Date Returned</th>
									<th class="text-center">Remarks</th>
									<th class="text-center">Librarian ID</th>
								</tr>
								</thead>

								<?php 
									foreach ($item_history as $ih) {
								?>
								<tr>
									<td class="text-center"><?php echo $ih->st_status ?></td>
									<td class="text-center"><a href="<?php echo base_url('librarymodule/show_account/'.base64_encode($ih->tr_eu_id)) ?>"><?php echo $ih->lastname.', '.$ih->firstname ?></td>
									<td class="text-center"><?php echo $ih->tr_date ?></td>
									<td class="text-center"><?php echo $ih->tr_due_date ?></td>
									<td class="text-center"><?php echo $ih->tr_ret_date ?></td>
									<td class="text-center"><?php echo $ih->tr_remarks ?></td>
									<td class="text-center"><?php echo $ih->tr_staff_id ?></td>
								</tr>

								<?php
									}
								?>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal -->

<div id="edit_bitem_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  	<div class="modal-content">
	    	<div class="modal-header bg-primary">
	      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	      	<h4 class="modal-title" id="modal_title">Edit General Info: <?php echo $item_info->gb_title ?></h4>
	    	</div>

	    	<?php 
	    		$item_id = $item_info->bk_id;
	    		$base_id = substr($item_id,0,12);
	    		$count_i = 0;
	    			$test = '';
	    		foreach ($gen_item as $gi) {
	    			
	    			$comp_item = $gi->bk_id;
	    			$base_comp = substr($comp_item,0, 12);
	    			$test = $test.'|'.$base_id.'<>'.$base_comp;
	    			if ($base_id==$base_comp) {
	    				$count_i++;

	    			}
	    		}
	    	?>

	 		<div class="modal-body">
	 			<form class="form-horizontal" id="edit_g_item" name="edit_g_item">
		 			<input type="hidden" name="icount" id="icount" value="<?php echo $count_i ?>" required>
		 			<input type="hidden" name="istat" id="istat" value="<?php echo $item_info->bk_st_id ?>" required>
		 			<input type="hidden" name="gb_id" id="gb_id" value="<?php echo $item_info->bk_gb_id ?>" required>
		 			<input type="hidden" name="iswitch" id="iswitch" required>
	 				<input type="hidden" name="ext1" id="ext1" value="<?php echo $ext1 ?>">
					<input type="hidden" name="ext2" id="ext2" value="<?php echo $ext2 ?>">
					<input type="hidden" name="base_ext" id="base_ext" value="<?php echo $base_id ?>">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4">
							<label for="bk_publisher">Publishers</label>
							<div class="controls">
								<select id="bk_publisher" name="bk_publisher" tabindex="-1" style="width:90%;">
									<option value="<?php echo $item_info->pub_id ?>"><?php echo $item_info->pub_publication ?></option>
										<?php foreach ($bk_publication as $bpub) { ?>
									<option value="<?php echo $bpub->pub_id ?>"><?php echo $bpub->pub_publication ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_serial">Serial Number</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_serial" name="bk_serial" placeholder="Serial Number" value="<?php echo $item_info->bk_serial_num ?>">				
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_serial">Call Number</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_call_number" name="bk_call_number" placeholder="Call Number" value="<?php echo $item_info->bk_call_number ?>">		
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div id="dstatus" class="form-group col-md-4">
							<label for="bk_status">Status</label>
							<div class="controls">
								<select id="bk_status" name="bk_status" tabindex="-1" style="width:90%;">
									<option value="<?php echo $item_info->bk_st_id ?>"><?php echo $item_info->st_status ?></option>
										<?php foreach ($bk_status as $bs) { ?>
									<option value="<?php echo $bs->st_id ?>"><?php echo $bs->st_status ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<!-- <div class="form-group col-md-4 ">
							<label for="bk_date_pub">Date Published</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_date_pub" name="bk_date_pub" placeholder="Date published" data-date-format="yyyy-mm-dd" value="<?php echo $item_info->bk_pub_date ?>" required>					
							</div>
						</div> -->
						<div class="form-group col-md-4">
							<label for="bk_rfid">Physical Description</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_pdesc" name="bk_pdesc" placeholder="Description of the item" value="<?php echo $item_info->bk_physical_desc ?>">
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_rfid">RFID</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_rfid" name="bk_rfid" placeholder="Assign RFID" value="<?php echo $item_info->bk_rfid ?>">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_copyright">Copyright</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_copyright" name="bk_copyright" placeholder="Assign Copyright Year"
								value="<?php echo $item_info->bk_copyright_yr ?>">	
							</div>
						</div>
					</div>				
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4 ">
							<label for="bk_edition">Edition</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_edition" name="bk_edition" placeholder="item edition" value="<?php echo $item_info->bk_edition ?>">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_isbn">ISBN</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_isbn" name="bk_isbn" placeholder="item ISBN" value="<?php echo $item_info->bk_isbn ?>">					
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_media">Media Type</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_media" name="bk_media" placeholder="item media type" value="<?php echo $item_info->bk_media_type ?>">						
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4 ">
							<label for="bk_cost_price">Cost / Price</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_cost_price" name="bk_cost_price" placeholder="Cost/Price of the item" value="<?php echo $item_info->bk_cost_price ?>">
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_date_acquired">Date Acquired</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_date_acquired" name="bk_date_acquired" placeholder="Date Acquired" data-date-format="yyyy-mm-dd" value="<?php echo $item_info->bk_date_acquired ?>" required>					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_acq_source">Acquisition Source</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_acq_source" name="bk_acq_source" placeholder="Sourch of acquisition" value="<?php echo $item_info->bk_source ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4 ">
							<label for="bk_fine">Overdue Fine</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_fine" name="bk_fine" placeholder="Fine setting in case of overdue" value="<?php echo $item_info->bk_fn_id ?>">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_brw_days">Allowable Borrow days</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_brw_days" name="bk_brw_days" placeholder="Allowable borrow days" value="<?php echo $item_info->bk_borrow_days ?>">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_date_pub">Shelf Assignment/Location</label>
							<div class="controls">
								<select id="bk_shelf" name="bk_shelf" tabindex="-1" style="width:90%;">
									<option value="<?php echo $item_info->bk_shelf_id ?>"><?php echo $item_info->sh_number ?></option>
										<?php foreach ($bk_shelf as $bshelf) { ?>
									<option value="<?php echo $bshelf->sh_id ?>"><?php echo $bshelf->sh_number.' | '.$bshelf->sh_location_desc ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-mini" id="save_edit"><b><i class="fa fa-check fa-fw"></i>Save</b></button>
	  			<button type="button" class="btn btn-danger btn-mini" data-dismiss="modal"><b><i class="fa fa-times fa-fw"></i>Cancel</b></button>
			</div>
		</div>
	</div>
</div>

<!-- modal (end) -->

<!-- 

fetch item information
get base item id
get general item information
for every general item fetch and count equal base item id

 -->


<script type="text/javascript">

	$(document).ready(function() {
    $("#bk_author").select2();
    $("#bk_category").select2();
    $("#bk_publisher").select2();
    $("#bk_status").select2();
    $("#bk_dewey").select2();	
    $("#bk_shelf").select2();	
    $("#ebk_property").select2();
   });

   $("#edit_sitem").click(function(){
   	var istat = document.getElementById("istat").valuel;
   	if (istat===1) {
   		var x = document.getElementById("dstatus");
		x.style.display = "none";	
   	};
   	$("#edit_bitem_modal").modal('show');
   	document.getElementById("iswitch").value = 'single';
   	document.getElementById("modal_title").innerHTML = "Edit this item: <?php echo $item_info->gb_title ?>";

   });
	
	$("#edit_bitem").click(function(){
		var x = document.getElementById("dstatus");
		x.style.display = "none";
		var bnum = document.getElementById('base_ext').value;
		alert("Editing item batch number: " + bnum);
   		$("#edit_bitem_modal").modal('show');
   		document.getElementById("iswitch").value = 'multiple';
   		document.getElementById("modal_title").innerHTML = "Edit this item batch # "+bnum + " | Title: <?php echo $item_info->gb_title ?>";

   });

   $("#save_edit").click(function(){
   	var edit_type = document.getElementById('iswitch').value;
   	var ext1 = document.getElementById('ext1').value;
   	var ext2 = document.getElementById('ext2').value;
   	var resp = confirm("Do you really want to save the changes that you have made?");
   	if (resp == true){
   		if (edit_type == "single") {
    			var url1 = '<?php echo base_url() ?>librarymodule/edit_item/i_s';     
   		}else if (edit_type == "multiple"){
   			var url1 = '<?php echo base_url() ?>librarymodule/edit_item/i_m';     
   		}
   		// alert(url1);
   		$.ajax({
	        	type: "POST",
	        	url: url1,
	        	data: $("#edit_g_item").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
	        	dataType: 'json',
	        	success: function (data) {
	            alert('Transaction Succesfully submitted.');
	            document.location = '<?php echo base_url() ?>librarymodule/item/' + ext1 + '/' + ext2;
	            // alert(data.messi);
	            // location.reload();
	        	}
	    	});
   	};
   });

	function dashboard()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}

	function newbook()
	{
	document.location = '<?php echo base_url()?>librarymodule/books/b';
	}

	function showinventory()
	{
		document.location = '<?php echo base_url()?>librarymodule/books/i';
	}

	function assign_dd()
	{
		var dds = document.getElementById('select_dds').value;
		document.getElementById('bk_dewey_dummy').value =  dds;
		document.getElementById('bk_dewey').value =  dds;
	}

	function golend()
	{
		document.location = '<?php echo base_url()?>librarymodule/lend';
	}

</script>