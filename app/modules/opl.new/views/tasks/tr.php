<?php
$cnt = count($tasks);
if ($cnt != 0):
    foreach ($tasks as $pd):
        if ($pd['task_term'] == $term):
?>
            <tr class="align-middle table-hover" style="cursor:pointer;">
                <!-- Drag Icon -->
                <td class="text-center text-muted">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </td>

                <!-- Task Title -->
                <td onclick="document.location='<?php echo base_url('opl/viewTaskDetails/' . $pd['task_code'] . '/' . $pd['task_grade_id'] . '/' . $pd['task_section_id'] . '/' . $pd['task_subject_id'] . '/' . $sy) ?>'">
                    <strong><?php echo htmlspecialchars($pd['task_title']); ?></strong>
                </td>

                <!-- Start Date -->
                <td>
                    <span class="badge bg-light text-dark">
                        <?= htmlspecialchars(date('F d, Y g:i a', strtotime($pd['task_start_time']))) ?>
                    </span>
                </td>

                <!-- Remaining Time -->
                <td class="text-center">
                    <?php
                    $now = new DateTime();
                    $start = new DateTime($pd['task_start_time']);
                    $end = new DateTime($pd['task_end_time']);
                    $beforeStart = $now->diff($start);

                    if ($beforeStart->format("%R") == "-"):
                        $remaining = $now->diff($end);
                        if ($remaining->format("%R") != '-'):
                            if ($remaining->format("%d") != 0):
                                echo '<span class="badge bg-success">' . $remaining->format("%dd %hh %im") . '</span>';
                            else:
                                echo '<span class="badge bg-warning text-dark">' . $remaining->format("%hh %im") . '</span>';
                            endif;
                            echo '<br><small class="text-muted fst-italic">Refresh to update</small>';
                        else:
                            echo '<span class="badge bg-danger">Expired</span><br>';
                            echo '<small class="text-muted">' . date('F d, Y h:i a', strtotime($pd['task_end_time'])) . '</small>';
                        endif;
                    else:
                        echo '<span class="badge bg-info text-dark">Starts: ' . date('F d, Y h:i a', strtotime($pd['task_end_time'])) . '</span>';
                    endif;
                    ?>
                </td>

                <!-- Action Buttons -->
                <?php if (!$this->session->isOplAdmin): ?>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button
                                class="btn btn-sm btn-outline-primary"
                                title="Edit Task"
                                task-term='<?= $pd['task_term'] ?>'
                                task-code='<?php echo $pd['task_code']; ?>'
                                task-title="<?php echo htmlspecialchars($pd['task_title']); ?>"
                                task-type='<?php echo $pd['task_type']; ?>'
                                task-details="<?php echo htmlspecialchars($pd['task_details']); ?>"
                                task-sgls='<?php echo $pd['task_subject_id'] . '-' . $pd['task_grade_id'] . '-' . $pd['task_section_id'] ?>'
                                task-start-date='<?php echo date("Y-m-d", strtotime($pd['task_start_time'])); ?>'
                                task-start-time="<?php echo date("H:i:s", strtotime($pd['task_start_time'])); ?>"
                                task-end-date="<?php echo date("Y-m-d", strtotime($pd['task_end_time'])); ?>"
                                task-end-time="<?php echo date("H:i:s", strtotime($pd['task_end_time'])); ?>"
                                task-total-item="<?= $pd['task_total_score'] ?>"
                                task-attachments="<?= $pd['task_attachments'] ?>"
                                task-gsComponent="<?= $pd['gs_component_id'] ?>"
                                onclick='showEditModal(this)'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-sm btn-outline-danger"
                                title="Delete Task"
                                task-code='<?php echo $pd['task_code']; ?>'
                                task-title='<?php echo htmlspecialchars($pd['task_title']); ?>'
                                onclick="showDeleteModal(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
    <?php
        endif;
    endforeach;
else:
    ?>
    <tr>
        <td class="text-center p-4 text-muted" colspan="5">
            <i class="fas fa-tasks fa-2x mb-2"></i>
            <h5>No Tasks Listed</h5>
            <small>Try creating a new task to get started</small>
        </td>
    </tr>
<?php
endif;
?>