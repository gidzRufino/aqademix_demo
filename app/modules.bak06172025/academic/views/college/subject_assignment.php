<div class="col-lg-12 no-padding" style="border-bottom: 1px solid #EEEEEE;">
    <h3 class="pull-left col-lg-5">College Teaching Load </h3>
    
    <div class="col-lg-3 no-padding" style="margin:25px 0 5px;">
            <h5 style="margin:0;">Search By:
            <select id="searchOption"  onclick="getSearchOption(this.value)" style="width:150px; margin-right:5px;">
                <option>Select Option</option>
                <option value="employee_id">Teacher</option>
                <option value="" onclick="document.location='<?php echo base_url('academic/facultyAssignment') ?>'">K-12</option>
            </select>
             </h5>
    </div>
    <div class="form-group col-lg-4 pull-right" id='searchBox' style="margin:10px 0;">
        <div class="controls">
          <input autocomplete="off"  class="form-control" onkeydown="searchTeacher(this.value)"  name="searchTeacher" type="text" id="searchTeacher" placeholder="Search Teacher's Family Name" required>
          <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
        </div>
        <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

        </div>
    </div>
    <div class="form-group  col-lg-4 pull-right" id="grade" style=" display: none; margin:15px 0 5px;">
            <select onclick="getAssignmentByGradeLevel(this.value)" tabindex="-1" id="inputGrade" style="width:90%; font-size: 15px;" >
                <option>Search Grade level here</option>
                <?php 
                      foreach ($grade as $level)
                       {   
                      ?>                        
                    <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                    <?php }?>
            </select>
     </div>
</div> 
<div class="col-lg-12" id="teacherResult">
    
</div>
<?php 
$data['subjects'] = $subjects;
$data['GradeLevel'] = $grade;
$this->load->view('regModal', $data) ?>
<script type="text/javascript">
    
    $(document).ready(function() {
      $("#inputGrade").select2({});
      $("#inputSection").select2();
      $("#inputGradeAssign").select2({});
      $("#inputSectionAssign").select2();
      $("#inputSubjectAssign").select2();
    });
    
    function removeSubject(id)
    {
        var teacher = $('#em_id').val();
        r = confirm('Are you sure you want to remove subject Assigned?');
        if(r==true){
            var url = "<?php echo base_url().'academic/deleteAssignment/'?>"+id+'/'+teacher;
            $.ajax({
                   type: "GET",
                   url: url,
                   data:'csrf_test_name='+$.cookie('csrf_cookie_name'),
                   dataType:'json',
                   success: function(data)
                   {
                        if(data.status){
                            $('#subjectsAssignedTable').html(data.data)
                            $('#notify_me').html(data.msg)
                        }
                            $('#notify_me').show();
                            $('#notify_me').fadeOut(5000);
                   }
                 });

            return false; 
       }
          
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
        var url = "<?php echo base_url().'academic/teacherSearch/'?>";
        if(value==""){
              $('#citySearch').hide();
              $('#cityId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
        var url = "<?php echo base_url().'academic/getAssignedSubjectCollege/'?>";
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
        
    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputSection').html(data);
                   $('#inputSectionModal').html(data);
               }
             });

        return false;
  }
        
    function selectSectionAssign(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputSectionAssign').html(data);
                   $('#submitAdmission').show();
                   $('#submitAdmissionDisabled').hide();
               }
             });

        return false;
  }
</script>