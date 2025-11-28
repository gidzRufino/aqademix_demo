<div class="row" data-masonry='{"percentPosition": true }'>
    <?php
    $cnt = count($postDetails);
    foreach ($postDetails as $pd):
        $submittedTask = Modules::run('opl/opl_variables/getSubmittedTask', $pd->task_code, $this->session->school_year);

        $col = ($cnt > 1) ? 'col-lg-6 col-md-12' : 'col-12';

        if ($pd->avatar != NULL || $pd->avatar != ''):
            $path = FCPATH . 'uploads/' . $pd->avatar;
            if (file_exists($path)):
                $avatar = base_url() . 'uploads/' . $pd->avatar;
            else:
                $avatar = base_url() . 'images/avatar/' . ($pd->sex == 'Female' ? 'female.png' : 'male.png');
            endif;
        else:
            $avatar = base_url() . 'images/avatar/' . ($pd->sex == 'Female' ? 'female.png' : 'male.png');
        endif;
    ?>
        <div id="gvDetails" class="<?php echo $col ?> mb-4 fade-in">
            <div class="card shadow-sm border-0 rounded-3 hover-shadow transition h-100" id="card_<?php echo $pd->task_auto_id ?>">

                <!-- Header -->
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo $avatar; ?>" alt="User Image"
                            class="rounded-circle me-3 border border-2 border-light shadow-sm"
                            width="55" height="55">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">
                                <?php echo $pd->task_title ?>
                                <span class="badge bg-primary ms-2"><?php echo $pd->tt_type ?></span>
                            </h5>
                            <div class="d-flex flex-wrap align-items-center text-muted small">
                                <span class="me-3">
                                    <i class="fas fa-user me-1 text-secondary"></i>
                                    <span class="fw-bold text-secondary">Author:</span>
                                    <a href="#" class="fw-semibold text-decoration-none text-dark">
                                        <?php echo $pd->firstname . ' ' . $pd->lastname; ?>
                                    </a>
                                </span>
                                <span>
                                    <i class="far fa-clock me-1 text-secondary"></i>
                                    <span class="fw-bold text-secondary">Posted:</span>
                                    <?php echo date('F d, Y g:i a', strtotime($pd->task_start_time)) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if ($pd->task_author_id == $this->session->username): ?>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle"
                                onclick="window.open('<?php echo base_url('opl/printTask/' . $pd->task_code) ?>')"
                                title="Print / Export Task">
                                <i class="fas fa-file-pdf text-danger"></i>
                            </button>

                            <?php if (count($submittedTask->result()) == 0): ?>
                                <button type="button" class="btn btn-sm btn-outline-success rounded-circle"
                                    title="Edit Task"
                                    task-term='<?= $pd->task_term ?>'
                                    task-code='<?php echo $pd->task_code; ?>'
                                    task-title="<?php echo htmlspecialchars($pd->task_title); ?>"
                                    task-type='<?php echo $pd->task_type; ?>'
                                    task-details="<?php echo htmlspecialchars($pd->task_details); ?>"
                                    task-sgls='<?php echo $pd->task_subject_id . '-' . $pd->task_grade_id . '-' . $pd->task_section_id ?>'
                                    task-start-date='<?php echo date("Y-m-d", strtotime($pd->task_start_time)); ?>'
                                    task-start-time="<?php echo date("H:i:s", strtotime($pd->task_start_time)); ?>"
                                    task-end-date="<?php echo date("Y-m-d", strtotime($pd->task_end_time)); ?>"
                                    task-end-time="<?php echo date("H:i:s", strtotime($pd->task_end_time)); ?>"
                                    task-total-item="<?= $pd->task_total_score ?>"
                                    task-attachments="<?= $pd->task_attachments ?>"
                                    onclick='showEditModal(this)'>
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle"
                                    task-code='<?php echo $pd->task_code; ?>'
                                    task-title='<?php echo $pd->task_title; ?>'
                                    onclick="showDeleteModal(this)" title="Delete Task">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <?php if ($pd->task_attachments != ""): ?>
                        <div class="mb-3">
                            <span class="fw-bold text-secondary d-block mb-1">Attachment:</span>
                            <a href="<?php echo base_url('opl/downloads/' . base64_encode($pd->attachment_link . '/' . $pd->task_attachments)) ?>"
                                class="d-inline-flex align-items-center text-decoration-none bg-light rounded-pill px-3 py-1 small fw-semibold">
                                <i class="fas fa-paperclip me-2 text-primary"></i><?php echo $pd->task_attachments; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <span class="fw-bold text-secondary d-block mb-1">Details:</span>
                        <p class="mb-0 text-dark" style="line-height:1.6;">
                            <?php echo nl2br($pd->task_details); ?>
                        </p>
                    </div>

                    <?php if ($pd->task_is_online):
                        $quizDetails = Modules::run('opl/qm/getQuizDetails', $pd->task_online_link, $this->session->school_year);
                    ?>
                        <div class="bg-light p-3 rounded border">
                            <h6 class="fw-bold mb-2 d-flex align-items-center">
                                <i class="fas fa-question-circle me-2 text-primary"></i> Quiz Items
                            </h6>
                            <ol class="mb-0 ps-3 small">
                                <?php
                                $quizItems = explode(',', $quizDetails->qi_qq_ids);
                                foreach ($quizItems as $q):
                                    $qItems = Modules::run('opl/qm/getQuestionItems', $q);
                                    echo "<li>" . $qItems->question . "</li>";
                                endforeach;
                                ?>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer -->
                <?php if ($pd->task_author_id == $this->session->username): ?>
                    <div class="card-footer bg-white border-0 pt-2">
                        <small class="text-muted"
                            data-bs-toggle="popover"
                            data-bs-placement="right"
                            data-bs-html="true"
                            data-bs-content="<?php
                                                $data['submittedTask'] = $submittedTask->result();
                                                $data['totalStudents'] = count($submittedTask->result());
                                                $this->load->view('submittedTask', $data);
                                                ?>">
                            <i class="fas fa-users me-1 text-secondary"></i>
                            <span class="fw-bold text-secondary">Submitted by:</span>
                            <strong><?php echo count($submittedTask->result()) ?></strong> student(s)
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Masonry JS -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.7rem 1.5rem rgba(0, 0, 0, .15) !important;
        transform: translateY(-3px);
        transition: all 0.3s ease-in-out;
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    /* Fade-in animation for cards */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Delay animations slightly for a staggered effect
    document.querySelectorAll('.fade-in').forEach((el, i) => {
        el.style.animationDelay = (i * 0.1) + 's';
    });
</script>