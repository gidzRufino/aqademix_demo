<?php
// Helper functions for avatar and file existence
function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}
// =========================
// 1. SETUP & HELPERS
// =========================

// Determine column size based on task ownership/submission
$col = 'col-lg-12';

if ($task->task_author_id === $this->session->username) {
    $submittedTask = Modules::run(
        'opl/opl_variables/getSubmittedTask',
        $task->task_code,
        $this->session->school_year
    );
    $col = count($submittedTask->result()) > 0 ? 'col-lg-6' : 'col-lg-12';
}

if ($this->session->isStudent) {
    $iSubmitted = Modules::run(
        'opl/opl_variables/getSubmittedTask',
        $task->task_code,
        $this->session->school_year,
        $this->session->details->st_id
    );
    $col = $iSubmitted->row() ? 'col-lg-6' : 'col-lg-12';
}

$avatar = getAvatarUrl($task->avatar, $task->sex);

// Helper: Check if file exists in uploads directory
function uploadedFileExists($filePath)
{
    return !empty($filePath) && file_exists(FCPATH . $filePath);
}
?>
<style>
    /* Smooth transitions for buttons, avatar, and header */
    .task-header,
    .task-header-btn,
    .task-header-avatar {
        transition: all 0.2s ease-in-out;
    }

    /* Header hover effect */
    .task-header:hover {
        background-color: #f8f9fa !important;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    /* Avatar hover glow */
    .task-header-avatar:hover {
        box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
        transform: scale(1.05);
    }

    /* Button hover lift */
    .task-header-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    /* Dropdown hover highlight */
    .dropdown-menu .dropdown-item:hover {
        background: #f1f3f5;
        color: #000;
    }

    /* Badge pulse effect */
    .task-type-badge {
        position: relative;
        overflow: hidden;
    }

    .task-type-badge::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        transform: translate(-50%, -50%) scale(0.9);
        background: rgba(255, 255, 255, 0.3);
        opacity: 0;
        animation: badgePulse 2s infinite;
    }

    @keyframes badgePulse {
        0% {
            transform: translate(-50%, -50%) scale(0.9);
            opacity: 0.6;
        }

        70% {
            transform: translate(-50%, -50%) scale(1.4);
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }
</style>
<div class="row">
    <?php
    // print_r($task);
    if ($task):
    ?>
        <!-- Task Details -->
        <section id="detailsTask" class="<?= $col ?> mb-4">
            <div class="card shadow-sm border-0 rounded-3">

                <!-- Header -->
                <div class="card-header task-header bg-white border-0 shadow-sm d-flex align-items-center rounded-top py-2 px-3 flex-wrap">
                    <!-- Avatar -->
                    <img src="<?= $avatar ?>" alt="User Avatar"
                        class="task-header-avatar rounded-circle border shadow-sm me-2 mb-2 mb-md-0"
                        width="50" height="50">

                    <!-- Title & Details -->
                    <div class="flex-grow-1 mb-2 mb-md-0">
                        <div class="d-flex align-items-center mb-1 flex-wrap">
                            <h6 class="mb-0 fw-semibold text-dark me-2">
                                <?= htmlspecialchars($task->task_title) ?>
                            </h6>
                            <span class="badge bg-gradient px-2 small task-type-badge">
                                <?= htmlspecialchars($task->tt_type) ?>
                            </span>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>
                            <?= htmlspecialchars($task->firstname . ' ' . $task->lastname) ?>
                            &middot;
                            <i class="far fa-clock ms-2 me-1"></i>
                            <?= date('M d, Y g:i a', strtotime($task->task_start_time)) ?>
                        </small>
                    </div>

                    <!-- Action Buttons (Teacher) -->
                    <?php
                    if ($task->task_author_id === $this->session->username): ?>
                        <div class="ms-auto">
                            <!-- Desktop Buttons -->
                            <div class="d-none d-md-flex align-items-center">
                                <?php if (count($submittedTask->result()) === 0): ?>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill me-1 task-header-btn"
                                        onclick="showEditModal(this)"
                                        title="Edit Task"
                                        task-term='<?= $task->task_term ?>'
                                        task-code='<?= $task->task_code ?>'
                                        task-title='<?= $task->task_title ?>'
                                        task-type='<?php echo $task->task_type; ?>'
                                        task-details="<?php echo htmlspecialchars($task->task_details); ?>"
                                        task-sgls='<?php echo $subjectDetails->subject_id . '-' . $basicInfo->grade_id . '-' . $basicInfo->section_id ?>'
                                        task-start-date='<?php echo date("Y-m-d", strtotime($task->task_start_time)); ?>'
                                        task-start-time="<?php echo date("H:i:s", strtotime($pd['task_start_time'])); ?>"
                                        task-end-date="<?php echo date("Y-m-d", strtotime($task->task_end_time)); ?>"
                                        task-end-time="<?php echo date("H:i:s", strtotime($task->task_end_time)); ?>"
                                        task-total-item="<?= $task->task_total_score ?>"
                                        task-attachments="<?= $task->task_attachments ?>"
                                        task-gsComponent="<?= $task->gs_component_id ?>">
                                        <i class="fa fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill me-1 task-header-btn"
                                        onclick="showDeleteModal(this, 1)"
                                        data-task-code="<?= htmlspecialchars($task->task_code) ?>">
                                        <i class="fa fa-trash me-1"></i> Delete
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-secondary rounded-pill task-header-btn"
                                    onclick="location.reload()">
                                    <i class="fas fa-sync-alt me-1"></i> Refresh
                                </button>
                            </div>

                            <!-- Mobile Dropdown -->
                            <div class="dropdown d-md-none">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle task-header-btn"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <?php if (count($submittedTask->result()) === 0): ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="showEditModal(this)"
                                                data-task-code="<?= htmlspecialchars($task->task_code) ?>"
                                                data-task-title="<?= htmlspecialchars($task->task_title) ?>"
                                                data-task-type="<?= htmlspecialchars($task->task_type) ?>"
                                                data-task-details="<?= htmlspecialchars($task->task_details) ?>">
                                                <i class="fa fa-edit me-2 text-primary"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                onclick="showDeleteModal(this, 1)"
                                                data-task-code="<?= htmlspecialchars($task->task_code) ?>">
                                                <i class="fa fa-trash me-2"></i> Delete
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a class="dropdown-item" href="javascript:location.reload()">
                                            <i class="fas fa-sync-alt me-2 text-secondary"></i> Refresh
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <?php if (!empty($task->task_attachments)): ?>
                        <div class="mb-3">
                            <a href="<?= base_url('opl/downloads/' . base64_encode($task->attachment_link . '/' . $task->task_attachments)) ?>"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-paperclip"></i> <?= htmlspecialchars($task->task_attachments) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <p class="mb-3"><?= nl2br($task->task_details) ?></p>

                    <?php if ($task->task_is_online): ?>
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold mb-2"><i class="bi bi-ui-checks"></i> Quiz Items</h6>
                            <ol class="ps-3 mb-2">
                                <?php foreach ($quizItems as $qId):
                                    $qItems = Modules::run('opl/qm/getQuestionItems', $qId);
                                    echo '<li>' . $qItems->question . '</li>';
                                endforeach; ?>
                            </ol>

                            <?php if ($this->session->isStudent): ?>
                                <?php if ($now >= $start && $now <= $end && !$iSubmitted->row()): ?>
                                    <button onclick="answer(); this.disabled = true;"
                                        class="btn btn-primary btn-sm float-end mt-2">
                                        <i class="bi bi-send"></i> Submit Quiz
                                    </button>
                                <?php elseif ($now < $start): ?>
                                    <span class="badge bg-secondary">Not Started</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Time Ended</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php if ($this->session->isStudent): ?>

            <?php if (!$iSubmitted->row()):
                $now = new DateTime();
                $start = new DateTime($task->task_start_time);
                $end = new DateTime($task->task_end_time);
                $started = $now >= $start;
                $notEnded = $now <= $end;

                if ($started && $notEnded):
            ?>
                    <div class="mb-2">
                        <!-- Button triggers modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#answerModal">
                            Answer this Task
                        </button>
                    </div>
                <?php
                elseif (!$started):
                ?>
                    <button type="button" class="btn btn-light btn-sm" disabled>Not Started</button>
                <?php
                else:
                ?>
                    <button type="button" class="btn btn-light btn-sm" disabled>Time Ended</button>
            <?php
                endif;
            endif;
            ?>

            <!-- Modal -->
            <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="answerModalLabel">Answer Task: <?php echo htmlspecialchars($task->task_title); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php $this->load->view('../students/createResponse', $task); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>


        <!-- Student Submitted Answer -->
        <?php
        if ($this->session->isStudent && $iSubmitted->row()): ?>
            <section class="<?= $col ?> mb-4">
                <div class="card card-info">
                    <div class="card-header text-center">
                        <h6>Your Answer</h6>
                        <small class="text-muted">Please ensure correct spelling.</small>
                    </div>
                    <div class="card-body">
                        <?php
                        $submission = $iSubmitted->row();
                        if ($submission->ts_submission_type == 2): // File submission 
                        ?>
                            <p>Submitted File: <a href="<?= htmlspecialchars($submission->ts_details) ?>" target="_blank"><?= htmlspecialchars($submission->ts_file_name) ?></a></p>
                        <?php elseif ($submission->ts_submission_type == 3): // Multiple choice answers 
                        ?>
                            <ol>
                                <?php
                                $answers = explode(',', $submission->ts_details);
                                foreach ($answers as $ans) {
                                    list($qid, $ansText) = explode('_', $ans);
                                    $correct = Modules::run('opl/qm/checkAnswer', $ansText, $qid, $this->session->school_year);
                                    echo '<li>' . htmlspecialchars($ansText) . ' ' . ($correct ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>') . '</li>';
                                }
                                ?>
                            </ol>
                        <?php else: // Text submission 
                        ?>
                            <p><?= $submission->ts_details ?></p>
                        <?php endif; ?>
                        <small class="text-muted d-block mt-2">Date Submitted: <?= date('F d, Y h:i a', strtotime($submission->ts_date_submitted)) ?></small>
                    </div>

                    <div class="card-footer">
                        <?= Modules::run('opl/opl_variables/getComments', $submission->ts_code, 4, $this->session->school_year) ?>

                        <!-- Comment Input -->
                        <div class="input-group mt-2">
                            <?php
                            $avatarUrl = !empty($this->session->details->avatar) && file_exists(FCPATH . 'uploads/' . $this->session->details->avatar)
                                ? base_url('uploads/' . $this->session->details->avatar)
                                : base_url('images/avatar/' . ($this->session->details->sex == 'Female' ? 'female.png' : 'male.png'));
                            ?>
                            <img src="<?= $avatarUrl ?>" alt="User Avatar" class="rounded-circle mr-2" width="40" height="40">
                            <textarea id="<?= $this->session->details->st_id ?>_textarea" class="form-control" rows="1" placeholder="Add a comment..."></textarea>
                            <div class="input-group-append">
                                <button onclick="sendComment('4', '<?= $this->session->details->st_id ?>', '<?= $submission->ts_code ?>', '<?= $this->session->details->st_id ?>', '1')" class="btn btn-primary btn-sm">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Submitted Tasks List (for task author) -->
        <?php if ($task->task_author_id === $this->session->username && isset($submittedTask) && count($submittedTask->result()) > 0): ?>
            <section class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Student Responses</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($submittedTask->result() as $sT):
                            $student = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $sT->ts_submitted_by, $this->session->school_year);
                            $isValidated = Modules::run('gradingsystem/isGradeValidated', $student->st_id, $task->task_subject_id, $task->task_term, $this->session->school_year);
                            $rawScore = Modules::run('opl/qm/getRawScore', $task->task_code, $student->st_id, $this->session->school_year);
                            $score = $rawScore ? $rawScore->raw_score : 0;
                        ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-primary">
                                        <?= $student->lastname . ', ' . $student->firstname ?>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> Submitted:
                                        <?= date('F d, Y h:i a', strtotime($sT->ts_date_submitted)) ?>
                                    </small>
                                </div>

                                <div class="d-flex align-items-center">
                                    <?php
                                    switch ($sT->ts_submission_type):
                                        case 1:
                                    ?>
                                            <button class="btn btn-outline-primary btn-sm mr-2"
                                                data-student-name="<?= htmlspecialchars($student->lastname . ', ' . $student->firstname) ?>"
                                                data-answer="<?= htmlspecialchars($sT->ts_details) ?>"
                                                onclick="showStudentResponse(this)">
                                                <i class="fas fa-eye"></i> View Answer
                                            </button>
                                            <?php
                                            break;
                                        case 2:
                                            if (!empty($sT->ts_file_name)): ?>
                                                <a href="<?= base_url('opl/downloads/' . base64_encode($sT->ts_details)) ?>"
                                                    target="_blank"
                                                    class="btn btn-outline-success btn-sm mr-2">
                                                    <i class="fas fa-file-download"></i> Download
                                                </a>
                                        <?php
                                            endif;
                                            break;
                                    endswitch;
                                    if ($sT->marking_type == 0):
                                        ?>
                                        <span id="scoreBadge-<?= $student->st_id ?>"
                                            class="badge badge-pill badge-info pointer mr-2 p-2"
                                            style="font-size: 0.85rem; cursor: pointer;" title="Click to enter score">
                                            <i class="fas fa-star"></i>
                                            <?= htmlspecialchars((string)$score) ?>/<?= htmlspecialchars($sT->task_total_score) ?>
                                        </span>

                                        <input id="scoreInput-<?= $student->st_id ?>"
                                            type="number"
                                            min="0"
                                            max="<?= htmlspecialchars($sT->task_total_score) ?>"
                                            class="form-control form-control-sm text-center"
                                            style="width: 70px; display: none;"
                                            value="<?= htmlspecialchars((string)$score) ?>"
                                            data-task-id="<?= $sT->task_code ?>"
                                            data-ts-code="<?= $sT->ts_code ?>"
                                            data-student-id="<?= $student->st_id ?>" />
                                    <?php
                                    elseif ($sT->marking_type == 2):
                                        $rubricDetails['score'] = $score;
                                        $rubricDetails['task'] = $task;
                                        $rubricDetails['school_year'] = $this->session->school_year;
                                        $rubricDetails['totalScore'] = $sT->task_total_score;
                                        $rubricDetails['rubricId'] = $sT->marking_link;
                                        $rubricDetails['student'] = $student;
                                        $rubricDetails['isQuestion'] = 0;
                                        $rubricDetails['ans_id'] = $sT->ts_code;
                                        $this->load->view('../rubric/marking', $rubricDetails);
                                    endif;
                                    ?>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif;
    else:
        ?>
        <section class="<?= $col ?> mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center text-center">
                    No Task to Display
                </div>
            </div>
        </section>
    <?php
    endif;
    ?>

</div>
<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true" aria-labelledby="editTaskModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="editTaskForm" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="modal-content shadow-lg rounded-3">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0" id="editTaskModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit Task
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <input type="hidden" name="taskCode" id="taskCode" />

                    <!-- Task Title -->
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="taskTitle" id="taskTitle" placeholder="Enter task title" required />
                        <div class="invalid-feedback">Please enter the task title.</div>
                    </div>

                    <!-- Subject / Grade / Section -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subject / Grade / Section</label>
                        <input type="text" class="form-control bg-light" name="task_subject_grade_section" id="task_subject_grade_section" readonly />
                        <input type="hidden" id="taskGrade" name="taskGrade" />
                    </div>

                    <!-- Term -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="taskTerm" class="form-label fw-semibold">Term</label>
                            <select id="taskTerm" name="taskTerm" class="form-control">
                                <option>Select Grading</option>
                                <option value="1">First Grading</option>
                                <option value="2">Second Grading</option>
                                <option value="3">Third Grading</option>
                                <option value="4">Fourth Grading</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="taskItem" class="form-label fw-semibold">Number of Items</label>
                            <input type="text" class="form-control bg-light" name="taskItem" id="taskItem" readonly />
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Link to Unit -->
                        <div class="col-md-4">
                            <label for="taskUnitLink" class="form-label fw-semibold">Link to Unit</label>
                            <select id="taskUnitLink" name="taskUnitLink" class="form-control">
                                <?php foreach ($unitDetails as $ud): ?>
                                    <option value="<?php echo $ud->ou_opl_code ?>"><?php echo $ud->ou_unit_title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="taskType" class="form-label fw-semibold">Type</label>
                            <select class="form-control" name="taskType" id="taskType" required>
                                <?php foreach ($task_type as $tt): ?>
                                    <option value="<?= $tt->tt_id ?>"><?= $tt->tt_type ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a task type.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="submissionType" class="form-label fw-semibold">Submission Type</label>
                            <select class="form-control" name="submissionType" id="submissionType" required>
                                <option value="1">Use Editor</option>
                                <option value="2">File Submission</option>
                                <option value="3">Online Quiz Form</option>
                            </select>
                            <div class="invalid-feedback">Please select a submission type.</div>
                        </div>
                    </div>
                    <!-- Task Details -->
                    <div class="mb-3 mt-3">
                        <label for="taskDetails" class="form-label fw-semibold">Details</label>
                        <textarea class="form-control" name="taskDetails" id="taskDetails" rows="6" placeholder="Enter detailed instructions..."></textarea>
                    </div>

                    <!-- File Attachment -->
                    <div class="mb-3">
                        <label for="userfile" class="form-label fw-semibold">File Attachment <small class="text-muted">(Optional)</small></label>
                        <input class="form-control" type="file" name="userfile" id="userfile" />
                        <input type="hidden" name="taskAttachment" id="taskAttachment" />
                    </div>

                    <!-- Quiz Search -->
                    <div class="mb-3 position-relative" id="quizWrapper" style="display:none;">
                        <label for="searchBox" class="form-label fw-semibold">Search A Quiz</label>
                        <input type="text" onkeyup="searchAQuiz(this.value)" id="searchBox" class="form-control" placeholder="Search Name Here" autocomplete="off" />
                        <div id="searchQuestions" class="resultOverflow list-group position-absolute w-100 shadow-sm" style="display:none; max-height: 180px; overflow-y: auto; z-index: 1055;"></div>
                        <input type="hidden" name="quiz_id" id="quiz_id" />
                    </div>

                    <!-- Date & Time -->
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="taskStartDate" class="form-label fw-semibold">Start Date</label>
                            <input type="date" class="form-control" name="taskStartDate" id="taskStartDate" />
                        </div>
                        <div class="col-md-3">
                            <label for="taskTimeStart" class="form-label fw-semibold">Start Time</label>
                            <input type="time" class="form-control" name="taskTimeStart" id="taskTimeStart" />
                        </div>
                        <div class="col-md-3">
                            <label for="taskEndDate" class="form-label fw-semibold">End Date</label>
                            <input type="date" class="form-control" name="taskEndDate" id="taskEndDate" />
                        </div>
                        <div class="col-md-3">
                            <label for="taskTimeEnd" class="form-label fw-semibold">End Time</label>
                            <input type="time" class="form-control" name="taskTimeEnd" id="taskTimeEnd" />
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-check">
                        <input id="goPublic" type="checkbox" class="form-check-input">
                        <label for="goPublic" class="form-check-label">Go Public</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Save Changes</button>
                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Delete Task Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteTaskForm" method="post" action="<?= base_url('opl/deleteTasks') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="code" id="code" />
                    <p>Are you sure you want to delete the task: <strong id="delete_task_title"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--- View Students Reponse -->
<div class="modal fade" id="studentsResponse" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h4 id="stName" class="mb-0"></h4>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" id="answerDetails" style="min-height: 200px;">
                <p class="text-muted text-center my-3">
                    <i class="spinner-border spinner-border-sm text-primary"></i> Loading response...
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
<?php
if (!$this->session->isOplAdmin && !$this->session->isParent && !$this->session->isStudent):
    echo $this->load->view('tasks/editTask');
endif;
?>

<script>
    $(function() {
        $('.textarea').summernote();

        searchAQuiz = function(value) {

            var url = "<?php echo base_url() . 'opl/qm/searchAQuiz/' ?>" + value + '/' + '<?php echo $school_year ?>';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(data) {
                    $('#searchQuestions').show();
                    $('#searchQuestions').html(data);

                }
            });
        };
    });

    function showStudentResponse(btn) {
        $('#studentsResponse').modal('show');
        $('#stName').text($(btn).data('student-name'));
        $('#answerDetails').html($(btn).data('answer')); // HTML formatting preserved
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("[id^='scoreBadge-']").forEach(function(badge) {
            const studentId = badge.id.split("-")[1];
            const input = document.getElementById("scoreInput-" + studentId);
            const maxScore = parseInt(input.getAttribute("max"), 10);
            let preventBlurSave = false;

            // Show input on badge click
            badge.addEventListener("click", function() {
                var isValidated = '<?php echo $isValidated ?>'
                if (isValidated) {
                    alert('Grade already validated!')
                } else {
                    $(badge).fadeOut(200, function() {
                        $(input).fadeIn(200).focus();
                    });
                }
            });

            function saveScore() {
                const newScore = input.value.trim() || 0;

                // Validation: block saving if exceed max
                if (parseFloat(newScore) > maxScore) {
                    preventBlurSave = true;
                    alert(`Score cannot exceed ${maxScore}`);
                    input.focus();
                    input.select();
                    return; // ❌ Stop here, no save
                }

                // ✅ Proceed with saving
                $.ajax({
                    url: "<?= base_url('opl/qm/saveRawScore') ?>",
                    method: "POST",
                    data: {
                        task_code: input.dataset.taskId,
                        st_id: input.dataset.studentId,
                        ans_id: input.dataset.tsCode,
                        score: newScore,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.status === "success") {
                            badge.innerHTML = `<i class="fas fa-star"></i> ${newScore}/${maxScore}`;
                            $(input).fadeOut(200, function() {
                                $(badge).fadeIn(200);
                            });
                        } else {
                            alert(res.message || "Error saving score.");
                            input.focus();
                            input.select();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error, xhr.responseText);
                        alert("Error saving score. Check console for details.");
                        input.focus();
                        input.select();
                    }
                });
            }

            // Blur event
            input.addEventListener("blur", function() {
                if (preventBlurSave) {
                    preventBlurSave = false;
                    return; // Skip saving if validation failed
                }
                saveScore();
            });

            // Enter key event
            input.addEventListener("keypress", function(e) {
                if (e.key === "Enter") saveScore();
            });
        });
    });



    $('#submissionType').on('change', function() {
        if ($(this).val() == 3) {
            $('#quizWrapper').show();
        } else {
            $('#quizWrapper').hide();
        }
    })

    function sendComment(commentType, userId, taskCode, commenterId, isStudent) {
        const textareaId = `${userId}_textarea`;
        const commentText = document.getElementById(textareaId).value.trim();

        if (!commentText) {
            alert('Please enter a comment.');
            return;
        }

        const btn = event?.target || null;
        if (btn) btn.disabled = true;

        // Prepare data
        const data = {
            comment_type: commentType,
            comment_by: commenterId,
            comment_ref: taskCode,
            comment_text: commentText,
            is_student: isStudent,
        };

        fetch('<?= base_url("opl/opl_variables/saveComment") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
                },
                body: JSON.stringify(data),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    // Clear textarea and refresh comments area
                    document.getElementById(textareaId).value = '';
                    // Assuming you have a container to reload comments
                    reloadComments(taskCode, commentType);
                } else {
                    alert(res.message || 'Failed to save comment.');
                }
            })
            .catch(() => alert('Error submitting comment. Please try again.'))
            .finally(() => {
                if (btn) btn.disabled = false;
            });
    }

    function reloadComments(taskCode, commentType) {
        // Replace this with your method to reload comments via AJAX
        // For example, fetch and update comment container innerHTML
        fetch(`<?= base_url("opl/opl_variables/getCommentsAjax") ?>?task_code=${taskCode}&type=${commentType}`)
            .then(res => res.text())
            .then(html => {
                document.querySelector(`#comments-container-${taskCode}`).innerHTML = html;
            });
    }

    // function showEditModal(btn) {
    //     // Assuming you use Bootstrap modals or similar
    //     const modal = document.getElementById('editTaskModal');

    //     $('#editTaskModal').modal('show');
    //     // Fill modal inputs with data attributes
    //     modal.querySelector('#taskTerm').value = btn.dataset.taskTerm;
    //     modal.querySelector('#taskItem').value = btn.dataset.taskItem;
    //     modal.querySelector('#taskCode').value = btn.dataset.taskCode;
    //     modal.querySelector('#taskTitle').value = btn.dataset.taskTitle;
    //     modal.querySelector('#taskType').value = btn.dataset.taskType;
    //     // modal.querySelector('#task_details').value = btn.dataset.taskDetails;
    //     $('#taskDetails').summernote('code', btn.dataset.taskDetails);
    //     modal.querySelector('#task_subject_grade_section').value = btn.dataset.taskSgls;
    //     modal.querySelector('#taskUnitLink').value = btn.dataset.taskUnit;
    //     modal.querySelector('#submissionType').value = btn.dataset.taskSubmissionType;
    //     modal.querySelector('#taskAttachment').value = btn.dataset.taskAttachment
    //     modal.querySelector('#taskGrade').value = btn.dataset.taskSgls_id
    //     modal.querySelector('#taskStartDate').value = btn.dataset.taskStartDate;
    //     modal.querySelector('#taskTimeStart').value = btn.dataset.taskStartTime;
    //     modal.querySelector('#taskEndDate').value = btn.dataset.taskEndDate;
    //     modal.querySelector('#taskTimeEnd').value = btn.dataset.taskEndTime;
    //     // Show modal
    // }

    function showDeleteModal(btn, confirmFlag) {
        const modal = document.getElementById('deleteTaskModal');
        $('#deleteTaskModal').modal('show');
        modal.querySelector('#code').value = btn.dataset.taskCode;
    }

    function submitAnswer() {
        let answers = [];

        $('.answerOption').each(function() {
            if ($(this).attr('qt') == '1') {
                answers.push($(this).attr('name') + '_' + $(this).val());
            } else {
                if ($(this).is(':checked')) {
                    answers.push($(this).attr('name') + '_' + $(this).val());
                }
            }
        });

        var url = $('#base').val() + 'opl/student/submitAnswer';

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                teacher: $('#teacher_id').val(),
                answers: answers.toString(),
                task_code: $('#task_code').val(),
                q_code: $('#q_code').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            beforeSend: function() {
                $('#btnSubmitAnswer').prop('disabled', true).text('Submitting...');
            },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert('Error submitting answers. Please try again.');
                $('#btnSubmitAnswer').prop('disabled', false).text('Submit Answer');
            }
        });
    }

    // Bootstrap 5 form validation (shows invalid feedback)
    (() => {
        'use strict';
        const form = document.getElementById('editTaskForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('csrf_test_name', $.cookie('csrf_cookie_name'));

            $.ajax({
                type: 'POST',
                url: '<?= base_url() . 'opl/updateTasks' ?>',
                data: formData,
                dataType: 'JSON',
                processData: false, // ⬅️ Important for FormData
                contentType: false, // ⬅️ Important for FormData
                success: function(info) {
                    alert(info.message)
                    location.reload()
                }
            })
        })

    })();

    $('#deleteTaskForm').submit(function(e) {
        e.preventDefault()
        var url = $(this).attr('action')
        const data = new FormData(this)
        data.append('csrf_test_name', $.cookie('csrf_cookie_name'))

        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function(del) {
                $('#deleteTaskModal').modal('hide');
                alert(del.message)
            }
        })
    })

    // Quiz search autocomplete
    function searchAQuiz(query) {
        const resultsDiv = document.getElementById('searchQuestions');
        if (query.length < 2) {
            resultsDiv.style.display = 'none';
            resultsDiv.innerHTML = '';
            return;
        }

        // Example AJAX request (replace with your real implementation)
        fetch('/opl/quiz/search?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (!data.length) {
                    resultsDiv.style.display = 'none';
                    resultsDiv.innerHTML = '';
                    return;
                }

                resultsDiv.innerHTML = data.map(item =>
                    `<button type="button" class="list-group-item list-group-item-action" data-id="${item.id}" onclick="selectQuiz(${item.id}, '${item.name}')">${item.name}</button>`
                ).join('');
                resultsDiv.style.display = 'block';
            }).catch(() => {
                resultsDiv.style.display = 'none';
                resultsDiv.innerHTML = '';
            });
    }

    function selectQuiz(id, name) {
        document.getElementById('quiz_id').value = id;
        document.getElementById('searchBox').value = name;
        const resultsDiv = document.getElementById('searchQuestions');
        resultsDiv.style.display = 'none';
        resultsDiv.innerHTML = '';
    }
</script>

<style>
    /* Scrollbar for the quiz search dropdown */
    .resultOverflow::-webkit-scrollbar {
        width: 8px;
    }

    .resultOverflow::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }

    /* Bootstrap list-group styling for search results */
    #searchQuestions .list-group-item {
        cursor: pointer;
    }

    #searchQuestions .list-group-item:hover,
    #searchQuestions .list-group-item.active {
        background-color: #0d6efd;
        color: white;
    }

    /* Modal styling */
    #editTaskModal .modal-content {
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border: none;
    }

    #editTaskModal .modal-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 1rem 1.5rem;
    }

    #editTaskModal .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
    }

    #editTaskModal .btn-close {
        filter: invert(1);
    }

    #editTaskModal .modal-body {
        padding: 1.5rem;
        background-color: #f8f9fa;
    }

    #editTaskModal label {
        font-weight: 500;
        margin-bottom: 0.35rem;
    }

    #editTaskModal .form-control,
    #editTaskModal .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }

    #editTaskModal .form-control:focus,
    #editTaskModal .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }

    #editTaskModal .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
        background-color: #f1f3f5;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Quiz search result styling */
    .resultOverflow {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .small-input {
        width: 75px;
        /* Fixed width on larger screens */
        max-width: 100%;
        /* Responsive shrink on small screens */
        display: inline-block;
        /* Keeps it aligned next to the badge */
        margin-left: 5px;
        /* Small gap from the badge */
    }

    /* Smooth fade and scale-in animation for modal */
    .modal.fade .modal-dialog {
        transform: scale(0.95);
        transition: transform 0.3s ease-out;
    }

    .modal.fade.show .modal-dialog {
        transform: scale(1);
    }

    /* Input focus glow */
    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        border-color: #198754;
    }

    /* Button hover effect */
    .btn-success:hover {
        background-color: #157347;
        box-shadow: 0 4px 10px rgba(21, 115, 71, 0.3);
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
    }

    /* Label styling */
    .form-label {
        transition: color 0.2s ease-in-out;
    }

    .form-control:focus+.form-label,
    .form-select:focus+.form-label {
        color: #198754;
    }

    /* Section spacing */
    .modal-body .mb-3 {
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed #e9ecef;
    }

    /* Search results styling */
    #searchQuestions {
        background: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Premium background blur */
    .modal-backdrop.show {
        backdrop-filter: blur(6px);
        background-color: rgba(0, 0, 0, 0.4) !important;
    }
</style>