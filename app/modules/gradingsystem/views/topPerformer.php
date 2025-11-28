<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin:0">Top Performer
            <small class="pull-right" style="margin-top:5px;">
                <select tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                            <option>School Year</option>
                            <?php 
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($this->session->userdata('school_year')==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
                        </select>
                <select tabindex="-1" id="inputTerm" style="width:200px" class="span2">
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
                    <select name="inputGrade" onclick="getTopPerformer(this.value)" id="inputGrade" style="width:200px; font-size: 15px;" required>
                            <option>Select Grade Level</option> 
                           <?php 
                                  foreach ($gradeLevel as $level)
                                    {   
                              ?>                        
                            <option sec="<?php echo $level->level; ?>" value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                            <?php }?>
                   </select>
            </small>
    </div>
    <div class="col-lg-12" id="performers_list">
        <?php 
           
        ?>
    </div>
    
    
</div>

<script type="text/javascript">
        $(document).ready(function() {
            $('#inputGrade').select2();
            $("#inputSY").select2();
        });
        
        
        function getTopPerformer(level)
        {
            var grading = $('#inputTerm').val();
            var school_year = $('#inputSY').val();
            
            var url = '<?php echo base_url().'gradingsystem/getTopPerformerPerLevel/' ?>'+level+'/'+grading+'/'+school_year
            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#performers_list').html(data);
                   }
                 });

            return false;
        }

    
    
</script>