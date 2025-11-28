<table class="table table-striped">
        <tr>
            <th colspan="6" class="text-center"> Subjects Taken </th>
        </tr>
        <tr>
            <th class="text-center">Subject Code</th>
            <th class="text-center">Description</th>
            <th class="text-center">Lec Units</th>
            <th class="text-center">Lab Units</th>
            <th class="text-center">Schedule</th>
            <th></th>
        </tr>
            <?php
                $count = count($loadedSubject);
                $aprv = 0;
                foreach ($subjects as $ls):
                    $aprv += $ls->is_final;
                    
                  
            ?>
                        <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" onclick="removeSubject('<?php echo $ls->s_id ?>','<?php echo $ls->pre_req ?>')">
                                <td class="text-center"><?php echo $ls->sub_code ?></td>
                                <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                                <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo ($ls->s_lect_unit==0?0:$ls->s_lect_unit); ?></td>
                                <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo ($ls->s_lab_unit==0?0:$ls->s_lab_unit); ?></td>
                                <td class="text-center">
                                <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $ls->cl_section); 
                                    $sched = json_decode($scheds);
                                    echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                                ?>
                                </td>
                            </tr>

            <?php   
                        $totalUnitsLec += $ls->s_lect_unit;
                        $totalUnitsLab += $ls->s_lab_unit;

                endforeach;
            ?>

            <tr id="tr_total_taken">
                <td colspan="2"></td>
                <td id="totalLect_taken" class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLec==0?0:$totalUnitsLec) ?></td>
                <td class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLab==0?0:$totalUnitsLab) ?></td>
                <td class="text-center" style="font-weight: bold;"></td>
            </tr>  
            
</table>            