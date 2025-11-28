 <?php
                $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $admission_id, NULL, $school_year );
                
                $count = count($loadedSubject);
                $aprv = 0;
                foreach ($loadedSubject as $ls):
                    $aprv += $ls->is_final;
                    
                   if($this->session->userdata('position_id') == 1 || $this->session->userdata('position_id') >= 65 && $this->session->userdata('position_id') <= 69 || $this->session->userdata('position_id')== 44 ):
            ?>
                        <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" onclick="removeSubject('<?php echo $ls->s_id ?>','<?php echo $ls->pre_req ?>')">
                            <td class="text-center"><?php echo $ls->sub_code ?></td>
                            <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                            <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo $ls->s_lect_unit ?></td>
                            <td class="text-center">
                            <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $ls->cl_section, $ls->semester, $school_year); 
                                $sched = json_decode($scheds);
                                echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                            ?>
                            </td>
                        </tr>

            <?php   
                        $totalUnitsLec += $ls->s_lect_unit;
                        $totalUnitsLab += $ls->s_lab_unit;
                    else:
                        if($ls->is_final):    
            ?>
                        
                            <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" onclick="removeSubject('<?php echo $ls->s_id ?>','<?php echo $ls->pre_req ?>')">
                                <td class="text-center"><?php echo $ls->sub_code ?></td>
                                <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                                <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo ($ls->s_lect_unit==0?0:$ls->s_lab_unit+$ls->s_lect_unit); ?></td>
                                <td class="text-center"></td>
                            </tr>

            <?php       $totalUnitsLec += $ls->s_lect_unit;
                        $totalUnitsLab += $ls->s_lab_unit;
                        endif;
                    endif;
                    
                    
                endforeach;
            ?>

            <tr id="tr_total_taken">
                <td colspan="2"></td>
                <td id="totalLect_taken" class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLec==0?0:$totalUnitsLec) ?></td>
                <!--<td class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLab==0?0:$totalUnitsLab) ?></td>-->
            </tr>  