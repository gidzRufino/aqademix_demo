<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" colspan="7"><h3 class="no-padding"><?php $section = Modules::run('registrar/getSectionById', $section_id); echo $section->level.' - '.$section->section; ?></h3></th>
        </tr>
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
                        <td style="vertical-align:middle;" class="text-center" ><?php echo $t->time_fr.' - '.$t->time_to ?></td>
                        <?php   

                            for($d=1;$d<=6;$d++):
                                $s = Modules::run('schedule/getSched', $t->time_fr, $t->time_to, $d);
                                $timeSched = Modules::run('schedule/getAllSchedule', $t->time_fr, $t->time_to, $d, NULL, $section_id);
                                if($d == $s->day):

                                        ?>
                                            <td style="vertical-align:middle;" onmouseover="$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>')" data-toggle="context" data-target="#addSchedMenu" class="text-center no-padding"> <?php 
                                            foreach ($timeSched as $ts): 
                                            ?>
                                                <button id="<?php echo $ts->sched_id ?>_sched" onmouseover="$('#selectedSchedId').val('<?php echo $ts->sched_id ?>'),$('#selectedDayID').val('<?php echo $d ?>'), $('#inputTimeFrom').val('<?php echo $t->time_fr ?>'), $('#inputTimeTo').val('<?php echo $t->time_to ?>'), $('#timeSchedID').val('<?php echo $t->time_id ?>')" class="btn btn-xs btn-danger col-lg-12"><?php if($ts->subject_id==0): echo $ts->short_code;else:echo $ts->short_code.' - '.$ts->section;endif;?></button>
                                            <?php    
                                            endforeach;   
                                            ?></td>
                                        <?

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