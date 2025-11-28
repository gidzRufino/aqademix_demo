<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="row">
			<h3>Library Module Settings</h3>
		</div>
		<div class="row">
			<div class="panel-body">
				<div class="tab-content">
        			<div class="panel panel-primary">
						<div class="panel-heading">
							Account activation
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4" id="monitor">
									Now processing <b id="counter"></b> 
								</div>
								<div class="col-md-4 pull-right">
									<button class="btn btn-primary btn-sm pull-right" id="as_btn" type="button">Activate All Students</button> 
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style="margin-top:10px;">
									<div style="background: black; color: green;" id="well_info">
										<div class="col-md-12" style="background: black; color: green;" id="infos">
											
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
<div class="hidden">
	<form id="slist">
		<?php
			$count = 0;
			foreach ($students as $sl) {
				$count++;
		?>

				<input type="hidden" id="sl<?php echo $count ?>" value="<?php echo base64_encode($sl->user_id) ?>" required>
		
		<?php
			}
		?>	
	</form>
	<input type="hidden" id="last_num" value="<?php echo $count ?>" required>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("#well_info").hide();
		$("#monitor").hide();
	});

	$("#as_btn").click(function(){		
		$("#well_info").show();
		$("#monitor").show();
		$("#as_btn").hide();
		var numbers = document.getElementById("last_num").value;
		var num = numbers - 1;
		$("#counter").append('Processing '+ numbers +' accounts... '); 
		for (var i=1; i <= numbers; i++) {
			var pinit = 'sl' + i;
			var apending = document.getElementById(pinit).value;
			// $("#well_info").append('<p>processing '+ apending +'... success </p>');
			var url1 = "<?php echo base_url() . 'librarymodule/activate_profile/' ?>" + apending; 
			$.ajax({
				type: "POST",
				url: url1,
				dataType:'json',
				data: $("#edit_g_item").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
				success: function (data) {
					var info = data.name;
					var msg = data.msg;
					var stat = data.status;
					if (stat==1) {
						$("#infos").append('processing '+ info +'... success...'+ msg +' <br/>');
					}else{
						$("#infos").append('processing '+ info +'... process declined...'+ msg +' <br/>');
					}
					numbers--;
					$("#counter").text(numbers);
					if (numbers==0) {
						$("#counter").text('... PROCESS COMPLETED');
						alert('Process completed!');
					};
				}
			});   
		}

		
	});

</script>













