<?php
    
    echo link_tag('assets/css/bootstrap.min.css');
    ?>

    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<div class='container'>
<h3>Matching Type</h3>
<div class="row">
	<div class="col-md-6">
	<?php 
	echo count($students);
	//var_dump($students);
	for($a=0;$a<=count($students);$a++){
		echo '<ul>';
		echo '<li>' . $students[$a][0]->st_id . ' ' . $students[$a][0]->user_id . '</li>';
		echo '<li>' . $students[$a][0]->lastname . ' ' . $students[$a][0]->firstname .'</li>';
		echo '</ul>';
	}
	?>
	</div>
	<div class="col-md-6">
		<?php 
	//$match = Modules::run('registrar/getMatch');
	echo count($match). '<br/>';
	//echo $match[0][0]['st_id'] . '<br/>';
	//var_dump($match);
	for($x=0;$x<=count($match);$x++){
	echo '<ul>';
		echo '<li>' . $match[$x][0]['st_id'] . ' ' . $match[$x][0]['user_id'] . '</li>';
		echo '<li>' . $match[$x][0]['lastname'] . ' ' . $match[$x][0]['firstname'] . '</li>';
	echo '</ul>';
	}
	?>
	</div>
</div>

	

</div>

<style type="text/css">
	li{
		list-style: none;
	}
</style>