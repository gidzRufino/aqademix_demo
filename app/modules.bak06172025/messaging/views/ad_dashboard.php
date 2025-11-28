<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<h1>Tapping Station Ads Dashboard <small>Ads to be displayed on Idle Mode</small></h1>					
		<div class="" style="margin-bottom: 0px">
			<div class="row">
				<div class="col-lg-5">
	                <div class="panel panel-primary">
	                	<div class="panel-heading">
							<b>Upload new video / image ad</b>
	                	</div>
	                	<div class="panel-body">
	                		<b>Note: </b><span>Please select a file that is not greater than 15MB. The filename should also not contain any special characters. Only mp4 and mov file format for videos as well as jpg and png format for images are allowed. </span><br /><br />
			                <form action="uploadfiles" id="upload_form" enctype="multipart/form-data" method="post">
				                <!-- <div id="uploadStatus" class="col-lg-12" style="margin: 10px 0;">
				                    
				                </div>  -->
			                	<input type="file" name="userfile" id="userfile"><br />
			                	<!-- <input type="text" name="remarks" id="remarks"><br /> -->
			                	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
			                	<input class="btn btn-primary" type="submit" value="Upload File"> <br />
			                	<!-- <input class="btn btn-xs btn-success" value="Upload File" onclick="uploadFile()"> <br /> -->
			                	<!-- <div id="progressBarWrapper" class="progress" style="margin-top:10px;">
			                    	<div class="progress-bar progress-bar-success" id="progressBar" style="width: 0;" >
			                        0%
			                      	</div>
			                	</div> -->
			             	</form>		
	                	</div>
	                </div>
            	</div>
            	<!-- <div class="row"> -->
            	<div class="col-lg-7">
            		<div class="panel panel-primary">
            			<div class="panel-heading">
            				Ads Archive
            			</div>	
  			        	<div class="panel-body">
  			        		<table class="table table-condensed table-bordered" style="width:100%;">
  			        			<thead>
  			        				<tr>
  			        					<th class="text-center" width="50">Active</th>
  			        					<th class="text-center" width="200">ADS</th>
  			        					<th class="text-center">Date Added</th>
  			        					<th class="text-center">Format</th>
  			        					<!-- <th class="text-center">Remarks</th>
  			        					<th class="text-center">Action</th> -->
  			        				</tr>
  			        			</thead>
  			        			<tbody>

  			        				<?php 
  			        					foreach ($ads->result() as $ads) {
  			        						$file = base_url('images/ads').'/'.$ads->ad_file;
  			        						$afile = $ads->ad_file;
  			        						if(preg_match('/^.*\.(mp4|mov)$/i', $afile)){
											    $show = "<video width='150' class='ad-img' controls>
                     										<source src='".$file."' type='video/mp4'>
                  										</video>";
                  								$aformat = 'video';
											}elseif(preg_match('/^.*\.(jpg|png|gif)$/i', $afile)){
												$show = "<img class='ad-img' width='150px' src='".$file."'>";
												$aformat = 'image';
											}

											if ($ads->ad_active==1) {
												$act = 'checked';
											}elseif ($ads->ad_active==0) {
												$act = '';
											}
  			        				?>

  			        				<tr>
  			        					<td class="text-center"><input type="checkbox" id="c<?php echo $ads->ad_id ?>"  onclick="ad_activate(this.id)" <?php echo $act ?>></td>
  			        					<td class="text-center"><?php echo $show ?></td>
  			        					<td class="text-center"><?php echo $ads->ad_date ?></td>
  			        					<td class="text-center"><?php echo $aformat ?></td>
                                        <td class="text-center"><button class="btn btn-danger btn-sm" onclick="delete_ads(<?php echo $ads->ad_id ?>)"><i class="fa fa-trash"></i></button></td>  			        					<!-- <td class="text-center"><?php echo $ads->ad_remarks ?></td>
  			        					<td class="text-center"></td> -->
  			        				</tr>
  			        				<?php
  			        					}
  			        				?>

  			        			</tbody>
  			        		</table>
							<em id='successMsg' class='alert alert-success' style="display: none; width: 100%"></em>
							<em id='errorMsg' class='alert alert-danger' style="display: none; width: 100%"></em>
  			        	</div>
  			        </div>
            	</div>
            	<!-- </div> -->
			</div>
		</div> <!-- <div class="well"> -->

		<div class="row" style="margin-top: 15px;">
			
		</div>
		<div class="row">
			
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#ebk_property").select2();
		$(".table").tablesorter({debug: true});
		// $("#allin").DataTable();
	});

	function ad_activate(id)
	{
		var ad_id = document.getElementById(id);
		if (ad_id.checked) {
			var astatus = 1;
		}else{
			var astatus = 0;
		}
		// alert(astatus+' <> '+id);
		var url1 = "<?php echo base_url().'messaging/ad_status' ?>";
		$.ajax({
        	type: "POST",
        	url: url1,
        	data: 'astatus='+astatus+'&ad_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
        	// dataType: 'json',
        	success: function (data) {
            // alert('Transaction Succesfully submitted.');
        	}
    	});
	}

	function uploadFile(){
		var url1 = "<?php echo base_url().'messaging/uploadfiles' ?>";
		var userfile = document.getElementById('userfile').value;
		$.ajax({
        	type: "POST",
        	url: url1,
        	userfile: userfile,
        	data: $("#upload_form").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
        	dataType: 'json',
        	success: function (data) {
                    alert('Transaction Succesfully submitted.');
        	}
    	});

	}

	function delete_ads(id) {
		r = confirm('Are you sure you want to remove this Ads?');
        if(r==true){
			var url = '<?php echo base_url() . 'messaging/delete_ads/' ?>' + id;
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: url,
				success: function (data) {
					if (data.status) {
						$('#successMsg').html(data.msg);
						$('#successMsg').show().delay(3000).queue(function (n) {
							window.location.reload();
							n();
						});
					} else {
						$('#errorMsg').html(data.msg);
						$('#errorMsg').show().delay(5000).queue(function (n) {
							$(this).hide();
							n();
						});
					}
				}
			})
		}
	}
	
	

	
</script>