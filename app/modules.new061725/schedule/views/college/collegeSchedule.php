<div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading clearfix">
            <button data-toggle="modal" data-target="#max_Schedule" onclick="maxSched()" id="maxSched" class="btn btn-success btn-xs pull-right"><i class="fa fa-external-link-square"></i></button>
            
            <h4>College Schedules</h4>
            
        </div>
    <div class="panel-body" >
        <div id="sched_body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th onmouseover="$('#timeDeleteMenu').hide()" data-toggle="context" data-target="#addTimeMenu" class="text-center pointer" style="width:14%;">Time</th>
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
                                <tr id="<?php echo $t->time_id ?>time">
                                    <td onmouseover="$('#timeDeleteMenu').show(), $('#timeSchedID').val('<?php echo $t->time_id ?>')" data-toggle="context" data-target="#addTimeMenu"  style="vertical-align:middle;" class="text-center" ><?php echo $t->time_fr.' - '.$t->time_to ?></td>
                                    <?php   

                                        for($d=1;$d<=6;$d++):
                                            $s = Modules::run('schedule/getSchedCollege', $t->time_fr, $t->time_to, $d);
                                            $timeSched = Modules::run('schedule/getAllSchedule', $t->time_fr, $t->time_to, $d);
                                            $teacher = Modules::run('hr/getEmployeeName', $s->t_id);
                                            if($d == $s->row()->day):
                                                    ?>
                                                        <td style="vertical-align:middle;" onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>')" data-toggle="context" data-target="#addSchedMenu" class="text-center no-padding"> 
                                                            <?php 
                                                            foreach ($s->result() as $s):
                                                        ?>
                                                            <button id="<?php echo $ts->sched_id ?>_sched" onmouseover="$('#selectedSchedId').val('<?php echo $ts->sched_id ?>'),$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>'), $('#selectedSectionID').val('<?php echo $ts->section_id ?>')" class="btn btn-xs btn-danger col-lg-12 text-center">
                                                                <?php echo $s->sub_code.' [ rm. '.$s->room.' ] <br />'. $s->short_code;?>
                                                            </button>
                                                        <?php 
                                                            endforeach;
                                                        ?>
                                                        </td>
                                                    <?php

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
</div>
<div id="max_Schedule"  style="width:95%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
</div>



<script type="text/javascript">
    
    
    
</script>