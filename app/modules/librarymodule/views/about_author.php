<script type="text/javascript">
   $(function(){
   	$("#tsort").tablesorter({debug: true});
   });  
</script>

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
						 	<h4>New Item Entry</h4>
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
						<b>Author Information</b>
						<button type="button" class="btn btn-primary btn-xs pull-right" id="edit_sitem" style="margin-right: 5px;" data-toggle="modal" data-placement="left" title="Click to edit this item information." ><i class="fa fa-pencil fa-fw"></i>&nbsp;Edit</button>
						<!-- <button type="button" class="btn btn-primary btn-xs pull-right" id="edit_bitem" style="margin-right: 5px;" data-toggle="modal" data-placement="left" title="Click to edit batch item information." ><i class="fa fa-sitemap fa-fw"></i>&nbsp;Batch Edit</button> -->
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-bordered" style="width:100%;">
							<tr>
								<th class="bg-primary text-center" style="width: 10%;">Author</th>
								<td colspan="3" style="width: 40%; font-weight: bold;"><?php echo $author->au_name ?></td>
								<th class="bg-primary text-center" style="width: 10%;">Email</th>
								<td colspan="3" style="width: 40%; font-weight: bold;"><?php echo $author->au_email ?></td>
							</tr>
							<tr>
								<th class="bg-primary text-center" style="width: 10%;">Website</th>
								<td colspan="3" style="width: 40%; font-weight: bold;"><?php echo $author->au_web ?></td>
								<th class="bg-primary text-center" style="width: 10%;">Address</th>
								<td colspan="3" style="width: 40%; font-weight: bold;"><?php echo $author->au_address ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<b>Author's Items</b>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<table id="tsort" class="tablesorter table table-condensed table-bordered">
								<thead style="background:#E6EEEE;">
									<tr class="bg-primary">
										<th class="text-center">Item ID</th>
										<th class="text-center">Title</th>
										<th class="text-center">Sub Title</th>
										<th class="text-center">Remarks</th>
										<th class="text-center">Image</th>
									</tr>
								</thead>

								<?php 
									foreach ($abooks as $ab) {
								?>
								<tr>
									<td class="text-center"><?php echo $ab->gb_id ?></td>
									<td class="text-center"><?php echo $ab->gb_title ?></td>
									<td class="text-center"><?php echo $ab->gb_sub_title ?></td>
									<td class="text-center"><?php echo $ab->gb_remarks ?></td>
									<td class="text-center"><img class="img-responsive" style="width: 30%; border:5px solid #fff" src="<?php if($ab->gb_pic!=""):echo base_url().'uploads/'.$ab->gb_pic;else:echo base_url().'images/booki.png'; endif;  ?>" /></td>
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


<script type="text/javascript">

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