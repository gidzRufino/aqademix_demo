
<div class="modal" id='editDiscussion' tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Discussion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="discussionForm">
            <input type="hidden" id="sy" name="sy" value="<?php echo $this->session->school_year; ?>" />
            <input type="hidden" id="discussionID" name="discussionID" />
            <div class="form-group">
                <label for="exampleInputEmail1">Discussion Title</label>
                <input type="text" class="form-control" id="discussTitle" name="discussTitle" placeholder="Discusstion Title">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Discussion Details</label>
                <textarea class="textarea" id="discussDetails" name="discussDetails" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            
            <div class="form-group col-xs-12 col-lg-12 float-left">
                <label>Select Subject, Grade Level and Section </label>
                <select id="gradeLevel" name="gradeLevel" class="form-control">
                    <option>Select Subject, Grade Level and Section</option>
                    <?php foreach($getSubjects as $gl): 
                        ?>
                    <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->subject.' - '.$gl->level.' ['.$gl->section.'] '?></option>
                    <?php endforeach; ?>
                </select>
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
        <div class="checkbox float-left" >
            <label>
                <input id="goPublic" name="goPublic" value="0" type="checkbox"> Go Public
            </label>
        </div>
        <button class="btn btn-primary btn-sm" onclick="editDiscussion(this)" style="float:right;">Edit Discussion Discussion</button>
    </div>
    </div>
  </div>
</div>


<div class="modal" id='deleteDiscussion' tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                    <h1><i class="fa fa-exclamation text-danger"></i></h1>
                    <h5>You are deleting the unit <span id="discussion-title"></span>.</h4>
                    <small>Note: This cannot be undone</small>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="deleteBtn" onclick="deleteDiscussion(this)">Proceed</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>

    function toPDF(btn){
        var id = $(btn).attr('discussion-id'),
            url = $("#base").val() + "opl/discussionPDF/"+id;
        window.open(url);
    }

	function deleteDiscussion(btn)
    {
        var id = $(btn).attr('discussion-id'),
        base = $("#base").val(),
        url = base + "opl/deleteDiscussion";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data:{
                discussionid: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data){
                alert(data.message);
				document.location = base + "opl/discussionBoard/<?php echo $this->session->school_year; ?>/<?php echo $this->session->employee_id; ?>";
            }
        })
    }

	function readyDelete(btn)
	{
		var id = $(btn).attr('discussion-id');
		$("#deleteDiscussion").find("#discussion-title").html($(btn).attr('discussion-title'));
		$("#deleteDiscussion").find("#deleteBtn").attr('discussion-id', id);
		$("#deleteDiscussion").modal();
	}

    function editDiscussion(btn)
    {
        var form = $(btn).parent().prev().find("#discussionForm").serialize(),
            base = $("#base").val();
        $.ajax(
            {
                url: base + "/opl/editDiscussion",
                type: "POST",
                dataType: "JSON",
                data: form+"&csrf_test_name="+$.cookie('csrf_cookie_name'),
                beforeSend: function () {
                    $('#loadingModal').modal('show');
                },
                success: function(data){
                    alert(data.message);
                    location.reload();
                }
            }
        )
    }

    function showEditDiscussion(btn)
    {
        var modal = $("#editDiscussion");
        modal.find("#discussionID").val($(btn).attr('discussion-id'));
        modal.find("#discussTitle").val($(btn).attr('discussion-title'));
        $.ajax({
            url: "<?php echo site_url('opl/getDiscussionDetails/'); ?>"+$(btn).attr('discussion-id'),
            type: "GET",
            dataType: "JSON",
            beforeSend: function(){
                $("#discussionSaver").prop("disabled", true);
                $("#discussionSaver").html("<i class='fa fa-spinner fa-spin'></i>");
            },
            success: function(data){
                modal.find("#discussDetails").summernote('code', data.dis_details);
                $("#discussionSaver").prop("disabled", false);
                $("#discussionSaver").html("Edit Discussion");
            }
        })
        
        modal.find("#unitLink").val($(btn).attr('discussion-link'));
        modal.find("#startDate").val($(btn).attr('discussion-date'));
        modal.find("#timeStart").val($(btn).attr('discussion-time'));
        modal.modal();
    }
</script>