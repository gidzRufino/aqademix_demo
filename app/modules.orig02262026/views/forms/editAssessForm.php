<div id="editAssessForm" class="modal fade" style="width:350px; margin: 10px auto 0;" >
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Edit Your Assessment</h4>
        </div>
        <div class="panel-body">    
            <div  class="form-group">
                <label>Select Assessment</label>
                   <select class="form-control" name="selectAssessmentCat" id="selectAssessmentCat" required>
                       <option>Select Assessment Category</option>

                   </select>
                <label>Number of Items</label>
                    <input class="form-control" style="height:30px;"  name="no_Items" type="text" id="no_Items" placeholder="Number of Items" required>
                <label>Select Grading</label>    
                    <select tabindex="-1" id="editTerm" class="form-control">
                          <?php
                             $first = "";
                             $second = "";
                             $third = "";
                             $fourth = "";
                             switch($this->session->userdata('term')){
                                 case 1:
                                     $first = "selected = selected";
                                 break;

                                 case 2:
                                     $second = "selected = selected";
                                 break;

                                 case 3:
                                     $third = "selected = selected";
                                 break;

                                 case 4:
                                     $fourth = "selected = selected";
                                 break;


                             }
                          ?>
                            <option >Select Grading</option>
                            <option <?php echo $first ?> value="1">First Grading</option>
                            <option <?php echo $second ?> value="2">Second Grading</option>
                            <option <?php echo $third ?> value="3">Third Grading</option>
                            <option <?php echo $fourth ?> value="4">Fourth Grading</option>

                      </select>
            </div>
            <div class="control-group">
                  <div class="controls">
                      
                    </div>
                </div>
            <div class="control-group pull-left" id="month" style="width:230px;">
                    <div class="controls" id="addTerm">
                      
                    </div>
            </div>
        </div>    
        <div class="panel-footer">
            <div>
                <button onclick="editAssessment()" data-dismiss="modal" id="saveScoreBtn" class="btn btn-primary col-lg-12" style="float: none;"><i class="fa fa-save fa-fw"></i>Save</button>
            </div>
            
        </div>
    </div>
</div> 