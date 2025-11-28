<div id="editSubject"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Edit Subject</h6>
        </div>
        <div class="panel-body">
                <input value="" style="width:150px;"  name="inputSubject" type="text" id="editSubject" placeholder="Edit Subject" /> 
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='editSubject()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="addSubject"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Subject</h6>
        </div>
        <div class="panel-body">
                <input value="" style="width:150px;" class="" multiple="multiple" name="inputSubject" type="text" id="addedSubjects" placeholder="Select Subject" /> 
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveSubjectPerLevel()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="addCourse"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Course</h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Course:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputCourse" type="text" id="inputCourse" placeholder="Course" required>
              </div>
            <div class="form-group">
                <label class="control-label">Short Code:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputShortCode" type="text" id="inputShortCode" placeholder="Short Code" required>
              </div>
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addCourse()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>