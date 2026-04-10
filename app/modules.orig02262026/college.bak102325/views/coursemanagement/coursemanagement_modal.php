<div id="addSection"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Section</h6>
        </div>
        <div class="panel-body">
            <input type='text' id='txtAddSection' placeholder="Section Name" />
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addSection()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="addCourse"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6 id="addCourseTitle">Add Course</h6>
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
            <div class="form-group">
                <select style='width:230px;' name='inputAddDepartment' id='inputAddDepartment' required>
                    <option>Select Department</option>
                    <?php 
                          foreach ($dept as $p)
                            {
                              if($ccID == $p->cc_id)
                              {
                                      $selected = 'Selected';
                              } else {
                                      $selected = '';
                              }
                      ?>                        
                    <option <?php echo $selected; ?> value='<?php echo $p->cc_id; ?>'><?php echo $p->college_department; ?></option>

                <?php }?>
              </select>
            </div>
            <div class="form-group">
                <label class="control-label">Number of Years:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="numYears" type="text" id="numYears" placeholder="Years to Take" required>
              </div>
            <div style='margin:5px 0;'>
                <input id="addCourseId" type="hidden" value="0" />
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addCourse()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="addDepartment"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Department</h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Department:</label>
                  <input style="margin-bottom:0;" class="form-control"  name="inputDepartment" type="text" id="inputDepartment" placeholder="Department" required>
              </div>
            <div style='margin:5px 0;'>
            <a href='#' data-dismiss='modal' onclick='addDepartment()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>