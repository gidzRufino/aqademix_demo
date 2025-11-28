<?php
	$url1 = $this->uri->segment(3);
?>
<input class="hidden" type="hidden" name="url3" id="url3" value="<?php echo $url1 ?>">
<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="well well-sm" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button type="button" class="btn btn-primary" onclick="newbook()" style="text-align:center;">
						<div class="col-md-12">
						 	<i class="fa fa-file-text-o fa-2x"></i><br/>
						 	<h4>New Item</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-info" onclick="showinventory()" style="text-align:center;">
						<div class="col-md-12">
						 	<i class="fa fa-clipboard fa-2x"></i><br/>
						 	<h4>Item List</h4>
						</div>
					</button>
				</div>
				<div class="col-md-2">
		          	<button type="button" class="btn btn-warning" onclick="goinventory()" style="text-align:center">
		            	<div class="col-md-12">
		              		<i class="fa fa-star fa-2x"></i><br/>
		              		<h4>Inventory</h4>
		            	</div>
		          	</button>
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
		<div class="jumbotron" id="addi">
		  	<h1>Hello!</h1>
		  	<p>You can add new items and also display all your item's inventory from here! </p>
		  	<!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->
		</div>
		<div id="new_entry" style="display:none">
			
		 <?php 
		 	// $data['bk_author'] = $bk_author;
		   $this->load->view('forms/new_entry', $data); 
		 ?>    

		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
    // $("#bk_author").select2();
    // $("#bk_sor").select2();
    // $("#bk_dewey").select2();
    $("#bk_deweysi").select2();
    $("#bk_category").select2();
    $("#bk_publisher").select2();
    $("#bk_status").select2();
    $("#bk_shelf").select2();
    $("#bk_tt1").select2();
    $("#bk_tt2").select2();
    $("#bk_tt3").select2();
    // $("#bk_dewey").select2();
    $("#ebk_property").select2();
    var url3 = document.getElementById('url3').value;

    if (url3=='i'){
    	showinventory();
    }else if (url3=='b') {
    	newbook();
    }

   });
	
	function dashboard()
	{
		document.location = '<?php echo base_url()?>librarymodule';
	}

	function newbook()
	{
		document.getElementById("addi").hidden = true;
		$("#new_entry").css('display','block');
		$("#show_inventory").css('display', 'none');
	}

	function showinventory()
	{
		// document.getElementById("addi").hidden = true;
		// $("#new_entry").css('display','none');
		// $("#show_inventory").css('display', 'block');	
		document.location = '<?php echo base_url()?>librarymodule/inventory';	
	}

	function goinventory()
	{
		// document.getElementById("addi").hidden = true;
		// $("#new_entry").css('display','none');
		// $("#show_inventory").css('display', 'block');	
		document.location = '<?php echo base_url()?>librarymodule/item_list';	
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