<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width:50px;"><i class="fas fa-bars"></i></th>
                <th>Task Title</th>
                <th style="width:200px;">Start Date</th>
                <th style="width:250px;" class="text-center">Time Remaining</th>
                <th style="width:200px;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = count($tasks);
            if ($cnt != 0):
                foreach ($tasks as $pd):
                    $iSubmitted = Modules::run('opl/opl_variables/getSubmittedTask', $pd->task_code, $this->session->school_year, $this->session->details->st_id);

                    $taskId = $pd->task_auto_id; // unique identifier

                    // Dates
                    $now   = new DateTime();
                    $start = new DateTime($pd->task_start_time);
                    $end   = new DateTime($pd->task_end_time);

                    $totalDuration   = $end->getTimestamp() - $start->getTimestamp();
                    $elapsedDuration = $now->getTimestamp() - $start->getTimestamp();
                    $progress = ($totalDuration > 0) ? ($elapsedDuration / $totalDuration) * 100 : 100;
                    if ($progress < 0) $progress = 0;
                    if ($progress > 100) $progress = 100;
                    $progressText = round($progress) . "%";

                    if ($progress >= 100) {
                        $progressClass = "bg-danger";
                    } elseif ($progress >= 50) {
                        $progressClass = "bg-warning";
                    } else {
                        $progressClass = "bg-success";
                    }

                    // Status + row color
                    $rowClass = '';
                    $statusBadge = '';
                    if ($iSubmitted->row()):
                        $rowClass = 'table-success';
                        $statusBadge = '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Submitted</span>';
                    else:
                        if ($now > $end):
                            $rowClass = 'table-danger';
                            $statusBadge = '<span class="badge badge-danger"><i class="fas fa-exclamation-circle"></i> Past Due</span>';
                        else:
                            $rowClass = 'table-warning';
                            $statusBadge = '<span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>';
                        endif;
                    endif;

                    $remaining = $now->diff($end);
                    $timeRemaining = ($remaining->format("%R") != '-') ?
                        ($remaining->format("%d") != 0 ? $remaining->format("%dd %hh %im") : $remaining->format("%hh %im"))
                        : '<span class="text-danger">Expired</span>';
            ?>
                    <tr class="<?= $rowClass ?>" style="cursor:pointer"
                        onclick="document.location='<?php echo base_url('opl/viewTaskDetails/' . $pd->task_code . '/' . $pd->task_grade_id . '/' . $pd->task_section_id . '/' . $pd->task_subject_id . '/' . $this->session->details->school_year) ?>'">
                        <td class="text-center align-middle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </td>
                        <td class="align-middle">
                            <i class="fas fa-tasks text-primary"></i> <?php echo $pd->task_title ?>
                        </td>
                        <td class="align-middle">
                            <i class="far fa-calendar-alt"></i> <?php echo date('F d, Y h:i a', strtotime($pd->task_start_time)) ?>
                        </td>
                        <td class="align-middle">
                            <div>
                                <i class="far fa-clock"></i> <span id="timeRemaining_<?= $taskId ?>"><?= $timeRemaining ?></span>
                            </div>
                            <div class="progress mt-1" style="height: 20px; font-size: 12px; font-weight: bold;">
                                <div id="progressBar_<?= $taskId ?>"
                                    class="progress-bar progress-bar-striped progress-bar-animated <?= $progressClass ?>"
                                    role="progressbar"
                                    style="width: <?= $progress ?>%;">
                                    <?= $progressText ?>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <?= $statusBadge ?>
                        </td>
                    </tr>

                    <!-- hidden values for JS auto-update -->
                    <input type="hidden" id="startTime_<?= $taskId ?>" value="<?= $start->getTimestamp() ?>">
                    <input type="hidden" id="endTime_<?= $taskId ?>" value="<?= $end->getTimestamp() ?>">

                <?php
                endforeach;
            else:
                ?>
                <tr>
                    <td class="text-center" colspan="5">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> No Tasks Listed
                        </div>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>

<script>
    function updateTasks() {
        <?php foreach ($tasks as $pd): ?>
                (function() {
                    let taskId = "<?= $pd->task_auto_id ?>";
                    let start = parseInt(document.getElementById("startTime_" + taskId).value);
                    let end = parseInt(document.getElementById("endTime_" + taskId).value);
                    let now = Math.floor(Date.now() / 1000);

                    let total = end - start;
                    let elapsed = now - start;
                    let progress = (total > 0) ? (elapsed / total) * 100 : 100;
                    if (progress < 0) progress = 0;
                    if (progress > 100) progress = 100;

                    let remainingSeconds = end - now;
                    let remainingText = "";
                    if (remainingSeconds > 0) {
                        let days = Math.floor(remainingSeconds / (60 * 60 * 24));
                        let hours = Math.floor((remainingSeconds % (60 * 60 * 24)) / 3600);
                        let mins = Math.floor((remainingSeconds % 3600) / 60);
                        remainingText = (days > 0 ? days + "d " : "") + hours + "h " + mins + "m";
                    } else {
                        remainingText = "<span class='text-danger'>Expired</span>";
                    }

                    // update UI
                    document.getElementById("timeRemaining_" + taskId).innerHTML = remainingText;

                    let progressBar = document.getElementById("progressBar_" + taskId);
                    progressBar.style.width = progress + "%";
                    progressBar.innerHTML = Math.round(progress) + "%";

                    // color change
                    progressBar.classList.remove("bg-success", "bg-warning", "bg-danger");
                    if (progress >= 100) {
                        progressBar.classList.add("bg-danger");
                    } else if (progress >= 50) {
                        progressBar.classList.add("bg-warning");
                    } else {
                        progressBar.classList.add("bg-success");
                    }
                })();
        <?php endforeach; ?>
    }

    // update every 60s
    setInterval(updateTasks, 60000);
</script>