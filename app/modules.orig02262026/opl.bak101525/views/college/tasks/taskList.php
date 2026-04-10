<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h5 class="page-header"><i class="nav-icon fas fa-tasks"></i> List of Task</h5>
            <table class="table table-striped table-responsive-sm col-12">
                <tr>
                    <th></th>
                    <th>TASK TITLE</th>
                    <th>DATE CREATED</th>
                    <th class="text-center">DEADLINE FOR SUBMISSION</th>
                    <th class="text-center">ACTION</th>
                </tr>
                
                <?php 
    $cnt = count($tasks);
    if($cnt != 0):
    foreach ($tasks as $pd):
        
        ?>
                <tr style="cursor:pointer" >
                    <td class="text-center">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                    </td>
                    <td onclick="document.location='<?php echo base_url('opl/college/viewTaskDetails/'.$pd->task_code.'/'.$pd->task_grade_id.'/'.$pd->task_section_id.'/'.$pd->task_subject_id.'/'.$school_year)?>'"><?php echo $pd->task_title ?></td>
                    <td><span><?php echo date('F d, Y g:i a', strtotime($pd->task_start_time)) ?></span></td>
                    <td class="text-center">
                        <span id="op_id_<?php echo $pd->task_auto_id ?>"></span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-outline-success btn-sm" task-code='<?php echo $pd->task_code; ?>' task-title="<?php echo htmlspecialchars($pd->task_title); ?>" task-type='<?php echo $pd->task_type; ?>' task-details="<?php echo htmlspecialchars($pd->task_details); ?>" task-sgls='<?php echo $pd->task_subject_id.'-'.$pd->task_grade_id.'-'.$pd->task_section_id ?>' task-start-date='<?php echo date("Y-m-d", strtotime($pd->task_start_time)); ?>' task-start-time="<?php echo date("H:m:s", strtotime($pd->task_start_time)); ?>" task-end-date="<?php echo date("Y-m-d", strtotime($pd->task_end_time)); ?>" task-end-time="<?php echo date("H:m:s", strtotime($pd->task_end_time)); ?>" onclick='showEditModal(this)'><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline-danger btn-sm" task-code='<?php echo $pd->task_code; ?>' task-title='<?php echo $pd->task_title; ?>' onclick="showDeleteModal(this)"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                
               
                
        <input class="dateTime" task_id="<?php echo $pd->task_auto_id ?>"  type="hidden" id="dateTime_<?php echo $pd->task_auto_id ?>" value="<?php echo date('M d, Y G:i:s', strtotime($pd->task_end_time)) ?>" />
        <?php
    endforeach;
else:
    ?>
    <tr>
        <td class="text-center" colspan="5"><h3>No Tasks Listed</h3></td>
    </tr>
    <?php
endif;
                
                ?>
            </table>
        </div>

    </div>
</section>
<?php echo $this->load->view('tasks/editTask'); ?>
<script type="text/javascript">
       $(document).ready(function(){
            
            $('.dateTime').each(function(){
                  var id = $(this).attr('task_id');
                  var dateTime = $(this).val();
                  getCountDown(id, dateTime);
            });
            
       });   
       
       
            function getCountDown(id, dateTime) {
                  // Set the date we're counting down to
            var countDownDate = new Date(dateTime).getTime();
    
            // Update the count down every 1 second
            var x = setInterval(function() { 


            // Get today's date and time
                var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            var d = (days===0?"":days + "d ");
            
            document.getElementById("op_id_"+id).innerHTML = d + hours + "h "
                    + minutes + "m ";
//            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
//                    + minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
               $('#op_id_'+id).html(dateTime);
            }
        }, 1000);
            };
</script>    