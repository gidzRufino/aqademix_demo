<td key="<?php echo $key ?>_6" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="6" id="td_<?php echo $key ?>_6" class="no-padding text-center" style="width:16.6%; text-algin:center; ">
       <?php 

            foreach ($day6 as $d6):
                if(strtotime($value)== strtotime($d6->t_from)):
                    ?>
                        <div onclick="confirmDelete('td_<?php echo $key ?>_6','<?php echo $d6->sched_gcode  ?>')" id="delete_<?php echo $d6->sched_gcode  ?>_6" style="position: relative; width: 100%; top:-18px; display: none;">
                            <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                        </div>
                        <input gcode="<?php echo $d6->sched_gcode  ?>" bg="<?php echo $d6->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_6" />
                        <?php echo $d6->sub_code.' - Rm. '.$d6->room.'<br />'.$d6->short_code.'-'.$d6->section; ?>
                    <?php 
                elseif(strtotime($value)< strtotime($d6->t_to) && strtotime($value) >  strtotime($d6->t_from)):
                    ?>
                        <input gcode="<?php echo $d6->sched_gcode  ?>"  bg="<?php echo $d6->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_6" />
                          <?php echo $d6->t_from.' - '.$d6->t_to; ?>

                    <?php
                endif;
            endforeach;

       ?>
   </td>