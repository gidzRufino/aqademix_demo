
<div class="clearfix" style="margin:0px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="margin-top: 50px;">
				<h1 class="text-center"><i class="fa fa-search fa-2x"></i> Library Search <i class="fa fa-search"></i></h1>
				<!-- <h4 class="text-center">A live searcher... <i class="fa fa-search"></i></h4> -->
			</div>
		</div>
		<div class="row" style="margin-top: 30px;">
			<div class="col-md-7 col-md-offset-3">
				<!-- <form class="form-horizontal" id="searchnow" name="searchnow"> -->
					<div class="input-group">
						<span class="input-group-addon">Search</span>
						<input type="text" style="width:90%;" class="form-control" id="searchbox" name="searchbox" placeholder="Live search for Titles, Authors or keywords">	
						
					</div>
				<!-- </form> -->
			</div>
		</div>
		<div class="row" style="padding-top: 10px;">
			<div class="col-md-12">

				<div id="disp"></div>
			</div>	
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var zero = 'lkasdlkwoijlkncxlvknsdlksjelkrjwefraklsdf';
		load_search(zero);
		$(".table").tablesorter({debug: true});

		function run(msg)
        {
          alert(msg);
        }

	});

		function load_search(query)	
		{
			var url = '<?php echo base_url()?>librarymodule/searchnow';
			$.ajax({
				url: url,
				dataType:'json',
				method: "POST",
				data:{query:query,csrf_test_name:$.cookie('csrf_cookie_name')},
				success:function(data){
					$('#disp').html(data.result);
				}
			})
		}

		$('#searchbox').keyup(function(){
			var search = $(this).val();
			if (search != '') {
				load_search(search);
			}else{
				load_search();
			}
		});

	
</script>
