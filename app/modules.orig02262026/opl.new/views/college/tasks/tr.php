<?php 
    $cnt = count($tasks);
    if($cnt != 0):
        foreach ($tasks as $pd):
            
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
        <?php if(!$this->session->isOplAdmin): ?>
        <td class="text-center">
            <button class="btn btn-outline-success btn-sm" task-code='<?php echo $pd->task_code; ?>' task-title="<?php echo htmlspecialchars($pd->task_title); ?>" task-type='<?php echo $pd->task_type; ?>' task-sgls='<?php echo $pd->task_subject_id.'-'.$pd->task_grade_id.'-'.$pd->task_section_id ?>' task-start-date='<?php echo date("Y-m-d", strtotime($pd->task_start_time)); ?>' task-start-time="<?php echo date("H:m:s", strtotime($pd->task_start_time)); ?>" task-end-date="<?php echo date("Y-m-d", strtotime($pd->task_end_time)); ?>" task-end-time="<?php echo date("H:m:s", strtotime($pd->task_end_time)); ?>" onclick='showEditModal(this)'><i class="fas fa-edit"></i></button>
            <button class="btn btn-outline-danger btn-sm" task-code='<?php echo $pd->task_code; ?>' task-title='<?php echo $pd->task_title; ?>' onclick="showDeleteModal(this)"><i class="fas fa-trash"></i></button>
        </td>
        <?php endif; ?>
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