
<h5 class="text-center">Weights of Each Items</h5>
<div class="pull-left">
  <div class="control-group">
    <div class="controls">
          <label class="control-label" for="inputSSS">Attendance:</label>
          <input name="attendance" type="text" value="<?php if($getWeightSettings->attendance!=''){ echo $getWeightSettings->attendance; } ?>" id="attendance" placeholder="Weights for Attendance" required>
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">Quizzes:</label>
          <input name="quizzes" type="text" value="<?php echo $getWeightSettings->quizzes; ?>" id="quizzes" placeholder="Weights for Quizzes" required>      
    </div>
    <div class="controls">
          <label class="control-label" for="inputSSS">Major Exams:</label>
          <input name="majorExams" type="text" value="<?php echo $getWeightSettings->major_exams; ?>" id="majorExams" placeholder="Weights for Major Exams" required> 
      </div>
   </div>  
</div>
<div class="pull-right">
  <div class="control-group">
    <div class="controls">
        <label class="control-label" for="inputSSS">Projects:</label>
          <input name="projects" type="text" value="<?php echo $getWeightSettings->projects; ?>" id="projects" placeholder="Weights for Projects" required> 
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">Assignments:</label>
          <input name="assignments" type="text" value="<?php echo $getWeightSettings->assignments; ?>" id="assignments" placeholder="Weights for assignments" required> 
      </div>
  </div>  
 
</div>