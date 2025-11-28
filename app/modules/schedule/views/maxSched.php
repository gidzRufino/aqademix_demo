<div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                    foreach ($time as $t):
                        ?>
                            <tr>
                                <td class="text-center" ><?php echo $t->time_fr.' - '.$t->time_to ?></td>
                                <?php   
                                
                                    for($d=1;$d<=6;$d++):
                                        $s = Modules::run('schedule/getSched', $t->time_fr, $t->time_to, $d);
                                        $timeSched = Modules::run('schedule/getAllSchedule', $t->time_fr, $t->time_to, $d);
                                        $teacher = Modules::run('hr/getEmployeeName', $s->t_id);
                                        if($d == $s->day):
                                            if($s->t_id!=""):
                                                ?>
                                                    <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>')" data-toggle="context" data-target="#addSchedMenu" class="text-center no-padding"> <?php 
                                                    foreach ($timeSched as $ts):
                                                        $teacher = Modules::run('hr/getEmployeeName', $ts->t_id);
                                                    ?>
                                                        <button id="<?php echo $ts->sched_id ?>_sched" onmouseover="$('#selectedSchedId').val('<?php echo $ts->sched_id ?>')" class="btn btn-xs btn-danger col-lg-12"><?php if($ts->subject_id==0): echo $ts->short_code;else:echo $ts->short_code.' - '.$ts->section.' [ '.$teacher->lastname.' ]';endif;?></button>
                                                    <?php    
                                                    endforeach;   
                                                    ?></td>
                                                <?
                                            else:
                                              ?>
                                               <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>')" 
                                                   data-toggle="context" data-target="#addSchedMenu"></td>     
                                              <?php
                                            endif;

                                        else:
                                              ?>
                                               <td onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>')" data-toggle="context" data-target="#addSchedMenu"></td>     
                                              <?php
                                        endif;
                                    endfor;
                             ?>
                            </tr>
                        <?php
                        
                    endforeach;
                
                ?>
            </tbody>
        </table>
    </div>
</div>