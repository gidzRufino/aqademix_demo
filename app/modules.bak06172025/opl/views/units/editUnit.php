

<div class="modal fade in " id="editUnitDetails">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="unitTitle" class="modal-title pull-left">Edit Unit</h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
            </div>
            <div class="card-body">
                <form  id="editUnitForm">
                    <input type="hidden" id="unitID" name="unitID" />
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Title</label>
                        <input type="text" class="form-control" id="unitTitle" name="unitTitle" placeholder="Unit Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Objectives</label>
                        <textarea class="textarea" id="unitObjectives" name="unitObjectives" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Overview</label>
                        <textarea class="textarea" id="unitOverview" name="unitOverview" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Subject </label>
                        <select id="subjects" name="subjects" class="form-control">
                            <?php $getSubjects = Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year);
                            foreach($getSubjects as $sub): 
                                if($subject_id==$sub->subject_id):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                ?>
                            <option <?php echo $selected ?> value="<?php echo $sub->subject_id ?>"><?php echo $sub->subject ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Grade Level </label>
                        <select id="gradeLevel" name="gradeLevel" class="form-control">
                            <?php foreach($gradeLevel as $gl): 
                                if($grade_level==$gl->grade_id):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                ?>
                            <option <?php echo $selected ?> value="<?php echo $gl->grade_id ?>"><?php echo $gl->level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label>File Attachment <small class="mute text-danger">[ Optional ]</small></label>
                        <input class="form-control" type="file" id="userfile" onchange="uploadFile(this)">
                    </div>
                </form>
             </div>

            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm" onclick="editUnit(this)" style="float:right;">Save Unit</button>
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id='deleteUnit' tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h1><i class="fa fa-exclamation text-danger"></i></h1>
				<h5>You are deleting the unit <span id="unit-title"></span>.</h4>
				<small>Note: This cannot be undone</small>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="deleteBtn" onclick="deleteUnit(this)">Proceed</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

    function uploadFile(input){
        var file = $(input)[0].files[0],
            fd = new FormData(),
            base = $('#base').val(),
            subject = $("#subjects").val(),
            code = $("#unitID").val();
        
        fd.append('code', code);
        fd.append("file", file);
        fd.append('subject_id', subject);
        fd.append("uploadType", "Unit");
        fd.append("csrf_test_name", $.cookie("csrf_cookie_name"));
        
        var url = base + "opl/uploadFile";

        $.ajax({
            url: url,
            dataType: "JSON",
            type: "POST",
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(data){
                alert(data.msg);
            }
        })

    }

    $(function () {
        // Summernote
        $('.textarea').summernote();
    });

	function readyDelete(btn)
	{
		var id = $(btn).attr('lesson-id');
		$("#deleteUnit").find("#unit-title").html($(btn).attr('lesson-title'));
		$("#deleteUnit").find("#deleteBtn").attr('lesson-id', id);
		$("#deleteUnit").modal();
	}

    function deleteUnit(btn)
    {
        var id = $(btn).attr('lesson-id'),
        url = $("#base").val() + "/opl/deleteunit";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data:{
                lessonid: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data){
                alert(data.message);
                location.reload();
            }
        })
    }

    function editUnit(btn)
    {
        var form = $(btn).parent().prev().find("#editUnitForm").serialize(),
        url = $("#base").val() + "/opl/editUnit";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: form+"&csrf_test_name="+$.cookie('csrf_cookie_name'),
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                alert(data.message);
                location.reload();
            }
        });
    }

    function showUnitEdit(btn)
    {   
        var modal = $("#editUnitDetails");
        modal.find("#unitID").val($(btn).attr('lesson-id'));
        modal.find("#unitTitle").val($(btn).attr('lesson-title'));
        modal.find("#unitObjectives").summernote('code', $(btn).attr('lesson-objective'));
        modal.find("#unitOverview").summernote('code', $(btn).attr('lesson-overview'));
        modal.modal();
    }
</script>