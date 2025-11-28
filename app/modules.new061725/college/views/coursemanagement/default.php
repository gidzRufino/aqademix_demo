<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Course Management Settings
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="getAdd('Course')">Add Course</button>
                <button type="button" class="btn btn-default" onclick="getAdd('Department')">Add Department</button>
              </div>
        </h3>
    </div>
     <div class="col-lg-12 no-padding">
        <div class="col-lg-12">
            <div style="width:70%; margin: 50px auto">
                <div class="col-lg-12">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="alert alert-info">
                            <h4 class="no-margin text-center"><i class="fa fa-info-circle fa-fw"></i> Click Course to View the Subjects Offered. </h4>
                        </div>
                    </div>
                </div>
                
            <table class="table table-striped table-hover col-lg-6">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center;"><H4>COURSES OFFERED</H4></th>
                        <th colspan="2" style="text-align:center;">
                            <div class="input-group pull-right">
                                <span class="input-group-addon bg-transparent"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search Courses..." onkeyup="if(event.which === 13) searchCourse(this.value)"if(event.which />
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th style="width:40%;">Course</th>
                        <th style="width:20%;">Short Code</th>
                        <th style="width:25%;">Department</th>
                        <th style="width:10%"></th>
                        <!--<th style="width:10%;">Pre-requisite</th>-->
                    </tr>
                </thead>
                <tbody id="subjectsWrapper" style="overflow-y: scroll;">
                    <?php foreach($courses as $c): ?>
                    <tr class="search-list" course="<?php echo strtolower($c->course); ?>" code="<?php echo strtolower($c->short_code); ?>">
                        <td style="width:40%;" class="pointer" onmouseover="$('#sec_name').val('<?php echo $c->course ?>'), $('#course_id').val('<?php echo $c->course_id ?>')" id="<?php echo $c->course_id ?>_li" onclick="$('#collegeCourseSubject').modal('show'), loadSubject('<?php echo $c->course ?>')"><?php echo strtoupper($c->course) ?></td>
                        <td style="width:20%;"><?php echo $c->short_code ?></td>
                        <td style="width:25%;"><?php echo strtoupper($c->college_department) ?></td>
                        <td style="width:10%" class="text-right">
                        <i style="font-size:15px; color:#777;" onclick="editCourse('<?php echo $c->course_id ?>','<?php echo $c->course ?>','<?php echo $c->short_code ?>', '<?php echo $c->dept_id ?>', '<?php echo $c->num_years ?>')" class="fa fa-pencil-square-o clickover pointer fade right in"></i>
                            <i style="font-size: 15px;" class="fa fa-trash-o pointer text-danger right"></i>    
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
                <tbody id="subjectSearch" style="overflow-y: scroll;"></tbody>
    <!--            <tfoot>
                    <tr>
                        <th colspan="3">
                            <?php echo $links ?>
                        </th>
                        <th>

                        </th>
                    </tr>
                </tfoot>-->
            </table>
            </div>

        </div>
    </div> 
</div>
<input type="hidden" id="sec_id" />
<input type="hidden" id="sec_name" />
<input type="hidden" id="grade_id" />
<?php 
    $data['ro_year'] = Modules::run('registrar/getROYear'); 
    $data['collegeSubjects'] = Modules::run('subjectmanagement/getCollegeSubjects');
    $data['dept'] = $this->coursemanagement_model->getCourseDept();
    $this->load->view('modalForms', $data);
    $this->load->view('coursemanagement_modal', $data); 
?>
<style type="text/css">
  .popover-content{
    width: 280px;
  }
</style>
<script type="text/javascript">
    
    $(document).ready(function(){
      $("#subjectSearch").css("display", "none");

      $(".clickover").clickover({
        placement: 'right',
        html: true
      });
        $('#dcms_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    });
    
    function searchCourse(val){
        if(val.length !== 0){
            var courses = $(".search-list").filter(function(){
                return $(this).attr('course').toLowerCase().indexOf(val.toLowerCase()) > -1;
            });
            html = "";
            if(courses.length !== 0){
                $("#subjectSearch").html("");
                $.each(courses, function (idx, v){
                    html += "<tr>"+$(v).html()+"</tr>";
                });
            }else{
                var courses = $(".search-list").filter(function(){
                    return $(this).attr('code').toLowerCase().indexOf(val.toLowerCase()) > -1;
                });
                $.each(courses, function (idx, v){
                    html += "<tr>"+$(v).html()+"</tr>";
                });
            }
            console.log(html);
            $("#subjectSearch").html(html);
            $("#subjectsWrapper").css("display", "none");
            $("#subjectSearch").css("display", "");
        }else{
            $("#subjectsWrapper").css("display", "");
            $("#subjectSearch").css("display", "none");
        }
    }
    
    
    function editCourse(id, course, short_code, dept_id, num_years)
    {
        $('#addCourseId').val(id);
        $('#inputCourse').val(course);
        $('#inputShortCode').val(short_code);
        $('#numYears').val(num_years);
        $('#inputAddDepartment option').each(function(){
            if($(this).val()==dept_id)
            {   
                $(this).attr('selected','selected');
            }
        });
        
        $('#addCourseTitle').html('Edit Course');
        
        $('#addCourse').modal('show');
    }
    
    
    function addCourse()
    {
        var course_id = $('#addCourseId').val();
        var course = $('#inputCourse').val();
        var short_code = $('#inputShortCode').val();
        var department = $('#inputAddDepartment').val();
        var numYears = $('#numYears').val();
        var url = '<?php echo base_url().'college/coursemanagement/addCourse/' ?>';
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data:{
                       course_id            : course_id,
                       course               : course,
                       short_code           : short_code,
                       department           : department,
                       numYears             : numYears,
                       csrf_test_name       : $.cookie('csrf_cookie_name')
                    },
                   success: function(data)
                   {
                       alert(data.msg);
                       if(data.status && course_id==0){
                            $('#college').append('<li>'+course+'</li>');
                       }else{
                           location.reload();
                       }
                   }
                 });

            return false;
    }

    function editCourseDept(){
      var courseId = $('#courseid').val();
      var ccID = $('#editDepartment').val();
      var url = '<?php echo base_url() . 'college/coursemanagement/updateCourseDept/' ?>'+courseId+'/'+ccID;
      $.ajax({
        type: 'GET',
        url: url,
        data: '',
        success: function(data)
        {
          if(data)
          {
            alert('Department Successfully Updated');
          } else {
            alert('An Error Occured');
          }
          window.location.reload();
        }
      });
    }
    
    function getAdd(data)
    {
        $('#add'+data).modal('show');
    }
    
    function loadSubject(course = null)
    {
        $('#courseTitle').html(course);
        var school_year = $('#inputCSY').val();
        var url = '<?php echo base_url().'college/coursemanagement/loadSubject/' ?>'+$('#course_id').val()+'/'+school_year;
         $.ajax({
               type: "GET",
               url: url,
               dataType: 'json',
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#11_Sem').html(data.fyfs);
                   $('#12_Sem').html(data.fyss);
                   $('#1_Sum').html(data.fys);
                   $('#21_Sem').html(data.syfs);
                   $('#22_Sem').html(data.syss);
                   $('#2_Sum').html(data.sys);
                   $('#31_Sem').html(data.tyfs);
                   $('#32_Sem').html(data.tyss);
                   $('#3_Sum').html(data.tys);
                   $('#41_Sem').html(data.fryfs);
                   $('#42_Sem').html(data.fryss);
                   $('#4_Sum').html(data.frys);
               }
             });

        return false;
    }
    
    function getLevel(level)
    {
        alert(level)
        if(level=='k12'){
            $('#k12').show()
            $('#college').hide()
        }else if(level=='college'){
            $('#k12').hide()
            $('#college').removClass('hide')
            
        }
    }
    
    function removeSubjectFromCourse(value)
    {
        
        var url = '<?php echo base_url().'college/coursemanagement/removeSubjectFromCourse/' ?>'+value;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {    
                       alert(data)
                       $('#tr_'+value).hide();
                   }
                 });

            return false;
    }
    
    function addSection()
    {
        var section = $('#txtAddSection').val()
        var grade_id = $('#grade_id').val()
        var url = '<?php echo base_url().'coursemanagement/addSection/' ?>'+section+'/'+grade_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   dataType: 'json',
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data.msg)
                       if(data.status){
                            $('#'+grade_id+'_section').append('<li>'+section+'</li>');
                       }
                   }
                 });

            return false;
    }
    
    function addDepartment(){
      var department = $('#inputDepartment').val();
      var url = '<?php echo base_url().'coursemanagement/addDepartment/' ?>'+department;
      $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        data: '',
        success: function(data)
        {
          alert(data.msg);
        }
      });
    }
    
    function deleteSection()
    {
        var section_id = $('#sec_id').val()
        var section = $('#sec_name').val()
        var answer = confirm("Do you really want to delete this Section name '"+section+"'? You cannot undo this action, so be careful.");
        if(answer==true){
            var url = '<?php echo base_url().'coursemanagement/deleteSection/' ?>'+section_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully Deleted')
                       $('#'+section_id+'_li').hide();
                   }
                 });

            return false;
        }
    }
</script>