<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">List of College Students
            <!--<small id="num_students"> [ <?php echo $allStudents->num_rows.' / '.$num_of_students; ?> ] </small>-->
            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
            <input type="hidden" id="hiddenSection" value="<?php echo $this->uri->segment(3) ?>" />
            
                <?php if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')){ ?>
                <!--<a href="#printIdModal" style="margin-top:0;" data-toggle="modal" class="btn btn-sm btn-info pull-right">Print ID</a>-->
                <div class="btn-group pull-right ">
                    <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Print</button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li onclick="$('#printIdModal').modal('show')"><a href="#">For ID</a></li>
                        <li onclick="getSubjectOfferedPerSem(), $('#studentsPerSubject').modal('show')"><a href="#">List of Students Per Subject</a></li>
                        <li onclick="$('#studentsPerCourse').modal('show')"><a href="#">Enrollment List</a></li>
                        <li onclick="$('#finalGradePerCourse').modal('show')"><a href="#">Generate Final Grade Per Course</a></li>
                        <li onclick="$('#studentsPerCoursePR').modal('show')"><a href="#">Promotional Report</a></li>
                        <li onclick="$('#studentsPerCourseList').modal('show')"><a href="#">List of Students Per Course Per Year</a></li>
                        <li onclick="getNSTPList()"><a href="#">List of Students for NSTP Students</a></li>
                        <li onclick="$('#studentsPerTeam').modal('show')" ><a href="#">List of Students Per Team</a></li>
                        <li onclick="$('#studentsForInsurance').modal('show')"><a href="#">Student List for Insurance</a></li>
                        <li onclick="generateTES()"><a href="#">Generate TES Application Form</a></li>
                        <li onclick="generateSummary()"><a href="#">Generate Summary of Enrollment</a></li>
                      </ul>
                </div>
                <a id="CSVExportBtn" style="margin:0 10px;" href="<?php echo base_url().'reports/exportToCsv' ?>" class="pull-right btn btn-success hide">Export To CSV </a> 
                <div class="btn-group pull-right">
                     <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                     <button type="button" class="btn btn-default" onclick="getEnrollment()">Enrollment Report</button>
                        <a href="#importCsv" data-toggle="modal"  id="uploadAssessment" class="btn btn-success" >
                            <i class="fa fa-upload"></i>
                        </a>
 
                </div>
                <div class="form-group pull-right">
                        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
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
                 </div>
                <div class="form-group pull-right">
                        <select onclick="getCollegeStudentsBySemester(this.value)" tabindex="-1" id="inputSem" style="width:200px; font-size: 15px;" class=" ">
                            
                            <?php
                                $sem = Modules::run('main/getSemester');
                                //$sem = 1;
                                switch ($sem):
                                    case 1:
                                        $first = 'Selected';
                                        $second='';
                                        $third='';
                                    break;
                                    case 2:
                                        $first = '';
                                        $second='selected';
                                        $third='';
                                    break;
                                    case 3:
                                        $first = '';
                                        $second='';
                                        $third='Selected';
                                    break;
                                endswitch;
                            ?>
                            <option <?php echo $first ?> value="1">First</option>
                            <option <?php echo $second ?> value="2">Second</option>
                            <option <?php echo $third ?> value="3">Summer</option>
                        </select>
                 </div>
            <?php } ?>
        </h3>
    </div>
</div> 
<div class="row" id="student-table" >

    <?php 
        //if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
            $this->load->view('collegeStudentTable'); 
       // endif;  
    ?>
</div>

<div class="modal fade" id="rollOver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal"  aria-hidden="true">&times;</button>
                <h4 id="myModalLabel">Are you Sure to enroll this Student with the Details Below:<br /><br />
                    <span id="sp_name" class="text-danger"></span>
                </h4>
            </div>
            <div class="modal-body">
                <?php  $sem = Modules::run('main/getSemester'); 
                        switch ($sem):
                            case 1:
                                $semester = 'First';
                            break;
                            case 2:
                                $semester = 'Second';
                            break;
                            case 3:
                                $semester = 'Summer';
                            break;
                        endswitch;
                ?>
                <table class="table table-striped">
                    <tr><th>Course</th><th>Year</th><th style="text-align: right;">Select Semester</th></tr>
                    <tr><td id="td_course"></td><td id="td_year"></td>
                        <td>
                            <div class="form-group pull-right">
                                    <select tabindex="-1"   id='ro_sem' style="width:200px; font-size: 15px;" class=" ">

                                        <?php
                                            $sem = Modules::run('main/getSemester');
                                            switch ($sem):
                                                case 1:
                                                    $first = 'Selected';
                                                    $second='';
                                                    $third='';
                                                break;
                                                case 2:
                                                    $first = '';
                                                    $second='selected';
                                                    $third='';
                                                break;
                                                case 3:
                                                    $first = '';
                                                    $second='';
                                                    $third='Selected';
                                                break;
                                            endswitch;
                                        ?>
                                        <option value="0" >Select Semester</option>
                                        <option <?php echo $first ?> value="1">First</option>
                                        <option <?php echo $second ?> value="2">Second</option>
                                        <option <?php echo $third ?> value="3">Summer</option>
                                    </select>
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" id="msg_area"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <input type='hidden' id='curr_grade_id'  />
                <input type='hidden' id='ro_st_id'  />
                <input type='hidden' id='ro_course_id' />
                <input type='hidden' value="<?php echo $sem ?>" />
                <input type='hidden' id='ro_user_id' />
                <input type='hidden' id='ro_badgeIndicator' />
              <button class="btn btn-warning" onclick="location.reload()"  data-dismiss="modal" >Close</button>
              <button onclick='saveCollegeRO()' id="confirmRO" class="btn btn-success">CONFIRM </button>
              <div id="resultSection" class="help-block" ></div>
            </div>
        </div>
      </div>
    </div>

<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Students CSV</h4>
        </div>
             <?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'reports/importCollegeStudents', $attributes);
        ?>
        <div class="panel-body">

                    <input style="height:30px" type="file" name="userfile" ><br />
                    <input class="form-control"type="text" name="sheet_number" id="sheet" placeholder="sheet number" /><br />
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="printIdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"> Print ID Card</h4>
      </div>
      <div class="modal-body">
          <div class="form-group ">
              <select onclick="$('#url_id').val('<?php echo base_url('college/exportForId'); ?>/'+this.value)"  tabindex="-1" id="" style="width:200px; font-size: 15px;" >
                    <option value="0">Search Grade level here</option>
                    <?php 
                          foreach ($course as $level)
                           {   
                          ?>                        
                        <option value="<?php echo $level->course_id; ?>"><?php echo $level->course; ?></option>
                        <?php }?>
                </select>
         </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" id="url_id" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="document.location=$('#url_id').val()" type="button" class="btn btn-success" data-dismiss="modal">Export</button>
        <a target="_blank" href="#" id="printIdBtn" style="margin-top:0;" onmouseover="printId(<?php echo $this->uri->segment(3) ?>, this.id, $('#frontBack').val(),$('#pageID').val() )" class="btn btn-small btn-info pull-right">Print ID</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="studentsPerSubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Print List of Students Per Subject</h4>
          </div>
          <div class="panel-body">
                <div>
                  <label>Please Select Subject</label><br />
                    <select onclick="getSectionPerSubject(this.value)" tabindex="-1" id="inputSubjectOffered" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        
                    </select>
                </div><br />
                <div>
                  <label>Please Select Section</label><br />
                    <select tabindex="-1" id="inputSubjectSection" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        <option id="subOption"></option>
                    </select>
                </div>
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="printStudentPerSubject()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="studentsPerTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Print List of Students Per Team</h4>
          </div>
          <div class="panel-body">
                <div>  
                  <label>Please Select Team</label><br />
                    <select class="form-control" id="team_id">
                        <option value="0">No Team</option>
                    </select>
                </div><br />
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="printStudentPerTeam()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="studentsForInsurance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Student List for Insurance</h4>
          </div>
          <div class="panel-body">
                <div>
                  <?php $courses = Modules::run('college/coursemanagement/getCourses'); ?>  
                  <label>Please Select Course</label><br />
                    <select tabindex="-1" id="inputCourseOfferedInsurance" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        <?php foreach($courses as $c): ?>
                        <option value="<?php echo $c->course_id ?>"><?php echo strtoupper($c->course) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br />
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="studentsForInsurance()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="studentsPerCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Print List of Students Per Course</h4>
          </div>
          <div class="panel-body">
                <div>
                  <?php $courses = Modules::run('college/coursemanagement/getCourses'); ?>  
                  <label>Please Select Course</label><br />
                    <select tabindex="-1" id="inputCourseOffered" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        <?php foreach($courses as $c): ?>
                        <option value="<?php echo $c->course_id ?>"><?php echo strtoupper($c->course) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br />
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="printStudentPerCourse()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="finalGradePerCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Generate Final Grade Per Course</h4>
          </div>
          <div class="panel-body">
                <div>
                  <?php $courses = Modules::run('college/coursemanagement/getCourses'); ?>  
                  <label>Please Select Course</label><br />
                    <select tabindex="-1" id="inputFGCourse" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        <?php foreach($courses as $c): ?>
                        <option value="<?php echo $c->course_id ?>"><?php echo strtoupper($c->course) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br />
                <div class='control-group' style='width:230px;'>
                      <label>Year Level</label><br />
                      <div id='AddedSection'>
                        <select name='inputYear' id='inputFGYearLevel' style='width:200px;' required>
                              <option>Select Year Level</option>
                              <option value='1'>First Year</option>
                              <option value='2'>Second Year</option>
                              <option value='3'>Third Year</option>
                              <option value='4'>Fourth Year</option>
                              <option value='5'>Fifth Year</option>
                          </select>
                      </div>
                </div>
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="generateFinalGradePerCourse()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="studentsPerCoursePR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Print Promotional Report Per Course</h4>
          </div>
          <div class="panel-body">
                <div>
                  <?php $courses = Modules::run('college/coursemanagement/getCourses'); ?>  
                  <label>Please Select Course</label><br />
                    <select tabindex="-1" id="inputPRCourse" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        
                        <option value="0">All Courses</option>
                        <?php foreach($courses as $c): ?>
                        <option value="<?php echo $c->course_id ?>"><?php echo strtoupper($c->course) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br />
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="printPromotionalReportPerCourse()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>


<div class="modal fade" id="studentsPerCourseList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:350px; margin: 50px auto;">
    <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="panel-header" id="myModalLabel">Print List of Students Per Course Per Year</h4>
          </div>
          <div class="panel-body">
                <div>
                  <?php $course = Modules::run('college/coursemanagement/getCourses'); ?>  
                  <label>Please Select Course</label><br />
                    <select tabindex="-1" id="studentCourse" style="width:300px; font-size: 15px;" class="populate select2-offscreen span2">
                        <?php foreach($course as $crs): ?>
                        <option value="<?php echo $crs->course_id ?>"><?php echo $crs->course ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br />
                <div class='control-group' style='width:230px;'>
                      <label>Year Level</label><br />
                      <div id='AddedSection'>
                        <select name='inputYear' id='inputYearLevel' style='width:200px;' required>
                              <option value='0'>Select Year Level</option>
                              <option value='1'>First Year</option>
                              <option value='2'>Second Year</option>
                              <option value='3'>Third Year</option>
                              <option value='4'>Fourth Year</option>
                              <!--<option value='5'>Fifth Year</option>-->
                          </select>
                      </div>
                </div>
          </div>
          <div class="panel-footer">
              <input type="hidden" id="url_id" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" onclick="printStudentPerCoursePerLevel()" style="margin-top:0;"  class="btn btn-small btn-info pull-right">Print</a>
          </div>
      </div>
</div>

<div class="modal fade" id="adminRemarks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" >&times;</button>
          <h3 id="myModalLabel">Update Student Status</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label" for="input">Remarks:</label>
            <div class="controls">
              <input name="dateRemarked" type="hidden" id="dateRemarked" placeholder="Date" value="<?php echo date('m-d-Y'); ?>">
              <select id="inputRemarks" style="width:300px">
                 <option>Select Student Status</option>         
                    <option value ="0" >Withdraw</option>
                    <option value ="1" >Old</option>
                    <option value ="2" >New</option>
                    <option value ="3" >Returnee</option>
                    <option value ="4" >Transferee</option>
             </select>
            </div>
            <input type="hidden" id="st_id" name="st_id" value="" />
            <input type="hidden" id="us_id" name="us_id" value="" />
            <input type="hidden" id="input_sem" name="input_sem" value="" />
            <input type="hidden" id="input_sy" name="input_sy" value="" />
          </div>
                       
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" onclick="submitRemarks(), $('#secretContainer').fadeOut(500)" class="btn btn-primary">Save </button>
          <div id="resultSection" class="help-block"></div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
    var admission_id = 0;
    
    function submitRemarks()
    {
        var url = "<?php echo base_url().'college/saveAdmissionRemarks/'?>"; // the script where you handle the form input.
        var user_id = $('#us_id').val()
        var sem = $('#input_sem').val()
        var sy = $('#input_sy').val()
        var code = $('#inputRemarks').val()
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "code="+code+"&st_id="+$('#st_id').val()+"&user_id="+user_id+"&semester="+sem+"&sy="+sy+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#remarks_'+st_id+"_td").html(data);
                       if(code > 0){
                           $('#img_'+st_id+"_td img").attr("src",'<?php echo base_url();?>images/unofficial.png');
                       }else{
                           $('#img_'+st_id+"_td img").attr("src",'<?php echo base_url();?>images/official.png');
                       }
                       
                   }
                 });

            return false;
    }
    
    function printStudentPerTeam()
    {
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var team = $("#team_id").val();
        var url = "<?php echo base_url()?>college/getTeams/"+school_year+'/'+sem+'/'+team; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function getNSTPList()
    {
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/nstpEL/"+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    
    function generateTES()
    {
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/generateTES/"+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function getEnrollment()
    {
        //$('#inputPRCourse').modal('hide');
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url('college/enrollmentReport/') ?>"+school_year+'/'+sem+'/'; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function generateSummary()
    {
        //$('#inputPRCourse').modal('hide');
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/enrollment/getEnrollmentList/"+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function printPromotionalReportPerCourse()
    {
        //$('#inputPRCourse').modal('hide');
        var sem = $('#inputSem').val();
        var course_id = $('#inputPRCourse').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/coursemanagement/printPromotionalReport/"+sem+'/'+school_year+'/'+course_id; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function studentsForInsurance()
    {
        $('#studentsPerCourse').modal('hide');
        var sem = $('#inputSem').val();
        var course_id = $('#inputCourseOfferedInsurance').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/coursemanagement/studentsForInsurance/"+course_id+'/'+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function printStudentPerCourse()
    {
        $('#studentsPerCourse').modal('hide');
        var sem = $('#inputSem').val();
        var course_id = $('#inputCourseOffered').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/coursemanagement/printStudentsPerCourse/"+course_id+'/'+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function printStudentPerSubject()
    {
        var sem = $('#inputSem').val();
        var subject_id = $('#inputSubjectOffered').val();
        var section_id = $('#inputSubjectSection').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url()?>college/subjectmanagement/printStudentsPerSubject/"+subject_id+'/'+section_id+'/'+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
        $('#studentsPerCourseList').modal('hide');
    }
    
    function printStudentPerCoursePerLevel()
    {
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var year_level = $('#inputYearLevel').val();
        var course_id = $('#studentCourse').val();
        
        var url = "<?php echo base_url()?>college/printStudentsPerCourse/"+course_id+'/'+year_level+'/'+sem+'/'+school_year; // the script where you handle the form input.    
        window.open(url, '_blank');
    }
    
    function getSectionPerSubject(val)
    {
        var sem = $('#inputSem').val();
         var url = "<?php echo base_url().'college/subjectmanagement/getSectionPerSubjectDrop/'?>"+val; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "value="+val, // serializes the form's elements.
                   //dataType: 'json',
                   beforeSend: function() {
                        $('#subOption').html('Loading Section Please Wait...');
                    },
                   success: function(data)
                   {
                       $('#subOption').html('Select Subject');
                       $('#inputSubjectSection').html(data);
                   }
                 });

            return false;
    }
    
    function getSubjectOfferedPerSem()
    {
        var sem = $('#inputSem').val();
         var url = "<?php echo base_url().'college/subjectmanagement/getSubjectOfferedPerSem/'?>"+sem; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "value="+sem, // serializes the form's elements.
                   //dataType: 'json',
                   beforeSend: function() {
                        $('#subOption').html('Loading Subject Please Wait...');
                    },
                   success: function(data)
                   {
                       $('#subOption').html('Select Subject');
                       $('#inputSubjectOffered').html(data);
                   }
                 });

            return false;
    }
    
    function getMMG(value)
    {
         var url = "<?php echo base_url().'registrar/getMMG/'?>"+value; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "value="+value, // serializes the form's elements.
                   //dataType: 'json',
                   beforeSend: function() {
                        showLoading('mmg_details');
                    },
                   success: function(data)
                   {
                       $('#mmg_details').html(data);
                   }
                 });

            return false;
    }
    
    function checkFinance()
    {
        var sem = $('#inputSem').val();
        var st_id = $('#ro_st_id').val();
        var url = "<?php echo base_url().'college/finance/getBalance/'?>"+st_id+'/'+sem+'/'+$('#inputSY').val(); // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "sem="+sem, // serializes the form's elements.
                   dataType:'json',
                   beforeSend: function() {
                        $('#msg_area').html('Please wait while system is checking finance data');
                    },
                   success: function(data)
                   {
                        if(data.status){
                            $('#confirmRO').removeClass('disabled');
                            $('#msg_area').html('<div class="alert alert-success">Student is clear for enrollment</div>')
                        }else{
                            $('#msg_area').html('<div class="alert alert-danger">Sorry, cannot enroll this student, Please let this student see the Business Office</div>');
                        }
                   }
                 });

            return false;
    }
    
    function printId(course_id, id, frontBack, pageID)
    {
        if(frontBack=='printIdCardBack'){
            var limit = 4;
           
        }else{
            limit = 8;
        }
        document.getElementById(id).href = '<?php echo base_url().'registrar/' ?>'+frontBack+'/'+section_id+'/'+limit+'/'+pageID
    }
    
    function showDeleteConfirmation(st_id, psid, adm_id)
    {   
        //alert(psid)
       admission_id = adm_id
       $('#stud_id').val(psid)
       $('#sp_stud_id').html(st_id)
       document.getElementById("user_id").focus()
    } 
    
    function deleteStudent()
    {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            var url = "<?php echo base_url().'college/deleteID/'?>"+st_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&user_id="+user_id, // serializes the form's elements.
                   dataType: 'json',
                   success: function(data)
                   {
                       if(data.status)
                       {
                           alert(data.msg);
                           location.reload();
                       }else{
                           alert(data.msg);
                           location.reload();
                       }
                   }
                 });

            return false;
        }else{
            location.reload();
        }
        
    }
    function getRemarks(st_id, user_id){
        $('#st_id').val(st_id);
        $('#u_id').val(user_id);
    }
//    function getStudentByYear(id)
//    {
//        var url = "<?php echo base_url().'registrar/getStudentByYear/'?>"+id+'/'; // the script where you handle the form input.
//        document.location = url;
//
//    } 
    
    function generateFinalGradePerCourse()
    {
        var sem = $('#inputSem').val();
        var school_year = $("#inputSY").val();
        var url = "<?php echo base_url().'college/gradingsystem/generateFinalGrade/'?>"+$('#inputFGCourse').val()+'/'+$('#inputFGYearLevel').val()+'/'+sem+'/'+school_year; // the script where you handle the form input.

        $.ajax({
               type: "GET",
               url: url,
               data: "sem="+sem, // serializes the form's elements.
               beforeSend: function() {
                   $('#finalGradePerCourse').modal('hide')
                    showLoading('student-table');
               },
               success: function(data)
               {
                  // location.reload();
               }
             });

        return false;
    }
    
    function getStudentByYear(year)
    {
       
            var url = "<?php echo base_url().'college/getCollegeStudentsBySemester/'?>"+year+'/'+$('#inputSem').val(); // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "year="+year,// serializes the form's elements.
                    beforeSend: function() {
                         showLoading('student-table');
                    }, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#student-table').html(data)
                   }
                 });

            return false;
    } 
    
    function getCollegeStudentsBySemester(sem)
    {
       
            var url = "<?php echo base_url().'college/getCollegeStudentsBySemester/'?>"+$('#inputSY').val()+'/'+sem; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "sem="+sem,// serializes the form's elements.
                    beforeSend: function() {
                         showLoading('student-table');
                    }, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#student-table').html(data)
                   }
                 });

            return false;
    } 
    
    function deleteAdmissionRemark(st_id, code_id)
    {
        var url = "<?php echo base_url().'main/deleteAdmissionRemark/'?>"+st_id+'/'+code_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id, // serializes the form's elements.
                   success: function(data)
                   {
                       location.reload()
                       //$('#inputSection').html(data);
                   }
                 });

            return false;
      
    }
    
    function showAddRFIDForm(id, st_id)
    {
       $('#addId').show();     
       $('#secretContainer').html($('#addId').html())
       $('#secretContainer').fadeIn(500)     
       $('#stud_id').val(id)
       $("#inputCard").attr('placeholder', st_id); 
       document.getElementById("inputCard").focus()
    }  
    
    function updateProfile(pk,table, column)
    {
    var url = "<?php echo base_url().'users/editProfile/'?>"; // the script where you handle the form input.
    var pk_id = $('#stud_id').val();
    var value = $('#inputCard').val()
    $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'id='+pk_id+'&column='+column+'&value='+value+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               alert('RFID Successfully Saved');
               location.reload();
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    }
 
    
    $(document).ready(function() {
      
     $('#studentCourse').select2();
     $('#inputCourseOffered').select2();
     $('#inputCourseOfferedInsurance').select2();
     $('#inputFGCourse').select2();
     $('#inputPRCourse').select2();
     $('#inputSubjectSection').select2();
     $('#inputSubjectOffered').select2();
      $("#inputGrade").select2({
            minimumInputLength: 2
        });
      setFocus();
      $("#inputSection").select2();
      $("#inputMonthReport").select2();
      $("#inputSY").select2();
     // $("#inputSem").select2();
      
      if($('#hiddenSection').val()!=""){
          $('#CSVExportBtn').show();
            var CSVUrl ="<?php echo base_url().'reports/exportToCsv/'?>"+"Null"+'/'+$('#hiddenSection').val();
            <?php if($this->session->userdata('is_superAdmin')): ?>
            document.getElementById('CSVExportBtn').href = CSVUrl
            <?php endif; ?>
      }
      
    });
    
    
    function deleteROStudent()
    {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var sy = $('#inputSY').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            if ($('#deleteAll').is(":checked"))
            {
               var url = "<?php echo base_url().'college/deleteID/'?>"+st_id; 
               $.ajax({
                    type: "POST",
                    url: url,
                    data: "st_id="+st_id+"&user_id="+user_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                    dataType: 'json',
                    success: function(data)
                    {
                        if(data.status)
                        {
                            socket.emit('sendNotification', { sendto: data.username,  msg :data.remarks, title:'Delete'}, function(data){});
                            alert(data.msg);
                            location.reload();
                        }else{
                            alert(data.msg);
                            location.reload();
                        }
                    }
                  });

                return false;
                   
            }
            var url = "<?php echo base_url().'college/deleteROStudent/'?>"+st_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&user_id="+user_id+'&sy='+sy+'&adm_id='+admission_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType: 'json',
                   success: function(data)
                   {
                       socket.emit('sendNotification', { sendto: data.username,  msg :data.remarks, title:'Delete'}, function(data){});
                       
                       alert(data);
                       location.reload();
                       //console.log(data)
                   }
                 });

            return false;
                
        }else{
            location.reload();
        }
        
    }
    
    function deleteAll(st_id)
    {
        
       var deleteAll=confirm('Are you Sure You want to delete all the record of student # ( '+st_id+' )?');
        if(deleteAll==false)
            {
                $('#deleteAll').prop('checked', false);
            }
    }
    
        function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }
    
    
    function scanStudents(value)
    {
         var url = "<?php echo base_url().'college/scanStudent/'?>"+value; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#rfid').val('');
                       document.location = '<?php echo base_url('college/viewCollegeDetails/') ?>'+data.st_id
                       //console.log(data)
                   }
                 });

            return false;  
    }
</script>
