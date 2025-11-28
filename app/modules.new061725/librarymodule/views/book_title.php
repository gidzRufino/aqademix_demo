<?php
	$url_now = $this->uri->segment(3);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#bk_category").select2();
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
<div class="clearfix" style="margin:0px;">
	<input type="hidden" name="now_url" id="now_url" value="<?php echo $url_now ?>" required>
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
						 	<h4>Lend an item</h4>
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
			  			<button type="button" class="btn btn-primary btn-xs pull-right" id="edit_gitem" style="margin-right: 5px;" data-toggle="modal" data-placement="left" title="Click to edit this item information." data-target="#edit_gitem_modal"><i class="fa fa-pencil fa-fw"></i>&nbsp;Edit</button>
			  		</div>
			  		<div class="panel-body">
			  			<div class="row">
			  				<div class="col-md-8">
			  					<div class="col-md-4">			  						
	  								<div rel="clickover" 
										data-content='<?php $gb_id = $bk->gb_id; echo Modules::run('librarymodule/cover_upload', $gb_id) ?>'
										class="clickover">
										<img class="img-responsive" style="width: 100%; border:1px solid gray;" src="<?php if($bk->gb_pic!=""):echo base_url().'uploads/'.$bk->gb_pic;else:echo base_url().'images/booki.png'; endif;  ?>" />
					                </div>
					                <div class="text-center" style="padding: 5px; border:1px solid gray; margin: 5px;">
					                	<b style="font-size: 18px;">Status Summary</b>
				  					<?php 
				  						$status = array();
				  						foreach ($info_graphic as $is) {

				  							$nd = $is->bk_st_id;
				  							$status[]= $nd - 1;  // array starts at 0
				  							
				  						}
				  						$icount =0;
				  						$count_status = array_count_values($status);
				  						foreach ($bk_status as $key => $value) {
											$test = $count_status[$key];
											if ($test!=""||$test!=null) {
						  					$icount = $icount + $count_status[$key];
				  						?>
				  							
				  							<p><b><?php echo $value->st_status ?>:&nbsp;&nbsp;</b><span><?php echo $count_status[$key] ?></span>&nbsp;&nbsp;</p>
				  						
				  						<?php 
				  							}}
				  						?>
				  					<p><b>Total # of Items:&nbsp;&nbsp;</b><span><?php echo $icount ?></span></p>
					            </div>
			  					</div>
			  					<div class="col-md-8">
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Title</b></div>
			  							<div class="col-md-8 text-left"><b><span><?php echo $bk->gb_title ?></span></b></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Sub Title</b></div>
			  							<div class="col-md-8 text-left"><span><?php echo $bk->gb_sub_title ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Author</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_author): echo $bk->gb_author; else: echo 'No Information'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Other Author(s)</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_co_author): echo $bk->gb_co_author; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Publisher</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->pub_publication): echo $bk->pub_publication; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Call Number</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->bk_call_number): echo $bk->bk_call_number; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Dewey Decimal</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_dw): echo $bk->gb_dw; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>ISBN</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->bk_isbn): echo $bk->bk_isbn; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Copyright Year</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->bk_copyright_yr): echo '<i class="fa fa-copyright"></i> '.$bk->bk_copyright_yr; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-4 text-right"><b>Shelf Location</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->sh_number): echo $bk->sh_number; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Topical Terms</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_topical_terms): echo $bk->gb_topical_terms; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Content Description and Remarks</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_remarks): echo $bk->gb_remarks; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Series Statement</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->gb_series_statement): echo $bk->gb_series_statement; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  						<div class="row xtra">
			  							<div class="col-md-4 text-right"><b>Physical Description</b></div>
			  							<div class="col-md-8 text-left"><span><?php if ($bk->bk_physical_desc): echo $bk->bk_physical_desc; else: echo '< No Information >'; endif; ?></span></div>
			  						</div>
			  					</div>
			  				</div>
			  				<div class="col-md-4">
			  					<div style="overflow-y:scroll; height:300px;padding: 5px;">
			  						<table id="inv_table" class="tablesorter table table-striped" style="width:100%;">
										<thead class="bg-default">
				  							<th class="text-center">Item ID</th>
				  							<th class="text-center">Status</th>
				  							<th class="text-center">Status Date</th>
				  						</thead>
				  						<tbody style="height: 300px;overflow-y:scroll;">

				  						<?php 
				  							$bk_count = 0;
				  							foreach ($bk_display as $bd) {
				  								$bk_count++;
				  						?>

				  						<tr>
				  							<td class="text-center"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($bd->bk_id).'/'.base64_encode($bd->bk_gb_id)) ?>"><?php echo $bd->bk_id ?></a></td>
				  							<td class="text-center"><?php echo $bd->st_status ?></td>
				  							<td class="text-center"><?php echo $bd->bk_st_date ?></td>
				  						</tr>
				  				
				  					<?php
				  						} // foreach $bk_display as $bd
				  					?>
				  						</tbody>
				  						<input type="hidden" name="bk_count" id="bk_count" value="<?php echo $bk_count ?>" required>
				  					</table>
				  				</div>
			  				</div>
			  			</div>

					  	<div class="row">
					  		<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<b>User Feedback</b>
									</div>
									<div class="panel-body">
										
									</div>
							</div>
						</div>
				  	</div>	
		  		</div>
		  	</div>
		</div>
		<div id="show_inventory" style="display:none">

		 <?php 
		 	$data['bk_inventory'] = $bk_inventory;
		   $this->load->view('forms/inventory', $data); 
		 ?>    

		</div>
		<div id="new_entry" style="display:none">
			
		 <?php 
		 	$data['bk_author'] = $bk_author;
		   $this->load->view('forms/new_entry', $data); 
		 ?>    

		</div>
	</div>
</div>

<div id="edit_gitem_modal" class="modal lg-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  	<div class="modal-content">
	    	<div class="modal-header bg-primary">
		      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		      	<h4 class="modal-title" id="myModalLabel">Edit General Item</h4>
	    	</div>
	    	<div class="modal-body">
	    		<div class="row">
		    		<form class="form-horizontal" id="edit_g_item" name="edit_g_item">
		    			<input type="hidden" name="gb_id" id="gb_id" value="<?php echo $bk->gb_id ?>" required>
			    		<div class="col-md-11 col-md-offset-1">
							<div class="row">
								<div class="form-group col-md-6 ">
									<label for="book_title"> Title</label>
									<div class="controls">
										<input type="text" style="width:90%;" id="book_title" name="book_title" value="<?php echo $bk->gb_title ?>">					
									</div>
								</div>
								<div class="form-group col-md-6 ">
									<label for="book_title"> Sub Title</label>
									<div class="controls">
										<input type="text" style="width:87%;" id="book_sub_title" name="book_sub_title" value="<?php echo $bk->gb_sub_title ?>">					
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label for="input">Author</label>
									<div id="sel_author" class="controls">
										<div class="controls">
											<input type="text" style="width:90%;" id="bk_author" name="bk_author" value="<?php echo $bk->gb_author ?>">					
										</div>
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="input">Other Author(s)</label>
									<div id="sel_sor" class="controls">
										<div class="controls">
											<input type="text" style="width:90%;" id="bk_other_auth" name="bk_other_auth" value="<?php echo $bk->gb_co_author ?>">					
										</div>
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="input">Statement of Responsibility</label>
									<div id="sel_sor" class="controls">
										<div class="controls">
											<input type="text" style="width:90%;" id="bk_sor" name="bk_sor" value="<?php echo $bk->gb_sor ?>">					
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label for="input">Series Statement</label>
									<div id="sel_sor" class="controls">
										<div class="controls">
											<input type="text" style="width:90%;" id="bk_ss" name="bk_ss" value="<?php echo $bk->gb_series_statement ?>">					
										</div>
									</div>
								</div>
								<div class="form-group col-md-4 ">
									<label for="bk_volume">Volume</label>
									<div class="controls">
										<input type="text" style="width:90%;" id="bk_volume" name="bk_volume" value="<?php echo $bk->gb_volume ?>">					
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="bk_dewey">Dewey Decimal Classification</label>
									<div class="controls">
										<input type="text" style="width:90%;" id="bk_dewey" name="bk_dewey" value="<?php echo $bk->gb_dw ?>">					
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label for="bk_category">Category</label>
									<div class="controls">
										<select id="bk_category" name="bk_category" tabindex="-1" style="width:90%;">
											<option value="<?php echo $bk->gb_ca_id ?>"><?php echo $bk->ca_category ?></option>
												<?php foreach ($bk_category as $bc) { ?>
											<option value="<?php echo $bc->ca_id ?>"><?php echo $bc->ca_category ?></option>
												<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group col-md-8">
									<label for="bk_tt">Topical Terms</label>
									<div class="controls">
										<textarea class="form-control" rows="2" style="width:90%;" id="bk_tt" name="bk_tt" ><?php echo $bk->gb_topical_terms ?></textarea> 					
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="bk_remarks">Content Description / Remarks</label>
									<div class="controls">
										<textarea class="form-control" rows="2" style="width:90%;" id="bk_remarks" name="bk_remarks"><?php echo $bk->gb_remarks?></textarea> 					
									</div>
								</div>
							</div>
						</div>
					</form> 
				</div>
		    </div>
	    	
	  		<div class="modal-footer">
	  			<span>
	  				<button type="button" class="btn btn-success btn-mini" id="save_edit"><b><i class="fa fa-check fa-fw"></i>Save</b></button>
	  				<button type="button" class="btn btn-danger btn-mini" data-dismiss="modal"><b><i class="fa fa-times fa-fw"></i>Cancel</b></button>
	      	</span>
	    	</div>	
		</div>
	</div>
</div>	

<div id="add_bk_author_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php 
      $data['bk_author'] = $bk_author;
      $this->load->view('forms/bk_author', $data); 
    ?>    
</div>

<div id="add_bk_publisher_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <?php 
      // $data['bk_author'] = $bk_publicaton;
      $this->load->view('forms/bk_publication', $data); 
    ?>    

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
    $("#bk_authori").select2();
    $("#bk_categoryi").select2();
    $("#bk_publisher").select2();
    $("#bk_status").select2();
    $("#bk_deweyi").select2();
    // $("#ebk_property").select2();
    // var bkcount = document.getElementById('bk_count').value;
    // document.getElementById('bkcount').innerHTML = bkcount;
    $(".clickover").clickover({
        placement: 'right',
        html: true
      });
   });

   $("#save_edit").click(function(){
	
    	var num = document.getElementById('book_title').value;
    	var check = document.getElementById('add_indicator').value;
    	var extra = document.getElementById('now_url').value;
    	var resp;
		var press = confirm("Do you want to save the changes that you have made?");
		if (press == true) {
			if (num!=''||num!=null){
    			var url1 = "<?php echo base_url() . 'librarymodule/edit_gitem' ?>"; 
		    	$.ajax({
		        	type: "POST",
		        	url: url1,
		        	data: $("#edit_g_item").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
		        	success: function (data) {
		            alert('Transaction Succesfully submitted.');
		            document.location = '<?php echo base_url() ?>librarymodule/books/'+extra;
		            // location.reload();
		        	}
		    	});    
	   	}else{
	   		alert('Please provide item title and try again.');
	   	}   
		} else {
		    $("#edit_gitem_modal").show('hidden');
		}
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