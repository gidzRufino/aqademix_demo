<div class="col-lg-12 no-padding" style="border-bottom: 1px solid #EEEEEE;">
    <h3 style="margin:10px 0;" class="page-header">College Teaching Load 
   
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <?php if($this->session->is_superAdmin || $this->session->position == 'Registrar' || $this->session->position == 'Dean'): ?>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/gradingsystem/listOfFacultyWGrades/2/') ?>'+$('#semInput').val()+'/'+$('#inputSY').val()">Faculty's Submitted Grades</button>
            <?php endif; ?>
         </div>
             
    <select style="margin-right: 20px; width:200px; margin-top:3px; font-size: 18px; font-weight: normal;" onclick="changeSem(this.value)" id='semInput' class="input-group select2-searching select2-search pull-right">
        <option >Select Semester</option>
        <option <?php echo $semester==1?'selected':'' ?> value="1">First Semester</option>
        <option <?php echo $semester==2?'selected':'' ?> value="2">Second Semester</option>
        <option <?php echo $semester==3?'selected':'' ?> value="3">Summer</option>
    </select>
    <div class="form-group pull-right">
            <select tabindex="-1" id="inputSY" style="margin-right: 20px; width:200px; margin-top:3px; font-size: 18px; font-weight: normal;" >
                    <option>School Year</option>
                    <?php 
                          foreach ($ro_year as $ro)
                           {   
                              $roYears = $ro->ro_years+1;
                              if($school_year==$ro->ro_years):
                                  $selected = 'Selected';
                              else:
                                  $selected = '';
                              endif;
                          ?>                        
                        <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                        <?php }?>
                </select>
         </div>
    </h3>
    
    <div class="col-lg-3 no-padding" style="margin:25px 0 5px;">
            <h5 style="margin:0;">Search By:
            <select id="searchOption"  onclick="getSearchOption(this.value)" style="width:150px; margin-right:5px;">
                <option>Select Option</option>
                <option value="employee_id">Teacher</option>
            </select>
             </h5>
    </div>
    <div class="form-group col-lg-4 pull-right" id='searchBox' style="margin:10px 0;">
        <div class="controls">
          <input autocomplete="off"  class="form-control" onkeydown="searchTeacher(this.value)"  name="searchTeacher" type="text" id="searchTeacher" placeholder="Search Teacher's Family Name" required>
          <input type="hidden" id="teacher_id" name="teacher_id" value="<?php echo $faculty_id ?>" />
        </div>
        <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

        </div>
    </div>
</div> 
<div class="col-lg-12" id="teacherResult">
    <?php 
    if($faculty_id!=NULL): 
       // echo Modules::run('college/subjectmanagement/getAssignedSubjectCollege', $faculty_id, $semester, $school_year);
        echo Modules::run('college/schedule/getSchedulePerTeacher', $faculty_id, $semester, $school_year);
    endif; ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
      $("#inputGrade").select2({});
      $("#inputSY").select2({});
      $("#semInput").select2({});
      $("#inputSection").select2();
      $("#inputGradeAssign").select2({});
      $("#inputSectionAssign").select2();
      $("#inputSubjectAssign").select2();
    });
    
    function assignSubject(sched_code, spc_id, sec_id)
    {
        var teacher = $('#teacher_id').val();
        var school_year = $('#inputSY').val();
            var url = "<?php echo base_url().'college/subjectmanagement/assignSubject'?>"
            $.ajax({
                   type: "POST",
                   url: url,
                   data:'t_id='+teacher+'&sched_code='+sched_code+'&section_id='+sec_id+'&spc_id='+spc_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                   dataType:'json',
                   success: function(data)
                   {
                        alert((data.status?'Successfully Saved':data.msg));
                        location.reload();
                   }
                 });

            return false; 
          
    }
    
    
    function getSearchOption(value)
      {
          switch(value)
          {
              case 'grade_level_id':
                  $('#grade').show()
                  $('#searchBox').hide();
                  $('#section').hide()
              break;
              case 'section_id':
                  $('#section').show();
                  $('#grade').hide();
                  $('#searchBox').hide();
              break;
              default:
                  $('#grade').hide()
                  $('#section').hide()
                  $('#searchBox').show();
              break;
          }
      }
      
    function searchTeacher(value)
    {
        var school_year = $('#inputSY').val();
        var url = "<?php echo base_url().'college/subjectmanagement/teacherSearch/'?>";
        if(value==""){
              $('#citySearch').hide();
              $('#cityId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   beforeSend: function() {
                            $('#teacherSearch').show();
                            $('#teacherSearch').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                        },
                   success: function(data)
                   {
                       $('#teacherSearch').show();
                       $('#teacherSearch').html(data);
                   }
                 });

            return false;  
          }
    }
    
    function getInfo(value)
    {
        var url = "<?php echo base_url().'college/subjectmanagement/getAssignedSubjectCollege/'?>";
        if(value==""){
              $('#citySearch').hide();
              $('#cityId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+value+'&semester='+$('#semInput').val()+'&school_year='+$('#inputSY').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   beforeSend: function() {
                            $('#teacherResult').show();
                            $('#teacherResult').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                        },
                   success: function(data)
                   {
                       $('#teacherResult').show();
                       $('#teacherResult').html(data);
                   }
                 });

            return false;  
          }
    }
    
    function getAssignmentByGradeLevel(value)
    {
        var url = "<?php echo base_url().'academic/getAssignmentByGradeLevel/'?>";
        if(value==""){
              $('#citySearch').hide();
              $('#cityId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   beforeSend: function() {
                            $('#teacherResult').show();
                            $('#teacherResult').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                        },
                   success: function(data)
                   {
                       $('#teacherResult').show();
                       $('#teacherResult').html(data);
                   }
                 });

            return false;  
          }
    }
        
    
</script>