<div class="col-lg-12 no-padding" style="border-bottom: 1px solid #EEEEEE;">
    <h3 style="margin:10px 0;" class="page-header">List of Faculty with Grades <?php echo ($term==2?'[Mid Term]':'[Final Term]') ?>
   
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/gradingsystem/listOfFacultyWGrades/'.($term==2?4:2).'/'.$sem.'/'.$school_year) ?>'"><?php echo ($term==2?'Final Term':'Mid Term') ?></button>
         </div>
    </h3>    
</div>    
<div class="col-lg-12">
    <table class="table">
        <tr><th>#</th><th>Last Name</th><th>First Name</th></tr>
        
        <?php 
        $i = 0;
        foreach ($facultyList as $f): 
            $i++;
            ?>
        
        <tr class="pointer" onclick="$('#subjectsPerTeacher').modal('show'), $('#nameHeader').html('<?php echo strtoupper($f->firstname.' '.$f->lastname) ?>'), getTeachingLoad('<?php echo $f->employee_id ?>')">
            <th><?php echo $i; ?></th>
            <th><?php echo strtoupper($f->lastname) ?></th>
            <th><?php echo strtoupper($f->firstname) ?></th></tr>
        <?php endforeach; ?>
    </table>
</div>

<div id="subjectsPerTeacher" class="modal fade col-lg-8 col-md-12" style="margin:15px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h4 class="no-margin"><span id="nameHeader"></span> Teaching Load 
            <i class="pull-right fa fa-close pointer" data-dismiss="modal"></i>
            </h4>
        </div>
        <div class="panel-body clearfix" id="subjectBody">
            
        </div>
            
    </div>
</div>

<div id="studentsPerSubjectList" class="modal fade col-lg-9 col-md-12" style="margin:15px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h4 class="no-margin">
            <i class="pull-right fa fa-close pointer" data-dismiss="modal"></i>
            </h4>
        </div>
        <div class="panel-body clearfix" id="studentsPerSubjectListBody">
            
        </div>
            
    </div>
</div>


<input type="hidden" id="semInput" value="<?php echo $sem ?>" />
<input type="hidden" id="termInput" value="<?php echo $term ?>" />
<input type="hidden" id="syInput" value="<?php echo $school_year ?>" />

<script type="text/javascript">
    
         
    function getTeachingLoad(id)
     {
        var semester = $('#semInput').val();
        var school_year = $('#syInput').val();
        
        var url = "<?php echo base_url().'college/gradingsystem/getAssignedSubjectCollege/'?>"+id+'/'+semester+'/'+school_year; // the script where you handle the form input.

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
    
         
    function getDeansListOfStudentPerSubject(id, sec_id, sub_id)
     {
        var semester = $('#semInput').val();
        var term = $('#termInput').val();
        var school_year = $('#syInput').val();
        var url = "<?php echo base_url().'college/gradingsystem/getDeansListOfStudentPerSubject/'?>"+id+'/'+sec_id+'/'+sub_id+'/'+semester+'/'+term+'/'+school_year; // the script where you handle the form input.

        $.ajax({
               type: "GET",
               url: url,
               //dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#studentsPerSubjectList').modal('show')
                   $('#studentsPerSubjectListBody').html(data)
               }
             });

        return false; 
     }
     
     function approveAll()
     {
         $('.st_value').each(function(){
             approveGrade($(this).attr('row'), $(this).attr('st_id'),$(this).attr('sub_id'));
          });
    }
     
     function approveGrade(id, st_id, sub_id)
     {
        var semester = $('#semInput').val();
        var term = $('#termInput').val();
        var url = "<?php echo base_url().'college/gradingsystem/approveGrade/'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data:{ 
                    st_id           : st_id,
                    sub_id          : sub_id,
                    sem             : semester,
                    term            : term,
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                   
               }, // serializes the form's elements.
               success: function(data)
               {
                   if(data.success)
                   {
                        $('#td_'+id).html('<button class="btn btn-success btn-xs disabled" >APPROVED</button>');
                   }
               }
             });

        return false; 
     }
     
</script>