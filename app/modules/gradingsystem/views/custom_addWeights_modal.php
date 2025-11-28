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
                        <select name="inputAssessment" id="inputAssessment" style="width: 80%" class="pull-left">
                            <option>Select Assessment</option>
                            <option value="Written Work">Written Work</option>
                            <option value="Performance Task">Performance Task</option>
                            <option value="Quarterly Assessment">Quarterly Assessment</option>
                            <option value="Homework">Homework</option>
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