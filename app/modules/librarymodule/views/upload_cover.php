<div class="panel panel-primary">
	<div class="panel-heading">
		<h5 id="myModalLabel">Upload item image</h5>
	</div>
	<div class="panel-body">
	<div class="text-center">Image should not exceed 1024 x 768 or 500kb in size.</div>
		<?php
		        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
		        echo form_open_multipart(base_url().'librarymodule/upload_now', $attributes);
		        ?>
		    <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
		    <br /><br />

		    <input type="submit" value="upload" class="btn-primary pull-right"/>
		    <input type="hidden" name="id" value="<?php echo $gb_id?>" />
		    <input type="hidden" name="location" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/' ?>" />

 		</form>
 	</div>
</div>
