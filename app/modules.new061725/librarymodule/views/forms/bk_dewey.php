<div class="modal-dialog" style="width: 350;">
  	<div class="modal-content">
    	<div class="modal-header bg-primary">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      	<b class="modal-title" id="myModalLabel">Dewey Decimal System Assignment</b>
    	</div>
	  	<div class="modal-body" >
	  		<div class="container-fluid">
				<div class="form-group">
					<b>Select DDS Code and click OK </b>&nbsp
					<select tabindex="-1" id="select_dds" style="width: 400px;">
	                <option>Dewey Decimal System</option>
	                  <?php foreach ($bk_display_dewey as $dd) { ?>
	                <option value="<?php echo $dd->dwc_id; ?>"><?php echo $dd->dwc_cat_id.' &nbsp|&nbsp'.$dd->dwc_description; ?></option>
	                  <?php } ?>
	              </select>
				</div>
	  		</div>
	  	</div>
	</div>
  	<div class="modal-footer">
  		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
     	<button type="button" onclick="assign_dd()" data-dismiss="modal" class="btn btn-success">OK</button>
  	</div>
</div>