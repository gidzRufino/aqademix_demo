<div id="addSHSubject"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Senior High Subject</h6>
        </div>
        <div class="panel-body">
                <input value="" style="width:100%;" class="" multiple="multiple" name="inputSubject" type="text" id="addedSHSubjects" placeholder="Select Subject" /> 
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveSubjectPerLevel()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
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
<div id="addCollegeSubject"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Subject</h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Subject Code:</label>
                  <input style="margin-bottom:0;" class="form-control"   multiple="multiple" name="inputSubjectCode" type="text" id="inputSubjectCode" placeholder="Subject Code" required>
              </div>
            <div class="form-group">
                <label class="control-label">Descriptive Title:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputDesc" type="text" id="inputDesc" placeholder="Descriptive Title" required>
              </div>
            <div class="form-group">
                <label class="control-label">Lecture Units:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputLectureUnits" type="text" id="inputLectureUnits" placeholder="Lecture Units" required>
              </div>
            <div class="form-group">
                <label class="control-label">Lab Units:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputLabUnits" type="text" id="inputLabUnits" placeholder="Lab Units" required>
              </div>
            <div class="form-group">
                <label class="control-label">Pre-Requisite Subject:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputPreR" type="text" id="inputPreR" placeholder="Pre-Requisite" required>
              </div>
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addCollegeSubjects()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>