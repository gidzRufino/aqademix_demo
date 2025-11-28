<!--Add Subject Modal-->

<div id="addCollegeSubjectModal" class="modal fade" style="width:900px; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h4 class="no-margin">Add Subject
            <div class="form-group col-lg-4 pull-right" id='searchBox' style="margin:10px 0;">
                <div class="controls">
                  <input autocomplete="off"  class="form-control" onkeypress="if (event.keyCode == 13) {searchSubject(this.value)}"  name="searchSubject" type="text" id="searchSubject" placeholder="Search Subject" required>
                  <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
                </div>
                <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

                </div>
            </div>
            </h4>
        </div>
        <div class="panel-body clearfix" id="subjectBody">
            
        </div>
            
    </div>
</div>

<!--Advisory Assignment Modal-->

<div id="advisoryModal" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green clearfix">
        <div class="panel-heading clearfix">
            <h4 class="pull-left">Advisory Assignment</h4>
            <i class="pull-right fa fa-close pointer" data-dismiss="modal"></i>
        </div>
        <div class="panel-body">
                <select name="inputGradeModal" onclick="selectSection(this.value)" tabindex="-1" id="inputGradeModal" style="width:150px" class="populate select2-offscreen span2">
                     <option>Select Grade Level</option>
                     <?php 
                           foreach ($GradeLevel as $level)
                            {   
                           ?>                        
                              <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                         <?php }?>
                 </select>
                 <select  tabindex="-1" id="inputSectionModal" name="inputSectionModal" style="width:150px" class="populate select2-offscreen span2">
                     <option>Select Section</option>

                 </select>

        
        </div>
        <div class="pull-right">
             <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button data-dismiss="modal" id="addAdvisorySubmit" class="btn btn-primary">Save </button>

        </div>
    </div>
    
</div>

<script type="text/javascript">
    
         
    function searchSubject(value)
     {
        var semester = $('#semInput').val();
        var school_year = $('#inputSY').val();
        var url = "<?php echo base_url().'college/subjectmanagement/searchSubject/'?>"+value+'/'+semester+'/'+school_year; // the script where you handle the form input.

        $.ajax({
               type: "GET",
               url: url,
               //dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#subjectBody').html(data)
               }
             });

        return false; 
     }
     
    
    
    $(document).ready(function() {

          $("#addSchedSubmit").click(function() {
            $("#addSchedForm").submit();
          }); 
          $("#addAdvisorySubmit").click(function() {
                var url = "<?php echo base_url().'academic/setAdviser/'?>"
                $.ajax({
                   type: "POST",
                   url: url,
                   data:'inputFacultyID='+$('#em_id').val()+"&inputGradeModal="+$('#inputGradeModal').val()+'&inputSectionModal='+$('#inputSectionModal').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements. 
                   success: function(data)
                   {
                       alert(data)
                       $('#advisoryModal').modal('hide');
                   }
                 });

            return false;  
          }); 
          $("#inputGradeModal").select2();
          $("#inputSectionModal").select2();
    });
</script>

<!-- End of Schedule Modal-->
