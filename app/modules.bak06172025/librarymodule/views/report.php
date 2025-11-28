<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="" style="margin: 10px 0px">
			<div class="row">
				<div class="col-md-3">
					<h3>Reports</h3>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<form class="form-horizontal" id="reportin" name="reportin">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4 col-md-offset-1">
						<h4>Select Reports</h4>
						<select class="pull-right" tabindex="-1" id="selrep" style="width: 50%; margin-top: -30px;">
						<!-- <select class="pull-right" tabindex="-1" onclick="get_report()" id="selrep" style="width: 50%; margin-top: -30px;"> -->
			             	<option>Select Report</option>
			             	<option value="1">Borrowed Books</option>
			             	<option value="2">Borrower</option>
			             	<option value="3">Library Entrance</option>
			             	<option value="4">Summary</option>
			           	</select>		
					</div>
					<div class="col-md-2">
						<h4>From</h4>
						<input type="text" class="pull-right" style="width: 75%; margin-top: -30px;" id="sfrom" name="sfrom" placeholder="Date Acquired" data-date-format="yyyy-mm-dd" required>			
					</div>
					<div class="col-md-2">
						<h4>To</h4>
						<input type="text" class="pull-right" style="width: 75%; margin-top: -30px;" id="sto" name="sto" placeholder="Date Acquired" data-date-format="yyyy-mm-dd" required>	
					</div>
					<div class="col-md-1">
						<button class="btn btn-primary btn-sm" id="fetch_now" type="button">Fetch Report</button> 
					</div>
				</div>
			</div>
			</form>
			<div class="panel-body">
				<div id="reportdiv">
					<table class="table table-condensed table-bordered">
						<?php 
							$uri1 = $this->uri->segment(3);
							$uri2 = $this->uri->segment(4);
							$uri3 = $this->uri->segment(5);
							if ($uri1=='b') {
								$rfrom = strtotime(date('Y-m-d', strtotime($uri2)));
								$rto = strtotime(date('Y-m-d', strtotime($uri3)));
						?>
						<thead>
							<tr>
								<th class="text-center">Title</th>
								<th class="text-center">Author</th>
								<th class="text-center">Borrowed by</th>
								<th class="text-center">Due Date</th>
								<th class="text-center">Date Returned</th>
							</tr>
						</thead>
						<?php
								foreach ($brecords as $rec) {
									$duedate = $rec->tr_due_date;
									$duedate = strtotime(date('Y-m-d', strtotime($duedate)));
									if ($duedate&&$duedate>=$rfrom&&$duedate<=$rto) {
						?>
							<tr>
								<td class="text-center"><?php echo $rec->gb_title ?></td>
								<td class="text-center"><?php echo $rec->gb_author ?></td>
								<td class="text-center"><?php echo $rec->lastname.', '.$rec->firstname ?></td>
								<td class="text-center"><?php echo $rec->tr_due_date ?></td>
								<td class="text-center"><?php echo $rec->tr_ret_date ?></td>
							</tr>


						<?php
									}						
								}
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#selrep").select2();
		$("#sfrom").datepicker();
		$("#sto").datepicker();
	});

	$("#fetch_now").click(function(){
		var getval = document.getElementById('selrep').value;
		var gfrom = $("#sfrom").val();
		var gto = $("#sto").val();
		if (getval==1) {
			document.location = '<?php echo base_url()?>librarymodule/report/b/' + gfrom + '/' + gto; 

		}
	});

</script>
