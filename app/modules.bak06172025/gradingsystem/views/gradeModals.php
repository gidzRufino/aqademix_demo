<div id="gsInGr_modal"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red no-padding clearfix">
        <div class="panel-heading">
            <span id="stname"></span>'s Individual Grade
            <input type="hidden" name="gs_stid_value" id="gs_stid_value" />
        </div>
        <div class="panel-body">
            <div id="gs_modal_body">
                
            </div>
        </div>
    </div>
</div>    


<!--Select Grade Section-->

<div id="selectGradeSection" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
    <h3 id="myModalLabel">Select Grade and Section</h3>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="span5">
            <div class="span2 pull-left">
                <select name="inputGradeModal" onclick="selectSection()" tabindex="-1" id="inputGradeModal" style="width:150px" class="populate select2-offscreen span2">
                             <option>Select Grade Level</option>
                             <?php 
                                   foreach ($selectSection as $level)
                                    {   
                                   ?>                        
                                      <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                 <?php }?>
                         </select> 
            </div>
            <div class="span2 pull-left">
                <select name="selectSection" style="width:150px;" id="inputSection" required>
                              <option>Select Section</option> 
                            </select>
              </div>
        </div>
          <div style='margin:50px auto 0; width:50%;'>
         <div class="controls">
             <select name="selectSubjectA" style="width:220px;" id="selectSubjectA" required>
                 <option>Select Subject</option> 
                 <?php foreach ($subject as $s) { ?>
                 <option value="<?php echo $s->subject_id ?>"><?php echo $s->subject ?></option> 
                 <?php }?>

               </select>
           </div>
       </div>
      </div>  
        
       
            
  </div>
    
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button onclick="openClassRecord()" data-dismiss="modal" id="" aria-hidden="true" class="btn btn-primary">Open </button>
    <div id="resultSection" class="help-block" ></div>
  </div>
</div>
<input type="hidden" id="setSection" />

<!--Add Criteria-->

<div id="addCriteria" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>   
    <h3 id="myModalLabel">Add Criteria</h3>
  </div>
  <div class="modal-body">
      <div class="pull-left row-fluid">
            <form class='form-horizontal' id='addCriteriaForm'>
                <label class="control-label" for="Criteria">Criteria Name:</label>
                <input style='margin-left:10px; height:30px; margin-bottom: 10px;' name="criteriaName" type="text" id="criteriaName" placeholder="Criteria Name" required><br>
                <label class="control-label" for="Percentage">Percentage Weight:</label>
                <input style='margin-left:10px; height:30px;' name="percentage" type="text" id="percentageWeight" placeholder="Percentage Weight" required>
            </form>
      </div>
  </div>
    
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id='saveCriteriaBtn' data-dismiss="modal" aria-hidden="true" class="btn btn-primary">Save</button>
  </div>
</div>
<script type="text/javascript">
    
    $('#saveCriteriaBtn').click(function() {
     
    var url = "<?php echo base_url().'index.php/gradingSystemSettings/addSubjectCriteria' ?>"; // the script where you handle the form input.
    var curriculum = document.getElementById('selectCurriculum').value;
    var section_id = document.getElementById('selectSectionInCriteria').value;
    var subject_id = document.getElementById('selectSubjectInCriteria').value;
    var criteria = document.getElementById('criteriaName').value;
    var percentage = document.getElementById('percentageWeight').value;
    var dataString = 'curriculum='+curriculum + "&section="+section_id+"&subject="+subject_id+"&criteriaName="+criteria+"&percentageWeight="+percentage;
    $.ajax({
           type: "POST",
           url: url,
           data: dataString,
           success: function(data)
           {
               alert(data);
               //$("form#addCriteriaForm")[0].reset();
                
              
               
           }
         });
     }); 
 </script>