<?php 
    $grade = Modules::run('registrar/getGradeLevel');
?>
<div style="margin-bottom:100px; overflow-y:scroll; ">
    <div class="row-fluid contentHeader sticky" style="width:1080px; background: #FFF; z-index: 2000">
        <h3 class="pull-left" style="margin:0">Division Updates</h3>
        <input type="hidden" id="sy" value="<?php echo $this->session->userdata('school_year') ?>" />
    </div>
    
    <div class="span6 btn-group">
        <a href="<?php echo base_url().'division/topStudents' ?>"  class="btn btn-info btn-group" >Generate Top Ten Students</a>
        <a class="btn btn-info btn-group" >Sync Data to Division</a>
        <a class="btn btn-info btn-group" >Submit DepEd Form</a>
        
    </div>
    
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
    
      <select name="inputGrade" id="inputGrade" style="width:200px" class="pull-right" required>
                       <?php 
                              foreach ($grade as $level)
                                {   
                          ?>                        
                                <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php }?>
      </select>
    <div id="result" class="row span12">
        
    </div>
    
    
</div>

<script type="text/javascript">
    function generateTopTen()
    {
        var grade_id = $('#inputGrade').val();
        var term = $('#inputTerm').val();
        var sy = $('#sy').val();
        var url = "<?php echo base_url().'division/topTen/'?>";
            $.ajax({
                type: "POST",
                url: url,
                data: 'grade_id='+grade_id+'&term='+term+'&sy='+sy, // serializes the form's elements.
                success: function(data)
                {
                    $('#result').html(data);

              }
            });
        
    }
    
</script>
