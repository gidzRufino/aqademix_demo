<!--subject Course-->
<div id="collegeCourseSubject" class="modal fade" style="width:85%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h5 class="no-margin col-lg-7" id="courseTitle"></h5>
            <i class="pointer fa fa-close pull-right"  style='font-size:22px;' data-dismiss="modal"></i>
            <div class="form-group col-lg-3 pull-right">
                <select tabindex="-1" id="inputCSY" name="inputCSY" onclick="loadSubject($('#courseTitle').html())" style="width:200px; font-size: 15px; color:black;">
                   <option>School Year</option>
                   <?php 
                        for($ro=2018; $ro<= date('Y'); $ro++){
                            $roYears = $ro+1;
                             if($this->session->userdata('school_year')==$ro):
                                 $selected = 'Selected';
                             else:
                                 $selected = '';
                             endif;
                         ?>                        
                       <option <?php echo $selected; ?> value="<?php echo $ro; ?>"><?php echo $ro.' - '.$roYears; ?></option>
                       <?php }?>
               </select>
                <span onclick="$('#addCollegeSubject').modal('show')" class="pull-right pointer"><i class='fa fa-plus-square' style='font-size:22px;'></i></spans>
            </div>
            <h4 class='text-center col-lg-12 no-margin'>SUBJECTS OFFERED</h4>
            <input type="hidden" id="course_id" />
        </div>
        <div style=" max-height: 550px; overflow-y: scroll;" id="subjectsPerSem" class="panel-body clearfix">
            <div class="col-lg-12">
                <h4 class="text-center no-margin">First Year</h4>
                <hr style="margin:5px auto" />
                <div class='col-lg-6'>
                    <div class="panel panel-danger no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">First Semester</h6>
                        </div>
                        <div id="11_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Second Semester</h6>
                        </div>
                        <div id="12_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Summer</h6>
                        </div>
                        <div id="1_Sum" class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h4 class="text-center no-margin">Second Year</h4>
                <hr style="margin:5px auto" />
                <div class='col-lg-6'>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">First Semester</h6>
                        </div>
                        <div id="21_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Second Semester</h6>
                        </div>
                        <div id="22_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Summer</h6>
                        </div>
                        <div id="2_Sum" class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h4 class="text-center no-margin">Third Year</h4>
                <hr style="margin:5px auto" />
                <div class='col-lg-6'>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">First Semester</h6>
                        </div>
                        <div id="31_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Second Semester</h6>
                        </div>
                        <div id="32_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Summer</h6>
                        </div>
                        <div id="3_Sum" class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h4 class="text-center no-margin">Fourth Year</h4>
                <hr style="margin:5px auto" />
                <div class='col-lg-6'>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">First Semester</h6>
                        </div>
                        <div id="41_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Second Semester</h6>
                        </div>
                        <div id="42_Sem" class="panel-body">

                        </div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <div class="panel panel-yellow no-padding">
                        <div class="panel-heading">
                            <h6 class="text-center no-margin">Summer</h6>
                        </div>
                        <div id="4_Sum" class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
         </div>    
         
        </div>
</div>


<div id="addCollegeSubject"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h6 class="col-lg-6">Add Subject</h6>
                 
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Year Level</label>
                <select tabindex="-1" id="yearLevel" name="yearLevel"  class="col-lg-12">
                   <option>Select Year Level</option>
                   <option value="1">First Year</option>
                   <option value="2">Second Year</option>
                   <option value="3">Third Year</option>
                   <option value="4">Fourth Year</option>
                   <option value="5">Fifth Year</option>
                   
               </select>
             </div>
            
            <div class="form-group">
                <label class="control-label">Semester</label>
                <select tabindex="-1" id="inputSem" name="inputSem"  class="col-lg-12">
                   <option>Select Semester</option>
                   <option value="1">First Semester</option>
                   <option value="2">Second Semester</option>
                   <option value="3">Summer</option>
                   
               </select>
             </div>
            <div class="form-group">
                <label class="control-label">Subject</label>
                <select tabindex="-1" id="inputCSubject" name="inputCSubject" class="col-lg-12 no-padding">
                   <option>Select Subject</option>
                   <?php 
                         foreach ($collegeSubjects as $cs)
                          { 
                         ?>                        
                       <option value="<?php echo $cs->s_id; ?>"><?php echo $cs->sub_code.' | '. $cs->s_desc_title ?></option>
                       <?php }?>
               </select>
              </div>

        </div>
        <div class="panel-footer" style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addSubjectPerCourse()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>



<script type="text/javascript">
    
         
    function addSubjectPerCourse()
     {
         var subject = document.getElementById("inputCSubject").value;
         var sem = $('#inputSem').val();
         var course_id = $('#course_id').val();
         var school_year = $('#inputCSY').val();
         var year_level = $('#yearLevel').val();
         
        var url = "<?php echo base_url().'college/coursemanagement/addSubjectPerCourse'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "subject="+subject+"&semester="+sem+"&course_id="+course_id+"&school_year="+school_year+"&yearLevel="+year_level+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#'+year_level+sem+'_Sem').html(data);
               }
             });

        return false; 
     }
     
    
    $(document).ready(function() {

          
          $("#inputGradeModal").select2();
          $("#inputCSubject").select2();
    });
</script>

<!-- End of Schedule Modal-->
