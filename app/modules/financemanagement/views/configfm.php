<?php
    foreach($settings as $set){
        $sy = $set->school_year;
    }
   $is_admin = $this->session->userdata('is_admin');
?>
<div class="clearfix row" style="margin:0;">
    <div class="row">
        <div class="pull-left span6 ">
            <h3>Finance Management - Categories</h3>

			<div class="control-group">
			<table class="span4 table table-stripped">
				<tr>
					<td class="span3">Description</td><td class="span2">Amount</td>
				</tr>

				
			</table>

                <div class="controls">
                <!-- <label class="control-label" for="inputBirthDate">Date of Birth</label> -->
      <!--               <input type="hidden" name="bdate_id" value="<?php echo $bdate_id ?>">
                    <input name="inputBdate" type="text" data-date-format="mm-dd-yy" id="inputBdate" placeholder="Date of Birth" value="<?php echo $bdate ?>" required>
                    <input name="inputBdate" type="text" data-date-format="mm-dd-yy" id="inputBdate" placeholder="Date of Birth" value="<?php echo $bdate ?>" required> -->
                </div>
            </div>
        </div>
    </div>
</div>
