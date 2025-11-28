<?php echo Modules::run('academic/viewCollegeTeacherInfo', $id, $school_year); ?>
<div class='col-lg-12 no-padding'>
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h5 class="text-center no-margin col-lg-7">Subjects Assigned</h5>
            <div class="col-lg-5 pull-right">
                <button onclick="window.open('<?php echo base_url('college/subjectmanagement/teachingLoadPerInstructor/')?>'+$('#inputSY').val()+'/'+$('#semInput').val()+'/<?php echo base64_encode($id) ?>','_blank')" class="btn btn-sm btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-print"></i></button>
                <a href="#" onclick="$('#addCollegeSubjectModal').modal('show')"class="btn btn-sm btn-primary pull-right" style="margin-right: 5px;">Add Subject</a>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Section Code</th>
                        <th>Descriptive Title</th>
                        <th>Schedule</th>
                        <th class="text-center">Units</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php
                $totalUnits = 0;
                //print_r($subjects);
                foreach ($subjects as $s):
                    $totalUnits += $s->s_lect_unit;
                ?>
                <tr id="tr_<?php echo $s->sched_gcode ?>">
                    <td><?php echo $s->sub_code; ?></td>
                    <td><?php echo $s->section; ?></td>
                    <td><?php echo $s->s_desc_title; ?></td>
                    <td>
                        <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year); 
                            $sched = json_decode($scheds);
                            echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'');
                        ?>
                    </td>
                    <td class="text-center"><?php echo ($s->sub_code == "NSTP 11" || $s->sub_code == "NSTP 12" || $s->sub_code == "NSTP 1" || $s->sub_code == "NSTP 2" ? 3 : ($s->s_lect_unit + $s->s_lab_unit)); ?></td>
                    <td class="text-center">
                        <button onclick="removeSubject('<?php echo $s->sched_gcode; ?>','<?php echo $school_year; ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <?php    
                endforeach;
                if($totalUnits > 0):
                ?>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center"><?php echo $totalUnits; ?></th>
                        <th></th>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?php 
$this->load->view('regModal') ?>

<script type="text/javascript">
    
    
    function removeSubject(id, school_year)
    {
        var teacher = $('#teacher_id').val();
        r = confirm('Are you sure you want to remove subject Assigned?');
        if(r==true){
            var url = "<?php echo base_url().'college/deleteFacultyAssignment/'?>"+id+'/'+school_year;
            $.ajax({
                   type: "GET",
                   url: url,
                   data:'csrf_test_name='+$.cookie('csrf_cookie_name'),
                   dataType:'json',
                   success: function(data)
                   {
                        if(data.status){
                            $('#subjectsAssignedTable').html(data.data);
                            alert('Successfully Removed');
                            $('#tr_'+id).remove();
                            
                        }
                            $('#notify_me').show();
                            $('#notify_me').fadeOut(5000);
                   }
                 });

            return false; 
       }
          
    }
    
</script>