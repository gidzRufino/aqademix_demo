<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h5 class="page-header"><i class="nav-icon fas fa-tasks"></i> Rubric List</h5>
            <table class="table table-striped table-responsive-sm col-12">
                <tr>
                    <th></th>
                    <th>Name of Rubric</th>
                    <th class="text-center">Number of Criteria</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Scale</th>
                    <th class="text-center">ACTION</th>
                </tr>
                
                <?php 
                    $cnt = count($list);
                    if($cnt != 0):
                    foreach ($list as $rb):

                        ?>
                                <tr style="cursor:pointer" >
                                    <td class="text-center">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </td>
                                    <td onclick="document.location='<?php echo base_url('opl/rubricDetails/'.$school_year.'/'.$rb->ruid) ?>'"><?php echo $rb->ru_alias ?></td>
                                    <?php $criteria = Modules::run('opl/getRubricCriteria', $rb->ruid, $school_year); ?>
                                    <td class="text-center"><?php echo $criteria->num_rows() ?></td>
                                    <td class="text-center"><?php echo ($rb->ru_type?'Project Type':'In Test Type') ?></td>
                                    <td class="text-center"><?php echo '1 - '.$rb->ri_scale ?></td>
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