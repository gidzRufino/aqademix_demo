<div class="row">
	<select id="teacherSelect" class="form-control">
		<option>Select Student</option>
		<?php 
			foreach($students AS $s):
				$name = Modules::run('portal/getStudentDetails', $s);
				if(!empty($name->level)):
			?>
					<option value="<?php echo $s; ?>"><?php echo Modules::run('main/compileName', $name); ?></option>
		<?php
				endif;
			endforeach;
			?>
	</select>
</div>

<div id="teachersList" class="row">
</div>


<script>
	$(document).ready(function(){
		$("#teacherSelect").select2();
	});

	$("#teacherSelect").change(function(){
		$.ajax("<?php echo site_url('portal/teachersList/'); ?>"+$(this).val(), {
			type: "GET",
			dataType: "JSON"
		}).always(function(data){
			$("#teachersList").html(data.responseText);
		});
	});
</script>