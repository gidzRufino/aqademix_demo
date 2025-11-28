
                
                <?php 
    $cnt = count($tasks);
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