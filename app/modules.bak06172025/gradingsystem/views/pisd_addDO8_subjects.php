<div id="addDOSubjects" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Add Subjects to DepEd Order 8 </h4>
        </div>
        <div class="panel-body">
                    <div class="form-group">
                              <select name="inputSubjectID" id="inputSubjectID" style="width:80%;"  class="pull-left controls-row span12" required>
                                <option>Select Subject</option> 
                              <?php  
                              $subjects = Modules::run('academic/getSubjects');
                              foreach ($subjects as $s)
                                 {     
                              ?>
                               <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></option>  
                              <?php } ?>
                           </select>
                    </div> <br />
                    <div class="form-group">
                        <select name="inputAssessment" id="inputAssessment" onclick="getSubComponent()"  style="width: 80%" class="pull-left">
                            <option>Select Assessment</option>
                            <option value="1">Written Work</option>
                            <option value="2">Performance Task</option>
                            <option value="3">Quarterly Assessment</option>
                        </select>
                    </div>  <br />
                    <div class="form-group">
                        <input type="text" class="form-control" name="inputWeight" id="inputWeight" placeholder="weight in decimal form" />
                    </div>
                    <button onclick="addSubjectWeight()" class="btn btn-success btn-sm pull-right">Save</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>
<div id="editDOSubjects" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Edit Assessment Weights in <span id="sub_title"></span></h4>
            <input type="hidden" id="subject_id" />
            <input type="hidden" id="school_year" />
            <input type="hidden" id="code" />
        </div>
        <div class="panel-body">
                    <div class="form-group">
                        <select name="inputAssessment" id="editAssessment" style="width: 80%" class="pull-left">
                            <option>Select Assessment</option>
                        </select>
                    </div>  <br />
                    <div class="form-group">
                        <input type="text" class="form-control" name="editWeight" id="editWeight" placeholder="weight in decimal form" />
                    </div>
                    <button onclick="editSubjectWeight()" class="btn btn-success btn-sm pull-right">Save</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>