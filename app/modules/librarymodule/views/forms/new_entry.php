<?php
	$userid = $this->session->userdata('username');
	$check = $this->uri->segment(3);
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#ebk_prop").select2();
	});
</script>
<form class="form-horizontal" id="new_book" name="new_book">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<b>New Item Entry - General Information</b>
			<button type="button" style="display:block;"id="copy_existing" class="btn btn-xs btn-danger pull-right "><b><i class="fa fa-copy fa-fw "></i> Copy existing item property</b></button>
			<button type="button" style="display:none;" id="add_new" class="btn btn-xs btn-danger pull-right "><b><i class="fa fa-plus fa-fw "></i> New item property</b></button>
			<?php
				if ($check!=""){
			?>
				<input type="hidden" name="add_indicator" id="add_indicator" value="new" required>
			<?php
				}else{
			?>
				<input type="hidden" name="add_indicator" id="add_indicator" value="old" required>
			<?php
				}
			?>
		</div>
		<div class="panel-body" id="existing_book_prop">
			<div class="col-md-11 col-md-offset-1">
				<div class="row">
					<div class="form-group col-md-11">
						<label for="bk_publisher">Select an existing Item Property</label>
						<div class="controls">
							<select id="ebk_prop" name="ebk_prop" tabindex="-1" style="width:100%;">
								<option>Item Properties</option>
									<?php foreach ($bk_lib_general as $blg) { ?>
								<option value="<?php echo $blg->gb_id ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->gb_author.' | Vol.'.$blg->gb_volume.' | Dewey: ['.$blg->gb_dw.'] '.$blg->gb_remarks ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body" >
			<div class="row" id="new_book_prop">
				<div class="col-md-11 col-md-offset-1">
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="book_title"> Title</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="book_title" name="book_title" placeholder="Enter item Title">					
							</div>
						</div>
						<div class="form-group col-md-6 ">
							<label for="book_title"> Sub Title</label>
							<div class="controls">
								<input type="text" style="width:87%;" id="book_sub_title" name="book_sub_title" placeholder="Enter item Sub Title">					
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="input">Author</label>
							<div id="sel_author" class="controls">
								<div class="controls">
									<input type="text" style="width:90%;" id="bk_author" name="bk_author" placeholder="Enter Author">					
								</div>
							</div>
							<!-- <div id="sel_author" class="controls">
								<select id="bk_author" name="bk_author" tabindex="-1" style="width:80%;">
									<option value="">Select item Author</option>
										<?php foreach ($bk_author as $bka) { ?>
									<option value="<?php echo $bka->au_id ?>"><?php echo $bka->au_name ?></option>
										<?php } ?>
								</select>
								<button id="add_bk_author" type="button" data-toggle="modal" data-target="#add_bk_author_modal" class="btn btn-xs btn-success"><b><i class="fa fa-plus fa-fw "></i></b></button>
							</div> -->
						</div>
						<div class="form-group col-md-4">
							<label for="input">Other Author(s)</label>
							<div id="sel_sor" class="controls">
								<div class="controls">
									<input type="text" style="width:90%;" id="bk_other_auth" name="bk_other_auth" placeholder="Enter other author(s)">					
								</div>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="input">Statement of Responsibility</label>
							<div id="sel_sor" class="controls">
								<div class="controls">
									<input type="text" style="width:90%;" id="bk_sor" name="bk_sor" placeholder="Enter Statement of Responsibility">					
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="input">Series Statement</label>
							<div id="sel_sor" class="controls">
								<div class="controls">
									<input type="text" style="width:90%;" id="bk_ss" name="bk_ss" placeholder="Enter Series statement">					
								</div>
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_volume">Volume</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_volume" name="bk_volume" placeholder="Enter item volume">					
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_dewey">Dewey Decimal Classification</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_dewey" name="bk_dewey" placeholder="Enter Dewey Decimal Classification">					
							</div>
							<!-- <div class="controls">
								<select tabindex="-1" id="bk_dewey" name="bk_dewey" style="width: 80%;">
					                <option value="">Dewey Decimal System</option>
					                  <?php foreach ($bk_dewey as $dd) { ?>
					                <option value="<?php echo $dd->dwc_id; ?>"><?php echo $dd->dwc_cat_id.' &nbsp|&nbsp'.$dd->dwc_description; ?></option>
					                  <?php } ?>
				              	</select>
				              	<button id="add_bk_dds" type="button" data-toggle="modal" data-target="#add_bk_dds_modal" class="btn btn-xs btn-success"><b><i class="fa fa-plus fa-fw "></i></b></button>
							</div> -->
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="bk_category">Category</label>
							<div class="controls">
								<select id="bk_category" name="bk_category" tabindex="-1" style="width:90%;">
									<option>Select Category</option>
										<?php foreach ($bk_category as $bc) { ?>
									<option value="<?php echo $bc->ca_id ?>"><?php echo $bc->ca_category ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group col-md-8">
							<label for="bk_tt">Topical Terms</label>
							<div class="controls">
								<textarea class="form-control" rows="2" style="width:90%;" id="bk_tt" name="bk_tt" placeholder="Enter topical terms..." ></textarea> 					
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="bk_remarks">Content Description / Remarks</label>
							<div class="controls">
								<textarea class="form-control" rows="2" style="width:90%;" id="bk_remarks" name="bk_remarks" placeholder="Enter content description..." ></textarea> 					
							</div>
						</div>
						<!-- <div class="form-group col-md-11">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<b>Topical Terms</b>
								</div>
								<div class="panel-body">
									<div class="controls">
										<select tabindex="-1" id="bk_tt1" name="bk_tt1" style="width: 85%;">
							                <option value="">Topical Term 1</option>
							                  <?php foreach ($bk_topical_terms as $tt) { ?>
							                <option value="<?php echo $tt->tt_id; ?>"><?php echo $tt->tt_topical_term ?></option>
							                  <?php } ?>
						              	</select>
						              	<button id="add_bk_tt" type="button" data-toggle="modal" data-target="#add_bk_tt_modal" class="btn btn-xs btn-success"><b><i class="fa fa-plus fa-fw "></i></b></button>
									</div>
									<div class="controls" style="margin: 10px 0;">
										<select tabindex="-1" id="bk_tt2" name="bk_tt2" style="width: 90%;">
							                <option value="">Topical Term 2</option>
							                  <?php foreach ($bk_topical_terms as $tt) { ?>
							                <option value="<?php echo $tt->tt_id; ?>"><?php echo $tt->tt_topical_term ?></option>
							                  <?php } ?>
						              	</select>
									</div>
									<div class="controls">
										<select tabindex="-1" id="bk_tt3" name="bk_tt3" style="width: 90%;">
							                <option value="">Topical Term 3</option>
							                  <?php foreach ($bk_topical_terms as $tt) { ?>
							                <option value="<?php echo $tt->tt_id; ?>"><?php echo $tt->tt_topical_term ?></option>
							                  <?php } ?>
						              	</select>
									</div>	
								</div>	
							</div>
						</div>
					</div> -->
				</div>
			</div>	
		</div>
		<div class="hidden">

			<?php
            $usrCode = substr($userid, 0, 3);
            $sysRef = date("ymdHis") . "-" . $usrCode;
            $tdate = date("Y-m-d");
         ?>        
         	<input type="hidden" name="u_id" id="u_id" value="<?php echo $userid ?>" required>
            <input type="hidden" name="gb_id" id="gb_id" value="<?php echo $sysRef ?>" required>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<b>Specific item Information</b>
				<span class="pull-right">Number of copies &nbsp<input type="number" min="1" style="width:40px; font-size: x-small; text-align: center;" id="num_of_copies" name="num_of_copies" placeholder="#"></span>
			</div>
			<div class="panel-body">
				<div class="col-md-11 col-md-offset-1">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="bk_call_number">Call Number</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_call_number" name="bk_call_number" placeholder="Enter call number">					
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_access_number">Accession Number</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_access_number" name="bk_access_number" placeholder="Enter Accession Number">					
							</div>
						</div>
						<!-- <div class="form-group col-md-4">
							<label for="bk_extent">Extent</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_extent" name="bk_extent" placeholder="Item Extent">					
							</div>
						</div> -->
						<div class="form-group col-md-4">
							<label for="bk_publisher">Publisher</label>
							<div class="controls">
								<select id="bk_publisher" name="bk_publisher" tabindex="-1" style="width:80%;">
									<option value="">Select item Publisher</option>
										<?php foreach ($bk_publication as $bpub) { ?>
									<option value="<?php echo $bpub->pub_id ?>"><?php echo $bpub->pub_publication ?></option>
										<?php } ?>
								</select>
								<button id="add_bk_publisher" type="button" data-toggle="modal" data-target="#add_bk_publisher_modal" class="btn btn-xs btn-success"><b><i class="fa fa-plus fa-fw "></i></b></button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="bk_serial">Serial Number</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_serial" name="bk_serial" placeholder="Serial Number">					
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="bk_status">Status</label>
							<div class="controls">
								<select id="bk_status" name="bk_status" tabindex="-1" style="width:90%;">
									<option value="">Select item Status</option>
										<?php foreach ($bk_status as $bs) { ?>
									<option value="<?php echo $bs->st_id ?>"><?php echo $bs->st_status ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
					<!-- </div>
					<div class="row"> -->
						<!-- <div class="form-group col-md-4 ">
							<label for="bk_date_pub">Date Published</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_date_pub" name="bk_date_pub" placeholder="Date published" data-date-format="yyyy-mm-dd" required>					
							</div>
						</div> -->
						<div class="form-group col-md-4 ">
							<label for="bk_rfid">RFID</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_rfid" name="bk_rfid" placeholder="Assign RFID">					
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4 ">
							<label for="bk_copyright">Copyright Year</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_copyright" name="bk_copyright" placeholder="Assign Copyright Year">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_edition">Edition</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_edition" name="bk_edition" placeholder="item edition">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_isbn">ISBN</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_isbn" name="bk_isbn" placeholder="item ISBN">					
							</div>
						</div>
					</div>
					<div class="row">
						<!-- <div class="form-group col-md-4 ">
							<label for="bk_dimension">Dimension</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_dimension" name="bk_dimension" placeholder="item Dimension">					
							</div>
						</div> -->
						<div class="form-group col-md-4 ">
							<label for="bk_cost_price">Cost / Price</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_cost_price" name="bk_cost_price" placeholder="Cost/Price of the item">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_date_acquired">Date Acquired</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_date_acquired" name="bk_date_acquired" placeholder="Date Acquired" data-date-format="yyyy-mm-dd" required>					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_acq_source">Acquisition Source</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_acq_source" name="bk_acq_source" placeholder="Sourch of acquisition">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4 ">
							<label for="bk_fine">Overdue Fine</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_fine" name="bk_fine" placeholder="Fine setting in case of overdue">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_brw_days">Allowable Borrow days</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_brw_days" name="bk_brw_days" placeholder="Allowable borrow days">					
							</div>
						</div>
						<div class="form-group col-md-4 ">
							<label for="bk_date_pub">Shelf Assignment/Location</label>
							<div class="controls">
								<select id="bk_shelf" name="bk_shelf" tabindex="-1" style="width:90%;">
									<option>Shelf Assignment/Location</option>
										<?php foreach ($bk_shelf as $bshelf) { ?>
									<option value="<?php echo $bshelf->sh_id ?>"><?php echo $bshelf->sh_number.' | '.$bshelf->sh_location_desc ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4 ">
							<label for="bk_rfid">Physical Description</label>
							<div class="controls">
								<input type="text" style="width:90%;" id="bk_pdesc" name="bk_pdesc" placeholder="Description of the item">		
							</div>
						</div>
					</div>				
					<!-- <div class="row"> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 pull-right">
				<button type="button" id="save_bk" class="btn btn-sm btn-success pull-right"><b><i class="fa fa-save fa-fw "></i>Save</b></button>
				<button type="button" id="cancel_bk" class="btn btn-sm btn-danger pull-right"><b><i class="fa fa-times fa-fw "></i>Cancel</b></button>
			</div>
		</div>
	</div>
</form>
<!-- <div class="panel-footer"> -->
	
<!-- </div> -->


<script type="text/javascript">

$(document).ready(function () {
	$("#ebk_prop").select2();
	$('#bk_date_pub').datepicker();
	$('#bk_date_acquired').datepicker();
   $("#copy_existing").css('display', 'block');
   $("#add_new").css('display', 'none');
   $("#new_book_prop").css('display', 'block');
   $("#existing_book_prop").css('display', 'none');
   document.getElementById('add_indicator').value = 'new';

});

$("#copy_existing").click(function(){
	$("#copy_existing").css('display', 'none');
   $("#add_new").css('display', 'block');
   $("#new_book_prop").css('display', 'none');
   $("#existing_book_prop").css('display', 'block');
   document.getElementById('add_indicator').value = 'old';
});

$("#add_new").click(function(){
	$("#copy_existing").css('display', 'block');
	$("#add_new").css('display', 'none');
	$("#new_book_prop").css('display', 'block');
	$("#existing_book_prop").css('display', 'none');
	document.getElementById('add_indicator').value = 'new';
});


$("#save_bk").click(function(){
	
    var num = document.getElementById('num_of_copies').value;
    var check = document.getElementById('add_indicator').value;
    var ttle = document.getElementById('book_title').value;
    var auth = document.getElementById('bk_author').value;
    var dew = document.getElementById('bk_dewey').value;
    // var vol = document.getElementById('bk_volume').value;
    var stat = document.getElementById('bk_status').value;
    var ebk = document.getElementById('ebk_prop').value;
    var ind = document.getElementById('add_indicator').value;
    push = 0;

    if (ind==='new') {
    	if (ttle!='' && auth!='' && dew!='' && stat!='') {
    		push = 1;
    	}else{
    		push = 0;
    		alert('Please provide at least the following: Item Title, Author, DDS, Volume, Status. Thanks.')
    	}

    }else if(ind==='old') {
    	if (stat!='' && ebk!='') {
    		push = 1;
    	}else{
    		push = 0;
    		alert("Please select existing item property and it's corresponding status and try again. Thanks.")
    	}
    };
    
    if (push===1) {
    	if (num!=''||num!=0){
	    	var url1 = "<?php echo base_url() . 'librarymodule/save_book' ?>/"+num+"/"+check; 
		    $.ajax({
		        type: "POST",
		        url: url1,
		        data: $("#new_book").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
		        success: function (data) {
		            alert('Transaction Succesfully submitted.');
		            document.location = '<?php echo base_url() ?>librarymodule/books';
		            // location.reload();
		        }
		    });    
	   }else{
	   	alert('Please indicate the number of item copies and try again. Thanks!');
	   }
	}
});


	

</script>
  
