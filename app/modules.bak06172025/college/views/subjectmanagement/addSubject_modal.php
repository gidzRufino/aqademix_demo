<div id="addCollegeSubject"  style="width:20%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Subject</h6>
        </div>
        <div class="panel-body">
            <form id="addCollege">
                <div class="form-group">
                    <label class="control-label">Subject Code / Course Title:</label>
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
                    <label class="control-label">Pre-Requisite Subject:</label><br />
                      <input style="margin-bottom:0; width: 105%"  name="inputPreR" multiple="multiple" type="text" id="inputPreR" placeholder="Pre-Requisite" required>
                  </div>
                <div style='margin:5px 0;'>
                    <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addCollegeSubjects()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                    <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>
                </div>
                
            </form>

        </div>
    </div>
</div>

<div id="editCollegeSubject"  style="width:20%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Edit Subject</h6>
        </div>
        <div class="panel-body">
            <form id="editCollege">
                <input type="hidden" id="editSubId" name="editSubId" />
                <div class="form-group">
                    <label class="control-label">Subject Code / Course Title:</label>
                      <input style="margin-bottom:0;" class="form-control"   multiple="multiple" name="editSubjectCode" type="text" id="editSubjectCode" placeholder="Subject Code" required>
                  </div>
                <div class="form-group">
                    <label class="control-label">Descriptive Title:</label>
                      <input style="margin-bottom:0;" class="form-control"  name="editDesc" type="text" id="editDesc" placeholder="Descriptive Title" required>
                  </div>
                <div class="form-group">
                    <label class="control-label">Lecture Units:</label>
                      <input style="margin-bottom:0;" class="form-control"  name="editLectureUnits" type="text" id="editLectureUnits" placeholder="Lecture Units" required>
                  </div>
                <div class="form-group">
                    <label class="control-label">Lab Units:</label>
                      <input style="margin-bottom:0;" class="form-control"  name="editLabUnits" type="text" id="editLabUnits" placeholder="Lab Units" required>
                  </div>
                <div class="form-group">
                    <label class="control-label">Pre-Requisite Subject:</label><br />
                      <input style="margin-bottom:0; width: 105%"  name="editPreR" multiple="multiple" type="text" id="editPreR" placeholder="Pre-Requisite" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Laboratory Fee :<small class="text-muted">(if applicable)</small></label><br />
                    <select id="labFee" name="labFee">
                        <option value="0">Select Lab Fee</option>
                        <?php $labFee = Modules::run('college/finance/getLaboratoryFees'); 
                            foreach($labFee as $lab):
                            ?>
                                <option value="<?php echo $lab->item_id ?>"><?php echo $lab->item_description; ?></option>
                            <?php 
                            endforeach; 
                            ?>
                    </select>
                </div>
                
            </form>
            
            <div style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='editCSubjects()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>
            </div>
            
        </div>
    </div>    
</div>
<!--onclick="addSubject('<?php echo $sub->s_id ?>','<?php echo ($sub->pre_req=="None"?'None':$sub->pre_req) ?>')"--> 
<div id="addSection"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style='width:100%;'>
        <div class="panel-heading">
            <h4 class="no-margin">Add Section</h4>
        </div>
        <div class="panel-body">
            <input style="margin-bottom:0;" class="form-control"   multiple="multiple" name="inputSubject" type="hidden" id="inputSubject" placeholder="Subject Code" required>
            <input style="margin-bottom:0;" class="form-control"  name="inputSubjectCode" type="hidden" id="Code" required>
            <div class="form-group">
                <label class="control-label">Course:</label>
                  <select id="searchCourse" class="col-lg-12 no-padding">
                        <option>Select Course</option>
                        <?php
                            foreach ($courses as $c):
                        ?>
                        <option value="<?php echo $c->course_id ?>"> <?php echo strtoupper($c->course) ?></option>
                        <?php
                            endforeach;
                        ?>   
                    </select>
            </div> <br /><br />
            <div class="form-group">
                <label class="control-label">Select Semester:</label> <br />
                  <select tabindex="-1" id="inputSem" name="inputSem" style="width:100%" >
                      <option>Select Semester</option>
                      <option value="1">First Semester</option>
                      <option value="2">Second Semester</option>
                      <option value="3">Summer</option>
                  </select>
            </div>
            <div class="checkbox">
              <label>
                <input  type="checkbox" id="isRequested"> Is Subject Requested ?
              </label>
            </div>
            <hr />
            <div id="subjectPerSection">
                
            </div>
            <div style='margin:5px 0;' class="pull-right">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addSection()' style='margin-right:10px; color:white;' class='btn btn-xs btn-success pull-left'>ADD</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>
            </div>
        </div>
    </div>
</div>