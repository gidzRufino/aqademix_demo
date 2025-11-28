<div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading clearfix">
            <button data-toggle="modal" data-target="#max_Schedule" onclick="maxSched()" id="maxSched" class="btn btn-success btn-xs pull-right"><i class="fa fa-external-link-square"></i></button>
            <h4>Schedules</h4>
            
        </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th data-toggle="context" data-target="#addTimeMenu" class="text-center pointer" style="width:14%;">Time</th>
                    <!--<th class="text-center" style="width:12.5%;">Sun</th>-->
                    <th class="text-center" style="width:12.5%;">Mon</th>
                    <th class="text-center" style="width:12.5%;">Tue</th>
                    <th class="text-center" style="width:12.5%;">Wed</th>
                    <th class="text-center" style="width:12.5%;">Thu</th>
                    <th class="text-center" style="width:12.5%;">Fri</th>
                    <th class="text-center" style="width:12.5%;">Sat</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $prev = array();
                    foreach ($schedules as $sched):
                        $time = strtotime($sched->time_fr)+  strtotime($sched->time_to);
                        if(!in_array($time, $prev)):
                ?>
                <tr>
                    <?php
                        
                            $prev[] = $time;
                    ?>
                        <td class="text-center" ><?php echo $sched->time_fr.' - '.$sched->time_to ?></td>
                <?php   
                       
                        
                        for($d=1;$d<=6;$d++):
                            $s = Modules::run('schedule/getSched', $sched->time_fr, $sched->time_to, $d);
                            $timeSched = Modules::run('schedule/getAllSchedule', $sched->time_fr, $sched->time_to, $d);
                            $teacher = Modules::run('hr/getEmployeeName', $s->t_id);
                            if($d == $s->day):
                                if($s->t_id!=""):
                                    ?>
                                        <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>')" data-toggle="context" data-target="#addSchedMenu" class="text-center no-padding"> <?php 
                                        foreach ($timeSched as $t):
                                            $teacher = Modules::run('hr/getEmployeeName', $t->t_id);
                                        ?>
                                            <button id="<?php echo $t->sched_id ?>_sched" onmouseover="$('#selectedSchedId').val('<?php echo $t->sched_id ?>')" class="btn btn-xs btn-danger col-lg-12"><?php echo $t->short_code.' - '.$t->section;      ?></button>
                                        <?php    
                                        endforeach;   
                                        ?></td>
                                    <?
                                else:
                                  ?>
                                   <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $sched->time_fr ?>'), $('#inputTimeTo').val('<?php echo $sched->time_to ?>')" 
                                       data-toggle="context" data-target="#addSchedMenu"></td>     
                                  <?php
                                endif;
                                
                            else:
                                  ?>
                                   <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $sched->time_fr ?>'), $('#inputTimeTo').val('<?php echo $sched->time_to ?>')" data-toggle="context" data-target="#addSchedMenu"></td>     
                                  <?php
                            endif;
                        endfor;
                 ?>
                </tr>
                 <?php
                    endif;
                    unset($time);
                    endforeach;
                
                ?>
            </tbody>
        </table>
    </div>
</div>
<div id="max_Schedule"  style="width:95%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
</div>
<input type="hidden" id="selectedSchedId" />
<input type="hidden" id="selectedDayID" />


<script type="text/javascript">

    function deleteSchedule()
    {
       var id = $('#selectedSchedId').val()
       var answer = confirm("Do you really want to delete this schedule? You cannot undo this action.");
        if(answer==true){
            var url = "<?php echo base_url().'schedule/deleteSched/'?>"+id ;
               $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                data: 'qcode='+id, // serializes the form's elements.
                success: function(data)
                {   
                    if(data.status){
                        $('#'+id+'_sched').addClass('hide')
                        alert(data.msg)
                    }else{
                        alert(data.msg)
                    }
                    
                }
              });
         }
         
        
    }
    
</script>