<div class="modal" id='editResouce' tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Resource</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="discussionForm">
            <input type="hidden" id="sy" name="sy" value="<?php echo $this->session->school_year; ?>" />
            <input type="hidden" id="discussionID" name="discussionID" />
            <div class="form-group">
                <label for="exampleInputEmail1">Resource Title</label>
                <input type="text" class="form-control" id="discussTitle" name="discussTitle" placeholder="Discusstion Title">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Resource Details</label>
                <textarea class="textarea" id="discussDetails" name="discussDetails" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            <div class="col-xs-12 col-lg-12 pull-left">
                <label>Link to Unit</label>
                <select id="unitLink" name="unitLink" class="form-control">
                    <?php $unitDetails = Modules::run('opl/opl_variables/getAllUnits',$this->session->username, $school_year);
                    foreach($unitDetails as $ud): ?>
                    <option  value="<?php echo $ud->ou_opl_code ?>"><?php echo $ud->ou_unit_title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Time</label>
                
                <input type="time" value="00:00 pm" class="form-control timePick" id="timeStart" name="timeStart" placeholder="">
            </div>
        </form>
    </div>

    <div class="card-footer clearfix">
        <button class="btn btn-primary btn-sm" onclick="editDiscussion(this)" style="float:right;">Edit Discussion Discussion</button>
    </div>
    </div>
  </div>
</div>


<div class="modal" id='deleteResource' tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h1><i class="fa fa-exclamation text-danger"></i></h1>
				<h5>You are deleting the Resource <span id="discussion-title"></span>.</h4>
				<small>Note: This cannot be undone</small>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="deleteBtn" onclick="deleteDiscussion(this)">Proceed</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
