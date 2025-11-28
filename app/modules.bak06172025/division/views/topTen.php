<?php 
    $grade = Modules::run('registrar/getGradeLevel');
    $sbj = Modules::run('academic/getSubjects');
?>
<div style="margin-bottom:100px; overflow-y:scroll; ">
    <div class="row-fluid contentHeader sticky" style="width:1080px; background: #FFF; z-index: 2000">
        
        <h3 class="pull-left" style="margin:0">Top Ten</h3>
        <button onclick="generateTopTen()" class="btn btn-success pull-right" >Generate</button>
        <select tabindex="-1" id="inputTerm" style="width:200px" class="span2 pull-right">
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
      <select name="inputGrade" id="inputSubject" style="width:200px" class="pull-right" required>
          <option value="0">Select Subject</option>
      </select>  
        <select name="inputSection" id="inputSection" class="pull-right controls-row" required>
                      <option value="0">Select Section</option>  
      </select>
        <select name="inputGrade" onclick="selectSection(this.value), selectSubject(this.value)" id="inputGrade" style="width:200px" class="pull-right" required>
                        <option>Select Grade Level</option> 
                         <?php 
                                foreach ($grade as $level)
                                  {   
                            ?>                        
                                  <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                          <?php }?>
      </select>
        
        
        <input type="hidden" id="sy" value="<?php echo $this->session->userdata('school_year') ?>" />
    </div>

    <div id="result" class="row span12">
        
    </div>
    
    
</div>

<script type="text/javascript">
    function generateTopTen()
    {
        var section_id = $('#inputSection').val();
        var subject_id = $('#inputSubject').val();
        var grade_id = $('#inputGrade').val();
        var term = $('#inputTerm').val();
        var sy = $('#sy').val();
        var url = "<?php echo base_url().'division/topTen/'?>";
            $.ajax({
                type: "POST",
                url: url,
                data: 'grade_id='+grade_id+'&term='+term+'&sy='+sy+'&subject_id='+subject_id+'&section_id='+section_id, // serializes the form's elements.
                success: function(data)
                {
                    $('#result').html(data);

              }
            });
        
    }
    
    function selectSection(level_id){
          var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "level_id="+level_id, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#inputSection').html(data);
                   }
                 });

            return false;
      }
    
    function selectSubject(level_id){
          var url = "<?php echo base_url().'academic/getSubjectsPerLevelDropDown/'?>"+level_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "level_id="+level_id, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#inputSubject').html(data);
                   }
                 });

            return false;
      }
    
</script>
