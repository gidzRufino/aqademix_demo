<!--<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h4 class="page-header"><i class="nav-icon fas fa-tasks"></i> New Task</h4>
            <div class="alert alert-info col-12">
                <h6 class="text-center">No Task for Today</h6>
            </div>
        </div>

    </div>
</section>-->
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
                    <th class="text-center">STATUS</th>
                </tr>
                
                <?php 
    $cnt = count($tasks);
   // print_r($tasks);
    if($cnt != 0):
    foreach ($tasks as $pd):
        $iSubmitted = Modules::run('opl/opl_variables/getSubmittedTask', $pd->task_code, $this->session->school_year, $this->session->details->st_id);
        ?>
                <tr style="cursor:pointer" >
                    <td class="text-center">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                    </td>
                    <td onclick="document.location='<?php echo base_url('opl/viewTaskDetails/'.$pd->task_code.'/'.$pd->task_grade_id.'/'.$pd->task_section_id.'/'.$pd->task_subject_id)?>'"><?php echo $pd->task_title ?></td>
                    <td><span><?php echo date('F d, Y g:i a', strtotime($pd->task_start_time)) ?></span></td>
                    <td class="text-center">
                        <span id="op_id_<?php echo $pd->task_auto_id ?>"></span>
                    </td>
                    <td class="text-center" style="font-size:15px;">
                        <?php if ($iSubmitted->row()): 
                                echo 'Done';
                            else:
                                if(strtotime(date('Y-m-d g:i:s')) > strtotime($pd->task_end_time)):
                                     echo '<span class="text-danger">Pending Submission / Past Due</span>';
                                else:
                                    echo '<span class="text-danger">Pending Submission</span>';
                                endif;
                            endif;
                            ?>
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