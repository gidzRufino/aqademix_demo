<div id="addEdHis"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <button onclick="saveAddHis()" style="margin-right:5px" type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-save"></i></button><span id="addEdHisTitle">Add Education</span>
        </div>
        <div id="" class="panel-body clearfix no-padding">
        <?php
            $attributes = array('class' => '', 'id'=>'addEdHisBody');
            echo form_open(base_url().'hr/addEducHis', $attributes);
        ?>
                <input type="hidden" id="eb_id" name="eb_id" value="0" />
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $basicInfo->employee_id ?>" />
                <div class="form-group col-lg-12">
                  <label class="control-label" for="YearGraduated"/>Education Level:</label> 
                  <div class="controls" id="educLevels">
                    <select name="educLevel" id="educLevel" style="width:230px; height:35px;"  required>
                        <option id="level_1" value="1">Elementary</option>
                        <option id="level_2" value="2">Secondary</option>
                        <option id="level_3" value="3">Vocational / Trade Course</option>
                        <option id="level_4" value="4">College</option>
                        <option id="level_5" value="5">Graduate Studies</option>
                     </select>
                 </div>   
               </div>
                <div class="form-group col-lg-12">
                  <label class="control-label" for="YearGraduated">Name of School</label>
                  <div class="controls">
                      <input autocomplete="off" class="form-control" onkeydown="searchSchool(this.value)" style="margin-right: 10px" name="inputNameOfSchool" type="text" id="inputNameOfSchool" placeholder="Name of School" required>
                      <input type="hidden" id="collegeId" name="collegeId" value="0" />

                  </div>
                  <div style="min-height: 30px; background: #FFF; display: none;" class="resultOverflow" id="collegeSearch">

                  </div>
                </div>
                <div class="form-group col-lg-12">
                    <label class="control-label" for="YearGraduated">Address of School</label>
                    <div class="controls">
                       <?php
                             $inputAddressOfSchool = array(
                                            'name'        => 'inputAddressOfSchool',
                                            'id'          => 'inputAddressOfSchool',
                                            'placeholder'  => 'Address of School',
                                            'class'        => 'form-control',

                                          );

                              echo form_input($inputAddressOfSchool);

                        ?> 

                    </div>
                  </div>
                <div class="form-group col-lg-12">
                    <label class="control-label" for="inputCourse">Course:</label>
                    <div class="controls">
                      <input autocomplete="off"  class="form-control" onkeydown="searchCourse(this.value)" style="margin-right: 10px;" name="inputCourse" type="text" id="inputCourse" placeholder="Course" required>
                      <input type="hidden" id="courseId" name="courseId" value="0" />
                    </div>
                    <div style="min-height: 30px; background: #FFF; width:230px; display: none;" class="resultOverflow" id="courseSearch">

                    </div>
                </div> 
                <div class="form-group col-lg-12">
                  <?php
                      $year = date('Y')-40;

                  ?>
                  <label class="control-label" for="YearGraduated"/>Year Graduated:</label> 
                  <div class="controls" id="AddedSection">
                   <select name="inputYearGraduated" id="inputYearGraduated" style="width:230px; height:35px;"  required>
                       <option>Select Year</option>
                         <?php 

                             for($x=$year;$x<=date('Y');$x++)
                               {   
                         ?>                        
                       <option id="year_<?php echo $x; ?>" value="<?php echo $x; ?>"><?php echo $x; ?></option>
                       <?php }?>


                     </select>
                 </div>   
               </div> 
                <div class="form-group col-lg-12">
                  <label class="control-label" for="YearGraduated"/>Years Attended:</label> 
                  <div class="controls">
                   <select name="yearsFrom" id="yearsFrom" style="width:120px; height:35px;"  required>
                       <option>From</option>
                         <?php 

                             for($x=$year;$x<=date('Y');$x++)
                               {   
                         ?>                        
                       <option id="year_from_<?php echo $x; ?>" value="<?php echo $x; ?>"><?php echo $x; ?></option>
                       <?php }?>


                     </select>
                   <select name="yearsTo" id="yearsTo" style="width:120px; height:35px;"  required>
                       <option>To</option>
                         <?php 

                             for($x=$year;$x<=date('Y');$x++)
                               {   
                         ?>                        
                       <option id="year_to_<?php echo $x; ?>" value="<?php echo $x; ?>"><?php echo $x; ?></option>
                       <?php }?>
                     </select>
                 </div>   
               </div>
                <div class="form-group col-lg-12">
                    <label class="control-label" for="inputContact">Highest Grade/Level/Units Earned:</label>
                    <div class="controls">
                      <input  class="form-control"  name="highestEarn" type="text" id="highestEarn" placeholder="Graduated">
                    </div>
                  </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
      function saveAddHis()
      {
          var url = "<?php echo base_url().'hr/addEducHis'?>"; // the script where you handle the form input.
          
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: $('#addEdHisBody').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status)
                       {    
                           alert(data.msg);
                       }
                   }
                 });

            return false;
            
      }
      
      function getEducHis(id)
      {
          var url = "<?php echo base_url().'hr/educHis'?>"; // the script where you handle the form input.
          $('#eb_id').val(id);
          $('#addEdHisTitle').html('Edit Educational Background');
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: 'id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {   
                           $('#inputNameOfSchool').val(data.school)
                           $('#collegeId').val(data.school_id)
                           $('#inputAddressOfSchool').val(data.school_add)
                           $('#inputCourse').val(data.course)
                           $('#courseId').val(data.course_id)
                           $('#highestEarn').val(data.highest_earn)
                           $('#level_'+data.level).attr('selected','selected');
                           $('#year_'+data.year_grad).attr('selected','selected');
                           $('#year_from_'+data.year_from).attr('selected','selected');
                           $('#year_to_'+data.year_to).attr('selected','selected');
                   }
                 });

            return false;
      }
</script>