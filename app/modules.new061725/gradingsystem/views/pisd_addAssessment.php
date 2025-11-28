<div id="addDOSubjects" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Add Weights to Subjects </h4>
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
                        <?php foreach($components as $c): ?>
                        <option value="<?php echo $c->id ?>"><?php echo $c->component ?></option>

                        <?php endforeach; ?>
                    </select>
                </div><br />
                <div class="form-group">
                    <select name="inputSubCom" id="inputSubCom" style="width: 80%" class="pull-left">
                        <option>Select Sub Component</option>
                        <?php 
                            foreach($subCom as $sc):
                        ?>
                        <option value="<?php echo $sc->sub_id ?>"><?php echo $sc->sub_component; ?></option>
                        <?php
                            endforeach;
                        ?>
                    </select> &nbsp;<i class="fa fa-plus pointer" onclick="$('#addComponent').modal('show')"></i>
                </div>  <br />  
                <div class="form-group">
                    <label>Weight of Component</label>
                    <input type="text" class="form-control" name="inputWeight" id="inputWeight" placeholder="weight in decimal form" />
                </div>  
                <div class="form-group">
                    <label>Percentage Score Weight</label>
                    <input type="text" class="form-control" name="inputPSWeight" id="inputPSWeight" placeholder="weight in decimal form" />
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
        </div>
        <div class="panel-body">
                <div class="form-group">
                    <select name="editAssessment" id="editAssessment" style="width: 80%" class="pull-left">
                        <option>Select Assessment</option>
                        <?php foreach($components as $c): ?>
                        <option value="<?php echo $c->id ?>"><?php echo $c->component ?></option>

                        <?php endforeach; ?>
                    </select>
                </div><br />
                <div class="form-group">
                    <select name="editSubCom" id="editSubCom" style="width: 80%" class="pull-left">
                        <option>Select Sub Component</option>
                        <?php 
                            foreach($subCom as $sc):
                        ?>
                        <option value="<?php echo $sc->sub_id ?>"><?php echo $sc->sub_component; ?></option>
                        <?php
                            endforeach;
                        ?>
                    </select> &nbsp;<i class="fa fa-plus pointer" onclick="$('#addComponent').modal('show')"></i>
                </div>  <br />  
                <div class="form-group">
                    <label>Weight of Component</label>
                    <input type="text" class="form-control" name="editWeight" id="editWeight" placeholder="weight in decimal form" />
                </div>  
                <div class="form-group">
                    <label>Percentage Score Weight</label>
                    <input type="text" class="form-control" name="editPSWeight" id="editPSWeight" placeholder="weight in decimal form" />
                </div>
                    <button onclick="editSubjectWeight()" class="btn btn-success btn-sm pull-right">Save</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>

<div id="addComponent" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <h4>Add Assessment Component</h4>
        </div>
        <div class="panel-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="sub_component" id="sub_component" placeholder="Name of Component" />
                    </div>
                    <button onclick="addSubComponent()" class="btn btn-success btn-sm pull-right">Save</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
</div>