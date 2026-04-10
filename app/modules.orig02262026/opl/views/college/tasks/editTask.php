<!---- Add me to opl/views/tasks ---->
<div class="modal" id='editTasks' tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Tasks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="taskSy" value="<?php echo $this->session->school_year; ?>" />
      <div class="modal-body">
        <form id="editTasksForm">
            <div class="form-group col-xs-12 col-lg-6 float-left">
                <label for="exampleInputEmail1">Task Title</label>
                <input type="text" class="form-control" id="taskTitle" name="taskTitle" placeholder="Task Title">
            </div>
            
            <div class="col-xs-12 col-lg-6 float-left">
                <label>Task Type</label>
                <select id="taskType" name="taskType" class="form-control">
                        
                    <?php
                        $task_type = Modules::run('opl/opl_variables/getTaskType'); 
                        foreach($task_type as $tt): ?>
                    <option  value="<?php echo $tt->tt_id ?>"><?php echo $tt->tt_type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="form-group ">
                <label for="exampleInputEmail1">Task Details</label>
                <textarea class="textarea" id="taskDetails" name="taskDetails" placeholder="Place some text here"
                        style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            <div class="col-xs-12 col-lg-6 pull-left">
                <label>Select Subject and Section </label>
                <select id="taskGrade" name="taskGrade" class="form-control" onchange="fetchLesson(this.value)">
                    <option>Select Subject and Section</option>
					<?php
						$getSubjects = Modules::run('opl/college/getTeacherAssignment', $this->session->username, $semester, $school_year);
						foreach($getSubjects as $gl): 
                        ?>
                    <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->s_desc_title.' [ '. $gl->section.' ] '?></option>
                    <?php endforeach; ?>
                </select>
            </div>
			<div class="col-xs-12 col-lg-6 pull-left">
                <label>Link to Unit</label>
                <select id="taskUnitLink" name="taskUnitLink" class="form-control">
                    <?php foreach($unitDetails as $ud): ?>
                    <option  value="<?php echo $ud->ou_opl_code ?>"><?php echo $ud->ou_unit_title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
			<div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Date</label>
                <input type="date" class="form-control" id="taskStartDate" name="taskStartDate" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Time</label>
                
                <input type="time" value="00:00 pm" class="form-control timePick" id="taskTimeStart" name="taskTimeStart" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Date Deadline</label>
                <input type="date" class="form-control" id="taskEndDate" name="taskEndDate" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Time Deadline</label>
                
                <input type="time" value="00:00 pm" class="form-control timePick" id="taskTimeEnd" name="taskTimeEnd" placeholder="">
            </div>
            <input type="hidden" id="taskCode" name="taskCode" />
        </form>
      </div>
      <div class="modal-footer clearfix">
        <div class="checkbox float-left" >
            <label>
                <input id="goPublic" type="checkbox"> Go Public
            </label>
        </div>
        <button type="button" class="btn btn-success" onclick="editTasks()">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id='deleteTask' tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h1><i class="fa fa-exclamation text-danger"></i></h1>
				<h5>You are deleting the task <span id="task-title"></span>.</h4>
				<small>Note: This cannot be undone</small>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteTask(this)">Delete</button>
				<button type="button" class="btn btn-secondary" onclick="$(this).parent().find('#deleteBtn').removeAttr('task-code'), $(this).parent().prev().find('#task-title').html('');" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<script>

	$(function(){
        $('.textarea').summernote();
        $('.timePick').clockpicker({
            placement: 'top',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
	});

    function toPDF(btn)
    {
        var code = $(btn).attr('task-code'),
            base = $("#base").val();
        window.open(base + "/opl/taskPDF/"+code);
    }
    
    function fetchLesson(value)
    {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/opl_variables/fetchLesson/'+value+'/'+school_year;
        $.ajax({
            type: "GET",
            url: url,
            data:'',
            success: function (data)
            {
                $('#taskUnitLink').html(data);
            }
        });
    }

	function showEditModal(btn){
            let sgls = $(btn).attr("task-sgls"),
            startdate = $(btn).attr('task-start-date'),
            enddate = $(btn).attr('task-end-date'),
            starttime = $(btn).attr('task-start-time'),
            endtime = $(btn).attr('task-end-time');
            console.info(startdate);
            $("#editTasks").find("#taskTitle").val($(btn).attr("task-title"));
            $("#editTasks").find("#taskType > [value='"+$(btn).attr("task-type")+"']").attr("selected", "true");
            $("#editTasks").find("#taskType").val($(btn).attr("task-type"));
            $("#editTasks").find("#taskDetails").summernote('code', $(btn).attr("task-details"));
            $("#editTasks").find("#taskCode").val($(btn).attr("task-code"));
            $("#editTasks").find("#taskGrade").val(sgls);
            $("#editTasks").find("#taskStartDate ").val(startdate);
            $("#editTasks").find("#taskEndDate").val(enddate);
            $("#editTasks").find("#taskTimeStart").val(starttime);
            $("#editTasks").find("#taskTimeEnd").val(endtime);
		fetchLesson(sgls);
            $("#editTasks").modal();
    }

    function editTasks(){
        let form = $("#editTasksForm").serialize(),
        base =  $("#base").val(),
        url = base+"/opl/updateTasks",
        goPublic = 0;
        if ($('#goPublic').is(':checked'))
        {
            gopublic = 1;
        }
        form = form+"&isPublic="+goPublic+"&csrf_test_name="+$.cookie('csrf_cookie_name');
        console.info(form);
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data:form,
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function(data){
                alert(data.message);
                location.reload();
            }
        });
    }

	function showDeleteModal(btn, page = null){
		let code = $(btn).attr('task-code'),
			title = $(btn).attr('task-title'),
			modal = $("#deleteTask");
		modal.find("#task-title").html(title);
		modal.find("#deleteBtn").attr("task-page", page);
		modal.find("#deleteBtn").attr("task-code", code);
		if(page == 1){
			let grade = $(btn).attr('task-grade'),
			section = $(btn).attr('task-section'),
			subject = $(btn).attr('task-subject');
			modal.find("#deleteBtn").attr('task-grade', grade);
			modal.find("#deleteBtn").attr('task-section', section);
			modal.find("#deleteBtn").attr('task-subject', subject);
		}
		modal.modal();
	}

    function deleteTask(btn)
    {
		let code = $(btn).attr('task-code'),
			page = $(btn).attr('task-page');
			base = $("#base").val(),
			url = base + "/opl/deleteTasks";
		$.ajax
		(
			{
				url: url,
				type: "POST",
				dataType: "JSON",
				data:
				{
					code: code,
					csrf_test_name: $.cookie('csrf_cookie_name')
				},
				beforeSend: function () {
				    $('#loadingModal').modal('show');
				},
				success: function(data)
				{
					alert(data.message);
					if(page == 1)
					{
						let grade = $(btn).attr('task-grade'),
							section = $(btn).attr('task-section'),
							subject = $(btn).attr('task-subject');
						document.location = base + "/opl/classBulletin/2020/List/"+grade+"/"+section+"/"+subject;
					}
					else
					{
						location.reload();
					}
				}
			}
		);
    }
</script>